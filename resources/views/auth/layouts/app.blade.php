




<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Projet</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <nav class="bg-white shadow-lg">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="text-lg font-semibold">
                    <a href="/" class="text-blue-500 hover:text-blue-700">Marro</a>
                </div>
                <div class="flex items-center">
                    @if (Auth::check())
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="text-gray-700 hover:text-blue-500 px-3 py-2">Déconnexion</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-500 px-3 py-2">Connexion</a>
                        <a href="{{ route('register') }}" class="text-gray-700 hover:text-blue-500 px-3 py-2">Inscription</a>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <main class="py-10">
        @yield('content')
    </main>
</body>
</html>