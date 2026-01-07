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

        {{-- SECTION FILTER: Compact & Smooth --}}
        <div class="bg-white rounded-2xl shadow-sm px-6 py-4 flex flex-wrap items-center gap-4">
            <label class="kt-input bg-gray-100 rounded-xl px-3 py-2 flex items-center gap-2">
                <i class="ki-filled ki-magnifier text-gray-400"></i>
                <input wire:model.live.debounce.300ms="search" class="bg-transparent border-none focus:ring-0 text-xs placeholder-gray-400 w-40" placeholder="Cari tugas..." type="text" />
            </label>

            <div class="flex flex-wrap gap-2 items-center">
                <input wire:model.live.debounce.500ms="customerName" type="text" placeholder="Customer..." class="bg-gray-100 border-none rounded-xl text-xs font-medium py-2 px-3 focus:ring-2 focus:ring-primary/10 w-32" />
                <input wire:model.live.debounce.500ms="recipientName" type="text" placeholder="Penerima..." class="bg-gray-100 border-none rounded-xl text-xs font-medium py-2 px-3 focus:ring-2 focus:ring-primary/10 w-32" />

                <select wire:model.live="status" class="bg-gray-100 border-none rounded-xl text-xs font-semibold py-2 px-3 focus:ring-2 focus:ring-primary/10 w-36">
                    <option value="">Semua Status</option>
                    <option value="todo">To-Do</option>
                    <option value="on_delivery">On Progress</option>
                    <option value="delivered">Delivered</option>
                    <option value="failed">Failed</option>
                    <option value="done">Done</option>
                </select>

                <div class="flex items-center bg-gray-100 rounded-xl px-2 gap-1">
                    <input wire:model.live="minPackages" type="number" placeholder="Min" class="bg-transparent border-none text-[10px] w-20 text-center focus:ring-0" />
                    <span class="text-gray-300">-</span>
                    <input wire:model.live="maxPackages" type="number" placeholder="Max" class="bg-transparent border-none text-[10px] w-20 text-center focus:ring-0" />
                </div>

                <select wire:model.live="sort" class="bg-gray-100 border-none rounded-xl text-xs font-semibold py-2 px-3 focus:ring-0 w-28">
                    <option value="latest">Terbaru</option>
                    <option value="oldest">Terlama</option>
                </select>

                {{-- Tombol Clear Filter --}}
                @if($search || $customerName || $recipientName || $status || $minPackages || $maxPackages)
                    <button wire:click="resetFilters" class="flex items-center gap-1.5 pl-2 pr-1 text-[10px] font-bold text-red-500 hover:text-red-700 transition-colors uppercase tracking-widest">
                        <i class="ki-filled ki-cross-circle fs-6"></i>
                        Clear
                    </button>
                @endif
            </div>
        </div>

        {{-- TABLE CARD --}}
        <div class="kt-card kt-card-grid min-w-full shadow-sm bg-white rounded-2xl overflow-hidden">
            <div class="kt-card-header px-8 py-5 bg-gray-50/30">
                <h3 class="kt-card-title text-sm font-semibold">
                    Menampilkan {{ $tasks->firstItem() ?? 0 }} - {{ $tasks->lastItem() ?? 0 }} dari {{ $tasks->total() }} data
                </h3>
            </div>

            <div class="kt-card-content px-2">
                <div class="kt-scrollable-x-auto">
                    <table class="kt-table table-auto w-full align-middle border-collapse">
                        <thead>
                        <tr class="text-gray-400 font-bold text-[10px] uppercase tracking-widest">
                            <th class="px-6 py-5 text-left">Informasi Tugas</th>
                            <th class="px-6 py-5 text-left">Penerima & Lokasi</th>
                            <th class="px-6 py-5 text-left">Log Aktivitas</th>
                            <th class="px-6 py-5 text-left">Volume</th>
                            <th class="px-6 py-5 text-right w-24">Actions</th>
                            <th class="px-6 py-5 text-right">Waktu</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($tasks as $item)
                            <tr class="group hover:bg-gray-50 transition-all duration-300">
                                <td class="px-6 py-5">
                                    <div class="flex flex-col gap-1">
                                        <a href="{{ route('dashboards.apps.deliveries.tasks.show', $item->id) }}" wire:navigate class="font-bold text-gray-800 text-sm group-hover:text-primary transition-colors cursor-pointer">
                                            {{ $item->name ?? 'Unnamed Task' }}
                                        </a>
                                        <span class="px-2 py-0.5 rounded-md bg-gray-100 text-[9px] font-bold text-gray-500 w-fit uppercase tracking-tight">
                                            REQ: {{ $item->destination->request->account->information->first_name ?? 'N/A' }}
                                        </span>
                                    </div>
                                </td>

                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-4">
                                        <div class="flex items-center justify-center shrink-0 w-10 h-10 rounded-xl bg-blue-50 text-blue-500 shadow-sm">
                                            <i class="ki-duotone ki-user fs-2"><span class="path1"></span><span class="path2"></span></i>
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="font-bold text-gray-800 text-sm mb-0.5 uppercase tracking-tight">
                                                {{ $item->destination->receipt_name ?? 'N/A' }}
                                            </span>
                                            <div class="flex items-center gap-1 text-gray-400 italic">
                                                <i class="ki-outline ki-geolocation text-[10px]"></i>
                                                <span class="text-[11px] truncate max-w-[180px]">
                                                    {{ $item->destination->receipt_address ?? 'N/A' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-5">
                                    @php
                                        $latestHistory = collect($item->history)->sortByDesc('created_at')->first();
                                        $historyCount = collect($item->history)->count();
                                        $statusConfig = [
                                            'on_delivery' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-600', 'icon' => 'ki-delivery-2'],
                                            'delivered' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-600', 'icon' => 'ki-double-check'],
                                            'failed' => ['bg' => 'bg-red-50', 'text' => 'text-red-600', 'icon' => 'ki-cross-circle'],
                                            'done' => ['bg' => 'bg-purple-50', 'text' => 'text-purple-600', 'icon' => 'ki-verify'],
                                            'todo' => ['bg' => 'bg-gray-100', 'text' => 'text-gray-600', 'icon' => 'ki-calendar-tick'],
                                        ];
                                        $currentStatus = $latestHistory['to_status'] ?? 'todo';
                                        $style = $statusConfig[$currentStatus] ?? $statusConfig['todo'];
                                    @endphp
                                    <div class="flex flex-col gap-1.5">
                                        @if($latestHistory)
                                            <div class="flex items-center gap-2">
                                                <div class="flex items-center gap-1.5 px-2 py-1 rounded-lg {{ $style['bg'] }} {{ $style['text'] }} shadow-sm">
                                                    <i class="ki-duotone {{ $style['icon'] }} fs-8"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                                                    <span class="text-[9px] font-black uppercase tracking-widest">{{ str_replace('_', ' ', $currentStatus) }}</span>
                                                </div>
                                            </div>
                                            <span class="text-[10px] font-bold text-gray-400 pl-1">
                                                By: {{ $latestHistory['account']['information']['first_name'] ?? 'System' }} • {{ \Carbon\Carbon::parse($latestHistory['created_at'])->diffForHumans() }}
                                            </span>
                                        @else
                                            <span class="text-[10px] font-bold text-gray-300 italic">N/A</span>
                                        @endif
                                    </div>
                                </td>

                                <td class="px-6 py-5">
                                    @php $pkgCount = count($item->destination->packages ?? []); @endphp
                                    @if($pkgCount > 0)
                                        <div class="flex items-center gap-2.5 p-1.5 pr-4 rounded-xl bg-primary/5 w-fit">
                                            <div class="flex items-center justify-center w-7 h-7 rounded-lg bg-white shadow-sm text-primary">
                                                <i class="ki-duotone ki-delivery-3 fs-4"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                                            </div>
                                            <div class="flex flex-col leading-none">
                                                <span class="text-[12px] font-black text-primary">{{ $pkgCount }}</span>
                                                <span class="text-[8px] font-bold text-primary/60 uppercase">Paket</span>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-[10px] font-bold text-gray-300 italic">N/A</span>
                                    @endif
                                </td>

                                <td class="px-6 py-5 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a class="flex items-center justify-center w-8 h-8 rounded-lg bg-blue-50 text-blue-500 hover:bg-blue-100 hover:text-blue-600 transition-colors shadow-sm" href="{{ route('dashboards.apps.deliveries.tasks.show', $item->id) }}" wire:navigate title="Detail">
                                            <i class="ki-filled ki-eye fs-5"></i>
                                        </a>
                                        <a class="flex items-center justify-center w-8 h-8 rounded-lg bg-yellow-50 text-yellow-500 hover:bg-yellow-100 hover:text-yellow-600 transition-colors shadow-sm" href="./tasks/{{ $item->id }}/edit" wire:navigate title="Edit">
                                            <i class="ki-filled ki-pencil fs-5"></i>
                                        </a>
                                        <button 
                                            class="flex items-center justify-center w-8 h-8 rounded-lg bg-red-50 text-red-500 hover:bg-red-100 hover:text-red-600 transition-colors shadow-sm"
                                            type="button"
                                            wire:click="delete('{{ $item->id }}')"
                                            wire:confirm="Are you sure you want to delete this task?"
                                            title="Delete"
                                        >
                                            <i class="ki-filled ki-trash fs-5"></i>
                                        </button>
                                    </div>
                                </td>

                                <td class="px-6 py-5 text-right">
                                    <div class="flex flex-col gap-0.5 items-end">
                                        <span class="font-bold text-[11px] text-gray-700">{{ $item->created_at->format('d M, Y') }}</span>
                                        <span class="text-[10px] text-gray-400 uppercase tracking-tighter">{{ $item->created_at->format('H:i') }} WIB</span>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="py-20 text-center text-gray-400 font-bold italic">Data tidak ditemukan.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="kt-card-footer px-8 py-5 bg-gray-50/30 flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-3 text-xs font-bold text-gray-400">
                    Tampilkan
                    <select wire:model.live="perPage" class="bg-white border-none shadow-sm rounded-lg text-xs font-bold px-2 py-1">
                        <option value="5">5</option><option value="10">10</option><option value="25">25</option>
                    </select>
                </div>
                <div>{{ $tasks->links(data: ['scrollTo' => false]) }}</div>
            </div>
        </div>
    </div>
</div>
