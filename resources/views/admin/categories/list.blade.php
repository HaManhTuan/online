@extends('layouts.admin.admin_layout')
@section('content')
<!-- <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/nestable2/1.6.0/jquery.nestable.css"> -->
 <link rel="stylesheet" href="{{ asset('admin/dist/css/nestable.css')}}">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="{{ asset('admin/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">
  <!-- Toastr -->
  <link rel="stylesheet" href="{{ asset('admin/plugins/toastr/toastr.min.css')}}">
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">
                  @php
                    $count_cate = DB::table('categories')->count();
                  @endphp
              <a class="btn btn-app resetForm" data-toggle="modal" data-target="#add-category-modal">
                  <span class="badge bg-danger">{{ $count_cate }}</span>
                  <i class="fas fa-plus"></i> Thêm mới
                </a>
            </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
              <li class="breadcrumb-item active">Danh mục</li>
              <li class="breadcrumb-item active"> <input id="status1" name="status" value="1" type="checkbox" class="d-none" data-on-color="primary" data-size="small" data-on-text="Yes" data-off-text="No" /></li>
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
                Danh sách danh mục sản phẩm
              </h3>
            </div>
            <div class="container-fluid">
              <div class="row">
                <div class="col-md-6" style="padding-top: 5px;">

                  @if ( $count_cate > 0)
                  <div class="icheck-primary d-inline" style="margin-left: 12px;">
                     <input type="checkbox"  id="checkboxPrimary" value="checkall" data-action="checkall"  class="d-none">
                     <label for="checkboxPrimary">Chọn tất cả danh sách
                     </label>
                  </div>
                  @endif

                </div>
                 <div class="col-md-6">
                   <button class="btn btn-danger float-right" style="display: none;padding-top: 5px;" id="btn-del-all">
                        <i class="fas fa-trash-alt mr-2"></i>
                        Xóa <span></span> mục đã chọn?
                    </button>
                 </div>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

               <div class="dd-save"style="display:none">
                  <p>
                      Bạn vừa thay đổi thứ tự sắp xếp. Vui lòng nhấn <button type="button" class="btn btn-sm btn-primary ml-1 mr-1 btn-save-sort"><i class="fas fa-save"></i> Cập nhật</button> để lưu lại thay đổi!
                  </p>
              </div>
                         @if ($count_cate > 0)
                <div class="dd myadmin-dd" id="nestable-menu">
                   {!! $data_ol !!}
                </div>
              @endif
              @if ($count_cate == 0)
                <h5 align="center">Danh mục sản phẩm đang trống.</h5>
              @endif
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <div class="col-12">
           <div class="card">
            <div class="card-header">
              <h3 class="card-title">
                Bảng danh mục sản phẩm
              </h3>
            </div>
            <div class="card-body">
              @if ($count_cate == 0)
                <h5 align="center">Danh mục sản phẩm đang trống.</h5>
              @endif
             <table id="category-table" class="table table-bordered table-hover">
               <thead>
               <tr>
                 <th>STT</th>
                 <th>Tên danh mục</th>
                 <th>Mô tả</th>
                 <th>Hành động</th>
               </tr>
               </thead>
               <tbody>
               @php
               $stt=1;
               @endphp
               @foreach ($category_data as $category)
                 <tr>
                   <td>{{ $stt++ }}</td>
                   <td>{{ $category->name}}
                     @if ( $category->status == 1)
                     <label class="badge badge-warning change-status float-right" id="change-status" data-id="{{ $category->id}}" data-status="{{ $category->status}}" style="cursor: pointer;">Hiện</label>

                     @endif
                      @if ( $category->status == 0)
                          <label class="badge badge-danger change-status float-right" id="change-status" data-id="{{ $category->id}}" data-status="{{ $category->status}}" style="cursor: pointer;">Ẩn</label>
                     @endif
                   </td>
                   <td>{{ $category->description}}</td>
                   <td>
                     <a class="btn-show-edit-modal d-none" data-toggle="modal" data-target="#edit-category-modal">Sửa</a>
                        <a href="" data-id="{{ $category->id}}" class="btn btn-sm btn-success btn-edit-category" data-toggle="tooltip" title="Sửa"><i class="fas fa-edit"></i></a>
                     <a href="" data-id="{{ $category->id}}" class="btn btn-sm btn-danger btn-del-category ml-1" data-toggle="tooltip" title="Xóa"><i class="fas fa-trash"></i></a>

                   </td>
                 </tr>
               @endforeach
               </tbody>
             </table>
            </div>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
     <!-- Modal thêm category -->
      <div id="add-category-modal" class="modal fade" tabindex="-1" role="dialog"
             aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="{{url('admin/category/add-category')}}" method="POST" id="addCategoryForm" onsubmit="return false;">
                      @csrf
                        <div class="modal-header">
                            <h4 class="modal-title">Thêm danh mục mới</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                          <div class="form-group">
                                <label class="control-label">Chọn danh mục cha <font color="#a94442">(*)</font></label>
                                <select class="form-control custom-select" name="parent_id" id="parent_id" data-rule-required="true" data-msg-required="Vui lòng chọn danh mục." >
                                    <option value="" disabled="disabled" selected="selected">--- Chọn danh mục cha ---</option>
                                    <option value="0">Không có</option>
                                        {!! $data_select !!}

                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="category_name_input" class="control-label">Tên danh mục <font color="#a94442">(*)</font></label>
                                <input type="text" class="form-control" id="name" name="name" onkeyup="ChangeToSlug();" placeholder="Enter Name." data-rule-required="true" data-msg-required="Vui lòng nhập tên danh mục."/>

                            </div>
                             <div class="form-group mb-3">
                                <label for="category_name_input" class="control-label">Url <font color="#a94442">(*)</font></label>
                                <input type="text" class="form-control" id="url" name="url" readonly=""  />

                            </div>
                            <div class="form-group">
                                <label class="control-label">Chi tiết danh mục</label>
                                <textarea rows="5" cols="2" name="description" class="form-control"></textarea>
                            </div>

                            <div class="form-group clearfix">
                                <div class="icheck-primary d-inline">
                                  <input type="checkbox" id="checkboxPrimary1" name="status_cate" checked>
                                  <label for="checkboxPrimary1">
                                  </label>
                                </div>
                                <label class="control-label font-weight-bold ml-2" for="status1">Hiển thị ngoài menu danh sách </label>
                            </div>
                            <div class="form-group clearfix">
                                <div class="icheck-primary d-inline">
                                  <input type="checkbox" id="checkboxPrimarystatus2" name="status" checked>
                                  <label for="checkboxPrimarystatus2">
                                  </label>
                                </div>
                                <label class="control-label font-weight-bold ml-2" for="status2">Hiển thị trên menu chính</label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Hủy bỏ</button>
                            <button type="submit" class="btn btn-danger waves-effect waves-light btn-add-save"><small class="ti-save mr-2"></small>Lưu thay đổi</button>
                        </div>
                    </form>
                </div>
        </div>
      </div>

        <!-- Modals sửa category -->
        <div id="edit-category-modal" class="modal fade" tabindex="-1" role="dialog"
             aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="{{url('admin/category/edit')}}" method="post" id="editCategoryForm" role="form" onsubmit="return false;">
                        <div class="modal-header">
                            <h4 class="modal-title">Sửa danh mục &quot;
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
<style>
  label.error{
    font-size: 14px;
    color:red;
    margin: 8px;
  }
  .dd-status{
    position: absolute;
    top: 6px;
    left: 165px;
  }
  .dd-handle{
    color: black !important;
  }
