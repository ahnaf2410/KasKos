<x-app-layout>
<div class="max-w-2xl mx-auto py-8">
    <h2 class="text-xl font-semibold mb-5">Tambah Pembayaran Patungan</h2>

    <form action="{{ route('admin.payments.store') }}" method="POST" class="bg-white rounded-lg shadow p-6 space-y-4">
        @csrf

        <div>
            <label class="block mb-1 text-sm font-medium">Tagihan</label>
            <select name="bill_id" class="w-full rounded-lg border-gray-300">
                <option value="">-- Pilih Tagihan --</option>
                @foreach($bills as $bill)
                    <option value="{{ $bill->id }}" @selected(old('bill_id')==$bill->id)>
                        {{ $bill->title }} ({{ $bill->period }})
                    </option>
                @endforeach
            </select>
            @error('bill_id') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block mb-1 text-sm font-medium">Penghuni</label>
            <select name="user_id" class="w-full rounded-lg border-gray-300">
                <option value="">-- Pilih Penghuni --</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" @selected(old('user_id')==$user->id)>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
            @error('user_id') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block mb-1 text-sm font-medium">Jumlah Bagian</label>
            <div class="relative">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">Rp</span>
                <input
                    type="text"
                    inputmode="numeric"
                    id="split_amount_display"
                    value="{{ old('split_amount') ? number_format((float) old('split_amount'), 0, ',', '.') : '' }}"
                    class="w-full rounded-lg border-gray-300 pl-10"
                    oninput="formatRupiah(this)">
                <input type="hidden" name="split_amount" id="split_amount" value="{{ old('split_amount') }}">
            </div>
            @error('split_amount') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block mb-1 text-sm font-medium">Status</label>
            <select name="status" class="w-full rounded-lg border-gray-300">
                <option value="unpaid">Belum Bayar</option>
                <option value="pending_verification">Menunggu Verifikasi</option>
                <option value="paid">Lunas</option>
            </select>
        </div>

        <div>
            <label class="block mb-1 text-sm font-medium">Catatan</label>
            <textarea name="notes" class="w-full rounded-lg border-gray-300">{{ old('notes') }}</textarea>
        </div>

        <div class="flex justify-end gap-2">
            <a href="{{ route('admin.payments.index') }}" class="px-4 py-2 rounded-lg bg-gray-200">Batal</a>
            <button class="px-4 py-2 rounded-lg bg-blue-600 text-white">Simpan</button>
        </div>
    </form>
</div>

<script>
function formatRupiah(input) {
    let raw = input.value.replace(/\D/g, '');
    document.getElementById('split_amount').value = raw;
    input.value = raw ? new Intl.NumberFormat('id-ID').format(raw) : '';
}
</script>
</x-app-layout>
