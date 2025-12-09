<?php

namespace App\Http\Controllers;

use App\Models\Customer; // Used for database interaction
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\CustomerStoreRequest; // Used for automatic validation
use Illuminate\Support\Facades\Storage; // <-- NEW: Used for deleting old profile images

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     * Implements Pagination.
     */
    public function index(): View
    {
        $customers = Customer::paginate(10);
        return view('customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CustomerStoreRequest $request): RedirectResponse
    {
        $path = null;
        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('profile-images', 'public');
        }

        Customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'profile_image' => $path,
        ]);

        return redirect()->route('customers.index')->with('status', 'Customer created successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     * Uses Route Model Binding (Customer $customer).
     */
    public function edit(Customer $customer): View // <-- UPDATED: Using Route Model Binding
    {
        // The Customer instance is automatically fetched by Laravel
        return view('customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     * Uses Route Model Binding (Customer $customer).
     */
    public function update(CustomerStoreRequest $request, Customer $customer): RedirectResponse // <-- UPDATED: Using Form Request and Model Binding
    {
        // 1. Handle File Upload (Optional: Delete old image if new one is present)
        $path = $customer->profile_image; // Keep the old path by default
        
        if ($request->hasFile('profile_image')) {
            // Delete old file if it exists
            if ($customer->profile_image) {
                Storage::disk('public')->delete($customer->profile_image);
            }
            // Store the new file
            $path = $request->file('profile_image')->store('profile-images', 'public');
        }

        // 2. Update Customer
        $customer->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'profile_image' => $path,
        ]);

        return redirect()->route('customers.index')->with('status', 'Customer updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     * Uses Route Model Binding (Customer $customer).
     */
    public function destroy(Customer $customer): RedirectResponse // <-- UPDATED: Using Model Binding
    {
        // Soft deletes the customer (sets the deleted_at timestamp)
        $customer->delete();

        return redirect()->route('customers.index')->with('status', 'Customer deleted successfully (Soft Deleted)!');
    }
    
    // The show method is typically left empty unless required for dedicated viewing
    public function show(Customer $customer)
    {
        // Not required by current project scope, but included for completeness
    }
}