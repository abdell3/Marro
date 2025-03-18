@extends('admin.layouts.app')

@section('title', 'Détails de l\'utilisateur')

@section('content')
<div class="bg-white p-6 rounded-lg shadow">
    <h2 class="text-2xl font-semibold mb-6">Détails de l'utilisateur</h2>

    <div class="space-y-4">
        <p><strong>ID :</strong> {{ $user->id }}</p>
        <p><strong>Nom :</strong> {{ $user->name }}</p>
        <p><strong>Email :</strong> {{ $user->email }}</p>
        <p><strong>Statut :</strong>
            <span class="px-2 py-1 text-sm rounded-full {{ $user->is_active ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' }}">
                {{ $user->is_active ? 'Actif' : 'Inactif' }}
            </span>
        </p>
    </div>

    <div class="mt-6">
        <a href="{{ route('admin.users.index') }}" class="text-blue-500 hover:text-blue-700">Retour à la liste</a>
    </div>
</div>
@endsection