<div>
    <form wire:submit.prevent="submit" class="space-y-8">
        <div class="kt-container-fixed">
            <div class="flex flex-wrap items-center justify-between gap-5 pb-8 lg:items-end">
                <div class="flex flex-col justify-center gap-2">
                    <h1 class="text-2xl font-bold tracking-tight text-gray-900 leading-none">Buat Data Request Baru</h1>
                    <p class="text-sm text-gray-500">Lengkapi informasi pengiriman di bawah ini secara mendetail.</p>
                </div>
                <div class="flex items-center gap-3">
                    <a
                        href="."
                        wire:navigate
                        class="kt-btn kt-btn-lg bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 transition-all shadow-sm"
                    >
                        Batalkan
                    </a>
                    <button class="kt-btn kt-btn-lg bg-indigo-600 hover:bg-indigo-700 text-white shadow-lg shadow-indigo-200 transition-all" type="submit">
                        Simpan & Buat Data
                    </button>
                </div>
            </div>
        </div>

        @if (session('message'))
            <div class="alert {{ session('status') ? 'alert-success' : 'alert-danger' }} rounded-xl border-none shadow-md">
                {{ session('message') }}
            </div>
        @endif

        <div class="kt-container-fixed">
            <div class="grid gap-8">
                <div class="kt-card overflow-hidden border-none shadow-xl shadow-gray-100/50 rounded-2xl ring-1 ring-gray-100">
                    <div class="kt-card-header h-2" style="background: linear-gradient(90deg, #065A5C 0%, #AB7707 100%);"></div>
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="p-2 bg-cyan-50 rounded-lg">
                                <svg class="w-5 h-5 text-cyan-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-800">Informasi Permintaan Pengiriman</h3>
                        </div>

                        @if($data['name'] == null)
                            <div class="bg-gray-50 rounded-2xl p-8 mb-6 border border-dashed border-gray-200">
                                <div class="flex flex-wrap md:flex-nowrap items-center gap-10">
                                    <div class="flex flex-col gap-3 max-w-xl">
                                        <h2 class="text-xl font-bold text-gray-900">Buat Nama Subject Pengiriman</h2>
                                        <p class="text-sm text-gray-600 leading-relaxed">
                                            Tentukan judul pengiriman Anda, contoh: <span class="italic font-medium text-indigo-600">"Pengiriman Logistik Cluster A"</span>. Judul ini memudahkan pelacakan data.
                                        </p>
                                    </div>
                                    <div class="ms-auto">
                                        <img alt="illustration" class="max-h-[140px] drop-shadow-xl" src="{{ asset(Storage::url('media/illustrations/32.svg')) }}">
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="grid grid-cols-1 xl:grid-cols-4 gap-6">
                            <div class="col-span-3">
                                <label class="block text-sm font-semibold text-gray-700 mb-2 ml-1">Judul Pengiriman</label>
                                <input class="kt-input focus:ring-4 focus:ring-cyan-100 transition-all border-gray-200 rounded-xl" type="text" placeholder="Masukkan judul permintaan..." wire:model.live="data.name" />
                            </div>
                            <div class="col-span-1">
                                <label class="block text-sm font-semibold text-gray-700 mb-2 ml-1">Tingkat Urgensi</label>
                                <input class="kt-input focus:ring-4 focus:ring-cyan-100 transition-all border-gray-200 rounded-xl" type="text" placeholder="Contoh: High/Low" wire:model.live="data.urgent" />
                            </div>
                        </div>
                    </div>
                </div>

                {{-- DESTINATIONS COMPONENT --}}
                <livewire:metronic.dashboards.apps.deliveries.requests.creates.destinations.items-layout wire:model.live="data.destinations" />

                <div class="flex gap-4 justify-end pt-4">
                    <button class="kt-btn kt-btn-lg bg-indigo-600 hover:bg-indigo-700 text-white shadow-lg shadow-indigo-200" type="submit">
                        Finalisasi & Simpan Data
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
