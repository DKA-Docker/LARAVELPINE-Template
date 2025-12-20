<div class="kt-card border-none shadow-xl shadow-red-100/50 rounded-2xl ring-1 ring-red-50">
    <div class="p-6 flex items-center justify-between border-b border-gray-50 bg-gradient-to-r from-red-600 to-orange-500 rounded-t-2xl">
        <div class="flex items-center gap-3">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
            <h3 class="text-lg font-bold text-white">Daftar Destinasi Pengiriman</h3>
        </div>
        <button class="px-4 py-2 bg-white/20 hover:bg-white/30 backdrop-blur-md text-white rounded-xl text-sm font-semibold transition-all" type="button" wire:click="add">
            + Tambah Destinasi
        </button>
    </div>

    <div class="p-4 space-y-4">
        @if(count($destinations) == 0)
            <div class="py-12 flex flex-col items-center text-center">
                <img alt="empty" class="max-h-[160px] mb-6 opacity-80" src="{{ asset(Storage::url('media/illustrations/31.svg')) }}">
                <h2 class="text-xl font-bold text-gray-800">Belum Ada Destinasi</h2>
                <p class="text-gray-500 max-w-sm mt-2">Anda bisa menambahkan lebih dari satu titik pengiriman untuk permintaan ini.</p>
            </div>
        @endif

        @foreach ($destinations as $index => $destination)
            <div class="border border-gray-100 rounded-2xl overflow-hidden transition-all hover:shadow-md" wire:key="destination-{{ $index }}">
                {{-- TOGGLE HEADER --}}
                <div class="p-4 flex items-center justify-between cursor-pointer bg-gray-50/50 hover:bg-gray-50 transition-colors" wire:click="toggle({{ $index }})">
                    <div class="flex items-center gap-4">
                        <span class="flex items-center justify-center w-8 h-8 rounded-full bg-red-100 text-red-600 text-xs font-bold">#{{ $index + 1 }}</span>
                        <div class="flex flex-col">
                            <span class="text-sm font-bold text-gray-800">
                                {{ $destination['receipt_name'] ? strtoupper($destination['receipt_name']) : 'Penerima Belum Diisi' }}
                            </span>
                            <span class="text-xs text-gray-500 italic">
                                {{ $destination['receipt_address'] ? $destination['receipt_address'] : 'Alamat pengiriman belum ditentukan' }}
                            </span>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <button class="p-2 text-gray-400 hover:text-red-500 transition-colors" type="button" wire:click.stop="delete({{ $index }})">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </div>
                </div>

                {{-- CONTENT --}}
                <div class="{{ ($open[$index] ?? false) ? 'block' : 'hidden' }} p-6 bg-white border-t border-gray-100 animate-fade-in">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="space-y-2">
                            <label class="text-xs font-bold text-gray-500 uppercase tracking-wider ml-1">Nama Penerima</label>
                            <input class="kt-input focus:ring-red-100 border-gray-200 rounded-xl" type="text" placeholder="Contoh: Bpk. Jaka" wire:model.defer="destinations.{{ $index }}.receipt_name" />
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-bold text-gray-500 uppercase tracking-wider ml-1">Alamat Lengkap</label>
                            <input class="kt-input focus:ring-red-100 border-gray-200 rounded-xl" type="text" placeholder="Masukkan alamat tujuan..." wire:model.defer="destinations.{{ $index }}.receipt_address" />
                        </div>
                    </div>
                    <div class="mb-6 space-y-2">
                        <label class="text-xs font-bold text-gray-500 uppercase tracking-wider ml-1">Catatan Tambahan</label>
                        <textarea class="kt-input min-h-24 focus:ring-red-100 border-gray-200 rounded-xl p-4" placeholder="Keterangan pengiriman..." wire:model.defer="destinations.{{ $index }}.description"></textarea>
                    </div>

                    <div class="pt-4 border-t border-gray-50">
                        <livewire:metronic.dashboards.apps.deliveries.requests.creates.destinations.packages.items-layout
                            wire:model.live="destinations.{{ $index }}.packages"
                            :key="'dest-'.$index.'-packages'"
                        />
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
