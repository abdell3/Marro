<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manage Badges') }}
            </h2>
            <a href="{{ route('admin.badges.create') }}" class="px-4 py-2 bg-orange-500 text-white rounded-md hover:bg-orange-600">
                Add New Badge
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Search -->
                    <div class="mb-6">
                        <form action="{{ route('admin.badges.index') }}" method="GET" class="flex">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search badges" class="flex-1 px-4 py-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-orange-500">
                            <button type="submit" class="px-4 py-2 bg-orange-500 text-white rounded-r-md hover:bg-orange-600">
                                Search
                            </button>
                        </form>
                    </div>
                    
                    <!-- Badges Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead>
                                <tr>
                                    <th class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Badge
                                    </th>
                                    <th class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Description
                                    </th>
                                    <th class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Users Count
                                    </th>
                                    <th class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($badges as $badge)
                                    <tr>
                                        <td class="py-4 px-4 border-b border-gray-200">
                                            <div class="flex items-center">
                                                @if($badge->icon)
                                                    <img src="{{ asset('storage/' . $badge->icon) }}" alt="{{ $badge->name }}" class="w-8 h-8 mr-3">
                                                @else
                                                    <div class="w-8 h-8 bg-orange-500 rounded-full flex items-center justify-center text-white font-bold mr-3">
                                                        {{ substr($badge->name, 0, 1) }}
                                                    </div>
                                                @endif
                                                <div class="text-sm font-medium text-gray-900">{{ $badge->name }}</div>
                                            </div>
                                        </td>
                                        <td class="py-4 px-4 border-b border-gray-200">
                                            <div class="text-sm text-gray-500">{{ Str::limit($badge->description, 50) }}</div>
                                        </td>
                                        <td class="py-4 px-4 border-b border-gray-200">
                                            <div class="text-sm text-gray-900">{{ $badge->users_count }}</div>
                                        </td>
                                        <td class="py-4 px-4 border-b border-gray-200">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('admin.badges.edit', $badge->id) }}" class="text-blue-500 hover:text-blue-700">
                                                    Edit
                                                </a>
                                                <a href="#" onclick="openAwardModal({{ $badge->id }} , '{{ $badge->name }}')" class="text-green-500 hover:text-green-700">
                                                    Award
                                                </a>
                                                <form action="{{ route('admin.badges.destroy', $badge->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:text-red-700" onclick="return confirm('Are you sure you want to delete this badge?')">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-6">
                        {{ $badges->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Award Badge Modal -->
    <div id="awardBadgeModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-orange-100 sm:mx-0 sm:h-10 sm:w-10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            Award Badge
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                Select a user to award the <span id="badgeName" class="font-medium"></span> badge to.
                            </p>
                            <form id="awardBadgeForm" action="{{ route('admin.badges.award') }}" method="POST" class="mt-4">
                                @csrf
                                <input type="hidden" name="badge_id" id="badgeId">
                                <div class="mb-4">
                                    <label for="user_id" class="block text-sm font-medium text-gray-700 mb-1">User</label>
                                    <select id="user_id" name="user_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500">
                                        <option value="">Select a user</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" onclick="submitAwardForm()" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-orange-500 text-base font-medium text-white hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 sm:ml-3 sm:w-auto sm:text-sm">
                    Award Badge
                </button>
                <button type="button" onclick="closeAwardModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Cancel
                </button>
            </div>
        </div>
    </div>
    
    @push('scripts')
    <script>
        function openAwardModal(badgeId, badgeName) {
            document.getElementById('badgeId').value = badgeId;
            document.getElementById('badgeName').textContent = badgeName;
            document.getElementById('awardBadgeModal').classList.remove('hidden');
        }
        
        function closeAwardModal() {
            document.getElementById('awardBadgeModal').classList.add('hidden');
        }
        
        function submitAwardForm() {
            document.getElementById('awardBadgeForm').submit();
        }
    </script>
    @endpush
</x-admin-layout>