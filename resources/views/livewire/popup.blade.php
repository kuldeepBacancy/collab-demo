<div x-data="{ show: @entangle('showPopup') }" x-show="show" class="fixed inset-0 z-50 flex items-center justify-center w-full h-full bg-black bg-opacity-50">
    <div class="relative w-full max-w-md p-4">
        <div class="bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="p-6 text-center">
                <h4 class="mb-4 text-lg font-semibold">{{ $modalHeading }}</h4>
                @if ($data)
                    <h6>Name: {{ $data['user']['name'] }}</h6>
                    <h6>Email: {{ $data['user']['email'] }}</h6>
                    <h6>Phone Number: {{ $data['user']['phone_number'] }}</h6>
                    <h6>Vehicle Number: {{ $data['vehicle_number'] }}</h6>
                @endif
                <br>
                <div class="flex justify-center">
                    <button type="button" wire:click="closePopup" class="px-4 py-2 text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-300">
                        Close
                    </button>
                    @if ($data)
                        <button type="button" wire:click="close({{ $data['user']['phone_number'] }})" class="px-4 py-2 ml-3 text-white bg-red-600 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                            Call
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script>
        window.addEventListener('callUser', event => {
            window.location.href = `tel:${event.detail[0].phoneNumber}`;
        });
    </script>
</div>
