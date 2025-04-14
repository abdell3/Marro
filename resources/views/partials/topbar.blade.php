<header class="sticky top-0 z-50 w-full border-b bg-white">
    <div class="container mx-auto flex h-14 items-center px-4">
        <div class="flex items-center mr-4">
            <a href="{{ route('home') }}" class="flex items-center space-x-2">
                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-orange-500">
                    <i class="fas fa-eye text-white"></i>
                </div>
                <span class="font-bold text-xl text-orange-500">marro</span>
            </a>
        </div>
        
        <div class="flex-1 mx-4">
            <div class="relative">
                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                <input 
                    type="search" 
                    placeholder="Search Marro" 
                    class="w-full bg-gray-100 pl-10 pr-4 py-2 rounded-full"
                >
            </div>
        </div>
        
        <div class="flex items-center space-x-4">
            <button class="text-gray-500 hover:text-gray-700">
                <i class="far fa-comment-alt"></i>
            </button>
            <button class="text-gray-500 hover:text-gray-700">
                <i class="far fa-bell"></i>
            </button>
            <button class="flex items-center space-x-1 border rounded-full px-3 py-1 hover:bg-gray-100">
                <i class="fas fa-plus text-sm"></i>
                <span>Create</span>
            </button>
            @auth
                <div class="relative">
                    <button class="rounded-full bg-gray-200 h-8 w-8 flex items-center justify-center">
                        <i class="fas fa-user"></i>
                    </button>
                </div>
            @else
                <a href="{{ route('login') }}" class="text-orange-500 hover:text-orange-600">Log In</a>
                <a href="{{ route('register') }}" class="bg-orange-500 text-white px-3 py-1 rounded-full hover:bg-orange-600">Sign Up</a>
            @endauth
        </div>
    </div>
</header>