<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Product;
use App\Models\OrderItem;
use App\Models\Order;

class ProducerDashboardController extends Controller
{
    /**
     * Get the currently authenticated user's producer profile.
     */
    private function getProducer(Request $request)
    {
        $user = $request->user();
        if ($user && $user->role !== 'producer') {
            return null;
        }
        return $user ? $user->producer : null;
    }

    /**
     * Get dashboard stats (revenue, order count, product count).
     */
    public function stats(Request $request): JsonResponse
    {
        $producer = $this->getProducer($request);
        
        if (!$producer) {
            return response()->json(['message' => 'Non autorisé.'], 403);
        }

        $totalProducts = Product::where('producer_id', $producer->id)->count();

        // Count order items for this producer
        $orderItems = OrderItem::whereHas('product', function ($q) use ($producer) {
            $q->where('producer_id', $producer->id);
        })->get();

        // Total sales and valid items (exclude cancelled orders)
        $validItems = $orderItems->where('status', '!=', 'annulée');
        
        $totalSales = $validItems->sum(function($item) {
            return $item->unit_price * $item->quantity;
        });

        // Unique orders (count of distinct order_ids)
        $totalOrders = $orderItems->pluck('order_id')->unique()->count();

        // Average Cart
        $averageCart = $totalOrders > 0 ? round($totalSales / $totalOrders, 2) : 0;

        // Best Selling Product
        $bestSellingProductData = $validItems->groupBy('product_name')->map(function ($items, $name) {
            return [
                'name' => $name,
                'quantity' => $items->sum('quantity')
            ];
        })->sortByDesc('quantity')->first();
        
        $bestSellingProductName = $bestSellingProductData['name'] ?? 'Aucun produit vendu';
        $bestSellingProductQty = $bestSellingProductData['quantity'] ?? 0;

        // Total Items Sold (Volume)
        $totalItemsSold = $validItems->sum('quantity');

        // Unique clients (count of distinct user_ids from associated orders)
        $distinctClients = Order::whereIn('id', $orderItems->pluck('order_id')->unique())
                                ->distinct('user_id')
                                ->count('user_id');

        // Status counts
        $newOrdersCount = $orderItems->where('status', 'nouvelle')->count();
        $inProgressCount = $orderItems->whereIn('status', ['nouvelle', 'en préparation'])->count();
        $completedCount = $orderItems->whereIn('status', ['prête', 'retirée'])->count();
        $cancelledCount = $orderItems->where('status', 'annulée')->count();

        return response()->json([
            'producer_name' => $producer->name ?? auth()->user()->firstname,
            'total_products' => $totalProducts,
            'total_orders' => $totalOrders,
            'total_order_items' => $orderItems->count(),
            'total_sales' => round($totalSales, 2),
            'average_cart' => $averageCart,
            'best_selling_product_name' => $bestSellingProductName,
            'best_selling_product_qty' => $bestSellingProductQty,
            'total_items_sold' => $totalItemsSold,
            'new_orders_count' => $newOrdersCount,
            'distinct_clients' => $distinctClients,
            'orders_in_progress' => $inProgressCount,
            'orders_completed' => $completedCount,
            'orders_cancelled' => $cancelledCount
        ]);
    }

    /**
     * Get the producer's products.
     */
    public function products(Request $request): JsonResponse
    {
        $producer = $this->getProducer($request);
        
        if (!$producer) {
            return response()->json(['message' => 'Non autorisé.'], 403);
        }

        $query = Product::where('producer_id', $producer->id)->orderBy('created_at', 'desc');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->input('search') . '%');
        }

        $products = $query->paginate(20);

        return response()->json($products);
    }

    /**
     * Get the producer's order items (with order and customer info).
     */
    public function orders(Request $request): JsonResponse
    {
        $producer = $this->getProducer($request);
        
        if (!$producer) {
            return response()->json(['message' => 'Non autorisé.'], 403);
        }

        $query = OrderItem::with(['order.user', 'product'])
            ->whereHas('product', function ($q) use ($producer) {
                $q->where('producer_id', $producer->id);
            });

        if ($request->filled('status')) {
            $status = $request->input('status');
            if ($status !== 'toutes') {
                $query->where('status', $status);
            }
        }

        $query->orderBy('created_at', 'desc');

        $orderItems = $query->paginate(20);

        return response()->json($orderItems);
    }

    public function updateOrderStatus(Request $request, $orderItemId): JsonResponse
    {
        \Log::info("updateOrderStatus called with orderItemId: " . $orderItemId . " User: " . optional($request->user())->id . " Role: " . optional($request->user())->role);
        $producer = $this->getProducer($request);
        
        if (!$producer) {
            return response()->json(['message' => 'Non autorisé.'], 403);
        }

        $orderItem = OrderItem::whereHas('product', function ($q) use ($producer) {
            $q->where('producer_id', $producer->id);
        })->findOrFail($orderItemId);

        $request->validate([
            'status' => 'required|string|in:nouvelle,en préparation,prête,retirée,annulée',
            'pickup_location' => 'required_if:status,en préparation|nullable|string|max:255',
            'pickup_date' => 'required_if:status,en préparation|nullable|date',
            'pickup_time' => 'required_if:status,en préparation|nullable|string|max:255'
        ], [
            'pickup_location.required_if' => 'Le lieu de retrait est obligatoire pour accepter la commande.',
            'pickup_date.required_if' => 'La date de retrait est obligatoire pour accepter la commande.',
            'pickup_time.required_if' => 'L\'heure de retrait est obligatoire pour accepter la commande.',
        ]);

        $orderItem->update([
            'status' => $request->input('status'),
            'pickup_location' => $request->input('pickup_location', $orderItem->pickup_location),
            'pickup_date' => $request->input('pickup_date', $orderItem->pickup_date),
            'pickup_time' => $request->input('pickup_time', $orderItem->pickup_time),
        ]);

        // Update parent order status
        $order = $orderItem->order;
        $allItems = $order->items;
        
        $allCancelled = $allItems->every(fn($item) => $item->status === 'annulée');
        $allCompletedOrCancelled = $allItems->every(fn($item) => in_array($item->status, ['retirée', 'annulée']));
        $anyProcessing = $allItems->contains(fn($item) => in_array($item->status, ['en préparation', 'prête']));
        $anyNew = $allItems->contains(fn($item) => $item->status === 'nouvelle');
        
        if ($allCancelled) {
            $order->update(['status' => 'cancelled']);
        } elseif ($allCompletedOrCancelled) {
            $order->update(['status' => 'completed']);
        } elseif ($anyProcessing) {
            $order->update(['status' => 'processing']);
        } elseif ($anyNew) {
            $order->update(['status' => 'pending']);
        }

        return response()->json(['message' => 'Statut mis à jour avec succès.', 'item' => $orderItem]);
    }
}
