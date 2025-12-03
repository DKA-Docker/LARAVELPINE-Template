<form wire:submit.prevent="submit">
    <!-- Container -->
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center justify-between gap-5 pb-7.5 lg:items-end">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-mono text-xl leading-none font-medium">Buat Data Request Baru</h1>
            </div>
            <div class="flex items-center gap-2.5">
                <a
                    class="kt-btn  kt-btn-lg kt-btn-destructive"
                    href="{{ route(preg_replace('/\.create\.index$/', '.index', \Illuminate\Support\Facades\Route::currentRouteName())) }}"
                >
                    Batalkan
                </a>
                <button class="kt-btn kt-btn-lg kt-btn-secondary" type="submit">
                    Buat Data
                </button>
            </div>
        </div>
    </div>
    <!-- End of Container -->
    <!-- Container -->
    <div class="kt-container-fixed">
        <div class="grid gap-5 lg:gap-7.5">
            <div class="kt-card border-1 border-cyan-700">
                <div class="kt-card-header" style="background: linear-gradient(34deg,rgba(6, 90, 92, 1) 49%, rgba(171, 119, 7, 1) 100%);">
                    <h3 class="kt-card-title text-white">
                        Informasi Permintaan pengiriman
                    </h3>
                </div>
                <div class="kt-card-content grid gap-5 lg:py-7.5">
                    <div class="w-full">
                        @if($data['title'] == null)
                            <div class="flex flex-col gap-5 lg:gap-7.5">
                                <div class="kt-card-content px-10 py-7.5 lg:pe-12.5">
                                    <div class="flex flex-wrap md:flex-nowrap items-center gap-6 md:gap-10">
                                        <!-- Kolom teks -->
                                        <div class="flex flex-col gap-3 max-w-xl">
                                            <h2 class="text-xl font-semibold text-mono">
                                                Buat Nama Subject Pengiriman
                                            </h2>
                                            <p class="text-sm text-secondary-foreground leading-5.5">
                                                Tentukan Namanya Yah, Misal. "Pengiriman Hari Ini". Tenang. Ini Adalah Subject. Hanya Sebuah Judul
                                            </p>
                                        </div>

                                        <!-- Kolom gambar, dipaksa nempel kanan -->
                                        <div class="ms-auto flex items-center gap-4">
                                            <img
                                                alt="image"
                                                class="block dark:hidden max-h-[160px]"
                                                src="{{ asset(Storage::url('media/illustrations/32.svg')) }}"
                                            >
                                            <img
                                                alt="image"
                                                class="hidden dark:block max-h-[160px]"
                                                src="{{ asset(Storage::url('media/illustrations/32-dark.svg')) }}"
                                            >
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="grid grid-cols-1 xl:grid-cols-4 gap-5 lg:gap-7.5 py-3">
                            <div class="col-span-3">
                                <div class="flex flex-col gap-3">
                                    <label class="kt-form-label font-normal text-mono pl-2">Judul Pengiriman</label>
                                    <input
                                        class="kt-input kt-input-lg"
                                        type="text"
                                        name="title"
                                        placeholder="Judul Permintaan"
                                        wire:model.live="data.title"
                                    />
                                </div>
                            </div>
                            <div class="col-span-1">
                                <div class="flex flex-col gap-3">
                                    <label class="kt-form-label font-normal text-mono pl-2">Urgensi</label>
                                    <input
                                        class="kt-input kt-input-lg"
                                        type="text"
                                        name="urgency"
                                        placeholder="Prioritas"
                                        wire:model.live="data.urgent"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- DESTINATIONS --}}
            <livewire:metronic.dashboards.apps.deliveries.requests.creates.destinations.items-layout
                wire:model.live="data.destinations"
            />

            <div class="flex gap-4 justify-end">
                <a
                    class="kt-btn  kt-btn-lg kt-btn-destructive"
                    href="{{ route(preg_replace('/\.create\.index$/', '.index', \Illuminate\Support\Facades\Route::currentRouteName())) }}"
                >
                    Batalkan
                </a>
                <button class="kt-btn kt-btn-lg kt-btn-secondary" type="submit">
                    Buat Data
                </button>
            </div>
        </div>
    </div>
    <!-- End of Container -->
</form>
