@extends('layouts.cms')

@section('title', 'Media Library')
@section('page-title', 'Media Library')

@section('content')
<div class="space-y-6">
    <!-- Header Actions -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Media Library</h2>
            <p class="text-sm text-gray-500 mt-1">Manage your media files</p>
        </div>
        <label class="flex items-center space-x-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium cursor-pointer">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
            </svg>
            <span>Upload Files</span>
            <input type="file" multiple class="hidden">
        </label>
    </div>
    
    <!-- View Toggle -->
    <div class="flex items-center justify-between bg-white rounded-xl shadow-sm border border-gray-200 p-4">
        <div class="flex items-center space-x-2">
            <button class="px-3 py-1.5 bg-blue-50 text-blue-600 rounded-lg text-sm font-medium">Grid</button>
            <button class="px-3 py-1.5 text-gray-600 hover:bg-gray-50 rounded-lg text-sm font-medium">List</button>
        </div>
        <div class="flex items-center space-x-4">
            <input type="text" placeholder="Search media..." class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none text-sm">
            <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none text-sm">
                <option>All Types</option>
                <option>Images</option>
                <option>Videos</option>
                <option>Documents</option>
            </select>
        </div>
    </div>
    
    <!-- Media Grid -->
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
        <!-- Sample Media Items -->
        @for($i = 0; $i < 12; $i++)
            <div class="group relative bg-white rounded-lg border border-gray-200 overflow-hidden card-hover">
                <div class="aspect-square bg-gradient-to-br from-blue-100 to-purple-100 flex items-center justify-center">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div class="p-2">
                    <p class="text-xs font-medium text-gray-900 truncate">image-{{ $i + 1 }}.jpg</p>
                    <p class="text-xs text-gray-500">2.4 MB</p>
                </div>
                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-opacity flex items-center justify-center opacity-0 group-hover:opacity-100">
                    <div class="flex space-x-2">
                        <button class="p-2 bg-white rounded-lg text-gray-700 hover:bg-gray-100">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </button>
                        <button class="p-2 bg-white rounded-lg text-gray-700 hover:bg-gray-100">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                        </button>
                        <button class="p-2 bg-white rounded-lg text-red-600 hover:bg-red-50">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        @endfor
    </div>
</div>
@endsection

