<?php

namespace App\Livewire;

use App\Models\Form;
use Livewire\Component;

class ShowForms extends Component
{
    public $title;

    public $content;

    public function deleteForm($id)
    {
        $form = Form::find($id);
        $form->delete();
    }

    public function editForm(Form $form)
    {
        return redirect()->route('forms.edit', $form);
    }

    public function render()
    {
        $forms = Form::where('user_id', auth()->user()->id)
            ->orderBy('created_at', 'desc')->get();

        return view('livewire.show-forms', compact('forms'))->layout('layouts.app');
    }
}
