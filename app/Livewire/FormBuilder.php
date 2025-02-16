<?php

namespace App\Livewire;

use App\Models\Form;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class FormBuilder extends Component
{
    #[Validate('required|string')]
    public $title = '';

    // #[Validate('required|integer')]
    public $user_id = '';

    public $contents;

    protected $listeners = [
        'elementAdded' => 'addElement',
        'elementRemoved' => 'removeElement',
        'elementMoved' => 'MoveElement',
        'formSaved' => 'saveForm',
    ];

    public function mount()
    {
        // Initialize with empty form structure
        $this->user_id = auth()->id();
        $this->contents = [];
    }

    public function addElement($type)
    {
        $this->contents[] = [
            'id' => uniqid(),
            'type' => $type,
            'label' => '',
            'placeholder' => '',
            'required' => false,
            'options' => [],
            'order' => count($this->contents),
        ];
    }

    #[On('elementRemoved')]
    public function removeElement($elementId)
    {
        $this->contents = array_filter($this->contents, function ($element) use ($elementId) {
            return $element['id'] !== $elementId;
        });
    }

    public function editForm(Form $form)
    {
        return view('forms.edit', ['form' => $form]);
    }

    public function saveForm()
    {
        $this->validate();
        Form::create([
            'user_id' => auth()->id(),
            'title' => $this->title,
            'content' => json_encode([
                'contents' => $this->contents,
            ]),
        ]);

        return redirect()->route('forms.index')->with('message', 'Form created successfully!');
    }

    public function render()
    {
        return view('livewire.form-builder')->layout('layouts.app');
    }
}
