<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
/**
 * @OA\Info(title="My Super Application API", version="1.0.0")
 */
class MessageController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/messages",
     *     @OA\Response(response="200", description="Display a listing of messages")
     * )
     */
    public function index()
    {
        $messages = Message::all();
        return response()->json($messages);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/messages",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="sender_id", type="integer"),
     *             @OA\Property(property="receiver_id", type="integer"),
     *             @OA\Property(property="property_id", type="integer"),
     *             @OA\Property(property="room_id", type="integer"),
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="type", type="string"),
     *             @OA\Property(property="status", type="string")
     *         )
     *     ),
     *     @OA\Response(response="201", description="Store a newly created message")
     * )
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'sender_id' => 'required|exists:users,id',
            'receiver_id' => 'required|exists:users,id',
            'property_id' => 'required|exists:properties,id',
            'room_id' => 'required|exists:rooms,id',
            'message' => 'required|string',
            'type' => 'required|string|max:50',
            'status' => 'required|in:seen,unseen',
        ]);

        $message = Message::create($validatedData);
        return response()->json($message, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/messages/{id}",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Display the specified message")
     * )
     */
    public function show($id)
    {
        $message = Message::find($id);
        if ($message) {
            return response()->json($message);
        } else {
            return response()->json(['message' => 'Message not found'], 404);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/v1/messages/{id}",
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
     *             @OA\Property(property="sender_id", type="integer"),
     *             @OA\Property(property="receiver_id", type="integer"),
     *             @OA\Property(property="property_id", type="integer"),
     *             @OA\Property(property="room_id", type="integer"),
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="type", type="string"),
     *             @OA\Property(property="status", type="string")
     *         )
     *     ),
     *     @OA\Response(response="200", description="Update the specified message")
     * )
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'sender_id' => 'required|exists:users,id',
            'receiver_id' => 'required|exists:users,id',
            'property_id' => 'required|exists:properties,id',
            'room_id' => 'required|exists:rooms,id',
            'message' => 'required|string',
            'type' => 'required|string|max:50',
            'status' => 'required|in:seen,unseen',
        ]);

        $message = Message::find($id);
        if ($message) {
            $message->update($validatedData);
            return response()->json($message);
        } else {
            return response()->json(['message' => 'Message not found'], 404);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/messages/{id}",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="204", description="Remove the specified message")
     * )
     */
    public function destroy($id)
    {
        $message = Message::find($id);
        if ($message) {
            $message->delete();
            return response()->json(null, 204);
        } else {
            return response()->json(['message' => 'Message not found'], 404);
        }
    }
}
