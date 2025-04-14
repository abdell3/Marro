@extends('layouts.auth')

@section('title', 'Join Marro')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-orange-50 to-orange-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full">
        <!-- Logo and Header -->
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center">
                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-orange-500 shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="white" class="h-7 w-7">
                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                    </svg>
                </div>
                <span class="ml-3 text-3xl font-bold text-orange-500">marro</span>
            </div>
            <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                Create your account
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                Join millions of people discovering and sharing what's happening now
            </p>
        </div>

        <!-- Registration Card -->
        <div class="bg-white py-8 px-6 shadow-xl rounded-xl border border-orange-500">
            @if ($errors->any())
                <div class="mb-4 bg-red-50 text-red-500 p-4 rounded-lg">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form class="space-y-6" action="{{ route('register') }}" method="POST">
                @csrf
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-700">
                            First name
                        </label>
                        <div class="mt-1">
                            <input id="first_name" name="first_name" type="text" required value="{{ old('first_name') }}" 
                                class="block w-full border-gray-600 rounded-md focus:ring-orange-500 focus:border-orange-500">
                        </div>
                    </div>
                    
                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-700">
                            Last name
                        </label>
                        <div class="mt-1">
                            <input id="last_name" name="last_name" type="text" required value="{{ old('last_name') }}" 
                                class="block w-full border-gray-600 rounded-md focus:ring-orange-500 focus:border-orange-500">
                        </div>
                    </div>
                </div>

                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700">
                        Username
                    </label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">@</span>
                        </div>
                        <input id="username" name="username" type="text" required value="{{ old('username') }}" 
                            class="pl-8 block w-full border-gray-600 rounded-md focus:ring-orange-500 focus:border-orange-500">
                    </div>
                    <p class="mt-1 text-xs text-gray-500">
                        This will be your public identity on Marro
                    </p>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">
                        Email address
                    </label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                        <input id="email" name="email" type="email" autocomplete="email" required value="{{ old('email') }}" 
                            class="pl-10 block w-full border-gray-600 rounded-md focus:ring-orange-500 focus:border-orange-500">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">
                        Password
                    </label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input id="password" name="password" type="password" required
                            class="pl-10 block w-full border-gray-600 rounded-md focus:ring-orange-500 focus:border-orange-500">
                    </div>
                    <div class="mt-1 text-xs">
                        <div class="password-strength-meter flex space-x-1 mt-2">
                            <div class="h-1 w-1/4 rounded-full bg-gray-400" id="strength-1"></div>
                            <div class="h-1 w-1/4 rounded-full bg-gray-400" id="strength-2"></div>
                            <div class="h-1 w-1/4 rounded-full bg-gray-400" id="strength-3"></div>
                            <div class="h-1 w-1/4 rounded-full bg-gray-400" id="strength-4"></div>
                        </div>
                        <p class="text-gray-500 mt-1">
                            Must be at least 8 characters with a number and a special character
                        </p>
                    </div>
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                        Confirm password
                    </label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-700"></i>
                        </div>
                        <input id="password_confirmation" name="password_confirmation" type="password" required
                            class="pl-10 block w-full border-gray-700 rounded-md focus:ring-orange-500 focus:border-orange-500">
                    </div>
                </div>

                

                <div>
                    <button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent rounded-md text-white bg-orange-500 hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-400 transition-all duration-200 ease-in-out">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <i class="fas fa-user-plus text-blue-900 group-hover:text-blue-900"></i>
                        </span>
                        Create account
                    </button>
                </div>
            </form>

            
        </div>

        <!-- Login Link -->
        <div class="mt-6 text-center">
            <p class="text-sm text-red-600">
                Already have an account?
                <a href="{{ route('login') }}" class="font-medium text-orange-500 hover:text-orange-400">
                    Sign in
                </a>
            </p>
        </div>
    </div>
</div>

@push('scripts')
<script>
   
    document.getElementById('password').addEventListener('input', function() {
        const password = this.value;
        const strength1 = document.getElementById('strength-1');
        const strength2 = document.getElementById('strength-2');
        const strength3 = document.getElementById('strength-3');
        const strength4 = document.getElementById('strength-4');
        
        // Reset all
        [strength1, strength2, strength3, strength4].forEach(el => {
            el.classList.remove('bg-red-500', 'bg-orange-500', 'bg-yellow-500', 'bg-green-500');
            el.classList.add('bg-gray-200');
        });
        
        if (password.length > 0) {
            strength1.classList.remove('bg-gray-200');
            strength1.classList.add('bg-red-500');
        }
        
        if (password.length >= 8) {
            strength2.classList.remove('bg-gray-200');
            strength2.classList.add('bg-orange-500');
        }
        
        if (password.length >= 8 && /\d/.test(password)) {
            strength3.classList.remove('bg-gray-200');
            strength3.classList.add('bg-yellow-500');
        }
        
        if (password.length >= 8 && /\d/.test(password) && /[!@#$%^&*(),.?":{}|<>]/.test(password)) {
            strength4.classList.remove('bg-gray-200');
            strength4.classList.add('bg-green-500');
        }
    });
</script>
@endpush
@endsection