<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Event\EventRequest;
use App\Http\Requests\Event\EventUpdateRequest;
use App\Http\Resources\EventCollection;
use App\Http\Resources\EventResource;
use App\Http\Resources\UserEventsCollection;
use App\Http\Resources\UserResource;
use App\Models\Event;
use App\Repository\Event\EventRepository;
use App\Repository\User\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EventController extends Controller
{
    /**
     * @var EventRepository
     */
    protected $eventRepo;

    /**
     * @var UserRepository
     */
    private $userRepo;

    public function __construct(EventRepository $eventRepository, UserRepository $userRepository)
    {
        $this->eventRepo = $eventRepository;
        $this->userRepo = $userRepository;
    }

    /**
     * Display a listing of the events.
     *
     * @param Request $request
     * @return EventCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Event::class);
        $events = $this->eventRepo->index();
        return Response::success(new EventCollection($events));
    }

    /**
     * Display a listing of the user events.
     *
     * @param Request $request
     * @return mixed
     */
    public function userEvents(Request $request)
    {
        $user = $request->user();
        $events = $this->eventRepo->events($user->id);
        return Response::success(['events' => new UserEventsCollection($events), 'user' => new UserResource($user)]);
    }

    /**
     * Display the specified event.
     *
     * @param Event $event
     * @return EventResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Event $event)
    {
        $this->authorize('view', $event);
        $event = $this->eventRepo->show($event->id);
        return Response::success(new EventResource($event));
    }

    /**
     * Store a newly event for a user.
     *
     * @param EventRequest $request
     * @return EventResource
     */
    public function store(EventRequest $request)
    {
        $event = $this->eventRepo->store($request->merge(['user_id' => $request->user()->id])->all());
        return Response::created(new EventResource($event));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param EventRequest $request
     * @param Event $event
     * @return EventResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(EventRequest $request, Event $event)
    {
        $this->authorize('update', $event);
        $event = $this->eventRepo->update($request->all(), $event->id);
        return Response::success(new EventResource($event));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Event $event
     * @return Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Event $event)
    {
        $this->authorize('delete', $event);
        $this->eventRepo->destroy($event->id);
        return Response::withoutData('event deleted successfully');
    }
}
