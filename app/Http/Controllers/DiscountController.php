<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use Illuminate\Http\Request;
use App\Http\Resources\DiscountResource;
use App\Http\Requests\CreateDiscountRequest;
use App\Http\Requests\UpdateDiscountRequest;
use App\Http\Requests\DeleteDiscountRequest;

class DiscountController extends Controller {
    // Read
    public function getAll(Request $request) {
        $query = Discount::query();

        if ($request->has('discount_percent')) {
            $query->where('discount_percent', $request->discount_percent);
        }

        if ($request->has('code_name')) {
            $query->where('code_name', 'LIKE', '%' . $request->code_name . '%');
        }

        if ($request->has('availibility')) {
            $query->where('availibility', $request->availibility);
        }
        
        if ($request->has('max_use')) {
            $query->where('max_use', $request->max_use);
        }

        $discounts = $query->paginate(25);

        return DiscountResource::collection($discounts);
    }

    public function getDiscountById(Discount $discount) {
        return new DiscountResource($discount);
    }

    public function getDiscountByCodeName(string $code_name) {
        $discount = Discount::where('code_name', $code_name)->firstOrFail();
        return new DiscountResource($discount);
    }

    // Create
    public function createDiscount(CreateDiscountRequest $request) {
        $validatedData = $request->validated();

        $discount = Discount::create($validatedData);

        return (new DiscountResource($discount))->additional([
            'message' => 'Réduction créée avec succès.'
        ]);
    }

    // Put
    public function putDiscount(UpdateDiscountRequest $request, Discount $discount) {
        $validatedData = $request->validated();

        $discount->update($validatedData);

        return (new DiscountResource($discount))->additional([
            'message' => 'Réduction mise à jour avec succès.'
        ]);
    }

    // Patch
    public function patchDiscount(UpdateDiscountRequest $request, Discount $discount) {
        $validatedData = $request->validated();

        $discount->update($validatedData);

        return (new DiscountResource($discount))->additional([
            'message' => 'Réduction mise à jour avec succès.'
        ]);
    }

    // Delete
    public function deleteDiscount(DeleteDiscountRequest $request, Discount $discount) {
        $discount->delete();

        return response()->json([
            'message' => 'Réduction supprimée avec succès.'
        ], 200);
    }
}
