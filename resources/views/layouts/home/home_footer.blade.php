<!-- ****** Quick View Modal Area Start ****** -->
<div class="modal fade" id="quickview" tabindex="-1" role="dialog" aria-labelledby="quickview" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close btn" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="modal-body">
                <div class="quickview_body">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 col-lg-5">
                                <div class="quickview_pro_img">
                                    <img src="" alt="">
                                </div>
                            </div>
                            <div class="col-12 col-lg-7">
                                <div class="quickview_pro_des">
                                    <h4 class="title" style="font-size: 16px;"></h4>
                                    <div class="row ml-1">
                                        <h5 class="price" style="font-size: 14px;"></h5>
                                        <span class="sale" style="font-size: 14px;margin-left: 18px"></span>
                                    </div>
                                    <p></p>
                                </div>
                                <!-- Add to Cart Form -->
                                <form class="cart" method="post" action="{{ url('add-cart') }}" id="frmcart">
                                    @csrf

                                    <input type="hidden" name="product_id" value="" id="product_id">
                                    <input type="hidden" name="id_size" class="id_size" id="id_size" value="">

                                    <div class="widget size mt-30">
                                        <h6 class="widget-title">Size</h6>

                                        <div class="widget-desc">
                                            <ul>
                                                <li><a href="#">M</a></li>
                                                <li><a href="#">S</a></li>
                                                <li><a href="#">XS</a></li>
                                                <li><a href="#">L</a></li>
                                                <li><a href="#">XL</a></li>
                                                <li><a href="#">42</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <p class="available" style="font-size: 12px; font-style: italic; color:red;"></p>
                                    <div class="widget quantity mt-30">
                                        <div class="quantity">
                                            <span class="qty-minus"><i class="fa fa-minus" aria-hidden="true"></i></span>
                                            <input type="number" class="qty-text" id="qty" step="1" min="1" max="12" name="quantity" value="1" autocomplete="off">
                                            <span class="qty-plus"><i class="fa fa-plus" aria-hidden="true"></i></span>
                                        </div>
                                        <button type="submit" name="addtocart" value="5" class="cart-submit">Add to cart</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ****** Quick View Modal Area End ****** -->
