@extends('admin.layouts.app')

@section('title', 'Modifier un post')

@section('content')
<div class="bg-white p-6 rounded-lg shadow">
    <h2 class="text-2xl font-semibold mb-6">Modifier le post</h2>

    <form action="{{ route('admin.posts.update', $post) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="title" class="block text-sm font-medium text-gray-700">Titre</label>
            <input type="text" name="title" id="title" value="{{ $post->title }}" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm" required>
        </div>
        <div class="mb-4">
            <label for="content" class="block text-sm font-medium text-gray-700">Contenu</label>
            <textarea name="content" id="content" rows="5" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm" required>{{ $post->content }}</textarea>
        </div>
        <div class="mb-4">
            <label for="category_id" class="block text-sm font-medium text-gray-700">Catégorie</label>
            <select name="category_id" id="category_id" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm" required>
                @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ $post->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label for="user_id" class="block text-sm font-medium text-gray-700">Auteur</label>
            <select name="user_id" id="user_id" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm" required>
                @foreach ($users as $user)
                <option value="{{ $user->id }}" {{ $post->user_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mt-6">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Mettre à jour</button>
        </div>
    </form>
</div>
@endsection