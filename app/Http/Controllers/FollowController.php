<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Follow;
use App\Models\Producer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\FollowResource;

class FollowController extends Controller {
    // Read
    public function getFollowById(Follow $follow) {
        Gate::authorize('view', $follow);

        return new FollowResource($follow->load('user')->load('producer'));
    }

    public function getUserFollow(User $user) {
        Gate::authorize('viewUserFollows', [Follow::class, $user]);

        $follows = $user->follows()->with('producer')->get(); 
    
        return FollowResource::collection($follows);
    }

    public function getProducerFollowers(Producer $producer) {
        Gate::authorize('viewProducerFollowers', [Follow::class, $producer]);

        $followers = $producer->followers()->with('user')->get();

        return FollowResource::collection($followers);
    }

    // Create
    public function createFollow(Request $request, Producer $producer) {
        Gate::authorize('create', Follow::class);

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

    // Update (no update needed in this controller)

    // Delete
    public function deleteFollow(Request $request, Producer $producer) {
        $user = $request->user();

        $follow = Follow::where('user_id', $user->id)->where('producer_id', $producer->id)->first();

        if (!$follow) {
            return response()->json([
                'message' => 'Vous ne suivez pas ce producteur.'
            ], 404);
        }

        Gate::authorize('delete', $follow);

        $follow->delete();

        return response()->json([
            'message' => 'Abonnement supprimé avec succès.'
        ], 204);
    }
}
