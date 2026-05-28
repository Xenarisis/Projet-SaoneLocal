<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\OrderResource;
use App\Http\Requests\PutOrderRequest;
use App\Http\Requests\PatchOrderRequest;
use App\Http\Requests\CreateOrderRequest;

class OrderController extends Controller {
    // Read
    public function getAll() {
        Gate::authorize('viewAny', Order::class);

        $orders = Order::paginate(50);
        return OrderResource::collection($orders);
    }

    public function getOrderById(Order $order) {
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

        return response()->json(new OrderResource($order), 201);
    }

    // Put
    public function putOrder(PutOrderRequest $request) {

    }

    // Patch
    public function patchOrder(PatchOrderRequest $request) {

    }

    // Delete
    public function deleteOrder() {

    }
}
