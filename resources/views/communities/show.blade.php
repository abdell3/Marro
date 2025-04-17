<x-layouts.app-layout>
    <div class="bg-white border-b">
        <div class="h-32 bg-gradient-to-r from-orange-400 to-orange-600 relative">
            @if($community->banner)
                <img src="{{ asset('storage/' . $community->banner) }}" alt="{{ $community->name }}" class="w-full h-full object-cover">
            @endif
        </div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="absolute -top-8 left-4 sm:left-6 lg:left-8 w-20 h-20 bg-white rounded-full border-4 border-white overflow-hidden">
                @if($community->icon)
                    <img src="{{ asset('storage/' . $community->icon) }}" alt="{{ $community->name }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full bg-orange-500 flex items-center justify-center text-white text-2xl font-bold">
                        {{ substr($community->name, 0, 1) }}
                    </div>
                @endif
            </div>
            
            <div class="flex items-end justify-between pt-4 pb-4">
                <div class="ml-24">
                    <h1 class="text-2xl font-bold">r/{{ $community->name }}</h1>
                    <p class="text-gray-500">{{ $community->users->count() }} members</p>
                </div>
                
                @auth
                    <div>
                        @if(Auth::user()->communities->contains($community->id))
                            <form action="{{ route('communities.leave', $community->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                                    Joined
                                </button>
                            </form>
                        @else
                            <form action="{{ route('communities.join', $community->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="px-4 py-2 bg-orange-500 text-white rounded-md hover:bg-orange-600">
                                    Join
                                </button>
                            </form>
                        @endif
                        
                        @if(Auth::user()->communities->contains($community->id))
                            <a href="{{ route('posts.create') }}" class="ml-2 px-4 py-2 bg-orange-500 text-white rounded-md hover:bg-orange-600">
                                Create Post
                            </a>
                        @endif
                    </div>
                @endauth
            </div>
        </div>
    </div>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row gap-6">
                <!-- Main Content -->
                <div class="md:w-2/3">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <h2 class="text-xl font-semibold mb-4">Posts in r/{{ $community->name }}</h2>
                            
                            @if(count($community->posts) > 0)
                                @foreach($community->posts as $post)
                                    <div class="mb-6 p-4 border border-gray-200 rounded-lg hover:shadow-md transition-shadow">
                                        <div class="flex">
                                            <!-- Voting -->
                                            <div class="flex flex-col items-center mr-4">
                                                <form action="{{ route('posts.upvote', $post->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="text-gray-500 hover:text-orange-500">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                                        </svg>
                                                    </button>
                                                </form>
                                                <span class="text-gray-700 font-medium">{{ $post->upvotes - $post->downvotes }}</span>
                                                <form action="{{ route('posts.downvote', $post->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="text-gray-500 hover:text-blue-500">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                            
                                            <!-- Post Content -->
                                            <div class="flex-1">
                                                <div class="flex items-center text-xs text-gray-500 mb-1">
                                                    <span>Posted by</span>
                                                    <a href="{{ route('posts.index', ['user_id' => $post->user->id]) }}" class="ml-1 hover:underline">
                                                        u/{{ $post->user->username ?? $post->user->name }}
                                                    </a>
                                                    <span class="mx-1">•</span>
                                                    <span>{{ $post->created_at->diffForHumans() }}</span>
                                                </div>
                                                
                                                <a href="{{ route('posts.show', $post->id) }}" class="block">
                                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $post->title }}</h3>
                                                    <div class="text-gray-700 mb-2">
                                                        {{ Str::limit(strip_tags($post->content), 200) }}
                                                    </div>
                                                </a>
                                                
                                                @if($post->tags->count() > 0)
                                                    <div class="flex flex-wrap gap-2 mb-2">
                                                        @foreach($post->tags as $tag)
                                                            <span class="px-2 py-1 bg-gray-100 text-xs rounded-full text-gray-600">
                                                                {{ $tag->name }}
                                                            </span>
                                                        @endforeach
                                                    </div>
                                                @endif
                                                
                                                <div class="flex items-center text-gray-500 text-sm mt-2">
                                                    <a href="{{ route('posts.show', $post->id) }}" class="flex items-center mr-4 hover:text-gray-700">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                                        </svg>
                                                        {{ $post->comments->count() }} Comments
                                                    </a>
                                                    
                                                    @auth
                                                        <a href="#" class="flex items-center mr-4 hover:text-gray-700">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                                                            </svg>
                                                            Save
                                                        </a>
                                                    @endauth
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-center py-8">
                                    <p class="text-gray-500">No posts in this community yet.</p>
                                    @auth
                                        @if(Auth::user()->communities->contains($community->id))
                                            <a href="{{ route('posts.create') }}" class="mt-4 inline-block px-4 py-2 bg-orange-500 text-white rounded-md hover:bg-orange-600">Create a Post</a>
                                        @else
                                            <form action="{{ route('communities.join', $community->id) }}" method="POST" class="mt-4">
                                                @csrf
                                                <button type="submit" class="px-4 py-2 bg-orange-500 text-white rounded-md hover:bg-orange-600">
                                                    Join to Post
                                                </button>
                                            </form>
                                        @endif
                                    @endauth
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Sidebar -->
                <div class="md:w-1/3">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <h2 class="text-lg font-semibold mb-4">About Community</h2>
                            <p class="text-gray-700 mb-4">{{ $community->description }}</p>
                            
                            <div class="flex items-center text-gray-500 mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>Created {{ $community->created_at->format('M d, Y') }}</span>
                            </div>
                            
                            <div class="border-t pt-4">
                                <div class="flex justify-between mb-2">
                                    <span class="text-gray-500">Members</span>
                                    <span class="font-semibold">{{ $community->users->count() }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Posts</span>
                                    <span class="font-semibold">{{ $community->posts->count() }}</span>
                                </div>
                            </div>
                            
                            @auth
                                <div class="mt-4 pt-4 border-t">
                                    @if(Auth::user()->communities->contains($community->id))
                                        <a href="{{ route('posts.create') }}" class="block w-full px-4 py-2 bg-orange-500 text-white text-center rounded-md hover:bg-orange-600">
                                            Create Post
                                        </a>
                                    @else
                                        <form action="{{ route('communities.join', $community->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="w-full px-4 py-2 bg-orange-500 text-white rounded-md hover:bg-orange-600">
                                                Join Community
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            @endauth
                        </div>
                    </div>
                    
                    @if($community->rules)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 bg-white border-b border-gray-200">
                                <h2 class="text-lg font-semibold mb-4">Community Rules</h2>
                                <div class="prose max-w-none">
                                    {!! nl2br(e($community->rules)) !!}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layouts.app-layout>