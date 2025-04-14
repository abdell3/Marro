<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Marro') }}</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased">
    <div class="relative min-h-screen bg-gray-100">
        <div class="bg-white shadow">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="flex-shrink-0 flex items-center">
                            <span class="text-2xl font-bold text-orange-500">Marro</span>
                        </div>
                    </div>
                    <div class="flex items-center">
                        @if (Route::has('login'))
                            <div class="space-x-4">
                                @auth
                                    <a href="{{ route('posts.index') }}" class="text-gray-700 hover:text-orange-500">Home</a>
                                @else
                                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-orange-500">Log in</a>

                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="ml-4 px-4 py-2 bg-orange-500 text-white rounded-md hover:bg-orange-600">Register</a>
                                    @endif
                                @endauth
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h1 class="text-4xl font-bold text-gray-900 mb-6">Welcome to Marro</h1>
                    <p class="text-xl text-gray-600 mb-8">Join our community to discuss, share, and connect with others.</p>
                    
                    <div class="flex justify-center space-x-4">
                        @auth
                            <a href="{{ route('posts.index') }}" class="px-6 py-3 bg-orange-500 text-white rounded-md hover:bg-orange-600">Browse Posts</a>
                            <a href="{{ route('communities.index') }}" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">Explore Communities</a>
                        @else
                            <a href="{{ route('register') }}" class="px-6 py-3 bg-orange-500 text-white rounded-md hover:bg-orange-600">Join Now</a>
                            <a href="{{ route('posts.index') }}" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">Browse as Guest</a>
                        @endauth
                    </div>
                </div>
                
                <div class="mt-16 grid gap-8 md:grid-cols-3">
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <div class="text-orange-500 text-3xl mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
                            </svg>
                        </div>
                        <h2 class="text-xl font-semibold mb-2">Join Discussions</h2>
                        <p class="text-gray-600">Participate in conversations about topics that interest you with like-minded individuals.</p>
                    </div>
                    
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <div class="text-orange-500 text-3xl mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <h2 class="text-xl font-semibold mb-2">Build Communities</h2>
                        <p class="text-gray-600">Create and grow your own communities around your interests, hobbies, or passions.</p>
                    </div>
                    
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <div class="text-orange-500 text-3xl mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                            </svg>
                        </div>
                        <h2 class="text-xl font-semibold mb-2">Share Content</h2>
                        <p class="text-gray-600">Share your thoughts, ideas, questions, and content with a supportive community.</p>
                    </div>
                </div>
                
                <div class="mt-16 text-center">
                    <h2 class="text-2xl font-semibold mb-6">Popular Communities</h2>
                    <div class="grid gap-4 md:grid-cols-4">
                        @foreach(\App\Models\Community::withCount('users')->orderBy('users_count', 'desc')->take(4)->get() as $community)
                            <a href="{{ route('communities.show', $community->slug) }}" class="bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition-shadow">
                                <div class="flex items-center justify-center mb-2">
                                    @if($community->icon)
                                        <img src="{{ asset('storage/' . $community->icon) }}" alt="{{ $community->name }}" class="w-12 h-12 rounded-full">
                                    @else
                                        <div class="w-12 h-12 bg-orange-500 rounded-full flex items-center justify-center text-white text-xl font-bold">
                                            {{ substr($community->name, 0, 1) }}
                                        </div>
                                    @endif
                                </div>
                                <h3 class="font-semibold">r/{{ $community->name }}</h3>
                                <p class="text-sm text-gray-500">{{ $community->users_count }} members</p>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        
        <footer class="bg-white mt-12 py-8 border-t">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center">
                    <div>
                        <span class="text-xl font-bold text-orange-500">Marro</span>
                        <p class="text-gray-500 text-sm mt-1">© {{ date('Y') }} Marro. All rights reserved.</p>
                    </div>
                    <div class="flex space-x-6">
                        <a href="#" class="text-gray-500 hover:text-orange-500">About</a>
                        <a href="#" class="text-gray-500 hover:text-orange-500">Terms</a>
                        <a href="#" class="text-gray-500 hover:text-orange-500">Privacy</a>
                        <a href="#" class="text-gray-500 hover:text-orange-500">Contact</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>