@extends('layouts.home.home_layout')
@section('content')
<div class="breadcumb_area padding_100">
	<div class="container">
		<div class="row">
			<div class="col-12 col-md-8">
				<ol class="breadcrumb d-flex align-items-center">
					<li class="breadcrumb-item"><a href="{{ url('/') }}">Trang chủ</a></li>
					<li class="breadcrumb-item active">Đăng kí- Đăng nhập</li>
				</ol>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				@if(Session::has('mess_error'))
				<div class="alert alert-danger alert-block">
					<button type="button" class="close" data-dismiss="alert">×</button>
					<strong>{!! session('mess_error') !!}</strong>
				</div>
				@endif
			</div>
		</div>
	</div>
</div>

<section class="single_product_details_area section_padding_0_100">
	<div class="container">
		<div class="row">
			<div class="col-md-5  wow fadeInLeft" data-wow-delay=".25s" style="border: 1px solid beige;">
				<div class="field-note field-note-login">Nếu bạn đã có tài khoản hãy đăng nhập cùng với email của bạn.</div>
				<form action="{{ url('/login') }}" method="POST" class="frm-login" id="frm-login">
					@csrf
					<div class="form-group">
						<label for="exampleInputEmail1">Email</label>
						<input type="email" class="form-control" id="email" name="email_login" data-rule-required="true" data-msg-required="Vui lòng nhập email.">
					</div>
					<div class="form-group">
						<label for="exampleInputPassword1">Mật khẩu</label>
						<input type="password" class="form-control" name="password_login" id="password" data-rule-required="true" data-msg-required="Vui lòng nhập mật khẩu.">
					</div>
					<button type="submit" class="btn btn-primary btn-login">Đăng nhập</button>
				</form>
			</div>
			<div class="col-md-1  wow fadeInLeft" data-wow-delay=".25s">
			</div>
			<div class="col-md-6  wow fadeInLeft" data-wow-delay=".25s" style="border: 1px solid beige;">
				<div class="field-note field-note-re">Nếu bạn chưa có tài khoản hãy đăng kí cùng với email của bạn.</div>
				<form action="{{ url('/register') }}" method="POST" id="frm-register">
					@csrf
					<div class="form-group">
						<label for="exampleInputEmail1">Tên</label>
						<input type="text" class="form-control" id="name" name="name" data-rule-required="true" data-msg-required="Vui lòng nhập tên.">
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1">Email</label>
						<input type="email" class="form-control email-re" id="email" name="email" data-rule-required="true" data-msg-required="Vui lòng nhập email.">
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1">Số điện thoại</label>
						<input type="number" class="form-control email-re" id="phone" name="phone" data-rule-required="true" data-msg-required="Vui lòng nhập số điện thoại.">
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1">Địa chỉ</label>
						<textarea  class="form-control" id="address" name="address" data-rule-required="true" data-msg-required="Vui lòng nhập địa chỉ."></textarea>
					</div>
					<div class="form-group">
						<label for="exampleInputPassword1">Mật khẩu</label>
						<input type="password" class="form-control" id="password" name="password" data-rule-required="true" data-msg-required="Vui lòng nhập mật khẩu.">
					</div>
					<button type="submit" class="btn btn-primary btn-register">Đăng Kí</button>
				</form>
			</div>
		</div>
	</div>
</section>
<style>
	#frm-login{
		margin: 0px 0px 20px 0px;
	}
	#frm-register{
		margin: 20px 0px 20px 0px;
	}
	#frm-register .error {
		font-size: 12px;
		color: red;
	}
	.frm-login label{
		font-size: 14px;
	}
	.frm-login .error{
		font-size: 12px;
		color: red;
	}
	.field-note{
		margin: 20px 0px 20px;
		font-size: 14px;
	}
</style>
<script>
	$(document).ready(function() {
		$('.btn-login').click(function() {
			$("#frm-login").validate({
				submitHandler: function() {
					let action = $("#frm-login").attr('action');
					let method = $("#frm-login").attr('method');
					let form = $("#frm-login").serialize();
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
								$('.field-note-login').notify(data.msg,'success');
								$("#frm-login")[0].reset();
								setTimeout(function(){ window.location.href="{{ url('/') }}"; }, 1000);
							}
							else{
								$('.field-note-login').notify(data.msg,'error');
								$("#frm-login")[0].reset();
							}

						},
						error: function(err) {
							console.log(err);
						}
					});
				}
			})
		});
		$('.btn-register').click(function() {
			$("#frm-register").validate({
				submitHandler: function() {
					let action = $("#frm-register").attr('action');
					let method = $("#frm-register").attr('method');
					let form = $("#frm-register").serialize();
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
								$('.field-note-re').notify(data.msg,'success');
								$("#frm-register")[0].reset();
							}
							else{
								$('.email-re').notify(data.msg,'error');
								$(".email-re").val('');
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