<footer class="footer_area">
    <div class="container">
        <div class="row">
            <!-- Single Footer Area Start -->
            <div class="col-12 col-md-6 col-lg-3">
                <div class="single_footer_area">
                    <div class="footer-logo">
                        <img src="img/core-img/logo.png" alt="">
                    </div>
                    <div class="copywrite_text d-flex align-items-center">
                        <p>
                            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                            Copyright &copy;
                            <script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
                        </p>
                    </div>
                </div>
            </div>
            <!-- Single Footer Area Start -->
            <div class="col-12 col-sm-6 col-md-3 col-lg-2">
                <div class="single_footer_area">
                    <ul class="footer_widget_menu">
                        <li><a href="#">About</a></li>
                        <li><a href="#">Blog</a></li>
                        <li><a href="#">Faq</a></li>
                        <li><a href="#">Returns</a></li>
                        <li><a href="#">Contact</a></li>
                    </ul>
                </div>
            </div>
            <!-- Single Footer Area Start -->
            <div class="col-12 col-sm-6 col-md-3 col-lg-2">
                <div class="single_footer_area">
                    <ul class="footer_widget_menu">
                        <li><a href="#">My Account</a></li>
                        <li><a href="#">Shipping</a></li>
                        <li><a href="#">Our Policies</a></li>
                        <li><a href="#">Afiliates</a></li>
                    </ul>
                </div>
            </div>
            <!-- Single Footer Area Start -->
            <div class="col-12 col-lg-5">
                <div class="single_footer_area">
                    <div class="footer_heading mb-30">
                        <h6>Subscribe to our newsletter</h6>
                    </div>
                    <div class="subscribtion_form">
                        <form action="#" method="post">
                            <input type="email" name="mail" class="mail" placeholder="Your email here">
                            <button type="submit" class="submit">Subscribe</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="line"></div>
        <!-- Footer Bottom Area Start -->
        <div class="footer_bottom_area">
            <div class="row">
                <div class="col-12">
                    <div class="footer_social_area text-center">
                        <a href="#"><i class="fa fa-pinterest" aria-hidden="true"></i></a>
                        <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                        <a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                        <a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

  <!-- var ps = $("#province option:selected").val();
        if ($.trim(ps) != '') {
            $.ajax({
                url: '',
                type: 'POST',
                data: {provinceid: ps},
                dataType: 'JSON',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(district_data) {
                    let district_html = "";
                    $.each(district_data, function(index, value) {
                        district_html += "<option value='"+value.districtid+"'>"+value.type+" "+value.name+"</option>";
                    });
                    $("#district").html(district_html);
                    $("#district option[value='']").prop('selected', true);
                    let ds = $("#district option:selected").val();
                    $.ajax({
                        url: '',
                        type: 'POST',
                        data: {districtid: ds},
                        dataType: 'JSON',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(ward_data) {
                            let ward_html = "";
                            $.each(ward_data, function(index, value) {
                                ward_html += "<option value='"+value.wardid+"'>"+value.type+" "+value.name+"</option>";
                            });
                            $("#ward").html(ward_html);
                            $("#ward option[value='']").prop('selected', true);
                        },
                        error: function(err) {
                            console.log(err);
                            Swal({
                                title: 'Error ' + err.status,
                                text: err.responseText,
                                showCancelButton: false,
                                showConfirmButton: true,
                                confirmButtonText: 'OK',
                                type: 'error'
                            });
                        }
                    });
                },
                error: function(err) {
                    console.log(err);
                    Swal({
                        title: 'Error ' + err.status,
                        text: err.responseText,
                        showCancelButton: false,
                        showConfirmButton: true,
                        confirmButtonText: 'OK',
                        type: 'error'
                    });
                }
            });
        }


        // Change
        $("#province").change(function() {
            let provinceid_change = $(this).val();
            if ($.trim(provinceid_change) != '') {
                $.ajax({
                    url: '',
                    type: 'POST',
                    data: {provinceid: provinceid_change},
                    dataType: 'JSON',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(district_data) {
                        let district_html = "";
                        $.each(district_data, function(index, value) {
                            district_html += "<option value='"+value.districtid+"'>"+value.type+" "+value.name+"</option>";
                        });
                        $("#district").html(district_html);
                        let ds = $("#district option").first().val();
                        $.ajax({
                            url: '',
                            type: 'POST',
                            data: {districtid: ds},
                            dataType: 'JSON',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(ward_data) {
                                let ward_html = "";
                                $.each(ward_data, function(index, value) {
                                    ward_html += "<option value='"+value.wardid+"'>"+value.type+" "+value.name+"</option>";
                                });
                                $("#ward").html(ward_html);
                            },
                            error: function(err) {
                                console.log(err);
                                Swal({
                                    title: 'Error ' + err.status,
                                    text: err.responseText,
                                    showCancelButton: false,
                                    showConfirmButton: true,
                                    confirmButtonText: 'OK',
                                    type: 'error'
                                });
                            }
                        });
                    },
                    error: function(err) {
                        console.log(err);
                        Swal({
                            title: 'Error ' + err.status,
                            text: err.responseText,
                            showCancelButton: false,
                            showConfirmButton: true,
                            confirmButtonText: 'OK',
                            type: 'error'
                        });
                    }
                });
            }
        });

        $("#district").change(function() {
            let ds = $(this).val();
            $.ajax({
                url: '',
                type: 'POST',
                data: {districtid: ds},
                dataType: 'JSON',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(ward_data) {
                    let ward_html = "";
                    $.each(ward_data, function(index, value) {
                        ward_html += "<option value='"+value.wardid+"'>"+value.type+" "+value.name+"</option>";
                    });
                    $("#ward").html(ward_html);
                },
                error: function(err) {
                    console.log(err);
                    Swal({
                        title: 'Error ' + err.status,
                        text: err.responseText,
                        showCancelButton: false,
                        showConfirmButton: true,
                        confirmButtonText: 'OK',
                        type: 'error'
                    });
                }
            });
        }); -->