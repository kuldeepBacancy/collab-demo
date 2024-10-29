<?php

namespace App\Livewire;

use App\Models\Vehicle;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\Attributes\Rule;
use Livewire\WithFileUploads;
use thiagoalessio\TesseractOCR\TesseractOCR;

class Dashboard extends Component
{
    use WithFileUploads;

    public $vehicle_image;

    private function extractVehicleNumber($ocrText)
    {
        if (preg_match('/[A-Z]{2}[ -]?[0-9]{2}[ -]?[A-Z]{1,2}[ -]?[0-9]{4}/', $ocrText, $matches)) {
            return $matches[0];
        }
        return 'Vehicle number not recognized.';
    }

    public function request()
    {
        $this->validate([
            'vehicle_image' => 'image|max:10240',
        ]);
        $imagePath = $this->vehicle_image->store('temp','public');
        $fullPath = Storage::disk('public')->path($imagePath);
        $ocrText = (new TesseractOCR($fullPath))->run();
        $vehicle_number = $this->extractVehicleNumber($ocrText);
        Storage::disk('public')->delete($imagePath);
        if($vehicle_number == 'Vehicle number not recognized.')
        {
            $this->addError('vehicle_image', 'Vehicle number not recognized.');
        }
        else{
            $vehicle = Vehicle::with('user')->where('vehicle_number', $vehicle_number)->first();
            $this->dispatch('openPopup', $vehicle);
        }
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
