<x-Dashboard.Pages.MainContent :theme="$theme" :session="$session">
    <h6 class="mb-0 text-uppercase">DataTable Import</h6>
    <hr>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered h-100" style="width:100%;" >
                    <thead>
                    <tr>
                        <th>Nama Lengkap</th>
                        <th>Email</th>
                        <th>Status</th>
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
