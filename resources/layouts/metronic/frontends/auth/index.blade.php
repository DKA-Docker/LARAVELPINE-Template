<x-metronic.frontends.layouts.container>
    <body class="antialiased flex h-full text-base text-foreground bg-background">
    <!-- Theme Mode -->
    <script>
        const defaultThemeMode = 'light'; // light|dark|system
        let themeMode;

        if (document.documentElement) {
            if (localStorage.getItem('kt-theme')) {
                themeMode = localStorage.getItem('kt-theme');
            } else if (
                document.documentElement.hasAttribute('data-kt-theme-mode')
            ) {
                themeMode =
                    document.documentElement.getAttribute('data-kt-theme-mode');
            } else {
                themeMode = defaultThemeMode;
            }

            if (themeMode === 'system') {
                themeMode = window.matchMedia('(prefers-color-scheme: dark)').matches
                    ? 'dark'
                    : 'light';
            }

            document.documentElement.classList.add(themeMode);
        }
    </script>
    <!-- End of Theme Mode -->
    <!-- Page -->
    <style>
        .page-bg {
            background-image: url({{ asset(Storage::url("media/images/2600x1200/bg-10.png")) }});
        }
        .dark .page-bg {
            background-image: url({{ asset(Storage::url("media/images/2600x1200/bg-10-dark.png")) }});
        }
    </style>
    @livewire(config('theme.name', 'laravel').".frontends.auth.components.login")
    <!-- End of Page -->
    <!-- Scripts -->
    <div class="frontend-auth"/>
    <!-- End of Scripts -->
    </body>
</x-metronic.frontends.layouts.container>
