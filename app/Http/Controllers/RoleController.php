<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
/**
 * @OA\Info(title="My Super Application API", version="1.0.0")
 */
class RoleController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/roles",
     *     @OA\Response(response="200", description="Display a listing of roles")
     * )
     */
    public function index()
    {
        $roles = Role::all();
        return response()->json($roles);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/roles",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="permissions", type="string")
     *         )
     *     ),
     *     @OA\Response(response="201", description="Store a newly created role")
     * )
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'permissions' => 'required|string|max:255',
        ]);

        $role = Role::create($validatedData);

        return response()->json($role, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/roles/{id}",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Display the specified role")
     * )
     */
    public function show($id)
    {
        $role = Role::findOrFail($id);
        return response()->json($role);
    }

    /**
     * @OA\Put(
     *     path="/api/v1/roles/{id}",
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
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="permissions", type="string")
     *         )
     *     ),
     *     @OA\Response(response="200", description="Update the specified role")
     * )
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'permissions' => 'required|string|max:255',
        ]);

        $role = Role::findOrFail($id);
        $role->update($validatedData);

        return response()->json($role);
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/roles/{id}",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="204", description="Remove the specified role")
     * )
     */
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return response()->json(null, 204);
    }
}
