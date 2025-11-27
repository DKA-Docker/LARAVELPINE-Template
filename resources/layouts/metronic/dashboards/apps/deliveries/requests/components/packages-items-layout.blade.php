<div class="kt-card">
    <div class="kt-card-header" id="advanced_settings_preferences">
        <h3 class="kt-card-title">
            Informasi Paket
        </h3>

        <div class="flex justify-end">
            {{-- Saat Tombol Tambah item di tekan. maka akan memicu method add menggunakan wire:click --}}
            <button class="kt-btn kt-btn-secondary" type="button" wire:click="add">
                Tambah Item
            </button>
        </div>
    </div>

    <div class="kt-card-content grid gap-5 lg:py-7.5">
        <div class="w-full">
            {{-- 1 WRAPPER accordion, di dalamnya banyak item --}}
            <div data-kt-accordion="true"
                 data-kt-accordion-expand-all="true"
                 class="my-3">

                @foreach ($items as $index => $item)
                    <div class="kt-accordion-item not-last:border-b border-b-border my-3"
                         data-kt-accordion-item="true"
                         wire:key="item-{{ $index }}"
                         aria-expanded="false">

                        {{-- TOGGLE --}}
                        <div class="kt-accordion-toggle py-4 kt-card-header bg-gray-100"
                             data-kt-accordion-toggle="#{{"accordion-content-$index"}}"
                             aria-controls="{{"accordion-content-$index"}}">
                            <h3 class="kt-card-title">
                                Item #{{ $index + 1 }}
                            </h3>

                            <div class="flex justify-end">
                                <button class="kt-btn kt-btn-secondary"
                                        type="button"
                                        wire:click="remove({{ $index }})">
                                    Hapus
                                </button>
                            </div>
                        </div>

                        {{-- CONTENT --}}
                        <div class="kt-accordion-content hidden p-2 border-b border-b-border"
                             id="{{"accordion-content-$index"}}"
                             style="height: 0;">
                            <div class="w-full">
                                <div class="grid grid-cols-1 xl:grid-cols-4 gap-5 lg:gap-7.5 py-3">
                                    <div class="col-span-2">
                                        <div class="flex flex-col gap-3">
                                            <label class="kt-form-label font-normal text-mono pl-2">
                                                Nama Paket (Item)
                                            </label>
                                            <input class="kt-input kt-input-lg"
                                                   type="text"
                                                   name="title"
                                                   placeholder="Judul Permintaan"
                                                   wire:model.defer="items.{{ $index }}.name"/>
                                        </div>
                                    </div>

                                    <div class="col-span-1">
                                        <div class="flex flex-col gap-3">
                                            <label class="kt-form-label font-normal text-mono pl-2">
                                                Kuantitas (Qty)
                                            </label>
                                            <input class="kt-input kt-input-lg"
                                                   type="number"
                                                   min="0"
                                                   name="qty"
                                                   placeholder="qty"
                                                   wire:model.defer="items.{{ $index }}.qty"/>
                                        </div>
                                    </div>

                                    <div class="col-span-1">
                                        <div class="flex flex-col gap-3">
                                            <label class="kt-form-label font-normal text-mono pl-2">
                                                Unit (Unit)
                                            </label>
                                            <input class="kt-input kt-input-lg"
                                                   type="text"
                                                   name="unit"
                                                   placeholder="Unit"
                                                   wire:model.defer="items.{{ $index }}.unit"/>
                                        </div>
                                    </div>
                                </div>

                                <span class="border-t border-border w-full"></span>

                                <div class="grid grid-cols-1 xl:grid-cols-4 gap-5 lg:gap-7.5 py-3">
                                    <div class="col-span-1">
                                        <div class="flex flex-col gap-3">
                                            <label class="kt-form-label font-normal text-mono pl-2">
                                                Panjang (Width)
                                            </label>
                                            <input class="kt-input kt-input-lg"
                                                   type="number"
                                                   min="0"
                                                   name="width"
                                                   placeholder="Panjang"
                                                   wire:model.defer="items.{{ $index }}.width"/>
                                        </div>
                                    </div>

                                    <div class="col-span-1">
                                        <div class="flex flex-col gap-3">
                                            <label class="kt-form-label font-normal text-mono pl-2">
                                                Tinggi (Height)
                                            </label>
                                            <input class="kt-input kt-input-lg"
                                                   type="number"
                                                   min="0"
                                                   name="height"
                                                   placeholder="Tinggi"
                                                   wire:model.defer="items.{{ $index }}.height"/>
                                        </div>
                                    </div>

                                    <div class="col-span-1">
                                        <div class="flex flex-col gap-3">
                                            <label class="kt-form-label font-normal text-mono pl-2">
                                                Lebar (Weight)
                                            </label>
                                            <input class="kt-input kt-input-lg"
                                                   type="number"
                                                   min="0"
                                                   name="weight"
                                                   placeholder="Lebar"
                                                   wire:model.defer="items.{{ $index }}.weight"/>
                                        </div>
                                    </div>

                                    <div class="col-span-1">
                                        <div class="flex flex-col gap-3">
                                            <label class="kt-form-label font-normal text-mono pl-2">
                                                Berat (Heavy)
                                            </label>
                                            <input class="kt-input kt-input-lg"
                                                   type="number"
                                                   name="heavy"
                                                   min="0"
                                                   placeholder=".kg"
                                                   wire:model.defer="items.{{ $index }}.heavy"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 xl:grid-cols-4 gap-5 lg:gap-7.5 py-3 w-full">
                                    <div class="col-span-2">
                                        <div class="flex flex-col gap-3">
                                            <label class="kt-form-label font-normal text-mono pl-2">Alamat</label>
                                            <div class="w-full">
                                                <div id="map" class="w-full h-[400px]"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-span-2">
                                        <div class="h-full w-full">
                                            <div class="flex flex-col gap-3">
                                                <label class="kt-form-label font-normal text-mono pl-2">Alamat</label>
                                                <input class="kt-input kt-input-lg" id="address" type="text" name="address" placeholder="Alamat"/>
                                            </div>
                                            <div class="grid grid-cols-1 xl:grid-cols-4 gap-5 lg:gap-7.5 py-3">
                                                <div class="col-span-2">
                                                    <div class="flex flex-col gap-3">
                                                        <label class="kt-form-label font-normal text-mono pl-2">Latitude</label>
                                                        <input class="kt-input kt-input-lg" id="lat" type="text" name="latitude" placeholder="Latitude"/>
                                                    </div>

                                                </div>
                                                <div class="col-span-2">
                                                    <div class="flex flex-col gap-3">
                                                        <label class="kt-form-label font-normal text-mono pl-2">Longitude</label>
                                                        <input class="kt-input kt-input-lg" id="lng" type="text" name="Longitude" placeholder="Longitude"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> {{-- end content --}}
                    </div> {{-- end item --}}
                @endforeach

            </div> {{-- end accordion wrapper --}}
        </div>
    </div>
</div>
