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
                <!-- End of Container -->
                <!-- Container -->
                {{-- @livewire("metronic.dashboards.apps.deliveries.rates.particles.headings.headings") --}}
                <div class="kt-container-fixed mb-10">
                    <div class="flex flex-col gap-2">
                        <h1 class="text-2xl font-bold text-gray-900">Create New Rate</h1>
                        <ul class="flex items-center gap-2 text-sm text-gray-500">
                             <li><a href="#" class="hover:text-primary">Dashboard</a></li>
                             <li><i class="ki-filled ki-right text-xs"></i></li>
                             <li><a href="#" class="hover:text-primary">Deliveries</a></li>
                             <li><i class="ki-filled ki-right text-xs"></i></li>
                             <li><a href="{{ route('dashboards.apps.deliveries.rates.index') }}" class="hover:text-primary">Rates</a></li>
                             <li><i class="ki-filled ki-right text-xs"></i></li>
                             <li class="text-gray-900 font-semibold">Create</li>
                        </ul>
                    </div>
                </div>
                <!-- End of Container -->
                @livewire("metronic.dashboards.apps.deliveries.rates.components.create-form")
            </main>
            <!-- End of Content -->
            @livewire("metronic.dashboards.layouts.constructors.footers")
        </div>
        <!-- End of Wrapper -->
    </div>
    <!-- End of Main -->
    </body>
</x-metronic.dashboards.layouts.container>
