@extends('layouts.app', ['activePage' => 'pembayaran'])
@section('content')
<div class="max-w-2xl mx-auto py-8">
    <h2 class="text-xl font-semibold mb-5">Edit Pembayaran Patungan</h2>

    <form action="{{ route('admin.payments.update',$payment) }}" method="POST" class="bg-white rounded-lg shadow p-6 space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block mb-1 text-sm font-medium">Kategori Tagihan</label>
            <select name="bill_category_id" id="bill_category_id" class="w-full rounded-lg border-gray-300" onchange="updateSplitInfo()">
                <option value="">-- Pilih Kategori Tagihan --</option>

                @foreach($billCategories as $category)
                    <option value="{{ $category->id }}"
                        data-price="{{ $category->price }}"
                        @selected($payment->bill?->bill_category_id == $category->id)>
                        {{ $category->category_name }} (Rp {{ number_format($category->price, 0, ',', '.') }})
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Auto Split Info --}}
        <div class="p-4 bg-blue-50 border border-blue-100 rounded-lg">
            <h4 class="text-sm font-bold text-blue-800 mb-2">Informasi Pembagian Otomatis</h4>
            <div class="space-y-1 text-sm">
                <p class="text-blue-700">Jumlah penghuni aktif: <strong>{{ $occupiedRoomsCount }} kamar</strong></p>
                <p class="text-blue-700">Pembagian otomatis: <strong id="split_info_display">Pilih kategori tagihan terlebih dahulu</strong></p>
                <p class="text-xs text-blue-600 mt-2">Perubahan akan disinkronkan ke SEMUA penghuni secara otomatis.</p>
            </div>
        </div>

        <div>
            <label class="block mb-1 text-sm font-medium">Status</label>
            <select name="status" class="w-full rounded-lg border-gray-300">
                <option value="unpaid" @selected($payment->status=='unpaid')>Belum Bayar</option>
                <option value="pending_verification" @selected($payment->status=='pending_verification')>Menunggu Verifikasi</option>
                <option value="paid" @selected($payment->status=='paid')>Lunas</option>
            </select>
        </div>

        <div>
            <label class="block mb-1 text-sm font-medium">Catatan</label>
            <textarea name="notes" class="w-full rounded-lg border-gray-300">{{ $payment->notes }}</textarea>
            <p class="text-xs text-gray-400 mt-1">Catatan ini akan diterapkan ke semua tagihan penghuni.</p>
        </div>

        <div class="flex justify-end gap-2">
            <a href="{{ route('admin.payments.index') }}" class="px-4 py-2 rounded-lg bg-gray-200">Batal</a>
            <button class="px-4 py-2 rounded-lg bg-blue-600 text-white">Update & Sinkronkan</button>
        </div>
    </form>
</div>

<script>
function updateSplitInfo() {
    const select = document.getElementById('bill_category_id');
    const selected = select.options[select.selectedIndex];
    const display = document.getElementById('split_info_display');
    const occupiedCount = {{ $occupiedRoomsCount }};

    if (selected && selected.dataset.price) {
        const price = parseFloat(selected.dataset.price);
        const splitAmount = price / occupiedCount;
        display.innerHTML = 'Rp ' + new Intl.NumberFormat('id-ID').format(splitAmount) + ' / tenant (dari Rp ' + new Intl.NumberFormat('id-ID').format(price) + ' dibagi ' + occupiedCount + ' kamar)';
    } else {
        display.innerHTML = 'Pilih kategori tagihan terlebih dahulu';
    }
}

// Auto-update on page load
document.addEventListener('DOMContentLoaded', function() {
    const select = document.getElementById('bill_category_id');
    if (select.value) {
        updateSplitInfo();
    }
});
</script>
@endsection
