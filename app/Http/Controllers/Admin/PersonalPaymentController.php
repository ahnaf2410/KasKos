<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PersonalPayment;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;

class PersonalPaymentController extends Controller
{
    public function index(Request $request)
    {
        $payments = PersonalPayment::with(['room', 'user'])
            ->search($request->search)
            ->when(
                $request->status,
                fn($q) => $q->where('status', $request->status)
            )
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.personal-payments.index', compact('payments'));
    }

    public function create()
    {
        return view('admin.personal-payments.create', [
            'rooms' => Room::orderBy('room_number')->get(),
            'users' => User::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_id' => ['required', 'exists:rooms,id'],
            'user_id' => ['required', 'exists:users,id'],
            'title' => ['required', 'string', 'max:255'],
            'due_date' => ['required', 'date'],
            'status' => ['required'],
            'notes' => ['nullable'],
        ]);

        $room = Room::findOrFail($validated['room_id']);

        PersonalPayment::create([
            'room_id' => $validated['room_id'],
            'user_id' => $validated['user_id'],
            'title' => $validated['title'],

            // otomatis mengambil harga kamar
            'amount' => $room->rental_price,

            'due_date' => $validated['due_date'],
            'status' => $validated['status'],
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()
            ->route('admin.personal-payments.index')
            ->with('success', 'Payment pribadi berhasil ditambahkan.');
    }

    public function show(PersonalPayment $personalPayment)
    {
        $personalPayment->load(['room','user','verifier']);

        return view(
            'admin.personal-payments.show',
            compact('personalPayment')
        );
    }

    public function edit(PersonalPayment $personalPayment)
    {
        return view('admin.personal-payments.edit', [
            'personalPayment' => $personalPayment,
            'rooms' => Room::orderBy('room_number')->get(),
            'users' => User::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, PersonalPayment $personalPayment)
    {
        $validated = $request->validate([
            'room_id' => ['required','exists:rooms,id'],
            'user_id' => ['required','exists:users,id'],
            'title' => ['required'],
            'due_date' => ['required','date'],
            'status' => ['required'],
            'notes' => ['nullable'],
        ]);

        $room = Room::findOrFail($validated['room_id']);

        $personalPayment->update([
            'room_id' => $validated['room_id'],
            'user_id' => $validated['user_id'],
            'title' => $validated['title'],

            // otomatis update nominal
            'amount' => $room->rental_price,

            'due_date' => $validated['due_date'],
            'status' => $validated['status'],
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()
            ->route('admin.personal-payments.index')
            ->with('success', 'Payment pribadi berhasil diperbarui.');
    }

    public function destroy(PersonalPayment $personalPayment)
    {
        $personalPayment->delete();

        return redirect()
            ->route('admin.personal-payments.index')
            ->with('success', 'Payment pribadi berhasil dihapus.');
    }
}
