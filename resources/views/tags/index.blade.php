<x-layouts.app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tags') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold">All Tags</h3>
                        
                        @can('admin')
                            <a href="{{ route('tags.create') }}" class="px-4 py-2 bg-orange-500 text-white rounded-md hover:bg-orange-600">
                                Create Tag
                            </a>
                        @endcan
                    </div>
                    
                    @if(count($tags) > 0)
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            @foreach($tags as $tag)
                                <a href="{{ route('admin.tags.show', $tag->slug) }}" class="block p-4 border border-gray-200 rounded-lg hover:shadow-md transition-shadow">
                                    <h4 class="font-semibold text-lg">{{ $tag->name }}</h4>
                                    <p class="text-sm text-gray-500">{{ $tag->posts->count() }} posts</p>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-500">No tags found.</p>
                            @can('admin')
                                <a href="{{ route('admin.tags.create') }}" class="mt-4 inline-block px-4 py-2 bg-orange-500 text-white rounded-md hover:bg-orange-600">Create a Tag</a>
                            @endcan
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layouts.app-layout>