<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\OrderResource;
use App\Http\Requests\GetOrderRequest;
use App\Http\Requests\PutOrderRequest;
use App\Http\Requests\ShowOrderRequest;
use App\Http\Requests\PatchOrderRequest;
use App\Http\Requests\CreateOrderRequest;
use App\Http\Requests\DeleteOrderRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class OrderItemController extends Controller {
    // Read
    public function index(GetOrderRequest $request): AnonymousResourceCollection {
        $query = Order::query();

        $user = $request->user();
        if ($user && !$user->isAdmin()) {
            $query->where('user_id', $user->id);
        } elseif ($request->filled('user_id')) {
            $query->where('user_id', $request->input('user_id'));
        }

        if ($request->filled('order_number')) {
            $query->where('order_number', $request->input('order_number'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('min_total')) {
            $query->where('total_excl_tax', '>=', $request->input('min_total'));
        }

        if ($request->filled('max_total')) {
            $query->where('total_excl_tax', '<=', $request->input('max_total'));
        }

        $orders = $query->paginate(50);
        $orders->appends($request->all());

        return OrderResource::collection($orders);
    }

    public function show(ShowOrderRequest $request, Order $order): OrderResource {
        return new OrderResource($order);
    }

    // Create
    public function store(CreateOrderRequest $request): JsonResponse {
        $user = $request->user();
        
        $cartItems = $user->cartItems()->with('product')->get();

        if ($cartItems->isEmpty()) {
            return response()->json([
                'message' => 'Impossible de créer une commande : le panier est vide.'
            ], 400);
        }

        $order = DB::transaction(function () use ($user, $cartItems) {
            $totalExclTax = 0;

            foreach ($cartItems as $cartItem) {
                $totalExclTax += $cartItem->quantity * $cartItem->product->price; 
            }

            $order = new Order();
            $order->order_number = 'ORD-' . strtoupper(uniqid()); 
            $order->status = 'pending';
            $order->total_excl_tax = $totalExclTax;
            $order->percentage_tax = 20.00;
            $order->payment_status = 'pending';
            $order->user_id = $user->id;
            
            $order->save();

            foreach ($cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'product_name' => $cartItem->product->name,
                    'unit_price' => $cartItem->product->price,
                    'quantity' => $cartItem->quantity,
                ]);
            }

            $user->cartItems()->delete();

            return $order;
        });

        return (new OrderResource($order))
            ->additional(['message' => 'Commande créée avec succès à partir du panier.'])
            ->response()
            ->setStatusCode(201);
    }

    // Update : Put
    public function updatePut(PutOrderRequest $request, Order $order): OrderResource {
        $validatedData = $request->validated();

        $order->update($validatedData);

        return (new OrderResource($order))->additional([
            'message' => 'Commande mise à jour avec succès.'
        ]);
    }

    // Update : Patch
    public function updatePatch(PatchOrderRequest $request, Order $order): OrderResource {
        $validatedData = $request->validated();

        $order->update($validatedData);

        return (new OrderResource($order))->additional([
            'message' => 'Commande mise à jour avec succès.'
        ]);
    }

    // Delete
    public function destroy(DeleteOrderRequest $request, Order $order): JsonResponse {
        $order->delete();

        return response()->json([
            'message' => 'Commande supprimée avec succès.'
        ], 200);
    }
}