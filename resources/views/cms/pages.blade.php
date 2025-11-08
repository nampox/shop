@extends('layouts.cms')

@section('title', 'Pages')
@section('page-title', 'Pages')

@section('content')
<div class="space-y-6">
    <!-- Header Actions -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">All Pages</h2>
            <p class="text-sm text-gray-500 mt-1">Manage your static pages</p>
        </div>
        <button class="flex items-center space-x-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            <span>New Page</span>
        </button>
    </div>
    
    <!-- Pages Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Sample Page Cards -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 card-hover">
            <div class="flex items-start justify-between mb-4">
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-gray-900 mb-1">Home</h3>
                    <p class="text-sm text-gray-500">Main landing page</p>
                </div>
                <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">Published</span>
            </div>
            <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                <span class="text-xs text-gray-500">Last updated: {{ now()->subDays(5)->format('M d, Y') }}</span>
                <div class="flex space-x-2">
                    <button class="text-blue-600 hover:text-blue-700 text-sm font-medium">Edit</button>
                    <button class="text-red-600 hover:text-red-700 text-sm font-medium">Delete</button>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 card-hover">
            <div class="flex items-start justify-between mb-4">
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-gray-900 mb-1">About Us</h3>
                    <p class="text-sm text-gray-500">Company information</p>
                </div>
                <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">Published</span>
            </div>
            <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                <span class="text-xs text-gray-500">Last updated: {{ now()->subDays(10)->format('M d, Y') }}</span>
                <div class="flex space-x-2">
                    <button class="text-blue-600 hover:text-blue-700 text-sm font-medium">Edit</button>
                    <button class="text-red-600 hover:text-red-700 text-sm font-medium">Delete</button>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 card-hover">
            <div class="flex items-start justify-between mb-4">
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-gray-900 mb-1">Contact</h3>
                    <p class="text-sm text-gray-500">Contact information</p>
                </div>
                <span class="px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800">Draft</span>
            </div>
            <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                <span class="text-xs text-gray-500">Last updated: {{ now()->subDays(1)->format('M d, Y') }}</span>
                <div class="flex space-x-2">
                    <button class="text-blue-600 hover:text-blue-700 text-sm font-medium">Edit</button>
                    <button class="text-red-600 hover:text-red-700 text-sm font-medium">Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

