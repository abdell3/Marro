<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Reports') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    <div class="mb-6">
                        <form action="{{ route('admin.reports.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                            <div class="flex-1">
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search reports" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500">
                            </div>
                            <div class="w-full md:w-48">
                                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500">
                                    <option value="">All Statuses</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Resolved</option>
                                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                            </div>
                            <div class="w-full md:w-48">
                                <select name="type" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500">
                                    <option value="">All Types</option>
                                    @foreach($reportTypes as $type)
                                        <option value="{{ $type->id }}" {{ request('type') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <button type="submit" class="px-4 py-2 bg-orange-500 text-white rounded-md hover:bg-orange-600">
                                    Filter
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Reports Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead>
                                <tr>
                                    <th class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        ID
                                    </th>
                                    <th class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Type
                                    </th>
                                    <th class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Reported By
                                    </th>
                                    <th class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Date
                                    </th>
                                    <th class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reports as $report)
                                    <tr>
                                        <td class="py-4 px-4 border-b border-gray-200">
                                            <div class="text-sm text-gray-900">#{{ $report->id }}</div>
                                        </td>
                                        <td class="py-4 px-4 border-b border-gray-200">
                                            <div class="text-sm text-gray-900">{{ $report->reportType->name }}</div>
                                        </td>
                                        <td class="py-4 px-4 border-b border-gray-200">
                                            <div class="flex items-center">
                                                @if($report->user->avatar)
                                                    <img class="h-8 w-8 rounded-full mr-2" src="{{ asset('storage/' . $report->user->avatar) }}" alt="{{ $report->user->name }}">
                                                @else
                                                    <div class="h-8 w-8 rounded-full bg-orange-500 flex items-center justify-center text-white font-bold mr-2">
                                                        {{ substr($report->user->name, 0, 1) }}
                                                    </div>
                                                @endif
                                                <div class="text-sm font-medium text-gray-900">{{ $report->user->name }}</div>
                                            </div>
                                        </td>
                                        <td class="py-4 px-4 border-b border-gray-200">
                                            <span class="px-2 py-1 text-xs rounded-full 
                                                {{ $report->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                                   ($report->status === 'resolved' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
                                                {{ ucfirst($report->status) }}
                                            </span>
                                        </td>
                                        <td class="py-4 px-4 border-b border-gray-200">
                                            <div class="text-sm text-gray-900">{{ $report->created_at->format('M d, Y') }}</div>
                                            <div class="text-sm text-gray-500">{{ $report->created_at->diffForHumans() }}</div>
                                        </td>
                                        <td class="py-4 px-4 border-b border-gray-200">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('admin.reports.show', $report->id) }}" class="text-blue-500 hover:text-blue-700">
                                                    View
                                                </a>
                                                @if($report->status === 'pending')
                                                    <form action="{{ route('admin.reports.update-status', $report->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="resolved">
                                                        <button type="submit" class="text-green-500 hover:text-green-700">
                                                            Resolve
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('admin.reports.update-status', $report->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="rejected">
                                                        <button type="submit" class="text-red-500 hover:text-red-700">
                                                            Reject
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $reports->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>