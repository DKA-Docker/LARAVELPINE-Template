<div x-data x-init="$dispatch('overview-ready')" class="grid gap-5 lg:gap-7.5 w-full">
    <div class="grid items-stretch gap-y-5 lg:grid-cols-3 lg:gap-7.5">
        <div class="lg:col-span-1">
            <div class="grid h-full grid-cols-2 items-stretch gap-5 lg:gap-6">
                @php
                    $stats = [
                        ['label' => __('dashboard.components.overview.stats.request'), 'value' => '0', 'delay' => '100ms'],
                        ['label' => __('dashboard.components.overview.stats.sending'), 'value' => '0', 'delay' => '200ms'],
                        ['label' => __('dashboard.components.overview.stats.pending'), 'value' => '0', 'delay' => '300ms'],
                        ['label' => __('dashboard.components.overview.stats.finished'), 'value' => '0', 'delay' => '400ms'],
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
                <div class="kt-card-header flex items-center justify-between px-6 py-4 border-b border-gray-100 dark:border-white/5">
                    <h3 class="kt-card-title font-bold text-lg">{{ __('dashboard.components.overview.chart.demography') }}</h3>
                    <div class="flex gap-2">
                        <button class="text-xs font-bold text-primary bg-primary/10 px-3 py-1.5 rounded-lg hover:bg-primary hover:text-white transition-all">{{ __('dashboard.components.overview.chart.by_city') }}</button>
                        <button class="text-xs font-bold text-gray-500 hover:bg-gray-100 dark:hover:bg-white/10 px-3 py-1.5 rounded-lg transition-all">{{ __('dashboard.components.overview.chart.by_district') }}</button>
                    </div>
                </div>
                <div class="kt-card-body p-6">
                    <div id="chart-demography" class="h-[350px] w-full"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- NEW CHARTS ROW -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 lg:gap-7.5 animate-fade-up" style="animation-delay: 600ms">
        <!-- Donut Chart -->
        <div class="kt-card shadow-sm border border-gray-200 dark:border-white/5 h-full">
            <div class="kt-card-header px-6 py-4 border-b border-gray-100 dark:border-white/5 flex items-center justify-between">
                <h3 class="kt-card-title font-bold text-lg">{{ __('dashboard.components.overview.chart.logistics') }}</h3>
                <div class="kt-menu-trigger p-2 hover:bg-gray-100 dark:hover:bg-white/5 rounded-lg cursor-pointer transition-colors">
                    <i class="ki-filled ki-dots-vertical text-gray-500"></i>
                </div>
            </div>
            <div class="kt-card-body p-6 flex flex-col items-center justify-center">
                    <div id="chart-donut" class="h-[350px] w-full"></div>
            </div>
        </div>

        <!-- Line Chart -->
        <div class="kt-card shadow-sm border border-gray-200 dark:border-white/5 h-full">
            <div class="kt-card-header px-6 py-4 border-b border-gray-100 dark:border-white/5 flex items-center justify-between">
                <h3 class="kt-card-title font-bold text-lg">{{ __('dashboard.components.overview.chart.performance') }}</h3>
                <select class="text-sm border-gray-200 dark:border-white/10 rounded-md bg-transparent focus:ring-0">
                    <option>{{ __('dashboard.components.overview.chart.last_7_days') }}</option>
                    <option>{{ __('dashboard.components.overview.chart.last_30_days') }}</option>
                </select>
            </div>
            <div class="kt-card-body p-6">
                    <div id="chart-line" class="h-[350px] w-full"></div>
            </div>
        </div>
    </div>
</div>
