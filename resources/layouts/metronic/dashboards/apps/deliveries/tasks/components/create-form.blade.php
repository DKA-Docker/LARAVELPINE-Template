<div class="space-y-6">
    {{-- CARD 1: INFORMASI TUGAS & MAPBOX --}}
    <div class="kt-card px-0 mx-auto overflow-hidden">
        <div class="kt-card-header">
            <h3 class="kt-card-title">Informasi Utama & Lokasi Koordinat</h3>
        </div>
        <div class="kt-card-content p-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- Form Input --}}
                <div class="space-y-5">
                    <div class="flex flex-col gap-2">
                        <label class="text-[11px] font-bold text-gray-500 uppercase tracking-wider">Nama Task</label>
                        <input wire:model="formData.task_name" class="kt-input kt-input-lg" type="text" placeholder="Contoh: Pengiriman Elektronik Batch A"/>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex flex-col gap-2">
                            <label class="text-[11px] font-bold text-gray-500 uppercase tracking-wider">Latitude</label>
                            <input type="text" wire:model="formData.latitude" class="kt-input bg-gray-50 font-mono text-xs" readonly>
                        </div>
                        <div class="flex flex-col gap-2">
                            <label class="text-[11px] font-bold text-gray-500 uppercase tracking-wider">Longitude</label>
                            <input type="text" wire:model="formData.longitude" class="kt-input bg-gray-50 font-mono text-xs" readonly>
                        </div>
                    </div>

                    <div class="p-4 bg-amber-50 border border-amber-100 rounded-xl">
                        <div class="flex gap-3">
                            <i class="ki-filled ki-information-2 text-amber-500 text-lg"></i>
                            <p class="text-[11px] text-amber-700 leading-relaxed">
                                <b>Cara Menentukan Lokasi:</b> Geser marker berwarna biru pada peta di samping untuk menyesuaikan titik koordinat pengiriman secara presisi.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Mapbox Container --}}
                <div class="lg:col-span-2">
                    {{-- Ganti container map di Blade menjadi seperti ini --}}
                    <div
                        wire:ignore
                        id="map"
                        class="w-full h-[350px] rounded-2xl border border-gray-200 shadow-inner overflow-hidden"
                        data-lng="{{ $formData['longitude'] }}"
                        data-lat="{{ $formData['latitude'] }}"
                    ></div>
                </div>
            </div>
        </div>
    </div>

    <div class="flex md:flex-row flex-col gap-5">
        {{-- CARD 2: DESTINASI --}}
        <div class="kt-card md:w-1/2 mx-auto">
            <div class="kt-card-header">
                <h3 class="kt-card-title">Lokasi Tujuan</h3>
            </div>
            <div class="kt-card-content p-6">
                <div class="flex flex-col gap-4">
                    <label class="text-[11px] font-bold text-gray-500 uppercase tracking-wider">Pilih Destinasi</label>
                    <select wire:model.live="formData.destination" class="form-select kt-input kt-input-lg">
                        <option value="">-- Pilih Alamat Tujuan --</option>
                        @foreach($destinations as $dest)
                            <option value="{{ $dest['id'] }}">
                                {{ $dest['receipt_name'] }} | {{ $dest['receipt_address'] }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        {{-- CARD 3: DRIVER --}}
        <div class="kt-card md:w-1/2 mx-auto">
            <div class="kt-card-header">
                <h3 class="kt-card-title">Personel Driver</h3>
            </div>
            <div class="kt-card-content p-6">
                <div class="flex flex-col gap-3 relative">
                    <label class="text-[11px] font-bold text-gray-500 uppercase tracking-wider">Cari Driver</label>

                    {{-- Badge Driver Terpilih --}}
                    <div class="flex flex-wrap gap-2 mb-1">
                        @foreach($formData['drivers'] as $id => $name)
                            <span class="inline-flex items-center gap-2 px-3 py-1 bg-blue-600 text-white text-[10px] font-bold rounded-lg shadow-sm">
                                {{ $name }}
                                <button type="button" wire:click.prevent="removeDriver('{{ $id }}')" class="hover:text-red-200 transition-colors">
                                    <i class="ki-filled ki-cross-circle text-xs"></i>
                                </button>
                            </span>
                        @endforeach
                    </div>

                    <input wire:model.live.debounce.300ms="driverSearch" type="text" class="kt-input kt-input-lg" placeholder="Ketik minimal 1 huruf..." autocomplete="off">

                    @if(strlen($driverSearch) >= 1)
                        <div class="absolute z-[100] mt-[75px] w-full bg-white border border-gray-200 rounded-xl shadow-2xl max-h-48 overflow-y-auto">
                            @forelse($suggestions as $driver)
                                @php
                                    $id = $driver['id'];
                                    $name = trim(($driver['information']['first_name'] ?? '') . ' ' . ($driver['information']['last_name'] ?? ''));
                                    if($name == '') $name = $driver['credential']['username'] ?? 'No Name';
                                @endphp
                                <div wire:click="addDriver('{{ $id }}', '{{ $name }}')" class="px-4 py-3 hover:bg-blue-50 cursor-pointer border-b border-gray-50 last:border-0 transition-colors">
                                    <div class="text-xs font-bold text-gray-800">{{ $name }}</div>
                                    <div class="text-[9px] text-gray-400 uppercase font-mono">{{ $driver['contact']['email'] ?? '' }}</div>
                                </div>
                            @empty
                                <div class="px-4 py-3 text-gray-400 text-xs italic">Tidak ada hasil...</div>
                            @endforelse
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- SECTION 4: TABEL ITEM (COMPACT) --}}
    <div class="py-2" id="order_receipt_body">
        <div class="kt-card shadow-sm border border-gray-100 overflow-hidden rounded-2xl">
            <div class="h-[6px] bg-gradient-to-r from-blue-600 to-emerald-400"></div>

            <div class="p-6">
                @if($currentDest)
                    <div class="flex flex-wrap items-center justify-between gap-4 mb-5">
                        <div class="text-left">
                            <h3 class="text-lg font-black text-gray-900 uppercase tracking-tight">Rincian Barang Elektronik</h3>
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">
                                Tujuan: <span class="text-blue-600">{{ $currentDest['receipt_name'] }}</span>
                            </p>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="flex items-center gap-2 bg-gray-50 px-3 py-1.5 rounded-lg border border-gray-200">
                                <span class="text-[9px] font-black text-gray-400 uppercase">Tampilkan:</span>
                                <select wire:model.live="perPage" class="bg-transparent text-xs font-bold text-gray-700 outline-none cursor-pointer">
                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                </select>
                            </div>
                            <div class="bg-gray-900 rounded-lg px-4 py-1.5">
                                <span class="text-[8px] font-bold text-gray-400 uppercase block leading-none mb-1">Total Qty</span>
                                <span class="text-xs font-black text-white leading-none">{{ collect($currentDest['packages'])->sum('qty') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="kt-scrollable-x-auto border border-gray-100 rounded-xl">
                        <table class="kt-table w-full">
                            <thead class="bg-gray-50/80">
                            <tr>
                                <th class="px-4 py-2 text-left w-12 text-[9px] font-black text-gray-400 uppercase">#</th>
                                <th class="px-4 py-2 text-left text-[9px] font-black text-gray-400 uppercase">Nama Produk</th>
                                <th class="px-4 py-2 text-center w-24 text-[9px] font-black text-gray-400 uppercase">Unit</th>
                                <th class="px-4 py-2 text-right w-24 text-[9px] font-black text-gray-400 uppercase">Qty</th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                            @php
                                $allPkgs = collect($currentDest['packages']);
                                $totalItems = $allPkgs->count();
                                $totalPages = ceil($totalItems / $perPage);
                                $packages = $allPkgs->slice(($currentPage - 1) * $perPage, $perPage);
                            @endphp
                            @foreach($packages as $index => $pkg)
                                <tr wire:key="row-{{ $pkg['id'] }}-{{ $currentPage }}" class="hover:bg-blue-50/40 transition-colors group">
                                    <td class="px-4 py-2 text-[10px] font-bold text-gray-300">
                                        {{ (($currentPage - 1) * $perPage) + $loop->iteration }}
                                    </td>
                                    <td class="px-4 py-2">
                                            <span class="text-[11px] font-bold text-gray-700 uppercase leading-tight break-words block max-w-md">
                                                {{ $pkg['name'] }}
                                            </span>
                                    </td>
                                    <td class="px-4 py-2 text-center">
                                            <span class="px-2 py-0.5 rounded bg-gray-100 text-[9px] font-black text-gray-400 uppercase">
                                                {{ $pkg['unit']['name'] ?? 'PCS' }}
                                            </span>
                                    </td>
                                    <td class="px-4 py-2 text-right">
                                        <span class="text-xs font-black text-gray-900">{{ $pkg['qty'] }}</span>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination Controls --}}
                    @if($totalPages > 1)
                        <div class="mt-5 flex flex-col md:flex-row justify-between items-center gap-4">
                            <span class="text-[9px] text-gray-400 font-bold uppercase tracking-[0.2em]">
                                Halaman {{ $currentPage }} / {{ $totalPages }}
                            </span>
                            <div class="flex items-center gap-1">
                                <button type="button" wire:click.prevent="setPage({{ max(1, $currentPage - 1) }})"
                                        class="w-7 h-7 flex items-center justify-center rounded-md border border-gray-200 {{ $currentPage == 1 ? 'opacity-20 cursor-not-allowed' : 'hover:bg-white text-blue-600 shadow-sm' }}"
                                        @if($currentPage == 1) disabled @endif>
                                    <i class="ki-filled ki-arrow-left text-[10px]"></i>
                                </button>

                                @for($i = 1; $i <= $totalPages; $i++)
                                    <button type="button" wire:click.prevent="setPage({{ $i }})"
                                            class="w-7 h-7 text-[10px] font-black rounded-md transition-all {{ $currentPage == $i ? 'bg-blue-600 text-white' : 'text-gray-400 hover:bg-gray-100' }}">
                                        {{ $i }}
                                    </button>
                                @endfor

                                <button type="button" wire:click.prevent="setPage({{ min($totalPages, $currentPage + 1) }})"
                                        class="w-7 h-7 flex items-center justify-center rounded-md border border-gray-200 {{ $currentPage == $totalPages ? 'opacity-20 cursor-not-allowed' : 'hover:bg-white text-blue-600 shadow-sm' }}"
                                        @if($currentPage == $totalPages) disabled @endif>
                                    <i class="ki-filled ki-arrow-right text-[10px]"></i>
                                </button>
                            </div>
                        </div>
                    @endif
                @else
                    <div class="py-16 flex flex-col items-center justify-center grayscale opacity-30">
                        <i class="ki-outline ki-delivery-2 text-6xl mb-3"></i>
                        <p class="text-[10px] font-black uppercase tracking-[0.4em]">Belum Ada Destinasi</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- BUTTON ACTION --}}
    <div class="flex gap-4 justify-end pt-4">
        <button type="button" class="kt-btn kt-btn-light font-bold text-xs uppercase tracking-widest">Batalkan</button>
        <button wire:click="submit" class="kt-btn kt-btn-secondary font-bold text-xs uppercase tracking-widest px-8 shadow-lg shadow-blue-100" type="button">
            Simpan Tugas
        </button>
    </div>
</div>

{{-- SCRIPT INTEGRASI MAPBOX --}}
<script>

</script>
