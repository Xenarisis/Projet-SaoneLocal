<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\CartItemResource;
use App\Http\Requests\GetCartItemRequest;
use App\Http\Requests\PutCartItemRequest;
use App\Http\Requests\ShowCartItemRequest;
use App\Http\Requests\PatchCartItemRequest;
use App\Http\Requests\DeleteCartItemRequest;
use App\Http\Requests\CreateCartItemRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CartItemController extends Controller {
    // Read
    public function index(GetCartItemRequest $request): AnonymousResourceCollection {
        $query = CartItem::with(['product.producer', 'user']);
        $user = auth('api')->user();

        if ($user && !$user->isAdmin()) {
            $query->where('user_id', $user->id);
        } elseif ($request->filled('user_id')) {
            $query->where('user_id', $request->input('user_id'));
        }

        if ($request->filled('product_id')) {
            $query->where('product_id', $request->input('product_id'));
        }

        $items = $query->paginate(50);
        $items->appends($request->all());

        return CartItemResource::collection($items);
    }

    public function show(ShowCartItemRequest $request, CartItem $cartItem): CartItemResource {
        return new CartItemResource($cartItem->load(['product.producer']));
    }
    
    // Create
    public function store(CreateCartItemRequest $request): JsonResponse {
        //! Need to delete 'quantity' of product ++ check there is enought
        $validatedData = $request->validated();
        $user = $request->user();
        
        $productId = $validatedData['product_id'];
        $quantityToAdd = $validatedData['quantity'] ?? 1;

        $cartItem = $user->cartItems()->where('product_id', $productId)->first();

        if ($cartItem) {
            $cartItem->quantity += $quantityToAdd;
            $cartItem->save();
            $message = 'Quantité mise à jour dans le panier.';
        } else {
            $cartItem = $user->cartItems()->create([
                'product_id' => $productId,
                'quantity' => $quantityToAdd
            ]);
            $message = 'Produit ajouté au panier.';
        }

        return (new CartItemResource($cartItem))
            ->additional(['message' => $message])
            ->response()
            ->setStatusCode(201);
    }

    // Update: Put
    public function updatePut(PutCartItemRequest $request, CartItem $cartItem): CartItemResource {
        //! Need to check quantity
        $validatedData = $request->validated();

        $cartItem->update($validatedData);

        return (new CartItemResource($cartItem))
            ->additional(['message' => 'Élément du panier mis à jour.']);
    }

    // Update: Patch
    public function updatePatch(PatchCartItemRequest $request, CartItem $cartItem): CartItemResource {
        //! Need to check quantity
        $validatedData = $request->validated();

        $cartItem->update($validatedData);

        return (new CartItemResource($cartItem))
            ->additional(['message' => 'Élément du panier mis à jour.']);
    }

    // Delete
    public function destroy(DeleteCartItemRequest $request, CartItem $cartItem): JsonResponse {
        $cartItem->delete();

        return response()->json([
            'message' => 'Produit retiré du panier avec succès.'
        ], 200);
    }
}