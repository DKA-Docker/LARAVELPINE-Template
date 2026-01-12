<div class="kt-container-fixed">
    <div class="grid gap-5 lg:gap-7.5">

        {{-- SECTION FILTER --}}
        <div class="rounded-2xl shadow-sm px-6 py-4 flex flex-wrap items-center gap-4">
            <label class="kt-input rounded-xl px-3 py-2 flex items-center gap-2">
                <i class="ki-filled ki-magnifier"></i>
                <input wire:model.live.debounce.300ms="query" class="bg-transparent border-none focus:ring-0 text-xs placeholder-gray-400 w-40" placeholder="Search Reports..." type="text" />
            </label>

            <div class="flex flex-wrap gap-2 items-center">
                 {{-- Date Range --}}
                 <div class="flex items-center gap-2">
                    <input type="date" wire:model.live="startDate" class="border-none rounded-xl text-xs font-medium py-2 px-3 focus:ring-2 focus:ring-primary/10 bg-gray-50" />
                    <span class="text-gray-400 text-xs">-</span>
                    <input type="date" wire:model.live="endDate" class="border-none rounded-xl text-xs font-medium py-2 px-3 focus:ring-2 focus:ring-primary/10 bg-gray-50" />
                </div>

                 {{-- Quick Filters --}}
                <div class="flex items-center gap-1">
                    <button class="px-3 py-1.5 rounded-lg text-[10px] font-bold uppercase tracking-wider border {{ $dateFilter === 'this_month' ? 'bg-primary text-white border-primary' : 'bg-white text-gray-500 border-gray-200 hover:bg-gray-50' }} transition-all" wire:click="setDateFilter('this_month')">
                        Month
                    </button>
                    <button class="px-3 py-1.5 rounded-lg text-[10px] font-bold uppercase tracking-wider border {{ $dateFilter === 'last_6_months' ? 'bg-primary text-white border-primary' : 'bg-white text-gray-500 border-gray-200 hover:bg-gray-50' }} transition-all" wire:click="setDateFilter('last_6_months')">
                        6 Months
                    </button>
                    <button class="px-3 py-1.5 rounded-lg text-[10px] font-bold uppercase tracking-wider border {{ $dateFilter === 'this_year' ? 'bg-primary text-white border-primary' : 'bg-white text-gray-500 border-gray-200 hover:bg-gray-50' }} transition-all" wire:click="setDateFilter('this_year')">
                        Year
                    </button>
                     <button class="px-3 py-1.5 rounded-lg text-[10px] font-bold uppercase tracking-wider border {{ $dateFilter === 'all' ? 'bg-primary text-white border-primary' : 'bg-white text-gray-500 border-gray-200 hover:bg-gray-50' }} transition-all" wire:click="setDateFilter('all')">
                        All
                    </button>
                </div>

                @if($query || $dateFilter !== 'all')
                    <button wire:click="setDateFilter('all'); $set('query', '');" class="flex items-center gap-1.5 pl-2 text-[10px] font-bold text-red-500 hover:text-red-700 transition-all uppercase tracking-widest">
                        <i class="ki-filled ki-cross-circle fs-6"></i>
                        Clear
                    </button>
                @endif
            </div>

             <div class="ml-auto">
                <button class="flex items-center justify-center gap-2 px-4 py-2 rounded-xl bg-green-50 text-green-600 hover:bg-green-100 hover:text-green-700 transition-colors font-bold text-xs uppercase tracking-wide border border-green-100 shadow-sm" wire:click="exportPdf">
                    <i class="ki-filled ki-file-down fs-5"></i>
                    Export PDF
                </button>
            </div>
        </div>

        {{-- TABLE CARD --}}
        <div class="kt-card kt-card-grid min-w-full shadow-sm rounded-2xl overflow-hidden">
            <div class="kt-card-header px-8 py-5">
                <div class="flex flex-col gap-1">
                    <h3 class="text-sm font-bold">Delivery Reports</h3>
                    <p class="text-[10px] font-medium uppercase tracking-tighter">
                        Showing {{ $reports->firstItem() ?? 0 }}-{{ $reports->lastItem() ?? 0 }} of {{ $reports->total() }} Records
                    </p>
                </div>
            </div>

            <div class="kt-card-content px-2">
                <div class="kt-scrollable-x-auto">
                    <table class="kt-table table-auto w-full align-middle border-collapse">
                        <thead>
                        <tr class="font-bold text-[10px] uppercase tracking-widest">
                            <th class="px-6 py-5 text-left">Task Name</th>
                            <th class="px-6 py-5 text-left">Destination</th>
                            <th class="px-6 py-5 text-left">Assigned Drivers</th>
                            <th class="px-6 py-5 text-left">Status</th>
                            <th class="px-6 py-5 text-right w-24">Actions</th>
                            <th class="px-6 py-5 text-right">Created</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($reports as $report)
                            <tr class="group transition-all duration-300 hover:bg-gray-50">
                                {{-- Task Name --}}
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-4">
                                        <div class="hidden sm:flex w-10 h-10 shrink-0 items-center justify-center rounded-xl bg-white border border-gray-200 shadow-sm group-hover:border-primary/30 group-hover:bg-primary/5 transition-all duration-300">
                                            <i class="ki-filled ki-clipboard-check group-hover:text-primary transition-colors text-lg"></i>
                                        </div>
                                        <div class="flex flex-col min-w-0">
                                            <span class="font-bold text-sm tracking-tight group-hover:text-primary transition-colors truncate leading-tight">
                                                {{ $report->name ?? 'Unnamed Task' }}
                                            </span>
                                            <div class="flex items-center gap-1.5 mt-1">
                                                <span class="text-[9px] font-bold uppercase tracking-widest px-1.5 py-0.5 rounded">
                                                    ID
                                                </span>
                                                <span class="text-[10px] font-medium truncate text-gray-500">
                                                    #{{ substr($report->id, 0, 8) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                {{-- Destination --}}
                                <td class="px-6 py-5">
                                    <div class="flex flex-col gap-1">
                                         <span class="text-sm font-bold text-gray-700 leading-tight">
                                            {{ $report->destinationData->receipt_name ?? 'N/A' }}
                                        </span>
                                        <div class="flex items-center gap-2">
                                            @php $pkgCount = $report->destinationData->packages->count() ?? 0; @endphp
                                             <div class="flex items-center gap-1 bg-indigo-50 px-2 py-0.5 rounded text-indigo-600">
                                                <i class="ki-filled ki-package fs-9"></i>
                                                <span class="text-[9px] font-bold">{{ $pkgCount }} Pkg</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                {{-- Assigned Drivers --}}
                                <td class="px-6 py-5">
                                    <div class="flex flex-wrap gap-2 py-1">
                                        @php
                                            $drivers = collect();
                                            foreach($report->assigns as $assign) {
                                                if($assign->assignedAccount) {
                                                    $drivers->push($assign->assignedAccount);
                                                }
                                            }

                                            $drivers = $drivers->unique('id');
                                        @endphp
                                        @forelse($drivers as $user)
                                              @php
                                                 $info = $user->getRelation('information');
                                                 // Robustly construct full name
                                                 $firstName = $info->first_name ?? '';
                                                 $lastName = $info->last_name ?? '';
                                                 $fullName = trim($firstName . ' ' . $lastName);
                                             @endphp
                                             <span class="inline-flex items-center gap-1.5 px-7 py-1.5 bg-gray-900 text-white text-[10px] font-black rounded-xl shadow-sm transition-transform hover:scale-120" title="{{ $fullName }}">
                                                 {{ strtoupper($fullName) }}
                                            </span>

                                        @empty
                                            <span class="text-gray-400 text-xs italic">Unassigned</span>
                                        @endforelse
                                    </div>
                                </td>

                                {{-- Status --}}
                                <td class="px-6 py-5">
                                    @php
                                        $status = $report->history->sortByDesc('created_at')->first()->to_status ?? 'pending';
                                        $st = strtolower($status);
                                        $statusConfig = [
                                            'delivered' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                            'completed' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                            'pending' => 'bg-orange-50 text-orange-600 border-orange-100',
                                            'in_progress' => 'bg-blue-50 text-blue-600 border-blue-100',
                                            'cancelled' => 'bg-red-50 text-red-600 border-red-100',
                                            'default' => 'bg-gray-50 text-gray-600 border-gray-100'
                                        ];
                                        $currentStyle = $statusConfig[$st] ?? $statusConfig['default'];
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider border {{ $currentStyle }}">
                                        <span class="w-1 h-1 rounded-full bg-current mr-1.5"></span>
                                        {{ $status }}
                                    </span>
                                </td>

                                {{-- Actions --}}
                                <td class="px-6 py-5 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        {{-- Add View Detail Link if exists --}}
                                        <button class="flex items-center justify-center w-8 h-8 rounded-lg bg-gray-50 text-gray-500 hover:bg-gray-100 cursor-not-allowed transition-colors shadow-sm" title="View Details (Coming Soon)">
                                            <i class="ki-filled ki-eye fs-5"></i>
                                        </button>
                                    </div>
                                </td>

                                {{-- Created --}}
                                <td class="px-6 py-5 text-right">
                                    <div class="flex flex-col items-end gap-1">
                                        <span class="font-bold text-[11px]">{{ $report->created_at->format('d M Y') }}</span>
                                        <span class="px-2 py-0.2 rounded text-[2px] font-bold tracking-tight text-gray-500">
                                            {{ $report->created_at->format('H:i') }} WITA
                                        </span>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-24 text-center">
                                    <div class="flex flex-col items-center justify-center gap-3">
                                        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center border border-dashed border-gray-200 text-gray-300">
                                            <i class="ki-filled ki-file text-3xl"></i>
                                        </div>
                                        <p class="font-bold italic text-xs text-gray-500">No reports found.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="kt-card-footer px-8 py-5 bg-gray-50/30 flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-3 text-xs font-bold">
                    Show:
                    <select wire:model.live="perPage" class="bg-white border-none shadow-sm rounded-lg text-xs font-bold px-2 py-1 cursor-pointer focus:ring-2 focus:ring-primary/10">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                </div>
                <div>{{ $reports->links(data: ['scrollTo' => false]) }}</div>
            </div>
        </div>
    </div>
</div>
