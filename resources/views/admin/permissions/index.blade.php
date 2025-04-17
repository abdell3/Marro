<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manage Permissions') }}
            </h2>
            <a href="{{ route('admin.permissions.create') }}" class="px-4 py-2 bg-orange-500 text-white rounded-md hover:bg-orange-600">
                Add New Permission
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead>
                                <tr>
                                    <th class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        ID
                                    </th>
                                    <th class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Name
                                    </th>
                                    <th class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Roles
                                    </th>
                                    <th class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($permissions as $permission)
                                    <tr>
                                        <td class="py-4 px-4 border-b border-gray-200">
                                            <div class="text-sm text-gray-900">{{ $permission->id }}</div>
                                        </td>
                                        <td class="py-4 px-4 border-b border-gray-200">
                                            <div class="text-sm font-medium text-gray-900">{{ $permission->name }}</div>
                                        </td>
                                        <td class="py-4 px-4 border-b border-gray-200">
                                            <div class="flex flex-wrap gap-1">
                                                @foreach($permission->roles as $role)
                                                    <span class="px-2 py-1 text-xs rounded-full 
                                                        {{ $role->name === 'Admin' ? 'bg-red-100 text-red-800' : 
                                                           ($role->name === 'Moderator' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') }}">
                                                        {{ $role->name }}
                                                    </span>
                                                @endforeach
                                                @if($permission->roles->count() === 0)
                                                    <span class="text-gray-500 text-sm">No roles</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="py-4 px-4 border-b border-gray-200">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('admin.permissions.edit', $permission->id) }}" class="text-blue-500 hover:text-blue-700">
                                                    Edit
                                                </a>
                                                <form action="{{ route('admin.permissions.destroy', $permission->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:text-red-700" onclick="return confirm('Are you sure you want to delete this permission?')">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-6">
                        {{ $permissions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>