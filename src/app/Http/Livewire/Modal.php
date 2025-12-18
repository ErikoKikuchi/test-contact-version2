<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Contact;

class Modal extends Component
{
    public $contactId;
    public $showModal = false;

    public function mount($contactId)
    {
        $this->contactId = $contactId;
    }

    public function openModal()
    {
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }
    public function deleteContact()
    {
        if ($this->contactId) {
            Contact::find($this->contactId)?->delete();
            $this->closeModal();
        }
    }
    public function render()
    {
        $selectedContact = null;

        if ($this->showModal && $this->contactId) {
            $selectedContact = Contact::with('category')->find($this->contactId);
        }
        return view('livewire.modal', compact('selectedContact'));
    }
}
