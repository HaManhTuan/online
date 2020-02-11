@extends('layouts.admin.admin_layout')
@section('content')
<link rel="stylesheet" href="{{ asset('css/bootstrap-colorselector.css') }}">
<link rel="stylesheet" href="{{ asset('admin/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">
<link rel="stylesheet" href="{{ asset('css/animate.css') }}">
<div class="content-wrapper">
  @php
  $count_pro = DB::table('products')->count();
  @endphp
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">
            <a class="btn btn-app" href="{{ url('admin/product/add') }}">
              <span class="badge bg-danger">{{ $count_pro }}</span>
              <i class="fas fa-plus"></i> Thêm mới
            </a>
          </h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
            <li class="breadcrumb-item active">Sản phẩm</li>
            <li class="breadcrumb-item active"></li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
     <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">
            Danh sách sản phẩm
          </h3>

          <button class="btn btn-danger float-right" style="display: none;padding-top: 5px;" id="btn-del-all">
            <i class="fas fa-trash-alt mr-2"></i>
            Xóa <span></span> mục đã chọn?
          </button>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          @if ($products->count() > 0)
          <table id="product-table" class="table table-bordered table-hover">
           <thead>
             <tr>
               <th>
                <div class="icheck-primary d-inline" style="margin-left: 12px;">
                 <input type="checkbox"  id="checkboxPrimary" value="checkall" data-action="checkall"  class="d-none">
                 <label for="checkboxPrimary">
                 </label>
               </div>
             </th>
             <th style="width:198px">Tên sản phẩm</th>
             <th>Danh mục</th>
             <th>Giá</th>
             <th>Ảnh</th>
             <th>Hành động</th>
           </tr>
         </thead>
         <tbody>
          @php
          $stt = 1;
          @endphp
          @foreach($products as $key => $product)
          <tr>
            <td>
              <div class="icheck-primary d-inline" style="margin-left: 12px;">
               <input type="checkbox"  class="checkone d-none" data-action="checkone" id="checkboxPrimary-{{ $product->id }}" data-id="{{ $product->id }}">
               <label for="checkboxPrimary-{{ $product->id }}">
               </label>
             </div>
           </td>
           <td>{{ $product->name }}
            <span class="{{$product_class_status[$key]}}" style="display: block;min-width: 70px;">{{$product_status[$key]}}</span>
          </td>
          <td>{{ $product->category->name}}</td>
          <td><p>
           Giá gốc: <span class="text-danger"> {{ number_format($product->price) }} VNĐ</span>
         </p>
         @if ($product->promotional_price < $product->price )
         <p style="color: blue">
          Giá KM: <span class="text-danger" style="font-weight: bold"> {{ number_format($product->promotional_price) }} VNĐ </span>
        </p>
        @endif
        <p>
          Sale: <label class="badge badge-danger">{{ $product->sale }} %</label>
        </p>
      </td>
      <td style="display: flex;}"><img src="{{asset('uploads/images/products/'.$product->image)}}" alt="{{$product->name}}" width="100" class="img-fluid d-block ml-auto mr-auto" /></td>
      <td>
        <a href="{{ url('admin/product/edit-pro/'.$product->url) }}" data-id="" class="btn btn-sm btn-success btn-edit-category" data-toggle="tooltip" title="Sửa"><i class="fas fa-edit"></i></a>

        <a href="" data-id="{{ $product->id }}" class="btn btn-sm btn-warning btn-size ml-1"  title="Size" data-toggle="modal" data-target="#addsize"><i class="fas fa-plus-circle"></i></a>

        <a href="{{ url('admin/product/add-image/'.$product->url) }}" data-id="" class="btn btn-sm btn-info btn-del-category ml-1" data-toggle="tooltip" title="Size & Màu"><i class="fas fa-photo-video"></i></a>

        <a href="" data-id="{{ $product->id }}" class="btn btn-sm btn-danger btn-del-pro ml-1" data-toggle="tooltip" title="Xóa"><i class="fas fa-trash"></i></a>


      </td>
    </tr>
    @endforeach


  </tbody>
</table>
@endif


