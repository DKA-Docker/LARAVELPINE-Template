<div>
    {{-- Header / Tabs --}}
    <div class="kt-card mb-5 mb-xl-10 bg-white shadow-sm rounded-2xl overflow-hidden">
        <div class="kt-card-body pt-9 pb-0 px-9">
            {{-- Details Basic --}}
            <div class="flex flex-wrap sm:flex-nowrap mb-6">
                {{-- Icon/Image Placeholder --}}
                <div class="me-7 mb-4">
                    <div class="relative w-[100px] h-[100px] lg:w-[160px] lg:h-[160px] bg-primary/5 rounded-xl flex items-center justify-center">
                         <i class="ki-duotone ki-delivery-24 text-primary fs-3x"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                    </div>
                </div>

                <div class="grow">
                    <div class="flex justify-between items-start flex-wrap mb-2">
                        <div class="flex flex-col">
                            <div class="flex items-center mb-2">
                                <a href="#" class="text-gray-900 hover:text-primary text-2xl font-bold me-2">{{ data_get($task, 'name', 'Task Name') }}</a>
                                <span class="px-3 py-1 rounded-lg bg-green-50 text-green-600 text-xs font-bold uppercase tracking-wide">
                                   {{ data_get($task, 'history.0.to_status', 'Pending') }}
                                </span>
                            </div>
                            <div class="flex flex-wrap font-semibold text-gray-400 text-sm mb-4 gap-4">
                                <div class="flex items-center gap-1">
                                    <i class="ki-filled ki-user text-gray-400"></i>
                                    {{ data_get($task, 'destination.request.account.information.first_name', 'N/A') }}
                                </div>
                                <div class="flex items-center gap-1">
                                    <i class="ki-filled ki-geolocation text-gray-400"></i>
                                    {{ data_get($task, 'destination.receipt_address', 'No Address') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tabs --}}
            <div class="flex overflow-x-auto border-b border-gray-200">
                <button 
                    wire:click.prevent="setActiveTab('general')" 
                    class="py-4 px-6 text-sm font-bold border-b-2 transition-colors whitespace-nowrap {{ $activeTab === 'general' ? 'border-primary text-primary' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}"
                >
                    General
                </button>
                <button 
                    wire:click.prevent="setActiveTab('assigned')" 
                    class="py-4 px-6 text-sm font-bold border-b-2 transition-colors whitespace-nowrap {{ $activeTab === 'assigned' ? 'border-primary text-primary' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}"
                >
                    Data Assigned
                </button>
                <button 
                    wire:click.prevent="setActiveTab('geo')" 
                    class="py-4 px-6 text-sm font-bold border-b-2 transition-colors whitespace-nowrap {{ $activeTab === 'geo' ? 'border-primary text-primary' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}"
                >
                    Geo Location
                </button>
                <button 
                    wire:click.prevent="setActiveTab('history')" 
                    class="py-4 px-6 text-sm font-bold border-b-2 transition-colors whitespace-nowrap {{ $activeTab === 'history' ? 'border-primary text-primary' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}"
                >
                    History
                </button>
            </div>
        </div>
    </div>

    {{-- Content --}}
    <div class="kt-card bg-white shadow-sm rounded-2xl p-9 animate-fade-in-up">
        @if($activeTab === 'general')
            <livewire:metronic.dashboards.apps.deliveries.tasks.components.view.tabs.general :task="$task" wire:key="tab-general" lazy />
        @elseif($activeTab === 'assigned')
            <livewire:metronic.dashboards.apps.deliveries.tasks.components.view.tabs.assigned :task="$task" wire:key="tab-assigned" lazy />
        @elseif($activeTab === 'geo')
            <livewire:metronic.dashboards.apps.deliveries.tasks.components.view.tabs.geo :task="$task" wire:key="tab-geo" lazy />
        @elseif($activeTab === 'history')
            <livewire:metronic.dashboards.apps.deliveries.tasks.components.view.tabs.history :task="$task" wire:key="tab-history" lazy />
        @endif
    </div>
</div>
```
