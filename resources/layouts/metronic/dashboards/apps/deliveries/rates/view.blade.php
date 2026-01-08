<div class="kt-container-fixed">
    <div class="grid gap-5 lg:gap-7.5">
        {{-- ALERT SUKSES DENGAN ANIMASI --}}
        @if (session()->has('success'))
            <div class="kt-card border-none bg-emerald-50 rounded-2xl p-5 flex items-center gap-4 animate-scale-in border border-emerald-100 shadow-sm mb-6">
                <div class="w-10 h-10 rounded-xl bg-emerald-500 flex items-center justify-center shadow-lg shadow-emerald-200">
                    <i class="ki-filled ki-check text-white text-xl"></i>
                </div>
                <div class="flex flex-col">
                    <span class="text-xs font-black text-emerald-900 uppercase tracking-widest leading-none mb-1">Transaction Success</span>
                    <p class="text-[11px] text-emerald-600 font-bold uppercase tracking-tight">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        {{-- ALERT ERROR DENGAN ANIMASI --}}
        @if (session()->has('error'))
            <div class="kt-card border-none bg-red-50 rounded-2xl p-5 flex items-center gap-4 animate-scale-in border border-red-100 shadow-sm mb-6">
                <div class="w-10 h-10 rounded-xl bg-red-500 flex items-center justify-center shadow-lg shadow-red-200">
                    <i class="ki-filled ki-cross-circle text-white text-xl"></i>
                </div>
                <div class="flex flex-col">
                    <span class="text-xs font-black text-red-900 uppercase tracking-widest leading-none mb-1">Transaction Failed</span>
                    <p class="text-[11px] text-red-600 font-bold uppercase tracking-tight">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        {{-- SECTION FILTER: Compact & Smooth --}}
        {{-- SECTION FILTER --}}
        <div class="bg-white rounded-2xl shadow-sm px-6 py-4 flex flex-wrap items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <label class="kt-input bg-gray-100 rounded-xl px-3 py-2 flex items-center gap-2">
                    <i class="ki-filled ki-magnifier text-gray-400"></i>
                    <input wire:model.live.debounce.300ms="search" class="bg-transparent border-none focus:ring-0 text-xs placeholder-gray-400 w-full md:w-64" placeholder="Search rates..." type="text" />
                </label>
            </div>

            <div class="ml-auto">
                 <a href="{{ route('dashboards.apps.deliveries.rates.create') }}" class="px-6 py-2.5 bg-gray-900 text-white font-bold text-sm rounded-xl hover:bg-gray-800 transition-all shadow-lg shadow-gray-200 flex items-center gap-2">
                    <i class="ki-filled ki-plus-square text-sm"></i>
                    <span >Create New</span>
                </a>
            </div>
        </div>

        {{-- TABLE CARD --}}
        <div class="kt-card kt-card-grid min-w-full shadow-sm bg-white rounded-2xl overflow-hidden">
            <div class="kt-card-header px-8 py-5 bg-gray-50/30 border-b border-gray-100">
                <h3 class="kt-card-title text-sm font-semibold flex items-center gap-2">
                   <i class="ki-filled ki-dollar text-emerald-500"></i>
                   List Data Tarif
                </h3>
            </div>

            <div class="kt-card-content px-2">
                <div class="kt-scrollable-x-auto">
                    <table class="kt-table table-auto w-full align-middle border-collapse">
                        <thead>
                        <tr class="text-gray-400 font-bold text-[10px] uppercase tracking-widest border-b border-gray-100">
                            <th class="px-6 py-5 text-left min-w-[200px]">Rate Name</th>
                            <th class="px-6 py-5 text-left min-w-[150px]">Category</th>
                            <th class="px-6 py-5 text-left min-w-[150px]">Price</th>
                            <th class="px-6 py-5 text-left min-w-[300px]">Description</th>
                            <th class="px-6 py-5 text-right min-w-[100px]">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($rates as $rate)
                            <tr class="group hover:bg-gray-50 transition-all duration-300 border-b border-gray-50 last:border-0">
                                <td class="px-6 py-5">
                                    <span class="font-bold text-gray-800 text-sm group-hover:text-primary transition-colors cursor-pointer">
                                        {{ $rate->name }}
                                    </span>
                                </td>

                                <td class="px-6 py-5">
                                     <span class="px-2 py-1 rounded-md bg-blue-50 text-blue-600 text-[10px] font-black uppercase tracking-tight">
                                        {{ $rate->category_rel->name ?? 'Uncategorized' }}
                                    </span>
                                </td>

                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-1 font-mono text-sm font-bold text-emerald-600">
                                        <span class="text-[10px] text-gray-400">Rp</span>
                                        {{ number_format($rate->price, 2) }}
                                    </div>
                                </td>

                                <td class="px-6 py-5">
                                    <span class="text-xs text-gray-500 line-clamp-1 max-w-[200px]" title="{{ $rate->description }}">
                                        {{ Str::limit($rate->description, 50) }}
                                    </span>
                                </td>

                                <td class="px-6 py-5 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('dashboards.apps.deliveries.rates.edit', $rate->id) }}" class="flex items-center justify-center w-8 h-8 rounded-lg bg-gray-100 text-gray-500 hover:bg-blue-50 hover:text-blue-600 transition-colors" title="Edit">
                                            <i class="ki-filled ki-pencil fs-6"></i>
                                        </a>
                                        <button wire:click="confirmDelete('{{ $rate->id }}')" class="flex items-center justify-center w-8 h-8 rounded-lg bg-gray-100 text-gray-500 hover:bg-red-50 hover:text-red-600 transition-colors" title="Delete">
                                            <i class="ki-filled ki-trash fs-6"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-20 text-center text-gray-400 font-bold italic flex flex-col items-center justify-center gap-4">
                                    <div class="w-16 h-16 rounded-full bg-gray-50 flex items-center justify-center">
                                        <i class="ki-outline ki-magnifier text-3xl text-gray-300"></i>
                                    </div>
                                    <span>No rates data found.</span>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="kt-card-footer px-8 py-5 bg-gray-50/30 flex flex-col md:flex-row items-center justify-between gap-4 border-t border-gray-100">
                <div class="flex items-center gap-3">
                    <span class="text-gray-500 font-bold text-xs">Tampilkan</span>
                    <select wire:model.live="perPage" class="form-select form-select-sm form-select-solid w-20 rounded-xl text-xs font-bold focus:ring-primary/10 bg-gray-100 border-none">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="25">25</option>
                    </select>
                </div>

                <div class="flex items-center gap-4">
                    <span class="text-gray-400 text-xs font-bold">
                        Showing {{ $rates->firstItem() ?? 0 }} - {{ $rates->lastItem() ?? 0 }} of {{ $rates->total() }}
                    </span>
                    <div class="flex gap-2">
                        @if($rates->onFirstPage())
                             <button class="px-4 py-2 rounded-xl bg-gray-100 text-gray-400 text-[10px] font-black uppercase tracking-widest cursor-not-allowed">
                                « Sebelumnya
                             </button>
                        @else
                            <button wire:click="previousPage" class="px-4 py-2 rounded-xl bg-gray-900 text-white text-[10px] font-black uppercase tracking-widest hover:bg-gray-800 transition-colors shadow-lg shadow-gray-200">
                                « Sebelumnya
                            </button>
                        @endif

                        @if($rates->hasMorePages())
                            <button wire:click="nextPage" class="px-4 py-2 rounded-xl bg-gray-900 text-white text-[10px] font-black uppercase tracking-widest hover:bg-gray-800 transition-colors shadow-lg shadow-gray-200">
                                Berikutnya »
                            </button>
                        @else
                             <button class="px-4 py-2 rounded-xl bg-gray-100 text-gray-400 text-[10px] font-black uppercase tracking-widest cursor-not-allowed">
                                Berikutnya »
                             </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- CUSTOM DELETE CONFIRMATION MODAL --}}
    @if($confirmingDeletion)
        <div class="fixed inset-0 z-[100] flex items-center justify-center bg-black/40 backdrop-blur-sm transition-all duration-300">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-[400px] p-6 animate-scale-in border border-gray-100 relative">
                {{-- Close Button --}}
                <button wire:click="cancelDelete" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition-colors">
                    <i class="ki-filled ki-cross text-xl"></i>
                </button>

                <div class="flex flex-col items-center gap-4 text-center">
                    {{-- Icon Warning --}}
                    <div class="w-16 h-16 rounded-full bg-red-50 flex items-center justify-center animate-bounce-short">
                        <i class="ki-outline ki-trash text-3xl text-red-500"></i>
                    </div>

                    {{-- Content --}}
                    <div class="space-y-2">
                        <h3 class="text-lg font-bold text-gray-900">Delete Rate?</h3>
                        <p class="text-sm text-gray-500 leading-relaxed px-4">
                            Are you sure you want to delete this rate? This action cannot be undone.
                        </p>
                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center gap-3 w-full mt-2">
                        <button wire:click="cancelDelete" class="flex-1 px-4 py-2.5 rounded-xl bg-gray-100 text-gray-600 font-bold text-sm hover:bg-gray-200 transition-colors">
                            Cancel
                        </button>
                        <button wire:click="deleteConfirmed" class="flex-1 px-4 py-2.5 rounded-xl bg-red-600 text-white font-bold text-sm hover:bg-red-700 transition-colors shadow-lg shadow-red-200">
                            Yes, Delete It
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
