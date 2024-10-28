<?php

namespace App\Livewire;

use App\Models\Vehicle;
use Livewire\Component;
use Livewire\Attributes\Rule;

class Dashboard extends Component
{

    #[Rule('regex:/^[A-Z]{2}[ -]?[0-9]{2}[ -]?[A-Z]{1,2}[ -]?[0-9]{4}$/|exists:vehicles')]
    public $vehicle_number = '';

    public function request(){
        $this->validate();
        $vehicle = Vehicle::with('user')->where('vehicle_number', $this->vehicle_number)->first();
        $this->dispatch('openPopup', $vehicle);
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
