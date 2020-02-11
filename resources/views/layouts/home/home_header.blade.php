
<header class="header_area wow fadeInUp" data-wow-delay=".25s">
    <!-- Top Header Area Start -->
    <div class="top_header_area">
        <div class="container h-100">
            <div class="row h-100 align-items-center justify-content-end">
                <div class="col-12 col-lg-12">
                    <div class="top_single_area d-flex align-items-center" style="justify-content: space-between;">
                        <div class="header-social-area wow fadeInLeft " data-wow-delay=".25s">
                            <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                            <a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                            <a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
                        </div>
                        <div class="search wow bounceInDown" data-wow-delay="1s">
                            <form id="demo-2">
                                <input type="text" class="searchTerm" placeholder="What are you looking for?">
                                <button type="submit" class="searchButton">
                                    <i class="fa fa-search"></i>
                                </button>
                            </form>
                        </div>
                        <div class="header-social-area wow fadeInRight " data-wow-delay=".25s">
                            @if(Auth::guard('customers')->check())
                            <a href="{{ url('login-register') }}" data-toggle="dropdown"><i class="ti-user" style="margin-right: 5px;"></i>{{ Auth::guard('customers')->user()->name}} </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="account-link" href="{{ url('account/history-order') }}"><i class="ti-medall-alt" style="margin-right: 5px;"></i>Lịch sử</a>
                                <a class="account-link" href="{{ url('account/view-account') }}"><i class="ti-settings" style="margin-right: 5px;" ></i>Cài đặt</a>
                            </div>
                               <a href="{{ url('logout-home') }}" title="Đăng xuất"><i class="ti-shift-right"></i></a>
                            @else
                            <a href="{{ url('login-register') }}"><i class="ti-user" style="margin-right: 5px;"></i>Tài khoản </a>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Top Header Area End -->
    <div class="main_header_area">
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-12 d-md-flex justify-content-between">
                    <!-- Header Social Area -->
                    <div class="header-social-area">
                        <div class="top_logo">
                            <a href="#"><img src="img/core-img/logo.png" alt=""></a>
                        </div>
                    </div>
                    <!-- Menu Area -->
                    <div class="main-menu-area">
                        <nav class="navbar navbar-expand-lg align-items-start">
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#karl-navbar" aria-controls="karl-navbar" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"><i class="ti-menu"></i></span></button>
                            <div class="collapse navbar-collapse align-items-start collapse" id="karl-navbar">
                                <ul class="navbar-nav animated" id="nav">
                                    <li class="nav-item active"><a class="nav-link" href="{{ url('/') }}">Trang chủ</a></li>
                                    @foreach ($category as $value)
                                    <li class="nav-item"><a class="nav-link" href="{{ url('danh-muc-san-pham/'.$value->url) }}">{{ $value->name }}</a></li>
                                    @endforeach
                                    <li class="nav-item"><a class="nav-link" href="#">Liên hệ</a></li>
                                </ul>
                            </div>
                        </nav>
                    </div>
                    <div class="cart">

                    </div>
                    <div class="header-right-side-menu ml-15">
                        <a href="#" id="sideMenuBtn"><i class="ti-menu" aria-hidden="true"></i><span>Danh mục sản phẩm</span></a>
                    </div>
                    <!-- Cart -->
                    <div class="cart">
                        <a href="#" id="header-cart-btn" target="_blank"><span class="cart_quantity">2</span> <i class="ti-bag"></i> </a>
                        <!-- Cart List Area Start -->
                        <ul class="cart-list">
                            <li>
                                <a href="#" class="image"><img src="img/product-img/product-10.jpg" class="cart-thumb" alt=""></a>
                                <div class="cart-item-desc">
                                    <h6><a href="#">Women's Fashion</a></h6>
                                    <p>1x - <span class="price">$10</span></p>
                                </div>
                                <span class="dropdown-product-remove"><i class="icon-cross"></i></span>
                            </li>
                            <li>
                                <a href="#" class="image"><img src="img/product-img/product-11.jpg" class="cart-thumb" alt=""></a>
                                <div class="cart-item-desc">
                                    <h6><a href="#">Women's Fashion</a></h6>
                                    <p>1x - <span class="price">$10</span></p>
                                </div>
                                <span class="dropdown-product-remove"><i class="icon-cross"></i></span>
                            </li>
                            <li class="total">
                                <span class="pull-right">Total: $20.00</span>
                                <a href="{{ url('account/view-cart') }}" class="btn btn-sm btn-cart">Cart</a>
                                <a href="{{ url('account/check-out') }}" class="btn btn-sm btn-checkout">Checkout</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        a.account-link:hover{
            color: red;
        }
    </style>
</header>