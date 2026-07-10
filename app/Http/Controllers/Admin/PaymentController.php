<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $payments = Payment::with(['bill', 'user'])
            ->search($request->query('search'))
            ->when($request->query('status'), fn ($q, $status) => $q->where('status', $status))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.payments.index', [
            'payments' => $payments,
        ]);
    }

    public function create()
    {
        return view('admin.payments.create', [
            'bills' => Bill::orderByDesc('due_date')->get(),
            'users' => User::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'bill_id' => ['required', 'exists:bills,id'],
            'user_id' => ['required', 'exists:users,id'],
            'split_amount' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'in:unpaid,pending_verification,paid'],
            'notes' => ['nullable', 'string'],
        ]);

        Payment::create($validated);

        return redirect()
            ->route('admin.payments.index')
            ->with('success', 'Pembayaran patungan berhasil ditambahkan.');
    }

    public function show(Payment $payment)
    {
        $payment->load(['bill', 'user', 'verifier']);

        return view('admin.payments.show', compact('payment'));
    }

    public function edit(Payment $payment)
    {
        return view('admin.payments.edit', [
            'payment' => $payment,
            'bills' => Bill::orderByDesc('due_date')->get(),
            'users' => User::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'bill_id' => ['required', 'exists:bills,id'],
            'user_id' => ['required', 'exists:users,id'],
            'split_amount' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'in:unpaid,pending_verification,paid'],
            'notes' => ['nullable', 'string'],
        ]);

        $payment->update($validated);

        return redirect()
            ->route('admin.payments.index')
            ->with('success', 'Pembayaran patungan berhasil diperbarui.');
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();

        return redirect()
            ->route('admin.payments.index')
            ->with('success', 'Pembayaran patungan berhasil dihapus.');
    }
}
