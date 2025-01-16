<?php

namespace App\Livewire;

use App\Models\Vehicle;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\Attributes\Rule;
use Livewire\WithFileUploads;
use Nilgems\PhpTextract\Textract;
use thiagoalessio\TesseractOCR\TesseractOCR;

class Dashboard extends Component
{
    use WithFileUploads;

    public $vehicle_image;
    public $vehicle_number;

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
            'vehicle_image' => 'nullable|image|max:10240',
        ]);

        if (!$this->vehicle_number) {
            $imagePath = $this->vehicle_image->store('temp','public');
            $fullPath = Storage::disk('public')->path($imagePath);
            # Run the extractor
            $output = Textract::run($fullPath);
            Log::info('$output', [$output]);
            $ocrText = $output->text;
            // $ocrText = (new TesseractOCR($fullPath))->withoutTempFiles()->run();
            //$ocrText = (new TesseractOCR($fullPath))->run();
            // Log::info('$ocrText', [$ocrText]);
            $this->vehicle_number = $this->extractVehicleNumber($ocrText);
            Storage::disk('public')->delete($imagePath);
        }


        if($this->vehicle_number == 'Vehicle number not recognized.')
        {
            $this->addError('vehicle_image', 'Vehicle number not recognized.');
        }
        else{
            $vehicle = Vehicle::with('user')->where('vehicle_number', $this->vehicle_number)->first();
            if (!empty($vehicle)) {
                $this->dispatch('openPopup', $vehicle);
            } else {
                $this->addError('vehicle_number', 'No vehicle found.');
            }

        }
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
