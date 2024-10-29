<div>
    <form class="w-full max-w-sm" wire:submit.prevent="request">
        <div class="py-2">
            <input wire:model="vehicle_image" type="file" accept="image/*" class="text-gray-700" />
            <div class="h-6">
                @error('vehicle_image')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>
        </div>
        {{-- <div class="py-2">
            <input wire:model="vehicle_number" id="vehicle_number" class="w-full px-2 py-1 mr-3 leading-tight text-gray-700 bg-transparent border-none appearance-none focus:outline-none masked" type="text" placeholder="AA 00 AA 0000" />
            <div class="h-6">
                @error('vehicle_number')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>
        </div> --}}
        <button class="flex-shrink-0 px-2 py-1 mt-2 text-sm text-white bg-teal-500 border-4 border-teal-500 rounded hover:bg-teal-700 hover:border-teal-700" type="submit">
            Request
        </button>
    </form>
    <livewire:popup />
</div>
