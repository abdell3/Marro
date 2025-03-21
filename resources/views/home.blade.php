
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        
        <div class="col-md-8">
            <h1>Posts récents</h1>

            @foreach ($posts as $post)
                <div class="post-card">
                    <div class="post-title">
                        <a href="{{ route('posts.show', $post->id) }}">{{ $post->title }}</a>
                    </div>
                    <div class="post-meta">
                        Posté par <strong>{{ $post->user->name }}</strong> dans
                        <a href="#">{{ $post->community->name }}</a> •
                        {{ $post->created_at->diffForHumans() }}
                    </div>
                    <div class="post-content mt-2">
                        {{ Str::limit($post->content, 200) }}
                    </div>
                    <div class="tags mt-2">
                        @foreach ($post->tags as $tag)
                            <span class="badge bg-primary">{{ $tag->name }}</span>
                        @endforeach
                    </div>
                    <div class="mt-2">
                        <a href="{{ route('posts.show', $post->id) }}" class="btn btn-sm btn-outline-primary">Voir plus</a>
                    </div>
                </div>
            @endforeach

            
            <div class="mt-4">
                {{ $posts->links() }}
            </div>
        </div>

        
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Communautés populaires</h5>
                    <ul class="list-group">
                        @foreach ($communities as $community)
                            <li class="list-group-item">
                                <a href="#">{{ $community->name }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection