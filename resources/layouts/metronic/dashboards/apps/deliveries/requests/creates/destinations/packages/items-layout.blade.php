<div class="kt-card  border-1 border-blue-800">
    <div class="kt-card-header rounded-t-xl" style="background: linear-gradient(90deg,rgba(2, 0, 36, 1) 0%, rgba(9, 9, 121, 1) 35%, rgba(0, 212, 255, 1) 100%);">
        <h3 class="kt-card-title text-white">
            Daftar Barang Yang Ingin Dikirim
        </h3>

        <div class="flex justify-end">
            <button class="kt-btn kt-btn-secondary" type="button" wire:click="add">
                Tambah Barang
            </button>
        </div>
    </div>

    <div class="grid px-2 gap-1">
        <div class="w-full">
            <div class="my-3">
                @if(count($packages) == 0)
                    <div class="flex flex-col gap-5 lg:gap-7.5">
                        <div class="kt-card-content px-10 py-7.5 lg:pe-12.5">
                            <div class="flex flex-wrap md:flex-nowrap items-center gap-6 md:gap-10">
                                <!-- Kolom teks -->
                                <div class="flex flex-col gap-3 max-w-xl">
                                    <h2 class="text-xl font-semibold text-mono">
                                        Tambah Barang Di Destinasi Ini
                                    </h2>
                                    <p class="text-sm text-secondary-foreground leading-5.5">
                                        Kamu Bisa Menambahkan Item Yang Mau Di Kirim Di Destinasi Ini. jangan Lupa Tambah Qty Dan Alamat Dengan Jelas Ya !
                                    </p>
                                </div>

                                <!-- Kolom gambar, dipaksa nempel kanan -->
                                <div class="ms-auto flex items-center gap-4">
                                    <img
                                        alt="image"
                                        class="block dark:hidden max-h-[160px]"
                                        src="{{ asset(Storage::url('media/illustrations/29.svg')) }}"
                                    >
                                    <img
                                        alt="image"
                                        class="hidden dark:block max-h-[160px]"
                                        src="{{ asset(Storage::url('media/illustrations/29-dark.svg')) }}"
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @foreach ($packages as $index => $package)
                    <div
                        class="kt-accordion-item my-3 border-1 border-blue-800"
                        data-kt-accordion-item="true"
                        wire:key="packages-{{ $index }}"
                    >
                        {{-- TOGGLE --}}
                        <div
                            class="kt-card-header cursor-pointer "
                            style="background: linear-gradient(90deg,rgba(2, 0, 36, 1) 0%, rgba(9, 9, 121, 1) 35%, rgba(0, 212, 255, 1) 100%);"
                            wire:click="toggle({{ $index }})"
                        >
                            <h3 class="kt-card-title text-white" id="packages-title-{{ $index }}">
                                <span class="packages-title-prefix">#{{ $index + 1 }} - </span>
                                <span class="packages-title-text">
                                    Kirim Barang {{ strtoupper($package['name'] ?: "Belum Ada Nama") }} - {{ strtoupper($package['qty'] ?? 0) }} {{ strtoupper($package['unit'] ?: "Unit") }}
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
                            class="kt-accordion-content border-b border-b-border {{ ($open[$index] ?? false) ? 'block' : 'hidden' }}"
                        >
                            <div class="w-full">
                                {{-- BARIS 1 --}}
                                <div class="grid grid-cols-1 xl:grid-cols-4 gap-5 lg:gap-7.5 py-3 p-5">
                                    <div class="col-span-2">
                                        <div class="flex flex-col gap-3">
                                            <label class="kt-form-label font-normal text-mono pl-2">
                                                Nama Item (Barang)
                                            </label>
                                            <input
                                                class="kt-input kt-input-lg"
                                                type="text"
                                                name="name"
                                                placeholder="name"
                                                wire:model.defer="packages.{{ $index }}.name"
                                                data-items-index="{{ $index }}"
                                                data-title-field="name"
                                            />
                                        </div>
                                    </div>
                                    <div class="col-span-1">
                                        <div class="flex flex-col gap-3">
                                            <label class="kt-form-label font-normal text-mono pl-2">
                                                Kuantitas (Qty)
                                            </label>
                                            <input
                                                class="kt-input kt-input-lg"
                                                type="number"
                                                min="0"
                                                name="qty"
                                                placeholder="qty"
                                                wire:model.defer="packages.{{ $index }}.qty"
                                                data-items-index="{{ $index }}"
                                                data-title-field="qty"
                                            />
                                        </div>
                                    </div>
                                    <div class="col-span-1">
                                        <div class="flex flex-col gap-3">
                                            <label class="kt-form-label font-normal text-mono pl-2">
                                                Unit (Satuan)
                                            </label>
                                            <input
                                                class="kt-input kt-input-lg"
                                                type="number"
                                                min="0"
                                                name="unit"
                                                placeholder="unit"
                                                wire:model.defer="packages.{{ $index }}.unit"
                                                data-items-index="{{ $index }}"
                                                data-title-field="unit"
                                            />
                                        </div>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 xl:grid-cols-4 gap-5 lg:gap-7.5 py-3 p-5">
                                    <div class="col-span-1">
                                        <div class="flex flex-col gap-3">
                                            <label class="kt-form-label font-normal text-mono pl-2">
                                                Lebar (Dimension)
                                            </label>
                                            <input
                                                class="kt-input kt-input-lg"
                                                type="text"
                                                name="width"
                                                placeholder="width"
                                                wire:model.defer="packages.{{ $index }}.width"
                                                data-items-index="{{ $index }}"
                                                data-title-field="width"
                                            />
                                        </div>
                                    </div>
                                    <div class="col-span-1">
                                        <div class="flex flex-col gap-3">
                                            <label class="kt-form-label font-normal text-mono pl-2">
                                                Panjang (Dimension)
                                            </label>
                                            <input
                                                class="kt-input kt-input-lg"
                                                type="number"
                                                min="0"
                                                name="weight"
                                                placeholder="weight"
                                                wire:model.defer="packages.{{ $index }}.weight"
                                                data-items-index="{{ $index }}"
                                                data-title-field="weight"
                                            />
                                        </div>
                                    </div>
                                    <div class="col-span-1">
                                        <div class="flex flex-col gap-3">
                                            <label class="kt-form-label font-normal text-mono pl-2">
                                                Tinggi (Dimension)
                                            </label>
                                            <input
                                                class="kt-input kt-input-lg"
                                                type="number"
                                                min="0"
                                                name="height"
                                                placeholder="height"
                                                wire:model.defer="packages.{{ $index }}.height"
                                                data-items-index="{{ $index }}"
                                                data-title-field="height"
                                            />
                                        </div>
                                    </div>
                                    <div class="col-span-1">
                                        <div class="flex flex-col gap-3">
                                            <label class="kt-form-label font-normal text-mono pl-2">
                                                Tinggi (Dimension)
                                            </label>
                                            <input
                                                class="kt-input kt-input-lg"
                                                type="number"
                                                min="0"
                                                name="heavy"
                                                placeholder="heavy"
                                                wire:model.defer="packages.{{ $index }}.heavy"
                                                data-items-index="{{ $index }}"
                                                data-title-field="heavy"
                                            />
                                        </div>
                                    </div>
                                </div>
                                <span class="border-t border-border w-full block"></span>


                            </div>
                        </div>
                    </div>
                @endforeach
            </div> {{-- end accordion wrapper --}}
        </div>
    </div>
</div>
