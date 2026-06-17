<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\OrderResource;
use App\Http\Requests\GetOrderRequest;
use App\Http\Requests\PutOrderRequest;
use App\Http\Requests\ShowOrderRequest;
use App\Http\Requests\PatchOrderRequest;
use App\Http\Requests\CreateOrderRequest;
use App\Http\Requests\DeleteOrderRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class OrderController extends Controller {
    
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
            $query->where('total', '>=', $request->input('min_total'));
        }

        if ($request->filled('max_total')) {
            $query->where('total', '<=', $request->input('max_total'));
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
        //! Automaticly fill order_number & status & total & everything based on cart / list of item (every cart items not neccesary pay now)
        $validatedData = $request->validated();
        
        $order = new Order($validatedData);
        $order->user_id = $request->user()->id;
        $order->save();

        return (new OrderResource($order))
            ->additional(['message' => 'Commande créée avec succès.'])
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