<?php

namespace App\Http\Api;

use App\Http\Resources\FormResource;
use App\Models\Form;
use App\Repositories\FormBuilderRepository;
use Illuminate\Http\Request;

class FormBuilderApi extends BaseApi
{

    /**
     * FormBuilderApi constructor.
     * @param FormBuilderRepository $repository
     */
    public function __construct(FormBuilderRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function create(Request $request)
    {
        $formData = array_get($request->all(), 'data', null);
        if (!$formData) {
            return response('Wrong', 403);
        }

        $formData = array_get($request->all(),'data', []);

        $form = $this->repository->createNewForm($formData);

        if ($form instanceof Form) {
            return response()->json(['status' => true, 'form_id' => $form->id]);
        } else {
            return response()->json(['status' => false, 'error' => 'Cannot create the form']);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function update(Request $request)
    {
        $data = $request->all();

        $id = array_get($data, 'data.id', null);

        if (!$id || !Form::find($id)) {
            if (env('APP_ENV') !== 'local') {
                Bugsnag::notifyError('FormBuilderApi', 'Cannot find the form: ' . array_get($data, 'data.id', null));
            }
            throw new \Exception('Cannot find the form: ' . array_get($data, 'data.id', null));
        }

        $form = $this->repository->updateForm($id, array_get($data, 'data', []));

        if ($form instanceof Form) {
            return response()->json(['status' => true, 'form_id' => $form->id]);
        } else {
            return response()->json(['status' => false, 'error' => 'Cannot create the form']);
        }
    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function show()
    {
        return FormResource::collection(Form::orderBy('created_at', 'desc')->get());
    }

    /**
     * @return FormResource
     * @throws \Exception
     */
    public function showSingleForm()
    {
        $id = request('id');

        if (!$id) {
            throw new \Exception('Cannot get form id');
        }

        $form = Form::find($id);
        if (!$form) {
            throw new \Exception('Cannot find the form');
        }

        return new FormResource($form);
    }
}
