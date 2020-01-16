<?php

namespace App\Http\Controllers;

use App\Components\Core\Result;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * UserController constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $results = $this->userRepository->listUsers(request()->all());

        return $this->sendResponse(
            $results->getMessage(),
            $results->getData()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = validator($request->all(),[
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8',
            'permissions' => 'array',
            'groups' => 'array',
        ]);

        if($validate->fails())
        {
            return $this->sendResponse(
                $validate->errors()->first(),
                null,
                400
            );
        }

        $results = $this->userRepository->create($request->all());

        return $this->sendResponse(
            $results->getMessage(),
            $results->getData()
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $results = $this->userRepository->get($id);

        return $this->sendResponse(
            $results->getMessage(),
            $results->getData()
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validate = validator($request->all(),[
            'name' => 'required',
            'email' => 'required|email',
            'permissions' => 'array',
            'groups' => 'array',
        ]);

        if($validate->fails())
        {
            return $this->sendResponse(
                $validate->errors()->first(),
                null,
                400
            );
        }

        $results = $this->userRepository->update($id,$request->all());

        return $this->sendResponse(
            $results->getMessage(),
            $results->getData()
        );
    }

    public function me(Request $request)
    {
        return Auth::user();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // do not delete self
        if($id==Auth::user()->id)
        {
            return $this->sendResponse(
                Result::MESSAGE_FORBIDDEN,
                null,
                403
            );
        }

        $results = $this->userRepository->delete($id);

        return $this->sendResponse(
            $results->getMessage(),
            $results->getData(),
            $results->getStatusCode()
        );
    }
}