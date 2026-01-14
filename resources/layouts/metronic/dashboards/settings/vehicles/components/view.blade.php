<div class="flex flex-col gap-6">

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

    {{-- ALERT ERROR DENGAN ANIMASI --}}
    @if (session()->has('error'))
        <div class="kt-card border-none bg-red-50 rounded-2xl p-5 flex items-center gap-4 animate-scale-in border border-red-100 shadow-sm mb-6">
            <div class="w-10 h-10 rounded-xl bg-red-500 flex items-center justify-center shadow-lg shadow-red-200">
                <i class="ki-filled ki-cross-circle text-white text-xl"></i>
            </div>
            <div class="flex flex-col">
                <span class="text-xs font-black text-red-900 uppercase tracking-widest leading-none mb-1">Transaction Failed</span>
                <p class="text-[11px] text-red-600 font-bold uppercase tracking-tight">{{ session('error') }}</p>
            </div>
        </div>
    @endif

    <div class="kt-card bg-white shadow-sm rounded-2xl overflow-hidden">
        <div class="kt-card-body pt-6 pb-0 px-6 sm:px-9">
            <div class="flex flex-wrap sm:flex-nowrap justify-between items-center mb-6">
                <div>
                    <h2 class="text-xl font-bold text-gray-900 leading-none mb-2">Master Data Management</h2>
                    <p class="text-sm text-gray-500 font-medium">Manage your vehicles and categories efficiently.</p>
                </div>
            </div>

            <div class="flex overflow-x-auto border-b border-gray-200 hide-scrollbar">
                <button
                    wire:click.prevent="setTab('vehicles')"
                    class="py-4 px-6 text-sm font-bold border-b-2 transition-colors whitespace-nowrap {{ $activeTab === 'vehicles' ? 'border-primary text-primary' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}"
                >
                    Vehicles List
                </button>
                <button
                    wire:click.prevent="setTab('categories')"
                    class="py-4 px-6 text-sm font-bold border-b-2 transition-colors whitespace-nowrap {{ $activeTab === 'categories' ? 'border-primary text-primary' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}"
                >
                    Categories
                </button>
            </div>
        </div>
    </div>

    {{-- Content --}}
    <div class="animate-fade-in-up">
        @if($activeTab === 'vehicles')
            @livewire('metronic.dashboards.settings.vehicles.components.view.tabs.vehicle')
        @elseif($activeTab === 'categories')
            @livewire('metronic.dashboards.settings.vehicles.components.view.tabs.category')
        @endif
    </div>
    {{-- CUSTOM DELETE CONFIRMATION MODAL --}}

        @if($confirmingDeletion)
            <div class="fixed inset-0 z-[100] flex items-center justify-center bg-black/40 backdrop-blur-sm transition-all duration-300">
                <div class="bg-white rounded-2xl shadow-2xl w-full max-w-[400px] p-6 animate-scale-in border border-gray-100 relative">
                    {{-- Close Button --}}
                    <button wire:click="cancelDelete" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition-colors">
                        <i class="ki-filled ki-cross text-xl"></i>
                    </button>

                    <div class="flex flex-col items-center gap-4 text-center">
                        {{-- Icon Warning --}}
                        <div class="w-16 h-16 rounded-full bg-red-50 flex items-center justify-center animate-bounce-short">
                            <i class="ki-outline ki-trash text-3xl text-red-500"></i>
                        </div>

                        {{-- Content --}}
                        <div class="space-y-2">
                            <h3 class="text-lg font-bold text-gray-900">
                                Delete {{ ucfirst($deleteType) }}?
                            </h3>
                            <p class="text-sm text-gray-500 leading-relaxed px-4">
                                Are you sure you want to delete this {{ $deleteType }}? This action cannot be undone.
                            </p>
                        </div>

                        {{-- Actions --}}
                        <div class="flex items-center gap-3 w-full mt-2">
                            <button wire:click="cancelDelete" class="flex-1 px-4 py-2.5 rounded-xl bg-gray-100 text-gray-600 font-bold text-sm hover:bg-gray-200 transition-colors">
                                Cancel
                            </button>
                            <button wire:click="deleteConfirmed" class="flex-1 px-4 py-2.5 rounded-xl bg-red-600 text-white font-bold text-sm hover:bg-red-700 transition-colors shadow-lg shadow-red-200">
                                Yes, Delete It
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

</div>
