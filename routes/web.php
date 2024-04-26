<?php

use App\Http\Controllers\FormController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PublicController::class, 'index'])->name('welcome');
Route::get('/form/{form}/view', [PublicController::class, 'viewForm'])->name('view_form');
Route::post('/form/{form}/submit', [PublicController::class, 'submitForm'])->name('submit_form');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/forms/index', [FormController::class, 'index'])->name('forms.index');
    Route::get('/forms/create', [FormController::class, 'createForm'])->name('forms.create');
    Route::post('/forms/store', [FormController::class, 'storeForm'])->name('forms.store');
    Route::get('forms/{form}/edit', [FormController::class, 'editForm'])->name('forms.edit');
    Route::put('/forms/update/{id}', [FormController::class, 'updateForm'])->name('forms.update');
    Route::delete('/forms/{form}/destroy', [FormController::class, 'destroyForm'])->name('forms.destroy');
    Route::get('/submissions/{form}/list', [FormController::class, 'listSubmissions'])->name('forms.submissions.list');

});

require __DIR__.'/auth.php';
