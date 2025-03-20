@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Liste des Posts</h1>

    
    <form action="{{ route('posts.index') }}" method="GET" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <label for="community_id">Filtrer par communauté :</label>
                <select name="community_id" id="community_id" class="form-control">
                    <option value="">Toutes les communautés</option>
                    @foreach ($communities as $community)
                        <option value="{{ $community->id }}" {{ request('community_id') == $community->id ? 'selected' : '' }}>
                            {{ $community->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <label for="tag_id">Filtrer par tag :</label>
                <select name="tag_id" id="tag_id" class="form-control">
                    <option value="">Tous les tags</option>
                    @foreach ($tags as $tag)
                        <option value="{{ $tag->id }}" {{ request('tag_id') == $tag->id ? 'selected' : '' }}>
                            {{ $tag->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <label for="order_by">Trier par :</label>
                <select name="order_by" id="order_by" class="form-control">
                    <option value="created_at" {{ request('order_by') == 'created_at' ? 'selected' : '' }}>Date</option>
                    <option value="title" {{ request('order_by') == 'title' ? 'selected' : '' }}>Titre</option>
                </select>
            </div>

            <div class="col-md-2">
                <label for="order_direction">Ordre :</label>
                <select name="order_direction" id="order_direction" class="form-control">
                    <option value="asc" {{ request('order_direction') == 'asc' ? 'selected' : '' }}>Croissant</option>
                    <option value="desc" {{ request('order_direction') == 'desc' ? 'selected' : '' }}>Décroissant</option>
                </select>
            </div>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Appliquer</button>
    </form>

    
    @foreach ($posts as $post)
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">{{ $post->title }}</h5>
                <p class="card-text">{{ Str::limit($post->content, 200) }}</p>
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
                <a href="{{ route('post.show', $post->id) }}" class="btn btn-primary">Voir plus</a>
            </div>
        </div>
    @endforeach

    
    {{ $posts->links() }}
     
</div>
@endsection