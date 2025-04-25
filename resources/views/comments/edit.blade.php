<x-layout.app title="Modifier le commentaire">
    <div class="container mx-auto max-w-4xl">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-6">Modifier le commentaire</h1>
            
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <form action="{{ route('comments.update', $comment->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <label for="contenu" class="block text-gray-700 font-medium mb-2">Contenu du commentaire</label>
                    <textarea 
                        id="contenu" 
                        name="contenu" 
                        rows="5" 
                        class="w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5"
                    >{{ old('contenu', $comment->contenu) }}</textarea>
                </div>
                
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('posts.show', $comment->post_id) }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                        Annuler
                    </a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layout.app>