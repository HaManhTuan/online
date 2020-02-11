@extends('layouts.home.home_layout')
@section('content')
<link rel="stylesheet" href="{{ asset('css/animate.css') }}">
<div class="cart_area section_padding_100 clearfix">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<h4 class="card-title text-center">
							Thông tin tài khoản của bạn
						</h4>
					</div>
					<div class="card-body">
						@if(Auth::guard('customers')->check())
						<form action="{{ url('account/edit-account') }}" class="frm-account" method="POST" id="frm-account">
							@csrf

							<div class="form-group">
								<label for="exampleInputEmail1">Tên</label>
								<input type="text" class="form-control" id="name" name="name" aria-describedby="emailHelp" placeholder="Enter email" value="{{ Auth::guard('customers')->user()->name }}">
							</div>
							<div class="form-group">
								<label for="exampleInputEmail1">Email</label>
								<input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Enter email" readonly="" value="{{ Auth::guard('customers')->user()->email }}">
							</div>
							<div class="form-group">
								<label for="exampleInputEmail1">Số điện thoại</label>
								<input type="number" class="form-control" id="phone" name="phone" aria-describedby="emailHelp" placeholder="Enter email" value="{{ Auth::guard('customers')->user()->phone }}">
							</div>
							<div class="form-group">
								<label for="exampleInputPassword1">Địa chỉ</label>
								<textarea  class="form-control" name="address" id="address" cols="30" rows="5">{{ Auth::guard('customers')->user()->address }}</textarea>
							</div>
							<button type="submit" class="btn btn-success btn-edit">Thay đổi</button>
							<button type="button" class="btn btn-danger " data-toggle="modal" data-target="#Resetpass">Đổi mật khẩu</button>
						</form>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="Resetpass" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg bounceInDown animated" style="max-width: 400px;">
		<div class="modal-content">
			<form action="{{ url('account/edit-password') }}" class="frm-password" method="POST" id="change-password-form" onsubmit="return false;">
				@csrf
				<div class="modal-header">
					<h4 class="modal-title">Đổi mật khẩu
					</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				</div>
				<input type="hidden" name="id" value="{{ Auth::guard('customers')->user()->id }}">
				<div class="modal-body">
					<div class="form-group">
						<label for="new-pwd">Mật khẩu mới</label>
						<input type="password" id="new-pwd" name="newPwd" class="form-control" placeholder="Nhập mật khẩu mới" data-rule-required="true" data-msg-required="Vui lòng nhập mật khẩu mới" />
					</div>
					<div class="form-group">
						<label for="retype-new-pwd">Nhập lại mật khẩu</label>
						<input type="password" id="retype-new-pwd" name="retypeNewPwd" class="form-control" placeholder="Nhập lại mật khẩu" data-rule-required="true" data-msg-required="Vui lòng nhập lại mật khẩu" data-rule-equalto="#new-pwd" data-msg-equalto="Mật khẩu không khớp" />
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Hủy bỏ</button>
					<button type="submit" class="btn btn-danger waves-effect waves-light btn-edit-save" id="btn-save-new-pwd"><small class="ti-save mr-2"></small>Lưu thay đổi</button>
				</div>
			</form>
		</div>
	</div>
</div>
<style>
	.frm-account{
		margin: 0 auto;
		width: 50%;
	}
	.modal.fade{
		opacity:1;
	}
	.modal.fade .modal-dialog {
		-webkit-transform: translate(0);
		-moz-transform: translate(0);
		transform: translate(0);
	}
	#change-password-form .error {
		font-size: 12px;
		color: red;
	}
</style>
<script>

	$('#Resetpass').on('show.bs.modal', function (e) {
		$('.modal .modal-dialog').attr('class', 'modal-dialog bounceInDown  animated');
	})
	$('#Resetpass').on('hide.bs.modal', function (e) {
		$('.modal .modal-dialog').attr('class', 'modal-dialog swing animated');
	})
	$(document).ready(function() {
		$(".btn-edit").click(function() {
			$("#frm-account").validate({
				submitHandler: function() {
					let action = $("#frm-account").attr('action');
					let method = $("#frm-account").attr('method');
					let form = $("#frm-account").serialize();
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
								$("html, body").animate({ scrollTop: 0 }, 600);
								$.notify(data.msg,'success');
								$("#name").val(data.name);
								$("#address").val(data.address);
							}
							else{
								$('.card-title').notify(data.msg,'error');
								$("#frm-account")[0].reset();
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
	$(document).on("click","#btn-save-new-pwd",function() {
		$("#change-password-form").validate({
			submitHandler: function() {
				let action = $("#change-password-form").attr('action');
				let method = $("#change-password-form").attr('method');
				let form = $("#change-password-form").serialize();
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
							$("html, body").animate({ scrollTop: 0 }, 600);
							$.notify(data.msg,'success');
							$("#change-password-form")[0].reset();
							$("#Resetpass").modal('hide');
							setTimeout(function(){ window.location.reload(); }, 2000);
						}
						else{
							$('.card-title').notify(data.msg,'error');
							$("#frm-account")[0].reset();
						}
					},
					error: function(err) {
						console.log(err);
					}
				});
			}
		})


	});
</script>
@endsection