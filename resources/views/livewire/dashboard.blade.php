<div>
    <form class="w-full max-w-sm" wire:submit="request">
        <div class="flex items-center py-2 border-b border-teal-500">
            <input wire:model="vehicle_number" class="w-full px-2 py-1 mr-3 leading-tight text-gray-700 bg-transparent border-none appearance-none focus:outline-none" type="text" placeholder="GJ 03 AY 1097" aria-label="Vehicle number">
            <button class="flex-shrink-0 px-2 py-1 text-sm text-white bg-teal-500 border-4 border-teal-500 rounded hover:bg-teal-700 hover:border-teal-700" type="submit">
                Request
            </button>
        </div>
        <div class="h-6">
            @error('vehicle_number')
                <span class="text-sm text-red-600">{{ $message }}</span>
            @enderror
        </div>
    </form>
    <livewire:popup/>
</div>
