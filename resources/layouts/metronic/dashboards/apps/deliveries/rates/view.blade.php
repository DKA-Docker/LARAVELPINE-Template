<div class="kt-container-fixed flex flex-col gap-5">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">List Data Rates</h3>
            <div class="card-toolbar">
                <div class="flex flex-wrap gap-2.5">
                    <input wire:model.live.debounce.500ms="search" type="text" class="kt-input" placeholder="Search..." />
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="kt-table-responsive">
                <table class="kt-table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer">
                    <thead>
                        <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                            <th>Name</th>
                            <th>Price</th>
                            <th>Category</th>
                            <th>Description</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 fw-bold">
                        @forelse($rates as $rate)
                            <tr>
                                <td>{{ $rate->name }}</td>
                                <td>{{ number_format($rate->price, 2) }}</td>
                                <td>{{ $rate->category }}</td>
                                <td>{{ Str::limit($rate->description, 50) }}</td>
                                <td class="text-end">
                                    <button class="btn btn-sm btn-light btn-active-light-primary">Edit</button>
                                    <button class="btn btn-sm btn-light btn-active-light-danger">Delete</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No data found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $rates->links() }}
            </div>
        </div>
    </div>
</div>
