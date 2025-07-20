<x-Dashboard.PageContainer :theme="$theme" :session="$session">
    <x-Dashboard.Partial.Header :theme="$theme" :session="$session">
    </x-Dashboard.Partial.Header>
    <x-Dashboard.Partial.Sidebar :theme="$theme" :session="$session">
    </x-Dashboard.Partial.Sidebar>
    <!--start main wrapper-->
    <main class="main-wrapper">
        <div class="main-content">
            <x-Dashboard.Partial.Breadcrumb theme="{{ $theme }}">
            </x-Dashboard.Partial.Breadcrumb>
            {{ $slot }}
        </div>
    </main>
    <!--end main wrapper-->
    <!--start overlay-->
    <div class="overlay btn-toggle"></div>
    <!--end overlay-->
    <x-Dashboard.Partial.Footer theme="{{ $theme }}">
    </x-Dashboard.Partial.Footer>
    <x-Dashboard.Partial.Switcher theme="{{ $theme }}">
    </x-Dashboard.Partial.Switcher>
</x-Dashboard.PageContainer>
