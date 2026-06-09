<?php

namespace App\Http\Controllers;

use App\Models\Producer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\ProducerResource;
use App\Http\Requests\PutProducerRequest;
use App\Http\Requests\PatchProducerRequest;
use App\Http\Requests\DeleteProducerRequest;
use App\Http\Requests\CreateProducerRequest;
use Illuminate\Contracts\Support\ValidatedData;

class ProducerController extends Controller {

    public function index() {
        return $this->getAll();
    }

    // CREATE
    public function createProducer(CreateProducerRequest $request) {
        $validatedData = $request->validated();

        $validatedData['user_id'] = $validatedData['user_id'] ?? auth('api')->id();
        
        $producer = Producer::create($validatedData);

        return (new ProducerResource($producer))->additional([
            'message' => 'producteur créé avec succès'
        ], 201);
    }

    // READ
    public function getAll() {
        Gate::authorize('viewAny', Producer::class);

        $producers = Producer::paginate(50);
        return ProducerResource::collection($producers);
    }

    public function getProducerById(Producer $producer) {
        Gate::Authorize('view', $producer);

        return new ProducerResource($producer);
    }

    public function getProducerByName($name) {
        $producerModel = Producer::where('name', $name)->firstOrFail();

        Gate::authorize('view', $producerModel);

        return new ProducerResource($producerModel);
    }

    public function getProducerByCity($city) {
        $cityModel = Producer::where('city', $city)->get();

        Gate::authorize('viewAny', $cityModel);

        return ProducerResource::collection($cityModel);
    }

    public function getProducerByPostal_code($postal_code) {
        $postal_codeModel = Producer::where('postal_code', $postal_code)->get();

        Gate::authorize('viewAny', $postal_codeModel);

        return ProducerResource::collection($postal_codeModel);
    }

    // UPDATE: put branch
    public function putProducer(PutProducerRequest $request, Producer $producer) {
        $validatedData = $request->validated();

        Gate::authorize('update', $producer);

        $producer->update($validatedData);

        return(new ProducerResource($producer))->additional([
            'message' => 'Producteur mis à jour avec succès'
        ]);
    }
    
    // UPDATE: patch branch
    public function patchProducer(PatchProducerRequest $request, Producer $producer) {
        $validatedData = $request->validated();

        Gate::authorize('update', $producer);

        $producer->update($validatedData);

        return(new ProducerResource($producer))->additional([
            'message' => 'Producteur mis à jour avec succès'
        ]);
    }

    // DELETE
    public function deleteProducer(DeleteProducerRequest $request, Producer $producer) {
        $validatedAciton = $request->validated();

        Gate::authorize('delete', $producer);

        $producer->delete($validatedAciton);

        return response()->json([
            'message' => 'Producteur supprimer avec succès'
        ], 200);
    }
}
