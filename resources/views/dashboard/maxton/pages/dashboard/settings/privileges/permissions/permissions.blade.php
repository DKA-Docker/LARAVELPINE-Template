@php use Illuminate\Support\Facades\Route; @endphp
<x-Dashboard.Pages.MainContent :theme="$theme" :session="$session">
    <x-Dashboard.Partial.Breadcrumb theme="{{ $theme }}">
    </x-Dashboard.Partial.Breadcrumb>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive p-3">
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                    <tr>
                        <th>Nama Permission</th>
                        <th>Tipe Permission</th>
                        <th>Tanggal Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(["resources/js/".$theme."/pages/settings/privileges/permissions.js"])
    @endif
</x-Dashboard.Pages.MainContent>
