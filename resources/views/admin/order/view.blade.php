@extends('layouts.admin.admin_layout')
@section('content')
<link rel="stylesheet" href="{{ asset('admin/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">
<link rel="stylesheet" href="{{ asset('admin/plugins/toastr/toastr.min.css')}}">
<div class="content-wrapper" style="min-height: 255px;">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Chi tiết hóa đơn - {{ $id }}</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Chi tiết hóa đơn</li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>
	<!-- /.content-header -->

	<!-- Main content -->
	<div class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-6">
					<div class="card">
						<div class="card-header" style="display: flex;align-items: center;">
							<h5 class="m-0">Trạng thái đơn hàng</h5>
							@if($orderDetail->order_status == 1)
							<span class="badge badge-success" style="margin-left: 10px">Mới</span>
							@elseif($orderDetail->order_status == 2)
							<span class="badge badge-primary" style="margin-left: 10px">Đang xử lý</span>
							@elseif($orderDetail->order_status == 3)
							<span class="badge badge-warning" style="margin-left: 10px">Đang chuyển</span>
							@elseif($orderDetail->order_status == 4)
							<span class="badge badge-info" style="margin-left: 10px">Đã chuyển</span>
							@elseif($orderDetail->order_status == 5)
							<span class="badge badge-danger" style="margin-left: 10px">Đã hủy</span>
							@endif

						</div>
						<div class="card-body">
							<table class="table table-bordered ">
								<tr>
									<th scope="col">Ngày tạo</th>
									<th scope="col">{{ date('d/m/Y h:i:s',strtotime($orderDetail->created_at)) }}</th>
								</tr>
								<tr>
									<th scope="col">Tổng tiền</th>
									<th scope="col">{{ number_format($orderDetail->total_price) }}</th>
								</tr>
								<tr>
									<th scope="col">Mã giảm giá</th>
									<th scope="col">{{ ($orderDetail->coupon_code) }}</th>
								</tr>
								<tr>
									<th scope="col">Giảm giá:</th>
									<th scope="col">{{ number_format($orderDetail->coupon_amount) }}</th>
								</tr>
								<tr>
									<th scope="col">Hình thức thanh toán</th>
									<th scope="col">
										COD
									</th>
								</tr>
							</table>
						</div>
					</div>
				</div>
				<!-- /.col-md-6 -->
				<div class="col-lg-6">
					<div class="card">
						<div class="card-header">
							<h5 class="m-0">Khách hàng</h5>
						</div>
						<div class="card-body">
							<table class="table table-bordered ">
								<tr>
									<th scope="col">Họ tên:</th>
									<th scope="col">{{ $orderDetail->name }}</th>
								</tr>
								<tr>
									<th scope="col">Số điện thoại</th>
									<th scope="col">
										{{ $orderDetail->phone }}
									</th>
								</tr>
								<tr>
									<th scope="col">Email</th>
									<th scope="col">
										{{ $orderDetail->email }}
									</th>
								</tr>
							</table>
						</div>
					</div>
					<div class="card">
						<div class="card-header" style="display: flex;align-items: center;">
							<h5 class="m-0">Trạng thái đơn hàng</h5>
							<input type="hidden" name="order_id" id="order_id" value="{{ $orderDetail->id }}">
							<select name="order_status" id="order_status" class="form-control" style="width: 180px;margin-left: 50px;">
								<option value="1">Mới</option>
								<option value="2">Đang chờ xử lý</option>
								<option value="3">Đang chuyển</option>
								<option value="4">Đã chuyển</option>
								<option value="5">Đã hủy</option>
							</select>
						</div>
					</div>
				</div>
				<script>
					$('select#order_status option[value="' + {{ $orderDetail->order_status }} +'"]').prop("selected", true);
				</script>
				<!-- /.col-md-6 -->
			</div>
			<!-- /.row -->
		</div>
		<div class="row">
			<div class="col-lg-6">
				<div class="card">
					<div class="card-header" style="display: flex;">
						<h5 class="m-0">Địa chỉ hóa đơn</h5>
						<a href="" data-toggle="modal" data-target="#edituser" style="margin-left: 20px;">Sửa</a>
					</div>
					<div class="card-body">
						{{ $customerDetail->name }} <br>
						{{ $customerDetail->phone }} <br>
						{{ $customerDetail->email }} <br>
						{{ $customerDetail->address }} <br>
					</div>
				</div>
			</div>
			<!-- /.col-md-6 -->
			<div class="col-lg-6">
				<div class="card">
					<div class="card-header" style="display: flex;">
						<h5 class="m-0">Địa chỉ chuyển hàng</h5>
						<a href="" data-toggle="modal" data-target="#editorder" style="margin-left: 20px;">Sửa</a>
					</div>
					<div class="card-body">
						{{ $orderDetail->name }} <br>
						{{ $orderDetail->phone }} <br>
						{{ $orderDetail->email }} <br>
						{{ $orderDetail->address }} <br>

					</div>
				</div>
			</div>
			<!-- /.col-md-6 -->
		</div>
		<!-- /.row -->
		<div class="row">
			<div class="col-md-12">
				<table id="order-table" class="table table-bordered table-hover">
					<thead>
						<tr>
							<th>Tên sản phẩm</th>
							<th>Size</th>
							<th>Giá</th>
							<th>Số lượng</th>
							<th>Tổng tiền</th>
						</tr>
					</thead>
					<tbody>
						@php $total_amount = 0; @endphp
						@foreach($orderDetail->orders as $value)
						<tr>
							<td>{{ $value->product_name }}</td>
							@php
							$size = DB::table('product_size')->where('id',$value->size)->value('size');
							@endphp
							<td>{{ $size }}</td>
							<td>{{ number_format($value->price) }}</td>
							<td>{{ $value->quantity }}</td>
							<td>{{ number_format($value->price*$value->quantity) }}</td>
						</tr>
