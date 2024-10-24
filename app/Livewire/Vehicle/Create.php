<?php

namespace App\Livewire\Vehicle;

use App\Models\Company;
use App\Models\Vehicle;
use App\Models\VehicleModel;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Rule;

class Create extends Component
{

    #[Rule('required')]
    public $company_name = '';

    #[Rule('required')]
    public $vehicle_model = '';

    #[Rule('required|min:3|regex:/^[A-Z]{2}[ -]?[0-9]{2}[ -]?[A-Z]{1,2}[ -]?[0-9]{4}$/|unique:vehicles')]
    public $vehicle_number = '';

    #[Rule('required_with:vehicle_number|same:vehicle_number')]
    public $confirm_vehicle_number = '';

    public function create(){
        $this->validate();
        Vehicle::create([
            'user_id' => Auth::user()->id,
            'company_id' => $this->company_name,
            'vehicle_model_id' => $this->vehicle_model,
            'vehicle_number' => $this->vehicle_number
        ]);
        $this->reset('company_name','vehicle_model','vehicle_number');
        return $this->redirect(route('vehicles.index'), navigate:true);
    }

    public function render()
    {
        $companies = Company::orderBy('company_name','asc')->get();
        $vehicleModels = VehicleModel::orderBy('model_name','asc')->get();
        return view('livewire.vehicle.create', compact('companies','vehicleModels'));
    }
}
