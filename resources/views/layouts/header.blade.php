<nav class="navbar navbar-expand-lg navbar-dark bg-dark p-0">
    <div class="container-fluid px-4">
        <!-- Mobile toggle -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <!-- Menu items - centered -->
        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}"><img src="{{ asset('images/icon-iphone.png') }}" alt="Home"></a>
                </li>
                <li class="nav-item dropdown-mega" data-dropdown="mac">
                    <a class="nav-link" href="#">Mac</a>
                    <div class="dropdown-content">
                        @include('components.dropdown-menu')
                    </div>
                </li>
                <li class="nav-item dropdown-mega" data-dropdown="ipad">
                    <a class="nav-link" href="#">iPad</a>
                    <div class="dropdown-content">
                        @include('components.dropdown-ipad')
                    </div>
                </li>
                <li class="nav-item dropdown-mega" data-dropdown="iphone">
                    <a class="nav-link" href="#">iPhone</a>
                    <div class="dropdown-content">
                        @include('components.dropdown-iphone')
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Watch</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">AirPods</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Accessories</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Support</a>
                </li>
                <li class="nav-item dropdown-mega" data-dropdown="search">
                    <a class="nav-link" href="#"><i class="bi bi-search"></i></a>
                    <div class="dropdown-content">
                        @include('components.search-dropdown')
                    </div>
                </li>
                <li class="nav-item dropdown-mega" data-dropdown="bag">
                    <a class="nav-link" href="#"><i class="bi bi-bag"></i></a>
                    <div class="dropdown-content">
                        @include('components.bag-dropdown')
                    </div>
                </li>
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><span class="dropdown-item-text">{{ Auth::user()->name }}</span></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Đăng xuất</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}"><i class="bi bi-person-plus"></i> Đăng ký</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}"><i class="bi bi-box-arrow-in-right"></i> Đăng nhập</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

