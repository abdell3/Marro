@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Modifier le post</h1>

    <form action="{{ route('posts.update', $post->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="title">Titre</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ $post->title }}" required>
        </div>

        <div class="form-group">
            <label for="content">Contenu</label>
            <textarea name="content" id="content" class="form-control" rows="5" required>{{ $post->content }}</textarea>
        </div>

        <div class="form-group">
            <label for="type">Type de post</label>
            <select name="type" id="type" class="form-control" required>
                <option value="text" {{ $post->type === 'text' ? 'selected' : '' }}>Texte</option>
                <option value="image" {{ $post->type === 'image' ? 'selected' : '' }}>Image</option>
                <option value="video" {{ $post->type === 'video' ? 'selected' : '' }}>Vidéo</option>
            </select>
        </div>

        <div class="form-group">
            <label for="file_path">Fichier (URL ou chemin)</label>
            <input type="text" name="file_path" id="file_path" class="form-control" value="{{ $post->file_path }}">
        </div>

        <div class="form-group">
            <label for="community_id">Communauté</label>
            <select name="community_id" id="community_id" class="form-control" required>
                @foreach ($communities as $community)
                    <option value="{{ $community->id }}" {{ $post->community_id === $community->id ? 'selected' : '' }}>
                        {{ $community->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="tags">Tags</label>
            <select name="tags[]" id="tags" class="form-control" multiple>
                @foreach ($tags as $tag)
                    <option value="{{ $tag->id }}" {{ in_array($tag->id, $post->tags->pluck('id')->toArray()) ? 'selected' : '' }}>
                        {{ $tag->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
</div>
@endsection