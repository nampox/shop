<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Shop')</title>
    
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('images/icon-iphone.png') }}">
    
    <!-- Bootstrap 5.3.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .navbar-brand { font-weight: bold; font-size: 1.5rem; }
        footer { margin-top: auto; }
        /* Modal hardening: đảm bảo modal luôn nổi và nội dung hiển thị rõ ràng */
        .modal { z-index: 1060 !important; }
        .modal-backdrop { z-index: 1055 !important; }
        .modal-dialog, .modal-content {
            background-color: #ffffff !important;
            color: #212529 !important;
            visibility: visible !important;
            opacity: 1 !important;
        }
        /* Tránh modal bị clip trong vùng overflow của container lạ khi chưa kịp append ra body */
        .modal.show { display: block; }
    </style>
    
    @stack('styles')
</head>
<body class="d-flex flex-column min-vh-100">
    @include('layouts.header')
    
    <main class="container my-4 flex-grow-1">
        @yield('content')
    </main>
    
    @include('layouts.footer')
    
    <!-- Bootstrap 5.3.3 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/header.js') }}"></script>
    <script>
    // Đảm bảo mọi modal được append vào body để tránh stacking context/overflow từ ancestor
    document.addEventListener('DOMContentLoaded', function () {
        document.addEventListener('show.bs.modal', function (event) {
            var modalEl = event.target;
            if (modalEl && modalEl.parentElement !== document.body) {
                document.body.appendChild(modalEl);
            }
        });
    });
    </script>
    
    @stack('scripts')
</body>
</html>

