<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Report Content') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('reports.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="reportable_type" value="{{ $reportableType }}">
                        <input type="hidden" name="reportable_id" value="{{ $reportableId }}">
                        
                        <div class="mb-4">
                            <label for="report_type_id" class="block text-sm font-medium text-gray-700 mb-1">Reason for Report</label>
                            <select id="report_type_id" name="report_type_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500">
                                <option value="">Select a reason</option>
                                @foreach($reportTypes as $reportType)
                                    <option value="{{ $reportType->id }}">{{ $reportType->name }}</option>
                                @endforeach
                            </select>
                            @error('report_type_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Additional Information (Optional)</label>
                            <textarea id="description" name="description" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500">{{ old('description') }}</textarea>
                            <p class="text-gray-500 text-xs mt-1">Please provide any additional details that will help our moderators understand the issue.</p>
                        </div>
                        
                        <div class="flex justify-end">
                            <a href="javascript:history.back()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 mr-2">
                                Cancel
                            </a>
                            <button type="submit" class="px-4 py-2 bg-orange-500 text-white rounded-md hover:bg-orange-600">
                                Submit Report
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>