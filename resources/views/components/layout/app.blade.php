<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ config('app.name', 'Marro') }} - {{ $title ?? 'Accueil' }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Scripts and Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Custom Styles -->
    <link href="{{ asset('css/comments.css') }}" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        
        /* Toggle Switch */
        .switch {
            position: relative;
            display: inline-block;
            width: 40px;
            height: 20px;
        }
        
        .switch input { 
            opacity: 0;
            width: 0;
            height: 0;
        }
        
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
        }
        
        .slider:before {
            position: absolute;
            content: "";
            height: 16px;
            width: 16px;
            left: 2px;
            bottom: 2px;
            background-color: white;
            transition: .4s;
        }
        
        input:checked + .slider {
            background-color: #ef4444;
        }
        
        input:focus + .slider {
            box-shadow: 0 0 1px #ef4444;
        }
        
        input:checked + .slider:before {
            transform: translateX(20px);
        }
        
        .slider.round {
            border-radius: 34px;
        }
        
        .slider.round:before {
            border-radius: 50%;
        }
        
        /* Dark Mode Styles */
        .dark {
            color-scheme: dark;
        }
        
        .dark body {
            background-color: #1a1a1a;
            color: #f3f4f6;
        }
        
        .dark header, .dark footer {
            background-color: #2d2d2d;
            border-color: #3a3a3a;
        }
        
        .dark .bg-white {
            background-color: #2d2d2d;
        }
        
        .dark .text-gray-600, .dark .text-gray-700 {
            color: #d1d5db;
        }
        
        .dark .text-gray-500 {
            color: #9ca3af;
        }
        
        .dark .bg-gray-100 {
            background-color: #3a3a3a;
        }
        
        .dark .border-gray-100, .dark .border-gray-200 {
            border-color: #3a3a3a;
        }
        
        .dark .hover\:bg-gray-100:hover {
            background-color: #4a4a4a;
        }
        
        /* Menu utilisateur */
        .user-dropdown {
            position: relative;
            display: inline-block;
        }
        
        .user-dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            margin-top: 0.5rem;
            min-width: 16rem;
            background-color: white;
            border-radius: 0.375rem;
            border: 1px solid #e5e7eb;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            z-index: 50;
            max-height: calc(100vh - 120px);
            overflow-y: auto;
        }
        
        .show-dropdown {
            display: block;
        }
        
        .user-dropdown-button {
            display: flex;
            align-items: center;
            cursor: pointer;
            padding: 0.25rem;
            outline: none;
        }
        
        .user-avatar {
            width: 2rem;
            height: 2rem;
            border-radius: 9999px;
            background-color: #d1d5db;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            margin-right: 0.5rem;
        }
        
        .dropdown-item {
            display: flex;
            align-items: center;
            padding: 0.5rem 1rem;
            color: #4b5563;
            font-size: 0.875rem;
            transition: background-color 0.2s;
        }
        
        .dropdown-item:hover {
            background-color: #f3f4f6;
        }
        
        .dropdown-divider {
            height: 1px;
            background-color: #e5e7eb;
            margin: 0.25rem 0;
        }
        
        .dark .user-dropdown-content {
            background-color: #2d2d2d;
            border-color: #3a3a3a;
        }
        
        .dark .dropdown-item {
            color: #d1d5db;
        }
        
        .dark .dropdown-item:hover {
            background-color: #4a4a4a;
        }
        
        .dark .dropdown-divider {
            background-color: #3a3a3a;
        }
    </style>
    
    {{ $styles ?? '' }}
