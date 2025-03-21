@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $post->title }}</h1>

    <div class="card mb-3">
        <div class="card-body">
            <p class="card-text">{{ $post->content }}</p>
            <p class="card-text">
                <small class="text-muted">
                    Posté par {{ $post->user->name }} dans {{ $post->community->name }}
                </small>
            </p>
            <div class="tags mb-2">
                @foreach ($post->tags as $tag)
                    <span class="badge badge-primary">{{ $tag->name }}</span>
                @endforeach
            </div>
        </div>
    </div>

    <!-- <h3>Commentaires</h3>
    @foreach ($post->comments as $comment)
        @include('comments._comment', ['comment' => $comment])
    @endforeach

    
    <form action="{{ route('comments.store') }}" method="POST" class="mt-4">
        @csrf
        <input type="hidden" name="post_id" value="{{ $post->id }}">
        <div class="form-group">
            <textarea name="content" class="form-control" rows="3" placeholder="Ajouter un commentaire..." required></textarea>
        </div>
        <button type="submit" class="btn btn-primary mt-2">Commenter</button>
    </form> -->

    
    <h3>Commentaires</h3>
    @foreach ($post->comments as $comment)
        <div class="card mb-2">
            <div class="card-body">
                <p class="card-text">{{ $comment->content }}</p>
                <p class="card-text">
                    <small class="text-muted">
                        Commenté par {{ $comment->user->name }} le {{ $comment->created_at->format('d/m/Y H:i') }}
                    </small>
                </p>
            </div>
        </div>
    @endforeach

    
    <a href="{{ route('post.index') }}" class="btn btn-secondary mt-3">Retour à la liste</a>
</div>
@endsection