<?php

namespace App\Http\Controllers;

use App\Models\Customer; // Used for database interaction
use Illuminate\Http\Request; // <-- ESSENTIAL for search input
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\CustomerStoreRequest; // Used for automatic validation
use Illuminate\Support\Facades\Storage; // Used for deleting old profile images
use Maatwebsite\Excel\Facades\Excel; // <-- Import the Excel Facade
use App\Exports\CustomersExport; // <-- Import the Export class

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource with search and pagination.
     */
    public function index(Request $request): View // <-- Accepts the Request object
    {
        // Get the search term from the request (e.g., from the input field named 'search')
        $search = $request->input('search');

        // Start building the query
        $query = Customer::query();

        // If a search term is present, apply the 'where' clauses
        if ($search) {
            $query->where('name', 'LIKE', '%' . $search . '%')
                  ->orWhere('email', 'LIKE', '%' . $search . '%');
        }
        
        // Retrieve customers with pagination (e.g., 10 per page)
        // Apply the pagination to the filtered query (or the full query if no search)
        $customers = $query->paginate(10);
        
        // Pass the customers AND the search term back to the view
        return view('customers.index', compact('customers', 'search'));
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
     */
    public function edit(Customer $customer): View
    {
        return view('customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CustomerStoreRequest $request, Customer $customer): RedirectResponse
    {
        // 1. Handle File Upload (Optional: Delete old image if new one is present)
        $path = $customer->profile_image;
        
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
     */
    public function destroy(Customer $customer): RedirectResponse
    {
        // Soft deletes the customer (sets the deleted_at timestamp)
        $customer->delete();

        return redirect()->route('customers.index')->with('status', 'Customer deleted successfully (Soft Deleted)!');
    }
    
    /**
     * Download a CSV/Excel export of all customers.
     * This is the new method for Day 6.
     */
    public function export()
    {
        // Uses the Excel Facade to download data from the CustomersExport class
        return Excel::download(new CustomersExport, 'customers_list.csv');
    }

    /**
     * The show method is typically left empty unless required for dedicated viewing
     */
    public function show(Customer $customer)
    {
        // Not required by current project scope, but included for completeness
    }
}