<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerApiController extends Controller
{
    public function __construct()
    {
        // 1. All API routes in this controller must have a valid Sanctum token.
        $this->middleware('auth:sanctum');
        
        // 2. RBAC Enforcement: Only users with the 'admin' role can perform
        // Create (store), Update, and Delete operations via the API.
        // This relies on your existing 'isAdmin' middleware.
        $this->middleware('isAdmin')->only(['store', 'update', 'destroy']);
    }

    // List all Customers (Accessible by any valid token holder)
    public function index()
    {
        // Return a simple paginated list of customers
        return response()->json(Customer::paginate(10));
    }

    // Show a specific Customer (Accessible by any valid token holder)
    public function show(Customer $customer)
    {
        // Return a single customer instance as JSON
        return response()->json($customer);
    }
    
    // Create a new Customer (Accessible only by Admin tokens)
    public function store(Request $request) {}
    
    // Update a Customer (Accessible only by Admin tokens)
    public function update(Request $request, Customer $customer) {}
    
    // Delete a Customer (Accessible only by Admin tokens)
    public function destroy(Customer $customer) {}
}