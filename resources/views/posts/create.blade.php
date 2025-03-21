@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Créer un nouveau post</h1>

    <form action="{{ route('posts.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="title">Titre</label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="content">Contenu</label>
            <textarea name="content" id="content" class="form-control" rows="5" required></textarea>
        </div>

        <div class="form-group">
            <label for="type">Type de post</label>
            <select name="type" id="type" class="form-control" required>
                <option value="text">Texte</option>
                <option value="image">Image</option>
                <option value="video">Vidéo</option>
            </select>
        </div>

        <div class="form-group">
            <label for="file_path">Fichier (URL ou chemin)</label>
            <input type="text" name="file_path" id="file_path" class="form-control">
        </div>

        <div class="form-group">
            <label for="community_id">Communauté</label>
            <select name="community_id" id="community_id" class="form-control" required>
                @foreach ($communities as $community)
                    <option value="{{ $community->id }}">{{ $community->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="tags">Tags</label>
            <select name="tags[]" id="tags" class="form-control" multiple>
                @foreach ($tags as $tag)
                    <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Créer</button>
    </form>
</div>
@endsection