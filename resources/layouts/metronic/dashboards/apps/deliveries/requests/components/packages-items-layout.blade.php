<div class="kt-card">
    <div class="kt-card-header" id="advanced_settings_preferences">
        <h3 class="kt-card-title">
            Informasi Paket
        </h3>

        <div class="flex justify-end">
            <button class="kt-btn kt-btn-secondary" type="button" wire:click="add">
                Tambah Item
            </button>
        </div>
    </div>
    <div class="kt-card-content grid gap-5 lg:py-7.5">
        <div class="w-full">
            @foreach ($items as $index => $item)
                <div wire:key="item-{{ $index }}"
                     data-kt-accordion="true"
                     data-kt-accordion-expand-all="true"
                     data-kt-accordion-initialized="true"
                     class="my-3">
                    <div class="kt-accordion-item not-last:border-b border-b-border" data-kt-accordion-item="true" aria-expanded="false">
                        <div aria-controls="accordion-content-{{$index}}"
                             class="kt-accordion-toggle py-4 kt-card-header bg-gray-100"
                             data-kt-accordion-toggle="#accordion-content-{{$index}}">
                            <h3 class="kt-card-title">
                                Judul Item
                            </h3>
                            <div class="flex justify-end">
                                <button class="kt-btn kt-btn-secondary" type="button" wire:click="remove({{ $index }})">
                                    Hapus
                                </button>
                            </div>
                        </div>

                        <div class="kt-accordion-content hidden p-2 border-b border-b-border"
                             id="accordion-content-{{$index}}"
                             style="height: 0;">
                            {{-- ... form nya --}}
                            <div class="w-full">
                                <div class="grid grid-cols-1 xl:grid-cols-4 gap-5 lg:gap-7.5 py-3">
                                    <div class="col-span-2">
                                        <div class="flex flex-col gap-3">
                                            <label class="kt-form-label font-normal text-mono pl-2">
                                                Nama Paket (Item)
                                            </label>
                                            <input class="kt-input kt-input-lg" type="text" name="title" placeholder="Judul Permintaan" wire:model.defer="items.{{ $index }}.name"/>
                                        </div>
                                    </div>
                                    <div class="col-span-1">
                                        <div class="flex flex-col gap-3">
                                            <label class="kt-form-label font-normal text-mono pl-2">
                                                Kuantitas (Qty)
                                            </label>
                                            <input class="kt-input kt-input-lg" type="number" name="qty" placeholder="qty" wire:model.defer="items.{{ $index }}.qty"/>
                                        </div>
                                    </div>
                                    <div class="col-span-1">
                                        <div class="flex flex-col gap-3">
                                            <label class="kt-form-label font-normal text-mono pl-2">
                                                Unit (Unit)
                                            </label>
                                            <input class="kt-input kt-input-lg" type="number" name="qty" placeholder="qty" wire:model.defer="items.{{ $index }}.qty"/>
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
                                            <input class="kt-input kt-input-lg" type="number" name="width" placeholder="Panjang" wire:model.defer="items.{{ $index }}.width"/>
                                        </div>
                                    </div>
                                    <div class="col-span-1">
                                        <div class="flex flex-col gap-3">
                                            <label class="kt-form-label font-normal text-mono pl-2">
                                                Tinggi (Height)
                                            </label>
                                            <input class="kt-input kt-input-lg" type="number" name="height" placeholder="height" wire:model.defer="items.{{ $index }}.height"/>
                                        </div>
                                    </div>
                                    <div class="col-span-1">
                                        <div class="flex flex-col gap-3">
                                            <label class="kt-form-label font-normal text-mono pl-2">
                                                Lebar (weight)
                                            </label>
                                            <input class="kt-input kt-input-lg" type="number" name="weight" placeholder="weight" wire:model.defer="items.{{ $index }}.weight"/>
                                        </div>
                                    </div>
                                    <div class="col-span-1">
                                        <div class="flex flex-col gap-3">
                                            <label class="kt-form-label font-normal text-mono pl-2">
                                                Berat (Heavy)
                                            </label>
                                            <input class="kt-input kt-input-lg" type="number" name="heavy" placeholder=".kg" wire:model.defer="items.{{ $index }}.heavy"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

