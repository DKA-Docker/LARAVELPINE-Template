<x-Dashboard.Pages.MainContent :theme="$theme" :session="$session">
    <x-Dashboard.Partial.Breadcrumb theme="{{ $theme }}">
    </x-Dashboard.Partial.Breadcrumb>
    <a class="btn btn-grd-primary mb-3" href="{{ route(Str::beforeLast(Route::currentRouteName(), '.').".create") }}">Buat Akun Baru</a>
    <div class="card">
        @if (session('message'))
            <div class="alert alert-success timeout-msg m-3">
                {{ session('message') }}
            </div>
        @endif
        <div class="card-body">
            <div class="table-responsive p-3">
                <table id="example" class="table table-striped table-bordered" style="width:100%" >
                    <thead>
                    <tr>
                        <th>Nama Lengkap</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Level Akses</th>
                        <th>Waktu Dibuat</th>
                        <th class="action">Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(["resources/js/".$theme."/pages/settings/managements/accounts.js"])
    @endif
</x-Dashboard.Pages.MainContent>
