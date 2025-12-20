<div class="kt-container-fixed">
    <div class="grid gap-5 lg:gap-7.5">
        <div class="kt-card kt-card-grid min-w-full">
            <div class="kt-card-header flex-wrap gap-2">
                <h3 class="kt-card-title text-sm font-semibold">
                    {{-- Navigasi info data yang aman --}}
                    Menampilkan {{ $deliveries->firstItem() ?? 0 }} sampai {{ $deliveries->lastItem() ?? 0 }}
                    dari {{ $deliveries->total() }} data
                </h3>
                <div class="flex flex-wrap gap-2 lg:gap-5">
                    <div class="flex">
                        <label class="kt-input">
                            <i class="ki-filled ki-magnifier"></i>
                            <input wire:model.live.debounce.300ms="search" placeholder="Cari user..." type="text" />
                        </label>
                    </div>
                    <div class="flex flex-wrap gap-2.5">
                        <select wire:model.live="status" class="kt-select w-36">
                            <option value="">Semua Status</option>
                            <option value="active">Active</option>
                            <option value="pending">Pending</option>
                        </select>
                        <select wire:model.live="sort" class="kt-select w-36">
                            <option value="latest">Terbaru</option>
                            <option value="oldest">Terlama</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="kt-card-content">
                <div class="kt-scrollable-x-auto">
                    <table class="kt-table kt-table-border table-auto">
                        <thead>
                        <tr>
                            <th class="min-w-[150px]">Requested</th>
                            <th class="min-w-[200px]">Name</th>
                            <th class="min-w-[200px]">Email</th>
                            <th class="min-w-[150px]">Dibuat</th>
                        </tr>
                        </thead>
                        <tbody>

                        @forelse($deliveries as $item)
                            <tr>
                                <td class="font-bold text-gray-700">
                                    {{-- Kolom 'name' dari tabel deliveries --}}
                                    {{ $item->name ?? 'Unnamed Request' }}
                                </td>
                                <td>
                                    {{-- Mengambil atribut dinamis 'information' yang disiapkan di Component --}}
                                    {{ $item->information->first_name ?? 'N/A' }}
                                    {{ $item->information->last_name ?? '' }}
                                </td>
                                <td>
                                    {{-- Mengambil atribut dinamis 'contact' yang disiapkan di Component --}}
                                    {{ $item->contact->email ?? '-' }}
                                </td>
                                <td>
                                    <span class="text-xs">
                                        {{ $item->created_at->format('H:i:s d-M-Y') }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-10 text-gray-500">Data tidak ditemukan.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="kt-card-footer flex-col justify-center gap-5 text-sm font-medium md:flex-row md:justify-between">
                <div class="order-2 flex items-center gap-2 md:order-1">
                    Tampilkan
                    <select wire:model.live="perPage" class="kt-select w-16">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="25">25</option>
                    </select>
                    Per Halaman
                </div>
                <div class="order-1">
                    {{-- Pagination Link --}}
                    {{ $deliveries->links(data: ['scrollTo' => false]) }}
                </div>
            </div>
        </div>
    </div>
</div>
