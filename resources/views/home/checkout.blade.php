@extends('layouts.home.home_layout')
@section('content')
<div class="cart_area section_padding_100 clearfix">
	<div class="container">
		<div class="row">
			<div class="col-8">
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

			</div>
		</div>
		<div class="row">
			<div class="col-12 col-md-4 col-lg-4">
				<div class="card">
					<div class="card-header">
						<h4 class="card-title text-center">
							Thông tin đơn đặt hàng
						</h4>
					</div>
					<div class="card-body">

						<form action="{{ url('account/place-order') }}" class="frm-order" method="POST" id="frm-order">
							@csrf
							<div class="form-group">
								<label for="exampleInputEmail1">Tên</label>
								<input type="hidden" name="customer_id" value="{{ Auth::guard('customers')->user()->id }}">
								<input type="text" class="form-control" id="name" name="name" aria-describedby="emailHelp" placeholder="Enter email" value="{{ Auth::guard('customers')->user()->name }}">
							</div>
							<div class="form-group">
								<label for="exampleInputEmail1">Email</label>
								<input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Enter email" readonly="" value="{{ Auth::guard('customers')->user()->email }}">
							</div>
							<div class="form-group">
								<label for="exampleInputEmail1">Số điện thoại</label>
								<input type="text" class="form-control" id="phone" name="phone" aria-describedby="emailHelp" placeholder="Enter email" value="{{ Auth::guard('customers')->user()->phone }}">
							</div>
							<div class="form-group">
								<label for="exampleInputPassword1">Địa chỉ</label>
								<textarea  class="form-control" name="address" id="address" cols="30" rows="3">{{ Auth::guard('customers')->user()->address }}</textarea>
							</div>
							<div class="form-group">
								<label for="exampleInputPassword1">Ghi chú</label>
								<textarea  class="form-control" name="note" id="note" cols="30" rows="3"></textarea>
							</div>


						</div>
					</div>
				</div>
				<div class="col-12 col-md-8 col-lg-8">
					<div class="cart-table clearfix">
						<table class="table table-bordered cart">
							<thead>
								<tr>
									<th>Sản phẩm</th>
									<th>Giá</th>
									<th>Số lượng</th>
									<th>Tổng tiền</th>
								</tr>
							</thead>
							<tbody>
								@php $total_amount = 0; @endphp
								@foreach($cart as $cart)
								<tr id="tr-item-{{ $cart->id }}" class="tr-item">
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
											<input class="totalprice" name="total_price" value="{{ number_format($cart->quantity*$cart->price ) }}" autocomplete="off" readonly="" style="width:90px;">
										</td>
									</tr>
<?php $total_amount = $total_amount+($cart->quantity*$cart->price);?>
									@endforeach
								</tbody>
							</table>
						</div>
						<div class="row">
							<div class="col-12 col-md-4 col-lg-4">
								<div class="shipping-method-area mt-70">
					{{-- 			<div class="cart-page-heading">
									<h5>Thanh toán</h5>
									<!-- <p>Select the one you want</p> -->
								</div>
								<div class="custom-control mb-30">
									<input type="checkbox"  name="method" class="">
									<span>Trả tiền mặt</span>
								</div> --}}
{{-- 								<div class="custom-control custom-radio mb-30">
									<input type="radio" id="customRadio2" name="customRadio" class="custom-control-input">
									<label class="custom-control-label d-flex align-items-center justify-content-between" for="customRadio2"><span>Standard delivery</span><span>$1.99</span></label>
								</div>
								<div class="custom-control custom-radio">
									<input type="radio" id="customRadio3" name="customRadio" class="custom-control-input">
									<label class="custom-control-label d-flex align-items-center justify-content-between" for="customRadio3"><span>Personal Pickup</span><span>Free</span></label>
								</div> --}}
							</div>
						</div>
						<div class="col-12 col-md-12 col-lg-12">
							<div class="cart-total-area mt-70">
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
									<input type="hidden" name="total_price" value="{{ $total_amount - Session::get('CouponAmount') }}">
									@else
									<li><span>Tổng cộng:</span> <span id="sub">@php echo number_format($total_amount); @endphp VNĐ</span></li>
									<input type="hidden" name="total_price" value="{{ $total_amount }}">
									@endif
								</ul>
								<button type="submit" class="btn karl-checkout-btn btn-thank">Thanh Toán</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<style>
	#frm-order .error{
		color: red;
		font-size: 12px;
	}
</style>
<script>
	$(document).ready(function() {
		$('.btn-thank').click(function() {
			$("#frm-order").validate({
				submitHandler: function() {
					let action = $("#frm-order").attr('action');
					let method = $("#frm-order").attr('method');
					let form = $("#frm-order").serialize();
					$.ajax({
						url: action,
						type: method,
						data: form,
						headers: {
							'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
						},
						dataType: 'JSON',
						success: function(data) {
							console.log(data);
							if (data.status == '_success') {
								$('.btn-thank').notify(data.msg,'success');
								setTimeout(function(){ window.location.href="{{ url('account/thank') }}"; }, 2000);
}
								else{

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
</script>
@endsection