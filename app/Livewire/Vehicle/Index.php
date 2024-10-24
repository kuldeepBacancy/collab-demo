<?php

namespace App\Livewire\Vehicle;

use App\Models\Vehicle;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{

    public function showModalView($id, $heading, $body)
    {
        $this->dispatch('openModal', data: [
            'id' => $id,
            'heading' => $heading,
            'body' => $body,
        ]);
    }

    public function render()
    {
        $vehicles = Vehicle::with('company','user','vehicleModel')->where('user_id',Auth::user()->id)->get();
        return view('livewire.vehicle.index', compact('vehicles'));
    }
}
