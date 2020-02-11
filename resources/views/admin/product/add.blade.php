@extends('layouts.admin.admin_layout')
@section('content')
<link rel="stylesheet" href="{{ asset('admin/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css">
<link rel="stylesheet" type="text/css" href="{{ asset('admin/dist/css/bootstrap-tagsinput.css')}}">
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-left">
            <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
            <li class="breadcrumb-item active">Sản phẩm</li>
            <li class="breadcrumb-item active">Thêm mới sản phẩm</li>
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
          <h3 class="card-title">Thêm mới sản phẩm</h3>
        </div>
        <div class="card-body">
          <div class="form-group">
           <form role="form" id="addProductForm" method="POST" action="{{ url('admin/product/add-pro') }}" enctype='multipart/form-data' onsubmit="return false;">
            @csrf
            <div class="card-body">
              <div class="form-group">
                <label for="category_name_input" class="control-label">Tên sản phẩm <font color="#a94442">(*)</font></label>
                <input type="text" class="form-control" id="name_pro" name="name" onkeyup="ChangeToSlug();" placeholder="Hãy nhập tên sản phẩm." data-rule-required="true" data-msg-required="Vui lòng nhập tên sản phẩm."/>
              </div>
              <div class="form-group">
                <label for="category_name_input" class="control-label">Url <font color="#a94442">(*)</font></label>
                <input type="text" class="form-control" id="url_pro" name="url" readonly=""  />
              </div>
              <div class="form-group">
                <label class="control-label">Chọn danh mục<font color="#a94442">(*)</font></label>
                <select class="form-control custom-select" name="parent_id" id="parent_id" data-rule-required="true" data-msg-required="Vui lòng chọn danh mục." >
                  <option value="" disabled="disabled" selected="selected">--- Chọn danh mục ---</option>
                  {!! $categoryData !!}
                </select>
              </div>
              <div class="form-group">
                <div class="col-md-6">
                  <label class="control-label">Màu:<font color="#a94442">(*)</font></label>
                    <select class="form-control custom-select" name="color" id="color" data-rule-required="true" data-msg-required="Vui lòng chọn màu." >
                      <option value="" disabled="disabled" selected="selected">--- Chọn màu ---</option>
                    {!! $data_color !!}
                    </select>
                </div>
              </div>
               <div class="form-group">
                <div class="col-md-4">
                   <label for="category_name_input" class="control-label">Số lượng <font color="#a94442">(*)</font></label>
                <input type="number" class="form-control" id="count" name="count" placeholder="Hãy nhập số lượng sản phẩm." data-rule-required="true" data-msg-required="Vui lòng nhập số lượng sản phẩm."  />
                </div>
               </div>
              <div class="form-group">
               <div class="row">
                 <div class="col-md-4">
                  <label for="exampleInputPassword1">Giá</label>
                  <input type="text" class="form-control" id="price" name="price" class="form-control" placeholder="Nhập giá sản phẩm tại đây." data-rule-required="true" data-msg-required="Vui lòng nhập giá."  onkeyup="this.value = number_format(this.value,0,'','.');" onblur="this.value = number_format(this.value,0,'','.')" >
                </div>
                <div class="col-md-4">
                  <label for="exampleInputPassword1">Giá khuyến mại</label>
                  <input type="text" id="promotional_price" name="promotional_price" class="form-control" placeholder="Nhập giá khuyến mại tại đây."  onkeyup="this.value = number_format(this.value,0,'','.')" onblur="this.value = number_format(this.value,0,'','.')" >
                </div>
                <div class="col-md-4">
                  <label for="exampleInputPassword1">Sale</label>
                  <input type="text" id="sale" name="sale" class="form-control"  onkeyup="this.value = number_format(this.value,0,'','.')" onblur="this.value = number_format(this.value,0,'','.')" >
                </div>
              </div>


            </div>

            <div class="form-group">
              <label class="control-label" for="description">Mô tả sản phẩm:</label>
              <textarea name="description" id="description" class="form-control" data-rule-required="true" data-msg-required="Vui lòng nhập mô tả sản phẩm."></textarea>
              <script>CKEDITOR.replace('description','', 'full')</script>
            </div>
            <div class="form-group">
             <label class="control-label" for="description">Ảnh đại diện sản phẩm:</label>
             <input type="file" name="file" id="file" class="dropify" accept="image/*" data-show-loader="true" />
           </div>
         <!--   <div class="form-group">
           <input type="checkbox"  name="status" value="1" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">
           <label class="control-label" for="description" style="margin-left: 10px;">Hiển thị</label>
         </div> -->
         <div class="form-group">
          <label class="control-label">Trạng thái<font color="#a94442">(*)</font></label>
          <select class="form-control custom-select" name="status" id="status" data-rule-required="true" data-msg-required="Vui lòng chọn danh mục." >
           <option value="1" selected="selected">Hiển thị</option>
           <option value="0">Không hiển thị</option>
          </select>
        </div>
         </div>
       </div>
       <!-- /.card-body -->

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
<script>
    // Dropify
    $(".dropify").dropify();
    function ChangeToSlug()
    {
      var title, slug;
            //Lấy text từ thẻ input title
            title = document.getElementById("name_pro").value;
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
            document.getElementById('url_pro').value = slug;
          }
        </script>
        <script src="{{ asset('admin/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}" ></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.29.2/sweetalert2.all.js"></script>
        <script type="text/javascript">
         $("input[data-bootstrap-switch]").bootstrapSwitch('state', true);
         $("#btn-save").click(function() {
          $("#addProductForm").validate({
            submitHandler: function() {
              let action = $("#addProductForm").attr('action');
              let method = $("#addProductForm").attr('method');
              let form = document.querySelector("#addProductForm");
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
        //  var  dataColor = '',
        //       dataSize = '',
        //       data = '';
        //  $('.form-check-input').each(function() {
        //   $(this).click(function() {
        //     var check = $(this).attr('checked');
        //     if (check == 'checked'){
        //       $(this).removeAttr('checked');
        //         dataColor = dataColor.replace(($(this).val()+','),'');
        //         alert(dataColor);

        //     }else{
        //        $(this).attr('checked','checked');
        //         var check2 = $(this).attr('checked');
        //             if (check2 == 'checked') {
        //               dataColor = dataColor+($(this).val())+',';
        //               alert(dataColor);
        //             }
        //     }

        //       });
        // });
      </script>
      @endsection