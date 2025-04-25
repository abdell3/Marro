<x-layout.app title="Communautés">
    <div class="container mx-auto">
        <div class="flex flex-col md:flex-row gap-6">
            <!-- Main Content -->
            <div class="w-full md:w-3/4">
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-bold text-gray-800">Toutes les communautés</h1>
                        
                        @auth
                            @if(auth()->user()->hasPermission('create-community'))
                                <a href="{{ route('communities.create') }}" class="bg-red-500 hover:bg-red-600 text-white font-medium py-2 px-4 rounded-full">
                                    Créer une communauté
                                </a>
                            @endif
                        @endauth
                    </div>
                    
                    @if($communities->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($communities as $community)
                                <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
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
                                            <p class="text-gray-700">
                                                {{ Str::limit($community->description, 100) }}
                                            </p>
                                            <div class="mt-3">
                                                @auth
                                                    @if(auth()->user()->communities->contains($community->id))
                                                        <form action="{{ route('communities.subscribe', $community->id) }}" method="POST" class="inline">
                                                            @csrf
                                                            <button type="submit" class="text-sm bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium py-1 px-3 rounded-full">
                                                                Désabonner
                                                            </button>
                                                        </form>
                                                    @else
                                                        <form action="{{ route('communities.subscribe', $community->id) }}" method="POST" class="inline">
                                                            @csrf
                                                            <button type="submit" class="text-sm bg-blue-100 hover:bg-blue-200 text-blue-800 font-medium py-1 px-3 rounded-full">
                                                                S'abonner
                                                            </button>
                                                        </form>
                                                    @endif
                                                @else
                                                    <a href="{{ route('login') }}" class="text-sm bg-blue-100 hover:bg-blue-200 text-blue-800 font-medium py-1 px-3 rounded-full">
                                                        S'abonner
                                                    </a>
                                                @endauth
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-500 mb-4">Aucune communauté n'a été créée pour le moment.</p>
                            
                            @auth
                                @if(auth()->user()->hasPermission('create-community'))
                                    <a href="{{ route('communities.create') }}" class="bg-red-500 hover:bg-red-600 text-white font-medium py-2 px-4 rounded-full">
                                        Créer la première communauté
                                    </a>
                                @endif
                            @endauth
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="w-full md:w-1/4">
                <!-- About Communities -->
                <div class="bg-white rounded-lg shadow p-4 mb-6">
                    <h3 class="text-lg font-medium mb-3">À propos des communautés</h3>
                    <p class="text-gray-700 mb-4">
                        Les communautés sont des groupes créés par des utilisateurs pour discuter de sujets spécifiques. Rejoignez celles qui vous intéressent et participez aux discussions !
                    </p>
                    
                    @auth
                        @if(auth()->user()->hasPermission('create-community'))
                            <a href="{{ route('communities.create') }}" class="block text-center bg-red-500 hover:bg-red-600 text-white font-medium py-2 px-4 rounded-full">
                                Créer une communauté
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="block text-center bg-red-500 hover:bg-red-600 text-white font-medium py-2 px-4 rounded-full">
                            Connexion pour créer
                        </a>
                    @endauth
                </div>
                
                <!-- Community Guidelines -->
                <div class="bg-white rounded-lg shadow p-4">
                    <h3 class="text-lg font-medium mb-3">Règles des communautés</h3>
                    <ul class="space-y-2 text-gray-700">
                        <li class="flex items-start">
                            <span class="text-red-500 mr-2">•</span>
                            <span>Respectez les autres membres de la communauté.</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-red-500 mr-2">•</span>
                            <span>Publiez du contenu pertinent pour la communauté.</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-red-500 mr-2">•</span>
                            <span>Ne faites pas de spam ou de publicité non sollicitée.</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-red-500 mr-2">•</span>
                            <span>Respectez les droits d'auteur et la propriété intellectuelle.</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-red-500 mr-2">•</span>
                            <span>Signalez tout contenu inapproprié aux modérateurs.</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-layout.app>
