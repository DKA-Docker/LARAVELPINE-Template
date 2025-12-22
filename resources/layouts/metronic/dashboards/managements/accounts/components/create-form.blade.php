<div class="space-y-6 animate-fade-in text-left">
    {{-- SECTION 1: KREDENSIAL --}}
    <div class="kt-card border-none shadow-xl shadow-gray-200/40 rounded-2xl overflow-hidden ring-1 ring-gray-100">
        <div class="bg-gradient-to-r from-gray-900 via-gray-800 to-gray-900 p-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center backdrop-blur-md">
                    <i class="ki-filled ki-shield-search text-lg text-emerald-400"></i>
                </div>
                <div>
                    <h3 class="text-white font-black text-lg tracking-tight">Kredensial Keamanan</h3>
                    <p class="text-gray-400 text-[10px] font-bold uppercase tracking-widest text-left">Atur akses login pengguna</p>
                </div>
            </div>
        </div>

        <div class="kt-card-content p-5">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 text-left">
                <div class="flex flex-col gap-1.5">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.15em] ml-1">Username</label>
                    <div class="relative group">
                        <input wire:model.live="formData.credential.username" class="kt-input focus:ring-4 focus:ring-emerald-50 border-gray-100 rounded-xl h-11 pl-10 font-bold text-gray-700 shadow-sm transition-all" type="text" placeholder="Username..."/>
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <i class="ki-filled ki-profile-circle text-lg text-gray-300 group-focus-within:text-emerald-500 transition-colors"></i>
                        </div>
                    </div>
                    @error('formData.credential.username') <span class="text-red-500 text-[10px] font-bold ml-1 italic">{{ $message }}</span> @enderror
                </div>

                <div class="flex flex-col gap-1.5">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.15em] ml-1">Password</label>
                    <div class="relative group">
                        <input wire:model.live="formData.credential.password" class="kt-input focus:ring-4 focus:ring-emerald-50 border-gray-100 rounded-xl h-11 pl-10 font-bold text-gray-700 shadow-sm transition-all" type="password" placeholder="••••••••"/>
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <i class="ki-filled ki-key text-lg text-gray-300 group-focus-within:text-emerald-500 transition-colors"></i>
                        </div>
                    </div>
                    @error('formData.credential.password') <span class="text-red-500 text-[10px] font-bold ml-1 italic">{{ $message }}</span> @enderror
                </div>

                <div class="flex flex-col gap-1.5">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.15em] ml-1">Konfirmasi Password</label>
                    <div class="relative group">
                        <input wire:model.live="formData.credential.password_confirmation" class="kt-input focus:ring-4 focus:ring-emerald-50 border-gray-100 rounded-xl h-11 pl-10 font-bold text-gray-700 shadow-sm transition-all" type="password" placeholder="••••••••"/>
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <i class="ki-filled ki-password text-lg text-gray-300 group-focus-within:text-emerald-500 transition-colors"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="flex md:flex-row flex-col gap-6 text-left">
        {{-- SECTION 2: PERSONAL INFO --}}
        <div class="kt-card md:w-1/2 border-none shadow-lg shadow-gray-100 rounded-2xl overflow-hidden ring-1 ring-gray-100">
            <div class="p-4 border-b border-gray-50 bg-gray-50/50">
                <h3 class="text-sm font-black text-gray-800 uppercase tracking-widest flex items-center gap-2">
                    <i class="ki-filled ki-badge text-blue-600"></i> Personal Information
                </h3>
            </div>
            <div class="kt-card-content p-5 space-y-4">
                <div class="grid grid-cols-2 gap-3">
                    <div class="flex flex-col gap-1.5">
                        <label class="text-[9px] font-black text-gray-400 uppercase ml-1">Nama Depan</label>
                        <input type="text" wire:model.live="formData.information.first_name" class="kt-input h-10 rounded-lg border-gray-100 focus:ring-4 focus:ring-blue-50 font-bold text-sm shadow-sm" placeholder="First Name">
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="text-[9px] font-black text-gray-400 uppercase ml-1">Nama Belakang</label>
                        <input type="text" wire:model.live="formData.information.last_name" class="kt-input h-10 rounded-lg border-gray-100 focus:ring-4 focus:ring-blue-50 font-bold text-sm shadow-sm" placeholder="Last Name">
                    </div>
                </div>

                <div class="flex flex-col gap-1.5">
                    <label class="text-[9px] font-black text-gray-400 uppercase ml-1">Email Contact</label>
                    <div class="relative group">
                        <input type="email" wire:model.live="formData.contact.email" class="kt-input h-10 rounded-lg border-gray-100 focus:ring-4 focus:ring-blue-50 pl-10 font-semibold text-sm shadow-sm w-full" placeholder="example@domain.com">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="ki-filled ki-sms text-base text-gray-300 group-focus-within:text-blue-500"></i>
                        </div>
                    </div>
                    @error('formData.contact.email') <span class="text-red-500 text-[10px] font-bold ml-1 italic">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        {{-- SECTION 3: ROLE ASSIGNMENT --}}
        <div class="kt-card md:w-1/2 border-none shadow-lg shadow-gray-100 rounded-2xl overflow-hidden ring-1 ring-gray-100">
            <div class="p-4 border-b border-gray-50 bg-gray-50/50 flex items-center justify-between">
                <h3 class="text-sm font-black text-gray-800 uppercase tracking-widest flex items-center gap-2">
                    <i class="ki-filled ki-setting-4 text-purple-600"></i> Role Assignment
                </h3>
                <button type="button" wire:click="clearRole" class="text-[9px] font-black text-red-500 uppercase hover:text-red-600 transition-colors flex items-center gap-1">
                    <i class="ki-filled ki-cross-circle"></i> Clear Select
                </button>
            </div>
            <div class="kt-card-content p-5">
                <div class="flex flex-col gap-3">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-wider ml-1">Hak Akses Sistem</label>
                    <div class="grid grid-cols-1 gap-2">
                        @foreach($roles ?? [] as $role)
                            @php
                                $isSelected = in_array($role->name, (array) ($formData['role'] ?? []));
                            @endphp
                            <label wire:key="role-{{ $role->id }}"
                                   class="relative flex items-center p-3 rounded-xl border transition-all group cursor-pointer {{ $isSelected ? 'bg-purple-50 border-purple-200' : 'bg-white border-gray-100 hover:bg-purple-50' }}">

                                <input type="checkbox" wire:model.live="formData.role" value="{{ $role->name }}" class="absolute opacity-0 w-full h-full cursor-pointer z-10">

                                <div class="flex grow items-center gap-3">
                                    <div class="w-7 h-7 rounded-lg bg-white flex items-center justify-center shadow-sm group-hover:scale-110 transition-transform">
                                        <i class="ki-filled ki-shield-check {{ $isSelected ? 'text-purple-600' : 'text-purple-400' }}"></i>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-xs font-black {{ $isSelected ? 'text-purple-900' : 'text-gray-800' }} uppercase tracking-tight">{{ $role->name }}</span>
                                        <span class="text-[9px] text-gray-400 font-bold uppercase tracking-tighter">Guard: {{ $role->guard_name }}</span>
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    @if($isSelected)
                                        <i class="ki-filled ki-check-circle text-purple-600 text-lg animate-scale-in"></i>
                                    @else
                                        <div class="w-5 h-5 rounded-full border-2 border-gray-100 group-hover:border-purple-200 transition-colors"></div>
                                    @endif
                                </div>
                            </label>
                        @endforeach
                    </div>
                    @error('formData.role') <span class="text-red-500 text-[10px] font-bold ml-1 italic">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>
    </div>

    {{-- ACTIONS --}}
    <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-100">
        <button type="button" onclick="history.back()" class="text-[10px] font-black uppercase tracking-widest text-gray-400 hover:text-red-500 transition-colors">Discard changes</button>
        <button wire:click="submit" wire:loading.attr="disabled" class="group relative overflow-hidden bg-gray-900 px-8 py-3.5 rounded-xl shadow-lg transition-all hover:bg-emerald-600 active:scale-95 disabled:opacity-50">
            <div class="relative z-10 flex items-center gap-3">
                <span wire:loading.remove wire:target="submit" class="text-[11px] font-black text-white uppercase tracking-[0.2em]">Create Account</span>
                <span wire:loading wire:target="submit" class="text-[11px] font-black text-white uppercase tracking-[0.2em]">Processing...</span>
                <i class="ki-filled ki-check-circle text-emerald-400 group-hover:text-white transition-colors"></i>
            </div>
            <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-full group-hover:animate-shimmer"></div>
        </button>
    </div>
</div>
