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

        {{-- SECTION FILTER --}}
        <div class="rounded-2xl shadow-sm px-6 py-4 flex flex-wrap items-center gap-4">
            <label class="kt-input  rounded-xl px-3 py-2 flex items-center gap-2">
                <i class="ki-filled ki-magnifier "></i>
                <input wire:model.live.debounce.300ms="search" class="bg-transparent border-none focus:ring-0 text-xs placeholder-gray-400 w-40" placeholder="Cari request..." type="text" />
            </label>

            <div class="flex flex-wrap gap-2 items-center">
                <input wire:model.live.debounce.500ms="customerName" type="text" placeholder="Nama Customer..." class=" border-none rounded-xl text-xs font-medium py-2 px-3 focus:ring-2 focus:ring-primary/10 w-40" />

                <select wire:model.live="status" class=" border-none rounded-xl text-xs font-semibold py-2 px-3 focus:ring-2 focus:ring-primary/10 w-36">
                    <option value="">Semua Status</option>
                    <option value="active">Active</option>
                    <option value="pending">Pending</option>
                </select>

                <select wire:model.live="sort" class=" border-none rounded-xl text-xs font-semibold py-2 px-3 focus:ring-0 w-28">
                    <option value="latest">Terbaru</option>
                    <option value="oldest">Terlama</option>
                </select>

                @if($search || $customerName || $status)
                    <button wire:click="resetFilters" class="flex items-center gap-1.5 pl-2 text-[10px] font-bold text-red-500 hover:text-red-700 transition-all uppercase tracking-widest">
                        <i class="ki-filled ki-cross-circle fs-6"></i>
                        Clear
                    </button>
                @endif
            </div>
        </div>

        {{-- TABLE CARD --}}
        <div class="kt-card kt-card-grid min-w-full shadow-sm rounded-2xl overflow-hidden">
            <div class="kt-card-header px-8 py-5">
                <div class="flex flex-col gap-1">
                    <h3 class="text-sm font-bold ">Daftar Request Pengiriman</h3>
                    <p class="text-[10px]  font-medium uppercase tracking-tighter">
                        Menampilkan {{ $deliveries->firstItem() ?? 0 }}-{{ $deliveries->lastItem() ?? 0 }} dari {{ $deliveries->total() }} Data
                    </p>
                </div>
            </div>

            <div class="kt-card-content px-2">
                <div class="kt-scrollable-x-auto">
                    <table class="kt-table table-auto w-full align-middle border-collapse">
                        <thead>
                        <tr class=" font-bold text-[10px] uppercase tracking-widest">
                            <th class="px-6 py-5 text-left">Nama Request</th>
                            <th class="px-6 py-5 text-left">Muatan (Dest/Pkt)</th> {{-- KOLOM GABUNGAN --}}
                            <th class="px-6 py-5 text-left">Requested By</th>
                            <th class="px-6 py-5 text-left">Status</th>
                            <th class="px-6 py-5 text-right w-24">Actions</th>
                            <th class="px-6 py-5 text-right">Dibuat</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($deliveries as $item)
                            <tr class="group transition-all duration-300 hover:bg-gray-50 cursor-pointer" onclick="window.location.href='{{ route('dashboards.apps.deliveries.requests.show', $item->id) }}'">

                                {{-- MODERNIZED: Kolom Nama Request --}}
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-4">
                                        {{-- Icon Decorative: Membuat tampilan lebih premium --}}
                                        <div class="hidden sm:flex w-10 h-10 shrink-0 items-center justify-center rounded-xl bg-white border border-gray-200 shadow-sm group-hover:border-primary/30 group-hover:bg-primary/5 transition-all duration-300">
                                            <i class="ki-filled ki-delivery-2  group-hover:text-primary transition-colors text-lg"></i>
                                        </div>

                                        <div class="flex flex-col min-w-0">
                    <span class="font-bold  text-sm tracking-tight group-hover:text-primary transition-colors truncate leading-tight">
                        {{ $item->name ?? 'Unnamed Request' }}
                    </span>
                                            <div class="flex items-center gap-1.5 mt-1">
                        <span class="text-[9px] font-bold  uppercase tracking-widest  px-1.5 py-0.5 rounded">
                            REQ-ID
                        </span>
                                                <span class="text-[10px]  font-medium truncate">
                            #{{ substr($item->id, 0, 8) }}
                        </span>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                {{-- KOLOM GABUNGAN: Muatan --}}
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-2">
                                        <div class="flex flex-col items-center justify-center bg-blue-50/50 border border-blue-100 rounded-lg py-1 px-2.5 min-w-[45px] hover:scale-105 transition-transform cursor-default">
                    <span class="text-[11px] font-black text-blue-700 leading-none">
                        {{ $item->destinations->count() }}
                    </span>
                                            <span class="text-[8px] font-bold text-blue-400 uppercase mt-0.5">Dest</span>
                                        </div>
                                        <div class="flex flex-col items-center justify-center bg-indigo-50/50 border border-indigo-100 rounded-lg py-1 px-2.5 min-w-[45px] hover:scale-105 transition-transform cursor-default">
                    <span class="text-[11px] font-black text-indigo-700 leading-none">
                        {{ $item->destinations->sum(fn($dest) => $dest->packages->count()) }}
                    </span>
                                            <span class="text-[8px] font-bold text-indigo-400 uppercase mt-0.5">Pkt</span>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-full bg-gradient-to-br from-gray-100 to-gray-200 border border-white shadow-sm flex items-center justify-center text-gray-500 overflow-hidden">
                                            {{-- Bisa diganti Initials jika mau lebih pro --}}
                                            <span class="text-[10px] font-bold  uppercase">
                        {{ substr($item->account->information->first_name ?? 'U', 0, 1) }}
                    </span>
                                        </div>
                                        <div class="flex flex-col">
                    <span class="text-sm font-bold text-gray-700 leading-tight">
                        {{ $item->account->information->first_name ?? 'N/A' }}
                        {{ $item->account->information->last_name ?? '' }}
                    </span>
                                            <span class="text-[10px]  font-medium mt-0.5">
                        {{ $item->account->contact->email ?? '-' }}
                    </span>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-5">
                                    @php
                                        $st = strtolower($item->status ?? 'pending');
                                        $statusConfig = [
                                            'active' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                            'pending' => 'bg-orange-50 text-orange-600 border-orange-100',
                                            'default' => 'bg-gray-50 text-gray-600 border-gray-100'
                                        ];
                                        $currentStyle = $statusConfig[$st] ?? $statusConfig['default'];
                                    @endphp
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider border {{ $currentStyle }}">
                                            <span class="w-1 h-1 rounded-full bg-current mr-1.5"></span>
                                            {{ $st }}
                                        </span>
                                    <td class="px-6 py-5 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <a class="flex items-center justify-center w-8 h-8 rounded-lg bg-blue-50 text-blue-500 hover:bg-blue-100 hover:text-blue-600 transition-colors shadow-sm" href="{{ route('dashboards.apps.deliveries.requests.show', $item->id) }}" onclick="event.stopPropagation()" title="Detail">
                                                <i class="ki-filled ki-eye fs-5"></i>
                                            </a>
                                            <a class="flex items-center justify-center w-8 h-8 rounded-lg bg-yellow-50 text-yellow-500 hover:bg-yellow-100 hover:text-yellow-600 transition-colors shadow-sm" href="{{ route('dashboards.apps.deliveries.requests.edit.index', $item->id) }}" onclick="event.stopPropagation()" title="Edit">
                                                <i class="ki-filled ki-pencil fs-5"></i>
                                            </a>
                                            <button 
                                                class="flex items-center justify-center w-8 h-8 rounded-lg bg-red-50 text-red-500 hover:bg-red-100 hover:text-red-600 transition-colors shadow-sm"
                                                type="button"
                                                wire:click.stop="confirmDelete('{{ $item->id }}')"
                                                title="Delete"
                                            >
                                                <i class="ki-filled ki-trash fs-5"></i>
                                            </button>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 text-right">
                                        <div class="flex flex-col items-end gap-1">
                                            <span class="font-bold text-[11px] ">{{ $item->created_at->format('d M Y') }}</span>
                                            <span class="px-1.5 py-0.5  rounded text-[9px]  font-bold tracking-tight">
                                                {{ $item->created_at->format('H:i') }} WIB
                                            </span>
                                        </div>
                                    </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-24 text-center">
                                    <div class="flex flex-col items-center justify-center gap-3">
                                        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center border border-dashed border-gray-200 text-gray-300">
                                            <i class="ki-filled ki-dropbox fs-1"></i>
                                        </div>
                                        <p class=" font-bold italic text-xs">Opps! Data tidak ditemukan.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="kt-card-footer px-8 py-5 bg-gray-50/30 flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-3 text-xs font-bold ">
                    Tampilkan
                    <select wire:model.live="perPage" class="bg-white border-none shadow-sm rounded-lg text-xs font-bold px-2 py-1 cursor-pointer">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="25">25</option>
                    </select>
                </div>
                <div>{{ $deliveries->links(data: ['scrollTo' => false]) }}</div>
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
                        <h3 class="text-lg font-bold text-gray-900">Delete Request?</h3>
                        <p class="text-sm text-gray-500 leading-relaxed px-4">
                            Are you sure you want to delete this request? This action cannot be undone.
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
