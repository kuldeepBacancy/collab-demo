<div x-data="{ show: @entangle('showModal') }" x-show="show" class="fixed inset-0 z-50 flex items-center justify-center w-full h-full bg-black bg-opacity-50">
    <div class="relative w-full max-w-md p-4">
        <div class="bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="p-6 text-center">
                <h4 class="mb-4 text-lg font-semibold">{{ $modalHeading }}</h4>
                <p class="mb-5 text-gray-600">{{ $modalBody }}</p>
                <div class="flex justify-center">
                    <button type="button" wire:click="closeModal" class="px-4 py-2 text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-300">
                        Close
                    </button>
                    <button type="button" wire:click="delete" class="px-4 py-2 ml-3 text-white bg-red-600 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                        Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
