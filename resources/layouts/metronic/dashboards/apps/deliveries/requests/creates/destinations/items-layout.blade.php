<div class="kt-card border-1 border-red-700">
    <div class="kt-card-header rounded-t-xl" style="background: linear-gradient(90deg,rgba(150, 5, 5, 1) 0%, rgba(253, 29, 29, 1) 70%, rgba(252, 176, 69, 1) 100%);">
        <h3 class="kt-card-title text-white">
            Daftar Destinasi Pengiriman
        </h3>

        <div class="flex justify-end">
            <button class="kt-btn kt-btn-secondary" type="button" wire:click="add">
                Tambah Destinasi
            </button>
        </div>
    </div>

    <div class="grid px-2 gap-1">
        <div class="w-full" >
            <div class="my-3">
                @if(count($destinations) == 0)
                    <div class="flex flex-col gap-5 lg:gap-7.5">
                        <div class="kt-card-content px-10 py-7.5 lg:pe-12.5">
                            <div class="flex flex-wrap md:flex-nowrap items-center gap-6 md:gap-10">
                                <!-- Kolom teks -->
                                <div class="flex flex-col gap-3 max-w-xl">
                                    <h2 class="text-xl font-semibold text-mono">
                                        Tambah Destinasi Pengiriman
                                    </h2>
                                    <p class="text-sm text-secondary-foreground leading-5.5">
                                        Anda Bisa Melakukan Pengiriman Lebih Dari 1 Titik. dan Di Dalam Destinasi Anda Memasukkan Beberapa item barang Di Destinasi Tersebut
                                    </p>
                                </div>

                                <!-- Kolom gambar, dipaksa nempel kanan -->
                                <div class="ms-auto flex items-center gap-4">
                                    <img
                                        alt="image"
                                        class="block dark:hidden max-h-[160px]"
                                        src="{{ asset(Storage::url('media/illustrations/31.svg')) }}"
                                    >
                                    <img
                                        alt="image"
                                        class="hidden dark:block max-h-[160px]"
                                        src="{{ asset(Storage::url('media/illustrations/31-dark.svg')) }}"
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @foreach ($destinations as $index => $destination)
                        <div
                            class="kt-accordion-item my-3 border-1 border-red-700"
                            wire:key="destination-{{ $index }}"
                        >
                            {{-- TOGGLE --}}
                            <div
                                class="kt-card-header cursor-pointer"
                                style="background: linear-gradient(90deg,rgba(150, 5, 5, 1) 0%, rgba(253, 29, 29, 1) 70%, rgba(252, 176, 69, 1) 100%);"
                                wire:click="toggle({{ $index }})"
                            >
                                <h3 class="kt-card-title text-white" id="destinations-title-{{ $index }}">
                                    <span class="destinations-title-prefix">#{{ $index + 1 }} - </span>
                                    <span class="destinations-title-text">
                                        Dikirim Ke {{ strtoupper($destination['receipt_name'] ?? 'Belum Ada Penerima') }} Di {{ strtoupper($destination['receipt_address'] ?? 'Belum Ada Alamat') }}
                                    </span>
                                </h3>

                                <div class="flex justify-end gap-2">
                                    <button
                                        class="kt-btn kt-btn-secondary"
                                        type="button"
                                        wire:click.stop="delete({{ $index }})"
                                    >
                                        Hapus
                                    </button>
                                </div>
                            </div>

                            {{-- CONTENT --}}
                            <div
                                class="kt-accordion-content {{ ($open[$index] ?? false) ? 'block' : 'hidden' }}"
                            >
                                <div class="w-full">
                                    {{-- BARIS 1 --}}
                                    <div class="grid grid-cols-1 xl:grid-cols-4 gap-5 lg:gap-7.5 py-3 p-5">
                                        <div class="col-span-2">
                                            <div class="flex flex-col gap-3">
                                                <label class="kt-form-label font-normal text-mono pl-2">
                                                    Nama Penerima
                                                </label>
                                                <input
                                                    class="kt-input kt-input-lg"
                                                    type="text"
                                                    name="receipt_name"
                                                    placeholder="Nama Penerima Barang"
                                                    wire:model.defer="destinations.{{ $index }}.receipt_name"
                                                />
                                            </div>
                                        </div>
                                        <div class="col-span-2">
                                            <div class="flex flex-col gap-3">
                                                <label class="kt-form-label font-normal text-mono pl-2">
                                                    Alamat Penerima
                                                </label>
                                                <input
                                                    class="kt-input kt-input-lg"
                                                    type="text"
                                                    name="receipt_address"
                                                    placeholder="Alamat penerima Barang"
                                                    wire:model.defer="destinations.{{ $index }}.receipt_address"
                                                />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 xl:grid-cols-2 gap-5 lg:gap-7.5 py-3 p-5">
                                        <div class="col-span-2">
                                            <div class="flex flex-col gap-3">
                                                <label class="kt-form-label font-normal text-mono pl-2">
                                                    Description
                                                </label>
                                                <textarea
                                                    class="kt-input kt-input-lg min-h-32 max-h-32 p-5"
                                                    name="description"
                                                    placeholder="description"
                                                    wire:model.defer="destinations.{{ $index }}.description"
                                                ></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 xl:grid-cols-1 gap-5 lg:gap-7.5 py-3 p-5">
                                        <div class="col-span-1">
                                            {{-- PACKAGES PER DESTINATION --}}
                                            <livewire:metronic.dashboards.apps.deliveries.requests.creates.destinations.packages.items-layout
                                                wire:model.live="destinations.{{ $index }}.packages"
                                                :key="'dest-'.$index.'-packages'"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
            </div> {{-- end accordion wrapper --}}
        </div>
    </div>
</div>
