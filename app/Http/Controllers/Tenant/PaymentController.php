<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    /**
     * Riwayat + status pembayaran patungan milik tenant yang login.
     */
    public function index()
    {
        $payments = Payment::with('bill')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('tenant.payments.index', compact('payments'));
    }

    /**
     * Form upload bukti pertama kali, untuk 1 payment spesifik.
     * Diakses lewat ?payment={id} dari tombol "Upload" di index.
     */
    public function create(Request $request)
    {
        $payment = Payment::with('bill')
            ->where('id', $request->query('payment'))
            ->where('user_id', Auth::id())
            ->firstOrFail();

        abort_if($payment->status === 'paid', 403, 'Pembayaran ini sudah lunas dan terverifikasi.');

        return view('tenant.payments.create', compact('payment'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'payment_id' => ['required', 'exists:payments,id'],
            'payment_slip' => ['required', 'image', 'max:2048'],
        ]);

        $payment = Payment::where('id', $validated['payment_id'])
            ->where('user_id', Auth::id())
            ->firstOrFail();

        abort_if($payment->status === 'paid', 403, 'Pembayaran ini sudah lunas dan terverifikasi.');

        $path = $request->file('payment_slip')->store('bukti-pembayaran', 'public');

        $payment->update([
            'payment_slip' => $path,
            'payment_date' => now(),
            'status' => 'pending_verification',
        ]);

        return redirect()
            ->route('tenant.payments.index')
            ->with('success', 'Bukti pembayaran berhasil diupload, menunggu verifikasi admin.');
    }

    /**
     * Preview bukti pembayaran + detail status.
     */
    public function show(Payment $payment)
    {
        abort_unless($payment->user_id === Auth::id(), 403);

        $payment->load('bill', 'verifier');

        return view('tenant.payments.show', compact('payment'));
    }

    /**
     * Form ganti bukti pembayaran, hanya boleh sebelum diverifikasi admin.
     */
    public function edit(Payment $payment)
    {
        abort_unless($payment->user_id === Auth::id(), 403);
        abort_if($payment->status === 'paid', 403, 'Bukti tidak dapat diubah karena sudah diverifikasi admin.');

        $payment->load('bill');

        return view('tenant.payments.edit', compact('payment'));
    }

    public function update(Request $request, Payment $payment)
    {
        abort_unless($payment->user_id === Auth::id(), 403);
        abort_if($payment->status === 'paid', 403, 'Bukti tidak dapat diubah karena sudah diverifikasi admin.');

        $validated = $request->validate([
            'payment_slip' => ['required', 'image', 'max:2048'],
        ]);

        if ($payment->payment_slip) {
            Storage::disk('public')->delete($payment->payment_slip);
        }

        $path = $request->file('payment_slip')->store('bukti-pembayaran', 'public');

        $payment->update([
            'payment_slip' => $path,
            'payment_date' => now(),
            'status' => 'pending_verification',
        ]);

        return redirect()
            ->route('tenant.payments.index')
            ->with('success', 'Bukti pembayaran berhasil diperbarui.');
    }

    /**
     * Hapus bukti pembayaran, hanya boleh sebelum diverifikasi admin.
     * Payment row tidak dihapus (itu tetap milik Auto Split), hanya bukti & status di-reset.
     */
    public function destroy(Payment $payment)
    {
        abort_unless($payment->user_id === Auth::id(), 403);
        abort_if($payment->status === 'paid', 403, 'Bukti tidak dapat dihapus karena sudah diverifikasi admin.');

        if ($payment->payment_slip) {
            Storage::disk('public')->delete($payment->payment_slip);
        }

        $payment->update([
            'payment_slip' => null,
            'payment_date' => null,
            'status' => 'unpaid',
        ]);

        return redirect()
            ->route('tenant.payments.index')
            ->with('success', 'Bukti pembayaran berhasil dihapus.');
    }
}
