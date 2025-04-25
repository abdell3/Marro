<x-layout.app :title="$post->titre">
    <div class="container mx-auto">
        <div class="flex flex-col md:flex-row gap-6">
            <!-- Main Content -->
            <div class="w-full md:w-3/4">
                <!-- Post -->
                <div class="bg-white rounded-lg shadow p-6 mb-6">
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
                            <div class="flex items-center text-xs text-gray-500 mb-2">
                                <a href="{{ route('communities.show', $post->community_id) }}" class="font-medium text-blue-600 hover:underline">
                                    {{ $post->community->theme_name }}
                                </a>
                                <span class="mx-1">•</span>
                                <span>Posté par <a href="#" class="hover:underline">{{ $post->auteur->prenom }} {{ $post->auteur->nom }}</a></span>
                                <span class="mx-1">•</span>
                                <span>{{ $post->datePublication->diffForHumans() }}</span>
                            </div>

                            <h1 class="text-2xl font-bold text-gray-800 mb-4">{{ $post->titre }}</h1>

                            @if($post->media_path)
                                <div class="mb-6 border border-gray-200 rounded-lg overflow-hidden">
                                    @if(str_starts_with($post->media_type, 'image/'))
                                        <img src="{{ asset('storage/' . $post->media_path) }}" alt="{{ $post->titre }}" class="w-full object-contain max-h-[500px]">
                                    @elseif(str_starts_with($post->media_type, 'video/'))
                                        <video controls class="w-full max-h-[500px]">
                                            <source src="{{ asset('storage/' . $post->media_path) }}" type="{{ $post->media_type }}">
                                            Votre navigateur ne prend pas en charge la lecture de vidéos.
                                        </video>
                                    @endif
                                </div>
                            @endif

                            <div class="text-gray-700 mb-6 prose max-w-none">
                                {!! nl2br(e($post->contenu)) !!}
                            </div>

                            @if($post->tags->count() > 0)
                                <div class="flex flex-wrap gap-2 mb-4">
                                    @foreach($post->tags as $tag)
                                        <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded">
                                            {{ $tag->title }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif

                            <!-- Post Actions -->
                            <div class="flex items-center text-gray-500 text-sm border-t border-gray-200 pt-4 mt-4">
                                <button class="flex items-center hover:text-gray-700 mr-6" onclick="savePost({{ $post->id }})">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                                    </svg>
                                    Sauvegarder
                                </button>
                                <button class="flex items-center hover:text-gray-700 mr-6" onclick="sharePost({{ $post->id }})">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                                    </svg>
                                    Partager
                                </button>
                                <button class="flex items-center hover:text-gray-700" onclick="toggleReportModal()">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9" />
                                    </svg>
                                    Signaler
                                </button>

                                @auth
                                    @if(auth()->id() === $post->auteur_id || auth()->user()->hasPermission('update-post'))
                                        <div class="ml-auto flex">
                                            <a href="{{ route('posts.edit', $post->id) }}" class="flex items-center hover:text-blue-600 mr-4">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                                Modifier
                                            </a>
                                            <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce post?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="flex items-center hover:text-red-600">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                    Supprimer
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Comments Section -->
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Commentaires ({{ $comments->count() }})</h2>
                    
                    @auth
                        <form action="{{ route('comments.store') }}" method="POST" class="mb-6">
                            @csrf
                            <input type="hidden" name="post_id" value="{{ $post->id }}">
                            <div class="mb-4">
                                <textarea name="contenu" rows="3" placeholder="Écrivez votre commentaire..."
                                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 resize-none"></textarea>
                            </div>
                            <div class="flex justify-end">
                                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-full hover:bg-blue-600 focus:outline-none focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    Commenter
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="bg-blue-50 p-4 rounded-lg mb-6">
                            <p class="text-blue-700">
                                <a href="{{ route('login') }}" class="font-medium hover:underline">Connectez-vous</a> ou 
                                <a href="{{ route('register') }}" class="font-medium hover:underline">inscrivez-vous</a> 
                                pour laisser un commentaire.
                            </p>
                        </div>
                    @endauth
                    
                    @if($comments->count() > 0)
                        <div class="space-y-6">
                            @foreach($comments as $comment)
                                <div id="comment-{{ $comment->id }}" class="border-b border-gray-200 pb-4 last:border-0 last:pb-0">
                                    <div class="flex">
                                        <div class="flex-shrink-0 mr-3">
                                            <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center overflow-hidden">
                                                <span class="text-sm font-medium">{{ substr($comment->auteur->prenom, 0, 1) . substr($comment->auteur->nom, 0, 1) }}</span>
                                            </div>
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex items-center mb-1">
                                                <span class="font-medium">{{ $comment->auteur->prenom }} {{ $comment->auteur->nom }}</span>
                                                <span class="mx-1">•</span>
                                                <span class="text-xs text-gray-500">{{ $comment->datePublication->diffForHumans() }}</span>
                                            </div>
                                            <div class="text-gray-700 mb-2">
                                                {!! nl2br(e($comment->contenu)) !!}
                                            </div>
                                            <div class="flex items-center text-xs text-gray-500">
                                                <button class="hover:text-gray-700 mr-3" onclick="toggleReplyForm({{ $comment->id }})">
                                                    Répondre
                                                </button>
                                                <button class="hover:text-gray-700 mr-3" onclick="toggleCommentReportModal({{ $comment->id }})">
                                                    Signaler
                                                </button>
                                                
                                                @auth
                                                    @if(auth()->id() === $comment->auteur_id || auth()->user()->hasPermission('update-comment'))
                                                        <a href="{{ route('comments.edit', $comment->id) }}" class="hover:text-blue-600 mr-3">
                                                            Modifier
                                                        </a>
                                                        <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce commentaire?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="hover:text-red-600">
                                                                Supprimer
                                                            </button>
                                                        </form>
                                                    @endif
                                                @endauth
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Afficher les réponses à ce commentaire -->
                                    @foreach($comment->replies as $reply)
                                        <div id="comment-{{ $reply->id }}" class="flex mt-3 ml-11 border-t border-gray-100 pt-3">
                                            <div class="flex-shrink-0 mr-3">
                                                <div class="w-6 h-6 bg-gray-300 rounded-full flex items-center justify-center overflow-hidden">
                                                    <span class="text-xs font-medium">{{ substr($reply->auteur->prenom, 0, 1) . substr($reply->auteur->nom, 0, 1) }}</span>
                                                </div>
                                            </div>
                                            <div class="flex-1">
                                                <div class="flex items-center mb-1">
                                                    <span class="font-medium text-sm">{{ $reply->auteur->prenom }} {{ $reply->auteur->nom }}</span>
                                                    <span class="mx-1 text-xs">•</span>
                                                    <span class="text-xs text-gray-500">{{ $reply->datePublication->diffForHumans() }}</span>
                                                </div>
                                                <div class="text-gray-700 mb-2 text-sm">
                                                    {!! nl2br(e($reply->contenu)) !!}
                                                </div>
                                                <div class="flex items-center text-xs text-gray-500">
                                                    <button class="hover:text-gray-700 mr-3" onclick="toggleReplyForm({{ $comment->id }})">
                                                        Répondre
                                                    </button>
                                                    <button class="hover:text-gray-700 mr-3" onclick="toggleCommentReportModal({{ $reply->id }})">
                                                        Signaler
                                                    </button>
                                                    
                                                    @auth
                                                        @if(auth()->id() === $reply->auteur_id || auth()->user()->hasPermission('update-comment'))
                                                            <a href="{{ route('comments.edit', $reply->id) }}" class="hover:text-blue-600 mr-3">
                                                                Modifier
                                                            </a>
                                                            <form action="{{ route('comments.destroy', $reply->id) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce commentaire?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="hover:text-red-600">
                                                                    Supprimer
                                                                </button>
                                                            </form>
                                                        @endif
                                                    @endauth
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-4">Aucun commentaire pour le moment. Soyez le premier à commenter!</p>
                    @endif
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="w-full md:w-1/4">
                <!-- Community Card -->
                <div class="bg-white rounded-lg shadow p-4 mb-6">
                    <h3 class="text-lg font-medium mb-3">À propos de la communauté</h3>
                    <a href="{{ route('communities.show', $post->community_id) }}" class="flex items-center mb-4">
                        <div class="w-10 h-10 bg-blue-500 rounded-full mr-3 flex items-center justify-center text-white font-bold">
                            {{ substr($post->community->theme_name, 0, 1) }}
                        </div>
                        <div>
                            <h4 class="font-medium">{{ $post->community->theme_name }}</h4>
                            <p class="text-xs text-gray-500">{{ $post->community->abonnes->count() }} membres</p>
                        </div>
                    </a>
                    <p class="text-gray-700 text-sm mb-4">{{ Str::limit($post->community->description, 150) }}</p>
                    <div class="border-t border-gray-200 pt-4">
                        @auth
                            @if(auth()->user()->communities->contains($post->community_id))
                                <form action="{{ route('communities.subscribe', $post->community_id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="block w-full py-2 px-4 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium rounded-full">
                                        Désabonner
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('communities.subscribe', $post->community_id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="block w-full py-2 px-4 bg-blue-500 hover:bg-blue-600 text-white font-medium rounded-full">
                                        S'abonner
                                    </button>
                                </form>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="block w-full py-2 px-4 bg-blue-500 hover:bg-blue-600 text-white text-center font-medium rounded-full">
                                Connectez-vous pour vous abonner
                            </a>
                        @endauth
                    </div>
                </div>
                
                <!-- Post Info -->
                <div class="bg-white rounded-lg shadow p-4 mb-6">
                    <h3 class="text-lg font-medium mb-3">Informations sur le post</h3>
                    <div class="space-y-2 text-sm text-gray-700">
                        <div class="flex justify-between">
                            <span>Type de contenu:</span>
                            <span class="font-medium">{{ ucfirst($post->typeContenu) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Posté par:</span>
                            <span class="font-medium">{{ $post->auteur->prenom }} {{ $post->auteur->nom }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Date:</span>
                            <span class="font-medium">{{ $post->datePublication->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Votes:</span>
                            <span class="font-medium">{{ $post->like }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Commentaires:</span>
                            <span class="font-medium">{{ $comments->count() }}</span>
                        </div>
                    </div>
                </div>
                
                <!-- Create Post Card -->
                <div class="bg-white rounded-lg shadow p-4">
                    <h3 class="text-lg font-medium mb-3">Créer un post</h3>
                    @auth
                        <a href="{{ route('posts.create', ['community_id' => $post->community_id]) }}" class="block w-full py-2 px-4 bg-red-500 text-white text-center font-medium rounded-full hover:bg-red-600 transition-colors">
                            Nouveau post
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="block w-full py-2 px-4 bg-red-500 text-white text-center font-medium rounded-full hover:bg-red-600 transition-colors">
                            Connectez-vous pour créer un post
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
    
    <!-- Report Post Modal (hidden by default) -->
    <div id="reportPostModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-lg max-w-md w-full p-6 mx-4">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-gray-900">Signaler le post</h3>
                <button onclick="toggleReportModal()" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <form action="{{ route('posts.report', $post->id) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="report_type_id" class="block text-gray-700 text-sm font-medium mb-2">Raison du signalement</label>
                    <select id="report_type_id" name="report_type_id" class="w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5">
                        <option value="1">Contenu inapproprié</option>
                        <option value="2">Spam</option>
                        <option value="3">Harcèlement</option>
                        <option value="4">Fausse information</option>
                        <option value="5">Contenu illégal</option>
                        <option value="6">Autre</option>
                    </select>
                </div>
                
                <div class="mb-4">
                    <label for="reason" class="block text-gray-700 text-sm font-medium mb-2">Description détaillée</label>
                    <textarea id="reason" name="reason" rows="3" class="w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5" placeholder="Veuillez expliquer le problème..."></textarea>
                </div>
                
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="toggleReportModal()" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-300">
                        Annuler
                    </button>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50">
                        Signaler
                    </button>
                </div>
            </form>
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
            
            function toggleReportModal() {
                @auth
                    const modal = document.getElementById('reportPostModal');
                    modal.classList.toggle('hidden');
                @else
                    alert('Vous devez être connecté pour signaler un post.');
                @endauth
            }
            
            function toggleCommentReportModal(commentId) {
                @auth
                    alert('Fonctionnalité de signalement de commentaire à implémenter.');
                @else
                    alert('Vous devez être connecté pour signaler un commentaire.');
                @endauth
            }
            
            function toggleReplyForm(commentId) {
                @auth
                    const replyFormId = `reply-form-${commentId}`;
                    const replyForm = document.getElementById(replyFormId);
                    
                    if (replyForm) {
                        // Si le formulaire existe déjà, basculer sa visibilité
                        replyForm.classList.toggle('hidden');
                    } else {
                        // Créer le formulaire s'il n'existe pas encore
                        const commentElement = document.getElementById(`comment-${commentId}`);
                        if (!commentElement) return;
                        
                        const formContainer = document.createElement('div');
                        formContainer.id = replyFormId;
                        formContainer.className = 'mt-3 pl-11';
                        formContainer.innerHTML = `
                            <form action="{{ route('comments.store') }}" method="POST" class="mb-4">
                                @csrf
                                <input type="hidden" name="post_id" value="{{ $post->id }}">
                                <input type="hidden" name="parent_id" value="${commentId}">
                                <div class="mb-2">
                                    <textarea name="contenu" rows="2" placeholder="Écrivez votre réponse..."
                                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 resize-none text-sm"></textarea>
                                </div>
                                <div class="flex justify-end space-x-2">
                                    <button type="button" onclick="toggleReplyForm(${commentId})" class="px-3 py-1 text-sm bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                                        Annuler
                                    </button>
                                    <button type="submit" class="px-3 py-1 text-sm bg-blue-500 text-white rounded-md hover:bg-blue-600">
                                        Répondre
                                    </button>
                                </div>
                            </form>
                        `;
                        
                        commentElement.appendChild(formContainer);
                    }
                @else
                    alert('Vous devez être connecté pour répondre à un commentaire.');
                @endauth
            }
        </script>
    </x-slot>
</x-layout.app>
