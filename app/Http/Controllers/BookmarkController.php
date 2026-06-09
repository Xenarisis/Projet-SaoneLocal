<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Bookmark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\BookmarkResource;
use App\Http\Requests\DeleteBookmarkRequest;
use App\Http\Requests\GetUserBookmarksRequest;

class BookmarkController extends Controller {

    // Read
    public function getUserBookmarks(GetUserBookmarksRequest $request, User $user) {
        $bookmarks = $user->bookmarks()->with('product')->latest()->get();

        return BookmarkResource::collection($bookmarks);
    }

    // Create
    public function addBookmark(Request $request, Product $product) {
        $user = $request->user();

        $alreadyBookmarked = Bookmark::where('user_id', $user->id)->where('product_id', $product->id)->exists();

        if ($alreadyBookmarked) {
            return response()->json([
                'message' => 'Ce produit est déjà dans vos favoris.'
            ], 409);
        }

        $bookmark = $user->bookmarks()->create(['product_id' => $product->id]);

        return (new BookmarkResource($bookmark))->additional(['message' => 'Produit ajouté aux favoris.'])->response()->setStatusCode(201);
    }

    // Delete
    public function deleteBookmark(DeleteBookmarkRequest $request, Bookmark $bookmark) {
        $bookmark->delete();

        return response()->json([
            'message' => 'Produit retiré des favoris.'
        ], 200);
    }
}