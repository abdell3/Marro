<x-layout.app title="Accueil">
    <div class="flex flex-col md:flex-row gap-6">
        <!-- Main Content -->
        <div class="w-full md:w-3/4">
            <!-- Filter Options -->
            <div class="bg-white rounded-lg shadow mb-6 p-4">
                <div class="flex items-center space-x-4">
                    <span class="text-gray-600 font-medium">Filtrer par:</span>
                    <a href="#" class="px-3 py-1 rounded-full bg-red-500 text-white">
                        Récents
                    </a>
                    <a href="#" class="px-3 py-1 rounded-full bg-gray-100 text-gray-700 hover:bg-gray-200">
                        Populaires
                    </a>
                </div>
            </div>

            <!-- Posts -->
            <div class="bg-white rounded-lg shadow p-6 text-center">
                <h3 class="text-xl font-medium text-gray-700 mb-2">Aucun post pour le moment</h3>
                <p class="text-gray-500 mb-4">Soyez le premier à créer un post dans cette communauté!</p>
                <a href="#" class="inline-block px-6 py-2 bg-red-500 text-white font-medium rounded-full hover:bg-red-600 transition-colors">
                    Créer un post
                </a>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="w-full md:w-1/4">
            <!-- Create Post Card -->
            <div class="bg-white rounded-lg shadow p-4 mb-6">
                <h3 class="text-lg font-medium mb-4">Créer un post</h3>
                <a href="#" class="block w-full py-2 px-4 bg-red-500 text-white text-center font-medium rounded-full hover:bg-red-600 transition-colors">
                    Nouveau post
                </a>
            </div>

            <!-- Popular Communities -->
            <div class="bg-white rounded-lg shadow p-4 mb-6">
                <h3 class="text-lg font-medium mb-4">Communautés populaires</h3>
                <p class="text-gray-500">Aucune communauté disponible.</p>
            </div>

            <!-- About Card -->
            <div class="bg-white rounded-lg shadow p-4">
                <h3 class="text-lg font-medium mb-3">À propos de Marro</h3>
                <p class="text-gray-700 mb-4">
                    Marro est une plateforme de discussion communautaire où vous pouvez partager vos idées, découvrir des contenus intéressants et participer à des débats sur divers sujets.
                </p>
                <div class="flex justify-between text-sm">
                    <div class="text-center">
                        <div class="font-bold text-lg">0</div>
                        <div class="text-gray-500">Posts</div>
                    </div>
                    <div class="text-center">
                        <div class="font-bold text-lg">0</div>
                        <div class="text-gray-500">Communautés</div>
                    </div>
                    <div class="text-center">
                        <div class="font-bold text-lg">2025</div>
                        <div class="text-gray-500">Depuis</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout.app>