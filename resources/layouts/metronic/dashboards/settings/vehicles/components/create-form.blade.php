<div class="card">
    <div class="card-header">
        <h3 class="card-title">Vehicle Details</h3>
    </div>
    <div class="card-body">
        <form wire:submit.prevent="store" class="flex flex-col gap-5">
            <div class="flex flex-col gap-1">
                <label class="form-label font-medium text-gray-900">Vehicle Name</label>
                <input type="text" wire:model="name" class="input" placeholder="Enter vehicle name" />
                @error('name') <span class="text-danger text-xs">{{ $message }}</span> @enderror
            </div>
            
            <div class="flex flex-col gap-1">
                <label class="form-label font-medium text-gray-900">License Plate</label>
                <input type="text" wire:model="plate" class="input" placeholder="Enter license plate" />
                @error('plate') <span class="text-danger text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="flex flex-col gap-1">
                <label class="form-label font-medium text-gray-900">Category</label>
                <select wire:model="category" class="select">
                    <option value="">Select Category</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
                @error('category') <span class="text-danger text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="flex justify-end gap-2 pt-5">
                <a href="{{ route('dashboards.settings.vehicles.index') }}" class="btn btn-light">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <span wire:loading.remove>Save Changes</span>
                    <span wire:loading>Saving...</span>
                </button>
            </div>
        </form>
    </div>
</div>
