@extends('layouts.cms')

@section('title', 'Quản lý Sản phẩm')
@section('page-title', 'Quản lý Sản phẩm')

@push('styles')
<!-- Multi-Select Component CSS -->
<link rel="stylesheet" href="{{ asset('css/components/multi-select.css') }}">

<style>
    /* Hide scrollbars in SweetAlert2 modal */
    .swal2-popup {
        overflow: hidden !important;
    }
    
    .swal2-html-container {
        overflow-x: hidden !important;
        overflow-y: auto !important;
        max-height: 70vh !important;
        /* Hide scrollbar but keep functionality */
        scrollbar-width: none !important; /* Firefox */
        -ms-overflow-style: none !important; /* IE and Edge */
    }
    
    .swal2-html-container::-webkit-scrollbar {
        display: none !important; /* Chrome, Safari, Opera */
    }
    
    /* Prevent horizontal scroll */
    .swal2-container {
        overflow-x: hidden !important;
    }

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
    .product-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid rgba(0, 0, 0, 0.05);
    }
    
    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        border-color: rgba(102, 126, 234, 0.3);
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

    /* Pulse animation */
    @keyframes pulse {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.5;
        }
    }
    
    .pulse {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
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

    /* Image thumbnail */
    .product-thumb {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }
    
    .product-thumb:hover {
        transform: scale(1.1);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
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

    /* Filter section */
    .filter-section {
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
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
                        <h6 class="text-white-50 mb-2 text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px;">Tổng sản phẩm</h6>
                        <h2 class="mb-0 text-white fw-bold">{{ $products->total() }}</h2>
                    </div>
                    <div class="fs-1 opacity-50">
                        <i class="bi bi-box-seam"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stat-card gradient-bg-success">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 mb-2 text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px;">Đang hoạt động</h6>
                        <h2 class="mb-0 text-white fw-bold">{{ $products->where('status', 'active')->count() }}</h2>
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
                        <h6 class="text-white-50 mb-2 text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px;">Bản nháp</h6>
                        <h2 class="mb-0 text-white fw-bold">{{ $products->where('status', 'draft')->count() }}</h2>
                    </div>
                    <div class="fs-1 opacity-50">
                        <i class="bi bi-file-earmark"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stat-card gradient-bg-warning">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 mb-2 text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px;">Đã lưu trữ</h6>
                        <h2 class="mb-0 text-white fw-bold">{{ $products->where('status', 'archived')->count() }}</h2>
                    </div>
                    <div class="fs-1 opacity-50">
                        <i class="bi bi-archive"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="filter-section">
        <form method="GET" action="{{ route('cms.products') }}" class="row g-3">
            <div class="col-md-4">
                <label class="form-label fw-semibold text-muted small text-uppercase">Tìm kiếm</label>
                <input type="text" 
                       name="search" 
                       class="form-control modern-input" 
                       placeholder="Tên sản phẩm, slug..." 
                       value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold text-muted small text-uppercase">Trạng thái</label>
                <select name="status" class="form-select modern-input">
                    <option value="">Tất cả</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Đang hoạt động</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Bản nháp</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Không hoạt động</option>
                    <option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>Đã lưu trữ</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold text-muted small text-uppercase">Danh mục</label>
                <select name="category" class="form-select modern-input">
                    <option value="">Tất cả</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100 rounded-pill fw-semibold">
                    <i class="bi bi-funnel me-2"></i>Lọc
                </button>
            </div>
        </form>
    </div>

    <!-- Products Table -->
    <div class="glass-card rounded-4 p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0 gradient-text">Danh sách sản phẩm</h4>
            <button class="btn btn-primary rounded-pill px-4" onclick="showAddProductModal()">
                <i class="bi bi-plus-circle me-2"></i>Thêm sản phẩm
            </button>
        </div>

        @if($products->count() > 0)
            <div class="table-responsive">
                <table class="table modern-table">
                    <thead>
                        <tr>
                            <th style="width: 80px;">Hình ảnh</th>
                            <th>Tên sản phẩm</th>
                            <th>Danh mục</th>
                            <th>Giá</th>
                            <th>Biến thể</th>
                            <th>Tồn kho</th>
                            <th>Trạng thái</th>
                            <th style="width: 150px;" class="text-center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td>
                                    @if($product->mainImage)
                                        <img src="{{ $product->mainImage->image_url }}" 
                                             alt="{{ $product->name }}" 
                                             class="product-thumb">
                                    @else
                                        <div class="product-thumb bg-light d-flex align-items-center justify-content-center">
                                            <i class="bi bi-image text-muted"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div class="fw-semibold">{{ $product->name }}</div>
                                    <small class="text-muted">{{ $product->slug }}</small>
                                </td>
                                <td>
                                    @if($product->categories->count() > 0)
                                        <div class="d-flex flex-wrap gap-1">
                                            @foreach($product->categories->take(2) as $category)
                                                <span class="badge bg-secondary rounded-pill">{{ $category->name }}</span>
                                            @endforeach
                                            @if($product->categories->count() > 2)
                                                <span class="badge bg-light text-dark rounded-pill">+{{ $product->categories->count() - 2 }}</span>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-muted">Chưa phân loại</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="fw-bold text-primary">{{ number_format($product->base_price, 0, ',', '.') }} đ</span>
                                </td>
                                <td>
                                    @if($product->variants->count() > 0)
                                        <span class="badge bg-info rounded-pill">{{ $product->variants->count() }} biến thể</span>
                                    @else
                                        <span class="text-muted">Không có</span>
                                    @endif
                                </td>
                                <td>
                                    @if($product->inventory)
                                        <span class="fw-semibold {{ $product->inventory->getAvailableQuantity() > 0 ? 'text-success' : 'text-danger' }}">
                                            {{ $product->inventory->getAvailableQuantity() }}
                                        </span>
                                    @elseif($product->variants->count() > 0)
                                        @php
                                            $totalStock = $product->variants->sum(function($variant) {
                                                return $variant->inventory ? $variant->inventory->getAvailableQuantity() : 0;
                                            });
                                        @endphp
                                        <span class="fw-semibold {{ $totalStock > 0 ? 'text-success' : 'text-danger' }}">
                                            {{ $totalStock }}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $statusConfig = [
                                            'active' => ['class' => 'bg-success', 'text' => 'Hoạt động'],
                                            'draft' => ['class' => 'bg-secondary', 'text' => 'Bản nháp'],
                                            'inactive' => ['class' => 'bg-warning', 'text' => 'Tạm dừng'],
                                            'archived' => ['class' => 'bg-dark', 'text' => 'Lưu trữ'],
                                        ];
                                        $config = $statusConfig[$product->status] ?? $statusConfig['draft'];
                                    @endphp
                                    <span class="status-badge {{ $config['class'] }} text-white">
                                        {{ $config['text'] }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <button class="btn btn-sm btn-outline-primary rounded-pill" title="Xem" onclick="showProductDetail({{ $product->id }})">
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
            @if($products->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                    <div class="text-muted small">
                        Hiển thị {{ $products->firstItem() ?? 0 }} - {{ $products->lastItem() ?? 0 }} trong tổng số {{ $products->total() }} sản phẩm
                    </div>
                    <nav>
                        {{ $products->links() }}
                    </nav>
                </div>
            @endif
        @else
            <div class="text-center py-5">
                <div class="mb-3">
                    <i class="bi bi-inbox fs-1 text-muted"></i>
                </div>
                <h5 class="text-muted">Chưa có sản phẩm nào</h5>
                <p class="text-muted">Bắt đầu bằng cách thêm sản phẩm đầu tiên của bạn</p>
                <button class="btn btn-primary rounded-pill px-4 mt-3" onclick="showAddProductModal()">
                    <i class="bi bi-plus-circle me-2"></i>Thêm sản phẩm
                </button>
            </div>
        @endif
    </div>
</div>

<!-- Floating Action Button -->
<button class="fab" title="Thêm sản phẩm mới" onclick="showAddProductModal()">
    <i class="bi bi-plus-lg"></i>
</button>

@push('scripts')
<script>
// Get categories for select
const categories = @json($categories);

async function showAddProductModal() {
    const { value: formValues } = await Swal.fire({
        title: '<span style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; font-weight: 700; font-size: 1.5rem;">Thêm sản phẩm mới</span>',
        html: `
            <div style="text-align: left; padding: 1rem 0;">
                <div class="mb-3">
                    <label class="form-label fw-semibold text-muted small text-uppercase mb-2">Tên sản phẩm <span class="text-danger">*</span></label>
                    <input id="swal-name" class="form-control modern-input" placeholder="Nhập tên sản phẩm" required style="border: 2px solid #e9ecef; border-radius: 12px; padding: 0.75rem 1.25rem; transition: all 0.3s ease;">
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-semibold text-muted small text-uppercase mb-2">Slug <span class="text-danger">*</span></label>
                    <input id="swal-slug" class="form-control modern-input" placeholder="slug-san-pham" required style="border: 2px solid #e9ecef; border-radius: 12px; padding: 0.75rem 1.25rem; transition: all 0.3s ease;">
                    <small class="text-muted">Sẽ được tự động tạo từ tên nếu để trống</small>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-semibold text-muted small text-uppercase mb-2">Mô tả ngắn</label>
                    <textarea id="swal-short-description" class="form-control modern-input" rows="2" placeholder="Mô tả ngắn về sản phẩm" style="border: 2px solid #e9ecef; border-radius: 12px; padding: 0.75rem 1.25rem; transition: all 0.3s ease; resize: none;"></textarea>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-semibold text-muted small text-uppercase mb-2">Mô tả chi tiết</label>
                    <textarea id="swal-description" class="form-control modern-input" rows="4" placeholder="Mô tả chi tiết về sản phẩm" style="border: 2px solid #e9ecef; border-radius: 12px; padding: 0.75rem 1.25rem; transition: all 0.3s ease; resize: none;"></textarea>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold text-muted small text-uppercase mb-2">Giá cơ bản (đ) <span class="text-danger">*</span></label>
                        <input type="number" id="swal-base-price" class="form-control modern-input" placeholder="0" min="0" step="1000" value="0" required style="border: 2px solid #e9ecef; border-radius: 12px; padding: 0.75rem 1.25rem; transition: all 0.3s ease;">
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold text-muted small text-uppercase mb-2">Trạng thái <span class="text-danger">*</span></label>
                        <select id="swal-status" class="form-select modern-input" required style="border: 2px solid #e9ecef; border-radius: 12px; padding: 0.75rem 1.25rem; transition: all 0.3s ease;">
                            <option value="draft">Bản nháp</option>
                            <option value="active">Đang hoạt động</option>
                            <option value="inactive">Tạm dừng</option>
                            <option value="archived">Lưu trữ</option>
                        </select>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-semibold text-muted small text-uppercase mb-2">Danh mục sản phẩm</label>
                    <select id="swal-categories" class="multi-select" multiple>
                        ${categories.map(cat => `<option value="${cat.id}">${cat.name}</option>`).join('')}
                    </select>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-semibold text-muted small text-uppercase mb-2">Thứ tự sắp xếp</label>
                    <input type="number" id="swal-sort-order" class="form-control modern-input" placeholder="0" value="0" min="0" style="border: 2px solid #e9ecef; border-radius: 12px; padding: 0.75rem 1.25rem; transition: all 0.3s ease;">
                </div>
            </div>
        `,
        width: '700px',
        padding: '2rem',
        showCancelButton: true,
        confirmButtonText: '<i class="bi bi-check-circle me-2"></i>Tạo sản phẩm',
        cancelButtonText: '<i class="bi bi-x-circle me-2"></i>Hủy',
        confirmButtonColor: '#667eea',
        cancelButtonColor: '#6c757d',
        customClass: {
            popup: 'rounded-4',
            title: 'mb-4',
            htmlContainer: 'text-start',
            confirmButton: 'btn btn-primary rounded-pill px-4',
            cancelButton: 'btn btn-secondary rounded-pill px-4'
        },
        focusConfirm: false,
        didOpen: () => {
            // Auto-generate slug from name
            const nameInput = document.getElementById('swal-name');
            const slugInput = document.getElementById('swal-slug');
            
            nameInput.addEventListener('input', function() {
                if (!slugInput.value || slugInput.dataset.autoGenerated === 'true') {
                    const slug = this.value
                        .toLowerCase()
                        .normalize('NFD')
                        .replace(/[\u0300-\u036f]/g, '')
                        .replace(/đ/g, 'd')
                        .replace(/Đ/g, 'D')
                        .replace(/[^a-z0-9\s-]/g, '')
                        .replace(/\s+/g, '-')
                        .replace(/-+/g, '-')
                        .trim();
                    slugInput.value = slug;
                    slugInput.dataset.autoGenerated = 'true';
                }
            });
            
            // Focus on name input
            nameInput.focus();
            
            // Add focus styles
            const inputs = document.querySelectorAll('#swal2-html-container .modern-input');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.style.borderColor = '#667eea';
                    this.style.boxShadow = '0 0 0 4px rgba(102, 126, 234, 0.1)';
                    this.style.background = '#fff';
                });
                input.addEventListener('blur', function() {
                    this.style.borderColor = '#e9ecef';
                    this.style.boxShadow = 'none';
                    this.style.background = 'rgba(255, 255, 255, 0.9)';
                });
            });
            
            // Initialize MultiSelect component
            setTimeout(() => {
                const categorySelect = document.getElementById('swal-categories');
                if (categorySelect && !categorySelect.multiSelectInstance) {
                    categorySelect.multiSelectInstance = new MultiSelect(categorySelect, {
                        placeholder: 'Chọn danh mục sản phẩm...',
                        searchPlaceholder: 'Tìm kiếm danh mục...'
                    });
                }
            }, 100);
        },
        preConfirm: () => {
            const name = document.getElementById('swal-name').value.trim();
            const slug = document.getElementById('swal-slug').value.trim();
            const shortDescription = document.getElementById('swal-short-description').value.trim();
            const description = document.getElementById('swal-description').value.trim();
            const basePrice = parseFloat(document.getElementById('swal-base-price').value) || 0;
            const status = document.getElementById('swal-status').value;
            const sortOrder = parseInt(document.getElementById('swal-sort-order').value) || 0;
            const categoryIds = Array.from(document.getElementById('swal-categories').selectedOptions)
                .map(option => parseInt(option.value));
            
            if (!name) {
                Swal.showValidationMessage('Vui lòng nhập tên sản phẩm');
                return false;
            }
            
            if (!slug) {
                Swal.showValidationMessage('Vui lòng nhập slug');
                return false;
            }
            
            return {
                name,
                slug,
                short_description: shortDescription || null,
                description: description || null,
                base_price: basePrice,
                status,
                sort_order: sortOrder,
                category_ids: categoryIds
            };
        }
    });
    
    if (formValues) {
        // Submit form
        try {
            const formData = new FormData();
            Object.keys(formValues).forEach(key => {
                if (key === 'category_ids') {
                    formValues[key].forEach(id => formData.append('category_ids[]', id));
                } else {
                    formData.append(key, formValues[key]);
                }
            });
            
            const response = await fetch('{{ route("cms.products.store") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: formData
            });
            
            const data = await response.json();
            
            if (data.success) {
                await showSuccess(data.message || 'Đã tạo sản phẩm thành công!');
                window.location.reload();
            } else {
                let errorText = data.message || 'Có lỗi xảy ra khi tạo sản phẩm';
                
                // Handle validation errors
                if (data.errors && Object.keys(data.errors).length > 0) {
                    const errorMessages = Object.values(data.errors).flat();
                    errorText = errorMessages.join('\\n');
                }
                
                await showError(errorText);
            }
        } catch (error) {
            await showError('Lỗi: ' + error.message);
        }
    }
}

