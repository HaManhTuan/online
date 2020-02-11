@extends('layouts.admin.admin_layout')
@section('content')
<link rel="stylesheet" href="{{ asset('admin/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-left">
            <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
            <li class="breadcrumb-item active">Sản phẩm</li>
            <li class="breadcrumb-item active">Ảnh sản phẩm</li>
          </ol>
        </div><!-- /.col -->
        <div class="col-sm-6">
          @if(Session::has('flash_message_success'))
          <div class="alert bg-success text-white alert-styled-left alert-dismissible">
            <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
            <span class="font-weight-semibold">Well done!</span> {{ Session::get('flash_message_success') }}
          </div>
          @endif
        </div>
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <section class="content">
   <div class="container-fluid">
    <form role="form" id="addAttributeForm" method="POST" action="{{ url('admin/product/add-image/'.$product_detail->url) }}" enctype='multipart/form-data' >
      @csrf
      <div class="row">
       <div class="col-md-6">
        <div class="card">
         <div class="card-header">
           <h3 class="card-title">Ảnh sản phẩm</h3>
         </div>
         <div class="card-body">
           <input type="hidden" name="product_id" value="{{ $product_detail->id }}">
           <table class="table table-bordered table-hover">
            <tr>
              <td class="font-weight-bold">Tên sản phẩm</td>
              <td><span class="text-dark">{{ $product_detail->name }}</span></td>
            </tr>
            <tr>
              <td class="font-weight-bold">Danh mục sản phẩm</td>
              <td><span class="text-dark">{{ $product_detail->category->name  }}</span></td>
            </tr>
            <tr>
              <td class="font-weight-bold">Giá sản phẩm</td>
              <td><span class="text-dark">{{ $product_detail->price  }}</span></td>
            </tr>
          </table>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Thêm ảnh sản phẩm </h3>
        </div>
        <div class="card-body">
         <input type="file" multiple="multiple" class="multi with-preview" name="file[]" id="uploadimg" />
       </div>
       <div class="card-footer">
         <button type="submit" class="btn btn-primary" id="btn-save" style="float: right;">Thêm Size</button>
       </div>
     </div>
   </div>
 </form>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="card">
     <div class="card-header">
      <h3 class="card-title">Bảng ảnh sản phẩm </h3>
    </div>
    <div class="card-body">
      @if ($product_img->count() > 0)
      <table class="table table-bordered" id="img-table">
        <thead>
          <tr>
            <th>TT</th>
            <th>Ảnh</th>
            <th>Hành động</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($product_img as $value)
          <tr id="tr-item-{{$value->id}}" class="tr-item">
           <td>{{$value->id}}</td>
           <td><img src="{{ asset('uploads/images/products/'.$value->img) }}" style="width: 200px"></td>
           <td><a data-id="{{$value->id}}" class="btn btn-danger btn-del"><i class="fas fa-trash"></i></a></td>
         </tr>
         @endforeach
       </tbody>
     </table>
     @else
     <h5 align="center">Không có dữ liệu</h5>
     @endif
   </div>
 </div>
</div>
</div>
</section>
</div>
<style>
  .MultiFile-list{
    border: 1px solid #e2e4e6;
    margin-top: 5px;
    padding: 5px;
  }
  .MultiFile-preview{
   float: right;
 }
 .MultiFile-title{
  color:red;
  margin-left: 30px;
}
.MultiFile-label{
  margin-bottom: 24px;
  padding-bottom: 19px;
}
.MultiFile-remove{
  position: absolute;
  background: #e2e4e6;
  width: 24px;
  text-align: center;
  color: black;
  border-radius: 12px;
}
.MultiFile-remove:hover{
  background: red;
  color:white;

}
.MultiFile-preview
{
  max-width: 10% !important;
}
</style>
<script src="{{ asset('admin/js/jquery.MultiFile.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.29.2/sweetalert2.all.js"></script>
<script>
  $(function(){
    $('.with-preview').MultiFile();
  });
  $(document).on('click', '.btn-del', function() {
    let id = $(this).attr('data-id');
    Swal({
      title: 'Xác nhận xóa?',
      type: 'error',
      html: '<p>Bạn sắp xóa 1 ảnh.</p><p>Bạn có chắn chắn muốn xóa?</p>',
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
          url: '{{ url('admin/product/delete-img') }}',
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
                              $("#tr-item-" + id).remove();
                              if ($("#img-table .tr-item").length == 0) {
                                location.reload();
                              }
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
</script>
@endsection