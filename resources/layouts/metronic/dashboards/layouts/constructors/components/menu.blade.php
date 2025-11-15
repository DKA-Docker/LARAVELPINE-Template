<!-- Sidebar Menu -->
<div class="kt-menu flex grow flex-col gap-1" data-kt-menu="true" data-kt-menu-accordion-expand-all="false" id="sidebar_menu">
    <div class="kt-menu-item">
        <a href="{{ request()->getSchemeAndHttpHost() . route('dashboards.index', [], false) }}">
            <div class="kt-menu-label gap-[10px] border border-transparent py-[6px] ps-[10px] pe-[10px]" tabindex="0">
            <span class="kt-menu-icon text-muted-foreground w-[20px] items-start">
                <i class="ki-duotone ki-element-11 text-lg"></i>
            </span>
                <span class="kt-menu-title text-foreground text-sm font-bold">Overview</span>
            </div>
        </a>
    </div>
    <div class="kt-menu-item pt-2.25 pb-px">
        <span class="kt-menu-heading text-muted-foreground ps-[10px] pe-[10px] text-xs font-medium uppercase">Apps</span>
    </div>
    <div class="kt-menu-item" data-kt-menu-item-toggle="accordion" data-kt-menu-item-trigger="click">
        <div class="kt-menu-link flex grow cursor-pointer items-center gap-[10px] border border-transparent py-[6px] ps-[10px] pe-[10px]" tabindex="0">
            <span class="kt-menu-icon text-muted-foreground w-[20px] items-start">
                <i class="ki-duotone ki-parcel text-lg"></i>
            </span>
            <span class="kt-menu-title text-foreground kt-menu-item-active:text-primary kt-menu-link-hover:!text-primary text-sm font-bold">Delivery</span>
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
                <a
                    class="kt-menu-link kt-menu-item-active:bg-accent/60 dark:menu-item-active:border-border kt-menu-item-active:rounded-lg hover:bg-accent/60 grow items-center gap-[14px] border border-transparent py-[8px] ps-[10px] pe-[10px] hover:rounded-lg"
                    href="{{ request()->getSchemeAndHttpHost() . route('dashboards.apps.deliveries.requests.index', [], false) }}"
                    tabindex="0"
                >
                    <span
                        class="kt-menu-bullet kt-menu-item-active:before:bg-primary kt-menu-item-hover:before:bg-primary relative -start-[3px] flex w-[6px] before:absolute before:top-0 before:size-[6px] before:-translate-y-1/2 before:rounded-full rtl:start-0 rtl:before:translate-x-1/2"
                    ></span>
                    <span class="kt-menu-icon text-muted-foreground items-start">
                        <i class="ki-duotone ki-delivery-3 text-lg"></i>
                    </span>
                    <span class="kt-menu-title text-2sm text-foreground kt-menu-item-active:text-primary kt-menu-item-active:font-semibold kt-menu-link-hover:!text-primary font-medium">Request</span>
                </a>
            </div>
            <div class="kt-menu-item">
                <a
                    class="kt-menu-link kt-menu-item-active:bg-accent/60 dark:menu-item-active:border-border kt-menu-item-active:rounded-lg hover:bg-accent/60 grow items-center gap-[14px] border border-transparent py-[8px] ps-[10px] pe-[10px] hover:rounded-lg"
                    href="{{ request()->getSchemeAndHttpHost() . route('dashboards.apps.deliveries.tasks.index', [], false) }}"
                    tabindex="0"
                >
                    <span
                        class="kt-menu-bullet kt-menu-item-active:before:bg-primary kt-menu-item-hover:before:bg-primary relative -start-[3px] flex w-[6px] before:absolute before:top-0 before:size-[6px] before:-translate-y-1/2 before:rounded-full rtl:start-0 rtl:before:translate-x-1/2"
                    ></span>
                    <span class="kt-menu-icon text-muted-foreground items-start">
                        <i class="ki-duotone ki-time text-lg"></i>
                    </span>
                    <span class="kt-menu-title text-2sm text-foreground kt-menu-item-active:text-primary kt-menu-item-active:font-semibold kt-menu-link-hover:!text-primary font-medium">Task</span>
                </a>
            </div>
            <div class="kt-menu-item">
                <a
                    class="kt-menu-link kt-menu-item-active:bg-accent/60 dark:menu-item-active:border-border kt-menu-item-active:rounded-lg hover:bg-accent/60 grow items-center gap-[14px] border border-transparent py-[8px] ps-[10px] pe-[10px] hover:rounded-lg"
                    href="{{ request()->getSchemeAndHttpHost() . route('dashboards.apps.deliveries.reports.index', [], false) }}"
                    tabindex="0"
                >
                    <span
                        class="kt-menu-bullet kt-menu-item-active:before:bg-primary kt-menu-item-hover:before:bg-primary relative -start-[3px] flex w-[6px] before:absolute before:top-0 before:size-[6px] before:-translate-y-1/2 before:rounded-full rtl:start-0 rtl:before:translate-x-1/2"
                    ></span>
                    <span class="kt-menu-icon text-muted-foreground items-start">
                        <i class="ki-duotone ki-element-8 text-lg"></i>
                    </span>
                    <span class="kt-menu-title text-2sm text-foreground kt-menu-item-active:text-primary kt-menu-item-active:font-semibold kt-menu-link-hover:!text-primary font-medium">Report</span>
                </a>
            </div>
        </div>
    </div>
    <div class="kt-menu-item">
        <a href="{{ request()->getSchemeAndHttpHost() . route('dashboards.apps.trackings.index', [], false) }}">
            <div class="kt-menu-label gap-[10px] border border-transparent py-[6px] ps-[10px] pe-[10px]" tabindex="0">
            <span class="kt-menu-icon text-muted-foreground w-[20px] items-start">
                <i class="ki-duotone ki-map text-lg"></i>
            </span>

                <span class="kt-menu-title text-foreground text-sm font-bold">Tracking</span>
            </div>
        </a>
    </div>
    <div class="kt-menu-item pt-2.25 pb-px">
        <span class="kt-menu-heading text-muted-foreground ps-[10px] pe-[10px] text-xs font-medium uppercase">Management</span>
    </div>
    <div class="kt-menu-item">
        <div class="kt-menu-label gap-[10px] border border-transparent py-[6px] ps-[10px] pe-[10px]" tabindex="0">
            <span class="kt-menu-icon text-muted-foreground w-[20px] items-start">
                <i class="ki-duotone ki-user text-lg"></i>
            </span>
            <span class="kt-menu-title text-foreground text-sm font-bold">Account</span>
        </div>
    </div>
    {{--
        <div class="hidden">
        <div class="kt-menu-item pt-2.25 pb-px">
        <span class="kt-menu-heading text-muted-foreground ps-[10px] pe-[10px] text-xs font-medium uppercase">Example</span>
        </div>
        <div class="kt-menu-item">
        <div class="kt-menu-label gap-[10px] border border-transparent py-[6px] ps-[10px] pe-[10px]" tabindex="0">
        <span class="kt-menu-icon text-muted-foreground w-[20px] items-start">
        <i class="ki-duotone ki-cheque text-lg"></i>
        </span>
        <span class="kt-menu-title text-foreground text-sm font-medium">Invoice Generator</span>
        <span class="kt-menu-badge me-[-10px]">
        <span class="kt-badge kt-badge-sm text-accent-foreground/60">Soon</span>
        </span>
        </div>
        </div>
        <div class="kt-menu-item">
        <div class="kt-menu-label gap-[10px] border border-transparent py-[6px] ps-[10px] pe-[10px]" tabindex="0">
        <span class="kt-menu-icon text-muted-foreground w-[20px] items-start">
        <i class="ki-duotone ki-delivery-3 text-lg"></i>
        </span>
        <span class="kt-menu-title text-foreground text-sm font-medium">Permintaan</span>
        </div>
        </div>
        <div class="kt-menu-item" data-kt-menu-item-toggle="accordion" data-kt-menu-item-trigger="click">
        <div class="kt-menu-link flex grow cursor-pointer items-center gap-[10px] border border-transparent py-[6px] ps-[10px] pe-[10px]" tabindex="0">
        <span class="kt-menu-icon text-muted-foreground w-[20px] items-start">
        <i class="ki-duotone ki-security-user text-lg"></i>
        </span>
        <span class="kt-menu-title text-foreground kt-menu-item-active:text-primary kt-menu-link-hover:!text-primary text-sm font-medium">Authentication</span>
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
        <div class="kt-menu-item" data-kt-menu-item-toggle="accordion" data-kt-menu-item-trigger="click">
        <div class="kt-menu-link grow cursor-pointer gap-[14px] border border-transparent py-[8px] ps-[10px] pe-[10px]" tabindex="0">
        <span
        class="kt-menu-bullet kt-menu-item-active:before:bg-primary kt-menu-item-hover:before:bg-primary relative -start-[3px] flex w-[6px] before:absolute before:top-0 before:size-[6px] before:-translate-y-1/2 before:rounded-full rtl:start-0 rtl:before:translate-x-1/2"
        ></span>
        <span class="kt-menu-title text-2sm text-foreground kt-menu-item-active:text-primary kt-menu-item-active:font-medium kt-menu-link-hover:!text-primary me-1 font-normal">
        Classic
        </span>
        <span class="kt-menu-arrow text-muted-foreground ms-1 me-[-10px] w-[20px] shrink-0 justify-end">
        <span class="kt-menu-item-show:hidden inline-flex">
        <i class="ki-duotone ki-plus text-[11px]"></i>
        </span>
        <span class="kt-menu-item-show:inline-flex hidden">
        <i class="ki-duotone ki-minus text-[11px]"></i>
        </span>
        </span>
        </div>
        <div class="kt-menu-accordion before:border-border relative gap-1 ps-[22px] before:absolute before:start-[32px] before:top-0 before:bottom-0 before:border-s">
        <div class="kt-menu-item">
        <a
        class="kt-menu-link kt-menu-item-active:bg-accent/60 dark:menu-item-active:border-border kt-menu-item-active:rounded-lg hover:bg-accent/60 grow items-center gap-[5px] border border-transparent py-[8px] ps-[10px] pe-[10px] hover:rounded-lg"
        href="#"
        tabindex="0"
        >
        <span
        class="kt-menu-bullet kt-menu-item-active:before:bg-primary kt-menu-item-hover:before:bg-primary relative -start-[3px] flex w-[6px] before:absolute before:top-0 before:size-[6px] before:-translate-y-1/2 before:rounded-full rtl:start-0 rtl:before:translate-x-1/2"
        ></span>
        <span class="kt-menu-title text-2sm text-foreground kt-menu-item-active:text-primary kt-menu-item-active:font-semibold kt-menu-link-hover:!text-primary font-normal">
        Sign In
        </span>
        </a>
        </div>
        <div class="kt-menu-item">
        <a
        class="kt-menu-link kt-menu-item-active:bg-accent/60 dark:menu-item-active:border-border kt-menu-item-active:rounded-lg hover:bg-accent/60 grow items-center gap-[5px] border border-transparent py-[8px] ps-[10px] pe-[10px] hover:rounded-lg"
        href="#"
        tabindex="0"
        >
        <span
        class="kt-menu-bullet kt-menu-item-active:before:bg-primary kt-menu-item-hover:before:bg-primary relative -start-[3px] flex w-[6px] before:absolute before:top-0 before:size-[6px] before:-translate-y-1/2 before:rounded-full rtl:start-0 rtl:before:translate-x-1/2"
        ></span>
        <span class="kt-menu-title text-2sm text-foreground kt-menu-item-active:text-primary kt-menu-item-active:font-semibold kt-menu-link-hover:!text-primary font-normal">
        Sign Up
        </span>
        </a>
        </div>
        <div class="kt-menu-item">
        <a
        class="kt-menu-link kt-menu-item-active:bg-accent/60 dark:menu-item-active:border-border kt-menu-item-active:rounded-lg hover:bg-accent/60 grow items-center gap-[5px] border border-transparent py-[8px] ps-[10px] pe-[10px] hover:rounded-lg"
        href="#"
        tabindex="0"
        >
        <span
        class="kt-menu-bullet kt-menu-item-active:before:bg-primary kt-menu-item-hover:before:bg-primary relative -start-[3px] flex w-[6px] before:absolute before:top-0 before:size-[6px] before:-translate-y-1/2 before:rounded-full rtl:start-0 rtl:before:translate-x-1/2"
        ></span>
        <span class="kt-menu-title text-2sm text-foreground kt-menu-item-active:text-primary kt-menu-item-active:font-semibold kt-menu-link-hover:!text-primary font-normal">
        2FA
        </span>
        </a>
        </div>
        <div class="kt-menu-item">
        <a
        class="kt-menu-link kt-menu-item-active:bg-accent/60 dark:menu-item-active:border-border kt-menu-item-active:rounded-lg hover:bg-accent/60 grow items-center gap-[5px] border border-transparent py-[8px] ps-[10px] pe-[10px] hover:rounded-lg"
        href="#"
        tabindex="0"
        >
        <span
        class="kt-menu-bullet kt-menu-item-active:before:bg-primary kt-menu-item-hover:before:bg-primary relative -start-[3px] flex w-[6px] before:absolute before:top-0 before:size-[6px] before:-translate-y-1/2 before:rounded-full rtl:start-0 rtl:before:translate-x-1/2"
        ></span>
        <span class="kt-menu-title text-2sm text-foreground kt-menu-item-active:text-primary kt-menu-item-active:font-semibold kt-menu-link-hover:!text-primary font-normal">
        Check Email
        </span>
        </a>
        </div>
        <div class="kt-menu-item" data-kt-menu-item-toggle="accordion" data-kt-menu-item-trigger="click">
        <div class="kt-menu-link grow cursor-pointer gap-[5px] border border-transparent py-[8px] ps-[10px] pe-[10px]" tabindex="0">
        <span
        class="kt-menu-bullet kt-menu-item-active:before:bg-primary kt-menu-item-hover:before:bg-primary relative -start-[3px] flex w-[6px] before:absolute before:top-0 before:size-[6px] before:-translate-y-1/2 before:rounded-full rtl:start-0 rtl:before:translate-x-1/2"
        ></span>
        <span class="kt-menu-title text-2sm text-foreground kt-menu-item-active:text-primary kt-menu-item-active:font-medium kt-menu-link-hover:!text-primary me-1 font-normal">
        Reset Password
        </span>
        <span class="kt-menu-arrow text-muted-foreground ms-1 me-[-10px] w-[20px] shrink-0 justify-end">
        <span class="kt-menu-item-show:hidden inline-flex">
        <i class="ki-duotone ki-plus text-[11px]"></i>
        </span>
        <span class="kt-menu-item-show:inline-flex hidden">
        <i class="ki-duotone ki-minus text-[11px]"></i>
        </span>
        </span>
        </div>
        <div class="kt-menu-accordion before:border-border relative gap-1 ps-[22px] before:absolute before:start-[32px] before:top-0 before:bottom-0 before:border-s">
        <div class="kt-menu-item">
        <a
        class="kt-menu-link kt-menu-item-active:bg-accent/60 dark:menu-item-active:border-border kt-menu-item-active:rounded-lg hover:bg-accent/60 grow items-center gap-[5px] border border-transparent py-[8px] ps-[10px] pe-[10px] hover:rounded-lg"
        href="#"
        tabindex="0"
        >
        <span
        class="kt-menu-bullet kt-menu-item-active:before:bg-primary kt-menu-item-hover:before:bg-primary relative -start-[3px] flex w-[6px] before:absolute before:top-0 before:size-[6px] before:-translate-y-1/2 before:rounded-full rtl:start-0 rtl:before:translate-x-1/2"
        ></span>
        <span
        class="kt-menu-title text-2sm text-foreground kt-menu-item-active:text-primary kt-menu-item-active:font-semibold kt-menu-link-hover:!text-primary font-normal"
        >
        Enter Email
        </span>
        </a>
        </div>
        <div class="kt-menu-item">
        <a
        class="kt-menu-link kt-menu-item-active:bg-accent/60 dark:menu-item-active:border-border kt-menu-item-active:rounded-lg hover:bg-accent/60 grow items-center gap-[5px] border border-transparent py-[8px] ps-[10px] pe-[10px] hover:rounded-lg"
        href="#"
        tabindex="0"
        >
        <span
        class="kt-menu-bullet kt-menu-item-active:before:bg-primary kt-menu-item-hover:before:bg-primary relative -start-[3px] flex w-[6px] before:absolute before:top-0 before:size-[6px] before:-translate-y-1/2 before:rounded-full rtl:start-0 rtl:before:translate-x-1/2"
        ></span>
        <span
        class="kt-menu-title text-2sm text-foreground kt-menu-item-active:text-primary kt-menu-item-active:font-semibold kt-menu-link-hover:!text-primary font-normal"
        >
        Check Email
        </span>
        </a>
        </div>
        <div class="kt-menu-item">
        <a
        class="kt-menu-link kt-menu-item-active:bg-accent/60 dark:menu-item-active:border-border kt-menu-item-active:rounded-lg hover:bg-accent/60 grow items-center gap-[5px] border border-transparent py-[8px] ps-[10px] pe-[10px] hover:rounded-lg"
        href="#"
        tabindex="0"
        >
        <span
        class="kt-menu-bullet kt-menu-item-active:before:bg-primary kt-menu-item-hover:before:bg-primary relative -start-[3px] flex w-[6px] before:absolute before:top-0 before:size-[6px] before:-translate-y-1/2 before:rounded-full rtl:start-0 rtl:before:translate-x-1/2"
        ></span>
        <span
        class="kt-menu-title text-2sm text-foreground kt-menu-item-active:text-primary kt-menu-item-active:font-semibold kt-menu-link-hover:!text-primary font-normal"
        >
        Change Password
        </span>
        </a>
        </div>
        <div class="kt-menu-item">
        <a
        class="kt-menu-link kt-menu-item-active:bg-accent/60 dark:menu-item-active:border-border kt-menu-item-active:rounded-lg hover:bg-accent/60 grow items-center gap-[5px] border border-transparent py-[8px] ps-[10px] pe-[10px] hover:rounded-lg"
        href="#"
        tabindex="0"
        >
        <span
        class="kt-menu-bullet kt-menu-item-active:before:bg-primary kt-menu-item-hover:before:bg-primary relative -start-[3px] flex w-[6px] before:absolute before:top-0 before:size-[6px] before:-translate-y-1/2 before:rounded-full rtl:start-0 rtl:before:translate-x-1/2"
        ></span>
        <span
        class="kt-menu-title text-2sm text-foreground kt-menu-item-active:text-primary kt-menu-item-active:font-semibold kt-menu-link-hover:!text-primary font-normal"
        >
        Password is Changed
        </span>
        </a>
        </div>
        </div>
        </div>
        </div>
        </div>
        <div class="kt-menu-item" data-kt-menu-item-toggle="accordion" data-kt-menu-item-trigger="click">
        <div class="kt-menu-link grow cursor-pointer gap-[14px] border border-transparent py-[8px] ps-[10px] pe-[10px]" tabindex="0">
        <span
        class="kt-menu-bullet kt-menu-item-active:before:bg-primary kt-menu-item-hover:before:bg-primary relative -start-[3px] flex w-[6px] before:absolute before:top-0 before:size-[6px] before:-translate-y-1/2 before:rounded-full rtl:start-0 rtl:before:translate-x-1/2"
        ></span>
        <span class="kt-menu-title text-2sm text-foreground kt-menu-item-active:text-primary kt-menu-item-active:font-medium kt-menu-link-hover:!text-primary me-1 font-normal">
        Branded
        </span>
        <span class="kt-menu-arrow text-muted-foreground ms-1 me-[-10px] w-[20px] shrink-0 justify-end">
        <span class="kt-menu-item-show:hidden inline-flex">
        <i class="ki-duotone ki-plus text-[11px]"></i>
        </span>
        <span class="kt-menu-item-show:inline-flex hidden">
        <i class="ki-duotone ki-minus text-[11px]"></i>
        </span>
        </span>
        </div>
        <div class="kt-menu-accordion before:border-border relative gap-1 ps-[22px] before:absolute before:start-[32px] before:top-0 before:bottom-0 before:border-s">
        <div class="kt-menu-item">
        <a
        class="kt-menu-link kt-menu-item-active:bg-accent/60 dark:menu-item-active:border-border kt-menu-item-active:rounded-lg hover:bg-accent/60 grow items-center gap-[5px] border border-transparent py-[8px] ps-[10px] pe-[10px] hover:rounded-lg"
        href="#"
        tabindex="0"
        >
        <span
        class="kt-menu-bullet kt-menu-item-active:before:bg-primary kt-menu-item-hover:before:bg-primary relative -start-[3px] flex w-[6px] before:absolute before:top-0 before:size-[6px] before:-translate-y-1/2 before:rounded-full rtl:start-0 rtl:before:translate-x-1/2"
        ></span>
        <span class="kt-menu-title text-2sm text-foreground kt-menu-item-active:text-primary kt-menu-item-active:font-semibold kt-menu-link-hover:!text-primary font-normal">
        Sign In
        </span>
        </a>
        </div>
        <div class="kt-menu-item">
        <a
        class="kt-menu-link kt-menu-item-active:bg-accent/60 dark:menu-item-active:border-border kt-menu-item-active:rounded-lg hover:bg-accent/60 grow items-center gap-[5px] border border-transparent py-[8px] ps-[10px] pe-[10px] hover:rounded-lg"
        href="#"
        tabindex="0"
        >
        <span
        class="kt-menu-bullet kt-menu-item-active:before:bg-primary kt-menu-item-hover:before:bg-primary relative -start-[3px] flex w-[6px] before:absolute before:top-0 before:size-[6px] before:-translate-y-1/2 before:rounded-full rtl:start-0 rtl:before:translate-x-1/2"
        ></span>
        <span class="kt-menu-title text-2sm text-foreground kt-menu-item-active:text-primary kt-menu-item-active:font-semibold kt-menu-link-hover:!text-primary font-normal">
        Sign Up
        </span>
        </a>
        </div>
        <div class="kt-menu-item">
        <a
        class="kt-menu-link kt-menu-item-active:bg-accent/60 dark:menu-item-active:border-border kt-menu-item-active:rounded-lg hover:bg-accent/60 grow items-center gap-[5px] border border-transparent py-[8px] ps-[10px] pe-[10px] hover:rounded-lg"
        href="#"
        tabindex="0"
        >
        <span
        class="kt-menu-bullet kt-menu-item-active:before:bg-primary kt-menu-item-hover:before:bg-primary relative -start-[3px] flex w-[6px] before:absolute before:top-0 before:size-[6px] before:-translate-y-1/2 before:rounded-full rtl:start-0 rtl:before:translate-x-1/2"
        ></span>
        <span class="kt-menu-title text-2sm text-foreground kt-menu-item-active:text-primary kt-menu-item-active:font-semibold kt-menu-link-hover:!text-primary font-normal">
        2FA
        </span>
        </a>
        </div>
        <div class="kt-menu-item">
        <a
        class="kt-menu-link kt-menu-item-active:bg-accent/60 dark:menu-item-active:border-border kt-menu-item-active:rounded-lg hover:bg-accent/60 grow items-center gap-[5px] border border-transparent py-[8px] ps-[10px] pe-[10px] hover:rounded-lg"
        href="#"
        tabindex="0"
        >
        <span
        class="kt-menu-bullet kt-menu-item-active:before:bg-primary kt-menu-item-hover:before:bg-primary relative -start-[3px] flex w-[6px] before:absolute before:top-0 before:size-[6px] before:-translate-y-1/2 before:rounded-full rtl:start-0 rtl:before:translate-x-1/2"
        ></span>
        <span class="kt-menu-title text-2sm text-foreground kt-menu-item-active:text-primary kt-menu-item-active:font-semibold kt-menu-link-hover:!text-primary font-normal">
        Check Email
        </span>
        </a>
        </div>
        <div class="kt-menu-item" data-kt-menu-item-toggle="accordion" data-kt-menu-item-trigger="click">
        <div class="kt-menu-link grow cursor-pointer gap-[5px] border border-transparent py-[8px] ps-[10px] pe-[10px]" tabindex="0">
        <span
        class="kt-menu-bullet kt-menu-item-active:before:bg-primary kt-menu-item-hover:before:bg-primary relative -start-[3px] flex w-[6px] before:absolute before:top-0 before:size-[6px] before:-translate-y-1/2 before:rounded-full rtl:start-0 rtl:before:translate-x-1/2"
        ></span>
        <span class="kt-menu-title text-2sm text-foreground kt-menu-item-active:text-primary kt-menu-item-active:font-medium kt-menu-link-hover:!text-primary me-1 font-normal">
        Reset Password
        </span>
        <span class="kt-menu-arrow text-muted-foreground ms-1 me-[-10px] w-[20px] shrink-0 justify-end">
        <span class="kt-menu-item-show:hidden inline-flex">
        <i class="ki-duotone ki-plus text-[11px]"></i>
        </span>
        <span class="kt-menu-item-show:inline-flex hidden">
        <i class="ki-duotone ki-minus text-[11px]"></i>
        </span>
        </span>
        </div>
        <div class="kt-menu-accordion before:border-border relative gap-1 ps-[22px] before:absolute before:start-[32px] before:top-0 before:bottom-0 before:border-s">
        <div class="kt-menu-item">
        <a
        class="kt-menu-link kt-menu-item-active:bg-accent/60 dark:menu-item-active:border-border kt-menu-item-active:rounded-lg hover:bg-accent/60 grow items-center gap-[5px] border border-transparent py-[8px] ps-[10px] pe-[10px] hover:rounded-lg"
        href="#"
        tabindex="0"
        >
        <span
        class="kt-menu-bullet kt-menu-item-active:before:bg-primary kt-menu-item-hover:before:bg-primary relative -start-[3px] flex w-[6px] before:absolute before:top-0 before:size-[6px] before:-translate-y-1/2 before:rounded-full rtl:start-0 rtl:before:translate-x-1/2"
        ></span>
        <span
        class="kt-menu-title text-2sm text-foreground kt-menu-item-active:text-primary kt-menu-item-active:font-semibold kt-menu-link-hover:!text-primary font-normal"
        >
        Enter Email
        </span>
        </a>
        </div>
        <div class="kt-menu-item">
        <a
        class="kt-menu-link kt-menu-item-active:bg-accent/60 dark:menu-item-active:border-border kt-menu-item-active:rounded-lg hover:bg-accent/60 grow items-center gap-[5px] border border-transparent py-[8px] ps-[10px] pe-[10px] hover:rounded-lg"
        href="#"
        tabindex="0"
        >
        <span
        class="kt-menu-bullet kt-menu-item-active:before:bg-primary kt-menu-item-hover:before:bg-primary relative -start-[3px] flex w-[6px] before:absolute before:top-0 before:size-[6px] before:-translate-y-1/2 before:rounded-full rtl:start-0 rtl:before:translate-x-1/2"
        ></span>
        <span
        class="kt-menu-title text-2sm text-foreground kt-menu-item-active:text-primary kt-menu-item-active:font-semibold kt-menu-link-hover:!text-primary font-normal"
        >
        Check Email
        </span>
        </a>
        </div>
        <div class="kt-menu-item">
        <a
        class="kt-menu-link kt-menu-item-active:bg-accent/60 dark:menu-item-active:border-border kt-menu-item-active:rounded-lg hover:bg-accent/60 grow items-center gap-[5px] border border-transparent py-[8px] ps-[10px] pe-[10px] hover:rounded-lg"
        href="#"
        tabindex="0"
        >
        <span
        class="kt-menu-bullet kt-menu-item-active:before:bg-primary kt-menu-item-hover:before:bg-primary relative -start-[3px] flex w-[6px] before:absolute before:top-0 before:size-[6px] before:-translate-y-1/2 before:rounded-full rtl:start-0 rtl:before:translate-x-1/2"
        ></span>
        <span
        class="kt-menu-title text-2sm text-foreground kt-menu-item-active:text-primary kt-menu-item-active:font-semibold kt-menu-link-hover:!text-primary font-normal"
        >
        Change Password
        </span>
        </a>
        </div>
        <div class="kt-menu-item">
        <a
        class="kt-menu-link kt-menu-item-active:bg-accent/60 dark:menu-item-active:border-border kt-menu-item-active:rounded-lg hover:bg-accent/60 grow items-center gap-[5px] border border-transparent py-[8px] ps-[10px] pe-[10px] hover:rounded-lg"
        href="#"
        tabindex="0"
        >
        <span
        class="kt-menu-bullet kt-menu-item-active:before:bg-primary kt-menu-item-hover:before:bg-primary relative -start-[3px] flex w-[6px] before:absolute before:top-0 before:size-[6px] before:-translate-y-1/2 before:rounded-full rtl:start-0 rtl:before:translate-x-1/2"
        ></span>
        <span
        class="kt-menu-title text-2sm text-foreground kt-menu-item-active:text-primary kt-menu-item-active:font-semibold kt-menu-link-hover:!text-primary font-normal"
        >
        Password is Changed
        </span>
        </a>
        </div>
        </div>
        </div>
        </div>
        </div>
        <div class="kt-menu-item">
        <a
        class="kt-menu-link kt-menu-item-active:bg-accent/60 dark:menu-item-active:border-border kt-menu-item-active:rounded-lg hover:bg-accent/60 grow items-center gap-[14px] border border-transparent py-[8px] ps-[10px] pe-[10px] hover:rounded-lg"
        href="#"
        tabindex="0"
        >
        <span
        class="kt-menu-bullet kt-menu-item-active:before:bg-primary kt-menu-item-hover:before:bg-primary relative -start-[3px] flex w-[6px] before:absolute before:top-0 before:size-[6px] before:-translate-y-1/2 before:rounded-full rtl:start-0 rtl:before:translate-x-1/2"
        ></span>
        <span class="kt-menu-title text-2sm text-foreground kt-menu-item-active:text-primary kt-menu-item-active:font-semibold kt-menu-link-hover:!text-primary font-normal">
        Welcome Message
        </span>
        </a>
        </div>
        <div class="kt-menu-item">
        <a
        class="kt-menu-link kt-menu-item-active:bg-accent/60 dark:menu-item-active:border-border kt-menu-item-active:rounded-lg hover:bg-accent/60 grow items-center gap-[14px] border border-transparent py-[8px] ps-[10px] pe-[10px] hover:rounded-lg"
        href="#"
        tabindex="0"
        >
        <span
        class="kt-menu-bullet kt-menu-item-active:before:bg-primary kt-menu-item-hover:before:bg-primary relative -start-[3px] flex w-[6px] before:absolute before:top-0 before:size-[6px] before:-translate-y-1/2 before:rounded-full rtl:start-0 rtl:before:translate-x-1/2"
        ></span>
        <span class="kt-menu-title text-2sm text-foreground kt-menu-item-active:text-primary kt-menu-item-active:font-semibold kt-menu-link-hover:!text-primary font-normal">
        Account Deactivated
        </span>
        </a>
        </div>
        <div class="kt-menu-item">
        <a
        class="kt-menu-link kt-menu-item-active:bg-accent/60 dark:menu-item-active:border-border kt-menu-item-active:rounded-lg hover:bg-accent/60 grow items-center gap-[14px] border border-transparent py-[8px] ps-[10px] pe-[10px] hover:rounded-lg"
        href="#"
        tabindex="0"
        >
        <span
        class="kt-menu-bullet kt-menu-item-active:before:bg-primary kt-menu-item-hover:before:bg-primary relative -start-[3px] flex w-[6px] before:absolute before:top-0 before:size-[6px] before:-translate-y-1/2 before:rounded-full rtl:start-0 rtl:before:translate-x-1/2"
        ></span>
        <span class="kt-menu-title text-2sm text-foreground kt-menu-item-active:text-primary kt-menu-item-active:font-semibold kt-menu-link-hover:!text-primary font-normal">
        Error 404
        </span>
        </a>
        </div>
        <div class="kt-menu-item">
        <a
        class="kt-menu-link kt-menu-item-active:bg-accent/60 dark:menu-item-active:border-border kt-menu-item-active:rounded-lg hover:bg-accent/60 grow items-center gap-[14px] border border-transparent py-[8px] ps-[10px] pe-[10px] hover:rounded-lg"
        href="#"
        tabindex="0"
        >
        <span
        class="kt-menu-bullet kt-menu-item-active:before:bg-primary kt-menu-item-hover:before:bg-primary relative -start-[3px] flex w-[6px] before:absolute before:top-0 before:size-[6px] before:-translate-y-1/2 before:rounded-full rtl:start-0 rtl:before:translate-x-1/2"
        ></span>
        <span class="kt-menu-title text-2sm text-foreground kt-menu-item-active:text-primary kt-menu-item-active:font-semibold kt-menu-link-hover:!text-primary font-normal">
        Error 500
        </span>
        </a>
        </div>
        </div>
        </div>
        </div>
    --}}
</div>
<!-- End of Sidebar Menu -->
