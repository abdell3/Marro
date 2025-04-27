<x-layout.app title="Modifier le profil">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="p-6">
                <h1 class="text-2xl font-bold text-gray-800 mb-6">Modifier votre avatar</h1>
                
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-md">
                        {{ session('success') }}
                    </div>
                @endif
                
                <div class="mb-8">
                    <div class="flex items-center">
                        <div class="w-24 h-24 rounded-full bg-gray-300 flex items-center justify-center overflow-hidden mr-6" id="avatar-preview-container">
                            @if($user->avatar)
                                <img src="{{ asset('storage/' . $user->avatar) }}?v={{ time() }}" alt="{{ $user->prenom }} {{ $user->nom }}" class="w-full h-full object-cover" id="avatar-preview" onerror="this.src='{{ asset('images/default-avatar.png') }}'; this.onerror=''">
                            @else
                                <span class="text-2xl font-medium" id="avatar-initials">{{ substr($user->prenom, 0, 1) . substr($user->nom, 0, 1) }}</span>
                            @endif
                        </div>
                        
                        <div>
                            <h2 class="text-xl font-medium text-gray-800">{{ $user->prenom }} {{ $user->nom }}</h2>
                            <p class="text-gray-600 mb-2">{{ $user->email }}</p>
                            
                            <form action="{{ route('profile.update-avatar') }}" method="POST" enctype="multipart/form-data" class="mt-4" id="avatar-form">
                                @csrf
                                @method('PUT')
                                
                                <div class="flex items-center space-x-4">
                                    <label class="flex items-center justify-center px-4 py-2 bg-gray-100 text-gray-700 rounded-md cursor-pointer hover:bg-gray-200 transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        Sélectionner une image
                                        <input type="file" name="avatar" id="avatar-input" class="hidden" accept="image/*" onchange="previewAvatar(this)">
                                    </label>
                                    
                                    <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition" id="avatar-submit-btn">
                                        Mettre à jour
                                    </button>
                                </div>
                                
                                <div id="avatar-status" class="text-sm mt-2 hidden"></div>
                                
                                @error('avatar')
                                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                @enderror
                            </form>
                        </div>
                    </div>
                </div>
                
                <h1 class="text-2xl font-bold text-gray-800 mb-6">Informations personnelles</h1>
                
                <form action="{{ route('profile') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-5">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label for="prenom" class="block text-sm font-medium text-gray-700 mb-1">Prénom</label>
                                <input 
                                    type="text" 
                                    id="prenom" 
                                    name="prenom" 
                                    value="{{ old('prenom', $user->prenom) }}" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-300"
                                >
                                @error('prenom')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="nom" class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
                                <input 
                                    type="text" 
                                    id="nom" 
                                    name="nom" 
                                    value="{{ old('nom', $user->nom) }}" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-300"
                                >
                                @error('nom')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                value="{{ old('email', $user->email) }}" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-300"
                            >
                            @error('email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="flex justify-end">
                            <button type="submit" class="px-6 py-2 bg-red-500 text-white font-medium rounded-md hover:bg-red-600 transition">
                                Enregistrer les modifications
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-sm overflow-hidden mt-6">
            <div class="p-6">
                <h1 class="text-2xl font-bold text-gray-800 mb-6">Changer de mot de passe</h1>
                
                <form action="{{ route('password.change') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-5">
                        <div>
                            <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">Mot de passe actuel</label>
                            <input 
                                type="password" 
                                id="current_password" 
                                name="current_password" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-300"
                            >
                            @error('current_password')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Nouveau mot de passe</label>
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-300"
                            >
                            @error('password')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirmer le nouveau mot de passe</label>
                            <input 
                                type="password" 
                                id="password_confirmation" 
                                name="password_confirmation" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-300"
                            >
                        </div>
                        
                        <div class="flex justify-end">
                            <button type="submit" class="px-6 py-2 bg-red-500 text-white font-medium rounded-md hover:bg-red-600 transition">
                                Changer le mot de passe
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <x-slot name="scripts">
        <script>
            let fileSelected = false;
            
            function previewAvatar(input) {
                if (input.files && input.files[0]) {
                    fileSelected = true;
                    const reader = new FileReader();
                    
                    // Mettre à jour le statut
                    const statusDiv = document.getElementById('avatar-status');
                    statusDiv.textContent = "Image sélectionnée - prêt pour téléchargement";
                    statusDiv.classList.remove('hidden', 'text-red-500');
                    statusDiv.classList.add('text-green-500');
                    
                    reader.onload = function(e) {
                        // Créer ou mettre à jour l'élément img
                        const previewContainer = document.getElementById('avatar-preview-container');
                        const initialsElement = document.getElementById('avatar-initials');
                        
                        // Cacher les initiales si présentes
                        if (initialsElement) {
                            initialsElement.style.display = 'none';
                        }
                        
                        // Vérifier si une prévisualisation existe déjà
                        let imgPreview = document.getElementById('avatar-preview');
                        
                        if (!imgPreview) {
                            // Créer un nouvel élément image si aucun n'existe
                            imgPreview = document.createElement('img');
                            imgPreview.id = 'avatar-preview';
                            imgPreview.className = 'w-full h-full object-cover';
                            imgPreview.onerror = function() {
                                this.src = '{{ asset('images/default-avatar.png') }}';
                                this.onerror = '';
                            };
                            previewContainer.appendChild(imgPreview);
                        }
                        
                        // Mettre à jour l'image avec le fichier sélectionné
                        imgPreview.src = e.target.result;
                    }
                    
                    reader.onerror = function() {
                        // Gérer les erreurs de lecture
                        const statusDiv = document.getElementById('avatar-status');
                        statusDiv.textContent = "Erreur de lecture de l'image. Veuillez réessayer.";
                        statusDiv.classList.remove('hidden', 'text-green-500');
                        statusDiv.classList.add('text-red-500');
                    }
                    
                    reader.readAsDataURL(input.files[0]);
                }
            }
            
            // Ajouter des écouteurs d'événements pour une meilleure expérience utilisateur
            document.addEventListener('DOMContentLoaded', function() {
                const form = document.getElementById('avatar-form');
                const fileInput = document.getElementById('avatar-input');
                const submitBtn = document.getElementById('avatar-submit-btn');
                const statusDiv = document.getElementById('avatar-status');
                
                if (form) {
                    form.addEventListener('submit', function(e) {
                        if (!fileSelected) {
                            e.preventDefault();
                            statusDiv.textContent = "Veuillez sélectionner une image avant de mettre à jour.";
                            statusDiv.classList.remove('hidden', 'text-green-500');
                            statusDiv.classList.add('text-red-500');
                        } else {
                            // Modifier le bouton pour indiquer le téléchargement
                            submitBtn.textContent = "Téléchargement...";
                            submitBtn.disabled = true;
                        }
                    });
                    
                    // Empêcher l'envoi sur le bouton Entrée si pas d'image sélectionnée
                    form.addEventListener('keypress', function(e) {
                        if (e.key === 'Enter' && !fileSelected) {
                            e.preventDefault();
                            statusDiv.textContent = "Veuillez sélectionner une image avant de mettre à jour.";
                            statusDiv.classList.remove('hidden', 'text-green-500');
                            statusDiv.classList.add('text-red-500');
                        }
                    });
                }
                
                // Vérifier si l'image existe déjà et est accessible
                const existingImg = document.getElementById('avatar-preview');
                if (existingImg) {
                    existingImg.onerror = function() {
                        this.src = '{{ asset('images/default-avatar.png') }}';
                        this.onerror = '';
                    };
                }
            });
        </script>
    </x-slot>
</x-layout.app>