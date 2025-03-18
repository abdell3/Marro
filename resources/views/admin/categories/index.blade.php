@extends('admin.layouts.app')

@section('title', 'Gestion des catégories')

@section('content')
<div class="bg-white p-6 rounded-lg shadow">
    <h2 class="text-2xl font-semibold mb-6">Liste des catégories</h2>

    <table class="min-w-full bg-white">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b">ID</th>
                <th class="py-2 px-4 border-b">Nom</th>
                <th class="py-2 px-4 border-b">Description</th>
                <th class="py-2 px-4 border-b">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
            <tr>
                <td class="py-2 px-4 border-b">{{ $category->id }}</td>
                <td class="py-2 px-4 border-b">{{ $category->name }}</td>
                <td class="py-2 px-4 border-b">{{ Str::limit($category->description, 50) }}</td>
                <td class="py-2 px-4 border-b">
                    <a href="{{ route('admin.categories.show', $category) }}" class="text-blue-500 hover:text-blue-700">Voir</a>
                    <a href="{{ route('admin.categories.edit', $category) }}" class="text-yellow-500 hover:text-yellow-700 ml-2">Modifier</a>
                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?');">
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
        {{ $categories->links() }}
    </div>

    
    <div class="mt-6">
        <a href="{{ route('categories.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Créer une catégorie</a>
    </div>
</div>
@endsection