

@extends('auth.layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
        <h2 class="text-2xl font-bold mb-6 text-center">Tableau de Bord</h2>
        <p class="text-gray-700 text-center">Bienvenue, {{ Auth::user()->name }} !</p>
        
        
        <div class="mt-6">
            <p class="text-gray-700">Email : {{ Auth::user()->email }}</p>
            <!-- <p class="text-gray-700">Pseudonyme : {{ Auth::user()->username }}</p> -->
        </div>

       
        <div class="mt-6 text-center">
            <a href="#" class="text-blue-500 hover:text-blue-700">Modifier mon profil</a>
        </div>
    </div>
</div>
@endsection