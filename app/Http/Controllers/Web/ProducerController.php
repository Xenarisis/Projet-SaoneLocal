<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Producer;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProducerController extends Controller
{
    /**
     * Display the specified producer.
     */
    public function show($id): View
    {
        $producer = Producer::findOrFail($id);
        
        return view('producers.show', compact('producer'));
    }
}
