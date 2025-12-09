<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (session('status'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('status') }}</span>
                        </div>
                    @endif
                    
                    <h3 class="text-2xl font-semibold text-gray-800 mb-6">CRM Overview</h3>

                    {{-- STATS CARDS --}}
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                        
                        {{-- Total Customers --}}
                        <div class="bg-white overflow-hidden shadow-sm rounded-lg p-5 border-l-4 border-indigo-600">
                            <p class="text-sm font-medium text-gray-500">Total Customers</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalCustomers }}</p>
                        </div>

                        {{-- Total Orders --}}
                        <div class="bg-white overflow-hidden shadow-sm rounded-lg p-5 border-l-4 border-blue-600">
                            <p class="text-sm font-medium text-gray-500">Total Orders</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalOrders }}</p>
                        </div>

                        {{-- Total Revenue (Completed Orders) --}}
                        <div class="bg-white overflow-hidden shadow-sm rounded-lg p-5 border-l-4 border-green-600">
                            <p class="text-sm font-medium text-gray-500">Total Revenue (Completed)</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">₹{{ $formattedRevenue }}</p>
                        </div>

                        {{-- Total Pending Orders (Calculated simply in the controller or here) --}}
                        {{-- Note: For simplicity, we'll assume Pending is Total - Completed - Cancelled. If you updated the DashboardController, this may need adjustment based on how you calculated Pending Orders there. --}}
                        <div class="bg-white overflow-hidden shadow-sm rounded-lg p-5 border-l-4 border-yellow-600">
                            <p class="text-sm font-medium text-gray-500">Total Pending Orders</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">
                                {{ \App\Models\Order::where('status', 'Pending')->count() }}
                            </p>
                        </div>
                    </div>
                    
                    {{-- RECENT CUSTOMERS LIST --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                        <div class="p-6">
                            <h4 class="text-xl font-semibold text-gray-800 mb-4">Recent 5 Customers</h4>
                            
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Joined Date</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse ($recentCustomers as $customer)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $customer->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $customer->email }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $customer->created_at->format('M d, Y') }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                                            No recent customers found.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>