<?php

namespace App\Http\Controllers;
use App\Models\Floor;
use Illuminate\Http\Request;

/**
 * @OA\Info(title="My Super Application API", version="1.0.0")
 */
class FloorController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/floors",
     *     @OA\Response(response="200", description="Display a listing of floors")
     * )
     */
    public function index()
    {
        $floors = Floor::all();
        return response()->json($floors);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/floors",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="property_id", type="integer"),
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="status", type="string")
     *         )
     *     ),
     *     @OA\Response(response="201", description="Store a newly created floor")
     * )
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|string|max:50',
        ]);

        $floor = Floor::create($validatedData);
        return response()->json($floor, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/floors/{id}",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Display the specified floor")
     * )
     */
    public function show($id)
    {
        $floor = Floor::find($id);
        if ($floor) {
            return response()->json($floor);
        } else {
            return response()->json(['message' => 'Floor not found'], 404);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/v1/floors/{id}",
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
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="status", type="string")
     *         )
     *     ),
     *     @OA\Response(response="200", description="Update the specified floor")
     * )
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|string|max:50',
        ]);

        $floor = Floor::find($id);
        if ($floor) {
            $floor->update($validatedData);
            return response()->json($floor);
        } else {
            return response()->json(['message' => 'Floor not found'], 404);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/floors/{id}",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="204", description="Remove the specified floor")
     * )
     */
    public function destroy($id)
    {
        $floor = Floor::find($id);
        if ($floor) {
            $floor->delete();
            return response()->json(null, 204);
        } else {
            return response()->json(['message' => 'Floor not found'], 404);
        }
    }
}
