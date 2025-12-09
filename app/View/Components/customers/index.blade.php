<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Customer Management
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

                    {{-- SEARCH FORM and ADD NEW CUSTOMER BUTTON --}}
                    <div class="flex justify-between items-center mb-4">
                        
                        <form method="GET" action="{{ route('customers.index') }}" class="flex items-center space-x-2">
                            <input type="text" name="search" placeholder="Search by name or email..." 
                                   value="{{ $search ?? '' }}" 
                                   class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-80">
                            
                            {{-- Using a simple button for search --}}
                            <x-primary-button type="submit">Search</x-primary-button>
                            
                            {{-- Clear button only appears if a search is active --}}
                            @if(isset($search) && $search)
                                <a href="{{ route('customers.index') }}" class="text-gray-500 hover:text-gray-700">Clear</a>
                            @endif
                        </form>

                        <a href="{{ route('customers.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                            Add New Customer
                        </a>
                    </div>
                    {{-- END SEARCH FORM and BUTTONS --}}


                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($customers as $customer)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $customer->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $customer->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $customer->phone }}</td>
                                
                                {{-- ACTIONS COLUMN START (Includes Edit and RBAC Delete) --}}
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium flex items-center space-x-2">
                                    
                                    {{-- Edit Link --}}
                                    <a href="{{ route('customers.edit', $customer) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                    
                                    {{-- RBAC Check: Delete button only visible to Admin --}}
                                    @if (Auth::user()->role === 'admin')
                                        <form method="POST" action="{{ route('customers.destroy', $customer) }}" onsubmit="return confirm('Are you sure you want to delete {{ $customer->name }}? This action cannot be undone.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 text-sm ml-2">Delete</button>
                                        </form>
                                    @endif
                                </td>
                                {{-- ACTIONS COLUMN END --}}
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                                    No customers found.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{-- UPDATED PAGINATION LINKS: Appends the search query to maintain filter on page change --}}
                    <div class="mt-4">
                        {{ $customers->appends(['search' => $search ?? ''])->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>