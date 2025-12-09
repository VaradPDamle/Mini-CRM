<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController; 
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// UPDATED ROOT ROUTE: Loads the new 'landing' page view
Route::get('/', function () {
    return view('landing');
});

// UPDATED: Pointing the /dashboard route to the new DashboardController
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

// All routes inside this group require the user to be logged in ('auth')
Route::middleware('auth')->group(function () {
    
    // Customer Management Module Routes (Existing RBAC)
    
    // CUSTOMER EXPORT ROUTE
    Route::get('customers/export/', [CustomerController::class, 'export'])->name('customers.export'); 

    // Customer Resource Route (Handles index, create, store, edit, update)
    Route::resource('customers', CustomerController::class)->except(['destroy']); 
    
    // Only Admins can access the destroy method (redefine destroy with isAdmin middleware)
    Route::delete('customers/{customer}', [CustomerController::class, 'destroy'])
        ->middleware('isAdmin')
        ->name('customers.destroy');

    // Order Management Module Routes
    
    // ORDER EXPORT ROUTE (Defined BEFORE resource route)
    Route::get('orders/export/', [OrderController::class, 'export'])->name('orders.export'); 

    // Order Resource Route
    Route::resource('orders', OrderController::class);

    // Profile Management Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';