<div class="flex flex-col gap-6">
    <div class="flex items-center justify-between mb-2">
        <h3 class="text-lg font-bold text-gray-900">Riwayat & Timeline</h3>
    </div>

    <div class="relative pl-4 border-l-2 border-dashed border-gray-200 ml-3 space-y-8">
        @forelse(collect(data_get($task, 'history', []))->sortByDesc('created_at') as $history)
            <div class="relative">
                {{-- Dot --}}
                <div class="absolute -left-[25px] top-1 w-4 h-4 rounded-full bg-white border-2 border-primary shadow-sm ring-4 ring-white"></div>
                
                <div class="flex flex-col gap-1">
                    {{-- Status Header --}}
                    <div class="flex items-center gap-2">
                        <span class="text-sm font-black text-gray-800 uppercase tracking-wide">
                            {{ str_replace('_', ' ', data_get($history, 'to_status')) }}
                        </span>
                        <span class="text-xs font-semibold text-gray-400">
                             {{ \Carbon\Carbon::parse(data_get($history, 'created_at'))->format('H:i, d M Y') }}
                        </span>
                    </div>

                    {{-- Description --}}
                    <div class="p-4 rounded-xl bg-gray-50 border border-gray-100 text-sm font-medium text-gray-600">
                         {{ data_get($history, 'description', 'No Description provided.') }}
                    </div>

                    {{-- User Info --}}
                    <div class="flex items-center gap-2 mt-1">
                         <div class="w-5 h-5 rounded-full bg-gray-200 flex items-center justify-center text-[9px] font-bold text-gray-500">
                            {{ substr(data_get($history, 'account.information.first_name', 'S'), 0, 1) }}
                         </div>
                         <span class="text-xs font-bold text-gray-400">
                            By: {{ data_get($history, 'account.information.first_name', 'System') }}
                         </span>
                    </div>
                </div>
            </div>
        @empty
            <div class="flex flex-col items-center justify-center py-10 text-gray-400">
                <i class="ki-outline ki-time text-4xl mb-3 opacity-50"></i>
                <span class="text-sm font-semibold">Belum ada riwayat tercatat</span>
            </div>
        @endforelse
    </div>
</div>
