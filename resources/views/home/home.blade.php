@extends('layouts.home.home_layout')
@section('content')
@include('layouts.home.home_slide')
<style>
    .widget-desc ul li {
        margin-right: 10px;
    }
</style>

<!-- ****** New Arrivals Area Start ****** -->
<section class="new_arrivals_area section_padding_100_0 clearfix">
    <div class="container">
        <div class="row">
            <div class="col-12 d-flex justify-content-between">
                <div class="section_heading text-left">
                    <h3 class="wow bounceInDown" data-wow-delay="0.1s">Sản phẩm mới</h3>
                </div>
                <div class="karl-projects-menu mb-100 wow bounceInDown" data-wow-delay="0.1s">
                    <div class="text-center portfolio-menu">
                        <button class="btn active" data-filter="*">ALL</button>
                        <button class="btn" data-filter=".women">WOMAN</button>
                        <button class="btn" data-filter=".man">MAN</button>
                        <button class="btn" data-filter=".access">ACCESSORIES</button>
                        <button class="btn" data-filter=".shoes">shoes</button>
                        <button class="btn" data-filter=".kids">KIDS</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="container">
        <div class="row karl-new-arrivals">
            @foreach($product_new as $value)

            <div class="col-12 col-sm-6 col-md-3 single_gallery_item women wow fadeInUpBig" data-wow-delay="0.2s" style="border: solid 1px #eee;">

               @if($value->sale > 0)
               <div class="item-card__badge-right-wrapper"> <div class="badge-text badge-text--promotion"> <div class="badge-text__text typo-r12"> <div class="badge__promotion">GIẢM<div class="badge__promotion-off">{{ $value->sale }}%</div> </div> </div> </div> </div>
               @endif
               <!-- Product Image -->
               <div class="product-img">
                <img src="{{ asset('uploads/images/products/'.$value->image) }}" alt="">
                <div class="product-quicview">
                 <a href="#" data-toggle="modal" data-id="{{ $value->id }}" data-target="#quickview" class="btn-review"><i class="ti-eye"></i></a>
                 <div class="pi-links">
                    <a href="#" class="add-card"><i class="ti-bag"></i><span>ADD TO CART</span></a>
                    <a href="#" class="wishlist-btn"><i class="ti-heart"></i></a>
                </div>
            </div>
        </div>
        <!-- Product Description -->
        <div class="product-description">
            <div class="list-price d-flex justify-content-between">
                @if($value->promotional_price > 0)
                <h4 class="product-price">{{ number_format($value->promotional_price) }} VND</h4>
                <h4 class="product-price-promotional" style="color: #ff084e">{{ number_format($value->price) }} VND</h4>
                @endif
                @if($value->promotional_price == 0)
                <h4 class="product-price">{{ number_format($value->price) }} VND</h4>
                @endif
            </div>
            <a class="product-name" href="{{ url('/'.$value->url) }}">{{ $value->name }}</a>
        </div>
    </div>
    @endforeach
</div>
</div>
</section>
<!-- ****** New Arrivals Area End ****** -->

<!-- ****** Offer Area Start ****** -->
<section class="offer_area height-700 section_padding_100 bg-img " style="background-image: url(img/bg-img/bg-5.jpg);">
    <div class="container h-100">
        <div class="row h-100 align-items-end justify-content-end">
            <div class="col-12 col-md-8 col-lg-6">
                <div class="offer-content-area wow fadeInUp" data-wow-delay="1s">
                    <h2>White t-shirt <span class="karl-level">Hot</span></h2>
                    <p>* Free shipping until 25 Dec 2017</p>
                    <div class="offer-product-price">
                        <h3><span class="regular-price">$25.90</span> $15.90</h3>
                    </div>
                    <a href="#" class="btn karl-btn mt-30">Shop Now</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ****** Offer Area End ****** -->

<!-- ****** Popular Brands Area Start ****** -->
<section class="karl-testimonials-area section_padding_100">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section_heading text-center">
                    <h2>Testimonials</h2>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-12 col-md-8">
                <div class="karl-testimonials-slides owl-carousel">

                    <!-- Single Testimonial Area -->
                    <div class="single-testimonial-area text-center">
                        <span class="quote">"</span>
                        <h6>Nunc pulvinar molestie sem id blandit. Nunc venenatis interdum mollis. Aliquam finibus nulla quam, a iaculis justo finibus non. Suspendisse in fermentum nunc.Nunc pulvinar molestie sem id blandit. Nunc venenatis interdum mollis. </h6>
                        <div class="testimonial-info d-flex align-items-center justify-content-center">
                            <div class="tes-thumbnail">
                                <img src="img/bg-img/tes-1.jpg" alt="">
                            </div>
                            <div class="testi-data">
                                <p>Michelle Williams</p>
                                <span>Client, Los Angeles</span>
                            </div>
                        </div>
                    </div>

                    <!-- Single Testimonial Area -->
                    <div class="single-testimonial-area text-center">
                        <span class="quote">"</span>
                        <h6>Nunc pulvinar molestie sem id blandit. Nunc venenatis interdum mollis. Aliquam finibus nulla quam, a iaculis justo finibus non. Suspendisse in fermentum nunc.Nunc pulvinar molestie sem id blandit. Nunc venenatis interdum mollis. </h6>
                        <div class="testimonial-info d-flex align-items-center justify-content-center">
                            <div class="tes-thumbnail">
                                <img src="img/bg-img/tes-1.jpg" alt="">
                            </div>
                            <div class="testi-data">
                                <p>Michelle Williams</p>
                                <span>Client, Los Angeles</span>
                            </div>
                        </div>
                    </div>

                    <!-- Single Testimonial Area -->
                    <div class="single-testimonial-area text-center">
                        <span class="quote">"</span>
                        <h6>Nunc pulvinar molestie sem id blandit. Nunc venenatis interdum mollis. Aliquam finibus nulla quam, a iaculis justo finibus non. Suspendisse in fermentum nunc.Nunc pulvinar molestie sem id blandit. Nunc venenatis interdum mollis. </h6>
                        <div class="testimonial-info d-flex align-items-center justify-content-center">
                            <div class="tes-thumbnail">
                                <img src="img/bg-img/tes-1.jpg" alt="">
                            </div>
                            <div class="testi-data">
                                <p>Michelle Williams</p>
                                <span>Client, Los Angeles</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</section>
