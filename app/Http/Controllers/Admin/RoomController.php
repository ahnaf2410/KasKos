<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoomRequest;
use App\Models\Room;
use Illuminate\Http\Request;
use App\Models\User;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
  public function index(Request $request)
{
    $rooms = Room::with('tenant')
        ->when($request->search, function ($query) use ($request) {
            $query->where('room_number', 'like', '%' . $request->search . '%')
                  ->orWhereHas('tenant', function ($q) use ($request) {
                      $q->where('name', 'like', '%' . $request->search . '%');
                  });
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
    $tenants = User::role('Tenant')->get();

    return view('admin.rooms.create', compact('tenants'));
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoomRequest $request)
    {
        $data = $request->validated();

$data['status'] = $data['tenant_id']
    ? 'occupied'
    : 'vacant';

Room::create($data);
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
    $tenants = User::role('Tenant')->get();

    return view('admin.rooms.edit', compact('room','tenants'));
}

    /**
     * Update the specified resource in storage.
     */
    public function update(RoomRequest $request, Room $room)
    {
        $data = $request->validated();

$data['status'] = $data['tenant_id']
    ? 'occupied'
    : 'vacant';

$room->update($data);
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

    public function clear(Room $room)
{
    $room->update([
        'tenant_id' => null,
        'status' => 'vacant'
    ]);

    return back()->with('success', 'Kamar berhasil dikosongkan');
}
}