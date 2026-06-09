<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Http\Resources\EventResource;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\CreateEventRequest;
use App\Http\Requests\PutEventRequest;
use App\Http\Requests\PatchEventRequest;
use App\Http\Requests\DeleteEventRequest;

class EventController extends Controller {
    public function index() {
        return $this->getAll();
    }

    // CREATE
    public function createEvent(CreateEventRequest $request) {
        $validatedData = $request->validated();
        
        $producerIds = Arr::pull($validatedData, 'producer_ids', []);

        $event = Event::create($validatedData);

        if (!empty($producerIds)) {
            $event->producers()->sync($producerIds);
        }

        $event->load('producers');

        return (new EventResource($event))->additional(['message' => 'Événnement créé avec succès'])->response()->setStatusCode(201);
    }

    // READ
    public function getAll() {
        Gate::authorize('viewAny', Event::class);

        $events = Event::paginate(50);
        return EventResource::collection($events);
    }

    public function getEventByID(Event $event) {
        Gate::authorize('view', $event);

        return new EventResource($event);
    }

    public function getEventByName($name) {
        $eventModel = Event::where('event_name', $name)->firstOrFail();
        Gate::authorize('view', $eventModel);

        return new EventResource($eventModel);
    }

    public function getEventByDate($date) {
        $eventModel = Event::where('event_date', $date);
        Gate::authorize('view', $eventModel);

        return new EventResource($eventModel);
    }

    public function getProducerByCity($city) {
        $cityModel = Event::where('city', $city);
        Gate::authorize('view', $cityModel);

        return new EventResource($cityModel);
    }

    public function getProducerByPostal_code($postal_code) {
        $postal_codeModel = Event::where('postal_code', $postal_code);
        Gate::authorize('view', $postal_codeModel);

        return new EventResource($postal_codeModel);
    }

    // UPDATE: put branch
    public function putEvent(PutEventRequest $request, Event $event) {
        $validatedData = $request->validated();

        Gate::authorize('update', $event);

        $event->update($validatedData);

        return(new EventResource($event))->additional([
            'message' => 'Événnement mis à jour avec succès'
        ]);
    }
    
    // UPDATE: patch branch
    public function patchEvent(PatchEventRequest $request, Event $event) {
        $validatedData = $request->validated();

        Gate::authorize('update', $event);

        $event->update($validatedData);

        return(new EventResource($event))->additional([
            'message' => 'Événnement mis à jour avec succès'
        ]);
    }

    // DELETE
    public function deleteEvent(DeleteEventRequest $request, Event $event) {
        $validatedAciton = $request->validated();

        Gate::authorize('delete', $event);

        $event->delete($validatedAciton);

        return response()->json([
            'message' => 'Événnement supprimer avec succès'
        ], 200);
    }
}
