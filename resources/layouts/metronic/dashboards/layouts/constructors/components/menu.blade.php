<div class="kt-menu flex grow flex-col gap-1" data-kt-menu="true" data-kt-menu-accordion-expand-all="false" id="sidebar_menu">

    <div class="kt-menu-item">
        <a href="{{ request()->getSchemeAndHttpHost() . route('dashboards.index', [], false) }}">
            <div class="kt-menu-label border border-transparent gap-[10px] ps-[10px] pe-[10px] py-[6px]" tabindex="0">
                <span class="kt-menu-icon items-start text-muted-foreground w-[20px]">
                    <i class="ki-duotone ki-element-11 text-lg"></i>
                </span>
                <span class="kt-menu-title text-foreground kt-menu-item-active:text-primary kt-menu-link-hover:!text-primary text-sm font-bold">
                    {{ __('menu.overview') }}
                </span>
            </div>
        </a>
    </div>

    @if(auth()->user()->canany(['dashboards.apps.deliveries.requests.view', 'dashboards.apps.deliveries.tasks.view', 'dashboards.apps.deliveries.reports.view', 'dashboards.apps.trackings.index']))
        <div class="kt-menu-item pt-2.25 pb-px">
            <span class="kt-menu-heading text-muted-foreground ps-[10px] pe-[10px] text-xs font-medium uppercase">{{ __('menu.apps') }}</span>
        </div>

        @if(auth()->user()->canany(['dashboards.apps.deliveries.requests.view', 'dashboards.apps.deliveries.tasks.view', 'dashboards.apps.deliveries.reports.view']))
            <div class="kt-menu-item" data-kt-menu-item-toggle="accordion" data-kt-menu-item-trigger="click">
                <div class="kt-menu-link flex grow cursor-pointer items-center gap-[10px] border border-transparent py-[6px] ps-[10px] pe-[10px]" tabindex="0">
                <span class="kt-menu-icon text-muted-foreground w-[20px] items-start">
                    <i class="ki-duotone ki-parcel text-lg"></i>
                </span>
                    <span class="kt-menu-title text-foreground kt-menu-item-active:text-primary kt-menu-link-hover:!text-primary text-sm font-bold">{{ __('menu.delivery') }}</span>
                    <span class="kt-menu-arrow text-muted-foreground ms-1 me-[-10px] w-[20px] shrink-0 justify-end">
                <span class="kt-menu-item-show:hidden inline-flex">
                    <i class="ki-duotone ki-plus text-[11px]"></i>
                </span>
                <span class="kt-menu-item-show:inline-flex hidden">
                    <i class="ki-duotone ki-minus text-[11px]"></i>
                </span>
            </span>
                </div>
                <div class="kt-menu-accordion before:border-border relative gap-1 ps-[10px] before:absolute before:start-[20px] before:top-0 before:bottom-0 before:border-s">

                    @can('dashboards.apps.deliveries.requests.view')
                        <div class="kt-menu-item">
                            <a class="kt-menu-link kt-menu-item-active:bg-accent/60 dark:menu-item-active:border-border kt-menu-item-active:rounded-lg hover:bg-accent/60 grow items-center gap-[14px] border border-transparent py-[8px] ps-[10px] pe-[10px] hover:rounded-lg"
                               href="{{ request()->getSchemeAndHttpHost() . route('dashboards.apps.deliveries.requests.index', [], false) }}" tabindex="0">
                                <span class="kt-menu-bullet kt-menu-item-active:before:bg-primary kt-menu-item-hover:before:bg-primary relative -start-[3px] flex w-[6px] before:absolute before:top-0 before:size-[6px] before:-translate-y-1/2 before:rounded-full rtl:start-0 rtl:before:translate-x-1/2"></span>
                                <span class="kt-menu-icon text-muted-foreground items-start">
                        <i class="ki-duotone ki-delivery-3 text-lg"></i>
                    </span>
                                <span class="kt-menu-title text-2sm text-foreground kt-menu-item-active:text-primary kt-menu-item-active:font-semibold kt-menu-link-hover:!text-primary font-medium">{{ __('menu.request') }}</span>
                            </a>
                        </div>
                    @endcan

                    @can('dashboards.apps.deliveries.tasks.view')
                        <div class="kt-menu-item">
                            <a class="kt-menu-link kt-menu-item-active:bg-accent/60 dark:menu-item-active:border-border kt-menu-item-active:rounded-lg hover:bg-accent/60 grow items-center gap-[14px] border border-transparent py-[8px] ps-[10px] pe-[10px] hover:rounded-lg"
                               href="{{ request()->getSchemeAndHttpHost() . route('dashboards.apps.deliveries.tasks.index', [], false) }}" tabindex="0">
                                <span class="kt-menu-bullet kt-menu-item-active:before:bg-primary kt-menu-item-hover:before:bg-primary relative -start-[3px] flex w-[6px] before:absolute before:top-0 before:size-[6px] before:-translate-y-1/2 before:rounded-full rtl:start-0 rtl:before:translate-x-1/2"></span>
                                <span class="kt-menu-icon text-muted-foreground items-start">
                        <i class="ki-duotone ki-time text-lg"></i>
                    </span>
                                <span class="kt-menu-title text-2sm text-foreground kt-menu-item-active:text-primary kt-menu-item-active:font-semibold kt-menu-link-hover:!text-primary font-medium">{{ __('menu.task') }}</span>
                            </a>
                        </div>
                    @endcan

                    @can('dashboards.apps.deliveries.reports.view')
                        <div class="kt-menu-item">
                            <a class="kt-menu-link kt-menu-item-active:bg-accent/60 dark:menu-item-active:border-border kt-menu-item-active:rounded-lg hover:bg-accent/60 grow items-center gap-[14px] border border-transparent py-[8px] ps-[10px] pe-[10px] hover:rounded-lg"
                               href="{{ request()->getSchemeAndHttpHost() . route('dashboards.apps.deliveries.reports.index', [], false) }}" tabindex="0">
                                <span class="kt-menu-bullet kt-menu-item-active:before:bg-primary kt-menu-item-hover:before:bg-primary relative -start-[3px] flex w-[6px] before:absolute before:top-0 before:size-[6px] before:-translate-y-1/2 before:rounded-full rtl:start-0 rtl:before:translate-x-1/2"></span>
                                <span class="kt-menu-icon text-muted-foreground items-start">
                                    <i class="ki-duotone ki-element-8 text-lg"></i>
                                </span>
                                <span class="kt-menu-title text-2sm text-foreground kt-menu-item-active:text-primary kt-menu-item-active:font-semibold kt-menu-link-hover:!text-primary font-medium">{{ __('menu.report') }}</span>
                            </a>
                        </div>
                    @endcan

                </div>
            </div>
        @endif

        <div class="kt-menu-item">
            <a href="{{ request()->getSchemeAndHttpHost() . route('dashboards.apps.trackings.index', [], false) }}">
                <div class="kt-menu-label border border-transparent gap-[10px] ps-[10px] pe-[10px] py-[6px]" tabindex="0">
                <span class="kt-menu-icon items-start text-muted-foreground w-[20px]">
                    <i class="ki-duotone ki-map text-lg"></i>
                </span>
                    <span class="kt-menu-title text-foreground kt-menu-item-active:text-primary kt-menu-link-hover:!text-primary text-sm font-bold">
                    {{ __('menu.tracking') }}
                </span>
                </div>
            </a>
        </div>
    @endif

    @can('dashboards.managements.accounts.view')
        <div class="kt-menu-item pt-2.25 pb-px">
            <span class="kt-menu-heading text-muted-foreground ps-[10px] pe-[10px] text-xs font-medium uppercase">{{ __('menu.management') }}</span>
        </div>
        <div class="kt-menu-item">
            <a href="{{ request()->getSchemeAndHttpHost() . route('dashboards.managements.accounts.index', [], false) }}">
                <div class="kt-menu-label border border-transparent gap-[10px] ps-[10px] pe-[10px] py-[6px]" tabindex="0">
                <span class="kt-menu-icon items-start text-muted-foreground w-[20px]">
                    <i class="ki-duotone ki-user text-lg"></i>
                </span>
                    <span class="kt-menu-title text-foreground kt-menu-item-active:text-primary kt-menu-link-hover:!text-primary text-sm font-bold">
                    {{ __('menu.account') }}
                </span>
                </div>
            </a>

        </div>

        <div class="kt-menu-item pt-2.25 pb-px">
            <span class="kt-menu-heading text-muted-foreground ps-[10px] pe-[10px] text-xs font-medium uppercase">{{ __('menu.settings') }}</span>
        </div>
        <div class="kt-menu-item" data-kt-menu-item-toggle="accordion" data-kt-menu-item-trigger="click">
            <div class="kt-menu-link flex grow cursor-pointer items-center gap-[10px] border border-transparent py-[6px] ps-[10px] pe-[10px]" tabindex="0">
                <span class="kt-menu-icon text-muted-foreground w-[20px] items-start">
                    <i class="ki-duotone ki-setting-2 text-lg"></i>
                </span>
                <span class="kt-menu-title text-foreground kt-menu-item-active:text-primary kt-menu-link-hover:!text-primary text-sm font-bold">{{ __('menu.settings') }}</span>
                <span class="kt-menu-arrow text-muted-foreground ms-1 me-[-10px] w-[20px] shrink-0 justify-end">
                    <span class="kt-menu-item-show:hidden inline-flex">
                        <i class="ki-duotone ki-plus text-[11px]"></i>
                    </span>
                    <span class="kt-menu-item-show:inline-flex hidden">
                        <i class="ki-duotone ki-minus text-[11px]"></i>
                    </span>
                </span>
            </div>
            <div class="kt-menu-accordion before:border-border relative gap-1 ps-[10px] before:absolute before:start-[20px] before:top-0 before:bottom-0 before:border-s">
                <div class="kt-menu-item">
                    <a class="kt-menu-link kt-menu-item-active:bg-accent/60 dark:menu-item-active:border-border kt-menu-item-active:rounded-lg hover:bg-accent/60 grow items-center gap-[14px] border border-transparent py-[8px] ps-[10px] pe-[10px] hover:rounded-lg"
                       href="{{ request()->getSchemeAndHttpHost() . route('dashboards.settings.vehicles.index', [], false) }}" tabindex="0">
                        <span class="kt-menu-bullet kt-menu-item-active:before:bg-primary kt-menu-item-hover:before:bg-primary relative -start-[3px] flex w-[6px] before:absolute before:top-0 before:size-[6px] before:-translate-y-1/2 before:rounded-full rtl:start-0 rtl:before:translate-x-1/2"></span>
                        <span class="kt-menu-icon text-muted-foreground items-start">
                            <i class="ki-duotone ki-car-2 text-lg"></i>
                        </span>
                        <span class="kt-menu-title text-2sm text-foreground kt-menu-item-active:text-primary kt-menu-item-active:font-semibold kt-menu-link-hover:!text-primary font-medium">{{ __('menu.vehicle') }}</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="kt-menu-item">
            <a href="{{ request()->getSchemeAndHttpHost() . route('dashboards.apps.deliveries.rates.index', [], false) }}" tabindex="0">
                <div class="kt-menu-label border border-transparent gap-[10px] ps-[10px] pe-[10px] py-[6px]" tabindex="1">
                <span class="kt-menu-icon text-muted-foreground items-start">
                        <i class="ki-duotone ki-tag text-lg"></i>
                </span>
                    <span class="kt-menu-title text-foreground kt-menu-item-active:text-primary kt-menu-link-hover:!text-primary text-sm font-bold">{{ __('menu.rates') }}</span>
                </div>
            </a>
        </div>

    @endcan

</div>
