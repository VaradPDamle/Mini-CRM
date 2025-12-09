<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CustomerController; // <-- Added the CustomerController
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// All routes inside this group require the user to be logged in ('auth')
Route::middleware('auth')->group(function () {
    
    // Customer Management Module Routes
    
    // Staff can CRUD, Admin can CRUD + Delete
    // The main resource route handles index, create, store, edit, update, show
    Route::resource('customers', CustomerController::class)->except(['destroy']); 

    // Only Admins can access the destroy method (redefine destroy with isAdmin middleware)
    Route::delete('customers/{customer}', [CustomerController::class, 'destroy'])
        ->middleware('isAdmin')
        ->name('customers.destroy');

    // Profile Management Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';