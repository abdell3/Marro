<x-layout.app title="Mes Communautés">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Mes Communautés</h1>
                <a href="{{ route('communities.index') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-full">
                    Découvrir des communautés
                </a>
            </div>
            
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif
            
            @if ($communities->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach ($communities as $community)
                        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                            <div class="flex items-center mb-2">
                                <div class="w-10 h-10 bg-blue-500 rounded-full mr-3 flex items-center justify-center text-white font-bold">
                                    {{ substr($community->theme_name, 0, 1) }}
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-medium">{{ $community->theme_name }}</h3>
                                    <p class="text-xs text-gray-500">{{ $community->abonnes->count() }} membres</p>
                                </div>
                            </div>
                            <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ Str::limit($community->description, 100) }}</p>
                            <div class="flex justify-between items-center">
                                <a href="{{ route('communities.show', $community->id) }}" class="text-blue-600 hover:underline text-sm font-medium">
                                    Voir les posts
                                </a>
                                <form action="{{ route('communities.subscribe', $community->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-sm bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-1 px-3 rounded-full">
                                        Désabonner
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-gray-50 p-6 rounded-lg text-center">
                    <div class="text-gray-500 mb-4">Vous n'êtes abonné à aucune communauté.</div>
                    <a href="{{ route('communities.index') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-full inline-block">
                        Découvrir des communautés
                    </a>
                </div>
            @endif
        </div>
        
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Communautés populaires à découvrir</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach (\App\Models\Community::where('id', 'NOT IN', $communities->pluck('id')->toArray())->withCount('abonnes')->orderBy('abonnes_count', 'desc')->take(6)->get() as $popularCommunity)
                    <div class="border border-gray-200 rounded-lg p-3 hover:shadow-md transition-shadow">
                        <div class="flex items-center mb-2">
                            <div class="w-8 h-8 bg-blue-500 rounded-full mr-2 flex items-center justify-center text-white font-bold">
                                {{ substr($popularCommunity->theme_name, 0, 1) }}
                            </div>
                            <h4 class="font-medium text-sm">{{ $popularCommunity->theme_name }}</h4>
                        </div>
                        <p class="text-xs text-gray-500 mb-2">{{ $popularCommunity->abonnes_count }} membres</p>
                        <form action="{{ route('communities.subscribe', $popularCommunity->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full text-xs bg-blue-500 hover:bg-blue-600 text-white font-medium py-1 px-2 rounded-full">
                                S'abonner
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-layout.app>