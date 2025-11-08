@extends('layouts.cms')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Total Users Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Total Users</p>
                    <p class="text-3xl font-bold text-gray-900">{{ number_format($stats['total_users']) }}</p>
                    <p class="text-xs text-gray-500 mt-2">All registered users</p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl flex items-center justify-center">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <!-- Active Users Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Active Users</p>
                    <p class="text-3xl font-bold text-gray-900">{{ number_format($stats['active_users']) }}</p>
                    <p class="text-xs text-gray-500 mt-2">Verified accounts</p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-green-400 to-green-600 rounded-xl flex items-center justify-center">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <!-- Recent Users Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">New Users (7d)</p>
                    <p class="text-3xl font-bold text-gray-900">{{ number_format($stats['recent_users']) }}</p>
                    <p class="text-xs text-gray-500 mt-2">Last 7 days</p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-purple-400 to-purple-600 rounded-xl flex items-center justify-center">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <a href="{{ route('cms.posts') }}" class="flex items-center space-x-3 p-4 rounded-lg border border-gray-200 hover:border-blue-300 hover:bg-blue-50 transition-all group">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-blue-200">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                </div>
                <div>
                    <p class="font-medium text-gray-900">New Post</p>
                    <p class="text-xs text-gray-500">Create article</p>
                </div>
            </a>
            
            <a href="{{ route('cms.pages') }}" class="flex items-center space-x-3 p-4 rounded-lg border border-gray-200 hover:border-blue-300 hover:bg-blue-50 transition-all group">
                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center group-hover:bg-purple-200">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                </div>
                <div>
                    <p class="font-medium text-gray-900">New Page</p>
                    <p class="text-xs text-gray-500">Create page</p>
                </div>
            </a>
            
            <a href="{{ route('cms.media') }}" class="flex items-center space-x-3 p-4 rounded-lg border border-gray-200 hover:border-blue-300 hover:bg-blue-50 transition-all group">
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center group-hover:bg-green-200">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div>
                    <p class="font-medium text-gray-900">Upload Media</p>
                    <p class="text-xs text-gray-500">Add files</p>
                </div>
            </a>
            
            <a href="{{ route('cms.users') }}" class="flex items-center space-x-3 p-4 rounded-lg border border-gray-200 hover:border-blue-300 hover:bg-blue-50 transition-all group">
                <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center group-hover:bg-orange-200">
                    <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                </div>
                <div>
                    <p class="font-medium text-gray-900">Add User</p>
                    <p class="text-xs text-gray-500">Invite member</p>
                </div>
            </a>
        </div>
    </div>
    
    <!-- Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Users -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-900">Recent Users</h2>
                <a href="{{ route('cms.users') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">View all</a>
            </div>
            <div class="space-y-4">
                @php
                    $recentUsers = \App\Models\User::latest()->take(5)->get();
                @endphp
                @forelse($recentUsers as $user)
                    <div class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-50 transition-colors">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-purple-500 rounded-full flex items-center justify-center text-white font-semibold text-sm">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">{{ $user->name }}</p>
                            <p class="text-xs text-gray-500 truncate">{{ $user->email }}</p>
                        </div>
                        <span class="text-xs text-gray-400">{{ $user->created_at->diffForHumans() }}</span>
                    </div>
                @empty
                    <p class="text-sm text-gray-500 text-center py-4">No users yet</p>
                @endforelse
            </div>
        </div>
        
        <!-- System Info -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">System Information</h2>
            <div class="space-y-4">
                <div class="flex items-center justify-between py-2 border-b border-gray-100">
                    <span class="text-sm text-gray-600">PHP Version</span>
                    <span class="text-sm font-medium text-gray-900">{{ PHP_VERSION }}</span>
                </div>
                <div class="flex items-center justify-between py-2 border-b border-gray-100">
                    <span class="text-sm text-gray-600">Laravel Version</span>
                    <span class="text-sm font-medium text-gray-900">{{ app()->version() }}</span>
                </div>
                <div class="flex items-center justify-between py-2 border-b border-gray-100">
                    <span class="text-sm text-gray-600">Environment</span>
                    <span class="text-sm font-medium text-gray-900">{{ app()->environment() }}</span>
                </div>
                <div class="flex items-center justify-between py-2">
                    <span class="text-sm text-gray-600">Server Time</span>
                    <span class="text-sm font-medium text-gray-900">{{ now()->format('H:i:s') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

