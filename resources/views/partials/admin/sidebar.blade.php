<div class="w-64 h-screen overflow-y-auto bg-white border-r">
    <div class="p-4">
        <div class="flex items-center mb-6">
            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-orange-500 mr-2">
                <i class="fas fa-eye text-white"></i>
            </div>
            <span class="font-bold text-xl">Marro Admin</span>
        </div>
        
        <nav class="space-y-1">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-2 px-3 py-2 rounded-md {{ request()->routeIs('admin.dashboard') ? 'bg-gray-100 text-gray-900' : 'text-gray-700 hover:bg-gray-100' }}">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
            
            <a href="{{ route('admin.users') }}" class="flex items-center space-x-2 px-3 py-2 rounded-md {{ request()->routeIs('admin.users') ? 'bg-gray-100 text-gray-900' : 'text-gray-700 hover:bg-gray-100' }}">
                <i class="fas fa-users"></i>
                <span>Users</span>
            </a>
            
            <a href="{{ route('communities') }}" class="flex items-center space-x-2 px-3 py-2 rounded-md {{ request()->routeIs('admin.communities') ? 'bg-gray-100 text-gray-900' : 'text-gray-700 hover:bg-gray-100' }}">
                <i class="fas fa-comments"></i>
                <span>Communities</span>
            </a>
            
            <a href="{{ route('posts') }}" class="flex items-center space-x-2 px-3 py-2 rounded-md {{ request()->routeIs('admin.posts') ? 'bg-gray-100 text-gray-900' : 'text-gray-700 hover:bg-gray-100' }}">
                <i class="fas fa-file-alt"></i>
                <span>Posts</span>
            </a>
            
            
            <a href="{{ route('reported') }}" class="flex items-center space-x-2 px-3 py-2 rounded-md {{ request()->routeIs('admin.reported') ? 'bg-gray-100 text-gray-900' : 'text-gray-700 hover:bg-gray-100' }}">
                <i class="fas fa-flag"></i>
                <span>Reported Content</span>
            </a>
            
            
            
            
            
            
        </nav>
        
        <div class="mt-6 pt-6 border-t">
            <a href="{{ route('logout') }}" class="flex items-center space-x-2 px-3 py-2 rounded-md text-red-500 hover:bg-red-50">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </div>
    </div>
</div>