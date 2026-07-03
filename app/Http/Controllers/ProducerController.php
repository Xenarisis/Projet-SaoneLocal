<?php

namespace App\Http\Controllers;

use App\Models\Producer;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\ProducerResource;
use App\Http\Requests\GetProducerRequest;
use App\Http\Requests\PutProducerRequest;
use App\Http\Requests\ShowProducerRequest;
use App\Http\Requests\PatchProducerRequest;
use App\Http\Requests\DeleteProducerRequest;
use App\Http\Requests\CreateProducerRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProducerController extends Controller {
    // Read
    public function index(GetProducerRequest $request): AnonymousResourceCollection {
        $query = Producer::query();

        $exactFilters = ['id', 'city', 'postal_code'];
        
        foreach ($exactFilters as $filter) {
            if ($request->filled($filter)) {
                $query->where($filter, $request->input($filter));
            }
        }

        if ($request->filled('name')) {
            $query->where('name', 'LIKE', '%' . $request->input('name') . '%');
        }

        $producers = $query->paginate(50);
        $producers->appends($request->all());

        return ProducerResource::collection($producers);
    }

    public function show(ShowProducerRequest $request, Producer $producer): ProducerResource {
        return new ProducerResource($producer);
    }

    // Create
    public function store(CreateProducerRequest $request): JsonResponse {
        $validatedData = $request->validated();

        $validatedData['user_id'] = $validatedData['user_id'] ?? $request->user()->id;
        
        $producer = Producer::updateOrCreate(
            ['user_id' => $validatedData['user_id']],
            $validatedData
        );

        if ($producer->user && $producer->user->role !== 'producer') {
            $producer->user->update(['role' => 'producer']);
        }

        return (new ProducerResource($producer))
            ->additional(['message' => 'Producteur créé avec succès.'])
            ->response()
            ->setStatusCode(201);
    }

    // Update : Put
    public function updatePut(PutProducerRequest $request, Producer $producer): ProducerResource {
        $validatedData = $request->validated();

        $producer->update($validatedData);

        return (new ProducerResource($producer))->additional([
            'message' => 'Producteur mis à jour avec succès.'
        ]);
    }

    // Update : Patch
    public function updatePatch(PatchProducerRequest $request, Producer $producer): ProducerResource {
        $validatedData = $request->validated();

        $producer->update($validatedData);

        return (new ProducerResource($producer))->additional([
            'message' => 'Producteur mis à jour avec succès.'
        ]);
    }

    // Delete
    public function destroy(DeleteProducerRequest $request, Producer $producer): JsonResponse {
        $producer->delete();

        return response()->json([
            'message' => 'Producteur supprimé avec succès.'
        ], 200);
    }
}