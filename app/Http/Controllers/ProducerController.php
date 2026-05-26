<?php

namespace App\Http\Controllers;

use App\Models\Producer;
use Illuminate\Http\Request;

class ProducerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        return getAll();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createProducer(Request $request) {
        $Validatedata = $request->validate([
            'name' => 'required|string|unique:producer|min:1|max:30',
            'presentation' => 'sometime|string',
            'street_line_1' => 'required|string|min:1|max:60',
            'street_line_2' => 'nullable|string|min:1|max:60',
            'city' => 'required|string|min:1|max:50',
            'postal_code' => 'required|string|min:1|max:20'
        ]);

        $Producer = new Producer();

        $Producer->name = $Validatedata['name'];
        $Producer->presentation = $Validatedata['presentation'];
        $Producer->street_line_1 = $Validatedata['street_line_1'];
        $Producer->street_line_2 = $Validatedata['street_line_2'];
        $Producer->city = $Validatedata['city'];
        $Producer->postal_code = $Validatedata['postal_code'];

        $Producer->save();

        return response()->json([
            'message' => 'Producteur bien créer',
            'producer' => $Producer
        ], 201);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Producer $producer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Producer $producer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Producer $producer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Producer $producer)
    {
        //
    }
}
