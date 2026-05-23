<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

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

        $products = $query->get();

        if($products->isEmpty()) {
            return response()->json([
                'message' => 'Aucun produit trouvé avec ces critères.',
                'data' => []
            ], 404);
        }

        return response()->json([
            'message' => $products->count() . ' produit(s) trouvé(s).',
            'data' => $products
        ], 200);
    }

    public function getProductById($id) {
        return Product::with('producer')->findOrFail($id);
    }

    // Create
    public function createProduct(Request $request) {
        $user = auth()->user();

        if ($user->role !== 'admin' && $user->role !== 'producer') {
            return response()->json([
                'message' => 'Action non autorisée. Seuls les administrateurs et les producteurs peuvent ajouter des produits.'
            ], 403);
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0|max:999.99',
            'quantity' => 'required|integer|min:0',
            'category' => 'required|string|max:255',
            'subcategory' => 'nullable|string|max:255',
            'producer_id' => 'required|exists:producers,id'
        ]);

        if ($user->role === 'producer') {
            $producerProfile = Producer::where('user_id', $user->id)->first();

            if (!$producerProfile || $producerProfile->id != $validatedData['producer_id']) {
                return response()->json([
                    'message' => 'Action refusée. Vous ne pouvez lier un produit qu\'à votre propre profil producteur.'
                ], 403);
            }
        }

        $product = Product::create($validatedData);

        return response()->json([
            'message' => 'Produit ajouté au catalogue avec succès.',
            'product' => $product
        ], 201);
    }
}
