@extends('admin.layouts.app')

@section('title', 'Gestion des commentaires')

@section('content')
<div class="bg-white p-6 rounded-lg shadow">
    <h2 class="text-2xl font-semibold mb-6">Liste des commentaires</h2>

    <table class="min-w-full bg-white">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b">ID</th>
                <th class="py-2 px-4 border-b">Contenu</th>
                <th class="py-2 px-4 border-b">Auteur</th>
                <th class="py-2 px-4 border-b">Post</th>
                <th class="py-2 px-4 border-b">Date de création</th>
                <th class="py-2 px-4 border-b">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($comments as $comment)
            <tr>
                <td class="py-2 px-4 border-b">{{ $comment->id }}</td>
                <td class="py-2 px-4 border-b">{{ Str::limit($comment->content, 50) }}</td>
                <td class="py-2 px-4 border-b">{{ $comment->user->name }}</td>
                <td class="py-2 px-4 border-b">{{ $comment->post->title }}</td>
                <td class="py-2 px-4 border-b">{{ $comment->created_at->format('d/m/Y H:i') }}</td>
                <td class="py-2 px-4 border-b">
                    <a href="{{ route('admin.comments.show', $comment) }}" class="text-blue-500 hover:text-blue-700">Voir</a>
                    <form action="{{ route('admin.comments.destroy', $comment) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce commentaire ?');">
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
        {{ $comments->links() }}
    </div>
</div>
@endsection