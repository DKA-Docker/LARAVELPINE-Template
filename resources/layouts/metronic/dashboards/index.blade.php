<x-metronic.dashboards.layouts.container>
    <body class="text-foreground bg-background demo1 kt-sidebar-fixed kt-header-fixed flex h-full text-base antialiased">

    <style>
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-up {
            animation: fadeInUp 0.6s ease-out forwards;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .dark .glass-card {
            background: rgba(0, 0, 0, 0.2);
        }
        .channel-stats-bg {
            background-image: url('{{ asset(Storage::url("media/images/2600x1600/bg-3.png")) }}');
            transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        .channel-stats-bg:hover {
            transform: translateY(-5px) scale(1.02);
        }
    </style>

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

    <div class="flex grow dashboards-index">
        @livewire(config('theme.name', 'laravel').".dashboards.layouts.constructors.sidebars")

        <div class="kt-wrapper flex grow flex-col h-screen">
            @livewire("metronic.dashboards.layouts.constructors.headers")
            <!-- Content -->
            <main class="grow overflow-y-auto pt-5" id="content" role="content">
                <div class="kt-container-fixed pb-8">
                    <div class="flex flex-wrap items-center justify-between gap-5 pb-7.5 lg:items-end animate-fade-up">
                        <div class="flex flex-col justify-center gap-2">
                            <h1 class="text-mono text-2xl leading-none font-bold tracking-tight">Dashboard</h1>
                            <div class="text-secondary-foreground flex items-center gap-2 text-sm font-medium opacity-70">
                                <i class="ki-filled ki-chart-line text-primary"></i>
                                Logistik Satu Pintu — Real-time Overview
                            </div>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <a class="kt-btn kt-btn-primary shadow-lg shadow-primary/20 transition-transform active:scale-95" href="#">
                                <i class="ki-filled ki-user"></i> View Profile
                            </a>
                        </div>
                    </div>

                    @livewire('metronic.dashboards.overview')

                </div>
            </main>

            @livewire(config('theme.name', 'laravel').".dashboards.layouts.constructors.footers")
        </div>
    </div>



    </body>
</x-metronic.dashboards.layouts.container>
