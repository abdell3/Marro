<x-layout.app title="Modifier le post">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Modifier le post</h1>
            
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <label for="community_id" class="block text-gray-700 text-sm font-medium mb-2">Communauté</label>
                    <select id="community_id" name="community_id" class="w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-red-500 focus:border-red-500 p-2.5" required>
                        <option value="" disabled>Choisir une communauté</option>
                        @foreach($communities as $community)
                            <option value="{{ $community->id }}" {{ $post->community_id == $community->id ? 'selected' : '' }}>
                                {{ $community->theme_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="mb-4">
                    <label for="titre" class="block text-gray-700 text-sm font-medium mb-2">Titre</label>
                    <input type="text" id="titre" name="titre" value="{{ old('titre', $post->titre) }}" class="w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-red-500 focus:border-red-500 p-2.5" placeholder="Un titre accrocheur pour votre post" required>
                </div>
                
                <div class="mb-4">
                    <label for="typeContenu" class="block text-gray-700 text-sm font-medium mb-2">Type de contenu</label>
                    <div class="flex flex-wrap gap-4">
                        <div class="flex items-center">
                            <input type="radio" id="type-text" name="typeContenu" value="text" class="w-4 h-4 text-red-600 bg-gray-100 border-gray-300 focus:ring-red-500" {{ $post->typeContenu === 'text' ? 'checked' : '' }}>
                            <label for="type-text" class="ml-2 text-sm font-medium text-gray-900">Texte</label>
                        </div>
                        <div class="flex items-center">
                            <input type="radio" id="type-image" name="typeContenu" value="image" class="w-4 h-4 text-red-600 bg-gray-100 border-gray-300 focus:ring-red-500" {{ $post->typeContenu === 'image' ? 'checked' : '' }}>
                            <label for="type-image" class="ml-2 text-sm font-medium text-gray-900">Image</label>
                        </div>
                        <div class="flex items-center">
                            <input type="radio" id="type-link" name="typeContenu" value="link" class="w-4 h-4 text-red-600 bg-gray-100 border-gray-300 focus:ring-red-500" {{ $post->typeContenu === 'link' ? 'checked' : '' }}>
                            <label for="type-link" class="ml-2 text-sm font-medium text-gray-900">Lien</label>
                        </div>
                        <div class="flex items-center">
                            <input type="radio" id="type-video" name="typeContenu" value="video" class="w-4 h-4 text-red-600 bg-gray-100 border-gray-300 focus:ring-red-500" {{ $post->typeContenu === 'video' ? 'checked' : '' }}>
                            <label for="type-video" class="ml-2 text-sm font-medium text-gray-900">Vidéo</label>
                        </div>
                    </div>
                </div>
                
                <!-- Current Media Preview (if exists) -->
                @if($post->media_path)
                <div class="mb-4" id="current-media-container">
                    <label class="block text-gray-700 text-sm font-medium mb-2">Média actuel</label>
                    <div class="border border-gray-300 rounded-lg p-2 mb-2">
                        @if(str_starts_with($post->media_type, 'image/'))
                            <img src="{{ asset('storage/' . $post->media_path) }}" alt="Image du post" class="max-h-64 mx-auto">
                        @elseif(str_starts_with($post->media_type, 'video/'))
                            <video controls class="w-full max-h-64 mx-auto">
                                <source src="{{ asset('storage/' . $post->media_path) }}" type="{{ $post->media_type }}">
                                Votre navigateur ne prend pas en charge la lecture de vidéos.
                            </video>
                        @endif
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" id="remove_media" name="remove_media" value="1" class="w-4 h-4 text-red-600 bg-gray-100 border-gray-300 focus:ring-red-500">
                        <label for="remove_media" class="ml-2 text-sm font-medium text-gray-900">Supprimer ce média</label>
                    </div>
                </div>
                @endif
                
                <div class="mb-4" id="media-upload-section" style="display: none;">
                    <label for="media" class="block text-gray-700 text-sm font-medium mb-2">
                        <span id="media-label">Téléverser un fichier</span>
                    </label>
                    <input type="file" id="media" name="media" class="w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-red-500 focus:border-red-500 p-2.5">
                    <p class="mt-1 text-xs text-gray-500" id="media-help-text">Formats supportés pour les images: JPG, PNG, GIF, WEBP (max 5 MB)</p>
                </div>
                
                <div class="mb-6">
                    <label for="contenu" class="block text-gray-700 text-sm font-medium mb-2">Contenu / Description</label>
                    <textarea id="contenu" name="contenu" rows="10" class="w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-red-500 focus:border-red-500 p-2.5" placeholder="Partagez votre contenu ou ajoutez une description pour votre média...">{{ old('contenu', $post->contenu) }}</textarea>
                </div>
                
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('posts.show', $post->id) }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-300">
                        Annuler
                    </a>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50">
                        Enregistrer les modifications
                    </button>
                </div>
            </form>
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
        const currentMediaContainer = document.getElementById('current-media-container');
        const removeMediaCheckbox = document.getElementById('remove_media');
        
        function updateFormBasedOnType() {
            const selectedType = document.querySelector('input[name="typeContenu"]:checked').value;
            
            // Reset
            mediaUploadSection.style.display = 'none';
            contenuTextarea.setAttribute('required', 'required');
            mediaInput.removeAttribute('required');
            
            // Show appropriate fields based on type
            if (selectedType === 'image') {
                mediaUploadSection.style.display = 'block';
                mediaLabel.textContent = 'Téléverser une nouvelle image';
                mediaHelpText.textContent = 'Formats supportés: JPG, PNG, GIF, WEBP (max 5 MB)';
                mediaInput.setAttribute('accept', 'image/*');
                contenuTextarea.placeholder = 'Ajoutez une description pour votre image...';
                contenuTextarea.removeAttribute('required');
            } else if (selectedType === 'video') {
                mediaUploadSection.style.display = 'block';
                mediaLabel.textContent = 'Téléverser une nouvelle vidéo';
                mediaHelpText.textContent = 'Formats supportés: MP4, WEBM, MOV (max 20 MB)';
                mediaInput.setAttribute('accept', 'video/*');
                contenuTextarea.placeholder = 'Ajoutez une description pour votre vidéo...';
                contenuTextarea.removeAttribute('required');
            } else if (selectedType === 'link') {
                contenuTextarea.placeholder = 'Collez votre lien ici...';
                if (currentMediaContainer) {
                    currentMediaContainer.style.display = 'none';
                    if (removeMediaCheckbox) {
                        removeMediaCheckbox.checked = true;
                    }
                }
            } else {
                contenuTextarea.placeholder = 'Partagez votre contenu ici...';
                if (currentMediaContainer) {
                    currentMediaContainer.style.display = 'none';
                    if (removeMediaCheckbox) {
                        removeMediaCheckbox.checked = true;
                    }
                }
            }
        }
        
        // Initial setup
        updateFormBasedOnType();
        
        // Update when type changes
        typeRadios.forEach(radio => {
            radio.addEventListener('change', updateFormBasedOnType);
        });
        
        // Handle remove media checkbox
        if (removeMediaCheckbox) {
            removeMediaCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    mediaUploadSection.style.display = 'block';
                }
            });
        }
    });
</script>