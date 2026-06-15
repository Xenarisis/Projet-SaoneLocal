<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\ReviewResource;
use App\Http\Requests\GetReviewRequest;
use App\Http\Requests\PutReviewRequest;
use App\Http\Requests\ShowReviewRequest;
use App\Http\Requests\PatchReviewRequest;
use App\Http\Requests\CreateReviewRequest;
use App\Http\Requests\DeleteReviewRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ReviewController extends Controller {
    // Read
    public function index(GetReviewRequest $request): AnonymousResourceCollection {
        $query = Review::with(['user', 'product']);

        if ($request->filled('product_id')) {
            $query->where('product_id', $request->input('product_id'));
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->input('user_id'));
        }

        if ($request->filled('rating')) {
            $query->where('rating', $request->input('rating'));
        }

        $reviews = $query->latest()->paginate(25);
        $reviews->appends($request->all());

        return ReviewResource::collection($reviews);
    }

    public function show(ShowReviewRequest $request, Review $review): ReviewResource {
        return new ReviewResource($review->loadMissing(['user', 'product']));
    }

    // Create
    public function store(CreateReviewRequest $request): JsonResponse {
        $validatedData = $request->validated();
        $user = $request->user();

        $alreadyReviewed = Review::where('user_id', $user->id)
            ->where('product_id', $validatedData['product_id'])
            ->exists();

        if ($alreadyReviewed) {
            return response()->json([
                'message' => 'Vous avez déjà laissé un avis pour ce produit.'
            ], 409);
        }

        $review = $user->reviews()->create([
            'product_id' => $validatedData['product_id'],
            'rating'     => $validatedData['rating'],
            'comment'    => $validatedData['comment'] ?? null,
        ]);

        return (new ReviewResource($review))
            ->additional(['message' => 'Avis ajouté avec succès.'])
            ->response()
            ->setStatusCode(201);
    }

    // Update : Put
    public function updatePut(PutReviewRequest $request, Review $review): ReviewResource {
        $validatedData = $request->validated();

        $review->update($validatedData);

        return (new ReviewResource($review))->additional([
            'message' => 'Avis modifié avec succès.'
        ]);
    }

    // Update : Patch
    public function updatePatch(PatchReviewRequest $request, Review $review): ReviewResource {
        $validatedData = $request->validated();

        $review->update($validatedData);

        return (new ReviewResource($review))->additional([
            'message' => 'Avis modifié avec succès.'
        ]);
    }

    // Delete
    public function destroy(DeleteReviewRequest $request, Review $review): JsonResponse {
        $review->delete();

        return response()->json([
            'message' => 'Avis supprimé avec succès.'
        ], 200);
    }
}