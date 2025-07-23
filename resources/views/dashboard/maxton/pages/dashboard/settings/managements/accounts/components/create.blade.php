<x-Dashboard.Pages.MainContent :theme="$theme" :session="$session">
    <x-Dashboard.Partial.Breadcrumb theme="{{ $theme }}">
    </x-Dashboard.Partial.Breadcrumb>
    <div class="row">
        <div class="col-12 col-lg-12">
            <div class="card">
                <div class="card-body p-4">
                    <h5 class="mb-4">Horizontal Addon</h5>
                    <div class="row mb-3">
                        <label for="input49" class="col-sm-3 col-form-label">Enter Your Name</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <span class="input-group-text"><i class="material-icons-outlined fs-5">vpn_key</i></span>
                                <input type="text" class="form-control" id="input49" placeholder="Your Name">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="input50" class="col-sm-3 col-form-label">Phone No</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <span class="input-group-text"><i class="material-icons-outlined fs-5">smartphone</i></span>
                                <input type="text" class="form-control" id="input50" placeholder="Phone No">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="input51" class="col-sm-3 col-form-label">Email Address</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <span class="input-group-text"><i class="material-icons-outlined fs-5">drafts</i></span>
                                <input type="text" class="form-control" id="input51" placeholder="Email">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="input52" class="col-sm-3 col-form-label">Choose Password</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <span class="input-group-text"><i class="material-icons-outlined fs-5">vpn_key</i></span>
                                <input type="text" class="form-control" id="input52" placeholder="Choose Password">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="input53" class="col-sm-3 col-form-label">Select Country</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <span class="input-group-text"><i class="material-icons-outlined fs-5">format_list_bulleted</i></span>
                                <select class="form-select" id="input53">
                                    <option selected="">Open this select menu</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label"></label>
                        <div class="col-sm-9">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="input54">
                                <label class="form-check-label" for="input54">Check me out</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-3 col-form-label"></label>
                        <div class="col-sm-9">
                            <div class="d-md-flex d-grid align-items-center gap-3">
                                <button type="button" class="btn btn-grd-primary px-4">Submit</button>
                                <button type="button" class="btn btn-grd-royal px-4">Reset</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(["resources/js/".$theme."/pages/settings/managements/accounts.js"])
    @endif
</x-Dashboard.Pages.MainContent>
