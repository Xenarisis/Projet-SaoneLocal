<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\OrderResource;
use App\Http\Requests\PutOrderRequest;
use App\Http\Requests\PatchOrderRequest;
use App\Http\Requests\CreateOrderRequest;
use App\Http\Requests\DeleteOrderRequest;

class OrderController extends Controller {
    // Read
    public function getAll() {
        Gate::authorize('viewAny', Order::class);

        $orders = Order::paginate(50);
        return OrderResource::collection($orders);
    }

    public function getOrderById(Order $order) {
        Gate::authorize('view', $order);

        return new OrderResource($order);
    }

    public function getOrderByOrderNumber($orderNumber) {
        $order = Order::where('order_number', $orderNumber)->firstOrFail();

        Gate::authorize('view', $order);
        return new OrderResource($order);
    }

    // Create
    public function createOrder(CreateOrderRequest $request) {
        $validatedData = $request->validated();
        
        $order = new Order($validatedData);
        $order->user_id = $request->user()->id;
        $order->save();

        return (new OrderResource($order))->additional(['message' => 'Commande crée avec succès'])->response()->setStatusCode(201);
    }

    // Put
    public function putOrder(PutOrderRequest $request, Order $order) {
        $validatedData = $request->validated();

        $order->update($validatedData);

        return (new OrderResource($order))->additional(['message' => 'Commande mis à jour avec succès'])->response();
    }

    // Patch
    public function patchOrder(PatchOrderRequest $request, Order $order) {
        $validatedData = $request->validated();

        $order->update($validatedData);

        return (new OrderResource($order))->additional(['message' => 'Commande mis à jour avec succès'])->response();
    }

    // Delete
    public function deleteOrder(DeleteOrderRequest $request, Order $order) {
        $order->delete();

        return response()->json(['message' => 'Commande supprimée avec succès']);
    }
}
