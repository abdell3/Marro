<x-layouts.app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Saved Posts') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if(count($savedPosts) > 0)
                        <div class="space-y-6">
                            @foreach($savedPosts as $savedPost)
                                <div class="flex border border-gray-200 rounded-lg hover:shadow-md transition-shadow">
                                    <!-- Voting -->
                                    <div class="flex flex-col items-center p-4 bg-gray-50 rounded-l-lg">
                                        <form action="{{ route('posts.upvote', $savedPost->post->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="text-gray-500 hover:text-orange-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                                </svg>
                                            </button>
                                        </form>
                                        <span class="text-gray-700 font-medium">{{ $savedPost->post->upvotes - $savedPost->post->downvotes }}</span>
                                        <form action="{{ route('posts.downvote', $savedPost->post->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="text-gray-500 hover:text-blue-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                    
                                    <!-- Post Content -->
                                    <div class="flex-1 p-4">
                                        <div class="flex items-center text-xs text-gray-500 mb-1">
                                            <a href="{{ route('communities.show', $savedPost->post->community->slug) }}" class="font-medium text-blue-500 hover:underline">
                                                r/{{ $savedPost->post->community->name }}
                                            </a>
                                            <span class="mx-1">•</span>
                                            <span>Posted by</span>
                                            <a href="{{ route('posts.index', ['user_id' => $savedPost->post->user->id]) }}" class="ml-1 hover:underline">
                                                u/{{ $savedPost->post->user->username ?? $savedPost->post->user->name }}
                                            </a>
                                            <span class="mx-1">•</span>
                                            <span>{{ $savedPost->post->created_at->diffForHumans() }}</span>
                                            <span class="mx-1">•</span>
                                            <span class="mx-1">•</span>
                                            <span>Saved {{ $savedPost->created_at->diffForHumans() }}</span>
                                        </div>
                                        
                                        <a href="{{ route('posts.show', $savedPost->post->id) }}" class="block">
                                            <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $savedPost->post->title }}</h3>
                                            <div class="text-gray-700 mb-2">
                                                {{ Str::limit(strip_tags($savedPost->post->content), 200) }}
                                            </div>
                                        </a>
                                        
                                        @if($savedPost->post->tags->count() > 0)
                                            <div class="flex flex-wrap gap-2 mb-2">
                                                @foreach($savedPost->post->tags as $tag)
                                                    <span class="px-2 py-1 bg-gray-100 text-xs rounded-full text-gray-600">
                                                        {{ $tag->name }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        @endif
                                        
                                        <div class="flex items-center justify-between text-gray-500 text-sm mt-2">
                                            <div class="flex items-center">
                                                <a href="{{ route('posts.show', $savedPost->post->id) }}" class="flex items-center mr-4 hover:text-gray-700">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                                    </svg>
                                                    {{ $savedPost->post->comments->count() }} Comments
                                                </a>
                                            </div>
                                            
                                            <form action="{{ route('saved-posts.destroy', $savedPost->post->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700">
                                                    Unsave
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="mt-6">
                            {{ $savedPosts->links() }}
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-500">You haven't saved any posts yet.</p>
                            <a href="{{ route('posts.index') }}" class="mt-4 inline-block px-4 py-2 bg-orange-500 text-white rounded-md hover:bg-orange-600">Browse Posts</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layouts.app-layout>