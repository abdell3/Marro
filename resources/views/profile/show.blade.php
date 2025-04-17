<x-layouts.app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Profile') }}
        </h2>
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
                    <div class="flex flex-col md:flex-row">
                        <div class="md:w-1/3 flex flex-col items-center p-4">
                            @if($user->avatar)
                                <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" class="w-32 h-32 rounded-full object-cover">
                            @else
                                <div class="w-32 h-32 bg-orange-500 rounded-full flex items-center justify-center text-white text-4xl font-bold">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                            @endif
                            
                            <h1 class="text-2xl font-bold mt-4">{{ $user->name }}</h1>
                            <p class="text-gray-500">u/{{ $user->username }}</p>
                            
                            <div class="mt-4 flex flex-col space-y-2 w-full">
                                <a href="{{ route('profile.edit') }}" class="w-full px-4 py-2 bg-orange-500 text-white text-center rounded-md hover:bg-orange-600">
                                    Edit Profile
                                </a>
                                <a href="{{ route('profile.password') }}" class="w-full px-4 py-2 bg-gray-200 text-gray-700 text-center rounded-md hover:bg-gray-300">
                                    Change Password
                                </a>
                                <a href="{{ route('profile.delete') }}" class="w-full px-4 py-2 bg-red-500 text-white text-center rounded-md hover:bg-red-600">
                                    Delete Account
                                </a>
                            </div>
                        </div>
                        
                        <div class="md:w-2/3 p-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <h2 class="text-lg font-semibold mb-2">Account Information</h2>
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <div class="mb-4">
                                            <p class="text-sm text-gray-500">Email</p>
                                            <p class="font-medium">{{ $user->email }}</p>
                                        </div>
                                        <div class="mb-4">
                                            <p class="text-sm text-gray-500">Username</p>
                                            <p class="font-medium">{{ $user->username }}</p>
                                        </div>
                                        <div class="mb-4">
                                            <p class="text-sm text-gray-500">Phone</p>
                                            <p class="font-medium">{{ $user->phone ?? 'Not provided' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Member Since</p>
                                            <p class="font-medium">{{ $user->created_at->format('F d, Y') }}</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div>
                                    <h2 class="text-lg font-semibold mb-2">Personal Information</h2>
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <div class="mb-4">
                                            <p class="text-sm text-gray-500">Location</p>
                                            <p class="font-medium">{{ $user->location ?? 'Not provided' }}</p>
                                        </div>
                                        <div class="mb-4">
                                            <p class="text-sm text-gray-500">Website</p>
                                            @if($user->website)
                                                <a href="{{ $user->website }}" target="_blank" class="font-medium text-blue-500 hover:text-blue-700">
                                                    {{ $user->website }}
                                                </a>
                                            @else
                                                <p class="font-medium">Not provided</p>
                                            @endif
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Bio</p>
                                            <p class="font-medium">{{ $user->bio ?? 'No bio provided' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-6">
                                <h2 class="text-lg font-semibold mb-2">Badges</h2>
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    @if($user->badges->count() > 0)
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($user->badges as $badge)
                                                <div class="flex items-center bg-white p-2 rounded-md border border-gray-200">
                                                    @if($badge->icon)
                                                        <img src="{{ asset('storage/' . $badge->icon) }}" alt="{{ $badge->name }}" class="w-6 h-6 mr-2">
                                                    @else
                                                        <div class="w-6 h-6 bg-orange-500 rounded-full flex items-center justify-center text-white text-xs font-bold mr-2">
                                                            {{ substr($badge->name, 0, 1) }}
                                                        </div>
                                                    @endif
                                                    <span class="text-sm font-medium">{{ $badge->name }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="text-gray-500">No badges earned yet</p>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="mt-6">
                                <h2 class="text-lg font-semibold mb-2">Communities</h2>
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    @if($user->communities->count() > 0)
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                                            @foreach($user->communities as $community)
                                                <a href="{{ route('communities.show', $community->slug) }}" class="flex items-center bg-white p-2 rounded-md border border-gray-200 hover:border-orange-500">
                                                    @if($community->icon)
                                                        <img src="{{ asset('storage/' . $community->icon) }}" alt="{{ $community->name }}" class="w-6 h-6 mr-2">
                                                    @else
                                                        <div class="w-6 h-6 bg-orange-500 rounded-full flex items-center justify-center text-white text-xs font-bold mr-2">
                                                            {{ substr($community->name, 0, 1) }}
                                                        </div>
                                                    @endif
                                                    <span class="text-sm font-medium">r/{{ $community->name }}</span>
                                                </a>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="text-gray-500">Not a member of any communities yet</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app-layout>