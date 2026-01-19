<div class="kt-container-fixed">
    <div class="grid gap-5 lg:gap-7.5">
        {{-- SECTION FILTER --}}
        <div class="bg-white rounded-2xl shadow-sm px-6 py-4 flex flex-wrap items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <label class="kt-input bg-gray-100 rounded-xl px-3 py-2 flex items-center gap-2">
                    <i class="ki-filled ki-magnifier text-gray-400"></i>
                    <input wire:model.live.debounce.300ms="search" class="bg-transparent border-none focus:ring-0 text-xs placeholder-gray-400 w-full md:w-64" placeholder="Search sessions..." type="text" />
                </label>
            </div>

            <div class="ml-auto">
                 <a href="#" class="px-6 py-2.5 bg-gray-900 text-white font-bold text-sm rounded-xl hover:bg-gray-800 transition-all shadow-lg shadow-gray-200 flex items-center gap-2">
                    <i class="ki-filled ki-plus-square text-sm"></i>
                    <span >Create New</span>
                </a>
            </div>
        </div>

        {{-- TABLE CARD --}}
        <div class="kt-card kt-card-grid min-w-full shadow-sm bg-white rounded-2xl overflow-hidden">
            <div class="kt-card-header px-8 py-5 bg-gray-50/30 border-b border-gray-100">
                <h3 class="kt-card-title text-sm font-semibold flex items-center gap-2">
                   <i class="ki-filled ki-time text-blue-500"></i>
                   List Data Session
                </h3>
            </div>

            <div class="kt-card-content px-2">
                <div class="kt-scrollable-x-auto">
                    <table class="kt-table table-auto w-full align-middle border-collapse">
                        <thead>
                        <tr class="text-gray-400 font-bold text-[10px] uppercase tracking-widest border-b border-gray-100">
                            <th class="px-6 py-5 text-left min-w-[200px]">Session ID</th>
                            <th class="px-6 py-5 text-left min-w-[150px]">Driver</th>
                            <th class="px-6 py-5 text-left min-w-[150px]">Task</th>
                            <th class="px-6 py-5 text-left min-w-[150px]">Created At</th>
                            <th class="px-6 py-5 text-right min-w-[100px]">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($sessions as $session)
                            <tr class="group hover:bg-gray-50 transition-all duration-300 border-b border-gray-50 last:border-0">
                                <td class="px-6 py-5">
                                    <div class="flex flex-col">
                                        <span class="font-bold text-gray-800 text-sm font-mono group-hover:text-primary transition-colors cursor-pointer">
                                            {{ \Illuminate\Support\Str::limit($session->id, 8) }}
                                        </span>
                                    </div>
                                </td>

                                <td class="px-6 py-5">
                                    <div class="flex flex-col">
                                        <span class="font-bold text-sm text-gray-800">{{ $session->accountDetail->information->first_name ?? $session->accountDetail->username ?? 'Unknown' }}</span>
                                        <span class="text-xs text-gray-500">{{ $session->accountDetail->credential->username ?? '' }}</span>
                                    </div>
                                </td>

                                <td class="px-6 py-5">
                                    <div class="flex flex-col">
                                        <span class="font-bold text-sm text-gray-800">{{ $session->taskDetail->name ?? '-' }}</span>
                                        <span class="text-xs text-gray-500">{{ $session->taskDetail->id ?? '' }}</span>
                                    </div>
                                </td>

                                <td class="px-6 py-5">
                                    <div class="flex flex-col gap-0.5">
                                        <span class="font-bold text-[11px] text-gray-700">{{ $session->created_at->format('d M, Y') }}</span>
                                        <span class="text-[10px] text-gray-400 uppercase tracking-tighter">{{ $session->created_at->format('H:i') }} WIB</span>
                                    </div>
                                </td>

                                <td class="px-6 py-5 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('dashboards.apps.deliveries.tasks.sessions.show', $session->id) }}" class="flex items-center justify-center w-8 h-8 rounded-lg bg-gray-100 text-gray-500 hover:bg-green-50 hover:text-green-600 transition-colors" title="View Map">
                                            <i class="ki-filled ki-map fs-6"></i>
                                        </a>
                                        <button class="flex items-center justify-center w-8 h-8 rounded-lg bg-gray-100 text-gray-500 hover:bg-blue-50 hover:text-blue-600 transition-colors" title="Edit">
                                            <i class="ki-filled ki-pencil fs-6"></i>
                                        </button>
                                        <button class="flex items-center justify-center w-8 h-8 rounded-lg bg-gray-100 text-gray-500 hover:bg-red-50 hover:text-red-600 transition-colors" title="Delete">
                                            <i class="ki-filled ki-trash fs-6"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-20 text-center text-gray-400 font-bold italic">
                                    <div class="flex flex-col items-center justify-center gap-4 w-full">
                                        <div class="w-16 h-16 rounded-full bg-gray-50 flex items-center justify-center">
                                            <i class="ki-outline ki-magnifier text-3xl text-gray-300"></i>
                                        </div>
                                        <span>No session data found.</span>
                                    </div>
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
                        Showing {{ $sessions->firstItem() ?? 0 }} - {{ $sessions->lastItem() ?? 0 }} of {{ $sessions->total() }}
                    </span>
                    <div class="flex gap-2">
                        {{ $sessions->links(data: ['scrollTo' => false]) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
