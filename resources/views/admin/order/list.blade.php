@extends('layouts.admin.admin_layout')
@section('content')
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-left">
						<li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
						<li class="breadcrumb-item active">Đơn hàng</li>
						<li class="breadcrumb-item active"></li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>
	<!-- /.content-header -->
	<!-- Main content -->
	<section class="content">
		<div class="container-fluid">
			<div class="col-12">
				<div class="card">
					<div class="card-header">
						<h3 class="card-title">
							Danh sách đơn đặt hàng
						</h3>
					</div>
					<!-- /.card-header -->
					<div class="card-body">
						<table id="product-table" class="table table-bordered table-hover coupon">
							<thead>
								<tr>
									<th>STT</th>
									<th>Thời gian</th>
									<th>Khách hàng</th>
									<th>Sản phẩm</th>
									<th>Email</th>
									<th>Giá</th>
									<th>Trạng thái</th>
									<th>Hành động</th>
								</tr>
							</thead>
							<tbody>
								@foreach($orders as $orders)
								<tr>
									<td>{{ $orders->id }}</td>
									<td>{{ $orders->created_at }}</td>
									<td>{{ $orders->name }}</td>
									<td>
										@foreach($orders->orders as $value)
										{{ $value->product_name }} -
										@php
										$size = DB::table('product_size')->where('id',$value->size)->value('size');
										@endphp
										Size: {{ $size }}-({{ $value->quantity }})<br>
										@endforeach
									</td>
									<td>{{ $orders->email }}</td>
									<td>{{ number_format($orders->total_price) }}</td>
									<td>@if($orders->order_status == 1)
										<span class="badge badge-success" style="margin-left: 10px">Mới</span>
										@elseif($orders->order_status == 2)
										<span class="badge badge-primary" style="margin-left: 10px">Đang xử lý</span>
										@elseif($orders->order_status == 3)
										<span class="badge badge-warning" style="margin-left: 10px">Đang chuyển</span>
										@elseif($orders->order_status == 4)
										<span class="badge badge-info" style="margin-left: 10px">Đã chuyển</span>
										@elseif($orders->order_status == 5)
										<span class="badge badge-danger" style="margin-left: 10px">Đã hủy</span>
									@endif</td>
									<td><a href="{{ url('admin/order/view-orderdetail/'.$orders->id) }}">Chi tiết</a></td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</thead>
				</div>
			</div>
		</div>
	</div>
</section>
</div>
@endsection