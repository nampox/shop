<div class="dropdown-menu-mega bag-dropdown">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="bag-content">
                    <h3 class="bag-title fw-bold mb-3">Giỏ hàng của bạn trống.</h3>
                    @auth
                        <p class="bag-subtitle text-white-50 mb-4">
                            Xin chào, <strong>{{ Auth::user()->name }}</strong>
                        </p>
                    @else
                        <p class="bag-subtitle text-white-50 mb-4">
                            <a href="{{ route('login') }}" class="text-decoration-none" style="color: #0071e3;">Đăng nhập</a> để xem các mục đã lưu
                        </p>
                    @endauth
                    
                    <div class="my-profile mt-4">
                        <h6 class="dropdown-heading" data-animation-delay="0.05">Hồ sơ của tôi</h6>
                        <ul class="list-unstyled">
                            @auth
                                <li class="dropdown-item" data-animation-delay="0.08">
                                    <a href="#" class="text-white text-decoration-none d-flex align-items-center py-2">
                                        <i class="bi bi-box-seam me-2" style="font-size: 1.2rem;"></i>
                                        <span>Đơn hàng</span>
                                    </a>
                                </li>
                                <li class="dropdown-item" data-animation-delay="0.12">
                                    <a href="#" class="text-white text-decoration-none d-flex align-items-center py-2">
                                        <i class="bi bi-bookmark me-2" style="font-size: 1.2rem;"></i>
                                        <span>Mục đã lưu của bạn</span>
                                    </a>
                                </li>
                                <li class="dropdown-item" data-animation-delay="0.16">
                                    <a href="#" class="text-white text-decoration-none d-flex align-items-center py-2">
                                        <i class="bi bi-person-circle me-2" style="font-size: 1.2rem;"></i>
                                        <span>Tài khoản</span>
                                    </a>
                                </li>
                                <li class="dropdown-item" data-animation-delay="0.2">
                                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="text-white text-decoration-none d-flex align-items-center py-2 border-0 bg-transparent w-100 text-start" style="font-size: inherit;">
                                            <i class="bi bi-box-arrow-right me-2" style="font-size: 1.2rem;"></i>
                                            <span>Đăng xuất</span>
                                        </button>
                                    </form>
                                </li>
                            @else
                                <li class="dropdown-item" data-animation-delay="0.08">
                                    <a href="{{ route('login') }}" class="text-white text-decoration-none d-flex align-items-center py-2">
                                        <i class="bi bi-box-arrow-in-right me-2" style="font-size: 1.2rem;"></i>
                                        <span>Đăng nhập</span>
                                    </a>
                                </li>
                                <li class="dropdown-item" data-animation-delay="0.12">
                                    <a href="{{ route('register') }}" class="text-white text-decoration-none d-flex align-items-center py-2">
                                        <i class="bi bi-person-plus me-2" style="font-size: 1.2rem;"></i>
                                        <span>Đăng ký</span>
                                    </a>
                                </li>
                            @endauth
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.bag-dropdown .bag-content {
    padding: 1rem 0;
}

.bag-title {
    font-size: 1.8rem;
    color: #f5f5f7;
}

.bag-subtitle {
    font-size: 0.95rem;
    color: #86868b;
}

.my-profile {
    margin-top: 1rem;
}
</style>

