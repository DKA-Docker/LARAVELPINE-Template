<div class="animate-pulse w-full">
    <div class="grid gap-5 lg:gap-7.5">
        <div class="grid items-stretch gap-y-5 lg:grid-cols-3 lg:gap-7.5">
            <div class="lg:col-span-1">
                <div class="grid h-full grid-cols-2 items-stretch gap-5 lg:gap-6">
                    @for($i=0; $i<4; $i++)
                        <div class="kt-card flex-col justify-between gap-6 p-5 shadow-sm border border-gray-200 dark:border-white/5 rounded-xl h-32 bg-gray-100 dark:bg-white/5">
                            <div class="h-8 w-12 rounded bg-gray-200 dark:bg-white/10"></div>
                            <div class="h-3 w-24 rounded bg-gray-200 dark:bg-white/10"></div>
                        </div>
                    @endfor
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="kt-card h-full shadow-xl border-none ring-1 ring-black/5 dark:ring-white/5 bg-white dark:bg-transparent rounded-xl">
                    <div class="px-6 py-4 border-b border-gray-100 dark:border-white/5 flex justify-between items-center">
                        <div class="h-6 w-48 rounded bg-gray-200 dark:bg-white/10"></div>
                        <div class="flex gap-2">
                            <div class="h-8 w-20 rounded bg-gray-200 dark:bg-white/10"></div>
                            <div class="h-8 w-20 rounded bg-gray-200 dark:bg-white/10"></div>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="h-[350px] w-full rounded bg-gray-100 dark:bg-white/5"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 lg:gap-7.5">
            @for($i=0; $i<2; $i++)
                <div class="kt-card shadow-sm border border-gray-200 dark:border-white/5 h-full rounded-xl">
                    <div class="px-6 py-4 border-b border-gray-100 dark:border-white/5 flex justify-between items-center">
                        <div class="h-6 w-40 rounded bg-gray-200 dark:bg-white/10"></div>
                        <div class="h-8 w-8 rounded bg-gray-200 dark:bg-white/10"></div>
                    </div>
                    <div class="p-6">
                        <div class="h-[350px] w-full rounded bg-gray-100 dark:bg-white/5"></div>
                    </div>
                </div>
            @endfor
        </div>
    </div>
</div>
