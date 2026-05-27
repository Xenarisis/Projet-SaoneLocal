<?php

namespace App\Http\Controllers;

use App\Models\Reduce;
use Illuminate\Http\Request;

class ReduceController extends Controller
{
    public function index() {
        return $this->getAll();
    }

    // CREATE
    public function createReduce(Request $request) {
        $Validatedata = $request->validate([
            // 'name' => 'required|string|unique:producer|min:1|max:30',
            // 'presentation' => 'sometime|string',
            // 'street_line_1' => 'required|string|min:1|max:60',
            // 'street_line_2' => 'nullable|string|min:1|max:60',
            // 'city' => 'required|string|min:1|max:50',
            // 'postal_code' => 'required|string|min:1|max:20'
        ]);

        $Reduce = Reduce::create($Validatedata);

        return response()->json([
            'message' => 'Code Bon et envoyer',
            'reduce' => $Reduce
        ], 201);
    }

    // READ
    public function getAll() {

    }

    // UPDATE: put branch
    public function putReduce() {

    }
    
    // UPDATE: patch branch
    public function patchReduce() {

    }

    // DELETE
    public function deleteReduce() {

    }
}
