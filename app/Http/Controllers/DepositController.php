<?php

namespace App\Http\Controllers;
use App\Models\Deposit;
use Illuminate\Http\Request;

/**
 * @OA\Info(title="My Super Application API", version="1.0.0")
 */
class DepositController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/deposits",
     *     @OA\Response(response="200", description="Display a listing of deposits")
     * )
     */
    public function index()
    {
        $deposits = Deposit::all();
        return response()->json($deposits);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/deposits",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="booking_id", type="integer"),
     *             @OA\Property(property="amount", type="number"),
     *             @OA\Property(property="refunded_date", type="string", format="date")
     *         )
     *     ),
     *     @OA\Response(response="201", description="Store a newly created deposit")
     * )
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'amount' => 'required|numeric',
            'refunded_date' => 'nullable|date',
        ]);

        $deposit = Deposit::create($validatedData);
        return response()->json($deposit, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/deposits/{id}",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Display the specified deposit")
     * )
     */
    public function show($id)
    {
        $deposit = Deposit::find($id);
        if ($deposit) {
            return response()->json($deposit);
        } else {
            return response()->json(['message' => 'Deposit not found'], 404);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/v1/deposits/{id}",
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
     *             @OA\Property(property="amount", type="number"),
     *             @OA\Property(property="refunded_date", type="string", format="date")
     *         )
     *     ),
     *     @OA\Response(response="200", description="Update the specified deposit")
     * )
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'amount' => 'required|numeric',
            'refunded_date' => 'nullable|date',
        ]);

        $deposit = Deposit::find($id);
        if ($deposit) {
            $deposit->update($validatedData);
            return response()->json($deposit);
        } else {
            return response()->json(['message' => 'Deposit not found'], 404);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/deposits/{id}",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="204", description="Remove the specified deposit")
     * )
     */
    public function destroy($id)
    {
        $deposit = Deposit::find($id);
        if ($deposit) {
            $deposit->delete();
            return response()->json(null, 204);
        } else {
            return response()->json(['message' => 'Deposit not found'], 404);
        }
    }
}
