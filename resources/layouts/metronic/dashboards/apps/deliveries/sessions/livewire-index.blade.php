<div>
    <div class="kt-card rounded-2xl border border-gray-100 shadow-sm">
        <div class="kt-card-header border-b border-gray-100 px-6 py-5 flex flex-wrap gap-4 items-center justify-between">
            <h3 class="kt-card-title text-lg font-black text-gray-800 tracking-tight">
                {{ __('menu.session') }}
            </h3>
            <div class="flex items-center gap-2">
                <input wire:model.live.debounce.300ms="search" type="text" class="kt-input h-10 rounded-xl bg-gray-50 border-gray-100 text-xs font-bold w-64" placeholder="{{ __('dashboard.general.search') }}...">
            </div>
        </div>
        <div class="kt-card-body p-0">
            <div class="relative w-full overflow-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                    <tr class="border-b border-gray-100 bg-gray-50/50">
                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">#</th>
                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ __('dashboard.task.table.task_id') }}</th>
                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ __('dashboard.task.table.driver') }}</th>
                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">{{ __('dashboard.general.created_at') }}</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                    @forelse($assigns as $assign)
                        <tr class="hover:bg-gray-50/50 transition-colors group">
                            <td class="px-6 py-4 text-center">
                                <span class="text-xs font-bold text-gray-500">{{ $loop->iteration + ($assigns->currentPage() - 1) * $assigns->perPage() }}</span>
                            </td>
                            <td class="px-6 py-4 md:whitespace-nowrap">
                                @if($assign->task)
                                    <div class="flex flex-col">
                                        <a href="{{ route('dashboards.apps.deliveries.tasks.view', $assign->task->id) }}" class="text-xs font-black text-gray-800 hover:text-primary transition-colors mb-0.5">
                                            {{ $assign->task->name }}
                                        </a>
                                        <span class="text-[9px] font-bold text-gray-400 font-mono">{{ substr($assign->task->id, 0, 8) }}</span>
                                    </div>
                                @else
                                    <span class="text-xs font-bold text-red-400 italic">Task Deleted</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($assign->assignedAccount)
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center text-gray-400 font-black text-xs">
                                            {{ substr($assign->assignedAccount->information->first_name ?? $assign->assignedAccount->username, 0, 1) }}
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="text-xs font-black text-gray-800">{{ $assign->assignedAccount->information->first_name ?? '' }} {{ $assign->assignedAccount->information->last_name ?? '' }}</span>
                                            <span class="text-[9px] font-bold text-gray-400">{{ $assign->assignedAccount->email }}</span>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-xs font-bold text-gray-400 italic">Unassigned</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex flex-col items-center">
                                    <span class="text-[10px] font-black text-gray-600">{{ $assign->created_at->format('d M Y') }}</span>
                                    <span class="text-[9px] font-bold text-gray-400">{{ $assign->created_at->format('H:i') }}</span>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-gray-400 text-xs font-bold italic">
                                No sessions found.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $assigns->links() }}
            </div>
        </div>
    </div>
</div>
