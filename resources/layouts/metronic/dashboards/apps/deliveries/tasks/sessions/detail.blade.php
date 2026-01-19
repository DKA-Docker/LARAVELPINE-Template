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
    
    <!-- Main -->
    <div class="flex grow">
        @livewire("metronic.dashboards.layouts.constructors.sidebars")
        
        <!-- Wrapper -->
        <div class="kt-wrapper flex grow flex-col h-screen">
            @livewire("metronic.dashboards.layouts.constructors.headers")
            
            <!-- Content -->
            <main class="grow overflow-y-auto pb-8" id="content" role="content">
                <div class="kt-container-fixed"></div>
                
                <div class="kt-container-fixed">
                     {{-- Livewire Detail Component --}}
                    <livewire:metronic.dashboards.apps.deliveries.tasks.sessions.detail :sessionId="$id" />
                </div>
                
            </main>
            <!-- End of Content -->
            
            @livewire("metronic.dashboards.layouts.constructors.footers")
        </div>
        <!-- End of Wrapper -->
    </div>
    <!-- End of Main -->

    {{-- ALREADY INCLUDED IN APP.JS: --}}
    {{-- resources/theme/metronic/js/pages/dashboards/apps/deliveries/tasks/sessions/view.ts --}}
</x-metronic.dashboards.layouts.container>
