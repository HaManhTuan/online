@extends('layouts.home.home_layout')
@section('content')
<div class="breadcumb_area padding_100">
	<div class="container">
		<div class="row">
			<div class="col-12 col-md-8">
				<ol class="breadcrumb d-flex align-items-center">
					<li class="breadcrumb-item"><a href="{{ url('/') }}">Trang chủ</a></li>
					<li class="breadcrumb-item active">Lịch sử mua hàng</li>
				</ol>
			</div>
		</div>
	</div>
</div><section class="single_product_details_area section_padding_0_100">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<h4 class="card-title text-center">
							Lịch sử mua hàng
						</h4>
					</div>
					<div class="card-body">
						<table class="table table-bordered orderview">
							<thead>
								<tr>
									<th>ID</th>
									<th>Sản phẩm</th>
									<th>Hình thức thanh toán</th>
									<th>Tổng tiền</th>
									<th>Ngày tạo</th>
									<th>Hành động</th>
								</tr>
							</thead>
							<tbody>
								@foreach($order as $order)
								<tr>
									<td>{{ $order->id }}</td>
									<td>
										@foreach($order->orders as $pro)
										{{ $pro->product_name }}-
										@php
										$size = DB::table('product_size')->where('id',$pro->size)->value('size');
										@endphp
										Size: {{ $size }}
										@endforeach
									</td>
									<td>COD</td>
									<td>{{ number_format($order->total_price) }}</td>
									<td>{{ $order->created_at }}</td>
									<td><button type="button" class="btn btn-warning btn-orderdetail" data-id="{{ $order->id }}" data-toggle="modal" data-target="#OrderDetail"><i class="ti-view-list"  ></i> Chi tiết</button></td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<style>
	.orderview a:hover{
		color: red;
	}
</style>
<div id="OrderDetail" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg bounceInRight animated" style="max-width: 1000px;">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Chi tiết đơn hàng
				</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			</div>
			<div class="modal-body"></div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Thoát</button>
			</div>
		</div>
	</div>
</div>
<script>
	$(".btn-orderdetail").click(function() {
		let id = $(this).attr('data-id');
		$.ajax({
			url: '{{url("account/history-orderdetail")}}',
			type: 'POST',
			data: {id: id},
			dataType: 'JSON',
			headers: {
				'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
			},
			success:function(data) {
				//console.log(data);
				 $("#OrderDetail .modal-body").html(data.body);
				 $("#OrderDetail").modal('show');
			},
			error: function(err) {
				console.log(err);
			}
		});
		return false;
	});
</script>
@endsection