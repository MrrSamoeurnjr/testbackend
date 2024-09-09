<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

/**
 * @OA\Info(title="My Super Application API", version="1.0.0")
 */
class ReviewController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/reviews",
     *     @OA\Response(response="200", description="Display a listing of reviews")
     * )
     */
    public function index()
    {
        $reviews = Review::all();
        return response()->json($reviews);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/reviews",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="user_id", type="integer"),
     *             @OA\Property(property="property_id", type="integer"),
     *             @OA\Property(property="rating", type="integer"),
     *             @OA\Property(property="comment", type="string")
     *         )
     *     ),
     *     @OA\Response(response="201", description="Store a newly created review")
     * )
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'property_id' => 'required|exists:properties,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        $review = Review::create($validatedData);

        return response()->json($review, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/reviews/{id}",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Display the specified review")
     * )
     */
    public function show($id)
    {
        $review = Review::findOrFail($id);
        return response()->json($review);
    }

    /**
     * @OA\Put(
     *     path="/api/v1/reviews/{id}",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="user_id", type="integer"),
     *             @OA\Property(property="property_id", type="integer"),
     *             @OA\Property(property="rating", type="integer"),
     *             @OA\Property(property="comment", type="string")
     *         )
     *     ),
     *     @OA\Response(response="200", description="Update the specified review")
     * )
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'property_id' => 'required|exists:properties,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        $review = Review::findOrFail($id);
        $review->update($validatedData);

        return response()->json($review);
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/reviews/{id}",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="204", description="Remove the specified review")
     * )
     */
    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        return response()->json(null, 204);
    }
}
