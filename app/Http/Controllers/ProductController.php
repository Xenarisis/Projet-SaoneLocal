<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\ProductResource;
use App\Http\Requests\GetProductRequest;
use App\Http\Requests\PutProductRequest;
use App\Http\Requests\ShowProductRequest;
use App\Http\Requests\PatchProductRequest;
use App\Http\Requests\DeleteProductRequest;
use App\Http\Requests\CreateProductRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductController extends Controller {
    // Read
    public function index(GetProductRequest $request): AnonymousResourceCollection {
        $query = Product::with('producer')->where('is_active', true);

        $exactFilters = ['id', 'quantity', 'category', 'subcategory', 'producer_id'];

        foreach ($exactFilters as $filter) {
            if ($request->filled($filter)) {
                $query->where($filter, $request->input($filter));
            }
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->input('min_price'));
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->input('max_price'));
        }

        if ($request->filled('name')) {
            $query->where('name', 'LIKE', '%' . $request->input('name') . '%');
        }

        if ($request->filled('description')) {
            $query->where('description', 'LIKE', '%' . $request->input('description') . '%');
        }

        if ($request->filled('producer_name')) {
            $query->whereHas('producer', function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->input('producer_name') . '%');
            });
        }

        $products = $query->paginate(25);
        $products->appends($request->all());

        return ProductResource::collection($products);
    }

    public function show(ShowProductRequest $request, Product $product): ProductResource {
        return new ProductResource($product->load('producer'));
    }

    // Create
    public function store(CreateProductRequest $request): JsonResponse {
        $validatedData = $request->validated();

        $user = $request->user();

        if ($user->isAdmin()) {
            if (!$request->has('producer_id')) {
                return response()->json([
                    'message' => 'En tant qu\'admin, vous devez spécifier un producer_id.'
                ], 422);
            }

            $validatedData['producer_id'] = $request->producer_id;
        } else {
            if (!$user->producer) {
                return response()->json([
                    'message' => 'Vous devez posséder un compte producteur pour créer un produit.'
                ], 403);
            }

            $validatedData['producer_id'] = $user->producer->id;
        }

        if ($request->hasFile('image')) {
            $manager = new \Intervention\Image\ImageManager(new \Intervention\Image\Drivers\Gd\Driver());
            $image = $manager->read($request->file('image'));
            $encoded = $image->toWebp(80);
            $filename = uniqid() . '.webp';
            \Illuminate\Support\Facades\Storage::disk('public')->put('products/' . $filename, $encoded->toString());
            $validatedData['image_path'] = $filename;
        }

        unset($validatedData['image']);

        $product = Product::create($validatedData);

        return (new ProductResource($product))
            ->additional(['message' => 'Produit créé avec succès.'])
            ->response()
            ->setStatusCode(201);
    }

    // Update : Put
    public function updatePut(PutProductRequest $request, Product $product): ProductResource {
        $validatedData = $request->validated();

        if ($request->boolean('delete_image')) {
            $validatedData['image_path'] = null;
        }

        if ($request->hasFile('image')) {
            $manager = new \Intervention\Image\ImageManager(new \Intervention\Image\Drivers\Gd\Driver());
            $image = $manager->read($request->file('image'));
            $encoded = $image->toWebp(80);
            $filename = uniqid() . '.webp';
            \Illuminate\Support\Facades\Storage::disk('public')->put('products/' . $filename, $encoded->toString());
            $validatedData['image_path'] = $filename;
        }

        unset($validatedData['image']);

        $product->update($validatedData);

        return (new ProductResource($product))->additional([
            'message' => 'Produit mis à jour avec succès.'
        ]);
    }

    // Update : Patch
    public function updatePatch(PatchProductRequest $request, Product $product): ProductResource {
        $validatedData = $request->validated();

        if ($request->boolean('delete_image')) {
            $validatedData['image_path'] = null;
        }

        if ($request->hasFile('image')) {
            $manager = new \Intervention\Image\ImageManager(new \Intervention\Image\Drivers\Gd\Driver());
            $image = $manager->read($request->file('image'));
            $encoded = $image->toWebp(80);
            $filename = uniqid() . '.webp';
            \Illuminate\Support\Facades\Storage::disk('public')->put('products/' . $filename, $encoded->toString());
            $validatedData['image_path'] = $filename;
        }

        unset($validatedData['image']);

        $product->update($validatedData);

        return (new ProductResource($product))->additional([
            'message' => 'Produit mis à jour avec succès.'
        ]);
    }

    // Delete
    public function destroy(DeleteProductRequest $request, Product $product): JsonResponse {
        $product->delete();

        return response()->json([
            'message' => 'Produit supprimé avec succès.'
        ], 200);
    }
}