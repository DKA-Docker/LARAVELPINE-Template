<div class="flex flex-col gap-6">
    {{-- Main Headers & Tabs --}}
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
</div>
