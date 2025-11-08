<!DOCTYPE html>
<html lang="vi" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'CMS Dashboard') - {{ config('app.name', 'Shop') }}</title>
    
    <!-- Bootstrap 5.3.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Tailwind CSS CDN (tạm thời cho các classes hiện tại) -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        /* Smooth transitions */
        * {
            transition-property: color, background-color, border-color, opacity, transform;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 200ms;
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        
        /* Sidebar animation */
        .sidebar-transition {
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        /* Card hover effect */
        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
    </style>
    
    @stack('styles')
</head>
<body class="h-full bg-gray-50">
    <div class="flex h-full">
        <!-- Sidebar -->
        <aside id="sidebar" class="fixed lg:static inset-y-0 left-0 z-50 w-64 bg-white border-r border-gray-200 sidebar-transition transform lg:translate-x-0 -translate-x-full lg:translate-x-0">
            <div class="flex flex-col h-full">
                <!-- Logo -->
                <div class="flex items-center justify-between h-16 px-6 border-b border-gray-200">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                            </svg>
                        </div>
                        <span class="text-xl font-bold text-gray-900">CMS</span>
                    </div>
                    <button id="sidebar-close" class="lg:hidden text-gray-500 hover:text-gray-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <!-- Navigation -->
                <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
                    <a href="{{ route('cms.dashboard') }}" class="nav-item flex items-center space-x-3 px-4 py-3 rounded-lg text-sm font-medium {{ request()->routeIs('cms.dashboard') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-50' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        <span>Dashboard</span>
                    </a>
                    
                    <a href="{{ route('cms.posts') }}" class="nav-item flex items-center space-x-3 px-4 py-3 rounded-lg text-sm font-medium {{ request()->routeIs('cms.posts') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-50' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span>Posts</span>
                    </a>
                    
                    <a href="{{ route('cms.pages') }}" class="nav-item flex items-center space-x-3 px-4 py-3 rounded-lg text-sm font-medium {{ request()->routeIs('cms.pages') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-50' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                        <span>Pages</span>
                    </a>
                    
                    <a href="{{ route('cms.media') }}" class="nav-item flex items-center space-x-3 px-4 py-3 rounded-lg text-sm font-medium {{ request()->routeIs('cms.media') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-50' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span>Media</span>
                    </a>
                    
                    <a href="{{ route('cms.users') }}" class="nav-item flex items-center space-x-3 px-4 py-3 rounded-lg text-sm font-medium {{ request()->routeIs('cms.users') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-50' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        <span>Users</span>
                    </a>
                    
                    <a href="{{ route('cms.settings') }}" class="nav-item flex items-center space-x-3 px-4 py-3 rounded-lg text-sm font-medium {{ request()->routeIs('cms.settings') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-50' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span>Settings</span>
                    </a>
                </nav>
                
                <!-- User section -->
                <div class="p-4 border-t border-gray-200">
                    <div class="flex items-center space-x-3 mb-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-purple-500 rounded-full flex items-center justify-center text-white font-semibold">
                            {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">{{ auth()->user()->name ?? 'Admin' }}</p>
                            <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email ?? '' }}</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center justify-center space-x-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </aside>
        
        <!-- Overlay for mobile -->
        <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden hidden"></div>
        
        <!-- Main content -->
        <div class="flex-1 flex flex-col overflow-hidden lg:ml-0">
            <!-- Top bar -->
            <header class="bg-white border-b border-gray-200 h-16 flex items-center justify-between px-6 sticky top-0 z-30">
                <button id="sidebar-toggle" class="lg:hidden text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                
                <div class="flex-1 lg:ml-0 ml-4">
                    <h1 class="text-xl font-semibold text-gray-900">@yield('page-title', 'Dashboard')</h1>
                </div>
                
                <div class="flex items-center space-x-4">
                    <a href="{{ route('home') }}" class="text-gray-500 hover:text-gray-700" title="View Site">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                        </svg>
                    </a>
                </div>
            </header>
            
            <!-- Page content -->
            <main class="flex-1 overflow-y-auto p-6">
                @if (session('success'))
                    <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center justify-between">
                        <span>{{ session('success') }}</span>
                        <button onclick="this.parentElement.remove()" class="text-green-600 hover:text-green-800">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg flex items-center justify-between">
                        <span>{{ session('error') }}</span>
                        <button onclick="this.parentElement.remove()" class="text-red-600 hover:text-red-800">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
    
    <script>
        // Sidebar toggle for mobile
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebar-toggle');
        const sidebarClose = document.getElementById('sidebar-close');
        const sidebarOverlay = document.getElementById('sidebar-overlay');
        
        function openSidebar() {
            sidebar.classList.remove('-translate-x-full');
            sidebarOverlay.classList.remove('hidden');
        }
        
        function closeSidebar() {
            sidebar.classList.add('-translate-x-full');
            sidebarOverlay.classList.add('hidden');
        }
        
        sidebarToggle?.addEventListener('click', openSidebar);
        sidebarClose?.addEventListener('click', closeSidebar);
        sidebarOverlay?.addEventListener('click', closeSidebar);
        
        // Close sidebar on escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && !sidebar.classList.contains('-translate-x-full')) {
                closeSidebar();
            }
        });
    </script>
    
    <!-- Bootstrap 5.3.3 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
</body>
</html>

