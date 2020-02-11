@extends('layouts.admin.admin_layout')
@section('content')
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-left">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Size</li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>
	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-6">
					<div class="card">
						<div class="card-body">
							<form action="{{ url('admin/attribute/view-attribute-size') }}" method="POST" >
								@csrf
								<div class="form-inline">
									<div class="field_wrapper_size">
										<input type="text" name="size[]"  id="size"  class="form-control" placeholder="Hãy nhập size" style="width: 342px;">
										<a href="javascript:void(0);" class="btn btn-primary add_button_size"><i class="fas fa-plus-circle"></i></a>
									</div>
								</div>
								<button type="submit" class="btn btn-success mt-1 mb-1 add_button_size" style="position: absolute;right: 10px;top:16px">Save</button>
							</form>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="card">
						<div class="card-body">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th scope="col">#</th>
										<th scope="col">Size</th>
										<th scope="col">Action</th>
									</tr>
								</thead>
								<tbody>
									@if($data_size->count() > 0)
										@foreach($data_size as $data_size)
										<tr>
											<th>{{ $data_size->id }}</th>
											<td>{{ $data_size->size }}</td>
											<td><a href="" class="btn btn-danger"><i class="fas fa-trash"></i></a></td>
										</tr>
										@endforeach
									@endif
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<script>
	$(document).ready(function() {
		let maxField = 10;
		let addButton = $('.add_button_size');
		let wrapper = $('.field_wrapper_size');
		let fieldHTML='<div class="field_wrapper_add_color" style="margin-top:2px;"><input type="text" name="size[]"  id="size"  class="form-control" placeholder="Hãy nhập size" style="width: 342px;"><a href="javascript:void(0);" class="btn btn-danger remove_button_color" style="margin-left:3px;"><i class="fas fa-trash"></i></a></div>';
		let x =1;
		$(addButton).click(function(){
			if(x < maxField){
				x++;
				$(wrapper).append(fieldHTML);
			}
		});
		$(wrapper).on('click','.remove_button_color', function(e){
			e.preventDefault();
			$(this).parent('div .field_wrapper_add_color').remove();
			x--;
		});
	});
	$(document).on('change','.colorselector', function() {
	    let color = $(this).find(':selected').data('color');
	    $(this).css('background',color);
	});
</script>
@endsection
