<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Threads') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold">All Threads</h3>
                        
                        @auth
                            <a href="{{ route('threads.create') }}" class="px-4 py-2 bg-orange-500 text-white rounded-md hover:bg-orange-600">
                                Create Thread
                            </a>
                        @endauth
                    </div>
                    
                    @if(count($threads) > 0)
                        <div class="space-y-6">
                            @foreach($threads as $thread)
                                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                                    <div class="flex justify-between">
                                        <div>
                                            <a href="{{ route('threads.show', $thread->id) }}" class="text-lg font-semibold hover:text-orange-500">
                                                {{ $thread->title }}
                                            </a>
                                            <p class="text-sm text-gray-500">
                                                in <a href="{{ route('communities.show', $thread->community->slug) }}" class="text-blue-500 hover:underline">r/{{ $thread->community->name }}</a>
                                            </p>
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ $thread->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                    <p class="mt-2 text-gray-700">
                                        {{ Str::limit($thread->description, 150) }}
                                    </p>
                                    <div class="mt-4 flex justify-end">
                                        <a href="{{ route('threads.show', $thread->id) }}" class="text-sm text-orange-500 hover:underline">
                                            View Thread
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="mt-6">
                            {{ $threads->links() }}
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-500">No threads found.</p>
                            @auth
                                <a href="{{ route('threads.create') }}" class="mt-4 inline-block px-4 py-2 bg-orange-500 text-white rounded-md hover:bg-orange-600">Create a Thread</a>
                            @endauth
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>