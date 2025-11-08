@extends('layouts.cms')

@section('title', 'Quản lý Danh mục')
@section('page-title', 'Quản lý Danh mục')

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
                        <h6 class="text-white-50 mb-2 text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px;">Tổng danh mục</h6>
                        <h2 class="mb-0 text-white fw-bold">{{ $stats['total'] }}</h2>
                    </div>
                    <div class="fs-1 opacity-50">
                        <i class="bi bi-folder"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stat-card gradient-bg-success">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 mb-2 text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px;">Đang hoạt động</h6>
                        <h2 class="mb-0 text-white fw-bold">{{ $stats['active'] }}</h2>
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
                        <h6 class="text-white-50 mb-2 text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px;">Không hoạt động</h6>
                        <h2 class="mb-0 text-white fw-bold">{{ $stats['inactive'] }}</h2>
                    </div>
                    <div class="fs-1 opacity-50">
                        <i class="bi bi-x-circle"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stat-card gradient-bg-warning">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 mb-2 text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px;">Danh mục con</h6>
                        <h2 class="mb-0 text-white fw-bold">{{ $stats['with_parent'] }}</h2>
                    </div>
                    <div class="fs-1 opacity-50">
                        <i class="bi bi-folder-symlink"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="filter-section">
        <form method="GET" action="{{ route('cms.categories') }}" class="row g-3">
            <div class="col-md-4">
                <label class="form-label fw-semibold text-muted small text-uppercase">Tìm kiếm</label>
                <input type="text" 
                       name="search" 
                       class="form-control modern-input" 
                       placeholder="Tên danh mục, slug..." 
                       value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold text-muted small text-uppercase">Trạng thái</label>
                <select name="is_active" class="form-select modern-input">
                    <option value="">Tất cả</option>
                    <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>Đang hoạt động</option>
                    <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>Không hoạt động</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold text-muted small text-uppercase">Danh mục cha</label>
                <select name="parent" class="form-select modern-input">
                    <option value="">Tất cả</option>
                    <option value="null" {{ request('parent') === 'null' ? 'selected' : '' }}>Không có danh mục cha</option>
                    @foreach($parentCategories as $parent)
                        <option value="{{ $parent->id }}" {{ request('parent') == $parent->id ? 'selected' : '' }}>
                            {{ $parent->name }}
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

    <!-- Categories Table -->
    <div class="glass-card rounded-4 p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0 gradient-text">Danh sách danh mục</h4>
            <button class="btn btn-primary rounded-pill px-4" onclick="showAddCategoryModal()">
                <i class="bi bi-plus-circle me-2"></i>Thêm danh mục
            </button>
        </div>

        @if($categories->count() > 0)
            <div class="table-responsive">
                <table class="table modern-table">
                    <thead>
                        <tr>
                            <th>Tên danh mục</th>
                            <th>Slug</th>
                            <th>Danh mục cha</th>
                            <th>Số sản phẩm</th>
                            <th>Số danh mục con</th>
                            <th>Thứ tự</th>
                            <th>Trạng thái</th>
                            <th style="width: 150px;" class="text-center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                            <tr>
                                <td>
                                    <div class="fw-semibold">{{ $category->name }}</div>
                                    @if($category->description)
                                        <small class="text-muted">{{ Str::limit($category->description, 50) }}</small>
                                    @endif
                                </td>
                                <td>
                                    <code class="text-muted">{{ $category->slug }}</code>
                                </td>
                                <td>
                                    @if($category->parent)
                                        <span class="badge bg-secondary rounded-pill">{{ $category->parent->name }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-info rounded-pill">{{ $category->products->count() ?? 0 }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-primary rounded-pill">{{ $category->children->count() ?? 0 }}</span>
                                </td>
                                <td>
                                    <span class="fw-semibold">{{ $category->sort_order }}</span>
                                </td>
                                <td>
                                    @if($category->is_active)
                                        <span class="status-badge bg-success text-white">Hoạt động</span>
                                    @else
                                        <span class="status-badge bg-secondary text-white">Không hoạt động</span>
                                    @endif
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
            @if($categories->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                    <div class="text-muted small">
                        Hiển thị {{ $categories->firstItem() ?? 0 }} - {{ $categories->lastItem() ?? 0 }} trong tổng số {{ $categories->total() }} danh mục
                    </div>
                    <nav>
                        {{ $categories->links() }}
                    </nav>
                </div>
            @endif
        @else
            <div class="text-center py-5">
                <div class="mb-3">
                    <i class="bi bi-inbox fs-1 text-muted"></i>
                </div>
                <h5 class="text-muted">Chưa có danh mục nào</h5>
                <p class="text-muted">Bắt đầu bằng cách thêm danh mục đầu tiên của bạn</p>
                <button class="btn btn-primary rounded-pill px-4 mt-3" onclick="showAddCategoryModal()">
                    <i class="bi bi-plus-circle me-2"></i>Thêm danh mục
                </button>
            </div>
        @endif
    </div>
</div>

<!-- Floating Action Button -->
<button class="fab" title="Thêm danh mục mới" onclick="showAddCategoryModal()">
    <i class="bi bi-plus-lg"></i>
</button>

@push('scripts')
<script>
// Get parent categories for select
const parentCategories = @json($parentCategories);

async function showAddCategoryModal() {
    const { value: formValues } = await Swal.fire({
        title: '<span style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; font-weight: 700; font-size: 1.5rem;">Thêm danh mục mới</span>',
        html: `
            <div style="text-align: left; padding: 1rem 0;">
                <div class="mb-3">
                    <label class="form-label fw-semibold text-muted small text-uppercase mb-2">Tên danh mục <span class="text-danger">*</span></label>
                    <input id="swal-name" class="form-control modern-input" placeholder="Nhập tên danh mục" required style="border: 2px solid #e9ecef; border-radius: 12px; padding: 0.75rem 1.25rem; transition: all 0.3s ease;">
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-semibold text-muted small text-uppercase mb-2">Slug <span class="text-danger">*</span></label>
                    <input id="swal-slug" class="form-control modern-input" placeholder="slug-danh-muc" required style="border: 2px solid #e9ecef; border-radius: 12px; padding: 0.75rem 1.25rem; transition: all 0.3s ease;">
                    <small class="text-muted">Sẽ được tự động tạo từ tên nếu để trống</small>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-semibold text-muted small text-uppercase mb-2">Mô tả</label>
                    <textarea id="swal-description" class="form-control modern-input" rows="3" placeholder="Mô tả về danh mục" style="border: 2px solid #e9ecef; border-radius: 12px; padding: 0.75rem 1.25rem; transition: all 0.3s ease; resize: none;"></textarea>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold text-muted small text-uppercase mb-2">Danh mục cha</label>
                        <select id="swal-parent-id" class="form-select modern-input" style="border: 2px solid #e9ecef; border-radius: 12px; padding: 0.75rem 1.25rem; transition: all 0.3s ease;">
                            <option value="">Không có (Danh mục gốc)</option>
                            ${parentCategories.map(cat => `<option value="${cat.id}">${cat.name}</option>`).join('')}
                        </select>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold text-muted small text-uppercase mb-2">Trạng thái <span class="text-danger">*</span></label>
                        <select id="swal-is-active" class="form-select modern-input" required style="border: 2px solid #e9ecef; border-radius: 12px; padding: 0.75rem 1.25rem; transition: all 0.3s ease;">
                            <option value="1" selected>Đang hoạt động</option>
                            <option value="0">Không hoạt động</option>
                        </select>
                    </div>
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
        confirmButtonText: '<i class="bi bi-check-circle me-2"></i>Tạo danh mục',
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
        },
        preConfirm: () => {
            const name = document.getElementById('swal-name').value.trim();
            const slug = document.getElementById('swal-slug').value.trim();
            const description = document.getElementById('swal-description').value.trim();
            const parentId = document.getElementById('swal-parent-id').value;
            const isActive = document.getElementById('swal-is-active').value === '1';
            const sortOrder = parseInt(document.getElementById('swal-sort-order').value) || 0;
            
            if (!name) {
                Swal.showValidationMessage('Vui lòng nhập tên danh mục');
                return false;
            }
            
            if (!slug) {
                Swal.showValidationMessage('Vui lòng nhập slug');
                return false;
            }
            
            return {
                name,
                slug,
                description: description || null,
                parent_id: parentId ? parseInt(parentId) : null,
                is_active: isActive,
                sort_order: sortOrder
            };
        }
    });
    
    if (formValues) {
        // Submit form
        try {
            const formData = new FormData();
            Object.keys(formValues).forEach(key => {
                if (formValues[key] !== null && formValues[key] !== undefined) {
                    // Convert boolean to 1/0 for FormData
                    if (typeof formValues[key] === 'boolean') {
                        formData.append(key, formValues[key] ? '1' : '0');
                    } else {
                        formData.append(key, formValues[key]);
                    }
                }
            });
            
            const response = await fetch('{{ route("cms.categories.store") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: formData
            });
            
            const data = await response.json();
            
            if (data.success) {
                await showSuccess(data.message || 'Đã tạo danh mục thành công!');
                window.location.reload();
            } else {
                let errorText = data.message || 'Có lỗi xảy ra khi tạo danh mục';
                
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
</script>
@endpush
@endsection

