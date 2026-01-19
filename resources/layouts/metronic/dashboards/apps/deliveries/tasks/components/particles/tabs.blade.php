<div class="kt-container-fixed">
    <div class="kt-tabs kt-tabs-line mb-5 mt-5" data-kt-tabs="true">
        <button class="kt-tab-toggle active group py-3 px-5 border-b-2 border-transparent hover:border-primary focus:border-primary text-gray-400 hover:text-primary active:text-primary active:border-primary flex items-center gap-2 font-medium transition-all [&.active]:text-primary [&.active]:border-primary" data-kt-tab-toggle="#tab_tasks">
            <i class="ki-duotone ki-calendar-tick text-lg group-[.active]:text-primary text-gray-400 group-hover:text-primary"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
            Tasks
        </button>
        @can('dashboards.apps.deliveries.tasks.sessions.view')
            <button class="kt-tab-toggle py-3 px-5 border-b-2 border-transparent hover:border-primary focus:border-primary text-gray-400 hover:text-primary active:text-primary active:border-primary flex items-center gap-2 font-medium transition-all [&.active]:text-primary [&.active]:border-primary" data-kt-tab-toggle="#tab_sessions">
                <i class="ki-duotone ki-user-tick text-lg group-[.active]:text-primary text-gray-400 group-hover:text-primary"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                Sessions
            </button>
        @endcan
    </div>

    <div class="block" id="tab_tasks">
        @livewire("metronic.dashboards.apps.deliveries.tasks.components.particles.headings.headings")
        @livewire("metronic.dashboards.apps.deliveries.tasks.components.view")
    </div>

    @can('dashboards.apps.deliveries.tasks.sessions.view')
        <div class="hidden" id="tab_sessions">
             @livewire("metronic.dashboards.apps.deliveries.tasks.sessions.view")
        </div>
    @endcan
</div>