<!-- ****** Popular Brands Area End ****** -->
<script>
  $(document).on("click", ".chossesize", function() {
    $(this).removeAttr("href");
    var sizeid =$(this).data('id');
    //$("#id_size").val(id);
    var product_id = $('#product_id').val();
       //alert(product_id);
       $.ajax({
        url: "{{ url('stock') }}",
        type: "POST",
                //dataType:'JSON',
                cache: false,
                data: {sizeid: sizeid, product_id: product_id},
                headers: {
                    'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
                },
                success: function(data){
                    console.log(data);
                    if (data.status == '_success') {
                        $('#id_size').val(sizeid);
                        $('.available').html('Bạn đã chọn size: '+data.size);
                    }
                    if (data.status == '_error') {
                        $('.available').html(data.msg);
                        $('#id_size').val('');
                        $('.cart-submit').hide();
                        setTimeout(function(){ window.location.reload(); }, 2000);
                    }
                },
                error:function(err) {
                    console.log(err);
                }
            });
   });
</script>
<script>
    $(function(){
      $(".qty-plus").click(function(){
        var inpt = $(this).parents(".quantity").find("[name=quantity]");
        var val = parseInt(inpt.val());
        if ( val < 0 ) inpt.val(val=0);
        inpt.val(val+1);
        var valinpt =inpt.val();
        var size_id = $('#id_size').val();
        var product_id = $('#product_id').val();
        if (size_id == '') {
                //$("html, body").animate({ scrollTop: 0 }, 600);
                $('.available').html("Hãy chọn size trước");
                setTimeout(function(){ window.location.reload(); }, 2000);
        }
        else{
            $.ajax({
                url: "{{ url('stocksize') }}",
                type: "POST",
                dataType:'JSON',
                cache: false,
                data: {sizeid: size_id, product_id: product_id, qty: valinpt},
                headers: {
                    'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
                },
                success: function(data){
                    console.log(data);
                    if (data.status == '_error') {
                        $('.qty-text').notify(data.msg, "error");
                        $('.cart-submit').hide();
                        $('.available').html("Số lượng quá lớn. Hãy nhập lại ");
                        setTimeout(function(){ window.location.reload(); }, 2000);
                    }
                },
                error:function(err) {
                    console.log(err);
                }
            });
        }
    });
      $(".qty-minus").click(function(){
        var inpt = $(this).parents(".quantity").find("[name=quantity]");
        var val = parseInt(inpt.val());
        //if ( val < 1 ) inpt.val(val=1);
        if ( val == 1 ) return;
        inpt.val(val-1);
        var valinpt =inpt.val();
        var size_id = $('#size_id').val();
        var product_id = $('#product_id').val();
        $.ajax({
            url: "{{ url('stocksize') }}",
            type: "POST",
            dataType:'JSON',
            cache: false,
            data: {sizeid: size_id, product_id: product_id, qty: valinpt},
            headers: {
                'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
            },
            success: function(data){
                console.log(data);
                if (data.status == '_error') {
                        //$("html, body").animate({ scrollTop: 0 }, 600);
                        $('.qty-text').notify(data.msg, "error");
                        // $('.available').html(data.msg);
                        $('.cart-submit').hide();
                        setTimeout(function(){ window.location.reload(); }, 2000);
                    }
                },
                error:function(err) {
                    console.log(err);
                }
            });
    });
  });
</script>
<script>
    $(document).on("click", ".btn-review", function() {
        let id = $(this).data('id');
        $.ajax({
          url: '{{url("modal-review")}}',
          type: 'POST',
          data: {id: id},
          dataType: 'JSON',
          headers: {
            'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
        },
        success:function(data) {
            //console.log(data);
            $("#quickview .quickview_pro_des h4").html(data.name_product);
            if (data.pricepronone > 0 ) {
                $("#quickview .quickview_pro_des .price").html(data.price_product);
                $("#quickview .quickview_pro_des .price").css('text-decoration','line-through');
                $("#quickview .quickview_pro_des .sale ").html(data.sale_product);
            }
            else{
                $("#quickview .quickview_pro_des .price").html(data.price_product);
            }
            $("#quickview .quickview_pro_des p ").html(data.des_product);
            $("#quickview .size  ").html(data.body_size);
            $("#quickview .quickview_pro_img img ").attr("src",data.avatar_product);
            $("#quickview .cart input[name='product_id']").val(data.product_id);
            $("#quickview").modal('show');
        },
        error: function(err) {
            console.log(err);
        }
    });
        return false;
    });
    $('#quickview').on('hidden.bs.modal', function () {
        $('#id_size').val('');
    });



</script>
@endsection