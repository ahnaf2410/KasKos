@extends('layouts.app', ['activePage' => 'kategori-tagihan', 'searchPlaceholder' => $searchPlaceholder ?? 'Cari kamar atau penyewa...'])

@section('content')
<div class="space-y-6">

    @if(session('success'))
        <div class="p-4 mb-4 text-sm text-emerald-800 rounded-2xl bg-emerald-50 border border-emerald-100 flex items-center space-x-2">
            <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-900">Kategori Tagihan</h2>
            <p class="text-sm text-slate-500">Atur pengelompokan biaya operasional dan tagihan penyewa.</p>
        </div>
        <div>
            <button type="button"
                    onclick="openCategoryModal()"
                    class="inline-flex items-center space-x-2 px-4 py-2 bg-[#a22a36] hover:bg-red-800 text-white text-sm font-semibold rounded-xl shadow-sm transition duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>Tambah Kategori</span>
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($categories as $category)
            @php
                $nameLower = strtolower($category->category_name);
                $tagLabel = 'Utility';

                if (str_contains($nameLower, 'wifi') || str_contains($nameLower, 'internet')) {
                    $tagLabel = 'Layanan';
                } elseif (str_contains($nameLower, 'bersih') || str_contains($nameLower, 'clean') || str_contains($nameLower, 'sehat')) {
                    $tagLabel = 'Iuran';
                } elseif (str_contains($nameLower, 'park')) {
                    $tagLabel = 'Opsional';
                }
            @endphp

            <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm flex flex-col justify-between hover:shadow-md transition duration-200">
                <div class="flex-1">
                    <div class="flex items-start justify-between gap-2">
                        <h4 class="font-bold text-slate-800 text-base">
                            {{ $category->category_name == 'Electricity' ? 'Listrik' : ($category->category_name == 'Wifi' ? 'Internet & WiFi' : ($category->category_name == 'Water' ? 'Air Bersih' : $category->category_name)) }}
                        </h4>

                        <div class="flex items-center space-x-1">
                            <!-- Tombol Edit -->
                            <button type="button"
                                    onclick="openEditModal({{ $category->id }}, '{{ addslashes($category->category_name) }}', {{ $category->price ?? 0 }}, {{ $category->default_active }})"
                                    class="p-1 text-slate-400 hover:text-amber-500 hover:bg-slate-50 rounded-lg transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </button>

                            <!-- Tombol Hapus (Remove Card) -->
                            <form action="{{ route('admin.bill-categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori tagihan ini?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1 text-slate-400 hover:text-red-600 hover:bg-slate-50 rounded-lg transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Tampilan Kolom Harga -->
                    <div class="mt-4 bg-slate-50 px-3 py-1.5 rounded-xl border border-slate-100 flex items-center justify-between">
                        <span class="text-[11px] font-medium text-slate-400">Harga Standar:</span>
                        <span class="text-xs font-bold text-slate-700">Rp {{ number_format($category->price ?? 0, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="border-t border-slate-100 mt-4 pt-4 flex items-center justify-between">
                    <div class="flex items-center text-slate-400">
                        <span class="text-xs font-semibold text-slate-500">{{ $tagLabel }}</span>
                    </div>

                    <div class="flex items-center space-x-2">
                        <span class="text-xs text-slate-400 font-medium">Default Aktif</span>
                        <form action="{{ route('admin.bill-categories.toggle', $category->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none {{ $category->default_active == 1 ? 'bg-[#00bda5]' : 'bg-slate-200' }}">
                                <span class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow transition duration-200 {{ $category->default_active == 1 ? 'translate-x-5' : 'translate-x-0' }}"></span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach

        <div onclick="openCategoryModal()"
             class="border-2 border-dashed border-slate-200 rounded-2xl p-6 bg-indigo-50/5 flex flex-col items-center justify-center text-center cursor-pointer hover:bg-indigo-50/20 transition duration-200 min-h-[120px] group">
            <h4 class="font-bold text-slate-700 text-sm">Kategori Baru</h4>
            <p class="text-[11px] text-slate-400 mt-1">Klik untuk menambah entitas baru</p>
        </div>
    </div>

    <!-- Tabel Riwayat Perubahan -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden mt-8">
        <div class="px-6 py-4 bg-[#f8fafc] border-b border-slate-100">
            <h3 class="text-sm font-bold text-slate-800">Riwayat Perubahan</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-100 bg-white">
                        <th class="px-6 py-3.5 text-[10px] font-bold text-slate-400 tracking-wider uppercase">KATEGORI</th>
                        <th class="px-6 py-3.5 text-[10px] font-bold text-slate-400 tracking-wider uppercase">HARGA LAMA</th>
                        <th class="px-6 py-3.5 text-[10px] font-bold text-slate-400 tracking-wider uppercase">HARGA BARU</th>
                        <th class="px-6 py-3.5 text-[10px] font-bold text-slate-400 tracking-wider uppercase">ADMIN</th>
                        <th class="px-6 py-3.5 text-[10px] font-bold text-slate-400 tracking-wider uppercase">WAKTU</th>
                        <th class="px-6 py-3.5 text-[10px] font-bold text-slate-400 tracking-wider uppercase">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 text-sm">
                    @forelse($logs as $log)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="px-6 py-4 font-bold text-slate-800">{{ $log->category_name }}</td>
                            <td class="px-6 py-4 text-slate-600 text-xs">{{ $log->old_price ? 'Rp ' . number_format($log->old_price, 0, ',', '.') : '-' }}</td>
                            <td class="px-6 py-4 text-slate-800 text-xs font-semibold">{{ $log->new_price ? 'Rp ' . number_format($log->new_price, 0, ',', '.') : '-' }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $log->admin_name }}</td>
                            <td class="px-6 py-4 text-slate-400 text-xs">{{ $log->created_at->diffForHumans() }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 rounded text-[10px] font-extrabold bg-indigo-50 text-indigo-600 border border-indigo-100">
                                    {{ $log->action }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-slate-400 text-xs italic">
                                Belum ada riwayat aktivitas perubahan data.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Terintegrasi Dinamis[cite: 1] -->
        @if(method_exists($logs, 'hasPages') && $logs->hasPages())
            <div class="px-6 py-4 border-t border-slate-100 bg-white">
                {{ $logs->appends(request()->query())->links() }}
            </div>
        @endif
    </div>

    <!-- Modal Tambah Kategori Baru -->
    <div id="createCategoryModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
        <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm" onclick="closeCategoryModal()"></div>

        <div class="flex min-h-full items-center justify-center p-4 text-center">
            <div class="relative w-full max-w-xl transform overflow-hidden rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all">

                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">Tambah Kategori Baru</h3>
                        <p class="text-xs text-slate-400 mt-0.5">Buat kelompok iuran atau operasional baru.</p>
                    </div>
                    <button type="button" onclick="closeCategoryModal()" class="text-slate-400 hover:text-slate-600 text-xs font-semibold transition">
                        Tutup
                    </button>
                </div>

                <form action="{{ route('admin.bill-categories.store') }}" method="POST" class="mt-5 space-y-5">
                    @csrf
                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-slate-700 block">Nama Kategori</label>
                        <input type="text" name="category_name" value="{{ old('category_name') }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm" placeholder="Contoh: Kebersihan, Keamanan, Listrik">
                        @error('category_name')<p class="text-[11px] font-semibold text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-slate-700 block">Harga / Biaya (Rp)</label>
                        <input type="number" name="price" value="{{ old('price') }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm" placeholder="Contoh: 50000">
                        @error('price')<p class="text-[11px] font-semibold text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="p-3.5 bg-slate-50 rounded-xl flex items-center justify-between border border-slate-100">
                        <div>
                            <span class="text-xs font-bold text-slate-700 block">Default Aktif</span>
                            <span class="text-[11px] text-slate-400">Otomatis terpasang aktif pada kamar baru.</span>
                        </div>
                        <div>
                            <input type="hidden" id="default_active_input" name="default_active" value="1">
                            <button type="button" id="toggle_button" onclick="toggleActiveState()" class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 bg-[#00bda5]">
                                <span id="toggle_circle" class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow transition duration-200 translate-x-5"></span>
                            </button>
                        </div>
                    </div>

                    <div class="border-t border-slate-100 pt-4 mt-6 flex items-center justify-end space-x-2.5">
                        <button type="button" onclick="closeCategoryModal()" class="px-4 py-2 bg-slate-100 text-slate-600 text-xs font-bold rounded-xl transition">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-[#a22a36] hover:bg-red-800 text-white text-xs font-bold rounded-xl shadow-sm transition">Simpan Kategori</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- Modal Edit Kategori -->
    <div id="editCategoryModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
        <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm" onclick="closeEditModal()"></div>

        <div class="flex min-h-full items-center justify-center p-4 text-center">
            <div class="relative w-full max-w-xl transform overflow-hidden rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all">

                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">Edit Kategori Tagihan</h3>
                        <p class="text-xs text-slate-400 mt-0.5">Ubah informasi kelompok operasional/iuran.</p>
                    </div>
                    <button type="button" onclick="closeEditModal()" class="text-slate-400 hover:text-slate-600 text-xs font-semibold transition">
                        Tutup
                    </button>
                </div>

                <form id="editCategoryForm" method="POST" action="" class="mt-5 space-y-5">
                    @csrf
                    @method('PUT')

                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-slate-700 block">Nama Kategori</label>
                        <input type="text" id="edit_category_name" name="category_name" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm" required>
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-slate-700 block">Harga / Biaya (Rp)</label>
                        <input type="number" id="edit_price" name="price" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm" required>
                    </div>

                    <div class="p-3.5 bg-slate-50 rounded-xl flex items-center justify-between border border-slate-100">
                        <div>
                            <span class="text-xs font-bold text-slate-700 block">Default Aktif</span>
                            <span class="text-[11px] text-slate-400">Otomatis terpasang aktif pada kamar baru.</span>
                        </div>
                        <div>
                            <input type="hidden" id="edit_default_active_input" name="default_active" value="1">
                            <button type="button" id="edit_toggle_button" onclick="toggleEditActiveState()" class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 bg-[#00bda5]">
                                <span id="edit_toggle_circle" class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow transition duration-200 translate-x-5"></span>
                            </button>
                        </div>
                    </div>

                    <div class="border-t border-slate-100 pt-4 mt-6 flex items-center justify-end space-x-2.5">
                        <button type="button" onclick="closeEditModal()" class="px-4 py-2 bg-slate-100 text-slate-600 text-xs font-bold rounded-xl transition">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-[#a22a36] hover:bg-red-800 text-white text-xs font-bold rounded-xl shadow-sm transition">Simpan Perubahan</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

</div>

<script>
    function openCategoryModal() {
        document.getElementById('createCategoryModal').classList.remove('hidden');
    }

    function openEditModal(id, name, price, defaultActive) {
        let form = document.getElementById('editCategoryForm');

        // Menggunakan teknik penukaran string route untuk menjamin URL terbuat dengan struktur akurat
        let routeUrl = "{{ route('admin.bill-categories.update', ':id') }}";
        form.action = routeUrl.replace(':id', id);

        document.getElementById('edit_category_name').value = name;
        document.getElementById('edit_price').value = price;

        const input = document.getElementById('edit_default_active_input');
        const btn = document.getElementById('edit_toggle_button');
        const circle = document.getElementById('edit_toggle_circle');

        input.value = defaultActive;
        if (defaultActive == "1") {
            btn.className = "relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 bg-[#00bda5]";
            circle.className = "pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow transition duration-200 translate-x-5";
        } else {
            btn.className = "relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 bg-slate-200";
            circle.className = "pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow transition duration-200 translate-x-0";
        }

        document.getElementById('editCategoryModal').classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('editCategoryModal').classList.add('hidden');
    }

    function closeCategoryModal() {
        document.getElementById('createCategoryModal').classList.add('hidden');
    }

    function toggleActiveState() {
        const input = document.getElementById('default_active_input');
        const btn = document.getElementById('toggle_button');
        const circle = document.getElementById('toggle_circle');

        if (input.value == "1") {
            input.value = "0";
            btn.classList.replace('bg-[#00bda5]', 'bg-slate-200');
            circle.classList.replace('translate-x-5', 'translate-x-0');
        } else {
            input.value = "1";
            btn.classList.replace('bg-slate-200', 'bg-[#00bda5]');
            circle.classList.replace('translate-x-0', 'translate-x-5');
        }
    }

    function toggleEditActiveState() {
        const input = document.getElementById('edit_default_active_input');
        const btn = document.getElementById('edit_toggle_button');
        const circle = document.getElementById('edit_toggle_circle');

        if (input.value == "1") {
            input.value = "0";
            btn.classList.replace('bg-[#00bda5]', 'bg-slate-200');
            circle.classList.replace('translate-x-5', 'translate-x-0');
        } else {
            input.value = "1";
            btn.classList.replace('bg-slate-200', 'bg-[#00bda5]');
            circle.classList.replace('translate-x-0', 'translate-x-5');
        }
    }

    @if($errors->any())
        openCategoryModal();
    @endif
</script>
@endsection
