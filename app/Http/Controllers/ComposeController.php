<?php

namespace App\Http\Controllers;

use App\Models\Compose;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\ComposeResource;
use App\Http\Requests\GetComposeRequest;
use App\Http\Requests\PutComposeRequest;
use App\Http\Requests\ShowComposeRequest;
use App\Http\Requests\PatchComposeRequest;
use App\Http\Requests\CreateComposeRequest;
use App\Http\Requests\DeleteComposeRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ComposeController extends Controller {
    // Read
    public function index(GetComposeRequest $request): AnonymousResourceCollection {
        $query = Compose::query();

        $exactFilters = ['id', 'order_id', 'product_id'];

        foreach ($exactFilters as $filter) {
            if ($request->filled($filter)) {
                $query->where($filter, $request->input($filter));
            }
        }

        $composes = $query->paginate(50);
        $composes->appends($request->all());

        return ComposeResource::collection($composes);
    }

    public function show(ShowComposeRequest $request, Compose $compose): ComposeResource {
        return new ComposeResource($compose);
    }

    // Create
    public function store(CreateComposeRequest $request): JsonResponse {
        $validatedData = $request->validated();
        
        $compose = Compose::create($validatedData);

        return (new ComposeResource($compose))
            ->additional(['message' => 'Compose created successfully.'])
            ->response()
            ->setStatusCode(201);
    }

    // Update : Put 
    public function updatePut(PutComposeRequest $request, Compose $compose): ComposeResource {
        $validatedData = $request->validated();

        $compose->update($validatedData);

        return (new ComposeResource($compose))
            ->additional(['message' => 'Compose updated successfully.']);
    }

    // Update : Patch
    public function updatePatch(PatchComposeRequest $request, Compose $compose): ComposeResource {
        $validatedData = $request->validated();

        $compose->update($validatedData);

        return (new ComposeResource($compose))
            ->additional(['message' => 'Compose updated successfully.']);
    }

    // Delete
    public function destroy(DeleteComposeRequest $request, Compose $compose): JsonResponse {
        $compose->delete();

        return response()->json([
            'message' => 'Compose deleted successfully.'
        ], 200);
    }
}