<x-Dashboard.Pages.MainContent :theme="$theme" :session="$session">
    <x-Dashboard.Partial.Breadcrumb theme="{{ $theme }}">
    </x-Dashboard.Partial.Breadcrumb>
    <div class="row">
        <div class="col">
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
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="primary-pills-home" role="tabpanel">
                            <div class="row mb-3 p-2">
                                <h5 class="mt-2">Informasi Akun</h5>
                                <div class="col-sm-6">
                                    <label for="first_name" class="col-sm-3 col-form-label">First Name</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="material-icons-outlined fs-5">person</i></span>
                                        <input type="text" name="information[first_name]" readonly id="first_name" placeholder="First Name" class="form-control @error('information.first_name') is-invalid @enderror" value="{{ old('information.first_name') ?? $account->information->first_name }}">
                                        @error('information.first_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label for="last_name" class="col-sm-3 col-form-label">Last Name</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="material-icons-outlined fs-5">person</i></span>
                                        <input type="text" name="information[last_name]" readonly class="form-control" id="last_name" placeholder="Your Name" value="{{ old('information.last_name') ?? $account->information->last_name }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3 p-2">
                                <h5 class="mt-2">Informasi Login</h5>
                                <div class="col-sm-12">
                                    <label for="username" class="col-sm-3 col-form-label">Username</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="material-icons-outlined fs-5">person</i></span>
                                        <input type="text" name="credential[username]" readonly id="username" placeholder="username" class="form-control @error('credential.username') is-invalid @enderror" value="{{ old('credential.username') ?? $account->credential->username }}">
                                        @error('credential.username')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3 p-2">
                                <h5 class="mt-2">Informasi Kontak</h5>
                                <div class="col-sm-12">
                                    <label for="email" class="col-sm-3 col-form-label">Email</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="material-icons-outlined fs-5">email</i></span>
                                        <input type="email" name="contact[email]" id="email" readonly placeholder="Your Name" class="form-control @error('contact.email') is-invalid @enderror" value="{{ old('contact.email') ?? $account->contact->email }}">
                                        @error('contact.email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3 p-2">
                                <h5 class="mt-2">Izin Akses</h5>
                                <div class="col-sm-6">
                                    <label for="select-permission" class="form-label">Pilih Permission</label>
                                    <select class="form-select" id="select-permission" data-placeholder="Pilih Izin" readonly>
                                        <option></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="primary-pills-profile" role="tabpanel"></div>
                        <div class="tab-pane fade" id="primary-pills-contact" role="tabpanel"></div>
                        <div class="tab-pane fade" id="primary-pills-permission" role="tabpanel"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(["resources/js/".$theme."/pages/settings/managements/components/create.js"])
    @endif
</x-Dashboard.Pages.MainContent>
