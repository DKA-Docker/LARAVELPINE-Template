<x-metronic.frontends.layouts.container>
    <body class="antialiased flex h-full text-base text-foreground bg-background">
    <!-- Theme Mode -->
    <script>
        const defaultThemeMode = 'light'; // light|dark|system
        let themeMode;

        if (document.documentElement) {
            if (localStorage.getItem('kt-theme')) {
                themeMode = localStorage.getItem('kt-theme');
            } else if (
                document.documentElement.hasAttribute('data-kt-theme-mode')
            ) {
                themeMode =
                    document.documentElement.getAttribute('data-kt-theme-mode');
            } else {
                themeMode = defaultThemeMode;
            }

            if (themeMode === 'system') {
                themeMode = window.matchMedia('(prefers-color-scheme: dark)').matches
                    ? 'dark'
                    : 'light';
            }

            document.documentElement.classList.add(themeMode);
        }
    </script>
    <!-- End of Theme Mode -->
    <!-- Page -->
    <style>
        .page-bg {
            background-image: url({{ asset(Storage::url("media/images/2600x1200/bg-10.png")) }});
        }
        .dark .page-bg {
            background-image: url({{ asset(Storage::url("media/images/2600x1200/bg-10-dark.png")) }});
        }
    </style>
    <div class="flex items-center justify-center grow bg-center bg-no-repeat page-bg">
        <div class="kt-card max-w-[370px] w-full">
            <form action="#" class="kt-card-content flex flex-col gap-5 p-10" id="sign_in_form" method="get">
                <div class="text-center mb-2.5">
                    <h3 class="text-lg font-medium text-mono leading-none mb-2.5">
                        Masuk Untuk Menggunakan Layanan
                    </h3>
                </div>
                <div class="grid grid-cols-2 gap-2.5">
                    <a class="kt-btn kt-btn-outline justify-center" href="#">
                        <img alt="" class="size-3.5 shrink-0" src="{{ asset(Storage::url("media/brand-logos/google.svg")) }}"/>
                        Use Google
                    </a>
                    <a class="kt-btn kt-btn-outline justify-center" href="#">
                        <img alt="" class="size-3.5 shrink-0 dark:hidden" src="{{ asset(Storage::url("media/brand-logos/apple-black.svg")) }}"/>
                        <img alt="" class="size-3.5 shrink-0 light:hidden" src="{{ asset(Storage::url("media/brand-logos/apple-white.svg")) }}"/>
                        Use Apple
                    </a>
                </div>
                <div class="flex items-center gap-2">
      <span class="border-t border-border w-full">
      </span>
                    <span class="text-xs text-muted-foreground font-medium uppercase">
       Or
      </span>
                    <span class="border-t border-border w-full">
      </span>
                </div>
                <div class="flex flex-col gap-1">
                    <label class="kt-form-label font-normal text-mono">
                        Email
                    </label>
                    <input class="kt-input" placeholder="email@email.com" type="text" value=""/>
                </div>
                <div class="flex flex-col gap-1">
                    <div class="flex items-center justify-between gap-1">
                        <label class="kt-form-label font-normal text-mono">
                            Password
                        </label>
                        <a class="text-sm kt-link shrink-0" href="#">
                            Forgot Password?
                        </a>
                    </div>
                    <div class="kt-input" data-kt-toggle-password="true">
                        <input name="user_password" placeholder="Enter Password" type="password" value=""/>
                        <button class="kt-btn kt-btn-sm kt-btn-ghost kt-btn-icon bg-transparent! -me-1.5" data-kt-toggle-password-trigger="true" type="button">
        <span class="kt-toggle-password-active:hidden">
         <i class="ki-filled ki-eye text-muted-foreground">
         </i>
        </span>
                            <span class="hidden kt-toggle-password-active:block">
         <i class="ki-filled ki-eye-slash text-muted-foreground">
         </i>
        </span>
                        </button>
                    </div>
                </div>
                <label class="kt-label">
                    <input class="kt-checkbox kt-checkbox-sm" name="check" type="checkbox" value="1"/>
                    <span class="kt-checkbox-label">
       Remember me
      </span>
                </label>
                <div class="flex items-end justify-end font-medium">
                    <a class="text-sm link" href="html/demo1/authentication/classic/sign-up.html">
                        Daftar Sekarang
                    </a>
                </div>
                <button class="kt-btn kt-btn-primary flex justify-center grow">
                    Sign In
                </button>
            </form>
        </div>
    </div>
    <!-- End of Page -->
    <!-- Scripts -->
    <!-- End of Scripts -->
    </body>
</x-metronic.frontends.layouts.container>
