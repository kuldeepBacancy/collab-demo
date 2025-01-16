<div>
    <form wire:submit.prevent="request" class="p-6">
        <div
            class="dropzone-drag flex bg-gray-100 rounded-lg border-solid border-4 border-indigo-400 relative justify-center px-4 py-4 hover:border-dashed">
            <div class="dropzone-drag-inner text-center">

                <!--   ✅ Here we can put font icon as well   -->
                <div class="dropzone-drag-icon flex justify-center">
                    <input wire:model="vehicle_image" accept="image/*"
                        class="absolute inset-0 z-50 m-0 p-0 w-full h-full outline-none opacity-0 cursor-pointer dark:text-gray-400 focus:outline-none dark:placeholder-gray-400"
                        id="file_input" type="file">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"
                        class="main-grid-item-icon" fill="none" stroke="currentColor" stroke-linecap="round"
                        stroke-linejoin="round" stroke-width="2">
                        <polyline points="16 16 12 12 8 16" />
                        <line x1="12" x2="12" y1="12" y2="21" />
                        <path d="M20.39 18.39A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.3" />
                        <polyline points="16 16 12 12 8 16" />
                    </svg>

                </div>

                <h5 class="dropzone-drag-title py-2">
                    Open Camera to capture vehicle number
                </h5>

            </div>

            @error('vehicle_image')
                <span class="text-sm text-red-600">{{ $message }}</span>
            @enderror
        </div>
        <div class="w-full font-bold text-center py-6">
            OR
        </div>
        <div class="flex justify-center">
            <div class="flex flex-col justify-center align-center w-full">
                <x-input name="vehicle_number" wire:model="vehicle_number" placeholder="Enter Vehicle-number"/>
                @error('vehicle_number')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="flex justify-center py-6">
            <button
                class="flex-shrink-0 px-2 py-1 mt-2 text-sm text-white bg-teal-500 border-4 border-teal-500 rounded hover:bg-teal-700 hover:border-teal-700"
                type="submit">
                Request
            </button>
        </div>
    </form>
    <livewire:popup />
</div>
