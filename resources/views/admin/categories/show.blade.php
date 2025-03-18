@extends('admin.layouts.app')

@section('title', 'Détails de la catégorie')

@section('content')
<div class="bg-white p-6 rounded-lg shadow">
    <h2 class="text-2xl font-semibold mb-6">Détails de la catégorie</h2>

    <div class="space-y-4">
        <p><strong>ID :</strong> {{ $category->id }}</p>
        <p><strong>Nom :</strong> {{ $category->name }}</p>
        <p><strong>Description :</strong> {{ $category->description }}</p>
    </div>

    <div class="mt-6">
        <a href="{{ route('admin.categories.index') }}" class="text-blue-500 hover:text-blue-700">Retour à la liste</a>
    </div>
</div>
@endsection