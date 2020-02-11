@extends('layouts.home.home_layout')
@section('content')
<div class="cart_area section_padding_100 clearfix">
	<div class="container">
		<div class="row">
			<div class="col-12">
				@if(Session::has('mess_success'))
				<div class="alert alert-success alert-block">
					<button type="button" class="close" data-dismiss="alert">×</button>
					<strong>{!! session('mess_success') !!}</strong>
				</div>
				@endif
				@if(Session::has('mess_error'))
				<div class="alert alert-danger alert-block">
					<button type="button" class="close" data-dismiss="alert">×</button>
					<strong>{!! session('mess_error') !!}</strong>
				</div>
				@endif
				<div class="cart-table clearfix">
					<table class="table table-bordered cart">
						<thead>
							<tr>
								<th>Ảnh</th>
								<th>Sản phẩm</th>
								<th>Giá</th>
								<th>Số lượng</th>
								<th>Tổng tiền</th>
							</tr>
						</thead>
						<tbody>
							@if($countCart > 0)
							@php $total_amount = 0; @endphp
							@foreach($cart as $cart)
							<tr id="tr-item-{{ $cart->id }}" class="tr-item">
								<td>
									<a href="#"><img src="{{ asset('uploads/images/products/'.$cart->image) }}" alt="Product" style="width: 150px;"></a>
								</td>
								<td><h6>{{ $cart->product_name }}</h6>
									<h6>Size: {{ $cart->sizecart->size }}</h6></td>
									<td class="price"><input type="hidden" class="pricecart" name="pricecart" value="{{ $cart->price }}"><span>{{ number_format($cart->price) }}</span></td>
									<td class="qty">
										<div class="quantity">
											@if($cart->quantity > 1)
											<a href="{{ url('account/cart/update-cart/'.$cart->id.'/-1') }}"><span class="qty-minus"><i class="fa fa-minus" aria-hidden="true"></i></span></a>
											@endif
											<input type="number" class="qty-text" id="qty" step="1" min="1" max="10" name="quantity" value="{{ $cart->quantity }}">
											<a href="{{ url('account/cart/update-cart/'.$cart->id.'/1') }}"><span class="qty-plus"><i class="fa fa-plus" aria-hidden="true"></i></span></a>
										</div>
									</td>
									<td class="total_price">
										<input class="totalprice" name="total_price" value="{{ number_format($cart->quantity*$cart->price ) }}" autocomplete="off" readonly="">
										<span><a class="delcart" data-id="{{ $cart->id }}"><i class="fa fa-trash" style="font-size: 20px;margin-left: 20px;color:red;"></i></a></span></td>
									</tr>
