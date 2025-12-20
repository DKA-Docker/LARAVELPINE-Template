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
                            <a class="kt-btn kt-btn-primary" href="{{ route(preg_replace('/\.[^.]+$/', '.create', Route::currentRouteName())) }}">Add Account</a>
                        </div>
                    </div>
                </div>
                <!-- End of Container -->
                <!-- Container -->

                <!-- Select Table Header Status -->
                <div class="kt-container-fixed">
                    <div class="grid gap-5 lg:gap-7.5">
                        <div class="kt-card kt-card-grid min-w-full" id="table-container">
                            <div class="kt-card-header flex-wrap gap-2">
                                <h3 class="kt-card-title text-sm">Showing <span class="show_from">0</span> of <span class="show_total"></span> users</h3>
                                <div class="flex flex-wrap gap-2 lg:gap-5">
                                    <div class="flex">
                                        <label class="kt-input">
                                            <i class="ki-filled ki-magnifier"></i>
                                            <input placeholder="Search users" type="text" value="" />
                                        </label>
                                    </div>
                                    <div class="flex flex-wrap gap-2.5">
                                        <select class="kt-select w-36" data-kt-select="true" data-kt-select-placeholder="Select a status">
                                            <option value="1">Active</option>
                                            <option value="2">Disabled</option>
                                            <option value="2">Pending</option>
                                        </select>
                                        <select class="kt-select w-36" data-kt-select="true" data-kt-select-placeholder="Select a sort">
                                            <option value="1">Latest</option>
                                            <option value="2">Older</option>
                                            <option value="3">Oldest</option>
                                        </select>
                                        <button class="kt-btn kt-btn-outline kt-btn-primary">
                                            <i class="ki-filled ki-setting-4"></i>
                                            Filters
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="kt-card-content">
                                <div class="grid">
                                    <div class="kt-scrollable-x-auto">
                                        <table class="kt-table kt-table-border table-auto" data-kt-datatable-table="true" data-kt-datatable-page-size="5" id="table-delivery-request">
                                            <thead>
                                            <tr>
                                                <th scope="col" data-kt-datatable-column="name">
                                                    <span class="kt-table-col">
                                                        <span class="kt-table-col-label">Nama Task</span>
                                                        <span class="kt-table-col-sort"></span>
                                                    </span>
                                                </th>
                                                <th scope="col" data-kt-datatable-column="email">
                                                    <span class="kt-table-col">
                                                        <span class="kt-table-col-label">Email</span>
                                                        <span class="kt-table-col-sort"></span>
                                                    </span>
                                                </th>
                                                <th scope="col" data-kt-datatable-column="destinations">
                                                    <span class="kt-table-col">
                                                        <span class="kt-table-col-label">Destinations</span>
                                                        <span class="kt-table-col-sort"></span>
                                                    </span>
                                                </th>
                                                <th scope="col" data-kt-datatable-column="created_at">
                                                    <span class="kt-table-col">
                                                        <span class="kt-table-col-label">Tanggal dibuat</span>
                                                        <span class="kt-table-col-sort"></span>
                                                    </span>
                                                </th>
                                                <th scope="col" data-kt-datatable-column="actions">
                                                    <span class="kt-table-col">
                                                        <span class="kt-table-col-label">Aksi</span>
                                                        <span class="kt-table-col-sort"></span>
                                                    </span>
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="kt-card-footer text-secondary-foreground flex-col justify-center gap-5 text-sm font-medium md:flex-row md:justify-between">
                                        <div class="order-2 flex items-center gap-2 md:order-1">
                                            Menampilkan
                                            <select class="kt-select w-16" data-kt-datatable-size="true" data-kt-select="" name="perpage"></select>
                                            Per Halaman
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

            </main>
            <!-- End of Content -->
            @livewire("metronic.dashboards.layouts.constructors.footers")
        </div>

        <!-- End of Page -->
        <!-- Scripts -->
        <div class="dashboards-apps-managements-accounts"/>
        <!-- End of Scripts -->
    </body>
</x-metronic.dashboards.layouts.container>
