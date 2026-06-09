<?php

use App\Livewire\Questionnaire;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('questionnaire');
    }

    return view('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/responses', Questionnaire::class)->name('questionnaire');
});

require __DIR__.'/settings.php';
