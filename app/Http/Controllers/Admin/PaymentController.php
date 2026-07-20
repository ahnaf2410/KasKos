<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Payment;
use App\Models\User;
use App\Models\Room;
use Illuminate\Http\Request;
use App\Models\BillCategory;

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
        $occupiedRoomsCount = Room::whereNotNull('tenant_id')->count();

        return view('admin.payments.create', [
            'users' => User::orderBy('name')->get(),
            'billCategories' => BillCategory::orderBy('category_name')->get(),
            'occupiedRoomsCount' => $occupiedRoomsCount,
        ]);
    }

    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'bill_id' => ['required', 'exists:bills,id'],
    //         'user_id' => ['required', 'exists:users,id'],
    //         'split_amount' => ['required', 'numeric', 'min:0'],
    //         'status' => ['required', 'in:unpaid,pending_verification,paid'],
    //         'notes' => ['nullable', 'string'],
    //     ]);

    //     Payment::create($validated);

    //     return redirect()
    //         ->route('admin.payments.index')
    //         ->with('success', 'Pembayaran patungan berhasil ditambahkan.');
    // }
    public function store(Request $request)
{
    $validated = $request->validate([
        'bill_category_id' => ['required', 'exists:bill_categories,id'],
        'status' => ['required', 'in:unpaid,pending_verification,paid'],
        'notes' => ['nullable', 'string'],
    ]);

    $billCategory = BillCategory::findOrFail($validated['bill_category_id']);
    $bill = Bill::where('bill_category_id', $validated['bill_category_id'])
        ->latest()
        ->firstOrFail();

    // Dapatkan semua tenant yang menempati kamar
    $occupiedRooms = Room::whereNotNull('tenant_id')->get();
    $tenantCount = $occupiedRooms->count();

    if ($tenantCount === 0) {
        return redirect()->back()
            ->with('error', 'Tidak ada penghuni yang menempati kamar. Pembayaran patungan tidak dapat dibuat.')
            ->withInput();
    }

    // Hitung split amount per tenant
    $splitAmount = $billCategory->price / $tenantCount;

    $createdCount = 0;
    foreach ($occupiedRooms as $room) {
        // Cek apakah sudah ada payment untuk bill ini dan user ini
        $existingPayment = Payment::where('bill_id', $bill->id)
            ->where('user_id', $room->tenant_id)
            ->first();

        if ($existingPayment) {
            continue; // Skip jika sudah ada
        }

        Payment::create([
            'bill_id' => $bill->id,
            'user_id' => $room->tenant_id,
            'split_amount' => $splitAmount,
            'status' => $validated['status'],
            'notes' => $validated['notes'] ?? 'Otomatis: ' . $billCategory->category_name . ' - ' . number_format($splitAmount, 0, ',', '.') . '/tenant',
        ]);

        $createdCount++;
    }

    return redirect()
        ->route('admin.payments.index')
        ->with('success', "Pembayaran patungan berhasil dibuat untuk {$createdCount} penghuni. Masing-masing Rp " . number_format($splitAmount, 0, ',', '.'));
}

    public function show(Payment $payment)
    {
        $payment->load(['bill', 'user', 'verifier']);

        return view('admin.payments.show', compact('payment'));
    }

    public function edit(Payment $payment)
    {
        $occupiedRoomsCount = Room::whereNotNull('tenant_id')->count();

        return view('admin.payments.edit', [
            'payment' => $payment,
            'users' => User::orderBy('name')->get(),
            'billCategories' => BillCategory::orderBy('category_name')->get(),
            'occupiedRoomsCount' => $occupiedRoomsCount,
        ]);
    }

    // public function update(Request $request, Payment $payment)
    // {
    //     $validated = $request->validate([
    //         'bill_id' => ['required', 'exists:bills,id'],
    //         'user_id' => ['required', 'exists:users,id'],
    //         'split_amount' => ['required', 'numeric', 'min:0'],
    //         'status' => ['required', 'in:unpaid,pending_verification,paid'],
    //         'notes' => ['nullable', 'string'],
    //     ]);

    //     $payment->update($validated);

    //     return redirect()
    //         ->route('admin.payments.index')
    //         ->with('success', 'Pembayaran patungan berhasil diperbarui.');
    // }

    public function update(Request $request, Payment $payment)
{
    $validated = $request->validate([
        'bill_category_id' => ['required', 'exists:bill_categories,id'],
        'status' => ['required', 'in:unpaid,pending_verification,paid'],
        'notes' => ['nullable', 'string'],
    ]);

    $bill = Bill::where('bill_category_id', $validated['bill_category_id'])
        ->latest()
        ->firstOrFail();

    $billCategory = BillCategory::findOrFail($validated['bill_category_id']);

    // Dapatkan semua tenant dan re-split
    $occupiedRooms = Room::whereNotNull('tenant_id')->get();
    $tenantCount = $occupiedRooms->count();
    $splitAmount = $tenantCount > 0 ? $billCategory->price / $tenantCount : 0;

    // Update semua payment untuk bill category ini
    $updatedCount = 0;
    foreach ($occupiedRooms as $room) {
        $existingPayment = Payment::where('bill_id', $bill->id)
            ->where('user_id', $room->tenant_id)
            ->first();

        if ($existingPayment) {
            $existingPayment->update([
                'split_amount' => $splitAmount,
                'status' => $validated['status'],
                'notes' => $validated['notes'] ?? $existingPayment->notes,
            ]);
            $updatedCount++;
        }
    }

    // Jika payment yang di-edit tidak termasuk dalam daftar (e.g. tenant sudah tidak punya kamar)
    // Update payment ini secara individual
    $payment->update([
        'bill_id' => $bill->id,
        'split_amount' => $splitAmount,
        'status' => $validated['status'],
        'notes' => $validated['notes'] ?? $payment->notes,
    ]);

    return redirect()
        ->route('admin.payments.index')
        ->with('success', "Pembayaran patungan berhasil diperbarui. Data disinkronkan untuk {$updatedCount} penghuni.");
}

    public function destroy(Payment $payment)
    {
        $payment->delete();

        return redirect()
            ->route('admin.payments.index')
            ->with('success', 'Pembayaran patungan berhasil dihapus.');
    }
}
