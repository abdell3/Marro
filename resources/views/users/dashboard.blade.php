<x-layout.app title="Tableau de bord">
    <div class="container mx-auto">
        <div class="flex flex-col md:flex-row gap-6">
            <!-- Main Content -->
            <div class="w-full md:w-3/4">
                <!-- Welcome Section -->
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <h1 class="text-2xl font-bold text-gray-800 mb-2">Bienvenue, {{ $user->prenom }}!</h1>
                    <p class="text-gray-600">Voici un résumé de votre activité sur Marro.</p>
                </div>
                
                <!-- Activity Stats -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                    <div class="bg-white rounded-lg shadow p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-xs font-medium text-gray-500 uppercase tracking-wider">Posts</h3>
                                <p class="text-2xl font-bold text-gray-800">{{ $posts->count() }}</p>
                            </div>
                            <div class="bg-red-100 p-3 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-lg shadow p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-xs font-medium text-gray-500 uppercase tracking-wider">Commentaires</h3>
                                <p class="text-2xl font-bold text-gray-800">{{ $user->comments->count() }}</p>
                            </div>
                            <div class="bg-blue-100 p-3 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-lg shadow p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-xs font-medium text-gray-500 uppercase tracking-wider">Votes</h3>
                                <p class="text-2xl font-bold text-gray-800">{{ $user->polls->count() }}</p>
                            </div>
                            <div class="bg-green-100 p-3 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-lg shadow p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-xs font-medium text-gray-500 uppercase tracking-wider">Communautés</h3>
                                <p class="text-2xl font-bold text-gray-800">{{ $user->communities->count() }}</p>
                            </div>
                            <div class="bg-purple-100 p-3 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Recent Posts -->
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold text-gray-800">Vos posts récents</h2>
                        <a href="{{ route('posts.create') }}" class="text-sm font-medium text-red-600 hover:underline">Créer un post</a>
                    </div>
                    
                    @if($posts->count() > 0)
                        <div class="space-y-4">
                            @foreach($posts->take(5) as $post)
                                <div class="flex items-start p-4 border border-gray-200 rounded-lg">
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
                                            <span>{{ $post->datePublication->diffForHumans() }}</span>
                                            <span class="mx-1">•</span>
                                            <span>{{ $post->commentaires->count() }} commentaires</span>
                                        </div>
                                        <div class="flex space-x-2">
                                            <a href="{{ route('posts.show', $post->id) }}" class="text-sm text-gray-600 hover:text-gray-800">Voir</a>
                                            <a href="{{ route('posts.edit', $post->id) }}" class="text-sm text-blue-600 hover:text-blue-800">Modifier</a>
                                            <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce post?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-sm text-red-600 hover:text-red-800">Supprimer</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        @if($posts->count() > 5)
                            <div class="mt-4 text-center">
                                <a href="#" class="text-sm font-medium text-gray-600 hover:underline">Voir tous vos posts</a>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-4">
                            <p class="text-gray-500 mb-4">Vous n'avez pas encore créé de posts.</p>
                            <a href="{{ route('posts.create') }}" class="inline-block px-4 py-2 bg-red-500 text-white font-medium rounded-full hover:bg-red-600">
                                Créer votre premier post
                            </a>
                        </div>
                    @endif
                </div>
                
                <!-- Saved Posts -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold text-gray-800">Posts sauvegardés</h2>
                        <a href="{{ route('saved-posts') }}" class="text-sm font-medium text-red-600 hover:underline">Voir tous</a>
                    </div>
                    
                    @if($savedPosts->count() > 0)
                        <div class="space-y-4">
                            @foreach($savedPosts->take(3) as $post)
                                <div class="flex items-start p-4 border border-gray-200 rounded-lg">
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
                                        <div class="flex items-center text-xs text-gray-500 mb-1">
                                            <a href="{{ route('communities.show', $post->community_id) }}" class="font-medium text-blue-600 hover:underline">
                                                {{ $post->community->theme_name }}
                                            </a>
                                            <span class="mx-1">•</span>
                                            <span>Posté par <a href="#" class="hover:underline">{{ $post->auteur->prenom }} {{ $post->auteur->nom }}</a></span>
                                            <span class="mx-1">•</span>
                                            <span>{{ $post->datePublication->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <p class="text-gray-500">Vous n'avez pas encore sauvegardé de posts.</p>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="w-full md:w-1/4">
                <!-- User Profile Card -->
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <div class="flex flex-col items-center">
                        <div class="w-20 h-20 bg-red-500 rounded-full flex items-center justify-center text-white text-2xl font-bold mb-3">
                            {{ substr($user->prenom, 0, 1) . substr($user->nom, 0, 1) }}
                        </div>
                        <h2 class="text-xl font-bold text-gray-800">{{ $user->prenom }} {{ $user->nom }}</h2>
                        <p class="text-gray-500">{{ $user->email }}</p>
                        
                        @if($user->badge)
                            <div class="mt-2 flex items-center">
                                <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7" />
                                    </svg>
                                    {{ $user->badge->nom }}
                                </span>
                            </div>
                        @endif
                        
                        <div class="mt-4 w-full border-t border-gray-200 pt-4">
                            <div class="flex justify-between text-sm">
                                <div class="text-center">
                                    <div class="font-bold">{{ $posts->count() }}</div>
                                    <div class="text-gray-500">Posts</div>
                                </div>
                                <div class="text-center">
                                    <div class="font-bold">{{ $user->comments->count() }}</div>
                                    <div class="text-gray-500">Commentaires</div>
                                </div>
                                <div class="text-center">
                                    <div class="font-bold">{{ $user->communities->count() }}</div>
                                    <div class="text-gray-500">Communautés</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-5 w-full">
                            <a href="{{ route('profile') }}" class="block text-center bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium py-2 px-4 rounded-lg">
                                Modifier le profil
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Communities You're In -->
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <h3 class="text-lg font-medium mb-4">Vos communautés</h3>
                    
                    @if($user->communities->count() > 0)
                        <div class="space-y-3">
                            @foreach($user->communities->take(5) as $community)
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
                        
                        @if($user->communities->count() > 5)
                            <div class="mt-3 text-center">
                                <a href="{{ route('user.communities') }}" class="text-sm font-medium text-red-600 hover:underline">
                                    Voir toutes vos communautés
                                </a>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-3">
                            <p class="text-gray-500 mb-3">Vous n'avez rejoint aucune communauté.</p>
                            <a href="{{ route('communities.index') }}" class="text-sm font-medium text-red-600 hover:underline">
                                Découvrir des communautés
                            </a>
                        </div>
                    @endif
                </div>
                
                <!-- Quick Links -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-medium mb-4">Liens rapides</h3>
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('posts.create') }}" class="flex items-center text-gray-700 hover:text-red-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Créer un post
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('communities.index') }}" class="flex items-center text-gray-700 hover:text-red-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                Explorer les communautés
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('saved-posts') }}" class="flex items-center text-gray-700 hover:text-red-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                                </svg>
                                Posts sauvegardés
                            </a>
                        </li>
                        @if($user->hasRole('admin') || $user->hasRole('moderator'))
                            <li>
                                <a href="{{ route('moderation') }}" class="flex items-center text-gray-700 hover:text-red-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                    Modération
                                </a>
                            </li>
                        @endif
                        @if($user->hasRole('admin'))
                            <li>
                                <a href="{{ route('admin.dashboard') }}" class="flex items-center text-gray-700 hover:text-red-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    Administration
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-layout.app>
