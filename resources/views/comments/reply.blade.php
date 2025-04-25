<x-layout.app title="Répondre au commentaire">
    <div class="container mx-auto max-w-4xl">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-6">Répondre au commentaire</h1>
            
            <div class="mb-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                <div class="flex items-start mb-2">
                    <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center mr-3 overflow-hidden">
                        @if($comment->auteur->avatar)
                            <img src="{{ asset('storage/' . $comment->auteur->avatar) }}" alt="{{ $comment->auteur->prenom }} {{ $comment->auteur->nom }}" class="w-full h-full object-cover">
                        @else
                            <span class="text-sm font-medium">{{ substr($comment->auteur->prenom, 0, 1) . substr($comment->auteur->nom, 0, 1) }}</span>
                        @endif
                    </div>
                    <div>
                        <div class="font-semibold">{{ $comment->auteur->prenom }} {{ $comment->auteur->nom }}</div>
                        <div class="text-sm text-gray-500">{{ $comment->datePublication->diffForHumans() }}</div>
                    </div>
                </div>
                <div class="mt-2 text-gray-700">
                    {!! nl2br(e($comment->contenu)) !!}
                </div>
            </div>
            
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <form action="{{ route('comments.storeReply', $comment->id) }}" method="POST">
                @csrf
                
                <div class="mb-4">
                    <label for="contenu" class="block text-gray-700 font-medium mb-2">Votre réponse</label>
                    <textarea 
                        id="contenu" 
                        name="contenu" 
                        rows="5" 
                        class="w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5"
                        placeholder="Écrivez votre réponse ici..."
                    >{{ old('contenu') }}</textarea>
                </div>
                
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('posts.show', $comment->post_id) }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                        Annuler
                    </a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Répondre
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layout.app>