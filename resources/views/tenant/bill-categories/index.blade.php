<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg bg-[#E84855] flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path d="M4 7h16M4 12h10M4 17h7" stroke-linecap="round"/>
                </svg>
            </div>
            <h2 class="font-semibold text-xl text-slate-800 leading-tight">
                {{ __('Kategori Tagihan') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12" x-data="{ modalOpen: false, selected: null }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm border border-slate-100 rounded-2xl">
                <div class="p-6">

                    <!-- Header + Search -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                        <div>
                            <h3 class="text-lg font-semibold text-slate-800">Daftar Kategori</h3>
                            <p class="text-sm text-slate-500 mt-0.5">Jenis-jenis tagihan bulanan yang berlaku di kos. Klik salah satu untuk lihat detail.</p>
                        </div>

                        <form method="GET" action="{{ route('tenant.bill-categories.index') }}" class="w-full sm:w-72">
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="11" cy="11" r="7"/>
                                        <path d="M21 21l-4.3-4.3" stroke-linecap="round"/>
                                    </svg>
                                </span>
                                <input type="text" name="search" value="{{ $search }}"
                                       placeholder="Cari kategori..."
                                       class="w-full rounded-lg border-slate-300 pl-9 pr-3 py-2 text-sm placeholder-slate-400 focus:border-[#E84855] focus:ring-[#E84855] focus:ring-1">
                            </div>
                        </form>
                    </div>

                    <!-- Grid Card -->
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                        @forelse ($categories as $category)
                            <button type="button"
                                    @click="selected = {
                                        name: @js($category->category_name),
                                        price: @js(number_format($category->price, 0, ',', '.')),
                                        active: @js((bool) $category->default_active),
                                        created: @js($category->created_at->format('d M Y')),
                                        updated: @js($category->updated_at->format('d M Y')),
                                    }; modalOpen = true"
                                    class="group rounded-xl border border-slate-100 p-5 flex flex-col items-center text-center hover:border-[#E84855]/40 hover:shadow-sm transition text-left">

                                <div class="w-11 h-11 rounded-full bg-[#E84855]/10 text-[#C3323E] flex items-center justify-center mb-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" stroke-linecap="round"/>
                                    </svg>
                                </div>

                                <span class="font-medium text-slate-700 group-hover:text-[#C3323E]">
                                    {{ $category->category_name }}
                                </span>
                                <span class="text-xs text-slate-500 mt-1">
                                    Rp {{ number_format($category->price, 0, ',', '.') }}
                                </span>

                                <span class="mt-3 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium border
                                    {{ $category->default_active
                                        ? 'bg-emerald-50 text-emerald-600 border-emerald-200'
                                        : 'bg-slate-100 text-slate-500 border-slate-200' }}">
                                    {{ $category->default_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </button>
                        @empty
                            <div class="col-span-full py-16 text-center text-slate-400">
                                <p class="text-sm">Belum ada kategori tagihan.</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $categories->links() }}
                    </div>

                </div>
            </div>
        </div>

        <!-- Modal Detail -->
        <div x-show="modalOpen"
             x-cloak
             class="fixed inset-0 z-50 flex items-center justify-center px-4"
             style="display: none;">
            <div class="absolute inset-0 bg-slate-900/50" @click="modalOpen = false"></div>

            <div x-show="modalOpen"
                 x-transition
                 class="relative bg-white rounded-2xl shadow-xl w-full max-w-sm p-8 text-center">

                <button @click="modalOpen = false" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M18 6 6 18M6 6l12 12" stroke-linecap="round"/>
                    </svg>
                </button>

                <template x-if="selected">
                    <div>
                        <div class="w-14 h-14 rounded-2xl bg-[#E84855]/10 text-[#C3323E] flex items-center justify-center mx-auto mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" stroke-linecap="round"/>
                            </svg>
                        </div>

                        <h3 class="text-lg font-bold text-slate-800" x-text="selected.name"></h3>

                        <p class="mt-2 text-2xl font-semibold text-[#C3323E]">
                            Rp <span x-text="selected.price"></span>
                        </p>
                        <p class="text-xs text-slate-400">per bulan (nominal dasar, sebelum dibagi rata)</p>

                        <span class="mt-4 inline-flex items-center px-3 py-1 rounded-full text-xs font-medium border"
                              :class="selected.active
                                ? 'bg-emerald-50 text-emerald-600 border-emerald-200'
                                : 'bg-slate-100 text-slate-500 border-slate-200'">
                            <span x-text="selected.active ? 'Kategori Aktif' : 'Kategori Nonaktif'"></span>
                        </span>

                        <div class="mt-6 pt-5 border-t border-slate-100 text-left text-sm text-slate-500 space-y-1">
                            <p>Dibuat: <span x-text="selected.created"></span></p>
                            <p>Diperbarui: <span x-text="selected.updated"></span></p>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
</x-app-layout>
