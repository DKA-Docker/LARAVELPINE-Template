<div class="flex items-center justify-center grow bg-center bg-no-repeat page-bg">
    <div class="kt-card max-w-[500px] w-full">
        <form wire:submit.prevent="store" class="kt-card-content flex flex-col gap-5 p-10">
            <div class="text-center mb-2.5">
                <h1 class="text-lg mb-2.5">
                    {{ config('app.name', 'Laravel') }}
                </h1>
                <h3 class="text-lg font-medium text-mono leading-none mb-2.5">
                    Pendaftaran Akun Baru
                </h3>
                <div class="text-sm text-gray-500">
                    Step {{ $currentStep }} of 3
                </div>
            </div>

            <!-- Stepper Indicators -->
            <div class="flex justify-center gap-2 mb-4">
                @foreach(range(1, 3) as $step)
                    <div class="w-2.5 h-2.5 rounded-full {{ $currentStep >= $step ? 'bg-primary' : 'bg-gray-300' }}"></div>
                @endforeach
            </div>

            <div class="items-center text-center w-full">
                @error('errors')
                <p class="text-lg text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Step 1: Information -->
            @if($currentStep == 1)
                <div class="flex flex-col gap-4">
                    <div class="flex flex-col gap-1">
                        <label class="kt-form-label font-normal text-mono">First Name</label>
                        <input type="text" class="kt-input" wire:model="first_name" placeholder="John" />
                        @error('first_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="kt-form-label font-normal text-mono">Last Name</label>
                        <input type="text" class="kt-input" wire:model="last_name" placeholder="Doe" />
                        @error('last_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>
            @endif

            <!-- Step 2: Contact -->
            @if($currentStep == 2)
                <div class="flex flex-col gap-4">
                    <div class="flex flex-col gap-1">
                        <label class="kt-form-label font-normal text-mono">Email</label>
                        <input type="email" class="kt-input" wire:model="email" placeholder="john@example.com" />
                        @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="kt-form-label font-normal text-mono">Phone</label>
                        <input type="tel" class="kt-input" wire:model="phone" placeholder="08123456789" />
                        @error('phone') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>
            @endif

            <!-- Step 3: Credentials -->
            @if($currentStep == 3)
                <div class="flex flex-col gap-4">
                    <div class="flex flex-col gap-1">
                        <label class="kt-form-label font-normal text-mono">Username</label>
                        <input type="text" class="kt-input" wire:model="username" placeholder="johndoe" />
                        @error('username') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="kt-form-label font-normal text-mono">Password</label>
                        <input type="password" class="kt-input" wire:model="password" placeholder="******" />
                        @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="kt-form-label font-normal text-mono">Confirm Password</label>
                        <input type="password" class="kt-input" wire:model="password_confirmation" placeholder="******" />
                        @error('password_confirmation') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>
            @endif

            <!-- Navigation Buttons -->
            <div class="flex justify-between mt-4">
                @if($currentStep > 1)
                    <button type="button" wire:click="prevStep" class="kt-btn kt-btn-outline">
                        Back
                    </button>
                @else
                   <!-- Spacer -->
                   <div></div> 
                @endif

                @if($currentStep < 3)
                    <button type="button" wire:click="nextStep" class="kt-btn kt-btn-primary">
                        Next
                    </button>
                @else
                    <button type="submit" class="kt-btn kt-btn-primary">
                        Daftar Sekarang
                    </button>
                @endif
            </div>

            <!-- Login Link -->
            <div class="text-center mt-4">
                <a href="{{ route('auth.index') }}" class="text-sm link">
                    Sudah punya akun? Masuk
                </a>
            </div>

        </form>
    </div>
</div>
