@extends('layouts.home.home_layout')
@section('content')
<div class="cart_area section_padding_100 clearfix">
	<div class="container">
		<div class="row">
			<div class="col-md-12 wow fadeInDown" data-wow-delay=".25s">
				<h5 align="center">ĐƠN HÀNG CỦA BẠN ĐANG ĐƯỢC XỬ LÝ</h5>
			</div>
			<div class="wow rollIn" data-wow-delay=".28s" style="margin:0 auto;"><div class="loader"></div></div>

			<div class="col-md-12 wow rollIn" data-wow-delay=".28s" style="margin:0 auto;">
				<h6 align="center">Hãy kiểm tra mail của bạn để biết thêm chi tiết.</h6>
				<h6 align="center">Cảm ơn bạn đã mua hàng tại siêu thị của chúng tôi.</h6>
			</div>

		</div>
	</div>
</div>
<style>
	.loader {
		width: 120px;
		height: 120px;
		animation: spin 2s linear infinite;
		background: url('{{ asset('img/loader.gif') }}') no-repeat center;
		margin: 0 auto;
	}

	@keyframes spin {
		0% { transform: rotate(0deg); }
		100% { transform: rotate(360deg); }
	}
</style>
@endsection