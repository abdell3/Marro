@extends('admin.layouts.app')

@section('title', 'Gestion des posts')

@section('content')
<div class="bg-white p-6 rounded-lg shadow">
    <h2 class="text-2xl font-semibold mb-6">Liste des posts</h2>

    <table class="min-w-full bg-white">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b">ID</th>
                <th class="py-2 px-4 border-b">Titre</th>
                <th class="py-2 px-4 border-b">Auteur</th>
                <th class="py-2 px-4 border-b">Catégorie</th>
                <th class="py-2 px-4 border-b">Date de création</th>
                <th class="py-2 px-4 border-b">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($posts as $post)
            <tr>
                <td class="py-2 px-4 border-b">{{ $post->id }}</td>
                <td class="py-2 px-4 border-b">{{ $post->title }}</td>
                <td class="py-2 px-4 border-b">{{ $post->user->name }}</td>
                <td class="py-2 px-4 border-b">{{ $post->category->name }}</td>
                <td class="py-2 px-4 border-b">{{ $post->created_at->format('d/m/Y H:i') }}</td>
                <td class="py-2 px-4 border-b">
                    <a href="{{ route('admin.posts.show', $post) }}" class="text-blue-500 hover:text-blue-700">Voir</a>
                    <a href="{{ route('admin.posts.edit', $post) }}" class="text-yellow-500 hover:text-yellow-700 ml-2">Modifier</a>
                    <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce post ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:text-red-700 ml-2">Supprimer</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-6">
        {{ $posts->links() }}
    </div>

    <div class="mt-6">
        <a href="{{ route('posts.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Créer un post</a>
    </div>
</div>
@endsection