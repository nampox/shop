@extends('layouts.cms')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@push('styles')
<style>
    /* Futuristic gradient backgrounds */
    .gradient-bg-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .gradient-bg-success {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    }
    
    .gradient-bg-info {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    }
    
    .gradient-bg-warning {
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
    }

    /* Glass morphism effect */
    .glass-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.18);
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
    }

    /* Hover effects */
    .card-hover {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid rgba(0, 0, 0, 0.05);
    }
    
    .card-hover:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        border-color: rgba(102, 126, 234, 0.3);
    }

    /* Stats cards */
    .stat-card {
        border-radius: 20px;
        padding: 1.5rem;
        color: white;
        position: relative;
        overflow: hidden;
        min-height: 120px;
    }
    
    .stat-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: rotate 20s linear infinite;
    }
    
    @keyframes rotate {
        from {
            transform: rotate(0deg);
        }
        to {
            transform: rotate(360deg);
        }
    }
    
    .stat-card .fs-1 {
        font-size: 3rem !important;
    }

    /* Animated gradient text */
    .gradient-text {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-weight: 700;
    }

    /* Quick action cards */
    .quick-action-card {
        border-radius: 16px;
        padding: 1.5rem;
        border: 2px solid #e9ecef;
        transition: all 0.3s ease;
        background: white;
        text-decoration: none;
        color: inherit;
        display: block;
    }
    
    .quick-action-card:hover {
        transform: translateY(-4px);
        border-color: #667eea;
        box-shadow: 0 12px 30px rgba(102, 126, 234, 0.15);
        color: inherit;
        text-decoration: none;
    }

    /* Recent user item */
    .recent-user-item {
        padding: 1rem;
        border-radius: 12px;
        transition: all 0.2s ease;
    }
    
    .recent-user-item:hover {
        background: rgba(102, 126, 234, 0.05);
        transform: translateX(4px);
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Stats Grid -->
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="stat-card gradient-bg-primary">
                <div class="d-flex justify-content-between align-items-center">
                <div>
                        <h6 class="text-white-50 mb-2 text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px;">Tổng người dùng</h6>
                        <h2 class="mb-0 text-white fw-bold">{{ number_format($stats['total_users']) }}</h2>
                        <p class="text-white-50 mb-0 small mt-2">Tất cả người dùng đã đăng ký</p>
                    </div>
                    <div class="fs-1 opacity-50">
                        <i class="bi bi-people"></i>
                </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-3">
            <div class="stat-card gradient-bg-success">
                <div class="d-flex justify-content-between align-items-center">
                <div>
                        <h6 class="text-white-50 mb-2 text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px;">Người dùng hoạt động</h6>
                        <h2 class="mb-0 text-white fw-bold">{{ number_format($stats['active_users']) }}</h2>
                        <p class="text-white-50 mb-0 small mt-2">Tài khoản đã xác thực</p>
                    </div>
                    <div class="fs-1 opacity-50">
                        <i class="bi bi-check-circle"></i>
                </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-3">
            <div class="stat-card gradient-bg-info">
                <div class="d-flex justify-content-between align-items-center">
                <div>
                        <h6 class="text-white-50 mb-2 text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px;">Người dùng mới (7d)</h6>
                        <h2 class="mb-0 text-white fw-bold">{{ number_format($stats['recent_users']) }}</h2>
                        <p class="text-white-50 mb-0 small mt-2">7 ngày qua</p>
                    </div>
                    <div class="fs-1 opacity-50">
                        <i class="bi bi-graph-up-arrow"></i>
                </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="glass-card rounded-4 p-4 mb-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0 gradient-text">Thao tác nhanh</h4>
        </div>
        <div class="row g-3">
            @if(auth()->user()->hasRole('admin'))
            <div class="col-md-3">
                <a href="{{ route('cms.users') }}" class="quick-action-card">
                    <div class="d-flex align-items-center">
                        <div style="width: 48px; height: 48px;" class="bg-orange-100 rounded-lg d-flex align-items-center justify-content-center me-3">
                            <i class="bi bi-person-plus fs-4 text-orange-600"></i>
                </div>
                <div>
                            <div class="fw-semibold mb-1">Thêm nhân viên</div>
                            <small class="text-muted">Mời thành viên mới</small>
                        </div>
                </div>
            </a>
            </div>
            @endif
            <div class="col-md-3">
                <a href="{{ route('cms.products') }}" class="quick-action-card">
                    <div class="d-flex align-items-center">
                        <div style="width: 48px; height: 48px;" class="bg-blue-100 rounded-lg d-flex align-items-center justify-content-center me-3">
                            <i class="bi bi-box-seam fs-4 text-blue-600"></i>
                </div>
                <div>
                            <div class="fw-semibold mb-1">Quản lý sản phẩm</div>
                            <small class="text-muted">Xem tất cả sản phẩm</small>
                        </div>
                </div>
            </a>
            </div>
            <div class="col-md-3">
                <a href="{{ route('cms.products') }}" class="quick-action-card">
                    <div class="d-flex align-items-center">
                        <div style="width: 48px; height: 48px;" class="bg-purple-100 rounded-lg d-flex align-items-center justify-content-center me-3">
                            <i class="bi bi-plus-circle fs-4 text-purple-600"></i>
                </div>
                <div>
                            <div class="fw-semibold mb-1">Thêm sản phẩm</div>
                            <small class="text-muted">Tạo sản phẩm mới</small>
                        </div>
                </div>
            </a>
            </div>
            <div class="col-md-3">
                <a href="{{ route('cms.dashboard') }}" class="quick-action-card">
                    <div class="d-flex align-items-center">
                        <div style="width: 48px; height: 48px;" class="bg-green-100 rounded-lg d-flex align-items-center justify-content-center me-3">
                            <i class="bi bi-graph-up fs-4 text-green-600"></i>
                </div>
                <div>
                            <div class="fw-semibold mb-1">Báo cáo</div>
                            <small class="text-muted">Xem thống kê</small>
                        </div>
                </div>
            </a>
            </div>
        </div>
    </div>
    
    <!-- Recent Activity -->
    <div class="row">
        <!-- Recent Users -->
        <div class="col-lg-6 mb-4">
            <div class="glass-card rounded-4 p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="mb-0 gradient-text">Người dùng gần đây</h4>
                    <a href="{{ route('cms.users') }}" class="btn btn-sm btn-outline-primary rounded-pill">
                        Xem tất cả
                    </a>
            </div>
                <div>
                @php
                    $recentUsers = \App\Models\User::latest()->take(5)->get();
                @endphp
                @forelse($recentUsers as $user)
                        <div class="recent-user-item d-flex align-items-center mb-3">
                            <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);" class="rounded-circle d-flex align-items-center justify-content-center text-white fw-semibold me-3">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                            <div class="flex-grow-1">
                                <div class="fw-semibold small">{{ $user->name }}</div>
                                <small class="text-muted">{{ $user->email }}</small>
                        </div>
                            <small class="text-muted">{{ $user->created_at->diffForHumans() }}</small>
                    </div>
                @empty
                        <p class="text-muted text-center py-4">Chưa có người dùng nào</p>
                @endforelse
                </div>
            </div>
        </div>
        
        <!-- System Info -->
        <div class="col-lg-6 mb-4">
            <div class="glass-card rounded-4 p-4">
                <h4 class="mb-4 gradient-text">Thông tin hệ thống</h4>
                <div>
                    <div class="d-flex justify-content-between align-items-center py-3 border-bottom">
                        <span class="text-muted small">Phiên bản PHP</span>
                        <span class="fw-semibold">{{ PHP_VERSION }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center py-3 border-bottom">
                        <span class="text-muted small">Phiên bản Laravel</span>
                        <span class="fw-semibold">{{ app()->version() }}</span>
                </div>
                    <div class="d-flex justify-content-between align-items-center py-3 border-bottom">
                        <span class="text-muted small">Môi trường</span>
                        <span class="badge bg-info rounded-pill">{{ app()->environment() }}</span>
                </div>
                    <div class="d-flex justify-content-between align-items-center py-3">
                        <span class="text-muted small">Thời gian server</span>
                        <span class="fw-semibold">{{ now()->format('H:i:s') }}</span>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
