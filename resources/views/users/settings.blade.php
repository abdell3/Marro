<x-layout.app title="Paramètres">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="p-6">
                <h1 class="text-2xl font-bold text-gray-800 mb-6">Paramètres du compte</h1>
                
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-md">
                        {{ session('success') }}
                    </div>
                @endif
                
                <!-- Notifications Settings -->
                <div class="mb-8">
                    <h2 class="text-xl font-medium text-gray-800 mb-4">Notifications</h2>
                    
                    <form action="{{ route('settings.update-notifications') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="font-medium text-gray-700">Notifications par email</h3>
                                    <p class="text-sm text-gray-500">Recevez des emails pour les activités importantes</p>
                                </div>
                                <label class="switch">
                                    <input type="checkbox" name="email_notifications" {{ $user->preferences['email_notifications'] ?? false ? 'checked' : '' }}>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="font-medium text-gray-700">Mentions</h3>
                                    <p class="text-sm text-gray-500">Recevez des notifications quand quelqu'un vous mentionne</p>
                                </div>
                                <label class="switch">
                                    <input type="checkbox" name="mention_notifications" {{ $user->preferences['mention_notifications'] ?? true ? 'checked' : '' }}>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="font-medium text-gray-700">Réponses</h3>
                                    <p class="text-sm text-gray-500">Recevez des notifications pour les réponses à vos posts</p>
                                </div>
                                <label class="switch">
                                    <input type="checkbox" name="reply_notifications" {{ $user->preferences['reply_notifications'] ?? true ? 'checked' : '' }}>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        
                        <div class="mt-6">
                            <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition">
                                Enregistrer les préférences
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Theme Settings -->
                <div class="mb-8">
                    <h2 class="text-xl font-medium text-gray-800 mb-4">Apparence</h2>
                    
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="font-medium text-gray-700">Mode sombre</h3>
                            <p class="text-sm text-gray-500">Basculer entre le mode clair et sombre</p>
                        </div>
                        <label class="switch">
                            <input type="checkbox" x-data x-model="darkMode">
                            <span class="slider round"></span>
                        </label>
                    </div>
                </div>
                
                <!-- Privacy Settings -->
                <div class="mb-8">
                    <h2 class="text-xl font-medium text-gray-800 mb-4">Confidentialité</h2>
                    
                    <form action="{{ route('settings.update-privacy') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="font-medium text-gray-700">Profil public</h3>
                                    <p class="text-sm text-gray-500">Permettre aux autres de voir votre profil</p>
                                </div>
                                <label class="switch">
                                    <input type="checkbox" name="public_profile" {{ $user->preferences['public_profile'] ?? true ? 'checked' : '' }}>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="font-medium text-gray-700">Historique de posts visible</h3>
                                    <p class="text-sm text-gray-500">Permettre aux autres de voir votre historique de posts</p>
                                </div>
                                <label class="switch">
                                    <input type="checkbox" name="show_post_history" {{ $user->preferences['show_post_history'] ?? true ? 'checked' : '' }}>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        
                        <div class="mt-6">
                            <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition">
                                Enregistrer les paramètres
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Account Actions -->
                <div>
                    <h2 class="text-xl font-medium text-gray-800 mb-4">Actions du compte</h2>
                    
                    <div class="space-y-4">
                        <a href="{{ route('profile.edit') }}" class="flex items-center text-gray-700 hover:text-red-500 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Modifier le profil
                        </a>
                        
                        <a href="{{ route('password.change') }}" class="flex items-center text-gray-700 hover:text-red-500 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                            </svg>
                            Changer de mot de passe
                        </a>
                        
                        <button 
                            class="flex items-center text-red-600 hover:text-red-800 transition"
                            onclick="if(confirm('Êtes-vous sûr de vouloir supprimer votre compte ? Cette action est irréversible.')) document.getElementById('delete-account-form').submit();"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Supprimer le compte
                        </button>
                        
                        <form id="delete-account-form" action="{{ route('account.delete') }}" method="POST" class="hidden">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout.app>