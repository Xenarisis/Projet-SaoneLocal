<?php

namespace App\Http\Controllers;

use App\Models\Producer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\ProducerResource;
use App\Http\Requests\PutProducerRequest;
use App\Http\Controllers\PatchProducerRequest;
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

    public function getProducerById($Producer) {
        Gate::Authorize('view', $Producer);

        return new ProducerResource($Producer);
    }

    public function getProducerByName($name) {
        $ProducerModel = Producer::where('name', $name)->firstOrFail();
        Gate::authorize('view', $ProducerModel);

        return new ProducerResource($ProducerModel);
    }

    public function getProducerByCity($city) {
        $CityModel = Producer::where('city', $city);
        Gate::authorize('view', $CityModel);

        return new ProducerResource($CityModel);
    }

    public function getProducerByPostal_code($Postal_code) {
        $Postal_codeModel = Producer::where('postal_code', $Postal_code);
        Gate::authorize('view', $Postal_codeModel);

        return new ProducerResource($Postal_codeModel);
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
