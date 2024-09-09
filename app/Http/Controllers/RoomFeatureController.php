<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RoomFeature;
/**
 * @OA\Info(title="My Super Application API", version="1.0.0")
 */
class RoomFeatureController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/room-features",
     *     @OA\Response(response="200", description="Display a listing of room features")
     * )
     */
    public function index()
    {
        $roomFeatures = RoomFeature::all();
        return response()->json($roomFeatures);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/room-features",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="property_id", type="integer"),
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="status", type="string")
     *         )
     *     ),
     *     @OA\Response(response="201", description="Store a newly created room feature")
     * )
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'name' => 'required|string|max:255',
            'status' => 'required|string|max:50',
        ]);

        $roomFeature = RoomFeature::create($validatedData);

        return response()->json($roomFeature, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/room-features/{id}",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Display the specified room feature")
     * )
     */
    public function show($id)
    {
        $roomFeature = RoomFeature::findOrFail($id);
        return response()->json($roomFeature);
    }

    /**
     * @OA\Put(
     *     path="/api/v1/room-features/{id}",
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
     *             @OA\Property(property="property_id", type="integer"),
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="status", type="string")
     *         )
     *     ),
     *     @OA\Response(response="200", description="Update the specified room feature")
     * )
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'name' => 'required|string|max:255',
            'status' => 'required|string|max:50',
        ]);

        $roomFeature = RoomFeature::findOrFail($id);
        $roomFeature->update($validatedData);

        return response()->json($roomFeature);
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/room-features/{id}",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="204", description="Remove the specified room feature")
     * )
     */
    public function destroy($id)
    {
        $roomFeature = RoomFeature::findOrFail($id);
        $roomFeature->delete();

        return response()->json(null, 204);
    }
}