</head>
<body class="bg-gray-100 min-h-screen">
    <header class="bg-white shadow-sm">
        <div class="container mx-auto px-4 py-3">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="text-red-500 font-bold text-xl">
                        Marro
                    </a>
                </div>
                
                <!-- Search Bar -->
                <div class="hidden md:flex flex-1 max-w-md mx-6">
                    <form action="{{ route('search') }}" method="GET" class="w-full">
                        <div class="relative">
                            <input 
                                type="text" 
                                name="query" 
                                placeholder="Rechercher sur MAReddit..." 
                                class="w-full bg-gray-100 rounded-full py-2 px-4 focus:outline-none focus:ring-2 focus:ring-red-300"
                            >
                            <button type="submit" class="absolute right-3 top-2.5 text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Navigation -->
                <nav class="flex items-center space-x-4">
                    @if(Auth::check())
                        <div class="user-dropdown">
                            <button class="user-dropdown-button" id="userMenuButton">
                                <div class="user-avatar">
                                    @if(Auth::user()->avatar)
                                        <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="{{ Auth::user()->prenom }} {{ Auth::user()->nom }}" class="w-full h-full object-cover">
                                    @else
                                        <span class="text-sm font-medium">{{ substr(Auth::user()->prenom, 0, 1) . substr(Auth::user()->nom, 0, 1) }}</span>
                                    @endif
                                </div>
                                <span class="hidden md:inline-block text-sm font-medium">{{ Auth::user()->prenom }}</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            
                            <div class="user-dropdown-content" id="userDropdownMenu">
                                <!-- User Menu Header with Avatar -->
                                <div class="px-4 py-3 border-b border-gray-100">
                                    <a href="{{ route('profile') }}" class="flex items-center">
                                        <div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center mr-3 overflow-hidden">
                                            @if(Auth::user()->avatar)
                                                <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="{{ Auth::user()->prenom }} {{ Auth::user()->nom }}" class="w-full h-full object-cover">
                                            @else
                                                <span class="text-sm font-medium">{{ substr(Auth::user()->prenom, 0, 1) . substr(Auth::user()->nom, 0, 1) }}</span>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="font-medium">{{ Auth::user()->prenom }} {{ Auth::user()->nom }}</div>
                                            <div class="text-xs text-gray-500">Voir le profil</div>
                                        </div>
                                    </a>
                                </div>

                                <a href="{{ route('profile') }}" class="dropdown-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    Voir Profil
                                </a>
                                
                                <a href="{{ route('profile.edit') }}" class="dropdown-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Modifier Avatar
                                </a>

                                <a href="{{ route('saved-posts') }}" class="dropdown-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                                    </svg>
                                    Posts sauvegardés
                                </a>

                                <!-- Dark Mode Toggle -->
                                <div class="flex items-center justify-between px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <div class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                                        </svg>
                                        Mode sombre
                                    </div>
                                    <div>
                                        <label class="switch">
                                            <input type="checkbox" id="darkModeToggle">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </div>
                                
                                <div class="dropdown-divider"></div>
                                
                                @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('moderator'))
                                    <a href="{{ route('moderation') }}" class="dropdown-item">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                        </svg>
                                        Modération
                                    </a>
                                @endif
                                
                                @if(Auth::user()->hasRole('admin'))
                                    <a href="{{ route('admin.dashboard') }}" class="dropdown-item">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        Administration
                                    </a>
                                @endif
                                
                                <div class="dropdown-divider"></div>
                                
                                <a href="{{ route('settings') }}" class="dropdown-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    Paramètres
                                </a>
                                
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item w-full text-left">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        Déconnexion
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900">Connexion</a>
                        <a href="{{ route('register') }}" class="text-white bg-red-500 hover:bg-red-600 px-4 py-2 rounded-full text-sm font-medium">Inscription</a>
                    @endif
                </nav>
            </div>
            
            <!-- Mobile Search -->
            <div class="mt-3 md:hidden">
                <form action="{{ route('search') }}" method="GET">
                    <div class="relative">
                        <input 
                            type="text" 
                            name="query" 
                            placeholder="Rechercher sur MAReddit..." 
                            class="w-full bg-gray-100 rounded-full py-2 px-4 focus:outline-none focus:ring-2 focus:ring-red-300"
                        >
                        <button type="submit" class="absolute right-3 top-2.5 text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </header>
    
    <main class="container mx-auto px-4 py-6">
        {{ $slot }}
    </main>
    
    <footer class="bg-white shadow-sm mt-auto">
        <div class="container mx-auto px-4 py-4">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-600 text-sm">&copy; {{ date('Y') }} MAReddit. Tous droits réservés.</p>
                <div class="mt-3 md:mt-0 flex space-x-4">
                    <a href="#" class="text-gray-600 hover:text-red-500 text-sm">À propos</a>
                    <a href="#" class="text-gray-600 hover:text-red-500 text-sm">Conditions d'utilisation</a>
                    <a href="#" class="text-gray-600 hover:text-red-500 text-sm">Politique de confidentialité</a>
                </div>
            </div>
        </div>
    </footer>
    
    {{ $scripts ?? '' }}
    
    <script>
        // Gestion du menu utilisateur
        document.addEventListener('DOMContentLoaded', function() {
            // Gestion du menu utilisateur
            const userMenuButton = document.getElementById('userMenuButton');
            const userDropdownMenu = document.getElementById('userDropdownMenu');
            
            if (userMenuButton && userDropdownMenu) {
                // Ouvrir/fermer le menu au clic sur le bouton
                userMenuButton.addEventListener('click', function(event) {
                    event.stopPropagation();
                    userDropdownMenu.classList.toggle('show-dropdown');
                });
                
                // Fermer le menu au clic à l'extérieur
                document.addEventListener('click', function(event) {
                    if (!userMenuButton.contains(event.target) && !userDropdownMenu.contains(event.target)) {
                        userDropdownMenu.classList.remove('show-dropdown');
                    }
                });
            }
            
            // Gestion du mode sombre
            const darkModeToggle = document.getElementById('darkModeToggle');
            const htmlElement = document.documentElement;
            
            // Vérifier si le mode sombre est activé dans le localStorage
            const isDarkMode = localStorage.getItem('darkMode') === 'true';
            
            // Appliquer le mode sombre si nécessaire
            if (isDarkMode) {
                htmlElement.classList.add('dark');
                if (darkModeToggle) {
                    darkModeToggle.checked = true;
                }
            }
            
            // Écouter les changements du toggle
            if (darkModeToggle) {
                darkModeToggle.addEventListener('change', function() {
                    if (this.checked) {
                        htmlElement.classList.add('dark');
                        localStorage.setItem('darkMode', 'true');
                    } else {
                        htmlElement.classList.remove('dark');
                        localStorage.setItem('darkMode', 'false');
                    }
                });
            }
            
            // Forcer le rechargement après connexion/déconnexion
            @if(session('auth_status'))
                window.location.reload();
            @endif
        });
    </script>
</body>
</html>