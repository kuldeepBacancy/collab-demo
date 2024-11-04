<div>
    <form wire:submit.prevent="request">
        <div class="flex items-center px-4 py-4">
            <div class="h-6">
                <input wire:model="vehicle_image" accept="image/*" class="block text-sm cursor-pointer dark:text-gray-400 focus:outline-none dark:placeholder-gray-400" id="file_input" type="file">
                    @error('vehicle_image')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
            </div>

            <button class="flex-shrink-0 px-2 py-1 mt-2 text-sm text-white bg-teal-500 border-4 border-teal-500 rounded hover:bg-teal-700 hover:border-teal-700" type="submit">
                Request
            </button>
        </div>
    </form>
    <livewire:popup />
</div>
