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
    
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.min.css">
    
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
        
        /* Sidebar Styles - Futuristic Collapsible */
        #sidebar {
            transition: width 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow-x: hidden;
            overflow-y: auto;
            width: 256px;
            flex-shrink: 0;
        }
        
        /* Apply collapsed state immediately if data attribute is set (prevents flash) */
        html[data-sidebar-collapsed="true"] #sidebar {
            width: 80px !important;
        }
        
        html[data-sidebar-collapsed="true"] #sidebar .sidebar-text,
        html[data-sidebar-collapsed="true"] #sidebar .sidebar-logo-text,
        html[data-sidebar-collapsed="true"] #sidebar .sidebar-user-info {
            opacity: 0;
            max-width: 0;
            overflow: hidden;
        }
        
        #sidebar.collapsed {
            width: 80px !important;
        }
        
        /* Text elements that should hide when collapsed */
        .sidebar-text,
        .sidebar-logo-text {
            transition: opacity 0.3s ease 0.1s, max-width 0.3s ease 0.1s;
            max-width: 200px;
            white-space: nowrap;
            display: inline-block;
        }
        
        .sidebar-user-info {
            transition: opacity 0.3s ease 0.1s;
            white-space: nowrap;
        }
        
        #sidebar.collapsed .sidebar-text,
        #sidebar.collapsed .sidebar-logo-text {
            opacity: 0;
            max-width: 0;
            overflow: hidden;
            transition: opacity 0.2s ease, max-width 0.2s ease;
        }
        
        #sidebar.collapsed .sidebar-user-info {
            opacity: 0;
            overflow: hidden;
            transition: opacity 0.2s ease;
        }
        
        /* Nav items */
        .nav-item {
            transition: all 0.3s ease;
        }
        
        #sidebar.collapsed .nav-item {
            justify-content: center;
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }
        
        #sidebar.collapsed .sidebar-user-avatar {
            margin: 0 auto;
        }
        
        /* Sidebar hover expand (only when collapsed) */
        @media (min-width: 1024px) {
            #sidebar.collapsed:hover {
                width: 256px !important;
                box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
                z-index: 1000;
            }
            
            #sidebar.collapsed:hover .sidebar-text,
            #sidebar.collapsed:hover .sidebar-logo-text {
                opacity: 1;
                max-width: 200px;
                overflow: visible;
                transition: opacity 0.3s ease 0.1s, max-width 0.3s ease 0.1s;
            }
            
            #sidebar.collapsed:hover .sidebar-user-info {
                opacity: 1;
                overflow: visible;
                transition: opacity 0.3s ease 0.1s;
            }
            
            #sidebar.collapsed:hover .nav-item {
                justify-content: flex-start;
                padding-left: 1rem;
                padding-right: 1rem;
            }
            
            #sidebar.collapsed:hover .sidebar-user-avatar {
                margin: 0;
            }
            
            /* Ensure no horizontal scroll on hover */
            #sidebar.collapsed:hover {
                overflow-x: hidden;
            }
        }
        
        /* Sidebar toggle button */
        .sidebar-toggle-btn {
            position: fixed;
            left: 256px;
            top: 50%;
            transform: translateY(-50%);
            width: 32px;
            height: 48px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 0 12px 12px 0;
            color: white;
            cursor: pointer;
            z-index: 999;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .sidebar-toggle-btn:hover {
            width: 36px;
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }
        
        html[data-sidebar-collapsed="true"] .sidebar-toggle-btn,
        #sidebar.collapsed + .sidebar-toggle-btn {
            left: 80px;
        }
        
        html[data-sidebar-collapsed="true"] .sidebar-toggle-btn svg,
        #sidebar.collapsed + .sidebar-toggle-btn svg {
            transform: rotate(180deg);
        }
        
        /* Main content transition */
        .main-content-wrapper {
            transition: margin-left 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        /* Desktop: sidebar is static, so no margin needed when expanded */
        @media (min-width: 1024px) {
            .main-content-wrapper {
                margin-left: 0;
            }
            
            /* Only add margin when sidebar is collapsed */
            html[data-sidebar-collapsed="true"] .main-content-wrapper,
            #sidebar.collapsed ~ .main-content-wrapper {
                margin-left: 0px;
            }
        }
        
        /* Nav item tooltip when collapsed */
        #sidebar.collapsed .nav-item {
            position: relative;
        }
        
        #sidebar.collapsed .nav-item::after {
            content: attr(data-tooltip);
            position: absolute;
            left: 100%;
            top: 50%;
            transform: translateY(-50%);
            margin-left: 12px;
            background: rgba(0, 0, 0, 0.9);
            color: white;
            padding: 0.5rem 0.75rem;
            border-radius: 8px;
            font-size: 0.75rem;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.2s;
            z-index: 1000;
        }
        
        #sidebar.collapsed .nav-item:hover::after {
            opacity: 1;
        }
        
        /* Card hover effect */
        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        /* Mobile responsive */
        @media (max-width: 1023px) {
            .sidebar-toggle-btn {
                display: none;
            }
            
            .main-content-wrapper {
                margin-left: 0 !important;
            }
        }
    </style>
    
    @stack('styles')
    
    <script>
        // Apply sidebar state IMMEDIATELY before DOM is fully rendered to prevent flash
        (function() {
            if (typeof Storage !== 'undefined') {
                const savedState = localStorage.getItem('sidebarCollapsed');
                if (savedState === 'true') {
                    document.documentElement.setAttribute('data-sidebar-collapsed', 'true');
                }
            }
        })();
    </script>
