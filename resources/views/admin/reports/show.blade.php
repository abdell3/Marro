<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Report Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">Report #{{ $report->id }}</h1>
                            <p class="text-gray-500">{{ $report->created_at->format('F d, Y \a\t h:i A') }}</p>
                        </div>
                        <span class="px-3 py-1 text-sm rounded-full 
                            {{ $report->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                               ($report->status === 'resolved' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
                            {{ ucfirst($report->status) }}
                        </span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h2 class="text-lg font-semibold mb-2">Report Information</h2>
                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Type:</span>
                                    <span>{{ $report->reportType->name }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Reported By:</span>
                                    <a href="{{ route('admin.users.show', $report->user_id) }}" class="text-blue-500 hover:text-blue-700">
                                        {{ $report->user->name }}
                                    </a>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Status:</span>
                                    <span>{{ ucfirst($report->status) }}</span>
                                </div>
                                @if($report->resolved_at)
                                    <div class="flex justify-between">
                                        <span class="text-gray-500">Resolved At:</span>
                                        <span>{{ $report->resolved_at->format('M d, Y h:i A') }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h2 class="text-lg font-semibold mb-2">Reported Content</h2>
                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Content Type:</span>
                                    <span>{{ ucfirst($report->reportable_type) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Content ID:</span>
                                    <span>#{{ $report->reportable_id }}</span>
                                </div>
                                @if($report->reportable)
                                    <div class="mt-2">
                                        <a href="{{ $contentUrl }}" class="text-blue-500 hover:text-blue-700">
                                            View Reported Content
                                        </a>
                                    </div>
                                @else
                                    <div class="mt-2 text-red-500">
                                        Content has been deleted
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h2 class="text-lg font-semibold mb-2">Report Description</h2>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-gray-700">{{ $report->description }}</p>
                        </div>
                    </div>

                    @if($report->status === 'pending')
                        <div class="flex space-x-4 mb-6">
                            <form action="{{ route('admin.reports.update-status', $report->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="resolved">
                                <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">
                                    Mark as Resolved
                                </button>
                            </form>
                            <form action="{{ route('admin.reports.update-status', $report->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="rejected">
                                <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">
                                    Reject Report
                                </button>
                            </form>
                        </div>
                    @endif

                    <div class="flex justify-between">
                        <a href="{{ route('admin.reports.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                            Back to Reports
                        </a>
                        <form action="{{ route('admin.reports.destroy', $report->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600" onclick="return confirm('Are you sure you want to delete this report?')">
                                Delete Report
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>