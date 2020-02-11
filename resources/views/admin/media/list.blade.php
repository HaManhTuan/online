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
          <div class="row">
            <h1 class="m-0 text-dark">
              <a class="btn btn-app resetForm" href="{{ url('admin/media/add-media') }}">
                <span class="badge bg-danger"></span>
                <i class="fas fa-plus"></i> Thêm mới
              </a>
            </h1>
            <h1 class="m-0 text-dark">
              <a class="btn btn-app resetForm" href="{{ url('admin/media/discount') }}">
                <span class="badge bg-danger"></span>
                <i class="fas fa-plus"></i> Discount
              </a>
            </h1>
          </div>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
            <li class="breadcrumb-item active">Media</li>
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
            Bảng Slide
          </h3>
        </div>
        @if ($media->count() > 0)
        <div class="card-body">
         <table id="media-table" class="table table-bordered table-hover">
           <thead>
             <tr>
               <th>Ảnh</th>
               <th>Mô tả 1</th>
               <th>Mô tả 2</th>
               <th>Nút</th>
               <th>Hành động</th>
             </tr>
           </thead>
           <tbody>
            @foreach ( $media as $item)
            <tr>
              <td><img src="{{ asset('uploads/images/sliders/'.$item['image']) }}" width="200"></td>
              <td>{{ $item->h6 }}</td>
              <td>{{ $item->h2 }}</td>
              <td>
                @if ( $item->button !='')
                <button type="button" class="btn btn-primary">{{ $item->button }}</button>
                @endif
              </td>
              <td>
                <a href="" class="btn btn-success btn-edit" data-id="{{ $item->id}}"><i class="fas fa-edit" ></i></a>
                <a href="" class="btn btn-danger btn-del" data-id="{{ $item->id }}"><i class="fas fa-trash"></i></a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      @endif
    </div>
  </div>
</div><!-- /.container-fluid -->
</section>
<!-- Modals sửa category -->
<div id="edit-media-modal" class="modal fade" tabindex="-1" role="dialog"
aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg">
  <div class="modal-content">
    <form action="{{url('admin/media/edit-media')}}" method="post" id="editSliderForm" role="form" onsubmit="return false;" enctype='multipart/form-data'>
      <div class="modal-header">
        <h4 class="modal-title">Sửa slide  &quot;
          <span data-ajax="edit" data-field="html"></span>&quot;
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>
      <div class="modal-body"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Hủy bỏ</button>
        <button type="submit" class="btn btn-info waves-effect waves-light btn-edit-save"><small class="ti-pencil-alt mr-2"></small>Cập nhật</button>
      </div>
    </form>
  </div>
</div>
</div>
<!-- /.content -->
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.js" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.29.2/sweetalert2.all.js"></script>
<script>

  $(document).on("click", ".btn-edit", function() {
    let id = $(this).attr('data-id');
    $.ajax({
      url: '{{url("admin/media/edit-modal")}}',
      type: 'POST',
      data: {id: id},
      dataType: 'JSON',
      headers: {
        'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
      },
      success:function(data) {
        $("#edit-media-modal .modal-body").html(data.body);
        $('[data-ajax="edit"]').html(data.name);
        $(".dropify").dropify();
        $("#edit-media-modal").modal('show');

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
  $(document).on('click', ".btn-edit-save", function() {
    let action = $("#editSliderForm").attr('action');
    let method = $("#editSliderForm").attr('method');
    let form = document.querySelector("#editSliderForm");
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
            type: 'error',
            showCancelButton: false,
            showConfirmButton: true,
            confirmButtonText: 'OK'
          });
        } else {
          Swal({
            title: data.msg,
            type: 'success',
            showCancelButton: false,
            showConfirmButton: false,
            timer: 2000
          }).then(() => {
            window.location.href = '{{url("admin/media/view-media")}}';
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
  });
  $(".btn-del").on('click',function() {
    let id = $(this).attr('data-id');
    Swal({
      title: 'Xác nhận xóa?',
      type: 'error',
      html: '<p>Bạn sắp xóa 1 slide ảnh.</p><p>Bạn có chắn chắn muốn xóa?</p>',
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
          url: '{{ url('admin/media/delete') }}',
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
</script>
@endsection