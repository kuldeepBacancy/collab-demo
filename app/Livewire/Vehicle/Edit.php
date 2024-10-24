<?php

namespace App\Livewire\Vehicle;

use App\Models\Company;
use App\Models\Vehicle;
use App\Models\VehicleModel;
use Livewire\Component;
use Livewire\Attributes\Rule;
use Illuminate\Support\Facades\Auth;

class Edit extends Component
{
    public $vehicleId;

    #[Rule('required')]
    public $company_name = '';

    #[Rule('required')]
    public $vehicle_model = '';

    #[Rule('required|min:3')]
    public $vehicle_number = '';

    public function mount($id)
    {
        $this->vehicleId = $id;
        $vehicle = Vehicle::find($id);

        $this->company_name = $vehicle->company_id;
        $this->vehicle_model = $vehicle->vehicle_model_id;
        $this->vehicle_number = $vehicle->vehicle_number;
    }

    public function update(){
        $this->validate();
        Vehicle::where('id', $this->vehicleId)->update([
            'user_id' => Auth::user()->id,
            'company_id' => $this->company_name,
            'vehicle_model_id' => $this->vehicle_model,
            'vehicle_number' => $this->vehicle_number
        ]);
        return $this->redirect(route('vehicles.index'), navigate:true);
    }

    public function render()
    {
        $companies = Company::orderBy('company_name','asc')->get();
        $vehicleModels = VehicleModel::orderBy('model_name','asc')->get();
        return view('livewire.vehicle.edit', compact('companies','vehicleModels'));
    }
}
