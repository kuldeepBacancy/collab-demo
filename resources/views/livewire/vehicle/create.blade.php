<div>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Vehicles') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            {{-- <button wire:navigate href="{{ route('vehicles.index') }}" type="button" class="py-2.5 px-5 me-2 mb-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 ml-auto">Back</button> --}}
            <form class="max-w-sm mx-auto" wire:submit="create">
                <div class="mb-5">
                    <label for="company_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select Company</label>
                    <select wire:model="company_name" id="company_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="" selected>Select company</option>
                        @foreach ($companies as $company)
                            <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                        @endforeach
                    </select>
                    <div class="h-3">
                        @error('company_name')
                            <span class="text-sm text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mb-5">
                    <label for="vehicle_model" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select Vehicle Model</label>
                    <select wire:model="vehicle_model" id="vehicle_model" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="" selected>Select vehicle model</option>
                        @foreach ($vehicleModels as $vehicleModel)
                            <option value="{{ $vehicleModel->id }}">{{ $vehicleModel->model_name }}</option>
                        @endforeach
                    </select>
                    <div class="h-3">
                        @error('vehicle_model')
                            <span class="text-sm text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mb-5">
                    <label for="vehicle_number" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Vehicle Number</label>
                    <input wire:model="vehicle_number" type="text" id="vehicle_number" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="GJ 03 AY 1097" />
                    <div class="h-3">
                        @error('vehicle_number')
                            <span class="text-sm text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="mb-5">
                    <label for="confirm_vehicle_number" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Confirm Vehicle Number</label>
                    <input wire:model="confirm_vehicle_number" type="text" id="confirm_vehicle_number" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="GJ 03 AY 1097" />
                    <div class="h-3">
                        @error('confirm_vehicle_number')
                            <span class="text-sm text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="flex w-full space-x-4">
                    <button wire:navigate href="{{ route('vehicles.index') }}" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Back</button>
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
