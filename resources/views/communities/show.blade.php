<x-layout.app :title="$community->theme_name">
    <div class="container mx-auto">
        <div class="flex flex-col md:flex-row gap-6">
            <!-- Main Content -->
            <div class="w-full md:w-3/4">
                <!-- Community Header -->
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <div class="flex items-center mb-4">
                        <div class="w-16 h-16 bg-blue-500 rounded-full mr-4 flex items-center justify-center text-white text-2xl font-bold">
                            {{ substr($community->theme_name, 0, 1) }}
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-800">{{ $community->theme_name }}</h1>
                            <p class="text-gray-500">{{ $community->abonnes->count() }} membres</p>
                        </div>
                        <div class="ml-auto">
                            @auth
                                @if(auth()->user()->communities->contains($community->id))
                                    <form action="{{ route('communities.subscribe', $community->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-2 px-4 rounded-full">
                                            Désabonner
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('communities.subscribe', $community->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-full">
                                            S'abonner
                                        </button>
                                    </form>
                                @endif
                                
                                <a href="{{ route('posts.create', ['community_id' => $community->id]) }}" class="bg-red-500 hover:bg-red-600 text-white font-medium py-2 px-4 rounded-full ml-2">
                                    Créer un post
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-full">
                                    S'abonner
                                </a>
                                <a href="{{ route('login') }}" class="bg-red-500 hover:bg-red-600 text-white font-medium py-2 px-4 rounded-full ml-2">
                                    Créer un post
                                </a>
                            @endauth
                        </div>
                    </div>
                    <p class="text-gray-700">{{ $community->description }}</p>
                </div>
                
                <!-- Filter Options -->
                <div class="bg-white rounded-lg shadow mb-6 p-4">
                    <div class="flex items-center space-x-4">
                        <span class="text-gray-600 font-medium">Filtrer par:</span>
                        <a href="{{ route('communities.show', ['community' => $community->id, 'filter' => 'latest']) }}" class="px-3 py-1 rounded-full {{ $filter === 'latest' ? 'bg-red-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            Récents
                        </a>
                        <a href="{{ route('communities.show', ['community' => $community->id, 'filter' => 'popular']) }}" class="px-3 py-1 rounded-full {{ $filter === 'popular' ? 'bg-red-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            Populaires
                        </a>
                    </div>
                </div>

                <!-- Posts -->
                @if($posts->count() > 0)
                    <div class="space-y-4">
                        @foreach($posts as $post)
                            <div class="bg-white rounded-lg shadow hover:shadow-md transition-shadow p-4">
                                <div class="flex items-start">
                                    <!-- Vote Section -->
                                    <div class="flex flex-col items-center mr-4">
                                        <button class="text-gray-500 hover:text-red-500 focus:outline-none" onclick="votePost({{ $post->id }}, 'upvote')">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                            </svg>
                                        </button>
                                        <span class="text-sm font-bold my-1">{{ $post->like }}</span>
                                        <button class="text-gray-500 hover:text-blue-500 focus:outline-none" onclick="votePost({{ $post->id }}, 'downvote')">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </button>
                                    </div>

                                    <!-- Post Content -->
                                    <div class="flex-1">
                                        <div class="flex items-center text-xs text-gray-500 mb-1">
                                            <span>Posté par <a href="#" class="hover:underline">{{ $post->auteur->prenom }} {{ $post->auteur->nom }}</a></span>
                                            <span class="mx-1">•</span>
                                            <span>{{ $post->datePublication->diffForHumans() }}</span>
                                        </div>

                                        <h3 class="text-lg font-medium mb-2">
                                            <a href="{{ route('posts.show', $post->id) }}" class="hover:underline">
                                                {{ $post->titre }}
                                            </a>
                                        </h3>

                                        <div class="text-gray-700 mb-3">
                                            @if(strlen($post->contenu) > 300)
                                                {{ substr($post->contenu, 0, 300) }}...
                                                <a href="{{ route('posts.show', $post->id) }}" class="text-blue-600 hover:underline">Voir plus</a>
                                            @else
                                                {{ $post->contenu }}
                                            @endif
                                        </div>

                                        <!-- Post Footer -->
                                        <div class="flex items-center text-gray-500 text-sm">
                                            <a href="{{ route('posts.show', $post->id) }}" class="flex items-center hover:text-gray-700 mr-4">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                                </svg>
                                                {{ $post->commentaires->count() }} commentaires
                                            </a>
                                            <button class="flex items-center hover:text-gray-700 mr-4" onclick="savePost({{ $post->id }})">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                                                </svg>
                                                Sauvegarder
                                            </button>
                                            <button class="flex items-center hover:text-gray-700" onclick="sharePost({{ $post->id }})">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                                                </svg>
                                                Partager
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-white rounded-lg shadow p-6 text-center">
                        <h3 class="text-xl font-medium text-gray-700 mb-2">Aucun post pour le moment</h3>
                        <p class="text-gray-500 mb-4">Soyez le premier à créer un post dans cette communauté!</p>
                        
                        @auth
                            <a href="{{ route('posts.create', ['community_id' => $community->id]) }}" class="inline-block px-6 py-2 bg-red-500 text-white font-medium rounded-full hover:bg-red-600 transition-colors">
                                Créer un post
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="inline-block px-6 py-2 bg-red-500 text-white font-medium rounded-full hover:bg-red-600 transition-colors">
                                Connectez-vous pour créer un post
                            </a>
                        @endauth
                    </div>
                @endif
            </div>
            
            <!-- Sidebar -->
            <div class="w-full md:w-1/4">
                <!-- About Community -->
                <div class="bg-white rounded-lg shadow p-4 mb-6">
                    <h3 class="text-lg font-medium mb-3">À propos de la communauté</h3>
                    <p class="text-gray-700 mb-4">{{ $community->description }}</p>
                    <div class="border-t border-gray-200 pt-4">
                        <div class="flex justify-between text-sm">
                            <div class="text-center">
                                <div class="font-bold text-lg">{{ $posts->count() }}</div>
                                <div class="text-gray-500">Posts</div>
                            </div>
                            <div class="text-center">
                                <div class="font-bold text-lg">{{ $community->abonnes->count() }}</div>
                                <div class="text-gray-500">Membres</div>
                            </div>
                            <div class="text-center">
                                <div class="font-bold text-lg">{{ $community->created_at->diffForHumans() }}</div>
                                <div class="text-gray-500">Créée</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        @auth
                            <a href="{{ route('posts.create', ['community_id' => $community->id]) }}" class="block w-full py-2 px-4 bg-red-500 text-white text-center font-medium rounded-full hover:bg-red-600 transition-colors">
                                Créer un post
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="block w-full py-2 px-4 bg-red-500 text-white text-center font-medium rounded-full hover:bg-red-600 transition-colors">
                                Connectez-vous pour créer un post
                            </a>
                        @endauth
                    </div>
                </div>
                
                <!-- Community Rules -->
                <div class="bg-white rounded-lg shadow p-4">
                    <h3 class="text-lg font-medium mb-3">Règles de la communauté</h3>
                    <ul class="space-y-2 text-gray-700">
                        <li class="flex items-start">
                            <span class="text-red-500 mr-2">1.</span>
                            <span>Soyez respectueux envers les autres membres.</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-red-500 mr-2">2.</span>
                            <span>Publiez du contenu pertinent pour la communauté.</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-red-500 mr-2">3.</span>
                            <span>Ne faites pas de spam ou de publicité non sollicitée.</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-red-500 mr-2">4.</span>
                            <span>Respectez les droits d'auteur et la propriété intellectuelle.</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-red-500 mr-2">5.</span>
                            <span>Signalez tout contenu inapproprié aux modérateurs.</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    
    <x-slot name="scripts">
        <script>
            function votePost(postId, voteType) {
                // In a real implementation, we would make an AJAX request to the server
                @auth
                    fetch(`/posts/${postId}/vote`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ vote_type: voteType })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Reload the page to show updated votes
                            window.location.reload();
                        } else {
                            alert(data.message);
                        }
                    });
                @else
                    alert('Vous devez être connecté pour voter.');
                @endauth
            }
            
            function savePost(postId) {
                // In a real implementation, we would make an AJAX request to the server
                @auth
                    fetch(`/posts/${postId}/save`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert(data.message);
                        }
                    });
                @else
                    alert('Vous devez être connecté pour sauvegarder un post.');
                @endauth
            }
            
            function sharePost(postId) {
                // In a real implementation, we would show a share dialog
                const url = `${window.location.origin}/posts/${postId}`;
                navigator.clipboard.writeText(url).then(() => {
                    alert(`URL copiée dans le presse-papier: ${url}`);
                });
            }
        </script>
    </x-slot>
</x-layout.app>
