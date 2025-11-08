@extends('layouts.cms')

@section('title', 'Nhân viên')
@section('page-title', 'Quản lý Nhân viên')

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

    /* Status badges with glow */
    .status-badge {
        padding: 0.35rem 0.85rem;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }
    
    .status-badge:hover {
        transform: scale(1.05);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    }

    /* Modern input styles */
    .modern-input {
        border: 2px solid #e9ecef;
        border-radius: 12px;
        padding: 0.75rem 1.25rem;
        transition: all 0.3s ease;
        background: rgba(255, 255, 255, 0.9);
    }
    
    .modern-input:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        background: #fff;
        outline: none;
    }

    /* Animated gradient text */
    .gradient-text {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-weight: 700;
    }

    /* Floating action button */
    .fab {
        position: fixed;
        bottom: 2rem;
        right: 2rem;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        transition: all 0.3s ease;
        z-index: 1000;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }
    
    .fab:hover {
        transform: scale(1.1) rotate(90deg);
        box-shadow: 0 12px 35px rgba(102, 126, 234, 0.5);
    }

    /* Modern table */
    .modern-table {
        border-collapse: separate;
        border-spacing: 0;
    }
    
    .modern-table thead th {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        padding: 1rem;
        border: none;
    }
    
    .modern-table tbody tr {
        transition: all 0.2s ease;
    }
    
    .modern-table tbody tr:hover {
        background: rgba(102, 126, 234, 0.05);
        transform: scale(1.01);
    }
    
    .modern-table tbody td {
        padding: 1.25rem 1rem;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        vertical-align: middle;
    }

    /* Avatar */
    .avatar {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        font-size: 18px;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }
    
    .avatar:hover {
        transform: scale(1.1);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    }

    /* Filter section */
    .filter-section {
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
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
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Stats Overview -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="stat-card gradient-bg-primary">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 mb-2 text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px;">Tổng nhân viên</h6>
                        <h2 class="mb-0 text-white fw-bold">{{ $users->total() }}</h2>
                    </div>
                    <div class="fs-1 opacity-50">
                        <i class="bi bi-people"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stat-card gradient-bg-success">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 mb-2 text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px;">Đã xác thực</h6>
                        <h2 class="mb-0 text-white fw-bold">{{ $users->where('email_verified_at', '!=', null)->count() }}</h2>
                    </div>
                    <div class="fs-1 opacity-50">
                        <i class="bi bi-check-circle"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stat-card gradient-bg-info">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 mb-2 text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px;">Chưa xác thực</h6>
                        <h2 class="mb-0 text-white fw-bold">{{ $users->where('email_verified_at', null)->count() }}</h2>
                    </div>
                    <div class="fs-1 opacity-50">
                        <i class="bi bi-clock"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stat-card gradient-bg-warning">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 mb-2 text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px;">Có vai trò</h6>
                        <h2 class="mb-0 text-white fw-bold">{{ $users->filter(fn($u) => $u->roles->count() > 0)->count() }}</h2>
                    </div>
                    <div class="fs-1 opacity-50">
                        <i class="bi bi-shield-check"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="filter-section">
        <form method="GET" action="{{ route('cms.users') }}" class="row g-3">
            <div class="col-md-4">
                <label class="form-label fw-semibold text-muted small text-uppercase">Tìm kiếm</label>
                <input type="text" 
                       name="search" 
                       class="form-control modern-input" 
                       placeholder="Tên, email..." 
                       value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold text-muted small text-uppercase">Vai trò</label>
                <select name="role" class="form-select modern-input">
                    <option value="">Tất cả vai trò</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->slug }}" {{ request('role') == $role->slug ? 'selected' : '' }}>
                            {{ $role->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold text-muted small text-uppercase">Trạng thái</label>
                <select name="status" class="form-select modern-input">
                    <option value="">Tất cả</option>
                    <option value="verified" {{ request('status') == 'verified' ? 'selected' : '' }}>Đã xác thực</option>
                    <option value="unverified" {{ request('status') == 'unverified' ? 'selected' : '' }}>Chưa xác thực</option>
                </select>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100 rounded-pill fw-semibold">
                    <i class="bi bi-funnel me-2"></i>Lọc
                </button>
            </div>
        </form>
    </div>

    <!-- Users Table -->
    <div class="glass-card rounded-4 p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0 gradient-text">Danh sách nhân viên</h4>
            <button class="btn btn-primary rounded-pill px-4">
                <i class="bi bi-plus-circle me-2"></i>Thêm nhân viên
            </button>
        </div>

        @if($users->count() > 0)
            <div class="table-responsive">
                <table class="table modern-table">
                    <thead>
                        <tr>
                            <th style="width: 60px;">#</th>
                            <th>Nhân viên</th>
                            <th>Vai trò</th>
                            <th>Email</th>
                            <th>Trạng thái</th>
                            <th>Ngày tham gia</th>
                            <th style="width: 150px;" class="text-center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>
                                    <div class="text-muted small">{{ $users->firstItem() + $loop->index }}</div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar bg-primary text-white me-3">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="fw-semibold">{{ $user->name }}</div>
                                            <small class="text-muted">ID: {{ $user->id }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($user->roles->count() > 0)
                                        <div class="d-flex flex-wrap gap-1">
                                            @foreach($user->roles as $role)
                                                <span class="badge bg-info rounded-pill">{{ $role->name }}</span>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="badge bg-secondary rounded-pill">Chưa có vai trò</span>
                                    @endif
                                </td>
                                <td>
                                    <small class="text-muted">{{ $user->email }}</small>
                                </td>
                                <td>
                                    @if($user->email_verified_at)
                                        <span class="status-badge bg-success text-white">
                                            <i class="bi bi-check-circle me-1"></i>Đã xác thực
                                        </span>
                                    @else
                                        <span class="status-badge bg-warning text-dark">
                                            <i class="bi bi-clock me-1"></i>Chưa xác thực
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <small class="text-muted">
                                        {{ $user->created_at->format('d/m/Y') }}<br>
                                        <span class="text-muted">{{ $user->created_at->format('H:i') }}</span>
                                    </small>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <button class="btn btn-sm btn-outline-primary rounded-pill" title="Xem">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-warning rounded-pill" title="Sửa">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger rounded-pill" title="Xóa">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($users->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                    <div class="text-muted small">
                        Hiển thị {{ $users->firstItem() ?? 0 }} - {{ $users->lastItem() ?? 0 }} trong tổng số {{ $users->total() }} nhân viên
                    </div>
                    <nav>
                        {{ $users->links() }}
                    </nav>
                </div>
            @endif
        @else
            <div class="text-center py-5">
                <div class="mb-3">
                    <i class="bi bi-people fs-1 text-muted"></i>
                </div>
                <h5 class="text-muted">Chưa có nhân viên nào</h5>
                <p class="text-muted">Bắt đầu bằng cách thêm nhân viên đầu tiên của bạn</p>
                <button class="btn btn-primary rounded-pill px-4 mt-3">
                    <i class="bi bi-plus-circle me-2"></i>Thêm nhân viên
                </button>
            </div>
        @endif
    </div>
</div>

<!-- Floating Action Button -->
<button class="fab" title="Thêm nhân viên mới">
    <i class="bi bi-plus-lg"></i>
</button>
@endsection

