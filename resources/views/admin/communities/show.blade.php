<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Community Details') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('communities.show', $community->slug) }}" target="_blank" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                    Visit Community
                </a>
                <form action="{{ route('admin.communities.destroy', $community->id) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600" onclick="return confirm('Are you sure you want to delete this community? This will also delete all posts and comments within this community.')">
                        Delete Community
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex items-center mb-6">
                        @if($community->icon)
                            <img src="{{ asset('storage/' . $community->icon) }}" alt="{{ $community->name }}" class="w-16 h-16 rounded-full mr-4">
                        @else
                            <div class="w-16 h-16 bg-orange-500 rounded-full flex items-center justify-center text-white text-2xl font-bold mr-4">
                                {{ substr($community->name, 0, 1) }}
                            </div>
                        @endif
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">r/{{ $community->name }}</h1>
                            <p class="text-gray-500">Created {{ $community->created_at->format('M d, Y') }} by 
                                <a href="{{ route('admin.users.show', $community->user_id) }}" class="text-blue-500 hover:text-blue-700">
                                    {{ $community->user->name }}
                                </a>
                            </p>
                        </div>
                    </div>
                    
                    <div class="mb-6">
                        <h2 class="text-lg font-semibold mb-2">Description</h2>
                        <p class="text-gray-700">{{ $community->description }}</p>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div class="bg-gray-50 p-4 rounded-lg text-center">
                            <div class="text-2xl font-bold text-orange-500">{{ $community->users_count }}</div>
                            <div class="text-gray-500">Members</div>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg text-center">
                            <div class="text-2xl font-bold text-orange-500">{{ $community->posts_count }}</div>
                            <div class="text-gray-500">Posts</div>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg text-center">
                            <div class="text-2xl font-bold text-orange-500">{{ $community->created_at->diffForHumans(null, true) }}</div>
                            <div class="text-gray-500">Age</div>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h2 class="text-lg font-semibold mb-4">Recent Posts</h2>
                            @if($community->posts->count() > 0)
                                <div class="space-y-4">
                                    @foreach($community->posts->take(5) as $post)
                                        <div class="border border-gray-200 rounded-lg p-3 hover:shadow-sm">
                                            <a href="{{ route('posts.show', $post->id) }}" class="font-medium hover:text-orange-500">
                                                {{ $post->title }}
                                            </a>
                                            <p class="text-sm text-gray-500">
                                                Posted by {{ $post->user->name }} • {{ $post->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-500">No posts yet</p>
                            @endif
                        </div>
                        
                        <div>
                            <h2 class="text-lg font-semibold mb-4">Top Members</h2>
                            @if($community->users->count() > 0)
                                <div class="space-y-4">
                                    @foreach($community->users->take(5) as $user)
                                        <div class="flex items-center border border-gray-200 rounded-lg p-3 hover:shadow-sm">
                                            @if($user->avatar)
                                                <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" class="w-8 h-8 rounded-full mr-3">
                                            @else
                                                <div class="w-8 h-8 bg-orange-500 rounded-full flex items-center justify-center text-white font-bold mr-3">
                                                    {{ substr($user->name, 0, 1) }}
                                                </div>
                                            @endif
                                            <div>
                                                <a href="{{ route('admin.users.show', $user->id) }}" class="font-medium hover:text-orange-500">
                                                    {{ $user->name }}
                                                </a>
                                                <p class="text-xs text-gray-500">Joined {{ $user->pivot->created_at->diffForHumans() }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-500">No members yet</p>
                            @endif
                        </div>
                    </div>
                    
                    <div class="mt-6">
                        <a href="{{ route('admin.communities.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                            Back to Communities
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>