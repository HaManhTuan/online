@extends('layouts.admin.admin_layout')
@section('content')
  <link rel="stylesheet" href="{{ asset('admin/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css">
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-left">
              <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
              <li class="breadcrumb-item active">Media</li>
              <li class="breadcrumb-item active">Thêm mới Slide</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
      	<div class="row">
      		<div class="col-md-12">
      			<div class="card">
		            <div class="card-header">
		              <h3 class="card-title">Thêm mới Slide</h3>
		            </div>
		            <div class="card-body">
						<form role="form" id="addSlideForm" method="POST" action="{{ url('admin/media/add-media') }}" enctype='multipart/form-data' onsubmit="return false;">
                            @csrf
						    <div class="card-body">
						    	<div class="form-group">
						    		 <label for="category_name_input" class="control-label">Tên<font color="#a94442">(*)</font></label>
	                                <input type="text" class="form-control" id="" name="name" placeholder="Hãy nhập slide." data-rule-required="true" data-msg-required="Vui lòng nhập tên slide."/>
						    	</div>
						    	<div class="form-group">
						    		 <label for="category_name_input" class="control-label">Ảnh<font color="#a94442">(*)</font></label>
	                   <input type="file" id="input-file-now" name="image" class="dropify" data-rule-required="true" data-msg-required="Vui lòng chọn slide.">
						    	</div>
						    	<div class="form-group">
						    		 <label for="category_name_input" class="control-label">Mô tả 1<font color="#a94442">(*)</font></label>
	                                <input type="text" class="form-control" name="h6">
						    	</div>
						    	<div class="form-group">
						    		 <label for="category_name_input" class="control-label">Mô tả 2<font color="#a94442">(*)</font></label>
	                                 <input type="text" class="form-control" name="h2">
						    	</div>
							    <div class="form-group">
						    		 <label for="category_name_input" class="control-label">Nút<font color="#a94442">(*)</font></label>
	                                 <input type="text" class="form-control" name="button" value="Khám Phá" style="width: 30%;">
						    	</div>
                            </div>
						    <div class="card-footer">
						      <button type="submit" class="btn btn-primary" id="btn-save">Thêm</button>
						    </div>
						  </form>
		            </div>
		        </div>
      		</div>
      	</div>
      </div>
    </section>
</div>
<style>
    label.error{
    font-size: 14px;
    color:red;
    margin: 8px;
  }
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.js" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.29.2/sweetalert2.all.js"></script> 
<script>
	$(".dropify").dropify();
	  $("#btn-save").click(function() {
            $("#addSlideForm").validate({
                submitHandler: function() {
                    let action = $("#addSlideForm").attr('action');
                    let method = $("#addSlideForm").attr('method');
                    let form = document.querySelector("#addSlideForm");
                    var formData = new FormData(form);
                    $.ajax({
                        url: action,
                        type: method,
                        processData: false,
                        contentType: false,
                        data: formData,
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
                                    window.location.href = "{{ url('admin/media/view-media') }}";
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