@extends('layouts.admin.admin_layout')
@section('content')
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
						<div class="card-header">
							<h5 class="m-0">Trạng thái đơn hàng</h5>
						</div>
						<div class="card-body">
							<table class="table table-bordered ">
								<tr>
									<th scope="col">Ngày tạo</th>
									<th scope="col">{{ date('d/m/Y h:i:s',strtotime($orderDetail->created_at)) }}</th>
								</tr>
								<tr>
									<th scope="col">Trạng thái</th>
									<th scope="col">
										@if($orderDetail->order_status == 1) New @endif</th>
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
					</div>
					<!-- /.col-md-6 -->
				</div>
				<!-- /.row -->
			</div>
			<div class="row">
				<div class="col-lg-6">
					<div class="card">
						<div class="card-header">
							<h5 class="m-0">Địa chỉ hóa đơn</h5>
						</div>
						<div class="card-body">
							<form>
								<div class="form-group">
									<label for="exampleInputEmail1">Tên:</label>
									<input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
								</div>
								<div class="form-group">
									<label for="exampleInputPassword1">Địa chỉ</label>
									<textarea class="form-control" name="address" id="address" cols="30" rows="3"></textarea>
								</div>
								<div class="form-group">
									<label for="exampleInputPassword1">Ghi chú</label>
									<textarea class="form-control" name="note" id="note" cols="30" rows="3"></textarea>
								</div>
								<button type="submit" class="btn btn-primary">Thay đổi</button>
							</form>
						</div>
					</div>
				</div>
				<!-- /.col-md-6 -->
				<div class="col-lg-6">
					<div class="card">
						<div class="card-header">
							<h5 class="m-0">Địa chỉ chuyển hàng</h5>
						</div>
						<div class="card-body">
							<form>
								<div class="form-group">
									<label for="exampleInputEmail1">Tên:</label>
									<input type="text" class="form-control" name ="name_order" id="name_order" aria-describedby="emailHelp">
								</div>
								<div class="form-group">
									<label for="exampleInputPassword1">Địa chỉ</label>
									<textarea class="form-control" name="address_order" id="address_order" cols="30" rows="3"></textarea>
								</div>
								<div class="form-group">
									<label for="exampleInputPassword1">Ghi chú</label>
									<textarea class="form-control" name="note_order" id="note_order" cols="30" rows="3"></textarea>
								</div>
								<button type="submit" class="btn btn-primary">Thay đổi</button>
							</form>
						</div>
					</div>
				</div>
				<!-- /.col-md-6 -->
			</div>
			<!-- /.row -->
		</div>
	</div>
</div>
@endsection