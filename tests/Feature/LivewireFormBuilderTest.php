<?php

use App\Livewire\FormBuilder;
use App\Models\Form;
use App\Models\User;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('it initializes with empty contents and sets user_id', function () {
    // Create a user and act as that user.
    $user = User::factory()->create();
    actingAs($user);

    // When the component mounts, "contents" should be empty,
    // and "user_id" should be set to the authenticated user's ID.
    Livewire::test(FormBuilder::class)
        ->assertSet('contents', [])
        ->assertSet('user_id', $user->id);
});

test('it can add an element to the form', function () {
    $user = User::factory()->create();
    actingAs($user);

    // Call the addElement method with a "text" type.
    Livewire::test(FormBuilder::class)
        ->call('addElement', 'text')
        // Assert that the first element in "contents" has type "text"
        ->assertSet('contents.0.type', 'text')
        // And that its order is 0.
        ->assertSet('contents.0.order', 0);
});

test('it can remove an element from the form', function () {
    $user = User::factory()->create();
    actingAs($user);

    // Add an element to the component.
    $component = Livewire::test(FormBuilder::class);
    $component->call('addElement', 'text');
    $contents = $component->get('contents');
    $elementId = $contents[0]['id'];

    // Now remove the element by its id.
    $component->call('removeElement', $elementId)
        ->assertSet('contents', []); // Expect an empty array after removal.
});

test('it validates title as required when saving form', function () {
    $user = User::factory()->create();
    actingAs($user);

    // Attempt to save the form without setting a title.
    // The validation should fail with a "required" error for the title.
    Livewire::test(FormBuilder::class)
        ->call('saveForm')
        ->assertHasErrors(['title' => 'required']);
});

test('it saves a valid form', function () {
    $user = User::factory()->create();
    actingAs($user);

    $title = 'Test Form';
    $contents = [
        [
            'id'          => uniqid(),
            'type'        => 'text',
            'label'       => 'Test label',
            'placeholder' => 'Test placeholder',
            'required'    => false,
            'options'     => [],
            'order'       => 0,
        ],
    ];

    // Set the title and contents, then call saveForm.
    // Expect a redirect to the forms index route after saving.
    Livewire::test(FormBuilder::class)
        ->set('title', $title)
        ->set('contents', $contents)
        ->call('saveForm')
        ->assertRedirect(route('forms.index'));

    // Assert that the form was saved in the database.
    expect(Form::where('title', $title)->exists())->toBeTrue();
});