<?php $total_amount = $total_amount+($value->quantity*$value->price);?>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
		<div class="row" style="display: flex;">
			<div class="col-md-4">
				<div class="card">
					<div class="card-header">
						<h5 class="m-0">Chú ý</h5>
					</div>
					<div class="card-body">
						<div class="form-group">
							<textarea name="note" id="note"  rows="4" class="form-control">
								{{ $orderDetail->note }}
							</textarea>
						</div>
					</div>
				</div>

			</div>
			<div class="col-md-5">
				<div class="card">
					<div class="card-header">
						<h5 class="m-0">Comment</h5>
					</div>
					<div class="card-body">
						<form action="">
							<div class="form-group">
								<textarea class="form-control" name="comment" id="comment" rows="3"></textarea>
							</div>
							<button type="submit" class="btn btn-success">Comment</button>
						</form>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="card">
					<div class="card-header" style="display: flex;">
						<h5 class="m-0">Đơn giá</h5>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-md-6">Tổng tiền:</div>
							<div class="col-md-6">{{ number_format($total_amount) }}</div>
						</div>
						@if(isset($orderDetail->coupon_amount))
						<div class="row mt-3">
							<div class="col-md-6">Giảm giá:</div>
							<div class="col-md-6">{{ number_format($orderDetail->coupon_amount) }}</div>
						</div>
						<div class="row mt-3">
							<div class="col-md-6">Thành tiền:</div>
							<div class="col-md-6">{{ number_format($orderDetail->total_price) }}</div>
						</div>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<div id="edituser" class="modal fade" tabindex="-1" role="dialog"
aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog bounceInDown animated">
	<div class="modal-content">
		<form action="{{ url('admin/order/change-customer') }}" method="post" id="id-edit-cus" class="add-size" role="form" onsubmit="return false;" enctype='multipart/form-data'>
			@csrf
			<div class="modal-header">
				<h4 class="modal-title">Bill address  &quot;
					<span data-ajax="edit" data-field="html">{{ $orderDetail->id }}</span>&quot;
				</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			</div>
			<input type="hidden" class="form-control" name="id_cus" id="name" value="{{ $customerDetail->id }}">
			<div class="modal-body">
				<div class="form-group">
					<label for="category_name_input" class="control-label">Họ tên:<font color="#a94442">(*)</font></label>
					<input type="text" class="form-control" name="name" id="name" value="{{ $customerDetail->name }}"
					data-rule-required="true" data-msg-required="Vui lòng nhập tên.">
				</div>
				<div class="form-group">
					<label for="category_name_input" class="control-label">Số điện thoại:<font color="#a94442">(*)</font></label>
					<input type="text" class="form-control" name="phone" id="phone" value="{{ $customerDetail->phone }}"
					data-rule-required="true" data-msg-required="Vui lòng nhập số điện thoại.">
				</div>
				<div class="form-group">
					<label for="category_name_input" class="control-label">Địa chỉ:<font color="#a94442">(*)</font></label>
					<textarea name="address" class="form-control" id="address" cols="30" rows="4" data-rule-required="true" data-msg-required="Vui lòng nhập địa chỉ.">{{ $customerDetail->address }}</textarea>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Hủy bỏ</button>
				<button type="submit" class="btn btn-info waves-effect waves-light" id="btn-save-cus"><small class="ti-pencil-alt mr-2"></small>Sửa</button>
			</div>
		</form>
	</div>
