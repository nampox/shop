@extends('layouts.cms')

@section('title', 'Posts')
@section('page-title', 'Posts')

@section('content')
<div class="space-y-6">
    <!-- Header Actions -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">All Posts</h2>
            <p class="text-sm text-gray-500 mt-1">Manage your blog posts and articles</p>
        </div>
        <button class="flex items-center space-x-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            <span>New Post</span>
        </button>
    </div>
    
    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
        <div class="flex flex-wrap items-center gap-4">
            <div class="flex-1 min-w-[200px]">
                <input type="text" placeholder="Search posts..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">
            </div>
            <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">
                <option>All Status</option>
                <option>Published</option>
                <option>Draft</option>
                <option>Archived</option>
            </select>
            <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">
                <option>All Categories</option>
                <option>News</option>
                <option>Tutorial</option>
                <option>Review</option>
            </select>
        </div>
    </div>
    
    <!-- Posts Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Author</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <!-- Sample rows -->
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">Getting Started with Laravel</div>
                            <div class="text-sm text-gray-500">A comprehensive guide to Laravel framework</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white text-xs font-semibold mr-2">
                                    A
                                </div>
                                <span class="text-sm text-gray-900">Admin</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">Published</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ now()->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end space-x-2">
                                <button class="text-blue-600 hover:text-blue-900">Edit</button>
                                <button class="text-red-600 hover:text-red-900">Delete</button>
                            </div>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">Advanced Tailwind CSS Tips</div>
                            <div class="text-sm text-gray-500">Learn advanced techniques for styling</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center text-white text-xs font-semibold mr-2">
                                    A
                                </div>
                                <span class="text-sm text-gray-900">Admin</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800">Draft</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ now()->subDays(2)->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end space-x-2">
                                <button class="text-blue-600 hover:text-blue-900">Edit</button>
                                <button class="text-red-600 hover:text-red-900">Delete</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-200 flex items-center justify-between">
            <div class="text-sm text-gray-500">
                Showing <span class="font-medium">1</span> to <span class="font-medium">2</span> of <span class="font-medium">2</span> results
            </div>
            <div class="flex space-x-2">
                <button class="px-3 py-1 border border-gray-300 rounded-lg text-sm text-gray-700 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed" disabled>Previous</button>
                <button class="px-3 py-1 border border-gray-300 rounded-lg text-sm text-gray-700 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed" disabled>Next</button>
            </div>
        </div>
    </div>
</div>
@endsection

