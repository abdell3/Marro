<x-layout.app title="Posts sauvegardés">
    <div class="container mx-auto">
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Vos posts sauvegardés</h1>
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif
            
            @if($savedPosts->count() > 0)
                <div class="space-y-4">
                    @foreach($savedPosts as $post)
                        <div class="bg-white border border-gray-200 rounded-lg hover:shadow-md transition-shadow">
                            <div class="p-4">
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

                                        @if($post->media_path && $post->typeContenu === 'image')
                                            <div class="mb-3 border border-gray-200 rounded-lg overflow-hidden">
                                                <img src="{{ asset('storage/' . $post->media_path) }}?v={{ time() }}" alt="{{ $post->titre }}" class="w-full object-contain max-h-[300px]" onerror="this.style.display='none'">
                                            </div>
                                        @elseif($post->media_path && $post->typeContenu === 'video')
                                            <div class="mb-3 border border-gray-200 rounded-lg overflow-hidden">
                                                <video controls class="w-full max-h-[300px]">
                                                    <source src="{{ asset('storage/' . $post->media_path) }}" type="{{ $post->media_type }}">
                                                    Votre navigateur ne prend pas en charge la lecture de vidéos.
                                                </video>
                                            </div>
                                        @endif

                                        <div class="text-gray-700 mb-3">
                                            @if(strlen($post->contenu) > 200)
                                                {{ substr($post->contenu, 0, 200) }}...
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
                                            <button class="flex items-center text-red-500 mr-4" onclick="unsavePost({{ $post->id }})">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="currentColor" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                                                </svg>
                                                Retirer des favoris
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
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white border border-gray-200 rounded-lg p-6 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                    </svg>
                    <h3 class="text-xl font-medium text-gray-700 mb-2">Vous n'avez pas de posts sauvegardés</h3>
                    <p class="text-gray-500 mb-4">Parcourez les posts et sauvegardez ceux qui vous intéressent pour les retrouver facilement plus tard.</p>
                    <a href="{{ route('home') }}" class="inline-block px-6 py-2 bg-red-500 text-white font-medium rounded-full hover:bg-red-600 transition-colors">
                        Découvrir des posts
                    </a>
                </div>
            @endif
        </div>
    </div>

    <x-slot name="scripts">
        <script>
            function votePost(postId, voteType) {
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
            }
            
            function unsavePost(postId) {
                if (confirm('Êtes-vous sûr de vouloir retirer ce post de vos favoris ?')) {
                    fetch(`/posts/${postId}/save`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Reload the page to update the saved posts list
                            window.location.reload();
                        }
                    });
                }
            }
            
            function sharePost(postId) {
                // For simplicity, just copy the URL to clipboard
                const url = `${window.location.origin}/posts/${postId}`;
                navigator.clipboard.writeText(url).then(() => {
                    alert(`URL copiée dans le presse-papier: ${url}`);
                });
            }
        </script>
    </x-slot>
</x-layout.app>
