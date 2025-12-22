<!-- Heading View -->
<div class="kt-container-fixed">
    <div class="flex flex-wrap items-center justify-between gap-5 pb-7.5 lg:items-end">
        <div class="flex flex-col justify-center gap-2">
            <h1 class="text-mono text-xl leading-none font-medium">{{ __('dashboard.request.heading') }}</h1>
            <div class="flex flex-wrap items-center gap-1.5 font-medium">
                <span class="text-secondary-foreground text-base">{{ __('dashboard.request.data.subtitle.all') }}:</span>
                <span class="gray-800 me-2 text-base font-semibold">49,053</span>
                <span class="text-green-800 text-base">{{ __('dashboard.request.data.subtitle.accepted') }}:</span>
                <span class="text-green-600 text-base font-semibold">1724</span>
                <span class="text-red-800 text-base">{{ __('dashboard.request.data.subtitle.rejected') }}:</span>
                <span class="text-red-600 text-base font-semibold">1724</span>
            </div>
        </div>
        <div class="flex items-center gap-2.5">
            <a class="kt-btn kt-btn-outline">Import</a>
            <a class="kt-btn kt-btn-primary" href="./requests/create" wire:navigate>Add Request</a>
        </div>
    </div>
</div>

