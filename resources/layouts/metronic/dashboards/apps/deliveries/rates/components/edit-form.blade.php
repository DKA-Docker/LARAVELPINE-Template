<div class="kt-container-fixed">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">

        @if ($errors->any())
            <div class="px-7 py-5">
                <div class="kt-card border-none bg-red-50 rounded-2xl p-5 flex items-center gap-4 animate-scale-in border border-red-100 shadow-sm">
                    <div class="w-10 h-10 rounded-xl bg-red-500 flex items-center justify-center shadow-lg shadow-red-200">
                        <i class="ki-filled ki-cross-circle text-white text-xl"></i>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-xs font-black text-red-900 uppercase tracking-widest leading-none mb-1">{{ __('dashboard.rates.edit.validation_error.title') }}</span>
                        <p class="text-[11px] text-red-600 font-bold uppercase tracking-tight">{{ __('dashboard.rates.edit.validation_error.message') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="px-7 py-5 border-b border-gray-200">

            <h3 class="font-bold text-gray-900 text-lg">Edit Rate Details</h3>
        </div>

        <div class="px-7 py-7">
            <div class="grid gap-6 mb-6">
                <!-- Name -->
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Nama Tarif</label>
                    <input wire:model="name" type="text" class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors" placeholder="e.g. Regular Shipping" />
                    @error('name') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Price -->
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Price (Rp)</label>
                    <input wire:model="price" type="number" class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors" placeholder="0" />
                    @error('price') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Category Section -->
                <div class="bg-gray-50 rounded-lg p-5 border border-gray-200/50">
                    <div class="flex items-center justify-between mb-4">
                        <label class="block text-sm font-semibold text-gray-900">Category</label>
                        <button wire:click="toggleCategoryMode" type="button" class="text-xs font-bold text-primary hover:text-primary-active uppercase tracking-wider">
                            {{ $category_mode === 'select' ? '+ Create New Category' : 'Select Existing' }}
                        </button>
                    </div>

                    @if($category_mode === 'select')
                        <select wire:model="category_id" class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors bg-white">
                            <option value="">Select Category...</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                    @else
                        <div class="space-y-4 animate-fade-in-up">
                            <div>
                                <input wire:model="new_category_name" type="text" class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors bg-white" placeholder="New Category Name" />
                                @error('new_category_name') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <textarea wire:model="new_category_description" rows="2" class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors bg-white" placeholder="Category Description (Optional)"></textarea>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Description</label>
                    <textarea wire:model="description" rows="4" class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors" placeholder="Additional details..."></textarea>
                    @error('description') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                <button wire:click="save" class="px-6 py-2.5 bg-gray-900 text-white font-bold text-sm rounded-xl hover:bg-gray-800 transition-all shadow-lg shadow-gray-200">
                    <span wire:loading.remove wire:target="save">Update Rate</span>
                    <span wire:loading wire:target="save">Updating...</span>
                </button>
                <a href="{{ route('dashboards.apps.deliveries.rates.index') }}" class="px-6 py-2.5 bg-gray-100 text-gray-600 font-bold text-sm rounded-xl hover:bg-gray-200 transition-colors">
                    Cancel
                </a>
            </div>
        </div>
    </div>
</div>
