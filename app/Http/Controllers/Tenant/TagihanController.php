<?php

namespace App\Http\Controllers\Tenant; // 1. DIPERBAIKI: Mengikuti grup rute Tenant di web.php

use App\Http\Controllers\Controller;
use App\Models\Bill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TagihanController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil ID user tenant yang sedang login
        $userId = Auth::id();

        // 2. Tarik semua data tagihan untuk kalkulasi Box "Ringkasan Tagihan" (Selalu Akumulasi Total)
        $allTagihans = Bill::where('id', $userId)->get();

        // 3. Kalkulasi dinamis Box Ringkasan sesuai Logika UI SobatKos Anda:
        // - Sisa/Tertunda = Hanya yang berstatus 'belum_dibayar' (Sewa Bulanan + Internet = Rp 2.850.000)
        // - Terbayar = Gabungan 'lunas' dan 'menunggu_verifikasi' (Listrik + Air = Rp 427.500)
        $totalTertundaCount   = $allTagihans->where('status', 'belum_dibayar')->count();
        $totalTertundaNominal = $allTagihans->where('status', 'belum_dibayar')->sum('total_tagihan');
        $totalTerbayarNominal = $allTagihans->whereIn('status', ['lunas', 'menunggu_verifikasi'])->sum('total_tagihan');

        // 4. Fitur Filter Data Kartu (Untuk tombol: Semua, Belum Dibayar, Menunggu Verifikasi, Lunas)
        $query = Bill::where('id', $userId)->orderBy('due_date', 'asc');

        if ($request->has('status') && in_array($request->status, ['belum_dibayar', 'menunggu_verifikasi', 'lunas'])) {
            $query->where('status', $request->status);
        }

        $tagihans = $query->get();

        // 5. DIPERBAIKI: Diarahkan ke folder views/tenant/tagihan/index.blade.php
        return view('tenant.tagihan.index', compact(
            'tagihans',
            'totalTertundaCount',
            'totalTertundaNominal',
            'totalTerbayarNominal'
        ));
    }

    /**
     * Fitur Aksi: Tombol "Bayar Sekarang"
     */
    public function bayar(Request $request, $id)
    {
        $tagihan = Bill::where('id', Auth::id())->findOrFail($id);

        // Ubah status menjadi menunggu verifikasi setelah tenant menekan tombol bayar
        $tagihan->update([
            'status' => 'menunggu_verifikasi',
            'tanggal_bayar' => now() // Pastikan kolom ini tersedia di table/model Bill Anda
        ]);

        return redirect()->back()->with('success', 'Pembayaran berhasil dikirim! Menunggu verifikasi admin.');
    }

    /**
     * Fitur Aksi: Tombol "Lihat Detail" (Opsional)
     */
    public function show($id)
    {
        $tagihan = Bill::where('id', Auth::id())->findOrFail($id);
        return view('tenant.tagihan.show', compact('tagihan'));
    }
}
