<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Marro</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Custom animations */
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        
        .float-animation {
            animation: float 6s ease-in-out infinite;
        }
        
        /* Custom background pattern */
        .bg-pattern {
            background-color: #fff;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23FFA500' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
    </style>
</head>
<body class="bg-pattern">
    <div class="relative overflow-hidden">
        <!-- Decorative Elements -->
        <div class="hidden lg:block absolute top-20 left-10 w-32 h-32 bg-orange-500 rounded-full opacity-10 float-animation" style="animation-delay: 0s;"></div>
        <div class="hidden lg:block absolute top-40 right-20 w-24 h-24 bg-orange-500 rounded-full opacity-10 float-animation" style="animation-delay: 1s;"></div>
        <div class="hidden lg:block absolute bottom-20 left-1/4 w-16 h-16 bg-orange-500 rounded-full opacity-10 float-animation" style="animation-delay: 2s;"></div>
        
        <!-- Main Content -->
        @yield('content')
        
        <!-- Footer -->
        <footer class="mt-8 text-center text-sm text-gray-500 pb-6">
            <p>© {{ date('Y') }} Marro. All rights reserved.</p>
            <div class="mt-2 flex justify-center space-x-4">
                <a href="#" class="hover:text-gray-700">Terms</a>
                <a href="#" class="hover:text-gray-700">Privacy</a>
                <a href="#" class="hover:text-gray-700">Help</a>
                <a href="#" class="hover:text-gray-700">Contact</a>
            </div>
        </footer>
    </div>
    
    @stack('scripts')
</body>
</html>