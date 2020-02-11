<!DOCTYPE html>
<html lang="en">

<head>
    <base href="{{ asset('') }}" >
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <!-- Title  -->
    <title>Karl - Fashion Ecommerce Template | Home</title>

    <!-- Favicon  -->
    <link rel="icon" href="img/core-img/favicon.ico">

    <!-- Core Style CSS -->
    <link rel="stylesheet" href="css/core-style.css">


    <!-- Responsive CSS -->
    <link href="css/responsive.css" rel="stylesheet">
    <!-- jQuery (Necessary for All JavaScript Plugins) -->
    <script src="js/jquery/jquery-2.2.4.min.js"></script>
    <!-- Popper js -->
    <script src="js/popper.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.js"></script>
  <script src="{{ asset('admin/plugins/jquery-validation/jquery.validate.min.js')}}"></script>

</head>
<body>
    <div class="catagories-side-menu">
        <!-- Close Icon -->
        <div id="sideMenuClose">
            <i class="ti-close"></i>
        </div>
        <!--  Side Nav  -->
        <div class="nav-side-menu">
            <div class="menu-list">
                <h6>Danh mục sản phẩm</h6>
                <ul id="menu-content" class="menu-content collapse out">
                  @foreach ($menu_data as $item)
                    <li data-toggle="collapse" data-target="{{ count($item['child']) > 0 ? '#'.$item['url'].'' :''}}" class="collapsed active">
                        <a href="#">{{ $item['name'] }} <span class="arrow"></span></a>
                        @if ( count($item['child']) > 0 )
                             <ul class="sub-menu collapse" id="{{ $item['url'] }}">
                                @foreach ($item['child'] as $item1)
                                     <li><a href="{{ url('danh-muc-san-pham/'.$item1['url']) }}">{{ $item1['name'] }}</a></li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                  @endforeach
                </ul>
            </div>
        </div>
    </div>
    <div id="wrapper">
        <!-- ****** Header Area Start ****** -->
          @include('layouts.home.home_header')
        <!-- ****** Header Area End ****** -->

        <!-- ****** Top Discount Area Start ****** -->
        @if(isset($discount))
            <section class="top-discount-area d-md-flex align-items-center wow fadeInDown" data-wow-delay=".25s" >
                <!-- Single Discount Area -->
                <div class="single-discount-area">
                    <h5>{{ $discount->discount1 }}</h5>

                </div>
               <!--  Single Discount Area -->
                <div class="single-discount-area">
                       <h5>{{ $discount->discount2 }}</h5>


                </div>
                <!-- Single Discount Area -->
                <div class="single-discount-area">
                       <h5>{{ $discount->discount3 }}</h5>


                </div>
            </section>

        @endif


        <!-- ****** Top Discount Area End ****** -->

        <!-- ****** Welcome Slides Area Start ****** -->

        <!-- ****** Welcome Slides Area End ****** -->
            @yield('content')
        <!-- ****** Footer Area Start ****** -->
        @include('layouts.home.home_footer')
        <!-- ****** Footer Area End ****** -->
    </div>
    <!-- /.wrapper end -->


    <!-- Bootstrap js -->
    <script src="js/bootstrap.min.js"></script>
    <!-- Plugins js -->
    <script src="js/plugins.js"></script>
    <!-- Active js -->
    <script src="js/active.js"></script>

</body>

</html>