<?php

namespace App\Livewire;

use App\Models\Vehicle;
use Livewire\Component;
use Livewire\Attributes\On;

class DeleteConfirmationModal extends Component
{

    public $showModal = false;
    public $modalHeading = '';
    public $modalBody = '';
    public $deleteVehicleId;

    protected $listeners = ['openModal'];

    public function openModal($data)
    {
        $this->deleteVehicleId = $data['id'];
        $this->modalHeading = $data['heading'];
        $this->modalBody = $data['body'];
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        return $this->redirect(route('vehicles.index'),navigate:true);
    }

    public function delete()
    {
        Vehicle::find($this->deleteVehicleId)->delete();
        $this->closeModal();
        return $this->redirect(route('vehicles.index'),navigate:true);
    }

    public function render()
    {
        return view('livewire.delete-confirmation-modal');
    }
}
