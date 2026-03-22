<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use Inertia\Inertia;

// Public Pages
Route::get('/', [PageController::class , 'show'])->name('home');

// Special previews
Route::middleware(['web', 'auth', 'can:view-admin'])->group(function () {
    Route::get('/forms/{id}/preview', function ($id) {
        $form = \App\Models\Form::findOrFail($id);
        return Inertia::render('Public/FormPreview', [
            'form' => $form,
            'settings' => \App\Models\Setting::pluck('value', 'key')->toArray()
        ]);
    })->name('forms.preview');
});

Route::post('/forms/{form}/submit', [\App\Http\Controllers\PublicFormController::class, 'submit'])
    ->middleware('throttle:10,1')
    ->name('forms.submit');

Route::get('/{path?}', [PageController::class, 'show'])->where('path', '.*');

// Przeniesiona naprawa kolejności przez wymuszenie manualnego loadu w boot.php
