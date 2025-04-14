<div class="bg-white rounded-md border overflow-hidden">
    <div class="flex">
        <div class="bg-gray-50 p-2 flex flex-col items-center">
            <button class="text-gray-500 hover:text-orange-500">
                <i class="fas fa-arrow-up"></i>
            </button>
            <span class="text-sm font-medium my-1">{{ $post->upvotes }}</span>
            <button class="text-gray-500 hover:text-blue-500">
                <i class="fas fa-arrow-down"></i>
            </button>
        </div>
        
        <div class="flex-1">
            <div class="p-3 pb-2">
                <div class="flex items-center text-sm text-gray-500">
                    <span class="font-medium text-black">m/{{ $post->community }}</span>
                    <span class="mx-1">•</span>
                    <span>Posted by u/{{ $post->author }}</span>
                    <span class="mx-1">•</span>
                    <span>{{ $post->created_at->diffForHumans() }}</span>
                </div>
                <h3 class="text-xl font-semibold leading-tight mt-1">{{ $post->title }}</h3>
            </div>
            
            <div class="px-3 pb-2">
                <p>{{ $post->content }}</p>
            </div>
            
            <div class="px-3 py-2 border-t flex space-x-2 text-gray-500">
                <button class="flex items-center space-x-1 px-2 py-1 rounded-md hover:bg-gray-100">
                    <i class="far fa-comment-alt"></i>
                    <span>{{ $post->comments_count }} Comments</span>
                </button>
                <button class="flex items-center space-x-1 px-2 py-1 rounded-md hover:bg-gray-100">
                    <i class="fas fa-share"></i>
                    <span>Share</span>
                </button>
                <button class="flex items-center space-x-1 px-2 py-1 rounded-md hover:bg-gray-100">
                    <i class="far fa-bookmark"></i>
                    <span>Save</span>
                </button>
                <button class="px-2 py-1 rounded-md hover:bg-gray-100">
                    <i class="fas fa-ellipsis-h"></i>
                </button>
            </div>
        </div>
    </div>
</div>