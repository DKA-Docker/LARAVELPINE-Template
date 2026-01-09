<x-metronic.dashboards.layouts.container>
    <body class="text-foreground bg-background demo1 kt-sidebar-fixed kt-header-fixed flex h-full text-base antialiased">
    <!-- Theme Mode -->
    <script>
        (() => {
            const defaultThemeMode = 'light'
            let themeMode
            if (document.documentElement) {
                if (localStorage.getItem('kt-theme')) {
                    themeMode = localStorage.getItem('kt-theme')
                } else {
                    themeMode = defaultThemeMode
                }
                if (themeMode === 'system') {
                    themeMode = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'
                }
                document.documentElement.classList.add(themeMode)
            }
        })()
    </script>
    <!-- End of Theme Mode -->

    <div class="flex grow">
        @livewire(config('theme.name', 'laravel').".dashboards.layouts.constructors.sidebars")

        <div class="kt-wrapper flex grow flex-col h-screen">
            @livewire("metronic.dashboards.layouts.constructors.headers")
            <!-- Content -->
            <main class="grow overflow-y-auto pt-5" id="content" role="content">
                <div class="kt-container-fixed pb-8">
                    <div class="flex flex-wrap items-center justify-between gap-5 pb-7.5 lg:items-end">
                        <div class="flex flex-col justify-center gap-2">
                            <h1 class="text-mono text-2xl leading-none font-bold tracking-tight">{{ __('menu.vehicle') }}</h1>
                            <div class="text-secondary-foreground flex items-center gap-2 text-sm font-medium opacity-70">
                                Settings / Vehicles
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            @livewire('metronic.dashboards.settings.vehicles.components.view')
                        </div>
                    </div>
                </div>
            </main>
            <!-- End of Content -->
            @livewire(config('theme.name', 'laravel').".dashboards.layouts.constructors.footers")
        </div>
    </div>
    </body>
</x-metronic.dashboards.layouts.container>
