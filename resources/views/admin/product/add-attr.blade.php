@extends('layouts.admin.admin_layout')
@section('content')
  <link rel="stylesheet" href="{{ asset('admin/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
      	<div class="row">      	@if(Session::has('flash_message_success'))
			   <div class="alert bg-success text-white alert-styled-left alert-dismissible">
					<button type="button" class="close" data-dismiss="alert"><span>×</span></button>
					<span class="font-weight-semibold">Well done!</span> {{ Session::get('flash_message_success') }}
				 </div>
			  @endif

            @if(Session::has('error_msg'))
          <div class="alert alert-danger" role="alert">
          {!! session('error_msg')!!}
        </div>
        @endif</div>
      	<div class="row">
	        <div class="col-sm-6">
	      		 <h1 class="m-0 text-dark">
	      			Quản lý  Size sản phẩm
	      		</h1>
	      	</div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
              <li class="breadcrumb-item active"> Size của sản phẩm</li>
              <li class="breadcrumb-item active"></li>
            </ol>
          </div>
      	</div>
       </div>
      </div>

    <section class="content">
      <div class="container-fluid">
		<div class="card card-default color-palette-box">
          <div class="card-header">
            <h3 class="card-title">
              <i class="fas fa-tag"></i>
             Chi tiết sản phẩm
            </h3>

          </div>
          <div class="card-body">
            <form role="form" id="addAttributeForm" method="POST" action="{{ url('admin/product/add-attribute/'.$product_detail->url) }}" enctype='multipart/form-data' >
            	@csrf
            	<input type="hidden" name="product_id" value="{{ $product_detail->id }}">
            	<div class="row">
            		<div class="col-md-6">
            			 <div class="form-group">
				              <label for="category_name_input" class="control-label">Tên sản phẩm <font color="#a94442">(*)</font>&nbsp: <span class="text-dark">{{ $product_detail->name }}</span></label>
				            </div>
				            <div class="form-group">
				              <label for="category_name_input" class="control-label">Danh mục <font color="#a94442">(*)</font>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: <span class="text-dark">{{ $category_name }}</span></label>
				            </div>
				             <div class="form-group">
				              <label for="category_name_input" class="control-label">Giá <font color="#a94442">(*)</font>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: <span class="text-dark">{{ $product_detail->price }}</span></label>
				            </div>
				             <div class="form-group">
				              <label for="category_name_input" class="control-label">Màu <font color="#a94442">(*)</font>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: <span class="text-dark">{{ $product_detail->color }}</span></label>
				            </div>
            		</div>
            		<div class="col-md-6">
            			<label for="category_name_input" class="control-label">Hãy nhập size cho sản phẩm <font color="#a94442">(*)</font>: </label>
			            <div class="form-inline">
			            	<div class="field_wrapper">
			            		<input type="text" name="size[]"  id="size"  class="form-control" placeholder="Hãy nhập size">
			            		<input type="text" name="stock[]" id="stock" class="form-control" placeholder="Hãy nhập số lượng">
			            		<a href="javascript:void(0);" class="btn btn-primary add_button"><i class="fas fa-plus-circle"></i></a>
			            	</div>
			            </div>
            		</div>
            	</div>
              <div class="card-footer">
    		      <button type="submit" class="btn btn-primary" id="btn-save" style="float: right;">Thêm Size</button>
    		    </div>
            </form>
           </div>
        </div>
        <div class="card card-default color-palette-box">
          <div class="card-header">
            <h3 class="card-title">
              <i class="fas fa-tag"></i>
             Bảng Size Sản Phẩm - {{ $product_detail->color }}
            </h3>
          </div>
           <div class="card-body">
           	<form  action="{{ url('admin/product/edit-attributes/'.$product_detail->url) }}" method="post">
           		{{ csrf_field() }}
              <table class="table table-bordered ">
                <thead>
                  <tr>
                    <th>Attribute ID</th>
                    <th>Size</th>
                    <th>Stock</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
            	@php
            	$productDetails=  DB::table('product_size')->where('product_id',$product_detail->id)->get();

            	@endphp
                  @foreach($productDetails as $attribute)
                  <tr class="gradeX">
                    <td class="center"><input type="hidden" name="idAttr[]" value="{{ $attribute->id }}">{{ $attribute->id }}</td>
                    <td class="center">{{ $attribute->size }}</td>
                    <td class="center"><input name="stock[]" class="form-control" type="text" value="{{ $attribute->stock }}" required style="width: 100px" /></td>
                    <td class="center">
                      <input type="submit" value="Update" class="btn btn-primary btn-mini" />
                      <a id="btn-delete" data-id="{{ $attribute->id }}" class="btn btn-danger btn-mini btn-delete">Delete</a>
                    </td>

                  </tr>
                  @endforeach
                </tbody>
              </table>
    </form>
           </div>
       </div>
	</section>
</div>
<style>
	.text-dark{
		font-style: italic;
font-weight: normal;

	}
	.field_wrapper_add{
		margin-top: 10px;
	}
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.29.2/sweetalert2.all.js"></script>

<script>
	$(document).ready(function() {
		var maxField = 10;
		var addButton = $('.add_button');
		var wrapper = $('.field_wrapper');
		var fieldHTML='<div class="field_wrapper_add"><input type="text" name="size[]"  id="size"  class="form-control" placeholder="Hãy nhập size" style="margin-right: 3px;"><input type="text" name="stock[]" id="stock" class="form-control" placeholder="Hãy nhập số lượng" style="margin-right: 3px;"><a href="javascript:void(0);" class="btn btn-danger remove_button"><i class="fas fa-trash"></i></a></div>';

		var x =1;
		$(addButton).click(function(){
			if(x < maxField){
              x++;
              $(wrapper).append(fieldHTML);
			}
		});
		$(wrapper).on('click','.remove_button', function(e){
			e.preventDefault();
			$(this).parent('div .field_wrapper_add').remove();
			x--;
		});
		$(".btn-delete").on('click',function() {
			let id = $(this).attr('data-id');
            Swal({
                title: 'Xác nhận xóa?',
                type: 'error',
                html: '<p>Bạn sắp xóa 1 size sản phẩm.</p><p>Bạn có chắn chắn muốn xóa?</p>',
                showConfirmButton: true,
                confirmButtonText: '<i class="ti-check" style="margin-right:5px"></i>Đồng ý',
                confirmButtonColor: '#ef5350',
                cancelButtonText: '<i class="ti-close" style="margin-right:5px"></i> Hủy bỏ',
                showCancelButton: true,
                focusConfirm: false,
                reverseButtons: true
            }).then((result) => {
                if (result.value == true) {
                    $.ajax({
                        url: '{{ url('admin/product/de-pro-size') }}',
                        type: 'POST',
                        data: {id: id, length: '1'},
                        dataType: 'JSON',
                        headers: {
                            'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
                        },
                        success: function(data) {
                          //console.log(data);
                            if(data.status == '_success') {
                                Swal({
                                    title: data.msg,
                                    showCancelButton: false,
                                    showConfirmButton: false,
                                    type: 'success',
                                    timer: 2000
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal({
                                    title: data.msg,
                                    showCancelButton: false,
                                    showConfirmButton: true,
                                    confirmButtonText: 'OK',
                                    type: 'error'
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
                return false;
            });
            return false;
		});
	});
</script>
@endsection