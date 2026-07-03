<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserResource;
use App\Http\Requests\GetUserRequest;
use App\Http\Requests\PutUserRequest;
use App\Http\Requests\ShowUserRequest;
use App\Http\Requests\PatchUserRequest;
use App\Http\Requests\DeleteUserRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserController extends Controller {
    // Read
    public function index(GetUserRequest $request): AnonymousResourceCollection {
        $query = User::query();

        $currentUser = $request->user();

        if ($currentUser && !$currentUser->isAdmin()) {
            $query->where('id', $currentUser->id);
        }

        if ($request->filled('id')) {
            $query->where('id', $request->input('id'));
        }

        if ($request->filled('email')) {
            $query->where('email', $request->input('email'));
        }

        if ($request->filled('username')) {
            $query->where('username', $request->input('username'));
        }

        if ($request->filled('google_token')) {
            $query->where('google_token', $request->input('google_token'));
        }

        $users = $query->paginate(50);
        $users->appends($request->all());

        return UserResource::collection($users);
    }

    public function show(ShowUserRequest $request, User $user): UserResource {
        return new UserResource($user);
    }

    // Update : Put
    public function updatePut(PutUserRequest $request, User $user): UserResource {
        $validatedData = $request->validated();

        if ($request->filled('password')) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        } else {
            unset($validatedData['password']);
        }

        if ($request->boolean('delete_pdp')) {
            $validatedData['pdp_path'] = null;
        }

        if ($request->hasFile('pdp')) {
            $manager = new \Intervention\Image\ImageManager(new \Intervention\Image\Drivers\Gd\Driver());
            $image = $manager->read($request->file('pdp'));
            $encoded = $image->toWebp(80);
            $filename = uniqid() . '.webp';
            \Illuminate\Support\Facades\Storage::disk('local')->put('avatars/' . $filename, $encoded->toString());
            $validatedData['pdp_path'] = $filename;
        }

        $user->update($validatedData);

        if ($user->role === 'producer' && $user->producer) {
            $user->producer->update([
                'name' => $request->input('producer_name', $user->producer->name),
                'presentation' => $request->input('presentation', $user->producer->presentation),
                'street_line_1' => $request->input('street_line_1', $user->producer->street_line_1),
                'street_line_2' => $request->input('street_line_2', $user->producer->street_line_2),
                'city' => $request->input('city', $user->producer->city),
                'postal_code' => $request->input('postal_code', $user->producer->postal_code),
            ]);
        }

        return (new UserResource($user))->additional([
            'message' => 'Utilisateur mis à jour avec succès.'
        ]);
    }

    public function becomeProducer(Request $request, User $user): JsonResponse {
        $currentUser = $request->user();

        \Log::info('BecomeProducer: current user=' . $currentUser->id . ', target user=' . $user->id . ', isAdmin=' . ($currentUser->isAdmin() ? 'true' : 'false'));

        if ($currentUser->id !== $user->id && !$currentUser->isAdmin()) {
            return response()->json(['message' => 'Non autorisé'], 403);
        }

        if ($user->role === 'user') {
            $user->update(['role' => 'producer']);
            if (!$user->producer) {
                \App\Models\Producer::create([
                    'user_id' => $user->id,
                    'name' => $user->username ?? ($user->firstname . ' ' . $user->lastname),
                    'city' => '',
                    'postal_code' => '71100',
                    'street_line_1' => '',
                ]);
            }
        }

        return response()->json(['message' => 'Vous êtes maintenant producteur !', 'user' => new UserResource($user->fresh(['producer']))], 200);
    }

    public function stopProducer(Request $request, User $user): JsonResponse {
        $currentUser = $request->user();

        if ($currentUser->id !== $user->id && !$currentUser->isAdmin()) {
            return response()->json(['message' => 'Non autorisé'], 403);
        }

        if ($user->role === 'producer') {
            $user->update(['role' => 'user']);
            
            if ($user->producer) {
                \App\Models\Product::where('producer_id', $user->producer->id)->update(['is_active' => false]);
                
                \App\Models\OrderItem::whereHas('product', function($q) use ($user) {
                    $q->where('producer_id', $user->producer->id);
                })
                ->whereNotIn('status', ['terminée', 'livrée', 'retirée', 'annulée'])
                ->update(['status' => 'annulée']);
            }
        }

        return response()->json(['message' => 'Votre espace producteur a été désactivé.', 'user' => new UserResource($user->fresh())], 200);
    }

    // Update : Patch
    public function updatePatch(PatchUserRequest $request, User $user): UserResource {
        $validatedData = $request->validated();

        if ($request->filled('password')) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        }

        if ($request->boolean('delete_pdp')) {
            $validatedData['pdp_path'] = null;
        }

        if ($request->hasFile('pdp')) {
            $manager = new \Intervention\Image\ImageManager(new \Intervention\Image\Drivers\Gd\Driver());
            $image = $manager->read($request->file('pdp'));
            $encoded = $image->toWebp(80);
            $filename = uniqid() . '.webp';
            \Illuminate\Support\Facades\Storage::disk('local')->put('avatars/' . $filename, $encoded->toString());
            $validatedData['pdp_path'] = $filename;
        }

        $user->update($validatedData);

        return (new UserResource($user))->additional([
            'message' => 'Utilisateur mis à jour avec succès.'
        ]);
    }

    // Delete
    public function destroy(DeleteUserRequest $request, User $user): JsonResponse {
        $currentUser = $request->user();

        $isAdmin = $currentUser->isAdmin();
        $isOwner = $currentUser->id === $user->id;

        if (!$isAdmin && !$isOwner) {
            return response()->json(['message' => 'Non autorisé'], 403);
        }

        if ($isOwner && !$isAdmin) {
            if ($request->filled('google_token')) {
                if ($user->google_token === null || $request->input('google_token') !== $user->google_token) {
                    return response()->json(['message' => 'Action non autorisée. Token Google invalide.'], 403);
                }
            }
        }

        $user->delete();

        return response()->json(['message' => 'Utilisateur supprimé avec succès.'], 200);
    }

    public function showAvatar($filename) {
        $path = storage_path('app/avatars/' . $filename);

        if (!file_exists($path)) {
            abort(404);
        }

        return response()->file($path);
    }
}