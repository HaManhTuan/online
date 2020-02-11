@extends('layouts.admin.admin_layout')
@section('content')
<link rel="stylesheet" href="{{ asset('admin/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">
<style>
	#retype-new-pwd-error{
		color: red;
		font-size: 14px;
	}
</style>
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Profile</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">User Profile</li>
					</ol>
				</div>
			</div>
		</div><!-- /.container-fluid -->
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-3">

					<!-- Profile Image -->
					<div class="card card-primary card-outline">
						<div class="card-body box-profile">
							<div class="text-center">
								<img class="profile-user-img img-fluid img-circle"
								src="{{ asset('admin/dist/img/user4-128x128.jpg')}}"
								alt="User profile picture">
							</div>
							<h3 class="profile-username text-center">{{ $userLogin->name }}</h3>
							<p class="text-muted text-center">Software Engineer</p>
							<a href="#" class="btn btn-primary btn-block" data-toggle="modal" data-target="#changepassword"><b>Change PassWord</b></a>
						</div>
						<!-- /.card-body -->
					</div>
					<!-- /.card -->
					<!-- About Me Box -->
					<div class="card card-primary" style="display: none;">
						<div class="card-header">
							<h3 class="card-title">About Me</h3>
						</div>
						<!-- /.card-header -->
						<div class="card-body">
							<strong><i class="fas fa-book mr-1"></i> Education</strong>

							<p class="text-muted">
								B.S. in Computer Science from the University of Tennessee at Knoxville
							</p>

							<hr>

							<strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>

							<p class="text-muted">Malibu, California</p>

							<hr>

							<strong><i class="fas fa-pencil-alt mr-1"></i> Skills</strong>

							<p class="text-muted">
								<span class="tag tag-danger">UI Design</span>
								<span class="tag tag-success">Coding</span>
								<span class="tag tag-info">Javascript</span>
								<span class="tag tag-warning">PHP</span>
								<span class="tag tag-primary">Node.js</span>
							</p>

							<hr>

							<strong><i class="far fa-file-alt mr-1"></i> Notes</strong>

							<p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>
						</div>
						<!-- /.card-body -->
					</div>
					<!-- /.card -->
				</div>
				<!-- /.col -->
				<div class="col-md-9">
					<div class="card">
						<div class="card-body">
							<form class="form-horizontal">
								<div class="form-group row">
									<label for="inputName" class="col-sm-2 col-form-label">Name</label>
									<div class="col-sm-10">
										<input type="email" class="form-control" id="name" name="name" placeholder="Name" value="{{ $userLogin->name }}">
									</div>
								</div>
								<div class="form-group row">
									<label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
									<div class="col-sm-10">
										<input type="email" class="form-control" name="email" id="email" value="{{ $userLogin->email }}" placeholder="Email">
									</div>
								</div>
								<div class="form-group row">
									<label for="inputEmail" class="col-sm-2 col-form-label">Role</label>
									<div class="col-sm-10">
										<select name="admin" id="admin" class="form-control admin">
											<option value="1">Admin</option>
											<option value="0">User</option>
										</select>
									</div>
									<script>
										$(document).ready(function() {
											$('select.admin option[value="' + {{ $userLogin->admin }} +'"]').prop("selected", true);
										});
									</script>
								</div>
								<div class="form-group row">
									<div class="offset-sm-2 col-sm-10">
										<button type="submit" class="btn btn-danger">Lưu thay đổi</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- Modal Size-->
<div id="changepassword" class="modal fade" tabindex="-1" role="dialog"
aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog bounceInDown animated">
	<div class="modal-content">
		<form action="{{ url('admin/changePwd') }}" method="post" id="change-password-form" class="changepassword" role="form" onsubmit="return false;" enctype='multipart/form-data'>
			@csrf
			<input type="hidden" name="id" value="{{$userLogin->id}}" />
			<div class="modal-header">
				<h4 class="modal-title">
					Đổi mật khẩu
				</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label for="new-pwd">Mật khẩu mới</label>
					<input type="password" id="new-pwd" name="newPwd" class="form-control" placeholder="Nhập mật khẩu mới" data-rule-required="true" data-msg-required="Vui lòng nhập mật khẩu mới" />
				</div>
				<div class="form-group">
					<label for="retype-new-pwd">Nhập lại mật khẩu</label>
					<input type="password" id="retype-new-pwd" name="retypeNewPwd" class="form-control" placeholder="Nhập lại mật khẩu" data-rule-required="true" data-msg-required="Vui lòng nhập lại mật khẩu" data-rule-equalto="#new-pwd" data-msg-equalto="Mật khẩu không khớp" />
				</div>
			</div>
			<div class="modal-footer">
				  <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
                    <button type="submit" id="btn-save-new-pwd" class="btn btn-primary"><i class="fas fa-save"></i> Lưu</button>
			</div>
		</form>
	</div>
</div>
</div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.29.2/sweetalert2.all.js"></script>

<script>
	 $("#btn-save-new-pwd").click(function() {
            let form = $("#change-password-form");
            form.validate({
                submitHandler: function() {
                    let action, method, formData;
                    action = form.attr('action');
                    method = form.attr('method');
                    formData = form.serialize();
                    $.ajax({
                        url: action,
                        type: method,
                        data: formData,
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
                                    type: 'success',
                                    timer: 2000
                                }).then(() => {
                                    location.reload();
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