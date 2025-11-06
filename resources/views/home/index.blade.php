@extends('layouts.app')

@section('title', 'Shop')

@section('content')
<div class="row text-center mb-5">
    <div class="col-12">
        <h1 class="display-4 fw-bold mb-3">Chào mừng đến Shop</h1>
        <p class="lead text-muted">Nơi bạn tìm thấy những sản phẩm tốt nhất</p>
    </div>
</div>

<div class="row g-4 mb-5">
    <div class="col-md-4">
        <div class="card h-100 shadow-sm">
            <div class="card-body text-center p-4">
                <div class="display-1 mb-3">
                    <i class="bi bi-box-seam text-primary"></i>
                </div>
                <h4 class="card-title">Sản phẩm phong phú</h4>
                <p class="card-text text-muted">Hàng ngàn sản phẩm đa dạng</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card h-100 shadow-sm">
            <div class="card-body text-center p-4">
                <div class="display-1 mb-3">
                    <i class="bi bi-shield-check text-success"></i>
                </div>
                <h4 class="card-title">Thanh toán an toàn</h4>
                <p class="card-text text-muted">Bảo mật tuyệt đối</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card h-100 shadow-sm">
            <div class="card-body text-center p-4">
                <div class="display-1 mb-3">
                    <i class="bi bi-truck text-info"></i>
                </div>
                <h4 class="card-title">Giao hàng nhanh</h4>
                <p class="card-text text-muted">Vận chuyển miễn phí</p>
            </div>
        </div>
    </div>
</div>

<div class="card bg-light">
    <div class="card-body text-center p-5">
        <h2 class="card-title mb-3">
            <i class="bi bi-star-fill text-warning"></i>
            Sản phẩm nổi bật
        </h2>
        <p class="text-muted">Sắp có sản phẩm...</p>
    </div>
</div>
@endsection

