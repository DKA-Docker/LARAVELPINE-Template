<x-default-layout>
    @section('title')
        {{ __('menu.session') }}
    @endsection

    @section('breadcrumbs')
        {{-- Breadcrumbs::render('dashboards.apps.deliveries.sessions.index') --}}
    @endsection

    <livewire:metronic.dashboards.apps.deliveries.sessions.index />

</x-default-layout>
