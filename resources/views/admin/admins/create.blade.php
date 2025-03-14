@extends('admin.layouts.master')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Dashboard
            <small>Quản lý admin</small>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <form id="create-admin-form" class="form-horizontal" enctype="multipart/form-data" id="add-admin-form" action="javascript:void(0)">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-fw fa-search"></i>Tạo mới admin</h3>
                            <div class="box-tools pull-right">
                                <a href="{{ route('admin.admins.list') }}" type="button" class="btn btn-primary"><i class="fa fa-fw fa-list-alt"></i>
                                    Xem danh sách
                                </a>
                            </div>
                        </div>
                    <!-- /.box-header -->
                        <div class="box-body">
                            <div class="form-group @error('name') has-error @enderror">
                                <label class="col-md-3 control-label">
                                    Tên<span class="required">(*)</span>
                                </label>
                                <div class="col-md-6">
                                    <input type="text" value="{{ old('name') }}" name="name" class="form-control">
                                    @error('name')
                                        <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group form-group-email">
                                <label class="col-md-3 control-label">
                                    Email<span class="required">(*)</span>
                                </label>
                                <div class="col-md-6">
                                    <input type="text" id="email" name="email" class="form-control">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group @error('password') has-error @enderror">
                                <label class="col-md-3 control-label">
                                    Mật khẩu<span class="required">(*)</span>
                                </label>
                                <div class="col-md-6">
                                    <input type="password" id="password" value="{{ old('password') }}" name="password" class="form-control">
                                    @error('password')
                                        <span class="help-block">{{ $message }}</span>
                                    @enderror

                                </div>
                            </div>
                            <div class="form-group @error('password_confirmation') has-error @enderror">
                                <label class="col-md-3 control-label">
                                    Xác nhận mật khẩu<span class="required">(*)</span>
                                </label>
                                <div class="col-md-6">
                                    <input type="password" name="password_confirmation" value="{{ old('password_confirmation') }}" class="form-control">
                                    @error('password_confirmation')
                                        <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group @error('role') has-error @enderror">
                                <label class="col-md-3 control-label">
                                    Quyền<span class="required">(*)</span>
                                </label>
                                <div class="col-md-2">
                                    <select class="form-control" name="role">
                                        @foreach($roles as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                    @error('role')
                                        <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Ảnh đại diện</label>
                                <div class="col-md-6">
                                    <div id="dropzone-admin-avatar" class="dropzone"></div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer text-center">
                            <div class="text-center">
                                <button type="reset" onclick="clearCreateAdminForm()" class="btn btn-default" style="margin-right: 10px">Xóa</button>
                                <button type="submit" class="btn btn-primary"><i class="fa fa-fw fa-check"></i>Tạo</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>

    </section>
    <!-- /.content -->
@endsection

@push('script')
    <script>
        let avatar = null
        const checkRoles = JSON.parse('{{ json_encode(array_keys($roles)) }}');
        $(function() {
            $("form").validate({
                rules: {
                    name: {
                        required: true,
                        maxlength: 50,
                    },
                    email: {
                        required: true,
                        email: true,
                        maxlength: 50,
                    },
                    password: {
                        required: true,
                        minlength: 6,
                        maxlength: 50,
                    },
                    password_confirmation: {
                        required: true,
                        minlength: 6,
                        maxlength: 50,
                        equalTo : "#password",
                    },
                    avatar: {
                        extension: "jpg|jpeg|png",
                        filesize: 20 * 1024 * 1024,
                    },
                    role: {
                        required: true,
                        in: checkRoles.join(',')
                    }
                },
                highlight: function(element) {
                    $(element).closest('.form-group').addClass('has-error');
                },
                unhighlight: function(element) {
                    $(element).closest('.form-group').removeClass('has-error');
                },
                messages: {
                    name: {
                        required: "Tên không được rỗng.",
                    },
                    email: {
                        required: "Email không được rỗng.",
                        email: "Email không hợp lệ.",
                    },
                    password: {
                        required: "Mật khẩu không được rỗng.",
                        minlength: "Mật khẩu phải ít nhất 6 ký tự.",
                        maxlength: "Mật khẩu không được lớn hơn 20 ký tự.",
                    },
                    password_confirmation: {
                        required: "Xác nhận mật khẩu không được rỗng.",
                        minlength: "Xác nhận mật khẩu phải ít nhất 6 ký tự.",
                        maxlength: "Xác nhận mật khẩu không được lớn hơn 20 ký tự.",
                        equalTo: "Mật khẩu và xác nhận mật khẩu không khớp nhau.",
                    },
                    role: {
                        required: "Quyền không được rỗng.",
                        in: "Quyền không hợp lệ.",
                    },
                    avatar: {
                        extension: "Vui lòng chọn ảnh có đuôi file là png, jpeg, jpg.",
                        filesize: "Kích thước tệp không được lớn hơn 20 Mb.",
                    }
                },
                invalidHandler: function(form, validator) {
                    toastr.error('Dữ liệu nhập không hợp lệ.', 'Lỗi');
                },
                submitHandler: function() {
                    const data = {
                        avatar: avatar,
                        name: $('input[name="name"]').val(),
                        email: $('input[name="email"]').val(),
                        password: $('input[name="password"]').val(),
                        password_confirmation: $('input[name="password_confirmation"]').val(),
                        role: $('select option:selected').val(),
                    }
                    $.ajax({
                        data: data,
                        type: 'POST',
                        cache:false,
                        url: `/admin/admins`,
                        success: function(response)
                        {
                            toastr.success(response.message, 'Thành công');
                            window.location = "/admin/admins"
                        },
                        error: function(error) {
                            const responseError = error.responseJSON
                            if (error.status == 422) {
                                toastr.error(responseError.errors[0], 'Lỗi');
                            } else {
                                toastr.error(responseError.message, 'Lỗi');
                            }
                        }
                    });
                }
            });
        });

        $("input[name=email]").on( "focus", function() {
            $("form .help-block").hide();
        } );

        function clearCreateAdminForm ()
        {
            var validator = $("form").validate();
            validator.resetForm();
            $("form .form-group").removeClass('has-error');
            $("form .help-block").hide();
        }

        let maxAvatar = 1
        Dropzone.autoDiscover = false;

        $("#dropzone-admin-avatar").dropzone({
            maxFiles: maxAvatar,
            renameFile: function (file) {
                var dt = new Date();
                var time = dt.getTime();
                return time + file.name;
            },
            acceptedFiles: ".jpg,.jpeg,.jpg,.png,.gif,.webp,.svg",
            dictDefaultMessage: "Bạn có thể kéo ảnh hoặc click để chọn",
            dictRemoveFile: 'Xóa',
            addRemoveLinks: true,
            uploadMultiple: false,
            autoProcessQueue: true,
            timeout: 60000,
            url: '/admin/upload-file',
            params: {
                key: "admin_avatar_"
            },
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (file, response) {
                avatar = response.data
            },
            error: function (file, response) {
                return false;
            },
            accept: function(file, done) {
                done()
            },
            init : function() {
                var myDropZone = this;
                myDropZone.on('maxfilesexceeded', function(file) {
                    toastr.error(`Tối đa là ${maxAvatar} ảnh.`, 'Lỗi');
                    myDropZone.removeFile(file);
                });
            },
            removedfile: function (file) {
                file.previewElement.remove()
                removeImageOnServer(JSON.parse(file.xhr.response).data.store_name)
                avatar = null
            },
        });
    </script>
@endpush
