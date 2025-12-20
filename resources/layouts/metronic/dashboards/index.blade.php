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
    </script>

    <div class="flex grow">
        @livewire(config('theme.name', 'laravel').".dashboards.layouts.constructors.sidebars")

        <div class="kt-wrapper flex grow flex-col">
            @livewire(config('theme.name', 'laravel').".dashboards.layouts.constructors.headers")

            <main class="grow pt-5" id="content" role="main">
                <div class="kt-container-fixed">
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

                    <div class="grid gap-5 lg:gap-7.5">
                        <div class="grid items-stretch gap-y-5 lg:grid-cols-3 lg:gap-7.5">
                            <div class="lg:col-span-1">
                                <div class="grid h-full grid-cols-2 items-stretch gap-5 lg:gap-6">
                                    @php
                                        $stats = [
                                            ['label' => 'Permintaan Pengiriman', 'value' => '0', 'delay' => '100ms'],
                                            ['label' => 'Sedang Dikirim', 'value' => '0', 'delay' => '200ms'],
                                            ['label' => 'Pengiriman Tertunda', 'value' => '0', 'delay' => '300ms'],
                                            ['label' => 'Pengiriman Selesai', 'value' => '0', 'delay' => '400ms'],
                                        ];
                                    @endphp
                                    @foreach($stats as $stat)
                                        <div class="kt-card channel-stats-bg glass-card group flex-col justify-between gap-6 bg-cover bg-no-repeat p-5 shadow-sm border-transparent hover:border-primary/30 animate-fade-up" style="animation-delay: {{ $stat['delay'] }}">
                                            <div class="flex flex-col gap-1">
                                                <span class="text-mono text-4xl font-extrabold group-hover:text-primary transition-colors">{{ $stat['value'] }}</span>
                                                <span class="text-secondary-foreground text-xs font-semibold uppercase tracking-wider opacity-80">{{ $stat['label'] }}</span>
                                            </div>
                                            <div class="flex justify-end opacity-0 group-hover:opacity-100 transition-opacity">
                                                <i class="ki-filled ki-arrow-right text-primary text-xl"></i>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="lg:col-span-2 animate-fade-up" style="animation-delay: 500ms">
                                <div class="kt-card h-full shadow-xl border-none ring-1 ring-black/5 dark:ring-white/5">
                                    <div class="kt-card-header flex items-center justify-between px-6 py-4">
                                        <h3 class="kt-card-title font-bold text-lg">Status Driver</h3>
                                        <div class="kt-input max-w-56 group border-transparent bg-secondary/30 rounded-full px-4 focus-within:ring-2 focus-within:ring-primary/50 transition-all">
                                            <i class="ki-filled ki-magnifier text-muted-foreground group-focus-within:text-primary"></i>
                                            <input class="bg-transparent border-none focus:ring-0 text-sm" data-kt-datatable-search="#kt_datatable_1" placeholder="Search Driver..." type="text" />
                                        </div>
                                    </div>
                                    <div class="kt-card-table p-0">
                                        <div class="grid" data-kt-datatable="true" data-kt-datatable-page-size="5" id="teams_datatable">
                                            <div class="kt-scrollable-x-auto">
                                                <table class="kt-table table-fixed w-full" id="kt_datatable_1">
                                                    <thead class="bg-secondary/10 border-b border-secondary/20">
                                                    <tr>
                                                        <th class="w-[50px] px-6 py-4"><input class="kt-checkbox kt-checkbox-sm" type="checkbox" /></th>
                                                        <th class="w-[280px] px-4 font-bold text-xs uppercase text-muted-foreground">Team & Info</th>
                                                        <th class="w-[125px] px-4 font-bold text-xs uppercase text-muted-foreground text-center">Rating</th>
                                                        <th class="w-[135px] px-4 font-bold text-xs uppercase text-muted-foreground">Last Modified</th>
                                                        <th class="w-[125px] px-4 font-bold text-xs uppercase text-muted-foreground">Members</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody class="divide-y divide-secondary/10">
                                                    <tr class="hover:bg-primary/5 transition-colors group cursor-pointer">
                                                        <td class="px-6 py-4"><input class="kt-checkbox kt-checkbox-sm" type="checkbox" /></td>
                                                        <td class="px-4 py-4">
                                                            <div class="flex flex-col gap-1">
                                                                <a class="text-mono font-bold text-sm group-hover:text-primary transition-colors" href="#">Product Management</a>
                                                                <span class="text-xs text-secondary-foreground opacity-60">Product development & lifecycle</span>
                                                            </div>
                                                        </td>
                                                        <td class="px-4 py-4 text-center">
                                                            <div class="kt-rating justify-center">
                                                                @for($i=0; $i<5; $i++) <i class="ki-solid ki-star text-yellow-400 text-xs"></i> @endfor
                                                            </div>
                                                        </td>
                                                        <td class="px-4 py-4 text-sm text-secondary-foreground">21 Oct, 2024</td>
                                                        <td class="px-4 py-4">
                                                            <div class="flex -space-x-3">
                                                                <img class="size-8 rounded-full ring-2 ring-background group-hover:-translate-y-1 transition-transform" src="{{ asset(Storage::url('media/avatars/300-4.png')) }}">
                                                                <img class="size-8 rounded-full ring-2 ring-background group-hover:-translate-y-1 transition-transform delay-75" src="{{ asset(Storage::url('media/avatars/300-1.png')) }}">
                                                                <span class="size-8 rounded-full ring-2 ring-background bg-primary/10 text-primary text-[10px] flex items-center justify-center font-bold">+10</span>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="px-6 py-4 flex items-center justify-between border-t border-secondary/10">
                                                <div class="text-xs text-muted-foreground font-medium">Showing 5 per page</div>
                                                <div class="kt-datatable-pagination"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>

            @livewire(config('theme.name', 'laravel').".dashboards.layouts.constructors.footers")
        </div>
    </div>

    </body>
</x-metronic.dashboards.layouts.container>
