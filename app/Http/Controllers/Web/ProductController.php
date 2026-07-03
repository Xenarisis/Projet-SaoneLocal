<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Display the specified product.
     */
    public function show($id): View
    {
        $product = Product::findOrFail($id);
        
        $producerProducts = Product::where('producer_id', $product->producer_id)
            ->where('id', '!=', $product->id)
            ->latest()
            ->take(6)
            ->get();
            
        $similarProducts = Product::where('category', $product->category)
            ->where('producer_id', '!=', $product->producer_id)
            ->where('id', '!=', $product->id)
            ->latest()
            ->take(6)
            ->get();

        return view('products.show', compact('product', 'producerProducts', 'similarProducts'));
    }
}
