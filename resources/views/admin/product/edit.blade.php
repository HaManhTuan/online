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
            <li class="breadcrumb-item active">Sản phẩm</li>
            <li class="breadcrumb-item active">Sửa sản phẩm</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <section class="content">
   <div class="container-fluid">
    <div class="row">
     <div class="col-md-12">
      <div class="card">
       <div class="card-header">
         <h3 class="card-title">Sửa sản phẩm</h3>
       </div>
       <div class="card-body">
        <form role="form" id="editProductForm" method="POST" action="{{ url('admin/product/edit-pro/'.$product_detail->url) }}" enctype='multipart/form-data'>
          @csrf

          <div class="card-body">
            <input type="hidden" name="product_id" value="{{ $product_detail->id }}">
            <div class="form-group">
             <label for="category_name_input" class="control-label">Tên sản phẩm <font color="#a94442">(*)</font></label>
             <input type="text" class="form-control" id="name_pro" name="name" onkeyup="ChangeToSlug();" value="{{ $product_detail->name }}" placeholder="Hãy nhập tên sản phẩm." data-rule-required="true" data-msg-required="Vui lòng nhập tên sản phẩm."/>
           </div>
           <div class="form-group">
             <label for="category_name_input" class="control-label">Url <font color="#a94442">(*)</font></label>
             <input type="text" class="form-control" id="url_pro" name="url" value="{{ $product_detail->url }}" readonly=""  />
           </div>
           <div class="form-group">
             <label class="control-label">Chọn danh mục<font color="#a94442">(*)</font></label>
             <select class="form-control custom-select" name="parent_id" id="parent_id" data-rule-required="true" data-msg-required="Vui lòng chọn danh mục." >
               <option value="" disabled="disabled" selected="selected">--- Chọn danh mục ---</option>
               {!! $data_select !!}
             </select>
           </div>
           <div class="form-group">
             <label class="control-label">Chọn danh màu<font color="#a94442">(*)</font></label>
             <select class="form-control custom-select" name="color" id="color" data-rule-required="true" data-msg-required="Vui lòng chọn màu." >
               <option value="" disabled="disabled" selected="selected">--- Chọn danh màu ---</option>
               {!! $data_color !!}
             </select>
           </div>
           <div class="form-group">
            <div class="col-md-4">
             <label for="category_name_input" class="control-label">Số lượng <font color="#a94442">(*)</font></label>
             <input type="number" class="form-control" id="count" name="count" placeholder="Hãy nhập số lượng sản phẩm." value="{{ $product_detail->count }}" data-rule-required="true" data-msg-required="Vui lòng nhập số lượng sản phẩm."  />
           </div>
         </div>
         <div class="form-group">
           <div class="row">
             <div class="col-md-4">
              <label for="exampleInputPassword1">Giá</label>
              <input type="text" class="form-control" id="price" name="price" class="form-control" placeholder="Nhập giá sản phẩm tại đây." data-rule-required="true" data-msg-required="Vui lòng nhập giá."  onkeyup="this.value = number_format(this.value,0,'','.');" onblur="this.value = number_format(this.value,0,'','.')" value="{{ $product_detail->price }}">
            </div>
            <div class="col-md-4">
              <label for="exampleInputPassword1">Giá khuyến mại</label>
              <input type="text" id="promotional_price" name="promotional_price" class="form-control" placeholder="Nhập giá khuyến mại tại đây."  onkeyup="this.value = number_format(this.value,0,'','.')" onblur="this.value = number_format(this.value,0,'','.')" value="{{ $product_detail->promotional_price }}">
            </div>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label" for="description">Mô tả sản phẩm:</label>
          <textarea name="description" id="description" class="form-control" data-rule-required="true" data-msg-required="Vui lòng nhập mô tả sản phẩm.">{!! $product_detail->description  !!}</textarea>
          <script>CKEDITOR.replace('description','', 'full')</script>
        </div>
        <div class="form-group">
         <label class="control-label" for="description">Ảnh sản phẩm:</label>
         <input type="file" name="file" id="file" class="dropify" accept="image/*" data-show-loader="true"  data-default-file="{{ asset('uploads/images/products/'.$product_detail->image) }}"/>
         <input type="hidden" name="old_file" value="{{ $product_detail->image }}">
       </div>
     {{--   <div class="form-group">
         <input type="checkbox" id="edit-product" name="status" value="1" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">
         <label class="control-label" for="description" style="margin-left: 10px;">Hiển thị</label>
       </div> --}}
       <div class="form-group">
        <label class="control-label">Trạng thái<font color="#a94442">(*)</font></label>
        <select class="form-control custom-select status" name="status" id="status" data-rule-required="true" data-msg-required="Vui lòng chọn danh mục." >
         <option value="1" selected="selected">Hiển thị</option>
         <option value="0">Không hiển thị</option>
       </select>
     </div>
     <script>
       $('select.status option[value="' + {{ $product_detail->status }} +'"]').prop("selected", true);
     </script>
   </div>
 </div>
 <!-- /.card-body -->

 <div class="card-footer">
  <button type="submit" class="btn btn-primary" id="btn-save">Sửa</button>
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
	.custom-file-label {
    position: absolute;
    top: 0;
    right: 0;
    left: 0;
    z-index: 1;
    height: calc(2.25rem + 2px);
    padding: .375rem .75rem;
    font-weight: 400;
    line-height: 1.5;
    color:
    #495057;
    background-color:
    #fff;
    border: 1px solid
    #ced4da;
    border-radius: .25rem;
    border-top-right-radius: 0.25rem;
    border-bottom-right-radius: 0.25rem;
    box-shadow: none;
  }
  .MultiFile-wrap{
    border: 1px solid #d1d1d1;
    margin: 10px auto;

  }
  .MultiFile-list{
    border-top: 1px solid #d1d1d1;
    margin-top: 15px;
    padding: 10px;
  }
  .MultiFile-label{
    margin:10px auto;
  }
  .MultiFile-remove{
    background:#e1e1e1;
    padding: auto auto;
    padding: 0px 7px;
    border-radius: 20px;
  }
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.29.2/sweetalert2.all.js"></script>
<script src="{{ asset('admin/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.js" ></script>
<script>
  //$("#edit-product").bootstrapSwitch('state', true);

  $(".dropify").dropify();
  //$("input[name='status'][value='']").bootstrapSwitch('state', true);
  $("#btn-save").click(function() {
    $("#editProductForm").validate({
      submitHandler: function() {
        let action = $("#editProductForm").attr('action');
        let method = $("#editProductForm").attr('method');
        let form = document.querySelector("#editProductForm");
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
                window.location.href = "{{ url('admin/product/view-product') }}";
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