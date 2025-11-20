<!DOCTYPE html>
<html class="h-full" data-kt-theme="true" data-kt-theme-mode="dark" dir="ltr" lang="en">
    <head>
        <title>{{ config("app.name", "Laravel") }}</title>
        <meta charset="utf-8" />
        <meta content="follow, index" name="robots" />
        <link href="#" rel="canonical" />
        <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport" />
        <meta content="" name="description" />
        <meta content="@keenthemes" name="twitter:site" />
        <meta content="@keenthemes" name="twitter:creator" />
        <meta content="summary_large_image" name="twitter:card" />
        <meta content="Metronic - Tailwind CSS " name="twitter:title" />
        <meta content="" name="twitter:description" />
        <meta content="assets/media/app/og-image.png" name="twitter:image" />
        <meta content="https://127.0.0.1:8001/metronic-tailwind-html/demo1/index.html" property="og:url" />
        <meta content="en_US" property="og:locale" />
        <meta content="website" property="og:type" />
        <meta content="@keenthemes" property="og:site_name" />
        <meta content="Metronic - Tailwind CSS " property="og:title" />
        <meta content="" property="og:description" />
        <meta content="assets/media/app/og-image.png" property="og:image" />
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
        <!-- Styles / Scripts -->
        @if (file_exists(public_path("build/manifest.json")) || file_exists(public_path("hot")))
            @vite(["resources/theme/" . config("theme.name", "laravel") . "/css/app.css", "resources/theme/" . config("theme.name", "laravel") . "/js/app.ts"])
        @endif

        @livewireStyles
    </head>
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
            @livewire(config('theme.name', 'laravel').".dashboards.layouts.constructors.sidebars")
            <!-- Wrapper -->
            <div class="kt-wrapper flex grow flex-col">
                @livewire(config('theme.name', 'laravel').".dashboards.layouts.constructors.headers")
                <!-- Content -->
                <main class="grow pt-5" id="content" role="content">
                    <!-- Container -->
                    <div class="kt-container-fixed" id="contentContainer"></div>
                    <!-- End of Container -->
                    <!-- Container -->
                    <div class="kt-container-fixed">
                        <div class="flex flex-wrap items-center justify-between gap-5 pb-7.5 lg:items-end">
                            <div class="flex flex-col justify-center gap-2">
                                <h1 class="text-mono text-xl leading-none font-medium">Dashboard</h1>
                                <div class="text-secondary-foreground flex items-center gap-2 text-sm font-normal">Dashboard Logistik Satu Pintu</div>
                            </div>
                            <div class="flex items-center gap-2.5">
                                <a class="kt-btn kt-btn-outline" href="#">View Profile</a>
                            </div>
                        </div>
                    </div>
                    <!-- End of Container -->
                    <!-- Container -->
                    <div class="kt-container-fixed">
                        <div class="grid gap-5 lg:gap-7.5">
                            <!-- begin: grid -->
                            <div class="grid items-stretch gap-y-5 lg:grid-cols-3 lg:gap-7.5">
                                <div class="lg:col-span-1">
                                    <div class="grid h-full grid-cols-2 items-stretch gap-5 lg:gap-7.5">
                                        <style>
                                            .channel-stats-bg {
                                                background-image: url('{{ asset(Storage::url("media/images/2600x1600/bg-3.png")) }}');
                                            }

                                            .dark .channel-stats-bg {
                                                background-image: url('{{ asset(Storage::url("media/images/2600x1600/bg-3-dark.png")) }}');
                                            }
                                        </style>
                                        <div class="kt-card channel-stats-bg h-full flex-col justify-between gap-6 bg-cover bg-[right_top_-1.7rem] bg-no-repeat rtl:bg-[left_top_-1.7rem]">
                                            <div class="flex flex-col gap-1 px-5 pt-3 pb-4">
                                                <span class="text-mono text-3xl font-semibold">0</span>
                                                <span class="text-secondary-foreground text-sm font-normal">Permintaan Pengiriman</span>
                                            </div>
                                        </div>
                                        <div class="kt-card channel-stats-bg h-full flex-col justify-between gap-6 bg-cover bg-[right_top_-1.7rem] bg-no-repeat rtl:bg-[left_top_-1.7rem]">
                                            <div class="flex flex-col gap-1 px-5 pt-3 pb-4">
                                                <span class="text-mono text-3xl font-semibold">0</span>
                                                <span class="text-secondary-foreground text-sm font-normal">Sedang Dikirim</span>
                                            </div>
                                        </div>
                                        <div class="kt-card channel-stats-bg h-full flex-col justify-between gap-6 bg-cover bg-[right_top_-1.7rem] bg-no-repeat rtl:bg-[left_top_-1.7rem]">
                                            <div class="flex flex-col gap-1 px-5 pt-3 pb-4">
                                                <span class="text-mono text-3xl font-semibold">0</span>
                                                <span class="text-secondary-foreground text-sm font-normal">Pengiriman Tertunda</span>
                                            </div>
                                        </div>
                                        <div class="kt-card channel-stats-bg h-full flex-col justify-between gap-6 bg-cover bg-[right_top_-1.7rem] bg-no-repeat rtl:bg-[left_top_-1.7rem]">
                                            <div class="flex flex-col gap-1 px-5 pt-3 pb-4">
                                                <span class="text-mono text-3xl font-semibold">0</span>
                                                <span class="text-secondary-foreground text-sm font-normal">Pengiriman Selesai</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="lg:col-span-2">
                                    <div class="grid">
                                        <div class="kt-card kt-card-grid h-full min-w-full">
                                            <div class="kt-card-header">
                                                <h3 class="kt-card-title">Status Driver</h3>
                                                <div class="kt-input max-w-48">
                                                    <i class="ki-filled ki-magnifier"></i>
                                                    <input data-kt-datatable-search="#kt_datatable_1" placeholder="Search Teams" type="text" />
                                                </div>
                                            </div>
                                            <div class="kt-card-table">
                                                <div class="grid" data-kt-datatable="true" data-kt-datatable-page-size="5" id="teams_datatable">
                                                    <div class="kt-scrollable-x-auto">
                                                        <table class="kt-table kt-table-border table-fixed" data-kt-datatable-table="true" id="kt_datatable_1">
                                                            <thead>
                                                                <tr>
                                                                    <th class="w-[50px]">
                                                                        <input class="kt-checkbox kt-checkbox-sm" data-kt-datatable-check="true" type="checkbox" />
                                                                    </th>
                                                                    <th class="w-[280px]">
                                                                        <span class="kt-table-col">
                                                                            <span class="kt-table-col-label">Team</span>
                                                                            <span class="kt-table-col-sort"></span>
                                                                        </span>
                                                                    </th>
                                                                    <th class="w-[125px]">
                                                                        <span class="kt-table-col">
                                                                            <span class="kt-table-col-label">Rating</span>
                                                                            <span class="kt-table-col-sort"></span>
                                                                        </span>
                                                                    </th>
                                                                    <th class="w-[135px]">
                                                                        <span class="kt-table-col">
                                                                            <span class="kt-table-col-label">Last Modified</span>
                                                                            <span class="kt-table-col-sort"></span>
                                                                        </span>
                                                                    </th>
                                                                    <th class="w-[125px]">
                                                                        <span class="kt-table-col">
                                                                            <span class="kt-table-col-label">Members</span>
                                                                            <span class="kt-table-col-sort"></span>
                                                                        </span>
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>
                                                                        <input class="kt-checkbox kt-checkbox-sm" data-kt-datatable-row-check="true" type="checkbox" value="1" />
                                                                    </td>
                                                                    <td>
                                                                        <div class="flex flex-col gap-2">
                                                                            <a class="text-mono hover:text-primary text-sm leading-none font-medium" href="#">Product Management</a>
                                                                            <span class="text-2sm text-secondary-foreground leading-3 font-normal">Product development & lifecycle</span>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="kt-rating">
                                                                            <div class="kt-rating-label checked">
                                                                                <i class="kt-rating-on ki-solid ki-star text-base leading-none"></i>
                                                                                <i class="kt-rating-off ki-outline ki-star text-base leading-none"></i>
                                                                            </div>
                                                                            <div class="kt-rating-label checked">
                                                                                <i class="kt-rating-on ki-solid ki-star text-base leading-none"></i>
                                                                                <i class="kt-rating-off ki-outline ki-star text-base leading-none"></i>
                                                                            </div>
                                                                            <div class="kt-rating-label checked">
                                                                                <i class="kt-rating-on ki-solid ki-star text-base leading-none"></i>
                                                                                <i class="kt-rating-off ki-outline ki-star text-base leading-none"></i>
                                                                            </div>
                                                                            <div class="kt-rating-label checked">
                                                                                <i class="kt-rating-on ki-solid ki-star text-base leading-none"></i>
                                                                                <i class="kt-rating-off ki-outline ki-star text-base leading-none"></i>
                                                                            </div>
                                                                            <div class="kt-rating-label checked">
                                                                                <i class="kt-rating-on ki-solid ki-star text-base leading-none"></i>
                                                                                <i class="kt-rating-off ki-outline ki-star text-base leading-none"></i>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td>21 Oct, 2024</td>
                                                                    <td>
                                                                        <div class="flex -space-x-2">
                                                                            <div class="flex">
                                                                                <img
                                                                                    class="ring-background relative size-[30px] shrink-0 rounded-full ring-1 hover:z-5"
                                                                                    src="{{ asset(Storage::url("media/avatars/300-4.png")) }}"
                                                                                    alt=""
                                                                                />
                                                                            </div>
                                                                            <div class="flex">
                                                                                <img
                                                                                    class="ring-background relative size-[30px] shrink-0 rounded-full ring-1 hover:z-5"
                                                                                    src="{{ asset(Storage::url("media/avatars/300-1.png")) }}"
                                                                                    alt=""
                                                                                />
                                                                            </div>
                                                                            <div class="flex">
                                                                                <img
                                                                                    class="ring-background relative size-[30px] shrink-0 rounded-full ring-1 hover:z-5"
                                                                                    src="{{ asset(Storage::url("media/avatars/300-2.png")) }}"
                                                                                    alt=""
                                                                                />
                                                                            </div>
                                                                            <div class="flex">
                                                                                <span
                                                                                    class="text-2xs ring-background relative inline-flex size-[30px] shrink-0 items-center justify-center rounded-full bg-green-500 leading-none font-semibold text-white ring-1"
                                                                                >
                                                                                    +10
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <input class="kt-checkbox kt-checkbox-sm" data-kt-datatable-row-check="true" type="checkbox" value="2" />
                                                                    </td>
                                                                    <td>
                                                                        <div class="flex flex-col gap-2">
                                                                            <a class="text-mono hover:text-primary text-sm leading-none font-medium" href="#">Marketing Team</a>
                                                                            <span class="text-2sm text-secondary-foreground leading-3 font-normal">Campaigns & market analysis</span>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="kt-rating">
                                                                            <div class="kt-rating-label checked">
                                                                                <i class="kt-rating-on ki-solid ki-star text-base leading-none"></i>
                                                                                <i class="kt-rating-off ki-outline ki-star text-base leading-none"></i>
                                                                            </div>
                                                                            <div class="kt-rating-label checked">
                                                                                <i class="kt-rating-on ki-solid ki-star text-base leading-none"></i>
                                                                                <i class="kt-rating-off ki-outline ki-star text-base leading-none"></i>
                                                                            </div>
                                                                            <div class="kt-rating-label checked">
                                                                                <i class="kt-rating-on ki-solid ki-star text-base leading-none"></i>
                                                                                <i class="kt-rating-off ki-outline ki-star text-base leading-none"></i>
                                                                            </div>
                                                                            <div class="kt-rating-label indeterminate">
                                                                                <i class="kt-rating-on ki-solid ki-star text-base leading-none" style="width: 50%"></i>
                                                                                <i class="kt-rating-off ki-outline ki-star text-base leading-none"></i>
                                                                            </div>
                                                                            <div class="kt-rating-label">
                                                                                <i class="kt-rating-on ki-solid ki-star text-base leading-none"></i>
                                                                                <i class="kt-rating-off ki-outline ki-star text-base leading-none"></i>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td>15 Oct, 2024</td>
                                                                    <td>
                                                                        <div class="flex -space-x-2">
                                                                            <div class="flex">
                                                                                <img
                                                                                    class="ring-background relative size-[30px] shrink-0 rounded-full ring-1 hover:z-5"
                                                                                    src="{{ asset(Storage::url("media/avatars/300-4.png")) }}"
                                                                                    alt=""
                                                                                />
                                                                            </div>
                                                                            <div class="flex">
                                                                                <span
                                                                                    class="text-2xs ring-background relative inline-flex size-[30px] shrink-0 items-center justify-center rounded-full bg-yellow-500 leading-none font-semibold text-white uppercase ring-1 hover:z-5"
                                                                                >
                                                                                    g
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <input class="kt-checkbox kt-checkbox-sm" data-kt-datatable-row-check="true" type="checkbox" value="3" />
                                                                    </td>
                                                                    <td>
                                                                        <div class="flex flex-col gap-2">
                                                                            <a class="text-mono hover:text-primary text-sm leading-none font-medium" href="#">HR Department</a>
                                                                            <span class="text-2sm text-secondary-foreground leading-3 font-normal">Talent acquisition, employee welfare</span>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="kt-rating">
                                                                            <div class="kt-rating-label checked">
                                                                                <i class="kt-rating-on ki-solid ki-star text-base leading-none"></i>
                                                                                <i class="kt-rating-off ki-outline ki-star text-base leading-none"></i>
                                                                            </div>
                                                                            <div class="kt-rating-label checked">
                                                                                <i class="kt-rating-on ki-solid ki-star text-base leading-none"></i>
                                                                                <i class="kt-rating-off ki-outline ki-star text-base leading-none"></i>
                                                                            </div>
                                                                            <div class="kt-rating-label checked">
                                                                                <i class="kt-rating-on ki-solid ki-star text-base leading-none"></i>
                                                                                <i class="kt-rating-off ki-outline ki-star text-base leading-none"></i>
                                                                            </div>
                                                                            <div class="kt-rating-label checked">
                                                                                <i class="kt-rating-on ki-solid ki-star text-base leading-none"></i>
                                                                                <i class="kt-rating-off ki-outline ki-star text-base leading-none"></i>
                                                                            </div>
                                                                            <div class="kt-rating-label checked">
                                                                                <i class="kt-rating-on ki-solid ki-star text-base leading-none"></i>
                                                                                <i class="kt-rating-off ki-outline ki-star text-base leading-none"></i>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td>10 Oct, 2024</td>
                                                                    <td>
                                                                        <div class="flex -space-x-2">
                                                                            <div class="flex">
                                                                                <img
                                                                                    class="ring-background relative size-[30px] shrink-0 rounded-full ring-1 hover:z-5"
                                                                                    src="{{ asset(Storage::url("media/avatars/300-4.png")) }}"
                                                                                    alt=""
                                                                                />
                                                                            </div>
                                                                            <div class="flex">
                                                                                <img
                                                                                    class="ring-background relative size-[30px] shrink-0 rounded-full ring-1 hover:z-5"
                                                                                    src="{{ asset(Storage::url("media/avatars/300-1.png")) }}"
                                                                                    alt=""
                                                                                />
                                                                            </div>
                                                                            <div class="flex">
                                                                                <img
                                                                                    class="ring-background relative size-[30px] shrink-0 rounded-full ring-1 hover:z-5"
                                                                                    src="{{ asset(Storage::url("media/avatars/300-2.png")) }}"
                                                                                    alt=""
                                                                                />
                                                                            </div>
                                                                            <div class="flex">
                                                                                <span
                                                                                    class="text-2xs ring-background relative inline-flex size-[30px] shrink-0 items-center justify-center rounded-full bg-violet-500 leading-none font-semibold text-white ring-1"
                                                                                >
                                                                                    +A
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <input class="kt-checkbox kt-checkbox-sm" data-kt-datatable-row-check="true" type="checkbox" value="4" />
                                                                    </td>
                                                                    <td>
                                                                        <div class="flex flex-col gap-2">
                                                                            <a class="text-mono hover:text-primary text-sm leading-none font-medium" href="#">Sales Division</a>
                                                                            <span class="text-2sm text-secondary-foreground leading-3 font-normal">Customer relations, sales strategy</span>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="kt-rating">
                                                                            <div class="kt-rating-label checked">
                                                                                <i class="kt-rating-on ki-solid ki-star text-base leading-none"></i>
                                                                                <i class="kt-rating-off ki-outline ki-star text-base leading-none"></i>
                                                                            </div>
                                                                            <div class="kt-rating-label checked">
                                                                                <i class="kt-rating-on ki-solid ki-star text-base leading-none"></i>
                                                                                <i class="kt-rating-off ki-outline ki-star text-base leading-none"></i>
                                                                            </div>
                                                                            <div class="kt-rating-label checked">
                                                                                <i class="kt-rating-on ki-solid ki-star text-base leading-none"></i>
                                                                                <i class="kt-rating-off ki-outline ki-star text-base leading-none"></i>
                                                                            </div>
                                                                            <div class="kt-rating-label checked">
                                                                                <i class="kt-rating-on ki-solid ki-star text-base leading-none"></i>
                                                                                <i class="kt-rating-off ki-outline ki-star text-base leading-none"></i>
                                                                            </div>
                                                                            <div class="kt-rating-label checked">
                                                                                <i class="kt-rating-on ki-solid ki-star text-base leading-none"></i>
                                                                                <i class="kt-rating-off ki-outline ki-star text-base leading-none"></i>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td>05 Oct, 2024</td>
                                                                    <td>
                                                                        <div class="flex -space-x-2">
                                                                            <div class="flex">
                                                                                <img
                                                                                    class="ring-background relative size-[30px] shrink-0 rounded-full ring-1 hover:z-5"
                                                                                    src="{{ asset(Storage::url("media/avatars/300-24.png")) }}"
                                                                                    alt=""
                                                                                />
                                                                            </div>
                                                                            <div class="flex">
                                                                                <img
                                                                                    class="ring-background relative size-[30px] shrink-0 rounded-full ring-1 hover:z-5"
                                                                                    src="{{ asset(Storage::url("media/avatars/300-7.png")) }}"
                                                                                    alt=""
                                                                                />
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <input class="kt-checkbox kt-checkbox-sm" data-kt-datatable-row-check="true" type="checkbox" value="5" />
                                                                    </td>
                                                                    <td>
                                                                        <div class="flex flex-col gap-2">
                                                                            <a class="text-mono hover:text-primary text-sm leading-none font-medium" href="#">Development Team</a>
                                                                            <span class="text-2sm text-secondary-foreground leading-3 font-normal">Software development</span>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="kt-rating">
                                                                            <div class="kt-rating-label checked">
                                                                                <i class="kt-rating-on ki-solid ki-star text-base leading-none"></i>
                                                                                <i class="kt-rating-off ki-outline ki-star text-base leading-none"></i>
                                                                            </div>
                                                                            <div class="kt-rating-label checked">
                                                                                <i class="kt-rating-on ki-solid ki-star text-base leading-none"></i>
                                                                                <i class="kt-rating-off ki-outline ki-star text-base leading-none"></i>
                                                                            </div>
                                                                            <div class="kt-rating-label checked">
                                                                                <i class="kt-rating-on ki-solid ki-star text-base leading-none"></i>
                                                                                <i class="kt-rating-off ki-outline ki-star text-base leading-none"></i>
                                                                            </div>
                                                                            <div class="kt-rating-label checked">
                                                                                <i class="kt-rating-on ki-solid ki-star text-base leading-none"></i>
                                                                                <i class="kt-rating-off ki-outline ki-star text-base leading-none"></i>
                                                                            </div>
                                                                            <div class="kt-rating-label indeterminate">
                                                                                <i class="kt-rating-on ki-solid ki-star text-base leading-none" style="width: 50%"></i>
                                                                                <i class="kt-rating-off ki-outline ki-star text-base leading-none"></i>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td>01 Oct, 2024</td>
                                                                    <td>
                                                                        <div class="flex -space-x-2">
                                                                            <div class="flex">
                                                                                <img
                                                                                    class="ring-background relative size-[30px] shrink-0 rounded-full ring-1 hover:z-5"
                                                                                    src="{{ asset(Storage::url("media/avatars/300-3.png")) }}"
                                                                                    alt=""
                                                                                />
                                                                            </div>
                                                                            <div class="flex">
                                                                                <img
                                                                                    class="ring-background relative size-[30px] shrink-0 rounded-full ring-1 hover:z-5"
                                                                                    src="{{ asset(Storage::url("media/avatars/300-8.png")) }}"
                                                                                    alt=""
                                                                                />
                                                                            </div>
                                                                            <div class="flex">
                                                                                <img
                                                                                    class="ring-background relative size-[30px] shrink-0 rounded-full ring-1 hover:z-5"
                                                                                    src="{{ asset(Storage::url("media/avatars/300-9.png")) }}"
                                                                                    alt=""
                                                                                />
                                                                            </div>
                                                                            <div class="flex">
                                                                                <span
                                                                                    class="text-2xs ring-background bg-destructive relative inline-flex size-[30px] shrink-0 items-center justify-center rounded-full leading-none font-semibold text-white ring-1"
                                                                                >
                                                                                    +5
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="kt-card-footer text-secondary-foreground flex-col justify-center gap-5 text-sm font-medium md:flex-row md:justify-between">
                                                        <div class="order-2 flex items-center gap-2 md:order-1">
                                                            Show
                                                            <select class="kt-select w-16" data-kt-datatable-size="true" data-kt-select="" name="perpage"></select>
                                                            per page
                                                        </div>
                                                        <div class="order-1 flex items-center gap-4 md:order-2">
                                                            <span data-kt-datatable-info="true"></span>
                                                            <div class="kt-datatable-pagination" data-kt-datatable-pagination="true"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end: grid -->
                            <!-- begin: grid -->
                            {{--
                                <div class="grid items-stretch gap-5 lg:grid-cols-3 lg:gap-7.5">
                                <div class="lg:col-span-1">
                                <div class="kt-card h-full">
                                <div class="kt-card-header">
                                <h3 class="kt-card-title">Highlights</h3>
                                <div class="kt-menu" data-kt-menu="true">
                                <div
                                class="kt-menu-item"
                                data-kt-menu-item-offset="0, 10px"
                                data-kt-menu-item-placement="bottom-start"
                                data-kt-menu-item-toggle="dropdown"
                                data-kt-menu-item-trigger="click"
                                >
                                <button class="kt-menu-toggle kt-btn kt-btn-sm kt-btn-icon kt-btn-ghost">
                                <i class="ki-filled ki-dots-vertical text-lg"></i>
                                </button>
                                <div class="kt-menu-dropdown kt-menu-default w-full max-w-[200px]" data-kt-menu-dismiss="true">
                                <div class="kt-menu-item">
                                <a class="kt-menu-link" href="#">
                                <span class="kt-menu-icon">
                                <i class="ki-filled ki-cloud-change"></i>
                                </span>
                                <span class="kt-menu-title">Activity</span>
                                </a>
                                </div>
                                <div class="kt-menu-item">
                                <a class="kt-menu-link" data-kt-modal-toggle="#share_profile_modal" href="#">
                                <span class="kt-menu-icon">
                                <i class="ki-filled ki-share"></i>
                                </span>
                                <span class="kt-menu-title">Share</span>
                                </a>
                                </div>
                                <div
                                class="kt-menu-item"
                                data-kt-menu-item-offset="-15px, 0"
                                data-kt-menu-item-placement="right-start"
                                data-kt-menu-item-toggle="dropdown"
                                data-kt-menu-item-trigger="click|lg:hover"
                                >
                                <div class="kt-menu-link">
                                <span class="kt-menu-icon">
                                <i class="ki-filled ki-notification-status"></i>
                                </span>
                                <span class="kt-menu-title">Notifications</span>
                                <span class="kt-menu-arrow">
                                <i class="ki-filled ki-right text-xs rtl:rotate-180 rtl:transform"></i>
                                </span>
                                </div>
                                <div class="kt-menu-dropdown kt-menu-default w-full max-w-[175px]">
                                <div class="kt-menu-item">
                                <a class="kt-menu-link" href="#">
                                <span class="kt-menu-icon">
                                <i class="ki-filled ki-sms"></i>
                                </span>
                                <span class="kt-menu-title">Email</span>
                                </a>
                                </div>
                                <div class="kt-menu-item">
                                <a class="kt-menu-link" href="#">
                                <span class="kt-menu-icon">
                                <i class="ki-filled ki-message-notify"></i>
                                </span>
                                <span class="kt-menu-title">SMS</span>
                                </a>
                                </div>
                                <div class="kt-menu-item">
                                <a class="kt-menu-link" href="#">
                                <span class="kt-menu-icon">
                                <i class="ki-filled ki-notification-status"></i>
                                </span>
                                <span class="kt-menu-title">Push</span>
                                </a>
                                </div>
                                </div>
                                </div>
                                <div class="kt-menu-item">
                                <a class="kt-menu-link" data-kt-modal-toggle="#report_user_modal" href="#">
                                <span class="kt-menu-icon">
                                <i class="ki-filled ki-dislike"></i>
                                </span>
                                <span class="kt-menu-title">Report</span>
                                </a>
                                </div>
                                <div class="kt-menu-separator"></div>
                                <div class="kt-menu-item">
                                <a class="kt-menu-link" href="#">
                                <span class="kt-menu-icon">
                                <i class="ki-filled ki-setting-3"></i>
                                </span>
                                <span class="kt-menu-title">Settings</span>
                                </a>
                                </div>
                                </div>
                                </div>
                                </div>
                                </div>
                                <div class="kt-card-content flex flex-col gap-4 p-5 lg:p-7.5 lg:pt-4">
                                <div class="flex flex-col gap-0.5">
                                <span class="text-secondary-foreground text-sm font-normal">All time sales</span>
                                <div class="flex items-center gap-2.5">
                                <span class="text-mono text-3xl font-semibold">$295.7k</span>
                                <span class="kt-badge kt-badge-outline kt-badge-success kt-badge-sm">+2.7%</span>
                                </div>
                                </div>
                                <div class="mb-1.5 flex items-center gap-1">
                                <div class="h-2 w-full max-w-[60%] rounded-xs bg-green-500"></div>
                                <div class="bg-destructive h-2 w-full max-w-[25%] rounded-xs"></div>
                                <div class="h-2 w-full max-w-[15%] rounded-xs bg-violet-500"></div>
                                </div>
                                <div class="mb-1 flex flex-wrap items-center gap-4">
                                <div class="flex items-center gap-1.5">
                                <span class="kt-badge-success size-2 rounded-full"></span>
                                <span class="text-foreground text-sm font-normal">Metronic</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                <span class="kt-badge-destructive size-2 rounded-full"></span>
                                <span class="text-foreground text-sm font-normal">Bundle</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                <span class="kt-badge-info size-2 rounded-full"></span>
                                <span class="text-foreground text-sm font-normal">MetronicNest</span>
                                </div>
                                </div>
                                <div class="border-input border-b"></div>
                                <div class="grid gap-3">
                                <div class="flex flex-wrap items-center justify-between gap-2">
                                <div class="flex items-center gap-1.5">
                                <i class="ki-filled ki-shop text-muted-foreground text-base"></i>
                                <span class="text-mono text-sm font-normal">Online Store</span>
                                </div>
                                <div class="text-foreground flex items-center gap-6 text-sm font-medium">
                                <span class="lg:text-right">0</span>
                                <span class="lg:text-right">
                                <i class="ki-filled ki-arrow-up text-green-500"></i>
                                3.9%
                                </span>
                                </div>
                                </div>
                                <div class="flex flex-wrap items-center justify-between gap-2">
                                <div class="flex items-center gap-1.5">
                                <i class="ki-filled ki-facebook text-muted-foreground text-base"></i>
                                <span class="text-mono text-sm font-normal">Facebook</span>
                                </div>
                                <div class="text-foreground flex items-center gap-6 text-sm font-medium">
                                <span class="lg:text-right">0</span>
                                <span class="lg:text-right">
                                <i class="ki-filled ki-arrow-down text-destructive"></i>
                                0.7%
                                </span>
                                </div>
                                </div>
                                <div class="flex flex-wrap items-center justify-between gap-2">
                                <div class="flex items-center gap-1.5">
                                <i class="ki-filled ki-instagram text-muted-foreground text-base"></i>
                                <span class="text-mono text-sm font-normal">Instagram</span>
                                </div>
                                <div class="text-foreground flex items-center gap-6 text-sm font-medium">
                                <span class="lg:text-right">0</span>
                                <span class="lg:text-right">
                                <i class="ki-filled ki-arrow-up text-green-500"></i>
                                8.2%
                                </span>
                                </div>
                                </div>
                                </div>
                                </div>
                                </div>
                                </div>
                                </div>
                            --}}
                            <!-- end: grid -->
                        </div>
                    </div>
                    <!-- End of Container -->
                </main>
                <!-- End of Content -->
                @livewire(config('theme.name', 'laravel').".dashboards.layouts.constructors.footers")
            </div>
            <!-- End of Wrapper -->
        </div>
        <!-- End of Main -->
        <div class="kt-modal" data-kt-modal="true" id="search_modal">
            <div class="kt-modal-content top-[15%] max-w-[600px]">
                <div class="kt-modal-header px-5 py-4">
                    <i class="ki-filled ki-magnifier text-muted-foreground text-xl"></i>
                    <input class="kt-input kt-input-ghost" name="query" placeholder="Tap to start search" type="text" value="" />
                    <button class="kt-btn kt-btn-sm kt-btn-icon kt-btn-dim shrink-0" data-kt-modal-dismiss="true">
                        <i class="ki-filled ki-cross"></i>
                    </button>
                </div>
                <div class="kt-modal-body p-0 pb-5">
                    <div class="kt-tabs kt-tabs-line mb-2.5 justify-between px-5" data-kt-tabs="true">
                        <div class="flex items-center gap-5">
                            <button class="kt-tab-toggle active py-5" data-kt-tab-toggle="#search_modal_mixed">Mixed</button>
                            <button class="kt-tab-toggle py-5" data-kt-tab-toggle="#search_modal_settings">Settings</button>
                            <button class="kt-tab-toggle py-5" data-kt-tab-toggle="#search_modal_integrations">Integrations</button>
                            <button class="kt-tab-toggle py-5" data-kt-tab-toggle="#search_modal_users">Users</button>
                            <button class="kt-tab-toggle py-5" data-kt-tab-toggle="#search_modal_docs">Docs</button>
                            <button class="kt-tab-toggle py-5" data-kt-tab-toggle="#search_modal_empty">Empty</button>
                            <button class="kt-tab-toggle py-5" data-kt-tab-toggle="#search_modal_no-results">No Results</button>
                        </div>
                        <div class="kt-menu -mt-px" data-kt-menu="true">
                            <div
                                class="kt-menu-item"
                                data-kt-menu-item-offset="0, 10px"
                                data-kt-menu-item-placement="bottom-end"
                                data-kt-menu-item-placement-rtl="bottom-start"
                                data-kt-menu-item-toggle="dropdown"
                                data-kt-menu-item-trigger="click"
                            >
                                <button class="kt-menu-toggle kt-btn kt-btn-icon kt-btn-ghost">
                                    <i class="ki-filled ki-setting-2"></i>
                                </button>
                                <div class="kt-menu-dropdown kt-menu-default w-full max-w-[175px]" data-kt-menu-dismiss="true">
                                    <div class="kt-menu-item">
                                        <a class="kt-menu-link" href="#">
                                            <span class="kt-menu-icon">
                                                <i class="ki-filled ki-document"></i>
                                            </span>
                                            <span class="kt-menu-title">View</span>
                                        </a>
                                    </div>
                                    <div
                                        class="kt-menu-item"
                                        data-kt-menu-item-offset="-15px, 0"
                                        data-kt-menu-item-placement="right-start"
                                        data-kt-menu-item-toggle="dropdown"
                                        data-kt-menu-item-trigger="click|lg:hover"
                                    >
                                        <div class="kt-menu-link">
                                            <span class="kt-menu-icon">
                                                <i class="ki-filled ki-notification-status"></i>
                                            </span>
                                            <span class="kt-menu-title">Export</span>
                                            <span class="kt-menu-arrow">
                                                <i class="ki-filled ki-right text-xs rtl:rotate-180 rtl:transform"></i>
                                            </span>
                                        </div>
                                        <div class="kt-menu-dropdown kt-menu-default w-full max-w-[175px]">
                                            <div class="kt-menu-item">
                                                <a class="kt-menu-link" href="#">
                                                    <span class="kt-menu-icon">
                                                        <i class="ki-filled ki-sms"></i>
                                                    </span>
                                                    <span class="kt-menu-title">Email</span>
                                                </a>
                                            </div>
                                            <div class="kt-menu-item">
                                                <a class="kt-menu-link" href="#">
                                                    <span class="kt-menu-icon">
                                                        <i class="ki-filled ki-message-notify"></i>
                                                    </span>
                                                    <span class="kt-menu-title">SMS</span>
                                                </a>
                                            </div>
                                            <div class="kt-menu-item">
                                                <a class="kt-menu-link" href="#">
                                                    <span class="kt-menu-icon">
                                                        <i class="ki-filled ki-notification-status"></i>
                                                    </span>
                                                    <span class="kt-menu-title">Push</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="kt-menu-item">
                                        <a class="kt-menu-link" href="#">
                                            <span class="kt-menu-icon">
                                                <i class="ki-filled ki-pencil"></i>
                                            </span>
                                            <span class="kt-menu-title">Edit</span>
                                        </a>
                                    </div>
                                    <div class="kt-menu-item">
                                        <a class="kt-menu-link" href="#">
                                            <span class="kt-menu-icon">
                                                <i class="ki-filled ki-trash"></i>
                                            </span>
                                            <span class="kt-menu-title">Delete</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="kt-scrollable-y-auto" data-kt-scrollable="true" data-kt-scrollable-max-height="auto" data-kt-scrollable-offset="300px">
                        <div class="" id="search_modal_mixed">
                            <div class="flex flex-col gap-2.5">
                                <div>
                                    <div class="text-secondary-foreground ps-5 pt-2.5 pb-1.5 text-xs font-medium">Settings</div>
                                    <div class="kt-menu kt-menu-default flex-col px-0.5">
                                        <div class="kt-menu-item">
                                            <a class="kt-menu-link" href="#">
                                                <span class="kt-menu-icon">
                                                    <i class="ki-filled ki-badge"></i>
                                                </span>
                                                <span class="kt-menu-title">Public Profile</span>
                                            </a>
                                        </div>
                                        <div class="kt-menu-item">
                                            <a class="kt-menu-link" href="#">
                                                <span class="kt-menu-icon">
                                                    <i class="ki-filled ki-setting-2"></i>
                                                </span>
                                                <span class="kt-menu-title">My Account</span>
                                            </a>
                                        </div>
                                        <div class="kt-menu-item">
                                            <a class="kt-menu-link" href="#">
                                                <span class="kt-menu-icon">
                                                    <i class="ki-filled ki-message-programming"></i>
                                                </span>
                                                <span class="kt-menu-title">Devs Forum</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="border-b-border border-b"></div>
                                <div>
                                    <div class="text-secondary-foreground ps-5 pt-2.5 pb-1.5 text-xs font-medium">Integrations</div>
                                    <div class="kt-menu kt-menu-default flex-col px-0.5">
                                        <div class="kt-menu-item">
                                            <div class="kt-menu-link jistify-between flex items-center gap-2">
                                                <div class="flex grow items-center gap-2">
                                                    <div class="border-border bg-accent/60 flex size-10 shrink-0 items-center justify-center rounded-full border">
                                                        <img alt="" class="size-6 shrink-0" src="{{ asset(Storage::url("media/brand-logos/jira.svg")) }}" />
                                                    </div>
                                                    <div class="flex flex-col gap-0.5">
                                                        <a class="text-mono hover:text-primary text-sm font-semibold" href="#">Jira</a>
                                                        <span class="text-secondary-foreground text-xs font-medium">Project management</span>
                                                    </div>
                                                </div>
                                                <div class="flex shrink-0 justify-end">
                                                    <div class="flex -space-x-2">
                                                        <div class="flex">
                                                            <img
                                                                class="ring-background relative size-6 shrink-0 rounded-full ring-1 hover:z-5"
                                                                src="{{ asset(Storage::url("media/avatars/300-4.png")) }}"
                                                                alt=""
                                                            />
                                                        </div>
                                                        <div class="flex">
                                                            <img
                                                                class="ring-background relative size-6 shrink-0 rounded-full ring-1 hover:z-5"
                                                                src="{{ asset(Storage::url("media/avatars/300-1.png")) }}"
                                                                alt=""
                                                            />
                                                        </div>
                                                        <div class="flex">
                                                            <img
                                                                class="ring-background relative size-6 shrink-0 rounded-full ring-1 hover:z-5"
                                                                src="{{ asset(Storage::url("media/avatars/300-2.png")) }}"
                                                                alt=""
                                                            />
                                                        </div>
                                                        <div class="flex">
                                                            <span
                                                                class="text-2xs ring-background relative inline-flex size-6 shrink-0 items-center justify-center rounded-full bg-green-500 leading-none font-semibold text-white ring-1 hover:z-5"
                                                            >
                                                                +3
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="kt-menu-item">
                                            <div class="kt-menu-link jistify-between flex items-center gap-2">
                                                <div class="flex grow items-center gap-2">
                                                    <div class="border-border bg-accent/60 flex size-10 shrink-0 items-center justify-center rounded-full border">
                                                        <img alt="" class="size-6 shrink-0" src="{{ asset(Storage::url("media/brand-logos/inferno.svg")) }}" />
                                                    </div>
                                                    <div class="flex flex-col gap-0.5">
                                                        <a class="text-mono hover:text-primary text-sm font-semibold" href="#">Inferno</a>
                                                        <span class="text-secondary-foreground text-xs font-medium">Real-time photo sharing app</span>
                                                    </div>
                                                </div>
                                                <div class="flex shrink-0 justify-end">
                                                    <div class="flex -space-x-2">
                                                        <div class="flex">
                                                            <img
                                                                class="ring-background relative size-6 shrink-0 rounded-full ring-1 hover:z-5"
                                                                src="{{ asset(Storage::url("media/avatars/300-14.png")) }}"
                                                                alt=""
                                                            />
                                                        </div>
                                                        <div class="flex">
                                                            <img
                                                                class="ring-background relative size-6 shrink-0 rounded-full ring-1 hover:z-5"
                                                                src="{{ asset(Storage::url("media/avatars/300-12.png")) }}"
                                                                alt=""
                                                            />
                                                        </div>
                                                        <div class="flex">
                                                            <img
                                                                class="ring-background relative size-6 shrink-0 rounded-full ring-1 hover:z-5"
                                                                src="{{ asset(Storage::url("media/avatars/300-9.png")) }}"
                                                                alt=""
                                                            />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="border-b-border border-b"></div>
                                <div>
                                    <div class="text-secondary-foreground ps-5 pt-2.5 pb-1.5 text-xs font-medium">Users</div>
                                    <div class="kt-menu kt-menu-default flex-col px-0.5">
                                        <div class="grid gap-1">
                                            <div class="kt-menu-item">
                                                <div class="kt-menu-link flex justify-between gap-2">
                                                    <div class="flex items-center gap-2.5">
                                                        <img alt="" class="size-9 shrink-0 rounded-full" src="{{ asset(Storage::url("media/avatars/300-3.png")) }}" />
                                                        <div class="flex flex-col">
                                                            <a class="text-mono hover:text-primary mb-px text-sm font-semibold" href="#">Tyler Hero</a>
                                                            <span class="text-2sm text-muted-foreground font-normal">tyler.hero @gmail.com connections</span>
                                                        </div>
                                                    </div>
                                                    <div class="flex items-center gap-2.5">
                                                        <div class="kt-badge kt-badge-outline kt-badge-success gap-1.5 rounded-full">
                                                            <span class="kt-badge-dot"></span>
                                                            In Office
                                                        </div>
                                                        <button class="kt-btn kt-btn-icon kt-btn-ghost kt-btn-sm">
                                                            <i class="ki-filled ki-dots-vertical text-lg"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="kt-menu-item">
                                                <div class="kt-menu-link flex justify-between gap-2">
                                                    <div class="flex items-center gap-2.5">
                                                        <img alt="" class="size-9 shrink-0 rounded-full" src="{{ asset(Storage::url("media/avatars/300-1.png")) }}" />
                                                        <div class="flex flex-col">
                                                            <a class="text-mono hover:text-primary mb-px text-sm font-semibold" href="#">Esther Howard</a>
                                                            <span class="text-2sm text-muted-foreground font-normal">esther.howard @gmail.com connections</span>
                                                        </div>
                                                    </div>
                                                    <div class="flex items-center gap-2.5">
                                                        <div class="kt-badge kt-badge-outline kt-badge-destructive gap-1.5 rounded-full">
                                                            <span class="kt-badge-dot"></span>
                                                            On Leave
                                                        </div>
                                                        <button class="kt-btn kt-btn-icon kt-btn-ghost kt-btn-sm">
                                                            <i class="ki-filled ki-dots-vertical text-lg"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="hidden" id="search_modal_settings">
                            <div class="kt-menu kt-menu-default flex-col px-0.5">
                                <div class="text-secondary-foreground ps-5 pt-2.5 pb-1.5 text-xs font-medium">Shortcuts</div>
                                <div class="kt-menu-item">
                                    <a class="kt-menu-link" href="#">
                                        <span class="kt-menu-icon">
                                            <i class="ki-filled ki-home-2"></i>
                                        </span>
                                        <span class="kt-menu-title">Go to Dashboard</span>
                                    </a>
                                </div>
                                <div class="kt-menu-item">
                                    <a class="kt-menu-link" href="#">
                                        <span class="kt-menu-icon">
                                            <i class="ki-filled ki-badge"></i>
                                        </span>
                                        <span class="kt-menu-title">Public Profile</span>
                                    </a>
                                </div>
                                <div class="kt-menu-item">
                                    <a class="kt-menu-link" href="#">
                                        <span class="kt-menu-icon">
                                            <i class="ki-filled ki-profile-circle"></i>
                                        </span>
                                        <span class="kt-menu-title">My Profile</span>
                                    </a>
                                </div>
                                <div class="kt-menu-item">
                                    <a class="kt-menu-link" href="#">
                                        <span class="kt-menu-icon">
                                            <i class="ki-filled ki-setting-2"></i>
                                        </span>
                                        <span class="kt-menu-title">My Account</span>
                                    </a>
                                </div>
                                <div class="kt-menu-item">
                                    <a class="kt-menu-link" href="#">
                                        <span class="kt-menu-icon">
                                            <i class="ki-filled ki-message-programming"></i>
                                        </span>
                                        <span class="kt-menu-title">Devs Forum</span>
                                    </a>
                                </div>
                                <div class="text-secondary-foreground ps-5 pt-2.5 pb-1.5 text-xs font-medium">Actions</div>
                                <div class="kt-menu-item">
                                    <a class="kt-menu-link" href="#">
                                        <span class="kt-menu-icon">
                                            <i class="ki-filled ki-user"></i>
                                        </span>
                                        <span class="kt-menu-title">Create User</span>
                                    </a>
                                </div>
                                <div class="kt-menu-item">
                                    <a class="kt-menu-link" href="#">
                                        <span class="kt-menu-icon">
                                            <i class="ki-filled ki-user-edit"></i>
                                        </span>
                                        <span class="kt-menu-title">Create Team</span>
                                    </a>
                                </div>
                                <div class="kt-menu-item">
                                    <a class="kt-menu-link" href="#">
                                        <span class="kt-menu-icon">
                                            <i class="ki-filled ki-subtitle"></i>
                                        </span>
                                        <span class="kt-menu-title">Change Plan</span>
                                    </a>
                                </div>
                                <div class="kt-menu-item">
                                    <a class="kt-menu-link" href="#">
                                        <span class="kt-menu-icon">
                                            <i class="ki-filled ki-setting"></i>
                                        </span>
                                        <span class="kt-menu-title">Setup Branding</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="hidden" id="search_modal_integrations">
                            <div class="kt-menu kt-menu-default flex-col px-0.5">
                                <div class="kt-menu-item">
                                    <div class="kt-menu-link jistify-between flex items-center gap-2">
                                        <div class="flex grow items-center gap-2">
                                            <div class="border-border bg-accent/60 flex size-10 shrink-0 items-center justify-center rounded-full border">
                                                <img alt="" class="size-6 shrink-0" src="{{ asset(Storage::url("media/brand-logos/jira.svg")) }}" />
                                            </div>
                                            <div class="flex flex-col gap-0.5">
                                                <a class="text-mono hover:text-primary text-sm font-semibold" href="#">Jira</a>
                                                <span class="text-secondary-foreground text-xs font-medium">Project management</span>
                                            </div>
                                        </div>
                                        <div class="flex shrink-0 justify-end">
                                            <div class="flex -space-x-2">
                                                <div class="flex">
                                                    <img
                                                        class="ring-background relative size-6 shrink-0 rounded-full ring-1 hover:z-5"
                                                        src="{{ asset(Storage::url("media/avatars/300-4.png")) }}"
                                                        alt=""
                                                    />
                                                </div>
                                                <div class="flex">
                                                    <img
                                                        class="ring-background relative size-6 shrink-0 rounded-full ring-1 hover:z-5"
                                                        src="{{ asset(Storage::url("media/avatars/300-1.png")) }}"
                                                        alt=""
                                                    />
                                                </div>
                                                <div class="flex">
                                                    <img
                                                        class="ring-background relative size-6 shrink-0 rounded-full ring-1 hover:z-5"
                                                        src="{{ asset(Storage::url("media/avatars/300-2.png")) }}"
                                                        alt=""
                                                    />
                                                </div>
                                                <div class="flex">
                                                    <span
                                                        class="text-2xs ring-background relative inline-flex size-6 shrink-0 items-center justify-center rounded-full bg-green-500 leading-none font-semibold text-white ring-1 hover:z-5"
                                                    >
                                                        +3
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="kt-menu-item">
                                    <div class="kt-menu-link jistify-between flex items-center gap-2">
                                        <div class="flex grow items-center gap-2">
                                            <div class="border-border bg-accent/60 flex size-10 shrink-0 items-center justify-center rounded-full border">
                                                <img alt="" class="size-6 shrink-0" src="{{ asset(Storage::url("media/brand-logos/inferno.svg")) }}" />
                                            </div>
                                            <div class="flex flex-col gap-0.5">
                                                <a class="text-mono hover:text-primary text-sm font-semibold" href="#">Inferno</a>
                                                <span class="text-secondary-foreground text-xs font-medium">Real-time photo sharing app</span>
                                            </div>
                                        </div>
                                        <div class="flex shrink-0 justify-end">
                                            <div class="flex -space-x-2">
                                                <div class="flex">
                                                    <img
                                                        class="ring-background relative size-6 shrink-0 rounded-full ring-1 hover:z-5"
                                                        src="{{ asset(Storage::url("media/avatars/300-14.png")) }}"
                                                        alt=""
                                                    />
                                                </div>
                                                <div class="flex">
                                                    <img
                                                        class="ring-background relative size-6 shrink-0 rounded-full ring-1 hover:z-5"
                                                        src="{{ asset(Storage::url("media/avatars/300-12.png")) }}"
                                                        alt=""
                                                    />
                                                </div>
                                                <div class="flex">
                                                    <img
                                                        class="ring-background relative size-6 shrink-0 rounded-full ring-1 hover:z-5"
                                                        src="{{ asset(Storage::url("media/avatars/300-9.png")) }}"
                                                        alt=""
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="kt-menu-item">
                                    <div class="kt-menu-link jistify-between flex items-center gap-2">
                                        <div class="flex grow items-center gap-2">
                                            <div class="border-border bg-accent/60 flex size-10 shrink-0 items-center justify-center rounded-full border">
                                                <img alt="" class="size-6 shrink-0" src="{{ asset(Storage::url("media/brand-logos/evernote.svg")) }}" />
                                            </div>
                                            <div class="flex flex-col gap-0.5">
                                                <a class="text-mono hover:text-primary text-sm font-semibold" href="#">Evernote</a>
                                                <span class="text-secondary-foreground text-xs font-medium">Notes management app</span>
                                            </div>
                                        </div>
                                        <div class="flex shrink-0 justify-end">
                                            <div class="flex -space-x-2">
                                                <div class="flex">
                                                    <img
                                                        class="ring-background relative size-6 shrink-0 rounded-full ring-1 hover:z-5"
                                                        src="{{ asset(Storage::url("media/avatars/300-6.png")) }}"
                                                        alt=""
                                                    />
                                                </div>
                                                <div class="flex">
                                                    <img
                                                        class="ring-background relative size-6 shrink-0 rounded-full ring-1 hover:z-5"
                                                        src="{{ asset(Storage::url("media/avatars/300-3.png")) }}"
                                                        alt=""
                                                    />
                                                </div>
                                                <div class="flex">
                                                    <img
                                                        class="ring-background relative size-6 shrink-0 rounded-full ring-1 hover:z-5"
                                                        src="{{ asset(Storage::url("media/avatars/300-1.png")) }}"
                                                        alt=""
                                                    />
                                                </div>
                                                <div class="flex">
                                                    <img
                                                        class="ring-background relative size-6 shrink-0 rounded-full ring-1 hover:z-5"
                                                        src="{{ asset(Storage::url("media/avatars/300-8.png")) }}"
                                                        alt=""
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="kt-menu-item">
                                    <div class="kt-menu-link jistify-between flex items-center gap-2">
                                        <div class="flex grow items-center gap-2">
                                            <div class="border-border bg-accent/60 flex size-10 shrink-0 items-center justify-center rounded-full border">
                                                <img alt="" class="size-6 shrink-0" src="{{ asset(Storage::url("media/brand-logos/gitlab.svg")) }}" />
                                            </div>
                                            <div class="flex flex-col gap-0.5">
                                                <a class="text-mono hover:text-primary text-sm font-semibold" href="#">Gitlab</a>
                                                <span class="text-secondary-foreground text-xs font-medium">Notes management app</span>
                                            </div>
                                        </div>
                                        <div class="flex shrink-0 justify-end">
                                            <div class="flex -space-x-2">
                                                <div class="flex">
                                                    <img
                                                        class="ring-background relative size-6 shrink-0 rounded-full ring-1 hover:z-5"
                                                        src="{{ asset(Storage::url("media/avatars/300-18.png")) }}"
                                                        alt=""
                                                    />
                                                </div>
                                                <div class="flex">
                                                    <img
                                                        class="ring-background relative size-6 shrink-0 rounded-full ring-1 hover:z-5"
                                                        src="{{ asset(Storage::url("media/avatars/300-17.png")) }}"
                                                        alt=""
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="kt-menu-item">
                                    <div class="kt-menu-link jistify-between flex items-center gap-2">
                                        <div class="flex grow items-center gap-2">
                                            <div class="border-border bg-accent/60 flex size-10 shrink-0 items-center justify-center rounded-full border">
                                                <img alt="" class="size-6 shrink-0" src="{{ asset(Storage::url("media/brand-logos/google-webdev.svg")) }}" />
                                            </div>
                                            <div class="flex flex-col gap-0.5">
                                                <a class="text-mono hover:text-primary text-sm font-semibold" href="#">Google webdev</a>
                                                <span class="text-secondary-foreground text-xs font-medium">Building web expierences</span>
                                            </div>
                                        </div>
                                        <div class="flex shrink-0 justify-end">
                                            <div class="flex -space-x-2">
                                                <div class="flex">
                                                    <img
                                                        class="ring-background relative size-6 shrink-0 rounded-full ring-1 hover:z-5"
                                                        src="{{ asset(Storage::url("media/avatars/300-14.png")) }}"
                                                        alt=""
                                                    />
                                                </div>
                                                <div class="flex">
                                                    <img
                                                        class="ring-background relative size-6 shrink-0 rounded-full ring-1 hover:z-5"
                                                        src="{{ asset(Storage::url("media/avatars/300-20.png")) }}"
                                                        alt=""
                                                    />
                                                </div>
                                                <div class="flex">
                                                    <img
                                                        class="ring-background relative size-6 shrink-0 rounded-full ring-1 hover:z-5"
                                                        src="{{ asset(Storage::url("media/avatars/300-21.png")) }}"
                                                        alt=""
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="kt-menu-item px-4 pt-2">
                                    <a class="kt-btn kt-btn-outline justify-center" href="#">Go to Apps</a>
                                </div>
                            </div>
                        </div>
                        <div class="hidden" id="search_modal_users">
                            <div class="kt-menu kt-menu-default flex-col px-0.5">
                                <div class="grid gap-1">
                                    <div class="kt-menu-item">
                                        <div class="kt-menu-link flex justify-between gap-2">
                                            <div class="flex items-center gap-2.5">
                                                <img alt="" class="size-9 shrink-0 rounded-full" src="{{ asset(Storage::url("media/avatars/300-3.png")) }}" />
                                                <div class="flex flex-col">
                                                    <a class="text-mono hover:text-primary mb-px text-sm font-semibold" href="#">Tyler Hero</a>
                                                    <span class="text-2sm text-muted-foreground font-normal">tyler.hero @gmail.com connections</span>
                                                </div>
                                            </div>
                                            <div class="flex items-center gap-2.5">
                                                <div class="kt-badge kt-badge-outline kt-badge-success gap-1.5 rounded-full">
                                                    <span class="kt-badge-dot"></span>
                                                    In Office
                                                </div>
                                                <button class="kt-btn kt-btn-icon kt-btn-ghost kt-btn-sm">
                                                    <i class="ki-filled ki-dots-vertical text-lg"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="kt-menu-item">
                                        <div class="kt-menu-link flex justify-between gap-2">
                                            <div class="flex items-center gap-2.5">
                                                <img alt="" class="size-9 shrink-0 rounded-full" src="{{ asset(Storage::url("media/avatars/300-1.png")) }}" />
                                                <div class="flex flex-col">
                                                    <a class="text-mono hover:text-primary mb-px text-sm font-semibold" href="#">Esther Howard</a>
                                                    <span class="text-2sm text-muted-foreground font-normal">esther.howard @gmail.com connections</span>
                                                </div>
                                            </div>
                                            <div class="flex items-center gap-2.5">
                                                <div class="kt-badge kt-badge-outline kt-badge-destructive gap-1.5 rounded-full">
                                                    <span class="kt-badge-dot"></span>
                                                    On Leave
                                                </div>
                                                <button class="kt-btn kt-btn-icon kt-btn-ghost kt-btn-sm">
                                                    <i class="ki-filled ki-dots-vertical text-lg"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="kt-menu-item">
                                        <div class="kt-menu-link flex justify-between gap-2">
                                            <div class="flex items-center gap-2.5">
                                                <img alt="" class="size-9 shrink-0 rounded-full" src="{{ asset(Storage::url("media/avatars/300-11.png")) }}" />
                                                <div class="flex flex-col">
                                                    <a class="text-mono hover:text-primary mb-px text-sm font-semibold" href="#">Jacob Jones</a>
                                                    <span class="text-2sm text-muted-foreground font-normal">jacob.jones @gmail.com connections</span>
                                                </div>
                                            </div>
                                            <div class="flex items-center gap-2.5">
                                                <div class="kt-badge kt-badge-outline kt-badge-primary gap-1.5 rounded-full">
                                                    <span class="kt-badge-dot"></span>
                                                    Remote
                                                </div>
                                                <button class="kt-btn kt-btn-icon kt-btn-ghost kt-btn-sm">
                                                    <i class="ki-filled ki-dots-vertical text-lg"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="kt-menu-item">
                                        <div class="kt-menu-link flex justify-between gap-2">
                                            <div class="flex items-center gap-2.5">
                                                <img alt="" class="size-9 shrink-0 rounded-full" src="{{ asset(Storage::url("media/avatars/300-5.png")) }}" />
                                                <div class="flex flex-col">
                                                    <a class="text-mono hover:text-primary mb-px text-sm font-semibold" href="#">TLeslie Alexander</a>
                                                    <span class="text-2sm text-muted-foreground font-normal">leslie.alexander @gmail.com connections</span>
                                                </div>
                                            </div>
                                            <div class="flex items-center gap-2.5">
                                                <div class="kt-badge kt-badge-outline kt-badge-success gap-1.5 rounded-full">
                                                    <span class="kt-badge-dot"></span>
                                                    In Office
                                                </div>
                                                <button class="kt-btn kt-btn-icon kt-btn-ghost kt-btn-sm">
                                                    <i class="ki-filled ki-dots-vertical text-lg"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="kt-menu-item">
                                        <div class="kt-menu-link flex justify-between gap-2">
                                            <div class="flex items-center gap-2.5">
                                                <img alt="" class="size-9 shrink-0 rounded-full" src="{{ asset(Storage::url("media/avatars/300-2.png")) }}" />
                                                <div class="flex flex-col">
                                                    <a class="text-mono hover:text-primary mb-px text-sm font-semibold" href="#">Cody Fisher</a>
                                                    <span class="text-2sm text-muted-foreground font-normal">cody.fisher @gmail.com connections</span>
                                                </div>
                                            </div>
                                            <div class="flex items-center gap-2.5">
                                                <div class="kt-badge kt-badge-outline kt-badge-primary gap-1.5 rounded-full">
                                                    <span class="kt-badge-dot"></span>
                                                    Remote
                                                </div>
                                                <button class="kt-btn kt-btn-icon kt-btn-ghost kt-btn-sm">
                                                    <i class="ki-filled ki-dots-vertical text-lg"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="kt-menu-item px-4 pt-2">
                                        <a class="kt-btn kt-btn-outline justify-center" href="#">Go to Users</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="hidden" id="search_modal_docs">
                            <div class="kt-menu kt-menu-default flex-col px-0.5">
                                <div class="grid">
                                    <div class="kt-menu-item">
                                        <div class="kt-menu-link flex items-center">
                                            <div class="flex grow items-center gap-2.5">
                                                <img src="{{ asset(Storage::url("media/file-types/pdf.svg")) }}" alt="" />
                                                <div class="flex flex-col">
                                                    <span class="text-mono hover:text-primary mb-px cursor-pointer text-sm font-semibold">Project-pitch.pdf</span>
                                                    <span class="text-muted-foreground text-xs font-medium">4.7 MB 26 Sep 2024 3:20 PM</span>
                                                </div>
                                            </div>
                                            <button class="kt-btn kt-btn-icon kt-btn-ghost kt-btn-sm">
                                                <i class="ki-filled ki-dots-vertical text-lg"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="kt-menu-item">
                                        <div class="kt-menu-link flex items-center">
                                            <div class="flex grow items-center gap-2.5">
                                                <img src="{{ asset(Storage::url("media/file-types/doc.svg")) }}" alt="" />
                                                <div class="flex flex-col">
                                                    <span class="text-mono hover:text-primary mb-px cursor-pointer text-sm font-semibold">Report-v1.docx</span>
                                                    <span class="text-muted-foreground text-xs font-medium">2.3 MB 1 Oct 2024 12:00 PM</span>
                                                </div>
                                            </div>
                                            <button class="kt-btn kt-btn-icon kt-btn-ghost kt-btn-sm">
                                                <i class="ki-filled ki-dots-vertical text-lg"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="kt-menu-item">
                                        <div class="kt-menu-link flex items-center">
                                            <div class="flex grow items-center gap-2.5">
                                                <img src="{{ asset(Storage::url("media/file-types/javascript.svg")) }}" alt="" />
                                                <div class="flex flex-col">
                                                    <span class="text-mono hover:text-primary mb-px cursor-pointer text-sm font-semibold">Framework-App.js</span>
                                                    <span class="text-muted-foreground text-xs font-medium">0.8 MB 17 Oct 2024 6:46 PM</span>
                                                </div>
                                            </div>
                                            <button class="kt-btn kt-btn-icon kt-btn-ghost kt-btn-sm">
                                                <i class="ki-filled ki-dots-vertical text-lg"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="kt-menu-item">
                                        <div class="kt-menu-link flex items-center">
                                            <div class="flex grow items-center gap-2.5">
                                                <img src="{{ asset(Storage::url("media/file-types/ai.svg")) }}" alt="" />
                                                <div class="flex flex-col">
                                                    <span class="text-mono hover:text-primary mb-px cursor-pointer text-sm font-semibold">Framework-App.js</span>
                                                    <span class="text-muted-foreground text-xs font-medium">0.8 MB 17 Oct 2024 6:46 PM</span>
                                                </div>
                                            </div>
                                            <button class="kt-btn kt-btn-icon kt-btn-ghost kt-btn-sm">
                                                <i class="ki-filled ki-dots-vertical text-lg"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="kt-menu-item">
                                        <div class="kt-menu-link flex items-center">
                                            <div class="flex grow items-center gap-2.5">
                                                <img src="{{ asset(Storage::url("media/file-types/php.svg")) }}" alt="" />
                                                <div class="flex flex-col">
                                                    <span class="text-mono hover:text-primary mb-px cursor-pointer text-sm font-semibold">appController.js</span>
                                                    <span class="text-muted-foreground text-xs font-medium">0.1 MB 21 Nov 2024 3:20 PM</span>
                                                </div>
                                            </div>
                                            <button class="kt-btn kt-btn-icon kt-btn-ghost kt-btn-sm">
                                                <i class="ki-filled ki-dots-vertical text-lg"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="kt-menu-item px-4 pt-2.5">
                                        <a class="kt-btn kt-btn-outline justify-center" href="#">Go to Users</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="hidden" id="search_modal_empty">
                            <div class="flex flex-col gap-5 py-9 text-center">
                                <div class="flex justify-center">
                                    <img alt="image" class="max-h-[113px] dark:hidden" src="{{ asset(Storage::url("media/illustrations/33.svg")) }}" />
                                    <img alt="image" class="light:hidden max-h-[113px]" src="{{ asset(Storage::url("media/illustrations/33-dark.svg")) }}" />
                                </div>
                                <div class="flex flex-col gap-1.5">
                                    <h3 class="text-mono text-center text-base font-semibold">Looking for something..</h3>
                                    <span class="text-secondary-foreground text-center text-sm font-medium">
                                        Initiate your digital experience with
                                        <br />
                                        our intuitive dashboard
                                    </span>
                                </div>
                                <div class="flex justify-center">
                                    <a class="kt-btn kt-btn-outline flex justify-center" href="#">View Projects</a>
                                </div>
                            </div>
                        </div>
                        <div class="hidden" id="search_modal_no-results">
                            <div class="flex flex-col gap-5 py-9 text-center">
                                <div class="flex justify-center">
                                    <img alt="image" class="max-h-[113px] dark:hidden" src="{{ asset(Storage::url("media/illustrations/33.svg")) }}" />
                                    <img alt="image" class="light:hidden max-h-[113px]" src="{{ asset(Storage::url("media/illustrations/33-dark.svg")) }}" />
                                </div>
                                <div class="flex flex-col gap-1.5">
                                    <h3 class="text-mono text-center text-base font-semibold">No Results Found</h3>
                                    <span class="text-secondary-foreground text-center text-sm font-medium">Refine your query to discover relevant items</span>
                                </div>
                                <div class="flex justify-center">
                                    <a class="kt-btn kt-btn-outline flex justify-center" href="#">View Projects</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Share Profile Modal -->
        <div class="kt-modal" data-kt-modal="true" id="share_profile_modal">
            <div class="kt-modal-content top-5 max-w-[500px] lg:top-[15%]">
                <div class="kt-modal-header">
                    <h3 class="kt-modal-title">Share Profile</h3>
                    <button class="kt-btn kt-btn-sm kt-btn-icon kt-btn-ghost shrink-0" data-kt-modal-dismiss="true">
                        <i class="ki-filled ki-cross"></i>
                    </button>
                </div>
                <div class="kt-modal-body grid gap-5 px-0 py-5">
                    <div class="flex flex-col gap-2.5 px-5">
                        <div class="flex-center flex gap-1">
                            <label class="text-mono text-sm font-semibold">Share read-only link</label>
                            <i class="ki-filled ki-information-2 text-muted-foreground text-sm"></i>
                        </div>
                        <label class="kt-input">
                            <input type="text" value="https://metronic.com/profiles/x7g2vA3kZ5" />
                            <button class="kt-btn kt-btn-icon kt-btn-sm kt-btn-ghost -me-2">
                                <i class="ki-filled ki-copy"></i>
                            </button>
                        </label>
                    </div>
                    <div class="border-b-border border-b"></div>
                    <div class="flex flex-col gap-2.5 px-5">
                        <div class="flex-center flex gap-1">
                            <label class="text-mono text-sm font-semibold">Share via email</label>
                            <i class="ki-filled ki-information-2 text-muted-foreground text-sm"></i>
                        </div>
                        <div class="flex-center flex gap-2.5">
                            <label class="kt-input">
                                <input type="text" value="miles.turner@gmail.com" />
                            </label>
                            <button class="kt-btn kt-btn-primary">Share</button>
                        </div>
                    </div>
                    <div class="kt-scrollable-y-auto max-h-[300px]">
                        <div class="flex flex-col gap-3 px-5">
                            <div class="flex flex-wrap items-center gap-2">
                                <div class="flex grow items-center gap-2.5">
                                    <img alt="" class="size-9 shrink-0 rounded-full" src="{{ asset(Storage::url("media/avatars/300-3.png")) }}" />
                                    <div class="flex flex-col">
                                        <a class="text-mono hover:text-primary mb-px text-sm font-semibold" href="#">Tyler Hero</a>
                                        <a class="hover:text-primary text-2sm text-secondary-foreground" href="#">tyler.hero@gmail.com</a>
                                    </div>
                                </div>
                                <select class="kt-select max-w-24" data-kt-select="true">
                                    <option selected="">Owner</option>
                                    <option>Editor</option>
                                    <option>Viewer</option>
                                </select>
                            </div>
                            <div class="flex flex-wrap items-center gap-2">
                                <div class="flex grow items-center gap-2.5">
                                    <img alt="" class="size-9 shrink-0 rounded-full" src="{{ asset(Storage::url("media/avatars/300-1.png")) }}" />
                                    <div class="flex flex-col">
                                        <a class="text-mono hover:text-primary mb-px text-sm font-semibold" href="#">Esther Howard</a>
                                        <a class="hover:text-primary text-2sm text-secondary-foreground" href="#">esther.howard@gmail.com</a>
                                    </div>
                                </div>
                                <select class="kt-select max-w-24" data-kt-select="true">
                                    <option>Owner</option>
                                    <option selected="">Editor</option>
                                    <option>Viewer</option>
                                </select>
                            </div>
                            <div class="flex flex-wrap items-center gap-2">
                                <div class="flex grow items-center gap-2.5">
                                    <img alt="" class="size-9 shrink-0 rounded-full" src="{{ asset(Storage::url("media/avatars/300-11.png")) }}" />
                                    <div class="flex flex-col">
                                        <a class="text-mono hover:text-primary mb-px text-sm font-semibold" href="#">Jacob Jones</a>
                                        <a class="hover:text-primary text-2sm text-secondary-foreground" href="#">jacob.jones@gmail.com</a>
                                    </div>
                                </div>
                                <select class="kt-select max-w-24" data-kt-select="true">
                                    <option>Owner</option>
                                    <option>Editor</option>
                                    <option selected="">Viewer</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="border-b-border border-b"></div>
                    <div class="flex flex-col gap-4 px-5">
                        <label class="text-mono text-sm font-semibold">Settings</label>
                        <div class="flex-center flex flex-wrap justify-between gap-2">
                            <div class="flex-center flex gap-1.5">
                                <i class="ki-filled ki-user text-muted-foreground"></i>
                                <div class="flex-center text-secondary-foreground flex text-xs font-medium">
                                    Anyone at
                                    <a class="link mx-1 text-xs font-medium" href="#">KeenThemes</a>
                                    can view
                                </div>
                            </div>
                            <button class="kt-link kt-link-sm kt-link-underlined kt-link-dashed">Change Access</button>
                        </div>
                        <div class="flex-center mb-2.5 flex flex-wrap justify-between gap-2">
                            <div class="flex-center flex gap-1.5">
                                <i class="ki-filled ki-icon text-muted-foreground"></i>
                                <div class="flex-center text-secondary-foreground flex text-xs font-medium">Anyone with link can edit</div>
                            </div>
                            <button class="kt-link kt-link-sm kt-link-underlined kt-link-dashed">Set Password</button>
                        </div>
                        <button class="kt-btn kt-btn-primary justify-center">Done</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- End of Share Profile Modal -->
        <div class="kt-modal" data-kt-modal="true" id="give_award_modal">
            <div class="kt-modal-content top-[15%] max-w-[500px]">
                <div class="kt-modal-header pr-2.5">
                    <h3 class="kt-modal-title">Give Award</h3>
                    <button class="kt-btn kt-btn-icon kt-btn-ghost shrink-0" data-kt-modal-dismiss="true">
                        <i class="ki-filled ki-black-left"></i>
                    </button>
                </div>
                <div class="kt-modal-body grid gap-5 px-0 py-5">
                    <div class="flex flex-col gap-2.5 px-5">
                        <div class="flex-center flex gap-1">
                            <label class="text-mono text-sm font-semibold">Share read-only link</label>
                            <i class="ki-filled ki-information-2 text-muted-foreground text-sm"></i>
                        </div>
                        <label class="kt-input">
                            <input type="text" value="https://metronic.com/profiles/x7g2vA3kZ5" />
                            <button class="kt-btn kt-btn-icon kt-btn-sm kt-btn-ghost -me-2">
                                <i class="ki-filled ki-copy"></i>
                            </button>
                        </label>
                    </div>
                    <div class="border-b-border border-b"></div>
                    <div class="flex flex-col gap-2.5 px-5">
                        <div class="flex-center flex gap-1">
                            <label class="text-mono text-sm font-semibold">Share via email</label>
                            <i class="ki-filled ki-information-2 text-muted-foreground text-sm"></i>
                        </div>
                        <div class="flex-center flex gap-2.5">
                            <label class="kt-input">
                                <input type="text" value="miles.turner@gmail.com" />
                            </label>
                            <button class="kt-btn kt-btn-primary">Share</button>
                        </div>
                    </div>
                    <div class="kt-scrollable-y-auto max-h-[300px]">
                        <div class="flex flex-col gap-3 px-5">
                            <div class="flex flex-wrap items-center gap-2">
                                <div class="flex grow items-center gap-2.5">
                                    <img alt="" class="size-9 shrink-0 rounded-full" src="{{ asset(Storage::url("media/avatars/300-3.png")) }}" />
                                    <div class="flex flex-col">
                                        <a class="text-mono hover:text-primary mb-px text-sm font-semibold" href="#">Tyler Hero</a>
                                        <a class="hover:text-primary text-2sm text-secondary-foreground" href="#">tyler.hero@gmail.com</a>
                                    </div>
                                </div>
                                <select class="kt-select max-w-24" data-kt-select="true">
                                    <option selected="">Owner</option>
                                    <option>Editor</option>
                                    <option>Viewer</option>
                                </select>
                            </div>
                            <div class="flex flex-wrap items-center gap-2">
                                <div class="flex grow items-center gap-2.5">
                                    <img alt="" class="size-9 shrink-0 rounded-full" src="{{ asset(Storage::url("media/avatars/300-1.png")) }}" />
                                    <div class="flex flex-col">
                                        <a class="text-mono hover:text-primary mb-px text-sm font-semibold" href="#">Esther Howard</a>
                                        <a class="hover:text-primary text-2sm text-secondary-foreground" href="#">esther.howard@gmail.com</a>
                                    </div>
                                </div>
                                <select class="kt-select max-w-24" data-kt-select="true">
                                    <option>Owner</option>
                                    <option selected="">Editor</option>
                                    <option>Viewer</option>
                                </select>
                            </div>
                            <div class="flex flex-wrap items-center gap-2">
                                <div class="flex grow items-center gap-2.5">
                                    <img alt="" class="size-9 shrink-0 rounded-full" src="{{ asset(Storage::url("media/avatars/300-11.png")) }}" />
                                    <div class="flex flex-col">
                                        <a class="text-mono hover:text-primary mb-px text-sm font-semibold" href="#">Jacob Jones</a>
                                        <a class="hover:text-primary text-2sm text-secondary-foreground" href="#">jacob.jones@gmail.com</a>
                                    </div>
                                </div>
                                <select class="kt-select max-w-24" data-kt-select="true">
                                    <option>Owner</option>
                                    <option>Editor</option>
                                    <option selected="">Viewer</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="border-b-border border-b"></div>
                    <div class="flex flex-col gap-4 px-5">
                        <label class="text-mono text-sm font-semibold">Settings</label>
                        <div class="flex-center flex flex-wrap justify-between gap-2">
                            <div class="flex-center flex gap-1.5">
                                <i class="ki-filled ki-user text-muted-foreground"></i>
                                <div class="flex-center text-secondary-foreground flex text-xs font-medium">
                                    Anyone at
                                    <a class="link mx-1 text-xs font-medium" href="#">KeenThemes</a>
                                    can view
                                </div>
                            </div>
                            <button class="kt-link kt-link-sm kt-link-underlined kt-link-dashed">Change Access</button>
                        </div>
                        <div class="flex-center mb-2.5 flex flex-wrap justify-between gap-2">
                            <div class="flex-center flex gap-1.5">
                                <i class="ki-filled ki-icon text-muted-foreground"></i>
                                <div class="flex-center text-secondary-foreground flex text-xs font-medium">Anyone with link can edit</div>
                            </div>
                            <button class="kt-link kt-link-sm kt-link-underlined kt-link-dashed">Set Password</button>
                        </div>
                        <button class="kt-btn kt-btn-primary justify-center">Done</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="kt-modal" data-kt-modal="true" id="report_user_modal">
            <div class="kt-modal-content top-[15%] max-w-[500px]">
                <div class="kt-modal-header">
                    <h3 class="kt-modal-title">Report User</h3>
                    <button class="kt-btn kt-btn-sm kt-btn-icon kt-btn-ghost shrink-0" data-kt-modal-dismiss="true">
                        <i class="ki-filled ki-cross"></i>
                    </button>
                </div>
                <div class="kt-modal-body p-0">
                    <div class="p-5">
                        <div class="grid place-items-center gap-1">
                            <div class="flex items-center justify-center rounded-full">
                                <img class="max-h-[55px] max-w-full rounded-full" src="{{ asset(Storage::url("media/avatars/300-1.png")) }}" alt="" />
                            </div>
                            <div class="flex items-center justify-center gap-1">
                                <a class="hover:text-primary text-mono text-sm leading-5 font-semibold" href="#">Jenny Klabber</a>
                                <svg class="text-primary" fill="none" height="13" viewbox="0 0 15 16" width="13" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M14.5425 6.89749L13.5 5.83999C13.4273 5.76877 13.3699 5.6835 13.3312 5.58937C13.2925 5.49525 13.2734 5.39424 13.275 5.29249V3.79249C13.274 3.58699 13.2324 3.38371 13.1527 3.19432C13.0729 3.00494 12.9565 2.83318 12.8101 2.68892C12.6638 2.54466 12.4904 2.43073 12.2998 2.35369C12.1093 2.27665 11.9055 2.23801 11.7 2.23999H10.2C10.0982 2.24159 9.99722 2.22247 9.9031 2.18378C9.80898 2.1451 9.72371 2.08767 9.65249 2.01499L8.60249 0.957487C8.30998 0.665289 7.91344 0.50116 7.49999 0.50116C7.08654 0.50116 6.68999 0.665289 6.39749 0.957487L5.33999 1.99999C5.26876 2.07267 5.1835 2.1301 5.08937 2.16879C4.99525 2.20747 4.89424 2.22659 4.79249 2.22499H3.29249C3.08699 2.22597 2.88371 2.26754 2.69432 2.34731C2.50494 2.42709 2.33318 2.54349 2.18892 2.68985C2.04466 2.8362 1.93073 3.00961 1.85369 3.20013C1.77665 3.39064 1.73801 3.5945 1.73999 3.79999V5.29999C1.74159 5.40174 1.72247 5.50275 1.68378 5.59687C1.6451 5.691 1.58767 5.77627 1.51499 5.84749L0.457487 6.89749C0.165289 7.19 0.00115967 7.58654 0.00115967 7.99999C0.00115967 8.41344 0.165289 8.80998 0.457487 9.10249L1.49999 10.16C1.57267 10.2312 1.6301 10.3165 1.66878 10.4106C1.70747 10.5047 1.72659 10.6057 1.72499 10.7075V12.2075C1.72597 12.413 1.76754 12.6163 1.84731 12.8056C1.92709 12.995 2.04349 13.1668 2.18985 13.3111C2.3362 13.4553 2.50961 13.5692 2.70013 13.6463C2.89064 13.7233 3.0945 13.762 3.29999 13.76H4.79999C4.90174 13.7584 5.00275 13.7775 5.09687 13.8162C5.191 13.8549 5.27627 13.9123 5.34749 13.985L6.40499 15.0425C6.69749 15.3347 7.09404 15.4988 7.50749 15.4988C7.92094 15.4988 8.31748 15.3347 8.60999 15.0425L9.65999 14C9.73121 13.9273 9.81647 13.8699 9.9106 13.8312C10.0047 13.7925 10.1057 13.7734 10.2075 13.775H11.7075C12.1212 13.775 12.518 13.6106 12.8106 13.3181C13.1031 13.0255 13.2675 12.6287 13.2675 12.215V10.715C13.2659 10.6132 13.285 10.5122 13.3237 10.4181C13.3624 10.324 13.4198 10.2387 13.4925 10.1675L14.55 9.10999C14.6953 8.96452 14.8104 8.79176 14.8887 8.60164C14.9671 8.41152 15.007 8.20779 15.0063 8.00218C15.0056 7.79656 14.9643 7.59311 14.8847 7.40353C14.8051 7.21394 14.6888 7.04197 14.5425 6.89749ZM10.635 6.64999L6.95249 10.25C6.90055 10.3026 6.83864 10.3443 6.77038 10.3726C6.70212 10.4009 6.62889 10.4153 6.55499 10.415C6.48062 10.4139 6.40719 10.3982 6.33896 10.3685C6.27073 10.3389 6.20905 10.2961 6.15749 10.2425L4.37999 8.44249C4.32532 8.39044 4.28169 8.32793 4.25169 8.25867C4.22169 8.18941 4.20593 8.11482 4.20536 8.03934C4.20479 7.96387 4.21941 7.88905 4.24836 7.81934C4.27731 7.74964 4.31999 7.68647 4.37387 7.63361C4.42774 7.58074 4.4917 7.53926 4.56194 7.51163C4.63218 7.484 4.70726 7.47079 4.78271 7.47278C4.85816 7.47478 4.93244 7.49194 5.00112 7.52324C5.0698 7.55454 5.13148 7.59935 5.18249 7.65499L6.56249 9.05749L9.84749 5.84749C9.95296 5.74215 10.0959 5.68298 10.245 5.68298C10.394 5.68298 10.537 5.74215 10.6425 5.84749C10.6953 5.90034 10.737 5.96318 10.7653 6.03234C10.7935 6.1015 10.8077 6.1756 10.807 6.25031C10.8063 6.32502 10.7908 6.39884 10.7612 6.46746C10.7317 6.53608 10.6888 6.59813 10.635 6.64999Z"
                                        fill="currentColor"
                                    ></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="border-b-border border-b"></div>
                    <div class="flex flex-col gap-5 p-5">
                        <div class="text-mono text-sm font-semibold">Let us know why you’re reporing this person</div>
                        <div class="flex flex-col gap-3.5">
                            <label class="kt-form-label flex items-center gap-2.5">
                                <input checked="" class="kt-radio radio-sm" name="report-option" type="radio" value="1" />
                                <div class="flex flex-col gap-0.5">
                                    <div class="text-mono text-sm font-semibold">Impersonation</div>
                                    <div class="text-secondary-foreground text-sm font-medium">It looks like this profile might be impersonating someone else</div>
                                </div>
                            </label>
                            <label class="kt-form-label flex items-center gap-2.5">
                                <input checked="" class="kt-radio radio-sm" name="report-option" type="radio" value="2" />
                                <div class="flex flex-col gap-0.5">
                                    <div class="text-mono text-sm font-semibold">Spammy</div>
                                    <div class="text-secondary-foreground text-sm font-medium">This person profile, comments or posts contain misleading text</div>
                                </div>
                            </label>
                            <label class="kt-form-label flex items-center gap-2.5">
                                <input checked="" class="kt-radio radio-sm" name="report-option" type="radio" value="3" />
                                <div class="flex flex-col gap-0.5">
                                    <div class="text-mono text-sm font-semibold">Off bumble behavior</div>
                                    <div class="text-secondary-foreground text-sm font-medium">This person has engaged in behavior that is abusive, bullying</div>
                                </div>
                            </label>
                            <label class="kt-form-label flex items-center gap-2.5">
                                <input checked="" class="kt-radio radio-sm" name="report-option" type="radio" value="4" />
                                <div class="flex flex-col gap-0.5">
                                    <div class="text-mono text-sm font-semibold">Something else</div>
                                    <div class="text-secondary-foreground text-sm font-medium">None of the reasons listed above are suitable</div>
                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="border-b-border border-b"></div>
                    <div class="text-2sm text-foreground p-5 text-center font-medium">
                        Don't worry, your report is completely anonymous; the person you're
                        <br />
                        reporting will not be informed that you've submitted it
                    </div>
                    <div class="border-b-border border-b"></div>
                    <div class="flex items-center justify-end gap-2.5 p-5" id="report_user_modal">
                        <button class="kt-btn kt-btn-primary">Report this person</button>
                        <button class="kt-btn kt-btn-outline" data-kt-modal-dismiss="true">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- End of Page -->
        <!-- Scripts -->
        <!-- End of Scripts -->
    </body>
</html>
