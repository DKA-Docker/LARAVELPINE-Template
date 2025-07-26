<x-Dashboard.Pages.MainContent :theme="$theme" :session="$session">
    <x-Dashboard.Partial.Breadcrumb theme="{{ $theme }}">
    </x-Dashboard.Partial.Breadcrumb>
    <div class="row">
        <div class="col">
            <form method="POST" autocomplete="off" action="{{ route(Str::beforeLast(Route::currentRouteName(), '.').".update", $account->id) }}">
                @csrf
                @method('PATCH')
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
                                            <input type="text" name="information[first_name]" id="first_name" placeholder="First Name" class="form-control @error('information.first_name') is-invalid @enderror" value="{{ old('information.first_name') ?? $account->information->first_name }}">
                                            @error('information.first_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="last_name" class="col-sm-3 col-form-label">Last Name</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="material-icons-outlined fs-5">person</i></span>
                                            <input type="text" name="information[last_name]" class="form-control" id="last_name" placeholder="Your Name" value="{{ $account->information->last_name}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3 p-2">
                                    <h5 class="mt-2">Informasi Login</h5>
                                    <div class="col-sm-12">
                                        <label for="username" class="col-sm-3 col-form-label">Username</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="material-icons-outlined fs-5">person</i></span>
                                            <input autocomplete="nope" type="text" name="credential[username]" id="username" placeholder="username" class="form-control @error('credential.username') is-invalid @enderror" value="{{ old('credential.username') ?? $account->credential->username }}">
                                            @error('credential.username')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-6 password">
                                        <label for="new_password" class="col-sm-3 col-form-label">Password baru</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="material-icons-outlined fs-5">lock</i></span>
                                            <input autocomplete="off" type="password" name="credential[new_password]" id="new_password" placeholder="Your Password" class="form-control @error('credential.new_password') is-invalid @enderror" value="{{ old('credential.new_password') }}">
                                            <button class="btn btn-outline-secondary toggle-password" type="button"  tabindex="-1">
                                                <i class="material-icons-outlined">visibility_off</i>
                                            </button>
                                            @error('credential.new_password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="progress mb-0" style="height:5px;">
                                            <div class="progress-bar bg-grd-info" role="progressbar" style="width: 2%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <!-- Bootstrap helper text -->
                                        <div class="form-text password-strength-label bold">Masukkan password Anda.</div>
                                    </div>
                                    <div class="col-sm-6 password">
                                        <label for="old_password" class="col-sm-3 col-form-label">Password Saat Ini</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="material-icons-outlined fs-5">lock</i></span>
                                            <input autocomplete="new-password" disabled type="password" name="credential[old_password]" id="old_password" placeholder="Password Saat ini" class="form-control @error('credential.old_password') is-invalid @enderror" value="{{ old('credential.old_password') }}" >
                                            <button class="btn btn-outline-secondary toggle-password"  tabindex="-1" type="button">
                                                <i class="material-icons-outlined">visibility_off</i>
                                            </button>
                                            @error('credential.old_password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <!-- Bootstrap helper text -->
                                        <div class="form-text password-strength-label bold">Harap Isi Password baru anda.</div>
                                    </div>
                                </div>
                                <div class="row mb-3 p-2">
                                    <h5 class="mt-2">Informasi Kontak</h5>
                                    <div class="col-sm-12">
                                        <label for="email" class="col-sm-3 col-form-label">Email</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="material-icons-outlined fs-5">email</i></span>
                                            <input type="email" name="contact[email]" id="email" placeholder="Your Name" class="form-control @error('credential.password_confirmation') is-invalid @enderror" value="{{ old('credential.password_confirmation') ?? $account->contact->email }}">
                                            @error('contact.email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="primary-pills-profile" role="tabpanel"></div>
                            <div class="tab-pane fade" id="primary-pills-contact" role="tabpanel"></div>
                            <div class="tab-pane fade" id="primary-pills-permission" role="tabpanel"></div>
                        </div>
                        <div class="row">
                            <label class="col-sm-9 col-form-label"></label>
                            <div class="col-sm-3 p-6">
                                <div class="d-md-flex d-grid gap-3 justify-content-md-end">
                                    <button type="submit" class="btn btn-grd-primary px-4">Update</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(["resources/js/".$theme."/pages/settings/managements/components/edit.js"])
    @endif
</x-Dashboard.Pages.MainContent>
