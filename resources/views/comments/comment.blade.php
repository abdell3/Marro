<div class="border-l-2 border-gray-200 pl-4 mb-4">
    <div class="flex items-start gap-4">
        <div class="flex flex-col items-center">
            <form action="{{ route('comments.upvote', $comment->id) }}" method="POST">
                @csrf
                <button type="submit" class="text-gray-500 hover:text-orange-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                    </svg>
                </button>
            </form>
            <span class="text-gray-700 text-sm font-medium">{{ $comment->upvotes - $comment->downvotes }}</span>
            <form action="{{ route('comments.downvote', $comment->id) }}" method="POST">
                @csrf
                <button type="submit" class="text-gray-500 hover:text-blue-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
            </form>
        </div>
        
        <div class="flex-1">
            <div class="flex items-center text-xs text-gray-500 mb-1">
                <a href="{{ route('posts.index', ['user_id' => $comment->user->id]) }}" class="font-medium hover:underline">
                    {{ $comment->user->username ?? $comment->user->name }}
                </a>
                <span class="mx-1">•</span>
                <span>{{ $comment->created_at->diffForHumans() }}</span>
            </div>
            
            <div class="text-gray-700 mb-2">
                {!! nl2br(e($comment->content)) !!}
            </div>
            
            <div class="flex items-center text-xs text-gray-500">
                @auth
                    <button type="button" class="reply-button hover:text-gray-700" data-comment-id="{{ $comment->id }}">
                        Reply
                    </button>
                    
                    @if(Auth::id() === $comment->user_id)
                        <span class="mx-1">•</span>
                        <a href="{{ route('comments.edit', $comment->id) }}" class="hover:text-gray-700">
                            Edit
                        </a>
                        
                        <span class="mx-1">•</span>
                        <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700" onclick="return confirm('Are you sure you want to delete this comment?')">
                                Delete
                            </button>
                        </form>
                    @endif
                @endauth
            </div>
            
            <!-- Reply Form (Hidden by default) -->
            @auth
                <div id="reply-form-{{ $comment->id }}" class="mt-3 hidden">
                    <form action="{{ route('comments.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="post_id" value="{{ $comment->post_id }}">
                        <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                        <div class="mb-2">
                            <textarea name="content" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500" placeholder="What are your thoughts?"></textarea>
                        </div>
                        <div class="flex justify-end">
                            <button type="button" class="cancel-reply px-3 py-1 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 mr-2" data-comment-id="{{ $comment->id }}">
                                Cancel
                            </button>
                            <button type="submit" class="px-3 py-1 bg-orange-500 text-white rounded-md hover:bg-orange-600">
                                Reply
                            </button>
                        </div>
                    </form>
                </div>
            @endauth
            
            <!-- Replies -->
            @if($comment->replies->count() > 0)
                <div class="mt-4 space-y-4">
                    @foreach($comment->replies as $reply)
                        @include('comments.comment', ['comment' => $reply])
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>