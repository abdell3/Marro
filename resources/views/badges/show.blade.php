<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Badge: ') }} {{ $badge->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex flex-col md:flex-row md:items-center">
                        <div class="flex justify-center md:justify-start mb-4 md:mb-0 md:mr-6">
                            @if($badge->icon)
                                <img src="{{ asset('storage/' . $badge->icon) }}" alt="{{ $badge->name }}" class="w-24 h-24">
                            @else
                                <div class="w-24 h-24 bg-orange-500 rounded-full flex items-center justify-center text-white text-3xl font-bold">
                                    {{ substr($badge->name, 0, 1) }}
                                </div>
                            @endif
                        </div>
                        
                        <div>
                            <h1 class="text-2xl font-bold">{{ $badge->name }}</h1>
                            <p class="text-gray-600 mt-2">{{ $badge->description }}</p>
                            <p class="text-sm text-gray-500 mt-4">{{ $badge->users->count() }} users have earned this badge</p>
                        </div>
                    </div>
                    
                    <div class="mt-10">
                        <h2 class="text-xl font-semibold mb-4">Users with this Badge</h2>
                        
                        @if($badge->users->count() > 0)
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                @foreach($badge->users as $user)
                                    <div class="flex items-center p-3 border border-gray-200 rounded-lg">
                                        <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center text-gray-700 font-semibold mr-3">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="font-medium">{{ $user->name }}</p>
                                            <p class="text-xs text-gray-500">{{ $user->username ?? '@' . strtolower(str_replace(' ', '', $user->name)) }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500">No users have earned this badge yet.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>