</style>
<script src="{{ asset('admin/js/jquery.nestable.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.29.2/sweetalert2.all.js"></script>
<!-- Toastr -->
<script src="{{ asset('admin/plugins/toastr/toastr.min.js')}}"></script>
<script src="{{ asset('admin/js/adminlte.js')}}"></script>
<script type="text/javascript">

    var updateOutput = function(e) {
    var list   = e.length ? e : $(e.target);
    if (window.JSON) {
      return window.JSON.stringify(list.nestable('serialize'));
    } else {
      return 'JSON browser support required for this demo.';
    }
    };
    var old_data_sort = updateOutput($('#nestable-menu').nestable());
    var new_data_sort;
    $('#nestable-menu').nestable().on("change",(e) => {
            let list = e.length ? e : $(e.target);
            if (window.JSON) {
                new_data_sort = window.JSON.stringify(list.nestable('serialize'));
            } else {
                Swal({
                    title: 'Error',
                    text: 'JSON browser support required for this demo.',
                    showCancelButton: false,
                    showConfirmButton: true,
                    confirmButtonText: 'OK',
                    type: 'error'
                });
                return false;
            }
            if (new_data_sort != old_data_sort) {
                $(".dd-save").fadeIn(200);
            } else {
                $(".dd-save").fadeOut(200);
            }
    });
    $(document).on('click', '[data-toggle="modal"].resetForm', function() {
        let target = $(this).data('target');
        $(target).find('form')[0].reset();
    });
    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 2000
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
    function ChangeToSlug()
    {
        var title, slug;
        //Lấy text từ thẻ input title
        title = document.getElementById("name").value;
        //Đổi chữ hoa thành chữ thường
        slug = title.toLowerCase();
        //Đổi ký tự có dấu thành không dấu
        slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
        slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
        slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
        slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
        slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
        slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
        slug = slug.replace(/đ/gi, 'd');
        //Xóa các ký tự đặt biệt
        slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
        //Đổi khoảng trắng thành ký tự gạch ngang
        slug = slug.replace(/ /gi, "-");
        //Đổi nhiều ký tự gạch ngang liên tiếp thành 1 ký tự gạch ngang
        //Phòng trường hợp người nhập vào quá nhiều ký tự trắng
        slug = slug.replace(/\-\-\-\-\-/gi, '-');
        slug = slug.replace(/\-\-\-\-/gi, '-');
        slug = slug.replace(/\-\-\-/gi, '-');
        slug = slug.replace(/\-\-/gi, '-');
        //Xóa các ký tự gạch ngang ở đầu và cuối
        slug = '@' + slug + '@';
        slug = slug.replace(/\@\-|\-\@|\@/gi, '');
        //In slug ra textbox có id “slug”
        document.getElementById('url').value = slug;
    }
    function ChangeToSlug_Edit()
    {
        var title, slug;
        //Lấy text từ thẻ input title
        title = document.getElementById("name_edit").value;
        //Đổi chữ hoa thành chữ thường
        slug = title.toLowerCase();
        //Đổi ký tự có dấu thành không dấu
        slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
        slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
        slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
        slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
        slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
        slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
        slug = slug.replace(/đ/gi, 'd');
        //Xóa các ký tự đặt biệt
        slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
        //Đổi khoảng trắng thành ký tự gạch ngang
        slug = slug.replace(/ /gi, "-");
        //Đổi nhiều ký tự gạch ngang liên tiếp thành 1 ký tự gạch ngang
        //Phòng trường hợp người nhập vào quá nhiều ký tự trắng
        slug = slug.replace(/\-\-\-\-\-/gi, '-');
        slug = slug.replace(/\-\-\-\-/gi, '-');
        slug = slug.replace(/\-\-\-/gi, '-');
        slug = slug.replace(/\-\-/gi, '-');
        //Xóa các ký tự gạch ngang ở đầu và cuối
        slug = '@' + slug + '@';
        slug = slug.replace(/\@\-|\-\@|\@/gi, '');
        //In slug ra textbox có id “slug”
        document.getElementById('url_edit').value = slug;
    }
    //Thêm mới danh mục
    $(".btn-add-save").click(function() {
            $("#addCategoryForm").validate({
                submitHandler: function() {
                    let action = $("#addCategoryForm").attr('action');
                    let method = $("#addCategoryForm").attr('method');
                    let formData = $("#addCategoryForm").serialize();
                      $.ajax({
                        url: action,
                        type: method,
                        data: formData,
                        dataType: 'JSON',
                        headers: {
                            'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
                        },
                        success: function(data) {
                            //console.log(data);
                          $("#add-category-modal").modal('hide');
                            if(data.status == '_success') {

                               Toast.fire({
                                type: 'success',
                                title: data.msg
                              }).then(() => {
                                    location.reload();
                                });
                            } else {
                              Toast.fire({
                                type: 'error',
                                title: data.msg
                              })
                            }
                        },
                        error: function(err) {
                            console.log(err);
                               Toast.fire({
                                type: 'error' + err.status,
                                title: err.responseText
                              })
                        }
                    });


                }
            });
    });
    //Xóa danh mục
    $(document).on('click', '.btn-del-category', function() {
            let id = $(this).attr('data-id');
            Swal({
                title: 'Xác nhận xóa?',
                type: 'error',
                html: '<p>Bạn sắp xóa 1 danh mục. Nếu xóa bạn không thể khôi phục lại được.</p><p>Bạn có chắn chắn muốn xóa?</p>',
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
                        url: '{{ url('admin/category/delete') }}',
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
                                    $("#dd-item-" + id).remove();
                                    if ($("#nestable-menu .dd-item").length == 0) {
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
    $(document).on('click', "#btn-del-all", function() {
            let id_array = new Array();
            let length = $("input.checkone:checked").length;
            $("input.checkone:checked").each(function() {
                let id = $(this).data('id');
                id_array.push(id);
            });
            let idStr = id_array.join(',');
            Swal({
                title: 'Xác nhận xóa?',
                type: 'error',
                html: '<p>Bạn sắp xóa '+length+' danh mục. Điều này là không thể đảo ngược.</p><p>Bạn có chắn chắn muốn xóa?</p>',
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
                        url: '{{url("admin/category/delete")}}',
                        type: 'POST',
                        data: {id: idStr, length: length},
                        dataType: 'JSON',
                        headers: {
                            'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
                        },
                        success: function(data) {
                            if(data.status == '_success') {
                                Swal({
                                    title: data.msg,
                                    showCancelButton: false,
                                    showConfirmButton: false,
                                    type: 'success',
                                    timer: 2000
                                }).then(() => {
                                    $("#btn-del-all").hide();
                                    $("input[type='checkbox']").prop('checked', false);
                                    $.each(id_array, function(index, value) {
                                        $("#dd-item-" + value).remove();
                                    });
                                    if ($("#nestable-menu .dd-item").length == 0) {
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
    $(document).on("click", ".btn-edit-category", function() {
            let id = $(this).attr('data-id');
            $.ajax({
                url: '{{url("admin/category/edit-modal")}}',
                type: 'POST',
                data: {id: id},
                dataType: 'JSON',
                headers: {
                    'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
                },
                success:function(data) {
                    $("#edit-category-modal .modal-body").html(data.body);
                    $('[data-ajax="edit"]').html(data.category_name);
                    $("#edit-category-modal #parent_id option[value='"+data.parent_id_data+"']").prop('selected', true);
                    if (data.status_data == 1) {
                        $("#checkboxPrimaryStatus").prop('checked', true);
                    }
                    else {
                      $("#checkboxPrimaryStatus").prop('checked', false);
                    }
                    if (data.status_cate == 1) {
                        $("#checkboxPrimaryStatus1").prop('checked', true);
                    }
                    else {
                      $("#checkboxPrimaryStatus1").prop('checked', false);
                    }
                    $("#edit-category-modal").modal('show');
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
            $("#editCategoryForm").validate({
                submitHandler: function() {
                    let formData = $("#editCategoryForm").serialize();
;

                    let action = $("#editCategoryForm").attr('action');
                    let method = $("#editCategoryForm").attr('method');
                    $.ajax({
                        url: action,
                        type: method,
                        data: formData,
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
            });
    });
    $(document).on('click', '#change-status', function() {
         let id = $(this).attr('data-id');
         let status = $(this).attr('data-status');
             $.ajax({
                url: '{{url("admin/category/change-status")}}',
                type: 'POST',
                data: {id: id, status : status},
                dataType: 'JSON',
                headers: {
                    'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
                },
                success:function(data) {
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
    $(".btn-save-sort").click(function(e){
            e.stopPropagation();
            $.ajax({
                url: "{{url('admin/category/changeSort')}}",
                type: "POST",
                data: {dataJson: new_data_sort},
                dataType:'JSON',
                headers: {
                    'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
                },
                success: function(data) {
                    if (data.status == '_success') {
                        Swal({
                            title: data.msg,
                            showCancelButton:false,
                            showConfirmButton: false,
                            type: 'success',
                            timer: 2000
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal({
                            title: data.msg,
                            showCancelButton:false,
                            showConfirmButton:true,
                            type: 'error'
                        });
                    }
                },
                error:function(err) {
                    console.log(err);
                    Swal({
                        title: "Error " + err.status,
                        text: err.responseText,
                        showCancelButton:false,
                        showConfirmButton:true,
                        type: 'error'
                    });
                }
            })
            return false;
    });
</script>
@endsection