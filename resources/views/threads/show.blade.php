<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Thread Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-6">
                        <div class="flex justify-between items-start">
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900">{{ $thread->title }}</h1>
                                <p class="text-sm text-gray-500 mt-1">
                                    in <a href="{{ route('communities.show', $thread->community->slug) }}" class="text-blue-500 hover:underline">r/{{ $thread->community->name }}</a>
                                    • Posted {{ $thread->created_at->diffForHumans() }}
                                </p>
                            </div>
                            
                            @can('update', $thread)
                                <div class="flex space-x-2">
                                    <a href="{{ route('threads.edit', $thread->id) }}" class="px-3 py-1 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                                        Edit
                                    </a>
                                    
                                    <form action="{{ route('threads.destroy', $thread->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded-md hover:bg-red-600" onclick="return confirm('Are you sure you want to delete this thread?')">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            @endcan
                        </div>
                        
                        <div class="mt-6 prose max-w-none">
                            {!! nl2br(e($thread->description)) !!}
                        </div>
                    </div>
                    
                    <div class="mt-8 border-t pt-6">
                        <h2 class="text-xl font-semibold mb-4">Posts in this Thread</h2>
                        
                        @if(count($thread->posts) > 0)
                            <div class="space-y-6">
                                @foreach($thread->posts as $post)
                                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                                        <div class="flex justify-between">
                                            <div>
                                                <a href="{{ route('posts.show', $post->id) }}" class="text-lg font-semibold hover:text-orange-500">
                                                    {{ $post->title }}
                                                </a>
                                                <p class="text-sm text-gray-500">
                                                    Posted by <a href="{{ route('posts.index', ['user_id' => $post->user->id]) }}" class="hover:underline">u/{{ $post->user->username ?? $post->user->name }}</a>
                                                    • {{ $post->created_at->diffForHumans() }}
                                                </p>
                                            </div>
                                            <div class="text-sm">
                                                <span class="text-green-500">{{ $post->upvotes }} upvotes</span>
                                                <span class="mx-1">•</span>
                                                <span class="text-red-500">{{ $post->downvotes }} downvotes</span>
                                            </div>
                                        </div>
                                        <p class="mt-2 text-gray-700">
                                            {{ Str::limit(strip_tags($post->content), 150) }}
                                        </p>
                                        <div class="mt-4 flex justify-between">
                                            <div class="flex items-center text-gray-500 text-sm">
                                                <a href="{{ route('posts.show', $post->id) }}" class="flex items-center hover:text-gray-700">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                                    </svg>
                                                    {{ $post->comments->count() }} Comments
                                                </a>
                                            </div>
                                            <a href="{{ route('posts.show', $post->id) }}" class="text-sm text-orange-500 hover:underline">
                                                View Post
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <p class="text-gray-500">No posts in this thread yet.</p>
                                @auth
                                    <a href="{{ route('posts.create') }}" class="mt-4 inline-block px-4 py-2 bg-orange-500 text-white rounded-md hover:bg-orange-600">Create a Post</a>
                                @endauth
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>