@extends('layouts.cms')

@section('title', 'Users')
@section('page-title', 'Users')

@section('content')
<div class="space-y-6">
    <!-- Header Actions -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">All Users</h2>
            <p class="text-sm text-gray-500 mt-1">Manage user accounts and permissions</p>
        </div>
        <button class="flex items-center space-x-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            <span>Add User</span>
        </button>
    </div>
    
    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
        <div class="flex flex-wrap items-center gap-4">
            <div class="flex-1 min-w-[200px]">
                <input type="text" placeholder="Search users..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">
            </div>
            <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">
                <option>All Roles</option>
                <option>Admin</option>
                <option>Editor</option>
                <option>Author</option>
                <option>Subscriber</option>
            </select>
            <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">
                <option>All Status</option>
                <option>Active</option>
                <option>Inactive</option>
                <option>Pending</option>
            </select>
        </div>
    </div>
    
    <!-- Users Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Joined</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($users as $user)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-purple-500 rounded-full flex items-center justify-center text-white font-semibold mr-3">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800">Admin</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($user->email_verified_at)
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">Active</span>
                                @else
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $user->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    <button class="text-blue-600 hover:text-blue-900">Edit</button>
                                    <button class="text-red-600 hover:text-red-900">Delete</button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No users</h3>
                                <p class="mt-1 text-sm text-gray-500">Get started by creating a new user.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($users->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

