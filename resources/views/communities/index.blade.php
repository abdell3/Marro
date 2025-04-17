<x-layouts.app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Communities') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <a href="{{ route('communities.index') }}" class="text-gray-700 {{ !request()->has('popular') ? 'font-bold' : '' }}">
                                All Communities
                            </a>
                            <span class="mx-2">|</span>
                            <a href="{{ route('communities.index', ['popular' => true]) }}" class="text-gray-700 {{ request()->has('popular') ? 'font-bold' : '' }}">
                                Popular
                            </a>
                        </div>
                        
                        @auth
                            <a href="{{ route('communities.create') }}" class="px-4 py-2 bg-orange-500 text-white rounded-md hover:bg-orange-600">
                                Create Community
                            </a>
                        @endauth
                    </div>
                    
                    @if(count($communities) > 0)
                        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                            @foreach($communities as $community)
                                <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-md transition-shadow">
                                    <div class="h-24 bg-gradient-to-r from-orange-400 to-orange-600 relative">
                                        @if($community->banner)
                                            <img src="{{ asset('storage/' . $community->banner) }}" alt="{{ $community->name }}" class="w-full h-full object-cover">
                                        @endif
                                    </div>
                                    <div class="p-4 relative">
                                        <div class="absolute -top-8 left-4 w-16 h-16 bg-white rounded-full border-4 border-white overflow-hidden">
                                            @if($community->icon)
                                                <img src="{{ asset('storage/' . $community->icon) }}" alt="{{ $community->name }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full bg-orange-500 flex items-center justify-center text-white text-xl font-bold">
                                                    {{ substr($community->name, 0, 1) }}
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <div class="mt-8">
                                            <a href="{{ route('communities.show', $community->slug) }}" class="text-lg font-semibold hover:text-orange-500">
                                                r/{{ $community->name }}
                                            </a>
                                            <p class="text-gray-500 text-sm mt-1">{{ $community->users->count() }} members</p>
                                            <p class="text-gray-700 text-sm mt-2 line-clamp-2">{{ $community->description }}</p>
                                            
                                            @auth
                                                <div class="mt-4">
                                                    @if(Auth::user()->communities->contains($community->id))
                                                        <form action="{{ route('communities.leave', $community->id) }}" method="POST">
                                                            @csrf
                                                            <button type="submit" class="w-full px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                                                                Leave
                                                            </button>
                                                        </form>
                                                    @else
                                                        <form action="{{ route('communities.join', $community->id) }}" method="POST">
                                                            @csrf
                                                            <button type="submit" class="w-full px-4 py-2 bg-orange-500 text-white rounded-md hover:bg-orange-600">
                                                                Join
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            @endauth
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="mt-6">
                            {{ $communities->links() }}
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-500">No communities found.</p>
                            @auth
                                <a href="{{ route('communities.create') }}" class="mt-4 inline-block px-4 py-2 bg-orange-500 text-white rounded-md hover:bg-orange-600">Create a Community</a>
                            @endauth
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layouts.app-layout>