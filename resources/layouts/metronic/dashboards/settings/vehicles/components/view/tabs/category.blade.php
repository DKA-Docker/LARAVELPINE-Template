<div class="flex flex-col gap-6">
    {{-- Toolbar & Filters --}}
    <div class="bg-white rounded-2xl shadow-sm px-6 py-4 flex flex-wrap items-center justify-between gap-4">
        <div class="flex flex-wrap items-center gap-4">
            <label class="kt-input bg-gray-100 rounded-xl px-3 py-2 flex items-center gap-2">
                <i class="ki-filled ki-magnifier text-gray-400"></i>
                <input wire:model.live.debounce.300ms="name" class="bg-transparent border-none focus:ring-0 text-xs placeholder-gray-400 w-40" placeholder="Search category..." type="text" />
            </label>
        </div>

        <a href="{{ route('dashboards.settings.vehicles.create.index', ['tab' => 'category']) }}" class="flex items-center gap-2 px-4 py-2.5 bg-primary text-white text-sm font-bold rounded-xl hover:bg-primary-dark transition-all shadow-lg shadow-primary/20">
            <i class="ki-filled ki-plus-square fs-3"></i>
            Add Category
        </a>
    </div>

    {{-- Table Card --}}
    <div class="kt-card kt-card-grid min-w-full shadow-sm bg-white rounded-2xl overflow-hidden">
        <div class="kt-card-header px-8 py-5 bg-gray-50/30 border-b border-gray-100">
            <h3 class="kt-card-title text-sm font-semibold text-gray-600">
               Showing {{ $categories->firstItem() ?? 0 }} - {{ $categories->lastItem() ?? 0 }} of {{ $categories->total() }} categories
            </h3>
        </div>

        <div class="kt-card-content px-2">
            <div class="kt-scrollable-x-auto">
                <table class="kt-table table-auto w-full align-middle border-collapse">
                    <thead>
                        <tr class="text-gray-400 font-bold text-[10px] uppercase tracking-widest border-b border-gray-100">
                            <th class="px-6 py-5 text-left">Category Name</th>
                            <th class="px-6 py-5 text-left">Description</th>
                            <th class="px-6 py-5 text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                        <tr wire:key="{{ $category->id }}" class="group hover:bg-gray-50 transition-all duration-300">
                            <td class="px-6 py-5">
                                <span class="font-bold text-gray-800 text-sm group-hover:text-primary transition-colors">{{ $category->name }}</span>
                            </td>
                            <td class="px-6 py-5">
                                <span class="text-xs font-medium text-gray-500">{{ Str::limit($category->description ?? '', 50) ?: '-' }}</span>
                            </td>
                            <td class="px-6 py-5 text-end">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('dashboards.settings.vehicles.categories.edit.index', $category->id) }}" class="flex items-center justify-center w-8 h-8 rounded-lg bg-blue-50 text-blue-500 hover:bg-blue-100 hover:text-blue-600 transition-colors shadow-sm">
                                        <i class="ki-filled ki-pencil fs-5"></i>
                                    </a>
                                    <button wire:click="$dispatch('confirm-delete', { id: '{{ $category->id }}', type: 'category' })" class="flex items-center justify-center w-8 h-8 rounded-lg bg-red-50 text-red-500 hover:bg-red-100 hover:text-red-600 transition-colors shadow-sm">
                                        <i class="ki-filled ki-trash fs-5"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="py-12 text-center text-gray-400 font-bold italic">
                                <div class="flex flex-col items-center gap-2">
                                    <i class="ki-outline ki-category fs-3x opacity-50"></i>
                                    <span>No categories found.</span>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="kt-card-footer px-8 py-5 bg-gray-50/30 border-t border-gray-100">
            {{ $categories->links() }}
        </div>
    </div>

</div>

