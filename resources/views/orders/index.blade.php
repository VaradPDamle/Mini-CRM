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

                    {{-- Button to add new order --}}
                    <div class="flex justify-end mb-4">
                        <a href="{{ route('orders.create') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            Add New Order
                        </a>
                    </div>

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
                                <td class="px-6 py-4 whitespace-nowrap text-right">**${{ number_format($order->amount, 2) }}**</td>
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

                    {{-- Pagination --}}
                    <div class="mt-4">
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>