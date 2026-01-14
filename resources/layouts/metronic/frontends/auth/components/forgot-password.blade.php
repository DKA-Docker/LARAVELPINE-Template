<div class="flex items-center justify-center grow bg-center bg-no-repeat page-bg">
    <div class="kt-card max-w-[450px] w-full">
        <form
            class="kt-card-content flex flex-col gap-5 p-10"
            wire:submit.prevent="submit"
        >
            <div class="text-center mb-2.5">
                <h1 class="text-lg mb-2.5">
                    Lupa Kata Sandi ?
                </h1>
                <div class="text-gray-500 fw-semibold fs-6">
                    Masukkan email Anda untuk mereset kata sandi.
                </div>
            </div>

            @if (session()->has('success'))
                <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                    <ul class="mb-0 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="flex flex-col gap-1">
                <label class="kt-form-label font-normal text-mono">
                    Email
                </label>
                <input
                    type="text"
                    class="kt-input"
                    name="email"
                    placeholder="Email Address"
                    wire:model="email"
                    autocomplete="off"
                />
            </div>

            <div class="flex flex-wrap justify-center gap-2 pb-lg-0">
                 <button type="submit" class="kt-btn kt-btn-primary flex justify-center grow">
                    <span class="indicator-label" wire:loading.remove>Submit</span>
                    <span class="indicator-progress" wire:loading>Please wait...</span>
                </button>
                <a href="{{ route('auth.index') }}" class="kt-btn kt-btn-light flex justify-center grow">Cancel</a>
            </div>
        </form>
    </div>
</div>
