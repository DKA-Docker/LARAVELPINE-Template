<div class="card">
    <div class="card-header">
        <h3 class="card-title">Edit Category Details</h3>
    </div>
    <div class="card-body">
        <form wire:submit.prevent="update" class="flex flex-col gap-5">
            <div class="flex flex-col gap-1">
                <label class="form-label font-medium text-gray-900">Name</label>
                <input type="text" wire:model="name" class="input" placeholder="Enter category name" />
                @error('name') <span class="text-danger text-xs">{{ $message }}</span> @enderror
            </div>
            
            <div class="flex flex-col gap-1">
                <label class="form-label font-medium text-gray-900">Description</label>
                <textarea wire:model="description" class="textarea" rows="3" placeholder="Enter description"></textarea>
                @error('description') <span class="text-danger text-xs">{{ $message }}</span> @enderror
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
