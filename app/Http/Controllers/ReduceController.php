<?php

namespace App\Http\Controllers;

use App\Models\Reduce;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\ReduceResource;
use App\Http\Requests\GetReduceRequest;
use App\Http\Requests\ShowReduceRequest;
use App\Http\Requests\CreateReduceRequest;
use App\Http\Requests\DeleteReduceRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ReduceController extends Controller {
    // Read
    public function index(GetReduceRequest $request): AnonymousResourceCollection {
        $query = Reduce::query();

        if ($request->filled('order_id')) {
            $query->where('order_id', $request->input('order_id'));
        }

        if ($request->filled('discount_id')) {
            $query->where('discount_id', $request->input('discount_id'));
        }

        $reduces = $query->paginate(50);
        $reduces->appends($request->all());

        return ReduceResource::collection($reduces);
    }

    public function show(ShowReduceRequest $request, Reduce $reduce): ReduceResource {
        return new ReduceResource($reduce);
    }

    // Create
    public function store(CreateReduceRequest $request): JsonResponse {
        $validatedData = $request->validated();
        
        $reduce = Reduce::create($validatedData);

        return (new ReduceResource($reduce))
            ->additional(['message' => 'Réduction crée avec succès.'])
            ->response()
            ->setStatusCode(201);
    }

    // Delete
    public function destroy(DeleteReduceRequest $request, Reduce $reduce): JsonResponse {
        $reduce->delete();

        return response()->json([
            'message' => 'Réduction retirée avec succès.'
        ], 200);
    }
}