<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\PersonalPayment;
use App\Models\Payment;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TagihanController extends Controller
{
    public function index(Request $request)
    {
        $tenant = auth()->user();

        // Ambil kamar tenant
        $room = Room::where('tenant_id', $tenant->id)->first();

        // Filter berdasarkan bulan & tahun
        $month = $request->query('month', now()->format('m'));
        $year = $request->query('year', now()->format('Y'));

        // Personal Payments (Biaya Sewa) - perbulan dengan filter bulan
        $personalQuery = PersonalPayment::where('user_id', $tenant->id);

        if ($request->filled('month')) {
            $personalQuery->whereMonth('due_date', $request->month);
        }
        if ($request->filled('year')) {
            $personalQuery->whereYear('due_date', $request->year);
        }

        $personalPayments = $personalQuery->latest()->get()->map(function ($p) {
            return (object) [
                'id' => $p->id,
                'nama_tagihan' => $p->title,
                'kategori' => 'sewa',
                'keterangan' => $p->notes ?? 'Pembayaran sewa kamar',
                'total_tagihan' => $p->amount,
                'status' => $p->status,
                'jatuh_tempo' => $p->due_date,
                'tanggal_bayar' => $p->payment_date,
                'tanggal_verifikasi' => $p->verified_by ? now() : null,
                'type' => 'personal',
                'created_at' => $p->created_at,
            ];
        });

        // Patungan Payments - filter bulan
        $patunganQuery = Payment::where('user_id', $tenant->id)->with('bill');

        if ($request->filled('month')) {
            $patunganQuery->whereMonth('created_at', $request->month);
        }
        if ($request->filled('year')) {
            $patunganQuery->whereYear('created_at', $request->year);
        }

        $patunganPayments = $patunganQuery->latest()->get()->map(function ($p) {
            return (object) [
                'id' => $p->id,
                'nama_tagihan' => $p->bill->title ?? 'Tagihan Patungan',
                'kategori' => 'patungan',
                'keterangan' => 'Periode: ' . ($p->bill->period ?? '-'),
                'total_tagihan' => $p->split_amount,
                'status' => $p->status,
                'jatuh_tempo' => $p->bill->due_date ?? null,
                'tanggal_bayar' => $p->payment_date,
                'tanggal_verifikasi' => $p->verified_at ?? null,
                'type' => 'patungan',
                'created_at' => $p->created_at,
            ];
        });

        // Gabung semua tagihan
        $tagihans = $personalPayments->concat($patunganPayments)->sortByDesc(function ($t) {
            return $t->created_at ?? now();
        });

        // Filter status
        if ($request->has('status') && in_array($request->status, ['unpaid', 'pending_verification', 'paid'])) {
            $tagihans = $tagihans->where('status', $request->status);
        }

        // Ringkasan
        $totalTertundaCount = $tagihans->where('status', 'unpaid')->count();
        $totalTertundaNominal = $tagihans->where('status', 'unpaid')->sum('total_tagihan');
        $totalTerbayarNominal = $tagihans->whereIn('status', ['paid', 'pending_verification'])->sum('total_tagihan');

        return view('tenant.tagihan.index', compact(
            'tagihans',
            'totalTertundaCount',
            'totalTertundaNominal',
            'totalTerbayarNominal',
            'room',
            'month',
            'year'
        ));
    }

    public function show($id)
    {
        $tenant = auth()->user();

        // Cek di personal payments
        $payment = PersonalPayment::where('id', $id)
            ->where('user_id', $tenant->id)
            ->first();

        if (!$payment) {
            // Cek di patungan payments
            $payment = Payment::where('id', $id)
                ->where('user_id', $tenant->id)
                ->with('bill')
                ->first();
        }

        if (!$payment) {
            return redirect()->route('tenant.tagihan.index')->with('error', 'Tagihan tidak ditemukan.');
        }

        return view('tenant.tagihan.show', compact('payment'));
    }

    public function bayar(Request $request, $id)
    {
        $request->validate([
            'payment_slip' => 'required|image|max:2048',
            'bank_account' => 'nullable|string|max:255',
        ]);

        $tenant = auth()->user();

        // Cek personal payment
        $payment = PersonalPayment::where('id', $id)
            ->where('user_id', $tenant->id)
            ->first();

        if ($payment) {
            $path = $request->file('payment_slip')->store('bukti-pembayaran', 'public');
            $payment->update([
                'payment_slip' => $path,
                'payment_date' => now(),
                'status' => 'pending_verification',
            ]);

            return redirect()->route('tenant.tagihan.index')
                ->with('success', 'Bukti pembayaran berhasil diupload, menunggu verifikasi admin.');
        }

        // Cek payment patungan
        $paymentPatungan = Payment::where('id', $id)
            ->where('user_id', $tenant->id)
            ->first();

        if ($paymentPatungan) {
            $path = $request->file('payment_slip')->store('bukti-pembayaran', 'public');
            $paymentPatungan->update([
                'payment_slip' => $path,
                'payment_date' => now(),
                'status' => 'pending_verification',
            ]);

            return redirect()->route('tenant.tagihan.index')
                ->with('success', 'Bukti pembayaran berhasil diupload, menunggu verifikasi admin.');
        }

        return redirect()->back()->with('error', 'Tagihan tidak ditemukan.');
    }
}
