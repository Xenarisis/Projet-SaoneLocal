<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\FollowResource;
use App\Http\Requests\GetFollowRequest;
use App\Http\Requests\ShowFollowRequest;
use App\Http\Requests\CreateFollowRequest;
use App\Http\Requests\DeleteFollowRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class FollowController extends Controller {
    // Read
    public function index(GetFollowRequest $request): AnonymousResourceCollection {
        $query = Follow::with(['user', 'producer']);
        $user = $request->user();

        if ($user && !$user->isAdmin()) {
            $query->where('user_id', $user->id);
        } 
        elseif ($request->filled('user_id')) {
            $query->where('user_id', $request->input('user_id'));
        }

        if ($request->filled('producer_id')) {
            $query->where('producer_id', $request->input('producer_id'));
        }

        $follows = $query->paginate(50);
        $follows->appends($request->all());

        return FollowResource::collection($follows);
    }

    public function show(ShowFollowRequest $request, Follow $follow): FollowResource {
        return new FollowResource($follow->loadMissing(['user', 'producer']));
    }

    // Create
    public function store(CreateFollowRequest $request): JsonResponse {
        $follow = Follow::firstOrCreate([
            'user_id'     => $request->user()->id,
            'producer_id' => $request->validated()['producer_id']
        ]);

        if (!$follow->wasRecentlyCreated) {
            return response()->json([
                'message' => 'Vous suivez déjà ce producteur.'
            ], 409);
        }

        return (new FollowResource($follow))
            ->additional(['message' => 'Abonnement ajouté avec succès.'])
            ->response()
            ->setStatusCode(201);
    }

    // Delete
    public function destroy(DeleteFollowRequest $request, Follow $follow): JsonResponse {
        $follow->delete();

        return response()->json([
            'message' => 'Abonnement supprimé avec succès.'
        ], 200);
    }
}