<aside class="flex flex-col shrink-0 shadow-2xl border-l border-blue-200/50 dark:border-white/10 glass-panel transition-all z-[1] w-full lg:w-[400px] h-1/2 lg:h-full relative overflow-hidden" style="z-index: 1;">
    <div class="sidebar-content-wrapper p-6 h-full relative z-[2] animate-pulse">
        {{-- Header --}}
        <div class="flex items-center gap-3 mb-6">
            <div class="w-2 h-2 rounded-full bg-gray-300 dark:bg-white/20"></div>
            <div class="h-6 w-32 bg-gray-200 dark:bg-white/10 rounded"></div>
        </div>

        {{-- Tabs --}}
        <div class="flex gap-2 mb-6">
            <div class="flex-1 h-10 bg-gray-200 dark:bg-white/5 rounded-xl"></div>
            <div class="flex-1 h-10 bg-gray-200 dark:bg-white/5 rounded-xl"></div>
        </div>

        {{-- Search --}}
        <div class="h-12 w-full bg-gray-200 dark:bg-white/5 rounded-xl mb-4"></div>

        {{-- List Items --}}
        <div class="space-y-3">
            @for ($i = 0; $i < 5; $i++)
                <div class="h-16 w-full bg-gray-100 dark:bg-white/5 rounded-xl border border-gray-200 dark:border-white/5"></div>
            @endfor
        </div>
    </div>
    
    {{-- Shimmer Effect --}}
    <div class="absolute inset-0 -translate-x-full animate-[shimmer_1.5s_infinite] bg-gradient-to-r from-transparent via-white/10 to-transparent"></div>
</aside>
