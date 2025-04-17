<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-orange-500 bg-opacity-10">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h2 class="font-semibold text-xl text-gray-800">{{ $userCount }}</h2>
                                <p class="text-gray-500">Total Users</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-500 bg-opacity-10">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h2 class="font-semibold text-xl text-gray-800">{{ $postCount }}</h2>
                                <p class="text-gray-500">Total Posts</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-500 bg-opacity-10">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h2 class="font-semibold text-xl text-gray-800">{{ $communityCount }}</h2>
                                <p class="text-gray-500">Communities</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-red-500 bg-opacity-10">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h2 class="font-semibold text-xl text-gray-800">{{ $pendingReportsCount }}</h2>
                                <p class="text-gray-500">Pending Reports</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- User Growth Chart -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold mb-4">User Growth (Last 30 Days)</h3>
                        <canvas id="userGrowthChart" height="300"></canvas>
                    </div>
                </div>

                <!-- Post Activity Chart -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold mb-4">Post Activity (Last 30 Days)</h3>
                        <canvas id="postActivityChart" height="300"></canvas>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Top Communities -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold">Top Communities</h3>
                            <a href="{{ route('communities.index') }}" class="text-orange-500 hover:text-orange-700">View All</a>
                        </div>
                        <div class="space-y-4">
                            @foreach($topCommunities as $community)
                                <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg">
                                    <div class="flex items-center">
                                        @if($community->icon)
                                            <img src="{{ asset('storage/' . $community->icon) }}" alt="{{ $community->name }}" class="w-10 h-10 rounded-full mr-3">
                                        @else
                                            <div class="w-10 h-10 bg-orange-500 rounded-full flex items-center justify-center text-white font-bold mr-3">
                                                {{ substr($community->name, 0, 1) }}
                                            </div>
                                        @endif
                                        <div>
                                            <a href="{{ route('communities.show', $community->slug) }}" class="font-medium hover:text-orange-500">r/{{ $community->name }}</a>
                                            <p class="text-sm text-gray-500">{{ $community->users_count }} members</p>
                                        </div>
                                    </div>
                                    <a href="{{ route('communities.show', $community->slug) }}" class="text-blue-500 hover:text-blue-700">View</a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Recent Reports -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold">Recent Reports</h3>
                            <a href="{{ route('admin.reports.index') }}" class="text-orange-500 hover:text-orange-700">View All</a>
                        </div>
                        <div class="space-y-4">
                            @foreach($recentReports as $report)
                                <div class="p-3 border border-gray-200 rounded-lg">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <span class="inline-block px-2 py-1 text-xs rounded-full 
                                                {{ $report->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                                   ($report->status === 'resolved' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
                                                {{ ucfirst($report->status) }}
                                            </span>
                                            <p class="font-medium mt-1">{{ $report->reportType->name }}</p>
                                            <p class="text-sm text-gray-500">Reported by {{ $report->user->name }} • {{ $report->created_at->diffForHumans() }}</p>
                                        </div>
                                        <a href="{{ route('admin.reports.show', $report->id) }}" class="text-blue-500 hover:text-blue-700">View</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Admin Quick Links -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-8">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <a href="{{ route('admin.users.index') }}" class="p-4 border border-gray-200 rounded-lg hover:bg-gray-50 flex flex-col items-center text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-500 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            <span>Manage Users</span>
                        </a>
                        <a href="{{ route('admin.roles.index') }}" class="p-4 border border-gray-200 rounded-lg hover:bg-gray-50 flex flex-col items-center text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-500 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            <span>Manage Roles</span>
                        </a>
                        <a href="{{ route('admin.reports.index') }}" class="p-4 border border-gray-200 rounded-lg hover:bg-gray-50 flex flex-col items-center text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-500 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            <span>Manage Reports</span>
                        </a>
                        <a href="{{ route('admin.badges.index') }}" class="p-4 border border-gray-200 rounded-lg hover:bg-gray-50 flex flex-col items-center text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-500 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                            </svg>
                            <span>Manage Badges</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    @endpush
</x-app-layout>