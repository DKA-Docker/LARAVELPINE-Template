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
                <div class="kt-container-fixed flex flex-col gap-5">
                    <div class="flex flex-col gap-1">
                        <h1 class="text-foreground font-semibold text-2xl">Data Rates Categories</h1>
                        <div class="text-muted-foreground text-sm">Manage your delivery rate categories here.</div>
                    </div>
                </div>
                <!-- End of Container -->
                @livewire("metronic.dashboards.apps.deliveries.rates.categories.view")
            </main>
            <!-- End of Content -->
            @livewire("metronic.dashboards.layouts.constructors.footers")
        </div>
        <!-- End of Wrapper -->
    </div>
    <!-- End of Main -->
    </body>
</x-metronic.dashboards.layouts.container>
