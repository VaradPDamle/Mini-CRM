<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Customer;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\OrderStoreRequest; 
use Illuminate\Support\Facades\Storage; // Not used here, but good practice if files were involved

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $orders = Order::with('customer')->paginate(10);
        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        // Fetch all customers for the form dropdown
        $customers = Customer::select('id', 'name')->orderBy('name')->get();
        return view('orders.create', compact('customers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OrderStoreRequest $request): RedirectResponse
    {
        Order::create([
            'customer_id' => $request->customer_id,
            'order_number' => $request->order_number,
            'amount' => $request->amount,
            'status' => $request->status,
            'order_date' => $request->order_date,
        ]);

        return redirect()->route('orders.index')->with('status', 'Order created successfully!');
    }
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order): View // Uses Route Model Binding
    {
        // Fetch customers to populate the dropdown
        $customers = Customer::select('id', 'name')->orderBy('name')->get();

        // Pass the fetched Order and Customers list to the view
        return view('orders.edit', compact('order', 'customers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OrderStoreRequest $request, Order $order): RedirectResponse // Uses Form Request for validation
    {
        // Validation handled automatically by OrderStoreRequest
        
        $order->update([
            'customer_id' => $request->customer_id,
            'order_number' => $request->order_number,
            'amount' => $request->amount,
            'status' => $request->status,
            'order_date' => $request->order_date,
        ]);

        return redirect()->route('orders.index')->with('status', 'Order updated successfully!');
    }

    /**
     * Remove the specified resource from storage (Soft Delete).
     */
    public function destroy(Order $order): RedirectResponse // Uses Route Model Binding
    {
        // Soft deletes the order
        $order->delete();

        return redirect()->route('orders.index')->with('status', 'Order deleted successfully (Soft Deleted)!');
    }
    
    // The show method is typically left empty unless required for dedicated viewing
    public function show(Order $order)
    {
        // Not required by current project scope
    }
}