<?php $total_amount = $total_amount+($cart->quantity*$cart->price);?>
									@endforeach
									@endif

								</tbody>

							</table>
						</div>
						<div class="cart-footer d-flex mt-30">
							<div class="back-to-shop w-50">
								<a href="{{ url('/') }}">Tiếp tục mua hàng</a>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12 col-md-6 col-lg-4">
							@if($countCart > 0)
						<div class="coupon-code-area mt-70">
							<div class="cart-page-heading frmcouponhead">
								<h5>Mã giảm giá</h5>
								<p>Hãy điền vào mã giảm giá:</p>
							</div>
							<form action="{{ url('account/coupon-cart') }}" method="POST" id="frmcoupon" onsubmit="return false;">
								@csrf
								<input type="search" name="coupon_code" id="coupon_code" placeholder="#569ab15" data-rule-required="true" data-msg-required="Vui lòng nhập mã giảm giá.">
								<button type="submit" id="apply_coupon">Gửi</button>
							</form>
						</div>
						@endif
					</div>
					<div class="col-12 col-md-6 col-lg-4">
					</div>
					<div class="col-12 col-lg-4">
						@if($countCart > 0)
						<div class="cart-total-area mt-70">
							<div class="cart-page-heading">
								<h5>Giỏ hàng</h5>
								<p></p>
							</div>

							<ul class="cart-total-chart">
								@if(!empty(Session::get('CouponAmount')))
								<li><span>Tổng tiền:</span> <span id="sub">@php echo number_format($total_amount); @endphp VNĐ</span></li>
								<li><span>Giảm giá:</span> <span>
									@php
									echo number_format(Session::get('CouponAmount'));
								@endphp VNĐ</span></li>
								<li><span>Tổng cộng:</span> <span id="sub">
									@php
									echo number_format($total_amount - Session::get('CouponAmount'));
								@endphp VNĐ</span></li>
								@else
								<li><span>Tổng cộng:</span> <span id="sub">@php echo number_format($total_amount); @endphp VNĐ</span></li>
								@endif
							</ul>

							<a href="{{ url('/account/check-out') }}" class="btn karl-checkout-btn">Thanh Toán</a>
						</div>
						@endif
					</div>
				</div>
			</div>
		</div>
		<script>

			$(document).ready(function() {


				$(".qty-plus").click(function(){
					var price = $(this).parents(".qty").siblings().find("[name=pricecart]").val();
					//alert(price);
					var inpt = $(this).parents(".qty").find("[name=quantity]");
					var val = parseInt(inpt.val());
					if ( val < 0 ) inpt.val(val=0);
					inpt.val(val+1);
					var valinpt =inpt.val();
					var toalsum = formatNumber(price*valinpt, '.', ',');
					$(this).parents(".qty").siblings().find("[name=total_price]").val(toalsum);
					//$('.total_price').val(toalsum);
					var total = 0;
					$('.totalprice').each(function(index) {
						if($(this).val() != '')
						{
							total += parseInt($(this).val());
						}
						$('#sub').html(total);
					});
				});
				$(".qty-minus").click(function(){
					var price = $(this).parents(".qty").siblings().find("[name=pricecart]").val();
					var inpt = $(this).parents(".quantity").find("[name=quantity]");
					var val = parseInt(inpt.val());
					if ( val == 1 ) return;
					inpt.val(val-1);
					var valinpt =inpt.val();
					//alert(price);

					var toalsum = formatNumber(price*valinpt, '.', ',');
					$(this).parents(".qty").siblings().find("[name=total_price]").val(toalsum);
				});
				$('.delcart').click(function() {
					var id = $(this).data('id');
					$.ajax({
						url:  "{{ url('/account/delete-cart') }}",
						type: "POST",
						dataType: "JSON",
						data: {id: id},
						headers: {
							'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
						},
						success: function(data){
							if (data.status=='_success') {
								$("html, body").animate({ scrollTop: 0 }, 600);
								$.notify('Bạn đã xóa thành công','success');
								$("#tr-item-" + id).remove();
								if ($(".cart .tr-item").length == 0) {
									location.reload();
								}
							}
							else{
								$.notify('Có lỗi xảy ra','error');
							}

						},
						error: function(err){
							console.log(err);
						}
					});
				});
				$("#apply_coupon").click(function() {
					$("#frmcoupon").validate({
						submitHandler: function() {
							let action = $("#frmcoupon").attr('action');
							let method = $("#frmcoupon").attr('method');
							let coupon_code = $("#coupon_code").val();
							$.ajax({
								url: action,
								type: method,
								data: {coupon_code: coupon_code},
								headers: {
									'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
								},
								dataType: 'JSON',
								success: function(data) {
									console.log(data);
									if(data.status=="_success"){
										$("#frmcoupon")[0].reset();
										$('.frmcouponhead').notify(data.msg,"success");
										setTimeout(function(){ location.reload(); }, 2000);


									}
									else{
										$("#frmcoupon")[0].reset();
										$('.frmcouponhead').notify(data.msg,"error");
									}
								},
								error: function(err) {
									console.log(err);
								}
							});
						}
					})
				});
			});

			function formatNumber(nStr, decSeperate, groupSeperate) {
				nStr += '';
				x = nStr.split(decSeperate);
				x1 = x[0];
				x2 = x.length > 1 ? '.' + x[1] : '';
				var rgx = /(\d+)(\d{3})/;
				while (rgx.test(x1)) {
					x1 = x1.replace(rgx, '$1' + groupSeperate + '$2');
				}
				return x1 + x2;
			}
		</script>
		@endsection