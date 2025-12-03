<div class="kt-card border-1 border-red-700">
    <div class="kt-card-header rounded-t-xl" style="background: linear-gradient(90deg,rgba(150, 5, 5, 1) 0%, rgba(253, 29, 29, 1) 70%, rgba(252, 176, 69, 1) 100%);">
        <h3 class="kt-card-title text-white">
            Ada {{ array_sum($destinations) }} Tujuan
        </h3>

        <div class="flex justify-end">
            <button class="kt-btn kt-btn-secondary" type="button" wire:click="add">
                Tambah Tujuan
            </button>
        </div>
    </div>

    <div class="grid px-2 gap-1">
        <div class="w-full" >
            <div class="my-3">
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
                                    Dikirim Ke {{ $destination['receipt_name'] ?? '-' }} Di {{ $destination['receipt_address'] ?? '-' }}
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
                                                placeholder="receipt_name"
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
                                                placeholder="receipt_address"
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
                                            <input
                                                class="kt-input kt-input-lg"
                                                type="text"
                                                name="description"
                                                placeholder="description"
                                                wire:model.defer="destinations.{{ $index }}.description"
                                            />
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
