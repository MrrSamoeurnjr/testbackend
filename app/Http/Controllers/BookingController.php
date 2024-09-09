<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
/**
 * @OA\Info(title="My Super Application API", version="1.0.0")
 */
class BookingController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/bookings",
     *     @OA\Response(response="200", description="Display a listing of bookings")
     * )
     */
    public function index()
    {
        $bookings = Booking::all();
        return response()->json($bookings);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/bookings",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="user_id", type="integer"),
     *             @OA\Property(property="property_id", type="integer"),
     *             @OA\Property(property="check_in", type="string", format="date"),
     *             @OA\Property(property="check_out", type="string", format="date")
     *         )
     *     ),
     *     @OA\Response(response="201", description="Store a newly created booking")
     * )
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'property_id' => 'required|exists:properties,id',
            'check_in' => 'required|date',
            'check_out' => 'required|date',
            // Add other validation rules as needed
        ]);

        $booking = Booking::create($validatedData);

        return response()->json($booking, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/bookings/{id}",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Display the specified booking")
     * )
     */
    public function show($id)
    {
        $booking = Booking::findOrFail($id);
        return response()->json($booking);
    }

    /**
     * @OA\Put(
     *     path="/api/v1/bookings/{id}",
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
     *             @OA\Property(property="check_in", type="string", format="date"),
     *             @OA\Property(property="check_out", type="string", format="date")
     *         )
     *     ),
     *     @OA\Response(response="200", description="Update the specified booking")
     * )
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'property_id' => 'required|exists:properties,id',
            'check_in' => 'required|date',
            'check_out' => 'required|date',
            // Add other validation rules as needed
        ]);

        $booking = Booking::findOrFail($id);
        $booking->update($validatedData);

        return response()->json($booking);
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/bookings/{id}",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="204", description="Remove the specified booking")
     * )
     */
    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        return response()->json(null, 204);
    }
}
