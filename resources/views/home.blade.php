<x-layout.app title="Accueil">
    <div class="flex flex-col md:flex-row gap-6">
        <!-- Main Content -->
        <div class="w-full md:w-3/4">
            <!-- Filter Options -->
            <div class="bg-white rounded-lg shadow mb-6 p-4">
                <div class="flex items-center space-x-4">
                    <span class="text-gray-600 font-medium">Filtrer par:</span>
                    <a href="{{ route('home', ['filter' => 'latest']) }}" class="px-3 py-1 rounded-full {{ $filter === 'latest' ? 'bg-red-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        Récents
                    </a>
                    <a href="{{ route('home', ['filter' => 'popular']) }}" class="px-3 py-1 rounded-full {{ $filter === 'popular' ? 'bg-red-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
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
                                        <a href="{{ route('communities.show', $post->community_id) }}" class="font-medium text-blue-600 hover:underline">
                                            {{ $post->community->theme_name }}
                                        </a>
                                        <span class="mx-1">•</span>
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
                    <a href="{{ route('posts.create') }}" class="inline-block px-6 py-2 bg-red-500 text-white font-medium rounded-full hover:bg-red-600 transition-colors">
                        Créer un post
                    </a>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="w-full md:w-1/4">
            <!-- Create Post Card -->
            <div class="bg-white rounded-lg shadow p-4 mb-6">
                <h3 class="text-lg font-medium mb-4">Créer un post</h3>
                <a href="{{ route('posts.create') }}" class="block w-full py-2 px-4 bg-red-500 text-white text-center font-medium rounded-full hover:bg-red-600 transition-colors">
                    Nouveau post
                </a>
            </div>

            <!-- Popular Communities -->
            <div class="bg-white rounded-lg shadow p-4 mb-6">
                <h3 class="text-lg font-medium mb-4">Communautés populaires</h3>
                @if($popularCommunities->count() > 0)
                    <div class="space-y-3">
                        @foreach($popularCommunities as $community)
                            <a href="{{ route('communities.show', $community->id) }}" class="flex items-center p-2 hover:bg-gray-50 rounded-lg">
                                <div class="w-8 h-8 bg-blue-500 rounded-full mr-3 flex items-center justify-center text-white font-bold">
                                    {{ substr($community->theme_name, 0, 1) }}
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-medium">{{ $community->theme_name }}</h4>
                                    <p class="text-xs text-gray-500">{{ $community->abonnes->count() }} membres</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                    <a href="{{ route('communities.index') }}" class="block text-center text-blue-600 hover:underline mt-4">
                        Voir toutes les communautés
                    </a>
                @else
                    <p class="text-gray-500">Aucune communauté disponible.</p>
                @endif
            </div>

            <!-- About Card -->
            <div class="bg-white rounded-lg shadow p-4">
                <h3 class="text-lg font-medium mb-3">À propos de MAReddit</h3>
                <p class="text-gray-700 mb-4">
                    MAReddit est une plateforme de discussion communautaire où vous pouvez partager vos idées, découvrir des contenus intéressants et participer à des débats sur divers sujets.
                </p>
                <div class="flex justify-between text-sm">
                    <div class="text-center">
                        <div class="font-bold text-lg">{{ $posts->count() }}</div>
                        <div class="text-gray-500">Posts</div>
                    </div>
                    <div class="text-center">
                        <div class="font-bold text-lg">{{ $popularCommunities->count() }}</div>
                        <div class="text-gray-500">Communautés</div>
                    </div>
                    <div class="text-center">
                        <div class="font-bold text-lg">{{ now()->format('Y') }}</div>
                        <div class="text-gray-500">Depuis</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="scripts">
        <script>
            function votePost(postId, voteType) {
                // In a real implementation, we would make an AJAX request to the server
                console.log(`Vote ${voteType} for post ${postId}`);
                alert(`Vous devez être connecté pour voter.`);
            }
            
            function savePost(postId) {
                // In a real implementation, we would make an AJAX request to the server
                console.log(`Save post ${postId}`);
                alert(`Vous devez être connecté pour sauvegarder un post.`);
            }
            
            function sharePost(postId) {
                // In a real implementation, we would show a share dialog
                console.log(`Share post ${postId}`);
                
                // For simplicity, just copy the URL to clipboard
                const url = `${window.location.origin}/posts/${postId}`;
                navigator.clipboard.writeText(url).then(() => {
                    alert(`URL copiée dans le presse-papier: ${url}`);
                });
            }
        </script>
    </x-slot>
</x-layout.app>
