<div class="flex flex-col gap-6">
    {{-- Toolbar & Filters --}}
    <div class="bg-white rounded-2xl shadow-sm px-6 py-4 flex flex-wrap items-center justify-between gap-4">
        <div class="flex flex-wrap items-center gap-4">
            <label class="kt-input bg-gray-100 rounded-xl px-3 py-2 flex items-center gap-2">
                <i class="ki-filled ki-magnifier text-gray-400"></i>
                <input wire:model.live.debounce.300ms="name" class="bg-transparent border-none focus:ring-0 text-xs placeholder-gray-400 w-40" placeholder="Search vehicle..." type="text" />
            </label>

            <select wire:model.live="category" class="bg-gray-100 border-none rounded-xl text-xs font-semibold py-2 px-3 focus:ring-2 focus:ring-primary/10 w-36">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>

        <a href="{{ route('dashboards.settings.vehicles.create.index') }}" class="flex items-center gap-2 px-4 py-2.5 bg-primary text-white text-sm font-bold rounded-xl hover:bg-primary-dark transition-all shadow-lg shadow-primary/20">
            <i class="ki-filled ki-plus-square fs-3"></i>
            Add Vehicle
        </a>
    </div>

    {{-- Table Card --}}
    <div class="kt-card kt-card-grid min-w-full shadow-sm bg-white rounded-2xl overflow-hidden">
        <div class="kt-card-header px-8 py-5 bg-gray-50/30 border-b border-gray-100">
            <h3 class="kt-card-title text-sm font-semibold text-gray-600">
               Showing {{ $vehicles->firstItem() ?? 0 }} - {{ $vehicles->lastItem() ?? 0 }} of {{ $vehicles->total() }} vehicles
            </h3>
        </div>

        <div class="kt-card-content px-2">
            <div class="kt-scrollable-x-auto">
                <table class="kt-table table-auto w-full align-middle border-collapse">
                    <thead>
                        <tr class="text-gray-400 font-bold text-[10px] uppercase tracking-widest border-b border-gray-100">
                            <th class="px-6 py-5 text-left">Vehicle Info</th>
                            <th class="px-6 py-5 text-left">Category</th>
                            <th class="px-6 py-5 text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($vehicles as $vehicle)
                        <tr wire:key="{{ $vehicle->id }}" class="group hover:bg-gray-50 transition-all duration-300">
                            <td class="px-6 py-5">
                                <div class="flex flex-col">
                                    <span class="font-bold text-gray-800 text-sm group-hover:text-primary transition-colors">{{ $vehicle->name }}</span>
                                    <span class="text-xs font-semibold text-gray-400 font-mono mt-0.5 tracking-tight">{{ $vehicle->plate }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                @if($vehicle->categoryDetail)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-indigo-50 text-indigo-600 text-[10px] font-bold uppercase tracking-wide">
                                        <i class="ki-filled ki-category fs-2"></i>
                                        {{ $vehicle->categoryDetail->name }}
                                    </span>
                                @else
                                    <span class="text-gray-300 text-xs italic">No Category</span>
                                @endif
                            </td>
                            <td class="px-6 py-5 text-end">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('dashboards.settings.vehicles.edit.index', $vehicle->id) }}" class="flex items-center justify-center w-8 h-8 rounded-lg bg-blue-50 text-blue-500 hover:bg-blue-100 hover:text-blue-600 transition-colors shadow-sm">
                                        <i class="ki-filled ki-pencil fs-5"></i>
                                    </a>
                                    <button wire:click="$dispatch('confirm-delete', { id: '{{ $vehicle->id }}', type: 'vehicle' })" class="flex items-center justify-center w-8 h-8 rounded-lg bg-red-50 text-red-500 hover:bg-red-100 hover:text-red-600 transition-colors shadow-sm">
                                        <i class="ki-filled ki-trash fs-5"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="py-12 text-center text-gray-400 font-bold italic">
                                <div class="flex flex-col items-center gap-2">
                                    <i class="ki-outline ki-car fs-3x opacity-50"></i>
                                    <span>No vehicles found.</span>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="kt-card-footer px-8 py-5 bg-gray-50/30 border-t border-gray-100">
            {{ $vehicles->links() }}
        </div>
    </div>

</div>
