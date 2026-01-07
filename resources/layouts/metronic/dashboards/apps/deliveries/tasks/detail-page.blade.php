<x-metronic.dashboards.layouts.container>
    <body class="text-foreground bg-background demo1 kt-sidebar-fixed kt-header-fixed flex h-full text-base antialiased">
    <!-- Theme Mode -->
    <script>
        const defaultThemeMode = 'light' // light|dark|system
        let themeMode

        if (document.documentElement) {
            if (localStorage.getItem('kt-theme')) {
                themeMode = localStorage.getItem('kt-theme')
            } else if (document.documentElement.hasAttribute('data-kt-theme-mode')) {
                themeMode = document.documentElement.getAttribute('data-kt-theme-mode')
            } else {
                themeMode = defaultThemeMode
            }

            if (themeMode === 'system') {
                themeMode = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'
            }

            document.documentElement.classList.add(themeMode)
        }
    </script>
    <!-- End of Theme Mode -->
    <!-- Page -->
    <!-- Main -->
    <div class="flex grow">
        @livewire("metronic.dashboards.layouts.constructors.sidebars")
        <!-- Wrapper -->
        <div class="kt-wrapper flex grow flex-col h-screen">
            @livewire("metronic.dashboards.layouts.constructors.headers")
            <!-- Content -->
            <main class="grow overflow-y-auto pb-8" id="content" role="content">
                <div class="kt-container-fixed"></div>
                 <!-- Container -->
                 <div class="kt-container-fixed mb-5">
                    @section('breadcrumbs')
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('dashboards.apps.deliveries.tasks.index') }}" class="text-muted text-hover-primary">
                                Tasks
                            </a>
                        </li>
                        <li class="breadcrumb-item text-muted">
                            <span class="bullet bg-gray-300 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">
                            Detail
                        </li>
                    @endsection
                 </div>
                 
                 <!-- Detail Component -->
                <div class="kt-container-fixed">
                     @livewire('metronic.dashboards.apps.deliveries.tasks.components.detail', ['taskId' => $task->id])
                </div>
            </main>
            <!-- End of Content -->
            @livewire("metronic.dashboards.layouts.constructors.footers")
        </div>
        <!-- End of Wrapper -->
    </div>
    <!-- End of Main -->
     <!-- Modals from Index if needed, omitted here for cleanliness unless requested -->
     </body>
</x-metronic.dashboards.layouts.container>
