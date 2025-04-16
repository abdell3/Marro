<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Badges') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @foreach($badges as $badge)
                            <a href="{{ route('badges.show', $badge->id) }}" class="block p-6 border border-gray-200 rounded-lg hover:shadow-md transition-shadow text-center">
                                <div class="flex justify-center mb-4">
                                    @if($badge->icon)
                                        <img src="{{ asset('storage/' . $badge->icon) }}" alt="{{ $badge->name }}" class="w-16 h-16">
                                    @else
                                        <div class="w-16 h-16 bg-orange-500 rounded-full flex items-center justify-center text-white text-xl font-bold">
                                            {{ substr($badge->name, 0, 1) }}
                                        </div>
                                    @endif
                                </div>
                                <h3 class="text-lg font-semibold">{{ $badge->name }}</h3>
                                <p class="text-sm text-gray-500 mt-1">{{ $badge->description }}</p>
                                <p class="text-xs text-gray-400 mt-2">{{ $badge->users->count() }} users have this badge</p>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>