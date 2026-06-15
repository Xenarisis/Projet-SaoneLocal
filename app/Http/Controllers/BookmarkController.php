<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Bookmark;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\BookmarkResource;
use App\Http\Requests\GetBookmarkRequest;
use App\Http\Requests\ShowBookmarkRequest;
use App\Http\Requests\CreateBookmarkRequest;
use App\Http\Requests\DeleteBookmarkRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BookmarkController extends Controller {
    // Read
    public function index(GetBookmarkRequest $request): AnonymousResourceCollection {
        $query = Bookmark::with('product');
        $user = $request->user();

        if ($user && !$user->isAdmin()) {
            $query->where('user_id', $user->id);
        } elseif ($request->filled('user_id')) {
            $query->where('user_id', $request->input('user_id'));
        }

        if ($request->filled('product_id')) {
            $query->where('product_id', $request->input('product_id'));
        }

        $bookmarks = $query->latest()->paginate(50);
        $bookmarks->appends($request->all());

        return BookmarkResource::collection($bookmarks);
    }

    public function show(ShowBookmarkRequest $request, Bookmark $bookmark): BookmarkResource {
        return new BookmarkResource($bookmark->load('product'));
    }

    // Create
    public function store(CreateBookmarkRequest $request): JsonResponse {
        $validatedData = $request->validated();
        $user = $request->user();
        $productId = $validatedData['product_id'];

        $alreadyBookmarked = Bookmark::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->exists();

        if ($alreadyBookmarked) {
            return response()->json([
                'message' => 'Ce produit est déjà dans vos favoris.'
            ], 409);
        }

        $bookmark = $user->bookmarks()->create([
            'product_id' => $productId
        ]);

        return (new BookmarkResource($bookmark))
            ->additional(['message' => 'Produit ajouté aux favoris.'])
            ->response()
            ->setStatusCode(201);
    }

    // Delete
    public function destroy(DeleteBookmarkRequest $request, Bookmark $bookmark): JsonResponse {
        $bookmark->delete();

        return response()->json([
            'message' => 'Produit retiré des favoris.'
        ], 200);
    }
}