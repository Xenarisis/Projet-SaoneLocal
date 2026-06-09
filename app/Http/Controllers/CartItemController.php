<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\CartItemResource;
use App\Http\Requests\PutCartItemRequest;
use App\Http\Requests\PatchCartItemRequest
;

class CartItemController extends Controller {
    
    // Read
    public function getCartItemById(CartItem $item) {
        Gate::authorize('view', $item);
        return new CartItemResource($item->load(['product.producer']));
    }

    public function getCartItemByUserId(Request $request, User $user) {
        Gate::authorize('viewUserCartItems', [CartItem::class, $user]);

        $items = $user->cartItems()->with(['product.producer'])->get(); 
        return CartItemResource::collection($items);
    }

    public function getCartItemByProductId(Request $request, Product $product) {
        Gate::authorize('viewProducerCartItems', [CartItem::class, $product]);

        $items = $product->cartItems()->with('user')->get();
        return CartItemResource::collection($items);
    }
    
    // Create
    public function addCartItem(Request $request, Product $product) {
        // Need to delete 'quantity' of product ++ check there is enought
        $user = $request->user();
        $quantityToAdd = $request->input('quantity', 1);

        $cartItem = $user->cartItems()->where('product_id', $product->id)->first();

        if ($cartItem) {
            $cartItem->quantity += $quantityToAdd;
            $cartItem->save();
            $message = 'Quantité mise à jour dans le panier.';
        } else {
            $cartItem = $user->cartItems()->create([
                'product_id' => $product->id,
                'quantity' => $quantityToAdd
            ]);
            
            $message = 'Produit ajouté au panier.';
        }

        return (new CartItemResource($cartItem))->additional(['message' => $message])->response()->setStatusCode(201);
    }

    // Put
    public function putCartItem(PutCartItemRequest $request, CartItem $cartItem) {
        //! Need to check quantity
        $validatedData = $request->validated();

        $cartItem->update($validatedData);

        return (new CartItemResource($cartItem))->additional(['message' => 'Élément du panier mis à jour.'])->response()->setStatusCode(200);
    }

    // Patch
    public function patchCartItem(PatchCartItemRequest $request, CartItem $cartItem) {
        //! Need to check quantity
        $validatedData = $request->validated();

        $cartItem->update(['quantity' => $request->quantity]);

        return (new CartItemResource($cartItem))->additional(['message' => 'Quantité modifiée avec succès.'])->response()->setStatusCode(200);
    }

    // Delete
    public function deleteCartItem(Request $request, CartItem $cartItem) {
        Gate::authorize('delete', $cartItem);

        $cartItem->delete();

        return response()->json([
            'message' => 'Produit retiré du panier avec succès.'
        ], 200);
    }
}