<x-layout.app title="Connexion">
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-md overflow-hidden mt-10">
        <div class="py-4 px-6">
            <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Connexion</h2>
            
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif
            
            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 text-sm font-medium mb-2">Adresse email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-red-500">
                </div>
                
                <div class="mb-6">
                    <label for="password" class="block text-gray-700 text-sm font-medium mb-2">Mot de passe</label>
                    <input id="password" type="password" name="password" required
                        class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-red-500">
                </div>
                
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center">
                        <input id="remember" type="checkbox" name="remember" class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded">
                        <label for="remember" class="ml-2 block text-sm text-gray-700">
                            Se souvenir de moi
                        </label>
                    </div>
                    
                    <a href="{{ route('password.request') }}" class="text-sm text-red-600 hover:underline">
                        Mot de passe oublié?
                    </a>
                </div>
                
                <div class="flex items-center justify-center">
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-medium py-2 px-4 rounded-full focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 w-full">
                        Se connecter
                    </button>
                </div>
            </form>
            
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    Vous n'avez pas de compte?
                    <a href="{{ route('register') }}" class="text-red-600 hover:underline font-medium">
                        S'inscrire
                    </a>
                </p>
            </div>
        </div>
    </div>
</x-layout.app>
