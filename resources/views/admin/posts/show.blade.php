@extends('admin.layouts.app')

@section('title', 'Détails du post')

@section('content')
<div class="bg-white p-6 rounded-lg shadow">
    <h2 class="text-2xl font-semibold mb-6">Détails du post</h2>

    <div class="space-y-4">
        <p><strong>ID :</strong> {{ $post->id }}</p>
        <p><strong>Titre :</strong> {{ $post->title }}</p>
        <p><strong>Contenu :</strong> {{ $post->content }}</p>
        <p><strong>Auteur :</strong> {{ $post->user->name }}</p>
        <p><strong>Catégorie :</strong> {{ $post->category->name }}</p>
        <p><strong>Date de création :</strong> {{ $post->created_at->format('d/m/Y H:i') }}</p>
    </div>

    <div class="mt-6">
        <a href="{{ route('admin.posts.index') }}" class="text-blue-500 hover:text-blue-700">Retour à la liste</a>
    </div>
</div>
@endsection