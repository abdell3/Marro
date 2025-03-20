<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mon Projet Reddit Clone</title>

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding-top: 56px; 
        }
        .navbar {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('post.index') }}">Reddit Clone</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('post.index') }}">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('post.create') }}">Créer un post</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="#">{{ Auth::user()->name }}</a>
                        </li>
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-link nav-link">Déconnexion</button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Connexion</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Inscription</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    
    <div class="container">
        @yield('content')
    </div>

    
    <footer class="bg-dark text-white text-center py-3 mt-4">
        <div class="container">
            <p>&copy; {{ date('Y') }} Mon Projet Reddit Clone. Tous droits réservés.</p>
        </div>
    </footer>

    






    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>