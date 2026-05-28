<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\Producer;
use Illuminate\Http\Request;
use app\Http\Resources\FollowResource;
// use app\Http\Requests\CreateFollowRequest;

class FollowController extends Controller {
    // Read
    public function createFollow(Request $request, Producer $producer) {
        $user = $request->user();

        $follow = Follow::firstOrCreate([
            'user_id' => $user->id,
            'producer_id' => $producer->id
        ]);

        if (!$follow->wasRecentlyCreated) {
            return response()->json([
                'message' => 'Vous suivez déjà ce producteur.'
            ], 409);
        }

        return (new FollowResource($follow))->additional(['message' => 'Follow ajouté avec succès.'])->response()->setStatusCode(201);
    }

    public function deleteFollow(Request $request, Producer $producer) {
        
    }

}
