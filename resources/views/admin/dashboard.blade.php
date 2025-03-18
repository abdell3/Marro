@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-lg font-semibold">Utilisateurs</h2>
        <p class="text-3xl">{{ $totalUsers }}</p>
    </div>
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-lg font-semibold">Posts</h2>
        <p class="text-3xl">{{ $totalPosts }}</p>
    </div>
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-lg font-semibold">Commentaires</h2>
        <p class="text-3xl">{{ $totalComments }}</p>
    </div>
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-lg font-semibold">Catégories</h2>
        <p class="text-3xl">{{ $totalCategories }}</p>
    </div>
</div>
@endsection