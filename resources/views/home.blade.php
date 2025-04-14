@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="flex items-center justify-between mb-4">
            <div class="flex space-x-2">
                <button class="px-3 py-1 border rounded-full bg-white text-sm font-medium">Best</button>
                <button class="px-3 py-1 rounded-full text-sm font-medium text-gray-500 hover:bg-gray-100">Hot</button>
                <button class="px-3 py-1 rounded-full text-sm font-medium text-gray-500 hover:bg-gray-100">New</button>
                <button class="px-3 py-1 rounded-full text-sm font-medium text-gray-500 hover:bg-gray-100">Top</button>
            </div>
        </div>
        
        <div class="space-y-4">
            @foreach($posts as $post)
                @include('partials.post-card', ['post' => $post])
            @endforeach
        </div>
    </div>
@endsection