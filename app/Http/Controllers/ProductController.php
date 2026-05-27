<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;
use App\Http\Requests\DeleteProductRequest;
use App\Http\Requests\RegisterProductRequest;

class ProductController extends Controller {
    // Read
    public function get(Request $request) {
        $query = Product::with('producer');

        $exactFilters = ['id', 'quantity', 'category', 'subcategory', 'producer_id'];
        foreach ($exactFilters as $filter) {
            if ($request->has($filter)) {
                $query->where($filter, $request->$filter);
            }
        }

        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        
        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        if ($request->has('name')) {
            $query->where('name', 'LIKE', '%' . $request->name . '%');
        }

        if ($request->has('description')) {
            $query->where('description', 'LIKE', '%' . $request->description . '%');
        }

        if ($request->has('producer_name')) {
            $query->whereHas('producer', function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->producer_name . '%');
            });
        }

        $products = $query->paginate(25);

        return ProductResource::collection($products);
    }

    public function getProductById(Product $product) {
        return new ProductResource($product->load('producer'));
    }

    // Create
    public function createProduct(RegisterProductRequest $request) {
        $validatedData = $request->validated();

        $user = auth('api')->user();

        $validatedData['producer_id'] = $user->producer->id;

        $product = Product::create($validatedData);

        return (new ProductResource($product))->additional([
            'message' => 'Produit créé avec succès.'
        ]);
    }

    // Put
    public function putProduct(PutProductRequest $request, Product $product) {
        $validatedData = $request->validated();

        $product->update($validatedData);

        return (new ProductResource($product))->additional([
            'message' => 'Produit mis à jour avec succès.'
        ]);
    }

    // Patch
    public function patchProduct(PatchProducerRequest $request, Product $product) {
        $validatedData = $request->validated();

        $product->update($validatedData);

        return (new ProductResource($product))->additional([
            'message' => 'Produit mis à jour avec succès.'
        ]);
    }

    // Delete
    public function deleteProduct(DeleteProductRequest $request, Product $product) {
        $product->delete();

        return response()->json([
            'message' => 'Produit supprimé avec succès.'
        ], 200);
    }
}