</div>
<!-- /.card-body -->
</div>
<!-- /.card -->
</div>
</div>
</section>
</div>
<!-- Modal Size-->
<div id="addsize" class="modal fade" tabindex="-1" role="dialog"
aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog bounceInDown animated">
  <div class="modal-content">
    <form action="{{ url('admin/product/add-size') }}" method="post" id="id-add-size" class="add-size" role="form" onsubmit="return false;" enctype='multipart/form-data'>
      <div class="modal-header">
        <h4 class="modal-title">Add Size  &quot;
          <span data-ajax="edit" data-field="html"></span>&quot;
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="product_id" value="" class="product_id">
        <input type="hidden" name="stock" value="" class="stock">
        <div class="col-md-12 mb-3">
          <a href="#" class="btn-all" data-action="checkall" id="checkboxmodal"><i class="fas fa-check-double" style="color:black;margin-right: 5px;"></i>Chọn hết</a> |
          <a href="#" class="btn-delall" data-action="nonecheckall" id="checkboxnonemodal"><i class="fas fa-trash" style="color:black;margin-right: 5px;"></i>Xóa hết</a>
        </div>
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <div class="row">
                @foreach($size as $size)
                <div class="col-md-6"> <div><input type="checkbox" class="checkonemodel" id="checkboxmodal-{{ $size->id }}" name="size[]" id="size" value="{{ $size->id }}"> {{ $size->size }}</div></div>
                @endforeach
              </div>
            </div>
          </div>
          <div class="col-md-8 table-size">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Hủy bỏ</button>
        <button type="submit" class="btn btn-info waves-effect waves-light" id="btn-save-size"><small class="ti-pencil-alt mr-2"></small>Add Size</button>
      </div>
    </form>
  </div>
</div>
</div>
<style>
  .modal.fade{
    opacity:1;
  }
  .modal.fade .modal-dialog {
   -webkit-transform: translate(0);
   -moz-transform: translate(0);
   transform: translate(0);
 }
 #addcolor .modal-dialog {
  right: 0px;
  position: absolute;
  max-width: 100%;
}
#addsize .modal-dialog {
  min-width: 770px;
  /* width: 670px; */
  position: absolute;
  right: 0px;
}
#addsize .modal-dialog .form-inline input{
  margin-left: 10px;
}
#addcolor #color-error
{
  position: absolute;
  font-size: 12px;
  color:red;
  bottom: -6px;
  left: 18px;
}
#addcolor #bgc-error
{
  position: absolute;
  font-size: 12px;
  color:red;
  bottom: -30px;
  left: 18px;
}
#addsize .modal-dialog .form-group .error{
  position: absolute;
  top: 101px;
  display: block;
  width: 150px;
  font-size: 14px;
  color:red;
}

