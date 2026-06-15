<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\EventResource;
use App\Http\Requests\GetEventRequest;
use App\Http\Requests\PutEventRequest;
use App\Http\Requests\ShowEventRequest;
use App\Http\Requests\PatchEventRequest;
use App\Http\Requests\DeleteEventRequest;
use App\Http\Requests\CreateEventRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class EventController extends Controller {
    // Read
    public function index(GetEventRequest $request): AnonymousResourceCollection {
        $query = Event::with('producers');

        if ($request->filled('event_name')) {
            $query->where('event_name', 'LIKE', '%' . $request->input('event_name') . '%');
        }

        if ($request->filled('event_date')) {
            $query->whereDate('event_date', $request->input('event_date'));
        }

        if ($request->filled('city')) {
            $query->where('city', $request->input('city'));
        }

        if ($request->filled('postal_code')) {
            $query->where('postal_code', $request->input('postal_code'));
        }

        $events = $query->paginate(50);
        $events->appends($request->all());

        return EventResource::collection($events);
    }

    public function show(ShowEventRequest $request, Event $event): EventResource {
        return new EventResource($event->load('producers'));
    }

    // Create
    public function store(CreateEventRequest $request): JsonResponse {
        $validatedData = $request->validated();
        $producerIds = Arr::pull($validatedData, 'producer_ids', []);

        $event = Event::create($validatedData);

        if (!empty($producerIds)) {
            $event->producers()->sync($producerIds);
        }

        $event->load('producers');

        return (new EventResource($event))
            ->additional(['message' => 'Événement créé avec succès.'])
            ->response()
            ->setStatusCode(201);
    }

    // Update : Put
    public function updatePut(PutEventRequest $request, Event $event): EventResource {
        $validatedData = $request->validated();
        $producerIds = Arr::pull($validatedData, 'producer_ids', null);

        $event->update($validatedData);

        if ($producerIds !== null) {
            $event->producers()->sync($producerIds);
            $event->load('producers');
        }

        return (new EventResource($event))
            ->additional(['message' => 'Événement mis à jour avec succès.']);
    }
    
    // Update : Patch
    public function updatePatch(PatchEventRequest $request, Event $event): EventResource {
        $validatedData = $request->validated();
        $producerIds = Arr::pull($validatedData, 'producer_ids', null);

        $event->update($validatedData);

        if ($producerIds !== null) {
            $event->producers()->sync($producerIds);
            $event->load('producers');
        }

        return (new EventResource($event))
            ->additional(['message' => 'Événement mis à jour avec succès.']);
    }

    // Delete
    public function destroy(DeleteEventRequest $request, Event $event): JsonResponse {
        $event->delete();

        return response()->json([
            'message' => 'Événement supprimé avec succès.'
        ], 200);
    }
}