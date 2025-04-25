<x-layout.app title="Profil">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Votre profil</h1>
            
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif
            
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <form action="{{ route('profile') }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="nom" class="block text-gray-700 text-sm font-medium mb-2">Nom</label>
                        <input type="text" id="nom" name="nom" value="{{ old('nom', $user->nom) }}" class="w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-red-500 focus:border-red-500 p-2.5" required>
                    </div>
                    
                    <div>
                        <label for="prenom" class="block text-gray-700 text-sm font-medium mb-2">Prénom</label>
                        <input type="text" id="prenom" name="prenom" value="{{ old('prenom', $user->prenom) }}" class="w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-red-500 focus:border-red-500 p-2.5" required>
                    </div>
                </div>
                
                <div class="mb-6">
                    <label for="email" class="block text-gray-700 text-sm font-medium mb-2">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" class="w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-red-500 focus:border-red-500 p-2.5" required>
                </div>
                
                <div class="flex justify-between">
                    <a href="{{ route('password.change') }}" class="text-sm font-medium text-red-600 hover:underline">Changer mon mot de passe</a>
                    
                    <button type="submit" class="px-5 py-2.5 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50">
                        Enregistrer les modifications
                    </button>
                </div>
            </form>
        </div>
        
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Badge</h2>
            
            @if($user->badge)
                <div class="flex items-center p-4 mb-4 border border-gray-200 rounded-lg">
                    <div class="bg-yellow-100 p-3 rounded-lg mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-medium text-gray-800">{{ $user->badge->nom }}</h3>
                        <p class="text-gray-600 text-sm">{{ $user->badge->critere }}</p>
                    </div>
                </div>
            @else
                <p class="text-gray-600 mb-4">Vous n'avez pas encore obtenu de badge. Participez activement à la communauté pour en gagner !</p>
            @endif
            
            <div class="border-t border-gray-200 pt-4">
                <h3 class="text-lg font-medium text-gray-800 mb-3">Badges disponibles</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="border border-gray-200 rounded-lg p-4 {{ $user->badge && $user->badge->nom === 'Nouveau venu' ? 'border-yellow-400 bg-yellow-50' : '' }}">
                        <div class="flex items-center mb-2">
                            <span class="w-8 h-8 flex items-center justify-center bg-blue-100 text-blue-800 rounded-full mr-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </span>
                            <h4 class="font-medium">Nouveau venu</h4>
                        </div>
                        <p class="text-sm text-gray-600">Inscrit sur le site</p>
                    </div>
                    
                    <div class="border border-gray-200 rounded-lg p-4 {{ $user->badge && $user->badge->nom === 'Contributeur' ? 'border-yellow-400 bg-yellow-50' : '' }}">
                        <div class="flex items-center mb-2">
                            <span class="w-8 h-8 flex items-center justify-center bg-green-100 text-green-800 rounded-full mr-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </span>
                            <h4 class="font-medium">Contributeur</h4>
                        </div>
                        <p class="text-sm text-gray-600">A créé au moins 10 posts</p>
                    </div>
                    
                    <div class="border border-gray-200 rounded-lg p-4 {{ $user->badge && $user->badge->nom === 'Expert' ? 'border-yellow-400 bg-yellow-50' : '' }}">
                        <div class="flex items-center mb-2">
                            <span class="w-8 h-8 flex items-center justify-center bg-red-100 text-red-800 rounded-full mr-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </span>
                            <h4 class="font-medium">Expert</h4>
                        </div>
                        <p class="text-sm text-gray-600">A obtenu au moins 100 upvotes sur ses posts</p>
                    </div>
                    
                    <div class="border border-gray-200 rounded-lg p-4 {{ $user->badge && $user->badge->nom === 'Commentateur' ? 'border-yellow-400 bg-yellow-50' : '' }}">
                        <div class="flex items-center mb-2">
                            <span class="w-8 h-8 flex items-center justify-center bg-purple-100 text-purple-800 rounded-full mr-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                </svg>
                            </span>
                            <h4 class="font-medium">Commentateur</h4>
                        </div>
                        <p class="text-sm text-gray-600">A laissé au moins 50 commentaires</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Paramètres du compte</h2>
            
            <div class="border-b border-gray-200 pb-4 mb-4">
                <h3 class="font-medium text-gray-800 mb-2">Notifications</h3>
                <p class="text-gray-600 text-sm mb-4">Gérez vos préférences de notifications.</p>
                <div class="flex items-center justify-between">
                    <span class="text-gray-700">Notifications par email</span>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" value="" class="sr-only peer" checked>
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-red-600"></div>
                    </label>
                </div>
            </div>
            
            <div class="border-b border-gray-200 pb-4 mb-4">
                <h3 class="font-medium text-gray-800 mb-2">Supprimer le compte</h3>
                <p class="text-gray-600 text-sm mb-4">Une fois que vous supprimez votre compte, il n'y a pas de retour en arrière. Soyez certain.</p>
                <button type="button" class="px-4 py-2 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50" onclick="confirmAccountDeletion()">
                    Supprimer mon compte
                </button>
            </div>
            
            <div class="text-right">
                <a href="{{ route('dashboard') }}" class="text-sm font-medium text-gray-600 hover:underline">Retour au tableau de bord</a>
            </div>
        </div>
    </div>
    
    <x-slot name="scripts">
        <script>
            function confirmAccountDeletion() {
                if (confirm('Êtes-vous sûr de vouloir supprimer votre compte ? Cette action est irréversible.')) {
                    alert('Fonctionnalité de suppression de compte à implémenter.');
                }
            }
        </script>
    </x-slot>
</x-layout.app>
