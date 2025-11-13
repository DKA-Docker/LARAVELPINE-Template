<!-- Sidebar -->
<div
    class="kt-sidebar bg-background border-e-border fixed top-0 bottom-0 z-20 hidden shrink-0 flex-col items-stretch border-e [--kt-drawer-enable:true] lg:flex lg:[--kt-drawer-enable:false]"
    data-kt-drawer="true"
    data-kt-drawer-class="kt-drawer kt-drawer-start top-0 bottom-0"
    id="sidebar"
>
    <div class="kt-sidebar-header relative hidden shrink-0 items-center justify-between px-3 lg:flex lg:px-6" id="sidebar_header">
        <a class="dark:block" href="#">
            <img class="default-logo min-h-[22px] max-w-none" src="{{ asset(Storage::url("media/app/default-logo.svg")) }}" alt="" />
            <img class="small-logo min-h-[22px] max-w-none" src="{{ asset(Storage::url("media/app/mini-logo.svg")) }}" alt="" />
        </a>
        <a class="hidden dark:hidden" href="#">
            <img class="default-logo min-h-[22px] max-w-none" src="{{ asset(Storage::url("media/app/default-logo-dark.svg")) }}" alt="" />
            <img class="small-logo min-h-[22px] max-w-none" src="{{ asset(Storage::url("media/app/mini-logo.svg")) }}" alt="" />
        </a>
        <button
            class="kt-btn kt-btn-outline kt-btn-icon absolute start-full top-2/4 size-[30px] -translate-x-2/4 -translate-y-2/4 rtl:translate-x-2/4"
            data-kt-toggle="body"
            data-kt-toggle-class="kt-sidebar-collapse"
            id="sidebar_toggle"
        >
            <i class="ki-filled ki-black-left-line kt-toggle-active:rotate-180 rtl:translate rtl:kt-toggle-active:rotate-0 transition-all duration-300 rtl:rotate-180"></i>
        </button>
    </div>
    <div class="kt-sidebar-content flex shrink-0 grow py-5 pe-2" id="sidebar_content">
        <div
            class="kt-scrollable-y-hover flex shrink-0 grow ps-2 pe-1 lg:ps-5 lg:pe-3"
            data-kt-scrollable="true"
            data-kt-scrollable-dependencies="#sidebar_header"
            data-kt-scrollable-height="auto"
            data-kt-scrollable-offset="0px"
            data-kt-scrollable-wrappers="#sidebar_content"
            id="sidebar_scrollable"
        >
            @livewire("metronic.layouts.constructors.components.menu")
        </div>
    </div>
</div>
<!-- End of Sidebar -->
