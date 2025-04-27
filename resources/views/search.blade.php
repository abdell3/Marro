<x-layout.app title="Recherche">
    <div class="container mx-auto">
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <form action="{{ route('search') }}" method="GET">
                <div class="flex">
                    <div class="relative w-full">
                        <input 
                            type="text" 
                            name="query" 
                            value="{{ $query }}" 
                            placeholder="Rechercher sur Marro..." 
                            class="w-full bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-full px-5 py-3 focus:outline-none focus:ring-2 focus:ring-red-300"
                        >
                        <button 
                            type="submit" 
                            class="absolute right-0 top-0 h-full px-4 text-gray-600 hover:text-red-500"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </div>
                </div>
                
                <div class="mt-4 flex flex-wrap gap-3">
                    <div class="flex items-center">
                        <span class="text-gray-600 font-medium mr-2">Filtrer par:</span>
                        <select name="filter" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg px-3 py-1.5 focus:outline-none focus:ring-2 focus:ring-red-300">
                            <option value="all" selected>Tout</option>
                            <option value="posts">Posts</option>
                            <option value="communities">Communautés</option>
                            <option value="users">Utilisateurs</option>
                        </select>
                    </div>
                    
                    <div class="flex items-center">
                        <span class="text-gray-600 font-medium mr-2">Trier par:</span>
                        <select name="sort" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg px-3 py-1.5 focus:outline-none focus:ring-2 focus:ring-red-300">
                            <option value="relevant" selected>Pertinence</option>
                            <option value="recent">Plus récents</option>
                            <option value="popular">Plus populaires</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>
        
        @if($query)
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-800 mb-2">Résultats pour "{{ $query }}"</h1>
                <p class="text-gray-600">{{ $posts->count() + $communities->count() }} résultats trouvés</p>
            </div>
            
            @if($posts->count() > 0 || $communities->count() > 0)
                <!-- Posts Results -->
                @if($posts->count() > 0)
                    <div class="bg-white rounded-lg shadow p-6 mb-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-4">Posts</h2>
                        
                        <div class="space-y-4">
                            @foreach($posts as $post)
                                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-sm">
                                    <div class="flex items-start">
                                        <div class="flex flex-col items-center mr-4">
                                            <span class="text-sm font-bold my-1">{{ $post->like }}</span>
                                            <span class="text-xs text-gray-500">votes</span>
                                        </div>
                                        
                                        <div class="flex-1">
                                            <h3 class="text-lg font-medium mb-1">
                                                <a href="{{ route('posts.show', $post->id) }}" class="hover:underline">
                                                    {{ $post->titre }}
                                                </a>
                                            </h3>
                                            <div class="flex items-center text-xs text-gray-500 mb-2">
                                                <a href="{{ route('communities.show', $post->community_id) }}" class="font-medium text-blue-600 hover:underline">
                                                    {{ $post->community->theme_name }}
                                                </a>
                                                <span class="mx-1">•</span>
                                                <span>Posté par <a href="#" class="hover:underline">{{ $post->auteur->prenom }} {{ $post->auteur->nom }}</a></span>
                                                <span class="mx-1">•</span>
                                                <span>{{ $post->datePublication->diffForHumans() }}</span>
                                            </div>
                                            <div class="text-gray-700 mb-2">
                                                {{ Str::limit($post->contenu, 150) }}
                                            </div>
                                            <div class="flex items-center text-gray-500 text-sm">
                                                <a href="{{ route('posts.show', $post->id) }}" class="flex items-center hover:text-gray-700 mr-4">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                                    </svg>
                                                    {{ $post->commentaires->count() }} commentaires
                                                </a>
                                                <a href="{{ route('posts.show', $post->id) }}" class="text-blue-600 hover:underline">Voir le post</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                
                <!-- Communities Results -->
                @if($communities->count() > 0)
                    <div class="bg-white rounded-lg shadow p-6 mb-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-4">Communautés</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($communities as $community)
                                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-sm">
                                    <div class="flex items-start">
                                        <div class="w-12 h-12 bg-blue-500 rounded-full mr-4 flex items-center justify-center text-white font-bold">
                                            {{ substr($community->theme_name, 0, 1) }}
                                        </div>
                                        <div class="flex-1">
                                            <h3 class="text-lg font-medium">
                                                <a href="{{ route('communities.show', $community->id) }}" class="hover:underline">
                                                    {{ $community->theme_name }}
                                                </a>
                                            </h3>
                                            <p class="text-sm text-gray-500 mb-2">{{ $community->abonnes->count() }} membres</p>
                                            <p class="text-gray-700 text-sm mb-3">
                                                {{ Str::limit($community->description, 100) }}
                                            </p>
                                            <div>
                                                @auth
                                                    @if(auth()->user()->communities->contains($community->id))
                                                        <form action="{{ route('communities.subscribe', $community->id) }}" method="POST" class="inline">
                                                            @csrf
                                                            <button type="submit" class="text-xs bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium py-1 px-2 rounded-full">
                                                                Désabonner
                                                            </button>
                                                        </form>
                                                    @else
                                                        <form action="{{ route('communities.subscribe', $community->id) }}" method="POST" class="inline">
                                                            @csrf
                                                            <button type="submit" class="text-xs bg-blue-100 hover:bg-blue-200 text-blue-800 font-medium py-1 px-2 rounded-full">
                                                                S'abonner
                                                            </button>
                                                        </form>
                                                    @endif
                                                @else
                                                    <a href="{{ route('login') }}" class="text-xs bg-blue-100 hover:bg-blue-200 text-blue-800 font-medium py-1 px-2 rounded-full">
                                                        S'abonner
                                                    </a>
                                                @endauth
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @else
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <h3 class="text-xl font-medium text-gray-700 mb-2">Aucun résultat trouvé</h3>
                    <p class="text-gray-500 mb-4">Essayez avec d'autres mots-clés ou vérifiez l'orthographe.</p>
                    <div class="flex justify-center">
                        <a href="{{ route('home') }}" class="text-red-600 hover:underline font-medium">
                            Retour à l'accueil
                        </a>
                    </div>
                </div>
            @endif
        @else
            <div class="bg-white rounded-lg shadow p-6 text-center">
                <h3 class="text-xl font-medium text-gray-700 mb-2">Commencez votre recherche</h3>
                <p class="text-gray-500 mb-4">Entrez des mots-clés pour trouver des posts, des communautés ou des utilisateurs.</p>
            </div>
        @endif
    </div>
</x-layout.app>
