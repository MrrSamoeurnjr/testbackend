<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
/**
 * @OA\Info(title="My Super Application API", version="1.0.0")
 */
class PropertyController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/properties",
     *     @OA\Response(response="200", description="Display a listing of properties")
     * )
     */
    public function index()
    {
        $properties = Property::all();
        return response()->json($properties);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/properties",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="user_id", type="integer"),
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="address", type="string"),
     *             @OA\Property(property="photos", type="string"),
     *             @OA\Property(property="latitude_longitude", type="string"),
     *             @OA\Property(property="policy", type="string"),
     *             @OA\Property(property="amount", type="number"),
     *             @OA\Property(property="require_deposit", type="boolean")
     *         )
     *     ),
     *     @OA\Response(response="201", description="Store a newly created property")
     * )
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'photos' => 'required|string',
            'latitude_longitude' => 'required|json',
            'policy' => 'required|string',
            'amount' => 'required|numeric',
            'require_deposit' => 'required|boolean',
        ]);

        $property = Property::create($validatedData);

        return response()->json($property, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/properties/{id}",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Display the specified property")
     * )
     */
    public function show($id)
    {
        $property = Property::findOrFail($id);
        return response()->json($property);
    }

    /**
     * @OA\Put(
     *     path="/api/v1/properties/{id}",
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
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="address", type="string"),
     *             @OA\Property(property="photos", type="string"),
     *             @OA\Property(property="latitude_longitude", type="string"),
     *             @OA\Property(property="policy", type="string"),
     *             @OA\Property(property="amount", type="number"),
     *             @OA\Property(property="require_deposit", type="boolean")
     *         )
     *     ),
     *     @OA\Response(response="200", description="Update the specified property")
     * )
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'photos' => 'required|string',
            'latitude_longitude' => 'required|json',
            'policy' => 'required|string',
            'amount' => 'required|numeric',
            'require_deposit' => 'required|boolean',
        ]);

        $property = Property::findOrFail($id);
        $property->update($validatedData);

        return response()->json($property);
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/properties/{id}",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="204", description="Remove the specified property")
     * )
     */
    public function destroy($id)
    {
        $property = Property::findOrFail($id);
        $property->delete();

        return response()->json(null, 204);
    }
}
