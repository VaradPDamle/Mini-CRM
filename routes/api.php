<?php

use App\Http\Controllers\Api\CustomerApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all are assigned the
| "api" middleware group. Make something great!
|
*/

// All routes within this group require a valid Laravel Sanctum API token
Route::middleware('auth:sanctum')->group(function () {
    
    // Test route: Returns the authenticated user's details (for token verification)
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Expose Customer Management via Resource Routes
    // Methods like create and edit (which return views) are excluded
    Route::resource('customers', CustomerApiController::class)->except(['create', 'edit']);
});