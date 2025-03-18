@extends('admin.layouts.app')

@section('title', 'Détails du commentaire')

@section('content')
<div class="bg-white p-6 rounded-lg shadow">
    <h2 class="text-2xl font-semibold mb-6">Détails du commentaire</h2>

    <div class="space-y-4">
        <p><strong>ID :</strong> {{ $comment->id }}</p>
        <p><strong>Contenu :</strong> {{ $comment->content }}</p>
        <p><strong>Auteur :</strong> {{ $comment->user->name }}</p>
        <p><strong>Post :</strong> {{ $comment->post->title }}</p>
        <p><strong>Date de création :</strong> {{ $comment->created_at->format('d/m/Y H:i') }}</p>
    </div>

    <div class="mt-6">
        <a href="{{ route('admin.comments.index') }}" class="text-blue-500 hover:text-blue-700">Retour à la liste</a>
    </div>
</div>
@endsection