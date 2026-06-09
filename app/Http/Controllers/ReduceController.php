<?php

namespace App\Http\Controllers;

use App\Models\Reduce;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\DeleteReduceRequest;
use App\Http\Requests\CreateReduceRequest;
use App\Http\Resources\ReduceResource;

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

        $reduces = Reduce::paginate(50);
        return ReduceResource::collection($reduces);
    }

    public function getReduceByID($reduce) {
        Gate::authorize('view', $reduce);

        return new ReduceResource($reduce);
    }

    // DELETE
    public function deleteReduce(DeleteReduceRequest $request, Reduce $reduce) {
        $validatedAciton = $request->validated();

        // Gate::authorize('delete', $reduce); //! optional because request make the validation

        $reduce->delete($validatedAciton);

        return response()->json([
            'message' => 'Reduce supprimer avec succès'
        ], 201);
    }
}
