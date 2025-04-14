<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marro Admin - @yield('title', 'Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    @yield('styles')
</head>
<body class="bg-gray-100">
    <header class="sticky top-0 z-50 w-full border-b bg-white">
        <div class="container mx-auto flex h-14 items-center px-4">
            <div class="flex-1 mx-4">
                <div class="relative max-w-sm">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    <input 
                        type="search" 
                        placeholder="Search..." 
                        class="w-full bg-white border pl-10 pr-4 py-2 rounded-md"
                    >
                </div>
            </div>
            
            <div class="flex items-center space-x-4">
                <button class="text-gray-500 hover:text-gray-700">
                    <i class="far fa-bell"></i>
                </button>
                <div class="relative">
                    <button class="rounded-full bg-gray-200 h-8 w-8 flex items-center justify-center">
                        <i class="fas fa-user"></i>
                    </button>
                </div>
            </div>
        </div>
    </header>
    
    <div class="flex">
        @include('partials.admin.sidebar')
        
        <main class="flex-1 p-6">
            @yield('content')
        </main>
    </div>

    @yield('scripts')
</body>
</html>