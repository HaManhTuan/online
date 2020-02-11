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
            <li class="breadcrumb-item active">Media</li>
            <li class="breadcrumb-item active">Discount</li>
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
          <h3 class="card-title">Discount</h3>
        </div>
        <div class="card-body">
          <form role="form" id="edit-discount" method="POST" action="{{ url('admin/media/discount') }}" enctype='multipart/form-data' onsubmit="return false;">
            @csrf
            <div class="card-body">
              <section class="top-discount-area d-md-flex align-items-center">
                <!-- Single Discount Area -->
                <div class="single-discount-area">
                  <input type="text" name="discount1" value="{{ $discount->discount1 }}" >
                </div>
                <!--  Single Discount Area -->
                <div class="single-discount-area">
                  <input type="text" name="discount2" value="{{ $discount->discount2 }}" >
                </div>
                <!-- Single Discount Area -->
                <div class="single-discount-area">
                  <input type="text" name="discount3" value="{{ $discount->discount3 }}">
                </div>
              </section>
              <div class="form-group mt-2">
                <input type="checkbox"   id="edit-discount" name="status" value="1" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">
                <label class="control-label" for="description" style="margin-left: 10px;">Hiển thị</label>
              </div>
           </div>
           <div class="card-footer">
            <button type="submit" class="btn btn-primary" id="btn-save">Cập nhật</button>
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
  .top-discount-area .single-discount-area {
    -webkit-box-flex: 0;
    -ms-flex: 0 0 33.333333%;
    flex: 0 0 33.333333%;
    max-width: 33.333333%;
    padding: 40px 15px;
    background-color:
    #b8b8b8;
    text-align: center;
    -ms-flex-item-align: stretch;
    align-self: stretch;
  }
  .top-discount-area .single-discount-area h5 {
    font-size: 18px;
    color:
    #fff;
    margin-bottom: 15px;
  }
  .top-discount-area .single-discount-area h6, .top-discount-area .single-discount-area a {
    font-size: 12px;
    color:
    #fff;
    font-weight: 700;
    margin-bottom: 0;
  }
  .top-discount-area .single-discount-area a {
    font-size: 12px;
    color:
    #fff;
    font-weight: 700;
    margin-bottom: 0;
  }
  .top-discount-area .single-discount-area:nth-child(2) {
    background-color:
    #ff084e;
  }
  .top-discount-area .single-discount-area:last-child {
    background-color:
    #3a3a3a;
  }
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.js" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.29.2/sweetalert2.all.js"></script>
<script src="{{ asset('admin/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}" ></script>
<script>
   $("#edit-discount [name='status']").bootstrapSwitch();
  $("#edit-discount [name='status'][value='"+{{ $discount->status }}+"']").bootstrapSwitch('state', true);
	$(".dropify").dropify();
 $("#btn-save").click(function() {
  $("#edit-discount").validate({
    submitHandler: function() {
      let action = $("#edit-discount").attr('action');
      let method = $("#edit-discount").attr('method');
      let form = document.querySelector("#edit-discount");
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
              timer: 3000
            }).then(() => {
              window.location.reload;
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