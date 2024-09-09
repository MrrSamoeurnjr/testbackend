<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
/**
 * @OA\Info(title="My Super Application API", version="1.0.0")
 */
class PaymentController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/payments",
     *     @OA\Response(response="200", description="Display a listing of payments")
     * )
     */
    public function index()
    {
        $payments = Payment::all();
        return response()->json($payments);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/payments",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="booking_id", type="integer"),
     *             @OA\Property(property="user_id", type="integer"),
     *             @OA\Property(property="paid_amount", type="number"),
     *             @OA\Property(property="total", type="number"),
     *             @OA\Property(property="methods", type="string"),
     *             @OA\Property(property="status", type="string")
     *         )
     *     ),
     *     @OA\Response(response="201", description="Store a newly created payment")
     * )
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'user_id' => 'required|exists:users,id',
            'paid_amount' => 'required|numeric',
            'total' => 'required|numeric',
            'methods' => 'required|in:cash,credit_card',
            'status' => 'required|in:unpaid,indebted,paid_off',
        ]);

        $payment = Payment::create($validatedData);
        return response()->json($payment, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/payments/{id}",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Display the specified payment")
     * )
     */
    public function show($id)
    {
        $payment = Payment::find($id);
        if ($payment) {
            return response()->json($payment);
        } else {
            return response()->json(['message' => 'Payment not found'], 404);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/v1/payments/{id}",
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
     *             @OA\Property(property="booking_id", type="integer"),
     *             @OA\Property(property="user_id", type="integer"),
     *             @OA\Property(property="paid_amount", type="number"),
     *             @OA\Property(property="total", type="number"),
     *             @OA\Property(property="methods", type="string"),
     *             @OA\Property(property="status", type="string")
     *         )
     *     ),
     *     @OA\Response(response="200", description="Update the specified payment")
     * )
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'user_id' => 'required|exists:users,id',
            'paid_amount' => 'required|numeric',
            'total' => 'required|numeric',
            'methods' => 'required|in:cash,credit_card',
            'status' => 'required|in:unpaid,indebted,paid_off',
        ]);

        $payment = Payment::find($id);
        if ($payment) {
            $payment->update($validatedData);
            return response()->json($payment);
        } else {
            return response()->json(['message' => 'Payment not found'], 404);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/payments/{id}",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="204", description="Remove the specified payment")
     * )
     */
    public function destroy($id)
    {
        $payment = Payment::find($id);
        if ($payment) {
            $payment->delete();
            return response()->json(null, 204);
        } else {
            return response()->json(['message' => 'Payment not found'], 404);
        }
    }
}
