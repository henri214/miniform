<?php

namespace App\Livewire;

use App\Models\Form;
use Livewire\Component;

class ShowTheForm extends Component
{
    public $form;

    public $contents;

    public function mount($formId)
    {
        $this->form = Form::findOrFail($formId);
        $this->contents = json_decode($this->form->content, true);
    }

    public function render()
    {
        return view('livewire.show-the-form')->layout('layouts.app');
    }
}
