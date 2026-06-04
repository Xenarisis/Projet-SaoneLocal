<?php

namespace App\Http\Controllers;

use App\Models\Compose;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\ComposeResource;
use App\Http\Controllers\CreateComposeRequest;
use App\Http\Request\PutComposeRequest;
use App\Http\Request\PatchComposeRequest;
use App\Http\Request\DeleteComposeRequest;

class ComposeController extends Controller
{
    public function index() {
        return $this->getAll();
    }

    //CREATE
    public function createCompose(CreateComposeRequest $request) {
        $validatedData = $request->validated();
        
        $compose = Compose::create($validatedData);

        return (new ComposeResource($compose))->additional([
            'message' => 'Compose créé avec succès'
        ], 201);
    }

    //READ
    public function getAll() {
        Gate::authorize('viewAny', Compose::class);

        $Compose = Compose::paginate(50);
        return ComposeResource::collection($Compose);
    }

    public function getComposeByID(Compose $compose) {
        Gate::authorize('view', $compose);

        return new ComposeResource($compose);
    }

    //UPDATE: put branch 
    public function putCompose(PutComposeRequest $request, Compose $compose) {
        $validatedAciton = $request->validated();

        Gate::authorize('update', $compose);

        $compose->update($validatedAciton);

        return response()->json([
            'message' => 'Compose update avec succès'
        ], 200);
    }

    //UPDATE: patch branch
    public function patchCompose(PatchComposeRequest $request, Compose $compose) {
        $validatedAciton = $request->validated();

        Gate::authorize('update', $compose);

        $compose->update($validatedAciton);

        return response()->json([
            'message' => 'Compose update avec succès'
        ], 200);
    }

    //DELETE
    public function deleteCompose(DeleteComposeRequest $request, Compose $compose) {
        $validatedAciton = $request->validated();

        Gate::authorize('delete', $compose);

        $compose->delete($validatedAciton);

        return response()->json([
            'message' => 'Compose supprimer avec succès'
        ], 200);

    }
}
