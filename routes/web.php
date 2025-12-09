<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController; 
use App\Http\Controllers\DashboardController; // <-- NEW: Imported the DashboardController
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// UPDATED: Pointing the /dashboard route to the new DashboardController
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

// All routes inside this group require the user to be logged in ('auth')
Route::middleware('auth')->group(function () {
    
    // Customer Management Module Routes (Existing RBAC)
    Route::resource('customers', CustomerController::class)->except(['destroy']); 
    Route::delete('customers/{customer}', [CustomerController::class, 'destroy'])
        ->middleware('isAdmin')
        ->name('customers.destroy');

    // Order Management Module Routes
    Route::resource('orders', OrderController::class);

    // Profile Management Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';