</div>
</div>
<div id="editorder" class="modal fade" tabindex="-1" role="dialog"
aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog bounceInDown animated">
	<div class="modal-content">
		<form action="{{ url('admin/order/change-order') }}" method="post" id="id-edit-order" class="add-size" role="form" onsubmit="return false;" enctype='multipart/form-data'>
			@csrf
			<div class="modal-header">
				<h4 class="modal-title">Ship address  &quot;
					<span data-ajax="edit" data-field="html">{{ $orderDetail->id }}</span>&quot;
				</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			</div>
			<div class="modal-body">
				<div class="modal-body">
					<div class="form-group">
						<label for="category_name_input" class="control-label">Họ tên:<font color="#a94442">(*)</font></label>
						<input type="text" class="form-control" name="name_order" id="name" value="{{ $orderDetail->name }}"
						data-rule-required="true" data-msg-required="Vui lòng nhập tên.">
					</div>
					<input type="hidden" class="form-control" name="id_order" id="name" value="{{ $orderDetail->id }}">
					<div class="form-group">
						<label for="category_name_input" class="control-label">Số điện thoại:<font color="#a94442">(*)</font></label>
						<input type="text" class="form-control" name="phone_order" id="phone" value="{{ $orderDetail->phone }}"
						data-rule-required="true" data-msg-required="Vui lòng nhập số điện thoại.">
					</div>
					<div class="form-group">
						<label for="category_name_input" class="control-label">Địa chỉ:<font color="#a94442">(*)</font></label>
						<textarea name="address_order" class="form-control" id="address" cols="30" rows="4" data-rule-required="true" data-msg-required="Vui lòng nhập địa chỉ.">{{ $orderDetail->address }}</textarea>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Hủy bỏ</button>
				<button type="submit" class="btn btn-info waves-effect waves-light" id="btn-save-order"><small class="ti-pencil-alt mr-2"></small>Sửa</button>
			</div>
		</form>
	</div>
</div>
</div>
<script src="{{ asset('admin/js/jquery.nestable.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.29.2/sweetalert2.all.js"></script>
<!-- Toastr -->
<script src="{{ asset('admin/plugins/toastr/toastr.min.js')}}"></script>
<script src="{{ asset('admin/js/adminlte.js')}}"></script>
<script>
	$(document).ready(function() {
		const Toast = Swal.mixin({
			toast: true,
			position: 'top-end',
			showConfirmButton: false,
			timer: 2000
		});
		$('select#order_status').change(function() {
			var status = $(this).val();
			var order_id = $("#order_id").val();
			$.ajax({
				url: "{{ url('admin/order/change-status') }}",
				type: "POST",
				//dataType: "JSON",
				data: {status: status, order_id: order_id  },
				headers: {
					'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
				},
				success: function(data){
					console.log(data);
					// if(data.status == '_success') {
					// 	Toast.fire({
					// 		type: 'success',
					// 		title: data.msg
					// 	}).then(() => {
					// 		location.reload();
					// 	});
					// } else {
					// 	Toast.fire({
					// 		type: 'error',
					// 		title: data.msg
					// 	})
					// }
				},
				error: function(err){
					console.log(err);
				}
			});

		});

	});
	$(document).on("click","#btn-save-cus",function() {
		$("#id-edit-cus").validate({
			submitHandler: function() {
				let action = $("#id-edit-cus").attr('action');
				let method = $("#id-edit-cus").attr('method');
				let form = $("#id-edit-cus").serialize();
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
						if (data.status == '_error') {
							Swal({
								title: data.msg,
								showCancelButton: false,
								showConfirmButton: true,
								confirmButtonText: 'OK',
								type: 'error'
							});
						} else {
							Swal({
								title: data.msg,
								showCancelButton: false,
								showConfirmButton: false,
								confirmButtonText: 'OK',
								type: 'success',
								timer: 2000
							}).then(() => {
								$("#id-edit-cus")[0].reset();
								window.location.reload();
							});
						}
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
	});
	$(document).on("click","#btn-save-order",function() {
		$("#id-edit-order").validate({
			submitHandler: function() {
				let action = $("#id-edit-order").attr('action');
				let method = $("#id-edit-order").attr('method');
				let form = $("#id-edit-order").serialize();
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
						if (data.status == '_error') {
							Swal({
								title: data.msg,
								showCancelButton: false,
								showConfirmButton: true,
								confirmButtonText: 'OK',
								type: 'error'
							});
						} else {
							Swal({
								title: data.msg,
								showCancelButton: false,
								showConfirmButton: false,
								confirmButtonText: 'OK',
								type: 'success',
								timer: 2000
							}).then(() => {
								$("#id-edit-order")[0].reset();
								window.location.reload();
							});
						}
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
	});
</script>
@endsection