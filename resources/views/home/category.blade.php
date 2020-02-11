@extends('layouts.home.home_layout')
@section('content')
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
<section class="shop_grid_area" style="padding: 30px 0px">
	<div class="container">
		<div class="row">
			<div class="col-12 col-md-4 col-lg-3">
				<div class="shop_sidebar_area wow fadeInLeft" data-wow-delay=".25s">
					<div class="widget catagory mb-50">
						<div class="nav-side-menu">
							<h6 class="mb-0">Danh mục các sản phẩm</h6>
							<div class="menu-list">
								<ul id="menu-content2" class="menu-content collapse out">
									@foreach ($menu_data as $item)
									<li data-toggle="collapse" data-target="{{ count($item['child']) > 0 ? '#'.$item['id'].'' :''}}" class="collapsed active">
										<a href="#">{{ $item['name'] }} <span class="arrow"></span></a>
										@if ( count($item['child']) > 0 )
										<ul class="sub-menu collapse" id="{{ $item['id'] }}">
											@foreach ($item['child'] as $item1)
											<li><a href="{{ url('danh-muc-san-pham/'.$item1['url']) }}">{{ $item1['name'] }}</a></li>
											@endforeach
										</ul>
										@endif
									</li>
									@endforeach
								</ul>
							</div>
						</div>
					</div>
					<div class="widget price mb-50">
						<h6 class="widget-title mb-30">Lọc theo giá</h6>
						<div class="widget-desc">
							<div id="slider-range"></div>
							<div class="range-price" id="amount"></div>
							<input type="hidden" id="amount1" name="amount1" value="">
							<input type="hidden" id="amount2" name="amount2" value="">
						</div>
					</div>
{{-- 					<div class="widget color mb-70">
						<h6 class="widget-title mb-30">Lọc theo size</h6>
						<div class="widget-desc">
							<ul class="d-flex justify-content-between">
								@foreach($color_data as $color_data)
								<li>
									<a class="common_selector filtercolor" data-id="{{ $color_data->id }}" href="#" style="background-color: {{ $color_data->class }} !important;">
									</a>

								</li>
								@endforeach
							</ul>
						</div>
					</div> --}}
				{{-- 	<div class="widget size mb-50">
						<h6 class="widget-title mb-30">Lọc theo Size</h6>
						<div class="widget-desc">
							<ul class="d-flex justify-content-between">
								@foreach($size_data as $size_data)
								<li><a href="#">{{ $size_data->size }}</a></li>
								@endforeach
							</ul>
						</div>
					</div> --}}
					<div class="widget recommended">
						<h6 class="widget-title mb-30">Đề xuất</h6>
						<div class="widget-desc">
							@foreach($product_random as $product_random)
							<div class="single-recommended-product d-flex mb-30">
								<div class="single-recommended-thumb mr-3">
									<img src="{{ asset('uploads/images/products/'.$product_random->image) }}" alt="">
								</div>
								<div class="single-recommended-desc">
									<a href="{{ url('/'.$product_random->url) }}"><h6>{{ $product_random->name }}</h6></a>
									<p>{{ number_format($product_random->price) }}</p>
								</div>
							</div>
							@endforeach
						</div>
					</div>
				</div>
			</div>
			<div class="col-12 col-md-8 col-lg-9">
				<div class="shop_grid_product_area">
					<div class="row filter_data">


					</div>
				</div>
			{{-- 	<div class="shop_pagination_area wow fadeInUp" data-wow-delay="1.1s" style="visibility: visible; animation-delay: 1.1s; animation-name: fadeInUp;">
					<nav aria-label="Page navigation">
						<ul class="pagination pagination-sm">
							<li class="page-item active"><a class="page-link" href="#">01</a></li>
							<li class="page-item"><a class="page-link" href="#">02</a></li>
							<li class="page-item"><a class="page-link" href="#">03</a></li>
						</ul>
					</nav>
				</div> --}}
			</div>
		</div>
	</div>
</section>

<script>
	$(document).ready(function(){
		filter_data();
		function filter_data()
		{
			$('.filter_data').html('<div class="loader"></div>');
			var minimum_price = $('#amount1').val();
			var maximum_price = $('#amount2').val();

			$.ajax({
				url:"{{ url('filter-data/'.$slug) }}",
				type:"POST",
				cache: false,
				data:{minimum_price:minimum_price, maximum_price:maximum_price},
				headers: {
					'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
				},
				success:function(data){
					//console.log(data);
					$('.filter_data').html(data);
				}
			});
		}
		$( "#slider-range" ).slider({
			range: true,
			min: 10000,
			max: 300000,
			values: [ 10000,300000 ],
			stop: function( event, ui ) {
				$( "#amount" ).html( "" + ui.values[ 0 ] + " - " + ui.values[ 1 ] );
				$( "#amount1" ).val(ui.values[ 0 ]);
				$( "#amount2" ).val(ui.values[ 1 ]);
				filter_data();
			}
		});
		$( "#amount" ).html( "" + $( "#slider-range" ).slider( "values", 0 ) +
			" - " + $( "#slider-range" ).slider( "values", 1 ) );

	});
</script>

@endsection