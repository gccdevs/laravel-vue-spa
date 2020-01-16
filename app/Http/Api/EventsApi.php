<?php

namespace App\Http\Api;

use App\Models\Event;
use App\Repositories\EventsRepository;
use Illuminate\Http\Request;
use App\Http\Resources\FormResource;
use App\Models\Form;

class EventsApi extends BaseApi
{

    /**
     * EventsRepository constructor.
     * @param EventsRepository $repository
     */
    public function __construct(EventsRepository $repository)
    {
        $this->repository = $repository;
    }

    public function show()
    {
    	$event = request('event');

    	if ($form = Form::find($event)) {
    		return new FormResource($form);
    	} else if ($form = Form::where('form_name', $event)->first()) {
    		return new FormResource($form);
    	} else {
            return response('Not Found', 403);
    	}
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function submit(Request $request)
    {
        $event = $this->repository->createNewEvent($request->all());

        if ($event instanceof Event) {
            return response()->json(['status' => true, 'event_id' => $event->id]);
        } else {
            return response()->json(['status' => false, 'error' => 'Cannot create the form']);
        }
    }

    public function FundraisingCharge(Request $request)
    {
        dd($request->all());
    }
}