</style>
<!-- Modal -->
<script src="{{ asset('js/bootstrap-colorselector.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.29.2/sweetalert2.all.js"></script>
<script>

  /*Modal close Add Color*/
  // $('#addcolor').on('hide.bs.modal', function (e) {
  //   $('#addcolor .modal-dialog').attr('class', 'modal-dialog  bounceOutRight  animated');
  //   $(".add-color")[0].reset();
  //   $('div .field_wrapper_add_color').remove();
  // });
  /*Modal close Add Size*/
  $('#addsize').on('hide.bs.modal', function (e) {
    $('#addsize .modal-dialog').attr('class', 'modal-dialog  bounceOutRight  animated');
  });
  $(document).on('click', '.btn-all', function() {
    let action = $(this).data('action');
    if (action == 'checkall') {
      $("input.checkonemodel").prop('checked', true);
    }
  });
  $(document).on('click', '.btn-delall', function() {
    let action = $(this).data('action');
    if (action == 'nonecheckall') {
      $("input.checkonemodel").prop('checked', false);
    }
  });
  $(document).on('click', 'input[type="checkbox"]', function() {
    let action = $(this).data('action');
    if (action == 'checkall') {
      if ($(this).is(":checked") == true) {
        $("input.checkone").prop('checked', true);
      } else {
        $("input.checkone").prop('checked', false);
      }
    }
    var chkLength = $("input.checkone").length;
    var chkCheckLength = $("input.checkone:checked").length;
    if (chkLength == chkCheckLength) {
      $("#checkboxPrimary").prop('checked', true);
    } else {
      $("#checkboxPrimary").prop('checked', false);
    }
    $("#btn-del-all > span").html(chkCheckLength);
    if (chkCheckLength > 0) {
      $("#btn-del-all").fadeIn(300);
    } else {
      $("#btn-del-all").hide();
    }
  });
  /*Delete Product*/
  $(document).on("click",".btn-del-pro",function() {
    let id = $(this).attr('data-id');
    Swal({
      title: 'Xác nhận xóa?',
      type: 'error',
      html: '<p>Bạn sắp xóa 1 màu</p><p>Bạn có chắn chắn muốn xóa?</p>',
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
          url: '{{ url('admin/product/delete-pro') }}',
          type: 'POST',
          data: {id: id},
          dataType: 'JSON',
          headers: {
            'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
          },
          success: function(data) {
            console.log(data);
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
  /*Open modal color*/
  $(document).on("click", ".btn-color", function() {
    let id = $(this).attr('data-id');

    $.ajax({
      url: '{{url("admin/product/modal-color")}}',
      type: 'POST',
      data: {id: id},
      dataType: 'JSON',
      headers: {
        'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
      },
      success:function(data) {
        $('#addcolor [data-ajax="edit"]').html(data.name).css({"font-size": "16px", "font-weight": "700"});
        $('#addcolor .product_id').val(data.product_id);
        $('#addcolor .table-color').html(data.body);
        $('#addcolor').on('show.bs.modal', function (e) {
          $('#addcolor .modal-dialog').attr('class', 'modal-dialog  bounceInDown  animated');
        });
      },
      error: function(err) {
        console.log(err);
        Swal({
          title: "Error " + err.status,
          text: err.responseText,
          showCancelButton: false,
          showConfirmButton: true,
          confirmButtonText: 'OK',
          type: 'error'
        });
      }
    });
    return false;
  });
  $(document).on("click", ".btn-color", function() {
    let id = $(this).attr('data-id');
    $.ajax({
      url: '{{url("admin/product/modal-color")}}',
      type: 'POST',
      data: {id: id},
      dataType: 'JSON',
      headers: {
        'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
      },
      success:function(data) {
        $('#addcolor [data-ajax="edit"]').html(data.name);
        $('#addcolor .product_id').val(data.product_id);
        $('#addcolor .table-color').html(data.body);
        $('#addcolor').on('show.bs.modal', function (e) {
          $('#addcolor .modal-dialog').attr('class', 'modal-dialog  bounceInDown  animated');
        });
        //$("#btn-save-color").
      },
      error: function(err) {
        console.log(err);
        Swal({
          title: "Error " + err.status,
          text: err.responseText,
          showCancelButton: false,
          showConfirmButton: true,
          confirmButtonText: 'OK',
          type: 'error'
        });
      }
    });
    return false;
  });
  /*Add-color*/
  $("#btn-save-color").click(function() {

    $("#id-add-color").validate({
      submitHandler: function() {
        let action = $("#id-add-color").attr('action');
        let method = $("#id-add-color").attr('method');
        let form = document.querySelector("#id-add-color");
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
                $("#id-add-color")[0].reset();
                window.location.reload();
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
  /*Add-color*/
  /*Delete- Color*/
  $(document).on('click','.btn-del-color', function() {
    let id = $(this).attr('data-id');
    Swal({
      title: 'Xác nhận xóa?',
      type: 'error',
      html: '<p>Bạn sắp xóa 1 màu</p><p>Bạn có chắn chắn muốn xóa?</p>',
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
          url: '{{ url('admin/product/delete-color') }}',
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
  /*Open modal size*/
  $(document).on("click", ".btn-size", function() {
    let id = $(this).attr('data-id');
    $.ajax({
      url: '{{url("admin/product/modal-size")}}',
      type: 'POST',
      data: {id: id},
      dataType: 'JSON',
      headers: {
        'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
      },
      success:function(data) {
        console.log(data);
        $('#addsize [data-ajax="edit"]').html(data.name+' - Màu: '+data.color);
        $('#addsize .product_id').val(data.product_id);
        $('#addsize .stock').val(data.stock);
        $('#addsize .table-size').html(data.body);
        $('#addsize').on('show.bs.modal', function (e) {
         $('#addsize .modal-dialog').attr('class', 'modal-dialog bounceInDown animated');
       });
        // $("#btn-save-color").prop("disabled", true);
      },
      error: function(err) {
        console.log(err);
        Swal({
          title: "Error " + err.status,
          text: err.responseText,
          showCancelButton: false,
          showConfirmButton: true,
          confirmButtonText: 'OK',
          type: 'error'
        });
      }
    });
    return false;
  });

  //Add-Size
  $("#btn-save-size").click(function() {
    if (($("input[name*='size']:checked").length)<=0) {
      alert("You must check at least 1 box");
    }
    else{
     let action = $("#id-add-size").attr('action');
     let method = $("#id-add-size").attr('method');
     let form = document.querySelector("#id-add-size");
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
            window.location.reload();
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
  /*update size-stock */
  $(document).on('click','.btn-up-size', function() {
    let id = $(this).attr('data-id');
    let size = $(this).parent().siblings().children('.size_list').val();
    let stock = $(this).parent().siblings().children('.stock_list').val();
    $.ajax({
      url: '{{ url('admin/product/update-size') }}',
      type: 'POST',
      dataType: 'JSON',
      data: {id: id, size: size, stock :stock},
      headers: {
        'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
      },
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
            window.location.reload();
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
    return false;
  });
  $(document).on('change','.colorselector', function() {
    // let color = $(this).val();
    let color = $(this).find(':selected').data('color');
    $(this).css('background',color);
    //$(".val-color").sibling().val(color);
    //console.log(color);
  });

</script>
@endsection