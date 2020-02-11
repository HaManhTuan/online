@extends('layouts.admin.admin_layout')
@section('content')
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-left">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Color</li>
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
							<form action="{{ url('admin/attribute/view-attribute') }}" method="POST">
								@csrf
								<div class="form-inline">
									<div class="field_wrapper_color">
										<input type="text" name="color[]" id="color"  class="form-control" placeholder="Hãy nhập màu"
										data-rule-required="true" data-msg-required="Vui lòng nhập tên màu.">
										<select id="bgc" class="form-control colorselector" data-rule-required="true" data-msg-required="Vui lòng chọn màu." name="bgc[]" ><option value="#000000" data-color="#fff" selected>--Select Color--</option><option value="#A0522D" data-color="#A0522D">Siena</option><option value="#CD5C5C" data-color="#CD5C5C" >indianred</option><option value="#FF4500" data-color="#FF4500">orangered</option><option value="#008B8B" data-color="#008B8B">darkcyan</option><option value="#B8860B" data-color="#B8860B">darkgoldenrod</option><option value="#32CD32" data-color="#32CD32">limegreen</option><option value="#FFD700" data-color="#FFD700">gold</option><option value="#48D1CC" data-color="#48D1CC">mediumturquoise</option><option value="#87CEEB" data-color="#87CEEB">skyblue</option><option value="#FF69B4" data-color="#FF69B4">hotpink</option><option value="#CD5C5C" data-color="#CD5C5C">indianred</option><option value="#87CEFA" data-color="#87CEFA">lightskyblue</option><option value="#6495ED" data-color="#6495ED">cornflowerblue</option><option value="15" data-color="#DC143C">crimson</option><option value="#FF8C00" data-color="#FF8C00">darkorange</option><option value="#C71585" data-color="#C71585">mediumvioletred</option><option value="#000000" data-color="#000000">black</option></select>
										<a href="javascript:void(0);" class="btn btn-primary add_button_color"><i class="fas fa-plus-circle"></i></a>
									</div>
								</div>
								<button type="submit" class="btn btn-success mt-1 mb-1 float-right mr-3">Save</button>
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
										<th scope="col">Name</th>
										<th scope="col">Color</th>
										<th scope="col">Action</th>
									</tr>
								</thead>
								<tbody>
									@if($data_color->count() > 0)
									@foreach($data_color as $data_color)
									<tr>
										<th>{{ $data_color->id }}</th>
										<td>{{ $data_color->color }}</td>
										<td><span style="display: block;width: 50px;height: 50px;background-color:{{ $data_color->class }}"></span></td>
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
		let addButton = $('.add_button_color');
		let wrapper = $('.field_wrapper_color');
		let fieldHTML='<div class="field_wrapper_add_color"><input type="text" name="color[]"  id="color"  class="form-control" placeholder="Hãy nhập màu" style="margin-right: 3px;margin-top:3px;" data-rule-required="true" data-msg-required="Vui lòng nhập tên màu."><select id="bgc" class="form-control colorselector" data-rule-required="true" data-msg-required="Vui lòng chọn màu." name="bgc[]" ><option value="#000000" data-color="#fff" selected>--Select Color--</option><option value="#A0522D" data-color="#A0522D">Siena</option><option value="#CD5C5C" data-color="#CD5C5C" >indianred</option><option value="#FF4500" data-color="#FF4500">orangered</option><option value="#008B8B" data-color="#008B8B">darkcyan</option><option value="#B8860B" data-color="#B8860B">darkgoldenrod</option><option value="#32CD32" data-color="#32CD32">limegreen</option><option value="#FFD700" data-color="#FFD700">gold</option><option value="#48D1CC" data-color="#48D1CC">mediumturquoise</option><option value="#87CEEB" data-color="#87CEEB">skyblue</option><option value="#FF69B4" data-color="#FF69B4">hotpink</option><option value="#CD5C5C" data-color="#CD5C5C">indianred</option><option value="#87CEFA" data-color="#87CEFA">lightskyblue</option><option value="#6495ED" data-color="#6495ED">cornflowerblue</option><option value="15" data-color="#DC143C">crimson</option><option value="#FF8C00" data-color="#FF8C00">darkorange</option><option value="#C71585" data-color="#C71585">mediumvioletred</option><option value="#000000" data-color="#000000">black</option></select><a href="javascript:void(0);" class="btn btn-danger remove_button_color" style="margin-left:3px;"><i class="fas fa-trash"></i></a></div>';
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
