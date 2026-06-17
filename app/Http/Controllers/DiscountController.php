<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\DiscountResource;
use App\Http\Requests\GetDiscountRequest;
use App\Http\Requests\PutDiscountRequest;
use App\Http\Requests\ShowDiscountRequest;
use App\Http\Requests\PatchDiscountRequest;
use App\Http\Requests\CreateDiscountRequest;
use App\Http\Requests\DeleteDiscountRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class DiscountController extends Controller {
    // Read
    public function index(GetDiscountRequest $request): AnonymousResourceCollection {
        $query = Discount::query();

        if ($request->filled('discount_percent')) {
            $query->where('discount_percent', $request->input('discount_percent'));
        }

        if ($request->filled('code_name')) {
            $query->where('code_name', 'LIKE', '%' . $request->input('code_name') . '%');
        }

        if ($request->filled('availibility')) {
            $query->where('availibility', $request->input('availibility'));
        }
        
        if ($request->filled('max_use')) {
            $query->where('max_use', $request->input('max_use'));
        }

        $discounts = $query->paginate(25);
        $discounts->appends($request->all());

        return DiscountResource::collection($discounts);
    }
    
    public function show(ShowDiscountRequest $request, Discount $discount): DiscountResource {
        return new DiscountResource($discount);
    }

    // Create
    public function store(CreateDiscountRequest $request): JsonResponse {
        $validatedData = $request->validated();

        $discount = Discount::create($validatedData);

        return (new DiscountResource($discount))
            ->additional(['message' => 'Réduction créée avec succès.'])
            ->response()
            ->setStatusCode(201);
    }

    // Update : Put
    public function updatePut(PutDiscountRequest $request, Discount $discount): DiscountResource {
        $validatedData = $request->validated();

        $discount->update($validatedData);

        return (new DiscountResource($discount))
            ->additional(['message' => 'Réduction mise à jour avec succès.']);
    }

    // Update : Patch
    public function updatePatch(PatchDiscountRequest $request, Discount $discount): DiscountResource {
        $validatedData = $request->validated();

        $discount->update($validatedData);

        return (new DiscountResource($discount))
            ->additional(['message' => 'Réduction mise à jour avec succès.']);
    }

    // Delete
    public function destroy(DeleteDiscountRequest $request, Discount $discount): JsonResponse {
        $discount->delete();

        return response()->json([
            'message' => 'Réduction supprimée avec succès.'
        ], 200);
    }
}