<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Producer;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageController extends Controller
{
    /**
     * Display the home page.
     */
    public function home(): View
    {
        $products = Product::latest()->take(8)->get();
        $producers = Producer::latest()->take(8)->get();
        
        return view('welcome', compact('products', 'producers'));
    }

    /**
     * Display the search page.
     */
    public function search(): View
    {
        $products = Product::all();
        $producers = Producer::all();
        
        return view('search.index', compact('products', 'producers'));
    }

    /**
     * Display the about page.
     */
    public function about(): View
    {
        return view('pages.about');
    }
}
