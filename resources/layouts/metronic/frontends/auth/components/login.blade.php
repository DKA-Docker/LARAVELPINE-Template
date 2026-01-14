<div class="flex items-center justify-center grow bg-center bg-no-repeat page-bg">
    <div class="kt-card max-w-[450px] w-full">
        <form
            wire:submit.prevent="store"
            id="sign_in_form"
            class="kt-card-content flex flex-col gap-5 p-10"
        >
            <div class="text-center mb-2.5">
                <h1 class="text-lg mb-2.5">
                    {{ config('app.name', 'Laravel') }}
                </h1>
                <h3 class="text-lg font-medium text-mono leading-none mb-2.5">
                    Masuk Untuk Menggunakan Layanan
                </h3>
            </div>

            <div class="grid grid-cols-2 gap-2.5">
                <a class="kt-btn kt-btn-outline justify-center" href="#">
                    <img alt="" class="size-3.5 shrink-0" src="{{ asset(Storage::url('media/brand-logos/google.svg')) }}"/>
                    Use Google
                </a>
                <a class="kt-btn kt-btn-outline justify-center" href="#">
                    <img alt="" class="size-3.5 shrink-0 dark:hidden" src="{{ asset(Storage::url('media/brand-logos/apple-black.svg')) }}"/>
                    <img alt="" class="size-3.5 shrink-0 light:hidden" src="{{ asset(Storage::url('media/brand-logos/apple-white.svg')) }}"/>
                    Use Apple
                </a>
            </div>

            <div class="flex items-center gap-2">
                <span class="border-t border-border w-full"></span>
                <span class="text-xs text-muted-foreground font-medium uppercase">Or</span>
                <span class="border-t border-border w-full"></span>

            </div>

            <div class="items-center text-center w-full">
                @error('errors')
                <p class="text-lg text-red-500">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex flex-col gap-1">
                <label class="kt-form-label font-normal text-mono">
                    Nama Pengguna
                </label>
                <input
                    type="text"
                    class="kt-input"
                    name="username"
                    placeholder="xxxxxxxx"
                    wire:model.defer="username"
                />
            </div>

            <div class="flex flex-col gap-1">
                <div class="flex items-center justify-between gap-1">
                    <label class="kt-form-label font-normal text-mono">
                        Kata Sandi
                    </label>
                    <a class="text-sm kt-link shrink-0" href="{{ route('auth.forgot-password') }}">
                        Lupa kata Sandi?
                    </a>
                </div>
                <div class="kt-input" data-kt-toggle-password="true">
                    <input
                        type="password"
                        placeholder="Enter Password"
                        name="password"
                        wire:model.defer="password"
                    />
                    <button
                        type="button"
                        class="kt-btn kt-btn-sm kt-btn-ghost kt-btn-icon bg-transparent! -me-1.5"
                        data-kt-toggle-password-trigger="true"
                    >
                        <span class="kt-toggle-password-active:hidden">
                            <i class="ki-filled ki-eye text-muted-foreground"></i>
                        </span>
                        <span class="hidden kt-toggle-password-active:block">
                            <i class="ki-filled ki-eye-slash text-muted-foreground"></i>
                        </span>
                    </button>
                </div>
                @error('password')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <label class="kt-label">
                <input
                    type="checkbox"
                    class="kt-checkbox kt-checkbox-sm"
                    wire:model="remember"
                    value="1"
                />
                <span class="kt-checkbox-label">Remember me</span>
            </label>

            <div class="flex items-end justify-end font-medium">
                <a class="text-sm link" href="{{ route('auth.register') }}">
                    Daftar Sekarang
                </a>
            </div>

            <button type="submit" class="kt-btn kt-btn-primary flex justify-center grow">
                Masuk
            </button>
        </form>
    </div>
</div>
