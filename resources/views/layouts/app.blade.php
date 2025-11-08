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
    
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.min.css">
    
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
    
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.all.min.js"></script>
    
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

