<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoomRequest;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $rooms = Room::query()
            ->when($request->search, function ($query) use ($request) {
                $query->where('room_number', 'like', '%' . $request->search . '%');
            })
            ->orderBy('room_number')
            ->paginate(10)
            ->withQueryString();

        return view('admin.rooms.index', compact('rooms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.rooms.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoomRequest $request)
    {
        Room::create($request->validated());

        return redirect()
            ->route('admin.rooms.index')
            ->with('success', 'Room berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Room $room)
    {
        return view('admin.rooms.show', compact('room'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Room $room)
    {
        return view('admin.rooms.edit', compact('room'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoomRequest $request, Room $room)
    {
        $room->update($request->validated());

        return redirect()
            ->route('admin.rooms.index')
            ->with('success', 'Room berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        $room->delete();

        return redirect()
            ->route('admin.rooms.index')
            ->with('success', 'Room berhasil dihapus.');
    }
}