async function showProductDetail(productId) {
    try {
        // Show loading
        Swal.fire({
            title: 'Đang tải...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
        // Fetch product details
        const response = await fetch(`{{ route('cms.products.show', ':id') }}`.replace(':id', productId), {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        });
        
        const data = await response.json();
        
        if (!data.success || !data.data || !data.data.product) {
            await showError('Không thể tải thông tin sản phẩm');
            return;
        }
        
        const product = data.data.product;
        
        // Format status
        const statusConfig = {
            'active': { text: 'Đang hoạt động', class: 'bg-success' },
            'draft': { text: 'Bản nháp', class: 'bg-secondary' },
            'inactive': { text: 'Tạm dừng', class: 'bg-warning' },
            'archived': { text: 'Lưu trữ', class: 'bg-dark' },
        };
        const status = statusConfig[product.status] || statusConfig['draft'];
        
        // Format categories
        const categoriesHTML = product.categories && product.categories.length > 0
            ? product.categories.map(cat => `<span class="badge bg-secondary rounded-pill me-1 mb-1">${cat.name}</span>`).join('')
            : '<span class="text-muted">Chưa phân loại</span>';
        
        // Format images
        const imagesHTML = product.images && product.images.length > 0
            ? product.images.map((img, idx) => `
                <div class="col-md-3 mb-2">
                    <img src="${img.image_url}" alt="${img.alt_text || product.name}" 
                         class="img-fluid rounded" style="max-height: 100px; object-fit: cover; width: 100%; cursor: pointer;"
                         onclick="window.open('${img.image_url}', '_blank')">
                </div>
            `).join('')
            : '<div class="col-12"><p class="text-muted text-center">Chưa có hình ảnh</p></div>';
        
        // Format variants
        const variantsHTML = product.variants && product.variants.length > 0
            ? `
                <div class="table-responsive">
                    <table class="table table-sm table-bordered">
                        <thead>
                            <tr>
                                <th>SKU</th>
                                <th>Tùy chọn</th>
                                <th>Giá</th>
                                <th>Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${product.variants.map(v => `
                                <tr>
                                    <td><code>${v.sku}</code></td>
                                    <td>${v.option_name}: ${v.option_value}</td>
                                    <td>${parseFloat(v.price).toLocaleString('vi-VN')} đ</td>
                                    <td><span class="badge ${v.status === 'active' ? 'bg-success' : 'bg-secondary'}">${v.status === 'active' ? 'Hoạt động' : 'Tạm dừng'}</span></td>
                                </tr>
                            `).join('')}
                        </tbody>
                    </table>
                </div>
            `
            : '<p class="text-muted">Không có biến thể</p>';
        
        // Format inventory
        let inventoryHTML = '';
        if (product.inventory) {
            const available = product.inventory.available_quantity || 0;
            inventoryHTML = `
                <div class="d-flex align-items-center gap-2">
                    <span class="fw-semibold ${available > 0 ? 'text-success' : 'text-danger'}">
                        ${available}
                    </span>
                    <span class="text-muted">sản phẩm có sẵn</span>
                </div>
            `;
        } else if (product.variants && product.variants.length > 0) {
            inventoryHTML = '<p class="text-muted">Tồn kho được quản lý theo biến thể</p>';
        } else {
            inventoryHTML = '<p class="text-muted">Chưa có thông tin tồn kho</p>';
        }
        
        // Show modal
        Swal.fire({
            title: `<span style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; font-weight: 700; font-size: 1.5rem;">${product.name}</span>`,
            html: `
                <div style="text-align: left; padding: 1rem 0; max-height: 70vh; overflow-y: auto;">
                    <!-- Basic Info -->
                    <div class="mb-4">
                        <h6 class="fw-bold text-uppercase mb-3" style="color: #667eea; font-size: 0.875rem; letter-spacing: 1px;">Thông tin cơ bản</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="text-muted small text-uppercase">Tên sản phẩm</label>
                                <p class="fw-semibold mb-0">${product.name}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="text-muted small text-uppercase">Slug</label>
                                <p class="mb-0"><code>${product.slug}</code></p>
                            </div>
                            <div class="col-md-6">
                                <label class="text-muted small text-uppercase">Giá cơ bản</label>
                                <p class="fw-bold text-primary mb-0">${parseFloat(product.base_price).toLocaleString('vi-VN')} đ</p>
                            </div>
                            <div class="col-md-6">
                                <label class="text-muted small text-uppercase">Trạng thái</label>
                                <p class="mb-0"><span class="badge ${status.class} rounded-pill">${status.text}</span></p>
                            </div>
                            <div class="col-md-6">
                                <label class="text-muted small text-uppercase">Thứ tự sắp xếp</label>
                                <p class="mb-0">${product.sort_order || 0}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="text-muted small text-uppercase">Ngày tạo</label>
                                <p class="mb-0">${new Date(product.created_at).toLocaleString('vi-VN')}</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Description -->
                    ${product.short_description ? `
                    <div class="mb-4">
                        <h6 class="fw-bold text-uppercase mb-3" style="color: #667eea; font-size: 0.875rem; letter-spacing: 1px;">Mô tả ngắn</h6>
                        <p class="mb-0">${product.short_description}</p>
                    </div>
                    ` : ''}
                    
                    ${product.description ? `
                    <div class="mb-4">
                        <h6 class="fw-bold text-uppercase mb-3" style="color: #667eea; font-size: 0.875rem; letter-spacing: 1px;">Mô tả chi tiết</h6>
                        <p class="mb-0" style="white-space: pre-wrap;">${product.description}</p>
                    </div>
                    ` : ''}
                    
                    <!-- Categories -->
                    <div class="mb-4">
                        <h6 class="fw-bold text-uppercase mb-3" style="color: #667eea; font-size: 0.875rem; letter-spacing: 1px;">Danh mục sản phẩm</h6>
                        <div>${categoriesHTML}</div>
                    </div>
                    
                    <!-- Images -->
                    <div class="mb-4">
                        <h6 class="fw-bold text-uppercase mb-3" style="color: #667eea; font-size: 0.875rem; letter-spacing: 1px;">Hình ảnh</h6>
                        <div class="row g-2">
                            ${imagesHTML}
                        </div>
                    </div>
                    
                    <!-- Variants -->
                    <div class="mb-4">
                        <h6 class="fw-bold text-uppercase mb-3" style="color: #667eea; font-size: 0.875rem; letter-spacing: 1px;">Biến thể (${product.variants ? product.variants.length : 0})</h6>
                        ${variantsHTML}
                    </div>
                    
                    <!-- Inventory -->
                    <div class="mb-4">
                        <h6 class="fw-bold text-uppercase mb-3" style="color: #667eea; font-size: 0.875rem; letter-spacing: 1px;">Tồn kho</h6>
                        ${inventoryHTML}
                    </div>
                </div>
            `,
            width: '900px',
            padding: '2rem',
            showConfirmButton: true,
            confirmButtonText: '<i class="bi bi-check-circle me-2"></i>Đóng',
            confirmButtonColor: '#667eea',
            customClass: {
                popup: 'rounded-4',
                title: 'mb-4',
                htmlContainer: 'text-start',
                confirmButton: 'btn btn-primary rounded-pill px-4'
            },
            scrollbarPadding: false
        });
    } catch (error) {
        await showError('Lỗi: ' + error.message);
    }
}
</script>
@endpush
@endsection

