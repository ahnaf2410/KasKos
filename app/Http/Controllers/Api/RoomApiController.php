<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Http\Resources\RoomResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoomApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rooms = Room::with('tenant')->paginate(10);
        return RoomResource::collection($rooms);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'room_number'  => 'required|string|unique:rooms,room_number',
            'floor'        => 'required|integer',
            'rental_price' => 'required|numeric',
            'status'       => 'required|string',
            'tenant_id'    => 'nullable|exists:users,id',
            'description'  => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors'  => $validator->errors()
            ], 422);
        }

        $room = Room::create($request->all());

        return response()->json([
            'message' => 'Room created successfully',
            'data'    => new RoomResource($room)
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $room = Room::with('tenant')->find($id);

        if (!$room) {
            return response()->json(['message' => 'Room not found'], 404);
        }

        return new RoomResource($room);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $room = Room::find($id);

        if (!$room) {
            return response()->json(['message' => 'Room not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'room_number'  => 'sometimes|required|string|unique:rooms,room_number,' . $room->id,
            'floor'        => 'sometimes|required|integer',
            'rental_price' => 'sometimes|required|numeric',
            'status'       => 'sometimes|required|string',
            'tenant_id'    => 'nullable|exists:users,id',
            'description'  => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors'  => $validator->errors()
            ], 422);
        }

        $room->update($request->all());

        return response()->json([
            'message' => 'Room updated successfully',
            'data'    => new RoomResource($room->load('tenant'))
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $room = Room::find($id);

        if (!$room) {
            return response()->json(['message' => 'Room not found'], 404);
        }

        $room->delete();

        return response()->json(['message' => 'Room deleted successfully'], 200);
    }

    /**
     * Get the renting history of a specific room.
     */
    public function history($id)
    {
        // 1. Cek apakah room-nya ada di database
        $room = Room::find($id);

        if (!$room) {
            return response()->json([
                'message' => 'Room not found'
            ], 404);
        }

        // 2. Ambil semua riwayat dari room tersebut dari tabel room_histories
        $history = \App\Models\RoomHistory::where('room_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        // 3. Kembalikan response JSON
        return response()->json([
            'room_number' => $room->room_number,
            'history'     => $history
        ], 200);
    }
}
