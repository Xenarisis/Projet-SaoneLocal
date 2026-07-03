<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
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
        $validatedData = $request->validated();
        $user = $request->user();
        
        $productId = $validatedData['product_id'];
        $quantityToAdd = $validatedData['quantity'] ?? 1;

        $product = Product::findOrFail($productId);

        if ($product->quantity < $quantityToAdd) {
            return response()->json([
                'message' => 'quantity insuffisant pour ce produit.'
            ], 422); 
        }

        DB::transaction(function () use ($user, $product, $productId, $quantityToAdd, &$cartItem, &$message) {
            $product->decrement('quantity', $quantityToAdd);

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
        });

        return (new CartItemResource($cartItem))
            ->additional(['message' => $message])
            ->response()
            ->setStatusCode(201);
    }

    // Update: Put
    public function updatePut(PutCartItemRequest $request, CartItem $cartItem) {
        return $this->handleQuantityUpdate($request, $cartItem);
    }

    // Update: Patch
    public function updatePatch(PatchCartItemRequest $request, CartItem $cartItem) {
        return $this->handleQuantityUpdate($request, $cartItem);
    }

    private function handleQuantityUpdate(Request $request, CartItem $cartItem) {
        $validatedData = $request->validated();

        if (isset($validatedData['quantity'])) {
            $newQuantity = $validatedData['quantity'];
            $oldQuantity = $cartItem->quantity;
            $difference = $newQuantity - $oldQuantity;

            $product = $cartItem->product;

            if ($difference > 0 && $product->quantity < $difference) {
                return response()->json([
                    'message' => 'quantity insuffisant pour cette mise à jour.'
                ], 422);
            }

            DB::transaction(function () use ($product, $cartItem, $validatedData, $difference) {
                if ($difference > 0) {
                    $product->decrement('quantity', $difference);
                } elseif ($difference < 0) {
                    $product->increment('quantity', abs($difference));
                }
                
                $cartItem->update($validatedData);
            });
        } else {
            $cartItem->update($validatedData);
        }

        return (new CartItemResource($cartItem))
            ->additional(['message' => 'Élément du panier mis à jour.']);
    }

    // Delete
    public function destroy(DeleteCartItemRequest $request, CartItem $cartItem): JsonResponse {
        DB::transaction(function () use ($cartItem) {
            $cartItem->product->increment('quantity', $cartItem->quantity);
            $cartItem->delete();
        });

        return response()->json([
            'message' => 'Produit retiré du panier avec succès.'
        ], 200);
    }
}