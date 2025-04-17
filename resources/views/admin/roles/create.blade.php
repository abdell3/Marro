<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Role') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('admin.roles.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500">
                            @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Permissions</label>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                @foreach($permissions as $permission)
                                    <div class="flex items-center">
                                        <input type="checkbox" id="permission_{{ $permission->id }}" name="permissions[]" value="{{ $permission->id }}" 
                                            {{ in_array($permission->id, old('permissions', [])) ? 'checked' : '' }}
                                            class="h-4 w-4 text-orange-500 focus:ring-orange-500 border-gray-300 rounded">
                                        <label for="permission_{{ $permission->id }}" class="ml-2 block text-sm text-gray-900">
                                            {{ $permission->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            @error('permissions')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="flex justify-end">
                            <a href="{{ route('admin.roles.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 mr-2">
                                Cancel
                            </a>
                            <button type="submit" class="px-4 py-2 bg-orange-500 text-white rounded-md hover:bg-orange-600">
                                Create Role
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>