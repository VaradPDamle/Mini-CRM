<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Order Management
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    {{-- Display Session Status/Success Messages --}}
                    @if (session('status'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('status') }}</span>
                        </div>
                    @endif

                    {{-- FILTER FORM and ADD NEW ORDER/EXPORT BUTTONS --}}
                    <div class="flex justify-between items-center mb-4">
                        
                        {{-- Order Status Filter Form --}}
                        <form method="GET" action="{{ route('orders.index') }}" class="flex items-center space-x-2">
                            <label for="status-filter" class="text-sm font-medium text-gray-700">Filter by Status:</label>
                            <select id="status-filter" name="status" onchange="this.form.submit()" 
                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                
                                <option value="">All Orders</option>
                                {{-- $statusFilter is passed from the controller, checks for active filter --}}
                                @foreach(['Pending', 'Completed', 'Cancelled'] as $statusOption)
                                    <option value="{{ $statusOption }}" {{ (isset($statusFilter) && $statusFilter === $statusOption) ? 'selected' : '' }}>
                                        {{ $statusOption }}
                                    </option>
                                @endforeach
                            </select>
                            
                            @if(isset($statusFilter) && $statusFilter)
                                {{-- Button to clear filter if one is active --}}
                                <a href="{{ route('orders.index') }}" class="text-gray-500 hover:text-gray-700">Clear Filter</a>
                            @endif
                        </form>

                        {{-- Export and Add New Order Buttons (UPDATED SECTION) --}}
                        <div class="flex space-x-2">
                            
                            {{-- Export Orders Button (NEW ADDITION) --}}
                            <a href="{{ route('orders.export') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                                Export Orders (CSV)
                            </a>

                            {{-- Add New Order Button (existing) --}}
                            <a href="{{ route('orders.create') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                Add New Order
                            </a>
                        </div>
                    </div>
                    {{-- END FILTER FORM and BUTTONS --}}


                    {{-- Order Listing Table --}}
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order #</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($orders as $order)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $order->order_number }}</td>
                                {{-- Access Customer Name via the eager-loaded relationship --}}
                                <td class="px-6 py-4 whitespace-nowrap">{{ $order->customer->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $order->order_date }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">₹{{ number_format($order->amount, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{-- Status Badge Styling --}}
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @if ($order->status === 'Completed') bg-green-100 text-green-800 
                                        @elseif ($order->status === 'Pending') bg-yellow-100 text-yellow-800 
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ $order->status }}
                                    </span>
                                </td>
                                
                                {{-- ACTIONS COLUMN START (Includes Edit and RBAC Delete) --}}
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    {{-- Edit Link (Points to OrderController@edit) --}}
                                    <a href="{{ route('orders.edit', $order) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>

                                    {{-- RBAC CHECK: Delete button only visible to Admin --}}
                                    @if (Auth::user()->role === 'admin')
                                        <form method="POST" action="{{ route('orders.destroy', $order) }}" 
                                            onsubmit="return confirm('Are you sure you want to delete Order #{{ $order->order_number }}? This will soft delete the record.');" 
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 text-sm">Delete</button>
                                        </form>
                                    @endif
                                </td>
                                {{-- ACTIONS COLUMN END --}}
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                                    No orders found. Use the "Add New Order" button to start.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{-- Pagination (CRUCIAL: Appends the filter query) --}}
                    <div class="mt-4">
                        {{ $orders->appends(['status' => $statusFilter ?? ''])->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>