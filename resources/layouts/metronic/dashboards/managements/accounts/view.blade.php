<div class="kt-container-fixed animate-fade-in scale-[0.98] origin-top">
    <div class="grid gap-4 lg:gap-6">
        {{-- SECTION FILTER: Slim & Compact Glass Design --}}
        <div class="bg-white/80 backdrop-blur-md sticky top-4 z-10 border border-gray-100 rounded-2xl shadow-[0_4px_20px_rgb(0,0,0,0.03)] px-5 py-3 flex flex-wrap items-center gap-3 transition-all duration-500">
            {{-- Search Input --}}
            <label class="group relative bg-gray-50/50 border border-gray-200 rounded-xl px-3 py-2 flex items-center gap-2 transition-all duration-300 hover:border-primary/30 focus-within:ring-4 focus-within:ring-primary/5 focus-within:border-primary/40 focus-within:bg-white w-full md:w-64">
                <i class="ki-filled ki-magnifier text-gray-400 text-sm group-focus-within:text-primary transition-colors"></i>
                <input wire:model.live.debounce.300ms="search"
                       class="bg-transparent border-none focus:ring-0 text-sm font-bold placeholder-gray-400 text-gray-700 w-full"
                       placeholder="Cari akun..." type="text" />
            </label>

            <div class="flex flex-wrap gap-2 items-center">
                <div class="flex gap-1.5">
                    <input wire:model.live.debounce.500ms="customerName" type="text" placeholder="Cust..."
                           class="bg-gray-50/50 border border-gray-200 rounded-lg text-xs font-bold py-2 px-3 focus:ring-4 focus:ring-primary/5 focus:border-primary/40 focus:bg-white transition-all w-28 shadow-sm" />

                    <input wire:model.live.debounce.500ms="recipientName" type="text" placeholder="Recp..."
                           class="bg-gray-50/50 border border-gray-200 rounded-lg text-xs font-bold py-2 px-3 focus:ring-4 focus:ring-primary/5 focus:border-primary/40 focus:bg-white transition-all w-28 shadow-sm" />
                </div>

                <div class="h-6 w-[1px] bg-gray-200 hidden md:block"></div>

                <select wire:model.live="status"
                        class="bg-gray-50/50 border border-gray-200 rounded-lg text-xs font-bold py-2 px-3 focus:ring-4 focus:ring-primary/5 focus:border-primary/40 focus:bg-white transition-all w-36 cursor-pointer shadow-sm">
                    <option value="">Status</option>
                    <option value="todo">To-Do</option>
                    <option value="on_delivery">Progress</option>
                    <option value="delivered">Delivered</option>
                    <option value="failed">Failed</option>
                    <option value="done">Done</option>
                </select>

                <div class="flex items-center bg-gray-50/50 border border-gray-200 rounded-lg px-2 gap-1 focus-within:bg-white transition-all shadow-sm">
                    <input wire:model.live="minPackages" type="number" placeholder="Min" class="bg-transparent border-none text-xs font-black w-12 text-center focus:ring-0 placeholder-gray-400" />
                    <span class="text-gray-300 text-xs">|</span>
                    <input wire:model.live="maxPackages" type="number" placeholder="Max" class="bg-transparent border-none text-xs font-black w-12 text-center focus:ring-0 placeholder-gray-400" />
                </div>

                <select wire:model.live="sort" class="bg-gray-50/50 border border-gray-200 rounded-lg text-xs font-bold py-2 px-3 focus:ring-0 w-28 shadow-sm cursor-pointer transition-all">
                    <option value="latest">Terbaru</option>
                    <option value="oldest">Terlama</option>
                </select>

                @if($search || $customerName || $recipientName || $status || $minPackages || $maxPackages)
                    <button wire:click="resetFilters"
                            class="group flex items-center gap-2 px-3 py-2 text-xs font-black text-red-500 hover:bg-red-50 rounded-lg transition-all duration-300 uppercase tracking-tight border border-transparent">
                        <i class="ki-filled ki-cross-circle text-base group-hover:rotate-90 transition-transform"></i>
                        Clear
                    </button>
                @endif
            </div>
        </div>

        {{-- TABLE CARD --}}
        <div class="bg-white rounded-2xl shadow-[0_10px_30px_rgba(0,0,0,0.02)] border border-gray-100 overflow-hidden transition-all duration-500">
            <div class="px-8 py-5 bg-gray-50/20 border-b border-gray-50 flex items-center justify-between">
                <div>
                    <h3 class="text-gray-800 text-base font-black tracking-tight">Manajemen Akun</h3>
                    <p class="text-gray-400 text-xs font-bold mt-0.5">
                        Menampilkan <span class="text-primary">{{ $acc->firstItem() ?? 0 }}-{{ $acc->lastItem() ?? 0 }}</span> dari {{ $acc->total() }} data
                    </p>
                </div>
            </div>

            <div class="p-3">
                <div class="kt-scrollable-x-auto">
                    <table class="table-auto w-full border-separate border-spacing-y-2">
                        <thead>
                        <tr class="text-gray-400 font-black text-xs uppercase tracking-[0.1em]">
                            <th class="px-6 py-4 text-left">Profil Pengguna</th>
                            <th class="px-6 py-4 text-left">Kredensial</th>
                            <th class="px-6 py-4 text-left">Peran</th>
                            <th class="px-6 py-4 text-left">Device</th>
                            <th class="px-6 py-4 text-right">Terdaftar</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y-0">
                        @forelse($acc as $index => $item)
                            <tr class="group transition-all duration-500 hover:translate-x-1"
                                style="animation: slideUp 0.4s ease-out {{ $index * 0.03 }}s both;">

                                <td class="px-6 py-4 bg-white group-hover:bg-primary/[0.02] rounded-l-xl border-y border-l border-transparent group-hover:border-primary/10">
                                    <div class="flex items-center gap-4">
                                        <div class="flex items-center justify-center shrink-0 w-10 h-10 rounded-xl bg-gradient-to-br from-primary/10 to-transparent text-primary font-black text-sm shadow-sm transition-transform group-hover:rotate-3">
                                            {{ substr($item->information->first_name ?? 'A', 0, 1) }}{{ substr($item->information->last_name ?? 'N', 0, 1) }}
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="font-black text-gray-800 text-sm group-hover:text-primary transition-colors tracking-tight">
                                                {{ $item->information->first_name ?? 'N/A' }} {{ $item->information->last_name ?? '' }}
                                            </span>
                                            <span class="text-xs font-bold text-gray-400 tracking-tight">UID: {{ substr($item->id, 0, 8) }}</span>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 bg-white group-hover:bg-primary/[0.02] border-y border-transparent group-hover:border-primary/10">
                                    <div class="flex flex-col gap-1">
                                        <span class="font-black text-gray-700 text-sm italic">@ {{ $item->credential->username ?? '-' }}</span>
                                        <span class="text-xs font-bold text-gray-400 truncate max-w-[150px]">
                                            {{ $item->contact->email ?? 'no-email' }}
                                        </span>
                                    </div>
                                </td>

                                <td class="px-6 py-4 bg-white group-hover:bg-primary/[0.02] border-y border-transparent group-hover:border-primary/10">
                                    @if($item->role)
                                        @php
                                            $roleName = strtolower($item->role->name);
                                            $roleClass = match(true) {
                                                str_contains($roleName, 'admin') => 'bg-emerald-500/10 text-emerald-600 border-emerald-500/20',
                                                str_contains($roleName, 'super') => 'bg-purple-500/10 text-purple-600 border-purple-500/20',
                                                str_contains($roleName, 'driver') => 'bg-blue-500/10 text-blue-600 border-blue-500/20',
                                                default => 'bg-gray-500/10 text-gray-600 border-gray-500/20',
                                            };
                                        @endphp
                                        <div class="px-3 py-1.5 rounded-xl border {{ $roleClass }} w-fit transition-transform group-hover:scale-105">
                                            <span class="text-xs font-black uppercase tracking-widest">{{ $item->role->name }}</span>
                                        </div>
                                    @else
                                        <span class="text-xs font-black text-gray-300 italic uppercase">No Role</span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 bg-white group-hover:bg-primary/[0.02] border-y border-transparent group-hover:border-primary/10">
                                    @if($item->firebase)
                                        <div class="flex items-center gap-2.5 px-3 py-2 rounded-xl bg-orange-50 border border-orange-100 w-fit">
                                            <i class="ki-filled ki-notification-on text-sm text-orange-500 animate-pulse"></i>
                                            <span class="text-xs font-black text-orange-600 uppercase tracking-tighter">Active</span>
                                        </div>
                                    @else
                                        <div class="flex items-center gap-2 opacity-30 pl-2">
                                            <i class="ki-outline ki-cloud-cross text-lg text-gray-400"></i>
                                            <span class="text-xs font-bold text-gray-400 italic">OFF</span>
                                        </div>
                                    @endif
                                </td>

                                <td class="px-6 py-4 bg-white group-hover:bg-primary/[0.02] rounded-r-xl text-right border-y border-r border-transparent group-hover:border-primary/10">
                                    <div class="flex flex-col items-end">
                                        <span class="font-black text-sm text-gray-700">{{ $item->created_at ? $item->created_at->format('d/m/Y') : '-' }}</span>
                                        <span class="text-xs font-bold text-gray-400 uppercase tracking-tighter">{{ $item->created_at ? $item->created_at->diffForHumans() : '' }}</span>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="py-24 text-center text-gray-300 font-black text-sm uppercase tracking-[0.2em]">Data Kosong</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- FOOTER --}}
            <div class="px-10 py-6 bg-gray-50/10 flex items-center justify-between gap-4 border-t border-gray-50">
                <div class="flex items-center gap-3 bg-white px-4 py-2 rounded-xl border border-gray-100 shadow-sm">
                    <span class="text-xs font-black text-gray-400 uppercase">Limit</span>
                    <select wire:model.live="perPage" class="bg-transparent border-none text-sm font-black text-primary focus:ring-0 p-0 cursor-pointer">
                        <option value="5">05</option><option value="10">10</option><option value="25">25</option>
                    </select>
                </div>
                <div class="mini-pagination scale-[0.95] origin-right">
                    {{ $acc->links(data: ['scrollTo' => false]) }}
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes slideUp { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        .animate-fade-in { animation: fadeIn 0.6s ease-out; }
        .font-black { font-weight: 900; }

        .kt-scrollable-x-auto::-webkit-scrollbar { height: 5px; }
        .kt-scrollable-x-auto::-webkit-scrollbar-thumb { background: #F3F4F6; border-radius: 10px; }

        /* Pagination Styling */
        .mini-pagination span[aria-current="page"] span { @apply bg-primary text-white border-none rounded-xl text-xs font-black px-3 py-1.5 !important; }
        .mini-pagination a, .mini-pagination span span { @apply bg-white border border-gray-100 rounded-xl text-xs font-black text-gray-400 hover:bg-gray-50 px-3 py-1.5 !important; }
    </style>
</div>
