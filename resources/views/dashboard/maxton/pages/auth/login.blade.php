<x-Dashboard.PageContainer theme="{{$theme}}">
    <!--authentication-->
    <div class="auth-basic-wrapper d-flex align-items-center justify-content-center">
        <div class="container-fluid my-5 my-lg-0">
            <div class="row">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5 col-xxl-4 mx-auto">
                    <div class="card rounded-4 mb-0 border-top border-4 border-primary border-gradient-1">
                        <div class="card-body p-5">
                            <img src="{{ asset('storage/images/logo1.png') }}" class="mb-4" width="145" alt="">
                            <h4 class="fw-bold">{{ env("APP_NAME", "Laravel") }}</h4>
                            <p class="mb-0">Enter your credentials to login your account</p>

                            <div class="form-body my-5">
                                <form class="row g-3" action="{{ route('login') }}" method="POST">
                                    @csrf
                                    <div class="col-12">
                                        <label for="inputEmailAddress" class="form-label">Username</label>
                                        <input type="text" name="username" class="form-control" id="inputEmailAddress" placeholder="Kartono, Herlambang. etc">
                                    </div>
                                    <div class="col-12">
                                        <label for="inputChoosePassword" class="form-label">Password</label>
                                        <div class="input-group" id="show_hide_password">
                                            <input type="password" name="password" class="form-control border-end-0" id="inputChoosePassword" placeholder="Enter Password">
                                            <a href="javascript:void(0);" class="input-group-text bg-transparent"><i class="bi bi-eye-slash-fill"></i></a>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked">
                                            <label class="form-check-label" for="flexSwitchCheckChecked">Remember Me</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 text-end">	<a href="{{ Route::has("forget") ? route("forget") : 'javascript:void(0);' }}">Forgot Password ?</a>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-grid">
                                            <button type="submit"  class="btn btn-grd-primary">Validasi</button>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="text-start">
                                            <p class="mb-0">Don't have an account yet? <a href="{{ Route::has("register") ? route("register") : 'javascript:void(0);' }}">Sign up here</a>
                                            </p>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div><!--end row-->
        </div>
    </div>
    <!--authentication-->
</x-Dashboard.PageContainer>
