<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Resources\EventResource;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\CreateEventRequest;
use App\Http\Requests\PutEventRequest;
use App\Http\Requests\PatchEventRequest;
use App\Http\Requests\DeleteEventRequest;

class EventController extends Controller
{
    public function index() {
        return $this->getAll();
    }

    // CREATE
    public function createEvent(CreateEventRequest $request) {
        $validatedData = $request->validated();
        
        $Event = Event::create($validatedData);

        return (new EventResource($Event))->additional([
            'message' => 'Event créé avec succès'
        ], 201);
    }

    // READ
    public function getAll() {
        Gate::authorize('viewAny', Event::class);

        $Events = Event::paginate(50);
        return EventResource::collection($Events);
    }

    public function getEventByID(Event $event) {
        Gate::authorize('view', $event);

        return new EventResource($event);
    }

    public function getEventByName($name) {
        $EventModel = Event::where('event_name', $name)->firstOrFail();
        Gate::authorize('view', $EventModel);

        return new EventResource($EventModel);
    }

    public function getEventByDate($date) {
        $EventModel = Event::where('event_date', $date);
        Gate::authorize('view', $EventModel);

        return new EventResource($EventModel);
    }

    public function getProducerByCity($city) {
        $CityModel = Event::where('city', $city);
        Gate::authorize('view', $CityModel);

        return new EventResource($CityModel);
    }

    public function getProducerByPostal_code($Postal_code) {
        $Postal_codeModel = Event::where('postal_code', $Postal_code);
        Gate::authorize('view', $Postal_codeModel);

        return new EventResource($Postal_codeModel);
    }

    // UPDATE: put branch
    public function putEvent(PutEventRequest $request, Event $Event) {
        $validatedData = $request->validated();

        Gate::authorize('update', $Event);

        $Event->update($validatedData);

        return(new EventResource($Event))->additional([
            'message' => 'event mis à jour avec succès'
        ]);
    }
    
    // UPDATE: patch branch
    public function patchEvent(PatchEventRequest $request, Event $Event) {
        $validatedData = $request->validated();

        Gate::authorize('update', $Event);

        $Event->update($validatedData);

        return(new EventResource($Event))->additional([
            'message' => 'event mis à jour avec succès'
        ]);
    }

    // DELETE
    public function deleteEvent(DeleteEventRequest $request, Event $Event) {
        $validatedAciton = $request->validated();

        Gate::authorize('delete', $Event);

        $Event->delete($validatedAciton);

        return response()->json([
            'message' => 'Event supprimer avec succès'
        ], 200);
    }
}
