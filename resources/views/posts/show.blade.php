<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Post Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
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
                            <div class="flex items-center text-xs text-gray-500 mb-2">
                                <a href="{{ route('communities.show', $post->community->slug) }}" class="font-medium text-blue-500 hover:underline">
                                    r/{{ $post->community->name }}
                                </a>
                                <span class="mx-1">•</span>
                                <span>Posted by</span>
                                <a href="{{ route('posts.index', ['user_id' => $post->user->id]) }}" class="ml-1 hover:underline">
                                    u/{{ $post->user->username ?? $post->user->name }}
                                </a>
                                <span class="mx-1">•</span>
                                <span>{{ $post->created_at->diffForHumans() }}</span>
                            </div>
                            
                            <h1 class="text-2xl font-bold text-gray-900 mb-4">{{ $post->title }}</h1>
                            
                            <div class="prose max-w-none mb-6">
                                {!! nl2br(e($post->content)) !!}
                            </div>
                            
                            @if($post->tags->count() > 0)
                                <div class="flex flex-wrap gap-2 mb-4">
                                    @foreach($post->tags as $tag)
                                        <span class="px-2 py-1 bg-gray-100 text-xs rounded-full text-gray-600">
                                            {{ $tag->name }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif
                            
                            <div class="flex items-center text-gray-500 text-sm mt-4 border-t pt-4">
                                @auth
                                    <a href="#" class="flex items-center mr-4 hover:text-gray-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                                        </svg>
                                        Save
                                    </a>
                                    
                                    @if(Auth::id() === $post->user_id)
                                        <a href="{{ route('posts.edit', $post->id) }}" class="flex items-center mr-4 hover:text-gray-700">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            Edit
                                        </a>
                                        
                                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="flex items-center text-red-500 hover:text-red-700" onclick="return confirm('Are you sure you want to delete this post?')">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                Delete
                                            </button>
                                        </form>
                                    @endif
                                @endauth
                            </div>
                        </div>
                    </div>
                    
                    <!-- Comments Section -->
                    <div class="mt-8">
                        <h3 class="text-lg font-semibold mb-4">{{ $post->comments->count() }} Comments</h3>
                        
                        @auth
                            <div class="mb-6">
                                <form action="{{ route('comments.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                                    <div class="mb-4">
                                        <textarea name="content" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500" placeholder="What are your thoughts?"></textarea>
                                    </div>
                                    <div class="flex justify-end">
                                        <button type="submit" class="px-4 py-2 bg-orange-500 text-white rounded-md hover:bg-orange-600">
                                            Comment
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @else
                            <div class="mb-6 p-4 bg-gray-50 rounded-md">
                                <p class="text-gray-600">
                                    <a href="{{ route('login') }}" class="text-blue-500 hover:underline">Log in</a> or 
                                    <a href="{{ route('register') }}" class="text-blue-500 hover:underline">sign up</a> 
                                    to leave a comment
                                </p>
                            </div>
                        @endauth
                        
                        <div class="space-y-6">
                            @forelse($post->comments->where('parent_id', null) as $comment)
                                @include('comments.comment', ['comment' => $comment])
                            @empty
                                <p class="text-gray-500 text-center py-4">No comments yet. Be the first to comment!</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>