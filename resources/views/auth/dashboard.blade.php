@extends('layouts.app')

@section('content')
<div class="container py-6 max-w-6xl mx-auto">
    <div class="flex flex-col md:flex-row gap-6">
        <!-- Main Content -->
        <div class="md:w-2/3">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 mb-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-bold">Votre Fil d'Actualité</h2>
                    <div class="flex space-x-2">
                        <a href="{{ route('home', ['sort' => 'popular']) }}" class="px-3 py-1 rounded-full {{ request('sort', 'popular') === 'popular' ? 'bg-orange-100 text-orange-700 dark:bg-orange-900 dark:text-orange-100' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                            Populaire
                        </a>
                        <a href="{{ route('home', ['sort' => 'new']) }}" class="px-3 py-1 rounded-full {{ request('sort') === 'new' ? 'bg-orange-100 text-orange-700 dark:bg-orange-900 dark:text-orange-100' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                            Nouveau
                        </a>
                        <a href="{{ route('home', ['sort' => 'top']) }}" class="px-3 py-1 rounded-full {{ request('sort') === 'top' ? 'bg-orange-100 text-orange-700 dark:bg-orange-900 dark:text-orange-100' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                            Top
                        </a>
                    </div>
                </div>

                @if($posts->count() > 0)
                    <div class="space-y-4">
                        @foreach($posts as $post)
                            <div class="border-b dark:border-gray-700 pb-4 last:border-0 last:pb-0">
                                <div class="flex">
                                    <!-- Votes section -->
                                    <div class="flex flex-col items-center mr-3">
                                        <button 
                                            class="p-1 rounded-md hover:bg-gray-200 dark:hover:bg-gray-600 {{ $post->isUpvotedBy(auth()->user()) ? 'text-orange-500' : '' }}"
                                            onclick="document.getElementById('upvote-form-{{ $post->id }}').submit()"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m18 15-6-6-6 6"/></svg>
                                        </button>
                                        
                                        <form id="upvote-form-{{ $post->id }}" action="{{ route('posts.upvote', $post->id) }}" method="POST" class="hidden">
                                            @csrf
                                        </form>
                                        
                                        <span class="text-sm font-medium my-1">{{ $post->votes_count }}</span>
                                        
                                        <button 
                                            class="p-1 rounded-md hover:bg-gray-200 dark:hover:bg-gray-600 {{ $post->isDownvotedBy(auth()->user()) ? 'text-blue-500' : '' }}"
                                            onclick="document.getElementById('downvote-form-{{ $post->id }}').submit()"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                                        </button>
                                        
                                        <form id="downvote-form-{{ $post->id }}" action="{{ route('posts.downvote', $post->id) }}" method="POST" class="hidden">
                                            @csrf
                                        </form>
                                    </div>

                                    <div class="flex-1">
                                        <div class="flex items-center text-sm text-gray-500 mb-1">
                                            <a href="{{ route('communities.show', $post->community) }}" class="font-medium text-gray-900 dark:text-white hover:underline">
                                                c/{{ $post->community->name }}
                                            </a>
                                            <span class="mx-1">•</span>
                                            <span>Posté par 
                                                <a href="{{ route('users.show', $post->user) }}" class="hover:underline">
                                                    u/{{ $post->user->username }}
                                                </a>
                                            </span>
                                            <span class="mx-1">•</span>
                                            <span>{{ $post->created_at->diffForHumans() }}</span>
                                        </div>

                                        <a href="{{ route('posts.show', $post) }}" class="block">
                                            <h3 class="text-lg font-semibold mb-2 hover:text-orange-500">{{ $post->title }}</h3>
                                            
                                            @if($post->content)
                                                <div class="prose dark:prose-invert max-w-none line-clamp-2 mb-2">
                                                    {{ Str::limit(strip_tags($post->content), 200 }}
                                                </div>
                                            @endif
                                            
                                            @if($post->image_path)
                                                <div class="mb-2">
                                                    <img src="{{ Storage::url($post->image_path) }}" alt="Image du post" class="max-h-48 rounded-lg">
                                                </div>
                                            @endif
                                        </a>

                                        <div class="flex space-x-4 text-gray-500 text-sm">
                                            <a href="{{ route('posts.show', $post) }}" class="flex items-center gap-1 hover:text-gray-700 dark:hover:text-gray-300">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                                                <span>{{ $post->comments_count }} Commentaires</span>
                                            </a>
                                            
                                            <button class="flex items-center gap-1 hover:text-gray-700 dark:hover:text-gray-300" onclick="sharePost('{{ route('posts.show', $post) }}', '{{ $post->title }}')">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"></path><polyline points="16 6 12 2 8 6"></polyline><line x1="12" y1="2" x2="12" y2="15"></line></svg>
                                                <span>Partager</span>
                                            </button>
                                            
                                            <button class="flex items-center gap-1 hover:text-gray-700 dark:hover:text-gray-300" onclick="savePost('{{ $post->id }}')">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="{{ $post->isSavedBy(auth()->user()) ? 'fill-current text-orange-500' : '' }}"><path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path></svg>
                                                <span>{{ $post->isSavedBy(auth()->user()) ? 'Sauvegardé' : 'Sauvegarder' }}</span>
                                            </button>
                                            
                                            @if(auth()->check())
                                                <button class="flex items-center gap-1 hover:text-gray-700 dark:hover:text-gray-300" 
                                                        onclick="openReportModal('App\\Models\\Post', '{{ $post->id }}', '{{ $post->title }}')">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z"></path><line x1="4" y1="22" x2="4" y2="15"></line></svg>
                                                    <span>Signaler</span>
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="mt-4">
                        {{ $posts->links() }}
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mx-auto mb-4 text-gray-400"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>
                        <h3 class="text-lg font-medium mb-2">Votre fil d'actualité est vide</h3>
                        <p class="text-gray-500 dark:text-gray-400 mb-4">Rejoignez des communautés pour voir des posts dans votre fil</p>
                        <a href="{{ route('communities.index') }}" class="px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 inline-block">
                            Découvrir des Communautés
                        </a>
                    </div>
                @endif
            </div>

            <!-- Vos Activités -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 mb-6">
                <h2 class="text-xl font-bold mb-4">Vos Activités Récentes</h2>
                
                @if($activities->count() > 0)
                    <div class="space-y-4">
                        @foreach($activities as $activity)
                            <div class="border-b dark:border-gray-700 pb-4 last:border-0 last:pb-0">
                                <div class="flex items-start">
                                    <div class="mr-3">
                                        @if($activity->type === 'post')
                                            <div class="p-2 bg-orange-100 dark:bg-orange-900 rounded-full">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-orange-500"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                                            </div>
                                        @elseif($activity->type === 'comment')
                                            <div class="p-2 bg-blue-100 dark:bg-blue-900 rounded-full">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-500"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                                            </div>
                                        @elseif($activity->type === 'vote')
                                            <div class="p-2 bg-green-100 dark:bg-green-900 rounded-full">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-green-500"><path d="m18 15-6-6-6 6"/></svg>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <div class="flex-1">
                                        <div class="text-sm text-gray-500 mb-1">
                                            @if($activity->type === 'post')
                                                Vous avez posté dans 
                                            @elseif($activity->type === 'comment')
                                                Vous avez commenté dans 
                                            @elseif($activity->type === 'vote')
                                                Vous avez voté dans 
                                            @endif
                                            <a href="{{ route('communities.show', $activity->community) }}" class="font-medium hover:underline">
                                                c/{{ $activity->community->name }}
                                            </a>
                                            <span class="mx-1">•</span>
                                            <span>{{ $activity->created_at->diffForHumans() }}</span>
                                        </div>
                                        
                                        <a href="{{ $activity->url }}" class="block hover:text-orange-500">
                                            <p class="font-medium">{{ $activity->title }}</p>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="mt-4 text-center">
                        <a href="{{ route('users.activities') }}" class="text-orange-500 hover:underline">
                            Voir Toutes les Activités
                        </a>
                    </div>
                @else
                    <div class="text-center py-4">
                        <p class="text-gray-500 dark:text-gray-400">Vous n'avez pas encore posté ou commenté.</p>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Sidebar -->
        <div class="md:w-1/3">
            <!-- Carte Utilisateur -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 mb-6">
                <div class="flex items-center mb-4">
                    <div class="h-12 w-12 bg-orange-500 rounded-full flex items-center justify-center text-white font-bold text-xl mr-3">
                        {{ substr(auth()->user()->username, 0, 1) }}
                    </div>
                    <div>
                        <h3 class="font-bold">{{ auth()->user()->name }}</h3>
                        <p class="text-sm text-gray-500">u/{{ auth()->user()->username }}</p>
                    </div>
                </div>
                
                <div class="flex justify-between text-center border-t dark:border-gray-700 pt-4">
                    <div>
                        <p class="font-bold">{{ auth()->user()->posts_count }}</p>
                        <p class="text-sm text-gray-500">Posts</p>
                    </div>
                    <div>
                        <p class="font-bold">{{ auth()->user()->comments_count }}</p>
                        <p class="text-sm text-gray-500">Commentaires</p>
                    </div>
                    <div>
                        <p class="font-bold">{{ auth()->user()->karma }}</p>
                        <p class="text-sm text-gray-500">Karma</p>
                    </div>
                </div>
                
                <div class="mt-4">
                    <a href="{{ route('users.show', auth()->user()) }}" class="block w-full py-2 bg-orange-500 text-white text-center rounded-lg hover:bg-orange-600">
                        Voir Profil
                    </a>
                </div>
            </div>
            
            <!-- Vos Communautés -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 mb-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-bold">Vos Communautés</h3>
                    <a href="{{ route('communities.index') }}" class="text-sm text-orange-500 hover:underline">
                        En trouver plus
                    </a>
                </div>
                
                @if($userCommunities->count() > 0)
                    <div class="space-y-3">
                        @foreach($userCommunities as $community)
                            <a href="{{ route('communities.show', $community) }}" class="flex items-center hover:bg-gray-100 dark:hover:bg-gray-700 p-2 rounded-lg">
                                <div class="h-8 w-8 bg-white dark:bg-gray-700 rounded-full border-2 border-orange-500 flex items-center justify-center text-orange-500 font-bold mr-3">
                                    {{ substr($community->name, 0, 1) }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-medium truncate">c/{{ $community->name }}</p>
                                    <p class="text-xs text-gray-500 truncate">{{ number_format($community->members_count) }} membres</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                    
                    <div class="mt-4 text-center">
                        <a href="{{ route('users.communities') }}" class="text-orange-500 hover:underline">
                            Voir Toutes les Communautés
                        </a>
                    </div>
                @else
                    <div class="text-center py-4">
                        <p class="text-gray-500 dark:text-gray-400 mb-4">Vous n'avez rejoint aucune communauté.</p>
                        <a href="{{ route('communities.index') }}" class="px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 inline-block">
                            Découvrir des Communautés
                        </a>
                    </div>
                @endif
            </div>
            
            <!-- Communautés Tendances -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                <h3 class="font-bold mb-4">Communautés Populaires</h3>
                
                <div class="space-y-3">
                    @foreach($trendingCommunities as $community)
                        <a href="{{ route('communities.show', $community) }}" class="flex items-center hover:bg-gray-100 dark:hover:bg-gray-700 p-2 rounded-lg">
                            <div class="h-8 w-8 bg-white dark:bg-gray-700 rounded-full border-2 border-orange-500 flex items-center justify-center text-orange-500 font-bold mr-3">
                                {{ substr($community->name, 0, 1) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-medium truncate">c/{{ $community->name }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ number_format($community->members_count) }} membres</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal de Signalement -->
    <div id="reportModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 max-w-md w-full mx-4">
            <h3 class="text-lg font-bold mb-4">Signaler un contenu</h3>
            <p class="mb-2">Vous signalez: <span id="reportContentTitle" class="font-medium"></span></p>
            
            <form id="reportForm" action="{{ route('reports.store') }}" method="POST">
                @csrf
                <input type="hidden" name="reportable_type" id="reportableType">
                <input type="hidden" name="reportable_id" id="reportableId">
                
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2">Raison du signalement:</label>
                    <select name="reason" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600" required>
                        <option value="">Sélectionnez une raison</option>
                        <option value="spam">Spam</option>
                        <option value="harassment">Harcèlement</option>
                        <option value="hate_speech">Discours haineux</option>
                        <option value="misinformation">Désinformation</option>
                        <option value="violence">Incitation à la violence</option>
                        <option value="illegal_content">Contenu illégal</option>
                        <option value="self_harm">Automutilation ou suicide</option>
                        <option value="other">Autre</option>
                    </select>
                </div>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2">Informations supplémentaires (optionnel):</label>
                    <textarea 
                        name="description" 
                        class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600"
                        rows="3"
                        placeholder="Veuillez fournir des détails supplémentaires pour aider les modérateurs"
                    ></textarea>
                </div>
                
                <div class="flex justify-end space-x-2">
                    <button type="button" class="px-4 py-2 border rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700" onclick="closeReportModal()">
                        Annuler
                    </button>
                    <button type="submit" class="px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600">
                        Envoyer le signalement
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function sharePost(url, title) {
        if (navigator.share) {
            navigator.share({
                title: title,
                url: url
            })
            .catch(console.error);
        } else {
            // Fallback pour les navigateurs qui ne supportent pas l'API Web Share
            const tempInput = document.createElement('input');
            document.body.appendChild(tempInput);
            tempInput.value = url;
            tempInput.select();
            document.execCommand('copy');
            document.body.removeChild(tempInput);
            
            alert('Lien copié dans le presse-papiers !');
        }
    }
    
    function savePost(postId) {
        fetch(`/posts/${postId}/toggle-save`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            }
        })
        .catch(error => console.error('Error:', error));
    }
    
    // Fonctions pour le modal de signalement
    function openReportModal(type, id, title) {
        document.getElementById('reportableType').value = type;
        document.getElementById('reportableId').value = id;
        document.getElementById('reportContentTitle').textContent = title;
        document.getElementById('reportModal').classList.remove('hidden');
    }
    
    function closeReportModal() {
        document.getElementById('reportModal').classList.add('hidden');
        document.getElementById('reportForm').reset();
    }
</script>
@endpush
@endsection