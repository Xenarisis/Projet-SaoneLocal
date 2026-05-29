<?php

namespace App\Http\Controllers;

use App\Models\Reduce;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\DeleteReduceRequest;
use App\Http\Requests\CreateReduceRequest;
use App\Http\Controllers\ReduceResource;

class ReduceController extends Controller
{
    public function index() {
        return $this->getAll();
    }

    // CREATE
    public function createReduce(CreateReduceRequest $request) {
        $validatedData = $request->validated();
        
        $reduce = Reduce::create($validatedData);

        return (new ReduceResource($reduce))->additional([
            'message' => 'reduce créé avec succès'
        ], 201);
    }

    // READ
    public function getAll() {
        Gate::authorize('viewAny', Reduce::class);

        $Reduces = Reduce::paginate(50);
        return ReduceResource::collection($Reduces);
    }

    public function getReduceByID($Reduce) {
        Gate::authorize('view', $Reduce);

        return new ReduceResource($Reduce);
    }

    // DELETE
    public function deleteReduce(DeleteReduceRequest $request, Reduce $Reduce) {
        $validatedAciton = $request->validated();

        Gate::authorize('delete', $Reduce);

        $Reduce->delete($validatedAciton);

        return response()->json([
            'message' => 'Reduce supprimer avec succès'
        ], 201);
    }
}
