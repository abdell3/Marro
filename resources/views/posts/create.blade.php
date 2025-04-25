<x-layout.app title="Créer un post">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Créer un nouveau post</h1>
            
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="mb-4">
                    <label for="community_id" class="block text-gray-700 text-sm font-medium mb-2">Communauté</label>
                    <select id="community_id" name="community_id" class="w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-red-500 focus:border-red-500 p-2.5" required>
                        <option value="" disabled {{ $selectedCommunityId ? '' : 'selected' }}>Choisir une communauté</option>
                        @foreach($communities as $community)
                            <option value="{{ $community->id }}" {{ $selectedCommunityId == $community->id ? 'selected' : '' }}>
                                {{ $community->theme_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="mb-4">
                    <label for="titre" class="block text-gray-700 text-sm font-medium mb-2">Titre</label>
                    <input type="text" id="titre" name="titre" value="{{ old('titre') }}" class="w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-red-500 focus:border-red-500 p-2.5" placeholder="Un titre accrocheur pour votre post" required>
                </div>
                
                <div class="mb-4">
                    <label for="typeContenu" class="block text-gray-700 text-sm font-medium mb-2">Type de contenu</label>
                    <div class="flex flex-wrap gap-4">
                        <div class="flex items-center">
                            <input type="radio" id="type-text" name="typeContenu" value="text" class="w-4 h-4 text-red-600 bg-gray-100 border-gray-300 focus:ring-red-500" checked>
                            <label for="type-text" class="ml-2 text-sm font-medium text-gray-900">Texte</label>
                        </div>
                        <div class="flex items-center">
                            <input type="radio" id="type-image" name="typeContenu" value="image" class="w-4 h-4 text-red-600 bg-gray-100 border-gray-300 focus:ring-red-500">
                            <label for="type-image" class="ml-2 text-sm font-medium text-gray-900">Image</label>
                        </div>
                        <div class="flex items-center">
                            <input type="radio" id="type-link" name="typeContenu" value="link" class="w-4 h-4 text-red-600 bg-gray-100 border-gray-300 focus:ring-red-500">
                            <label for="type-link" class="ml-2 text-sm font-medium text-gray-900">Lien</label>
                        </div>
                        <div class="flex items-center">
                            <input type="radio" id="type-video" name="typeContenu" value="video" class="w-4 h-4 text-red-600 bg-gray-100 border-gray-300 focus:ring-red-500">
                            <label for="type-video" class="ml-2 text-sm font-medium text-gray-900">Vidéo</label>
                        </div>
                    </div>
                </div>
                
                <div class="mb-4" id="media-upload-section" style="display: none;">
                    <label for="media" class="block text-gray-700 text-sm font-medium mb-2">
                        <span id="media-label">Téléverser un fichier</span>
                    </label>
                    <input type="file" id="media" name="media" class="w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-red-500 focus:border-red-500 p-2.5">
                    <p class="mt-1 text-xs text-gray-500" id="media-help-text">Formats supportés pour les images: JPG, PNG, GIF, WEBP (max 5 MB)</p>
                </div>
                
                <div class="mb-6">
                    <label for="contenu" class="block text-gray-700 text-sm font-medium mb-2">Contenu / Description</label>
                    <textarea id="contenu" name="contenu" rows="10" class="w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-red-500 focus:border-red-500 p-2.5" placeholder="Partagez votre contenu ou ajoutez une description pour votre média...">{{ old('contenu') }}</textarea>
                </div>
                
                <div class="flex justify-end space-x-3">
                    <a href="{{ url()->previous() }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-300">
                        Annuler
                    </a>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50">
                        Publier
                    </button>
                </div>
            </form>
        </div>
        
        <div class="bg-white rounded-lg shadow-md p-6 mt-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Conseils pour créer un bon post</h2>
            <ul class="space-y-2 text-gray-700">
                <li class="flex items-start">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 mr-2 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Utilisez un titre clair et descriptif pour attirer l'attention.</span>
                </li>
                <li class="flex items-start">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 mr-2 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Soyez concis et allez droit au but dans votre contenu.</span>
                </li>
                <li class="flex items-start">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 mr-2 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Assurez-vous que votre post respecte les règles de la communauté.</span>
                </li>
                <li class="flex items-start">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 mr-2 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Vérifiez l'orthographe et la grammaire avant de publier.</span>
                </li>
                <li class="flex items-start">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 mr-2 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Soyez ouvert aux commentaires et aux discussions.</span>
                </li>
            </ul>
        </div>
    </div>
</x-layout.app>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const typeRadios = document.querySelectorAll('input[name="typeContenu"]');
        const mediaUploadSection = document.getElementById('media-upload-section');
        const mediaLabel = document.getElementById('media-label');
        const mediaHelpText = document.getElementById('media-help-text');
        const mediaInput = document.getElementById('media');
        const contenuTextarea = document.getElementById('contenu');
        
        function updateFormBasedOnType() {
            const selectedType = document.querySelector('input[name="typeContenu"]:checked').value;
            
            // Reset
            mediaUploadSection.style.display = 'none';
            contenuTextarea.setAttribute('required', 'required');
            mediaInput.removeAttribute('required');
            
            // Show appropriate fields based on type
            if (selectedType === 'image') {
                mediaUploadSection.style.display = 'block';
                mediaLabel.textContent = 'Téléverser une image';
                mediaHelpText.textContent = 'Formats supportés: JPG, PNG, GIF, WEBP (max 5 MB)';
                mediaInput.setAttribute('accept', 'image/*');
                contenuTextarea.placeholder = 'Ajoutez une description pour votre image...';
                contenuTextarea.removeAttribute('required');
            } else if (selectedType === 'video') {
                mediaUploadSection.style.display = 'block';
                mediaLabel.textContent = 'Téléverser une vidéo';
                mediaHelpText.textContent = 'Formats supportés: MP4, WEBM, MOV (max 20 MB)';
                mediaInput.setAttribute('accept', 'video/*');
                contenuTextarea.placeholder = 'Ajoutez une description pour votre vidéo...';
                contenuTextarea.removeAttribute('required');
            } else if (selectedType === 'link') {
                contenuTextarea.placeholder = 'Collez votre lien ici...';
            } else {
                contenuTextarea.placeholder = 'Partagez votre contenu ici...';
            }
        }
        
        // Initial setup
        updateFormBasedOnType();
        
        // Update when type changes
        typeRadios.forEach(radio => {
            radio.addEventListener('change', updateFormBasedOnType);
        });
    });
</script>
