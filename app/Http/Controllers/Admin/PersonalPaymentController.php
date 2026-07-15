<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PersonalPayment;
use App\Models\User;
use Illuminate\Http\Request;

class PersonalPaymentController extends Controller
{
    public function index(Request $request)
    {
        $payments = PersonalPayment::with(['user', 'verifier'])
            ->search($request->search)

            ->when($request->status, function ($q) use ($request) {
                $q->where('status', $request->status);
            })

            ->when($request->month, function ($q) use ($request) {
                $q->whereMonth('due_date', $request->month);
            })

            ->when($request->year, function ($q) use ($request) {
                $q->whereYear('due_date', $request->year);
            })

            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.personal-payments.index', compact('payments'));
    }

    public function create()
    {
        return view('admin.personal-payments.create', [
            'users' => User::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id'   => ['required', 'exists:users,id'],
            'title'     => ['required', 'string', 'max:255'],
            'amount'    => ['required', 'numeric'],
            'due_date'  => ['required', 'date'],
            'status'    => ['required'],
            'notes'     => ['nullable'],
        ]);

        PersonalPayment::create($validated);

        return redirect()
            ->route('admin.personal-payments.index')
            ->with('success', 'Payment pribadi berhasil ditambahkan.');
    }

    public function show(PersonalPayment $personalPayment)
    {
        $personalPayment->load(['user', 'verifier']);

        return view(
            'admin.personal-payments.show',
            compact('personalPayment')
        );
    }

    public function edit(PersonalPayment $personalPayment)
    {
        return view('admin.personal-payments.edit', [
            'payment' => $personalPayment,
            'users' => User::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, PersonalPayment $personalPayment)
    {
        $validated = $request->validate([
            'user_id'   => ['required', 'exists:users,id'],
            'title'     => ['required', 'string', 'max:255'],
            'amount'    => ['required', 'numeric'],
            'due_date'  => ['required', 'date'],
            'status'    => ['required'],
            'notes'     => ['nullable'],
        ]);

        $personalPayment->update($validated);

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
