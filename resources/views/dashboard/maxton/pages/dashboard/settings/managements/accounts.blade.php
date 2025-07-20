<x-Dashboard.Pages.MainContent :theme="$theme" :session="$session">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive" style="height: 600px;">
                <table id="example" class="table table-striped table-bordereds mb-0">
                    <thead class="table-dark sticky-top">
                    <tr>
                        <th>Nama Lengkap</th>
                        <th>Email</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    <!-- Data -->
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>Nama Lengkap</th>
                        <th>Email</th>
                        <th>Status</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(["resources/js/maxton/pages/settings/managements/accounts.js"])
    @endif
</x-Dashboard.Pages.MainContent>
