<?php

namespace App\Livewire;

use Livewire\Component;

class Popup extends Component
{
    public $showPopup = false;
    public $modalHeading = '';
    public $data = '';

    protected $listeners = ['openPopup'];

    public function openPopup($data)
    {
        $this->modalHeading = 'Owner Details';
        $this->data = $data;
        $this->showPopup = true;
    }

    public function closePopup()
    {
        $this->showPopup = false;
        $this->reset(['data','modalHeading']);
        return $this->redirect(route('dashboard'),navigate:true);
    }

    public function close()
    {
        $this->showPopup = false;
        $this->dispatch('callUser', ['phoneNumber' => $this->data['user']['phone_number']]);
        $this->reset(['data','modalHeading']);
    }

    public function render()
    {
        return view('livewire.popup');
    }
}
