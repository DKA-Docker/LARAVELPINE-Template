<div class="flex flex-col gap-6">
    {{-- Main Headers --}}
    <div class="kt-card bg-white shadow-sm rounded-2xl overflow-hidden">
        <div class="kt-card-body pt-6 pb-6 px-6 sm:px-9">
            <div class="flex flex-wrap sm:flex-nowrap justify-between items-center">
                <div>
                    <h2 class="text-xl font-bold text-gray-900 leading-none mb-2">Edit Category</h2>
                    <p class="text-sm text-gray-500 font-medium">Update vehicle category details.</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Content --}}
    <div class="animate-fade-in-up">
        <div class="space-y-8 animate-fade-in">
            @if ($errors->any())
                <div class="kt-card border-none bg-red-50 rounded-2xl p-5 flex items-center gap-4 animate-scale-in border border-red-100 shadow-sm">
                    <div class="w-10 h-10 rounded-xl bg-red-500 flex items-center justify-center shadow-lg shadow-red-200">
                        <i class="ki-filled ki-cross-circle text-white text-xl"></i>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-xs font-black text-red-900 uppercase tracking-widest leading-none mb-1">Validation Error</span>
                        <p class="text-[11px] text-red-600 font-bold uppercase tracking-tight">Please check the form for errors.</p>
                    </div>
                </div>
            @endif

            <div class="kt-card border-none shadow-xl shadow-gray-100 rounded-3xl overflow-hidden ring-1 ring-gray-100">
                <div class="p-6 border-b border-gray-50 bg-gray-50/50">
                    <h3 class="text-sm font-black text-gray-800 uppercase tracking-widest flex items-center gap-2">
                        <i class="ki-filled ki-category text-blue-600"></i> Category Details
                    </h3>
                </div>

                <div class="p-8">
                    <form wire:submit.prevent="update" class="flex flex-col gap-8">
                        {{-- Name --}}
                        <div class="flex flex-col gap-2">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-wider ml-1">Name</label>
                            <input type="text" wire:model="name" class="kt-input h-14 rounded-2xl border-gray-100 focus:ring-4 focus:ring-blue-50 font-bold text-gray-700 shadow-sm transition-all pl-4" placeholder="Enter category name" />
                            @error('name') <span class="text-red-500 text-[10px] font-bold ml-1 italic">{{ $message }}</span> @enderror
                        </div>

                        {{-- Description --}}
                        <div class="flex flex-col gap-2">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-wider ml-1">Description</label>
                            <textarea wire:model="description" class="kt-input rounded-2xl border-gray-100 focus:ring-4 focus:ring-blue-50 font-bold text-gray-700 shadow-sm transition-all p-4 resize-none" rows="6" placeholder="Enter description"></textarea>
                            @error('description') <span class="text-red-500 text-[10px] font-bold ml-1 italic">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex items-center justify-end gap-5 pt-4">
                            <a href="{{ route('dashboards.settings.vehicles.index') }}" class="text-[10px] font-black uppercase tracking-widest text-gray-400 hover:text-red-500 transition-colors">
                                Cancel
                            </a>
                            <button type="submit" class="group relative overflow-hidden bg-gray-900 px-12 py-5 rounded-2xl shadow-2xl transition-all hover:bg-emerald-600 active:scale-95 disabled:opacity-50">
                                <div class="relative z-10 flex items-center gap-3">
                                    <span wire:loading.remove class="text-[11px] font-black text-white uppercase tracking-[0.2em]">Save Changes</span>
                                    <span wire:loading class="text-[11px] font-black text-white uppercase tracking-[0.2em]">Saving...</span>
                                    <i class="ki-filled ki-check-circle text-emerald-400 group-hover:text-white transition-colors"></i>
                                </div>
                                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-full group-hover:animate-shimmer"></div>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes fade-in { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes scale-in { from { transform: scale(0.9); opacity: 0; } to { transform: scale(1); opacity: 1; } }
        @keyframes shimmer { 100% { transform: translateX(100%); } }
        .animate-fade-in { animation: fade-in 0.5s ease-out forwards; }
        .animate-scale-in { animation: scale-in 0.3s cubic-bezier(0.34, 1.56, 0.64, 1) forwards; }
        .animate-shimmer { animation: shimmer 2s infinite; }
        .animate-fade-in-up { animation: fade-in 0.5s ease-out forwards; }
    </style>
</div>
