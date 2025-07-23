<x-Dashboard.Pages.MainContent :theme="$theme" :session="$session">
    <x-Dashboard.Partial.Breadcrumb theme="{{ $theme }}">
    </x-Dashboard.Partial.Breadcrumb>
    <div class="row">
        <div class="col">
            <h6 class="mb-0 text-uppercase">Primary Nav Pills</h6>
            <hr>
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-pills mb-3" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" data-bs-toggle="pill" href="#primary-pills-home" role="tab" aria-selected="true">
                                <div class="d-flex align-items-center">
                                    <div class="tab-icon"><i class="bi bi-house-door me-1 fs-6"></i>
                                    </div>
                                    <div class="tab-title">Data Akun</div>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" data-bs-toggle="pill" href="#primary-pills-profile" role="tab" aria-selected="false">
                                <div class="d-flex align-items-center">
                                    <div class="tab-icon"><i class="bi bi-person me-1 fs-6"></i>
                                    </div>
                                    <div class="tab-title">Data Login</div>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" data-bs-toggle="pill" href="#primary-pills-contact" role="tab" aria-selected="false">
                                <div class="d-flex align-items-center">
                                    <div class="tab-icon"><i class='bi bi-headset me-1 fs-6'></i>
                                    </div>
                                    <div class="tab-title">Data Kontak</div>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" data-bs-toggle="pill" href="#primary-pills-permission" role="tab" aria-selected="false">
                                <div class="d-flex align-items-center">
                                    <div class="tab-icon"><i class='bi bi-headset me-1 fs-6'></i>
                                    </div>
                                    <div class="tab-title">Data Permission</div>
                                </div>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="primary-pills-home" role="tabpanel">
                            <div class="row mb-3 p-6">
                                <h5 class="mt-2">Informasi Akun</h5>
                                <div class="col-sm-6">
                                    <label for="first_name" class="col-sm-3 col-form-label">First Name</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="material-icons-outlined fs-5">person</i></span>
                                        <input type="text" required name="first_name" class="form-control" id="first_name" placeholder="Your Name">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label for="last_name" class="col-sm-3 col-form-label">Last Name</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="material-icons-outlined fs-5">person</i></span>
                                        <input type="text" name="last_name" class="form-control" id="last_name" placeholder="Your Name">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="primary-pills-profile" role="tabpanel">
                            <div class="row mb-3 p-6">
                                <h5 class="mt-2">Informasi Login</h5>
                                <div class="col-sm-12">
                                    <label for="username" class="col-sm-3 col-form-label">Username</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="material-icons-outlined fs-5">person</i></span>
                                        <input type="text" required name="username" class="form-control" id="username" placeholder="Your Name">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label for="password" class="col-sm-3 col-form-label">Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="material-icons-outlined fs-5">lock</i></span>
                                        <input type="password" name="password" class="form-control" id="password" placeholder="Your Name">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label for="confirm_password" class="col-sm-3 col-form-label">Password Konfirmasi</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="material-icons-outlined fs-5">lock</i></span>
                                        <input type="password" name="confirm_password" class="form-control" id="confirm_password" placeholder="Your Name">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="primary-pills-contact" role="tabpanel">
                            <div class="row mb-3 p-6">
                                <h5 class="mt-2">Informasi Kontak</h5>
                                <div class="col-sm-12">
                                    <label for="email" class="col-sm-3 col-form-label">Email</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="material-icons-outlined fs-5">email</i></span>
                                        <input type="email" required name="email" class="form-control" id="email" placeholder="Your Name">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="primary-pills-permission" role="tabpanel">

                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-9 col-form-label"></label>
                        <div class="col-sm-3 p-6">
                            <div class="d-md-flex d-grid gap-3 justify-content-md-end">
                                <button type="button" class="btn btn-grd-primary px-4">Buat</button>
                                <button type="button" class="btn btn-grd-royal px-4">Batal</button>
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
