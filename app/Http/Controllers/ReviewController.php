<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Resources\ReviewResource;
use App\Http\Requests\AddReviewRequest;
use App\Http\Requests\UpdateReviewRequest;
use App\Http\Requests\DeleteReviewRequest;

class ReviewController extends Controller {
    // GET
    public function getProductReviews(Product $product) {
        $reviews = $product->reviews()->with('user')->latest()->get(); 
        return ReviewResource::collection($reviews);
    }

    public function getReviewById(Review $review) {
        return new ReviewResource($review->load(['user', 'product']));
    }

    // UPDATE
    public function addReview(AddReviewRequest $request, Product $product) {
        $user = $request->user();

        $alreadyReviewed = Review::where('user_id', $user->id)->where('product_id', $product->id)->exists();

        if ($alreadyReviewed) {
            return response()->json([
                'message' => 'Vous avez déjà laissé un avis pour ce produit.'
            ], 409);
        }

        $review = $user->reviews()->create([
            'product_id' => $product->id,
            'rating'     => $request->rating,
            'comment'    => $request->comment,
        ]);

        return (new ReviewResource($review))->additional(['message' => 'Avis ajouté avec succès.'])->response()->setStatusCode(201);
    }

    public function patchReview(UpdateReviewRequest $request, Review $review) {
        $review->update($request->validated());

        return (new ReviewResource($review))->additional(['message' => 'Avis modifié avec succès.'])->response()->setStatusCode(200);
    }

    // Delete
    public function deleteReview(DeleteReviewRequest $request, Review $review) {
        $review->delete();

        return response()->json([
            'message' => 'Avis supprimé avec succès.'
        ], 200);
    }
}