@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <h1 class="text-3xl font-bold mb-6">Dashboard</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-lg border p-4">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-sm font-medium text-gray-500">Total Users</h3>
                <i class="fas fa-users text-gray-400"></i>
            </div>
            <div class="text-2xl font-bold">{{ number_format($totalUsers) }}</div>
            
        </div>
        
        <div class="bg-white rounded-lg border p-4">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-sm font-medium text-gray-500">Communities</h3>
                <i class="fas fa-comments text-gray-400"></i>
            </div>
            
        </div>
        
        <div class="bg-white rounded-lg border p-4">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-sm font-medium text-gray-500">Total Posts</h3>
                <i class="fas fa-file-alt text-gray-400"></i>
            </div>
            
        </div>
        
        <div class="bg-white rounded-lg border p-4">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-sm font-medium text-gray-500">Reported Content</h3>
                <i class="fas fa-flag text-gray-400"></i>
            </div>
            
        </div>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
        <div class="bg-white rounded-lg border">
            <div class="flex items-center justify-between p-4 border-b">
                <h2 class="font-semibold">Recent Posts</h2>
                <a href="{{ route('posts.index') }}" class="text-sm text-orange-500 hover:text-orange-600">View All</a>
            </div>
            <div class="p-4">
                @foreach($recentPosts as $post)
                    <div class="flex items-start justify-between py-3 {{ !$loop->last ? 'border-b' : '' }}">
                        <div class="space-y-1">
                            <p class="font-medium">{{ $post->title }}</p>
                            <div class="flex text-sm text-gray-500">
                                <span>m/{{ $post->community->name }}</span>
                                <span class="mx-1">•</span>
                                <span>by {{ $post->user->username }}</span>
                                <span class="mx-1">•</span>
                                <span>{{ $post->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        <div class="flex space-x-1">
                            <a href="{{ route('admin.posts.show', $post) }}" class="text-gray-500 hover:text-gray-700 p-1">
                                <i class="fas fa-eye"></i>
                            </a>
                            <form action="{{ route('admin.posts.destroy', $post) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 p-1">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        
        <div class="bg-white rounded-lg border">
            <div class="flex items-center justify-between p-4 border-b">
                <h2 class="font-semibold">Recent Users</h2>
                <a href="{{ route('users.index') }}" class="text-sm text-orange-500 hover:text-orange-600">View All</a>
            </div>
            <div class="p-4">
                @foreach($recentUsers as $user)
                    <div class="flex items-center justify-between py-3 {{ !$loop->last ? 'border-b' : '' }}">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center">
                                @if($user->avatar)
                                    <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="w-8 h-8 rounded-full">
                                @else
                                    <span class="text-sm font-medium">{{ substr($user->name, 0, 2) }}</span>
                                @endif
                            </div>
                            <div>
                                <p class="font-medium">{{ $user->name }}</p>
                                <p class="text-sm text-gray-500">@{{ $user->username }}</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <span class="text-sm text-gray-500">Joined {{ $user->created_at->diffForHumans() }}</span>
                            <div class="flex space-x-1">
                                <a href="{{ route('users.show', $user) }}" class="text-gray-500 hover:text-gray-700 p-1">
                                    <i class="fas fa-user-check"></i>
                                </a>
                                <form action="{{ route('users.destroy', $user) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 p-1">
                                        <i class="fas fa-user-times"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    
    <div class="mt-6">
        <div class="bg-white rounded-lg border">
            <div class="flex items-center justify-between p-4 border-b">
                <h2 class="font-semibold">Reported Content</h2>
                <a href="{{ route('reported') }}" class="text-sm text-orange-500 hover:text-orange-600">View All</a>
            </div>
            <div class="p-4">
                
            </div>
        </div>
    </div>
@endsection