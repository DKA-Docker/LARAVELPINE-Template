<x-metronic.dashboards.layouts.container>
    <body class="text-foreground bg-background demo1 kt-sidebar-fixed kt-header-fixed flex h-full text-base antialiased">
    <div class="flex grow">
        @livewire("metronic.dashboards.layouts.constructors.sidebars")
        <div class="kt-wrapper flex grow flex-col h-screen">
            @livewire("metronic.dashboards.layouts.constructors.headers")
            <main class="grow overflow-y-auto pb-8" id="content" role="content">
                <div class="kt-container-fixed">
                    <div class="flex flex-wrap items-center justify-between gap-5 pb-7.5 lg:items-end">
                        <div class="flex flex-col justify-center gap-2">
                            <h1 class="text-mono text-xl leading-none font-medium">Create New Category</h1>
                        </div>
                    </div>
                </div>
                <div class="kt-container-fixed">
                    <div class="gap-5 lg:gap-7.5 mx-auto">
                        @livewire("metronic.dashboards.settings.vehicles.components.category.create-form")
                    </div>
                </div>
            </main>
            @livewire("metronic.dashboards.layouts.constructors.footers")
        </div>
    </div>
</x-metronic.dashboards.layouts.container>
