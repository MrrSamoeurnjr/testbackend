<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
/**
 * @OA\Info(title="My Super Application API", version="1.0.0")
 */
class RoomController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/rooms",
     *     @OA\Response(response="200", description="Display a listing of rooms")
     * )
     */
    public function index()
    {
        $rooms = Room::all();
        return response()->json($rooms);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/rooms",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="property_id", type="integer"),
     *             @OA\Property(property="floor_id", type="string"),
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="price", type="number"),
     *             @OA\Property(property="status", type="string"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="features_ids", type="string"),
     *             @OA\Property(property="size", type="number")
     *         )
     *     ),
     *     @OA\Response(response="201", description="Store a newly created room")
     * )
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'floor_id' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'status' => 'required|string|max:50',
            'description' => 'nullable|string',
            'features_ids' => 'nullable|json',
            'size' => 'required|numeric',
        ]);

        $room = Room::create($validatedData);

        return response()->json($room, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/rooms/{id}",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Display the specified room")
     * )
     */
    public function show($id)
    {
        $room = Room::findOrFail($id);
        return response()->json($room);
    }

    /**
     * @OA\Put(
     *     path="/api/v1/rooms/{id}",
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
     *             @OA\Property(property="floor_id", type="string"),
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="price", type="number"),
     *             @OA\Property(property="status", type="string"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="features_ids", type="string"),
     *             @OA\Property(property="size", type="number")
     *         )
     *     ),
     *     @OA\Response(response="200", description="Update the specified room")
     * )
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'floor_id' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'status' => 'required|string|max:50',
            'description' => 'nullable|string',
            'features_ids' => 'nullable|json',
            'size' => 'required|numeric',
        ]);

        $room = Room::findOrFail($id);
        $room->update($validatedData);

        return response()->json($room);
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/rooms/{id}",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="204", description="Remove the specified room")
     * )
     */
    public function destroy($id)
    {
        $room = Room::findOrFail($id);
        $room->delete();

        return response()->json(null, 204);
    }
}
