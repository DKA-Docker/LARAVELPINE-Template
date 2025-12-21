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
        <div class="kt-wrapper flex grow flex-col">
            @livewire("metronic.dashboards.layouts.constructors.headers")
            <!-- Content -->
            <main class="grow pt-5" id="content" role="content">
                <!-- Container -->
                <div class="kt-container-fixed" id="contentContainer"></div>
                <!-- End of Container -->
                <!-- Container -->
                <div class="kt-container-fixed">
                    <div class="flex flex-wrap items-center justify-between gap-5 pb-7.5 lg:items-end">
                        <div class="flex flex-col justify-center gap-2">
                            <h1 class="text-mono text-xl leading-none font-medium">Delivery Tasks</h1>
                            <div class="flex flex-wrap items-center gap-1.5 font-medium">
                                <span class="text-secondary-foreground text-base">Semua:</span>
                                <span class="gray-800 me-2 text-base font-semibold">0</span>
                                <span class="text-green-800 text-base">Diterima:</span>
                                <span class="text-green-600 text-base font-semibold">0</span>
                                <span class="text-red-800 text-base">Ditolak:</span>
                                <span class="text-red-600 text-base font-semibold">0</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <a class="kt-btn kt-btn-outline">Import</a>
                            <a class="kt-btn kt-btn-primary" href="{{ route(preg_replace('/\.[^.]+$/', '.create.index', Route::currentRouteName())) }}">Add Account</a>
                        </div>
                    </div>
                </div>
                <!-- End of Container -->
                <!-- Container -->
             @livewire("metronic.dashboards.managements.accounts.view")
            </main>
            <!-- End of Content -->
            @livewire("metronic.dashboards.layouts.constructors.footers")
        </div>
            {{-- End Of Wrapper --}}
    </div>
    {{-- End Of Flex    --}}

        <!-- End of Page -->
        <!-- Scripts -->
        <div class="dashboards-apps-managements-accounts"/>
        <!-- End of Scripts -->
    </body>
</x-metronic.dashboards.layouts.container>
