<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController; // <-- NEW: Added the OrderController import
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// All routes inside this group require the user to be logged in ('auth')
Route::middleware('auth')->group(function () {
    
    // Customer Management Module Routes (Existing RBAC)
    Route::resource('customers', CustomerController::class)->except(['destroy']); 
    Route::delete('customers/{customer}', [CustomerController::class, 'destroy'])
        ->middleware('isAdmin')
        ->name('customers.destroy');

    // Order Management Module Routes
    Route::resource('orders', OrderController::class); // <-- NEW: Added the orders resource route

    // Profile Management Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';