<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord Admin - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="flex">
        
        <aside class="bg-gray-800 text-white w-64 min-h-screen p-4">
            <h1 class="text-2xl font-bold">Admin Panel</h1>
            <nav class="mt-6">
                <ul>
                    <li><a href="{{ route('admin.dashboard') }}" class="block py-2 hover:bg-gray-700">Dashboard</a></li>
                    <li><a href="{{ route('users.index') }}" class="block py-2 hover:bg-gray-700">Utilisateurs</a></li>
                    <li><a href="{{ route('posts.index') }}" class="block py-2 hover:bg-gray-700">Posts</a></li>
                    <li><a href="{{ route('comments.index') }}" class="block py-2 hover:bg-gray-700">Commentaires</a></li>
                    <li><a href="{{ route('categories.index') }}" class="block py-2 hover:bg-gray-700">Catégories</a></li>
                </ul>
            </nav>
        </aside>

        
        <main class="flex-1 p-8">
            @yield('content')
        </main>
    </div>
</body>
</html>