</head>
<body class="h-full bg-gray-50">
    <div class="flex h-full">
        <!-- Sidebar -->
        <aside id="sidebar" class="fixed lg:static inset-y-0 left-0 z-50 w-64 bg-white border-r border-gray-200 transform lg:translate-x-0 -translate-x-full lg:translate-x-0">
            <div class="flex flex-col h-full">
                <!-- Logo -->
                <div class="flex items-center justify-between h-16 px-6 border-b border-gray-200">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                            </svg>
                        </div>
                        <span class="sidebar-logo-text text-xl font-bold text-gray-900 transition-opacity">CMS</span>
                    </div>
                    <button id="sidebar-close" class="lg:hidden text-gray-500 hover:text-gray-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <!-- Navigation -->
                <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto overflow-x-hidden">
                    <a href="{{ route('cms.dashboard') }}" 
                       data-tooltip="Dashboard"
                       class="nav-item flex items-center space-x-3 px-4 py-3 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('cms.dashboard') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-50' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        <span class="sidebar-text transition-opacity">Dashboard</span>
                    </a>
                    
                    <a href="{{ route('cms.products') }}" 
                       data-tooltip="Sản phẩm"
                       class="nav-item flex items-center space-x-3 px-4 py-3 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('cms.products') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-50' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        <span class="sidebar-text transition-opacity">Sản phẩm</span>
                    </a>
                    
                    <a href="{{ route('cms.categories') }}" 
                       data-tooltip="Danh mục"
                       class="nav-item flex items-center space-x-3 px-4 py-3 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('cms.categories') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-50' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                        </svg>
                        <span class="sidebar-text transition-opacity">Danh mục</span>
                    </a>
                    
                    @if(auth()->user()->hasRole('admin'))
                    <a href="{{ route('cms.users') }}" 
                       data-tooltip="Nhân viên"
                       class="nav-item flex items-center space-x-3 px-4 py-3 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('cms.users') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-50' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <span class="sidebar-text transition-opacity">Nhân viên</span>
                    </a>
                    @endif
                </nav>
                
                <!-- User section -->
                <div class="p-4 border-t border-gray-200">
                    <div class="flex items-center space-x-3 mb-3">
                        <div class="sidebar-user-avatar w-10 h-10 bg-gradient-to-br from-blue-400 to-purple-500 rounded-full flex items-center justify-center text-white font-semibold flex-shrink-0">
                            {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                        </div>
                        <div class="sidebar-user-info flex-1 min-w-0 transition-opacity">
                            <p class="text-sm font-medium text-gray-900 truncate">{{ auth()->user()->name ?? 'Admin' }}</p>
                            <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email ?? '' }}</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center justify-center space-x-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg transition-colors">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            <span class="sidebar-text transition-opacity">Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </aside>
        
        <!-- Sidebar Toggle Button -->
        <button class="sidebar-toggle-btn" id="sidebar-toggle-desktop" title="Thu gọn/Giãn sidebar">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="transition: transform 0.3s;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
        </button>
        
        <!-- Overlay for mobile -->
        <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden hidden"></div>
        
        <!-- Main content -->
        <div class="main-content-wrapper flex-1 flex flex-col overflow-hidden">
            <!-- Top bar -->
            <header class="bg-white border-b border-gray-200 h-16 flex items-center justify-between px-6 sticky top-0 z-30">
                <div class="d-flex align-items-center">
                    <button id="sidebar-toggle" class="lg:hidden me-3 text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                    <h1 class="text-xl font-semibold text-gray-900 mb-0">@yield('page-title', 'Dashboard')</h1>
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
        // Apply sidebar state IMMEDIATELY before DOM is fully rendered to prevent flash
        (function() {
            const savedState = localStorage.getItem('sidebarCollapsed');
            if (savedState === 'true' && window.innerWidth >= 1024) {
                document.documentElement.setAttribute('data-sidebar-collapsed', 'true');
            }
        })();
    </script>
    
    <script>
        // Sidebar state management
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebar-toggle');
        const sidebarToggleDesktop = document.getElementById('sidebar-toggle-desktop');
        const sidebarClose = document.getElementById('sidebar-close');
        const sidebarOverlay = document.getElementById('sidebar-overlay');
        
        // Load saved sidebar state - apply immediately without transition
        const savedState = localStorage.getItem('sidebarCollapsed');
        if (savedState === 'true' && window.innerWidth >= 1024) {
            // Disable transition temporarily
            sidebar.style.transition = 'none';
            sidebar.classList.add('collapsed');
            // Re-enable transition after a brief moment
            requestAnimationFrame(() => {
                setTimeout(() => {
                    sidebar.style.transition = '';
                }, 0);
            });
        }
        
        // Toggle sidebar collapse/expand
        function toggleSidebar() {
            sidebar.classList.toggle('collapsed');
            const isCollapsed = sidebar.classList.contains('collapsed');
            localStorage.setItem('sidebarCollapsed', isCollapsed);
            
            // Update data attribute for immediate CSS application
            if (isCollapsed) {
                document.documentElement.setAttribute('data-sidebar-collapsed', 'true');
            } else {
                document.documentElement.removeAttribute('data-sidebar-collapsed');
            }
        }
        
        // Mobile sidebar functions
        function openSidebar() {
            sidebar.classList.remove('-translate-x-full');
            sidebarOverlay.classList.remove('hidden');
        }
        
        function closeSidebar() {
            sidebar.classList.add('-translate-x-full');
            sidebarOverlay.classList.add('hidden');
        }
        
        // Event listeners
        sidebarToggleDesktop?.addEventListener('click', toggleSidebar);
        sidebarToggle?.addEventListener('click', openSidebar);
        sidebarClose?.addEventListener('click', closeSidebar);
        sidebarOverlay?.addEventListener('click', closeSidebar);
        
        // Close sidebar on escape key (mobile)
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && !sidebar.classList.contains('-translate-x-full')) {
                closeSidebar();
            }
        });
        
        // Handle window resize
        window.addEventListener('resize', () => {
            if (window.innerWidth < 1024) {
                sidebar.classList.remove('collapsed');
            }
        });
    </script>
    
    <!-- Bootstrap 5.3.3 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.all.min.js"></script>
    
    <!-- Multi-Select Component JS -->
    <script src="{{ asset('js/components/multi-select.js') }}"></script>
    
    <script>
        // Configure SweetAlert2 to match Bootstrap theme
        const SwalTheme = {
            confirmButtonColor: '#667eea',
            cancelButtonColor: '#6c757d',
            denyButtonColor: '#dc3545',
            buttonsStyling: true,
            customClass: {
                confirmButton: 'btn btn-primary',
                cancelButton: 'btn btn-secondary',
                denyButton: 'btn btn-danger',
                popup: 'rounded-4',
                title: 'fw-bold',
                htmlContainer: 'text-start'
            }
        };
        
        // Helper functions for common modals
        window.showConfirm = function(options) {
            return Swal.fire({
                ...SwalTheme,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: options.confirmText || 'Xác nhận',
                cancelButtonText: options.cancelText || 'Hủy',
                ...options
            });
        };
        
        window.showSuccess = function(message, title = 'Thành công!') {
            return Swal.fire({
                ...SwalTheme,
                icon: 'success',
                title: title,
                text: message,
                timer: 2000,
                timerProgressBar: true
            });
        };
        
        window.showError = function(message, title = 'Lỗi!') {
            return Swal.fire({
                ...SwalTheme,
                icon: 'error',
                title: title,
                text: message
            });
        };
        
        window.showInfo = function(message, title = 'Thông tin') {
            return Swal.fire({
                ...SwalTheme,
                icon: 'info',
                title: title,
                text: message
            });
        };
        
        window.showWarning = function(message, title = 'Cảnh báo!') {
            return Swal.fire({
                ...SwalTheme,
                icon: 'warning',
                title: title,
                text: message
            });
        };
    </script>
    
    @stack('scripts')
</body>
</html>

