<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Customer;
use Illuminate\View\View;
use Illuminate\Http\Request; 
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\OrderStoreRequest; 
use Illuminate\Support\Facades\Storage; 
use App\Models\User; // <-- Used to find the Admin user
use App\Notifications\NewOrderNotification; // <-- Used to send the email notification

class OrderController extends Controller
{
    /**
     * Display a listing of the resource with status filtering and pagination.
     */
    public function index(Request $request): View 
    {
        $statusFilter = $request->input('status');
        $query = Order::with('customer');

        if ($statusFilter && in_array($statusFilter, ['Pending', 'Completed', 'Cancelled'])) {
            $query->where('status', $statusFilter);
        }
        
        $orders = $query->paginate(10);
        
        return view('orders.index', compact('orders', 'statusFilter'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $customers = Customer::select('id', 'name')->orderBy('name')->get();
        return view('orders.create', compact('customers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OrderStoreRequest $request): RedirectResponse
    {
        // 1. Create the Order
        $order = Order::create([
            'customer_id' => $request->customer_id,
            'order_number' => $request->order_number,
            'amount' => $request->amount,
            'status' => $request->status,
            'order_date' => $request->order_date,
        ]);

        // 2. Find Admin Users
        // We look up all users with the role 'admin'
        $adminUsers = User::where('role', 'admin')->get();

        // 3. Send Notification to Admins
        // Wrap in try/catch so mail transport failures do not break order creation.
        foreach ($adminUsers as $admin) {
            try {
                $admin->notify(new NewOrderNotification($order));
            } catch (\Throwable $e) {
                // Log the error for debugging, but do not show detailed failure info to the user
                report($e);
            }
        }

        // 4. Redirect with a standard success message (silent notification failures)
        return redirect()->route('orders.index')->with('status', 'Order created successfully!');
    }
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order): View
    {
        $customers = Customer::select('id', 'name')->orderBy('name')->get();
        return view('orders.edit', compact('order', 'customers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OrderStoreRequest $request, Order $order): RedirectResponse
    {
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
    public function destroy(Order $order): RedirectResponse
    {
        $order->delete();

        return redirect()->route('orders.index')->with('status', 'Order deleted successfully (Soft Deleted)!');
    }
    
    public function show(Order $order)
    {
        // Not required by current project scope
    }
}