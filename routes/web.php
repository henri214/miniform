<?php

use App\Livewire\ShowTheForm;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::view('profile', 'profile')
        ->name('profile');
    Route::get('/form/{formId}', ShowTheForm::class)->name('form.show');
    Route::view('forms/', 'forms.create')->name('forms.create');
    Route::view('/forms/index', 'forms.index')->name('forms.index');
});
require __DIR__.'/auth.php';
