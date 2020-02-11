// Yêu cầu jquery bản 3 chấm trở lên, bootstrap.js, cropper.js, thư viện sweetalert
$(document).ready(function() {
    'use strict';
    // Add image
    $(document).on('change', ".ng-fileupload-item [ng-action='browse']", function() {
        $(this).parents(".ng-fileupload-item").addClass('active');
        let id, html;
        id = $(this).attr('ng-id');

        // Đọc file
        var file, resize, resize_w, resize_h;
        file = this.files[0];
        var rawImg = '';

        var reader = new FileReader();
        reader.onload = function (e) {
            $('#cropImagePop').modal('show');
            rawImg = e.target.result;
        }
        reader.readAsDataURL(file);

        // Crop
        let cropHtml = `
            <div class="modal fade" id="cropImagePop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">
                                Tạo ảnh đại diện
                            </h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <div class="img-container">
                                <img id="image-preview" src="" alt="Picture" style="width:70%" />
                            </div>
                        </div>
                        <div class="modal-footer d-block">
                            <div class="row">
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-info" data-method="rotate" data-option="-45" title="Rotate Left">
                                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="Xoay trái">
                                            <span class="fa fa-undo-alt"></span>
                                        </span>
                                    </button>
                                    <button type="button" class="btn btn-info" data-method="rotate" data-option="45" title="Rotate Right">
                                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="Xoay phải">
                                            <span class="fa fa-redo-alt"></span>
                                        </span>
                                    </button>
                                </div>
                                <div class="col-md-6 text-right">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
                                    <button type="button" class="btn btn-primary" data-method="getCroppedCanvas" data-option="{ &quot;maxWidth&quot;: 4096, &quot;maxHeight&quot;: 4096 }" data-loading-text="<i class='fas fa-spinner fa-spin loading mr-2'></i>">
                                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="Lưu">
                                          Lưu
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;

        // Add crop modal append to body tag
        if ($("body #cropImagePop").length == 0) {
            $("body").append(cropHtml);
        }

        var $image = $('#image-preview');
        var imageData = '';

        resize = $(this).parents('.ng-fileupload').attr('ng-resize').split(",");
        resize_w = resize[0];
        resize_h = resize[1];

        // Event when open to crop modal
        $('#cropImagePop').on('shown.bs.modal', function() {
            imageData = rawImg;
            $image.attr('src', imageData);
            var console = window.console || { log: function () {} };
            var URL = window.URL || window.webkitURL;
            var $dataX = 31;
            var $dataY = 47;
            var $dataHeight = resize_h;
            var $dataWidth = resize_w;
            var $dataRotate = 0;
            var $dataScaleX = 1;
            var $dataScaleY = 1;
            var options = {
                //aspectRatio: $dataWidth / $dataHeight,
                autoCropArea: 0.6,
                crop: function (e) {
                    $dataX.val(Math.round(e.detail.x));
                    $dataY.val(Math.round(e.detail.y));
                    $dataHeight.val(Math.round(e.detail.height));
                    $dataWidth.val(Math.round(e.detail.width));
                    $dataRotate.val(e.detail.rotate);
                    $dataScaleX.val(e.detail.scaleX);
                    $dataScaleY.val(e.detail.scaleY);
                }
            };
            var originalImageURL = $image.attr('src');
            var uploadedImageName = 'cropped.jpg';
            var uploadedImageType = 'image/jpeg';
            var uploadedImageURL;

            // Cropper
            $image.on({
                ready: function (e) {
                    console.log(e.type);
                },
                cropstart: function (e) {
                    console.log("Crop start " + e.type, e.detail.action);
                },
                cropmove: function (e) {
                    console.log(e.type, e.detail.action);
                },
                cropend: function (e) {
                    console.log(e.type, e.detail.action);
                },
                crop: function (e) {
                    console.log("Crop " + e.type);
                },
                zoom: function (e) {
                    console.log(e.type, e.detail.ratio);
                }
            }).cropper(options);




        

       

        });
        $('#cropImagePop').on('hide.bs.modal', function() {
            $("body").removeClass('modal-open');
            let $obj = $('.ng-fileupload .ng-fileupload-item.active');
            let name = $obj.parents('.ng-fileupload').attr('ng-name');

            let oldSrc = $.trim($obj.find(`input[name="${name}[]"]`).val());
            if (oldSrc != "" && /^(data\:image\/)/.test(oldSrc) == false) {
                let oldFileHtml = `<input type='hidden' name='oldFile[]' value='${oldSrc}' />`;
                $(".ng-fileupload").append(oldFileHtml);
            }
            $obj.find('img').attr('src', imageData);

            let filename = file.name;
            let filesize = file.size;
            // let filesize = atob(imageData.substr(22)).length;

            $obj.find('.ng-fileupload-filename').html(filename);
            $obj.find('.ng-fileupload-filesize').html(size_format(filesize));
            if ($obj.find(".ng-fileupload-filesize-hidden").length == 0) {
                let sizeHtml = `
                    <span class='ng-fileupload-filesize-hidden d-none'>${filesize}</span>
                    <input type="hidden" name="filesize[]" value="${filesize}" />
                `;
                $obj.append(sizeHtml);
            } else {
                $obj.find(".ng-fileupload-filesize-hidden").html(filesize);
                $obj.find("input[name='filesize[]']").val(filesize);
            }

            $obj.addClass('has-file');
            $obj.find(".ng-fileupload-preview, .ng-fileupload-info").removeClass('d-none');
            $obj.find(".ng-fileupload-actions [ng-action='delete']").removeClass('d-none');




            let inputFileHtml = `<input type="hidden" name="${name}[]" value="${imageData}" />`;
            if ($obj.find(`input[name='${name}[]']`).length == 0) {
                $obj.append(inputFileHtml);
            } else {
                $obj.find(`input[name='${name}[]']`).val(imageData);
            }


            let lastKey = $(".ng-fileupload .ng-fileupload-item").index($(".ng-fileupload .ng-fileupload-item.has-file:last-child")) + 1;
            let length = $(".ng-fileupload .ng-fileupload-item.has-file").length;

            // Đệ quy random key
            function str_random($length) {
                let value = Math.random().toString(36).substring($length);
                if ($(".ng-fileupload .ng-fileupload-item[ng-key='"+value+"']").length > 0) {
                    str_random($length);
                }
                return value;
            }

            let key = str_random(2);
            if (lastKey == length) {
                html = `
                    <li class="ng-fileupload-item" ng-key="${key}">
                        <div class="ng-fileupload-preview d-none">
                            <img src="" id="file-preview-${key}" />
                        </div>
                        <div class="ng-fileupload-actions">
                            <label class="fas fa-plus" for="file-${key}"></label>
                            <a href="javascript: void(0);" ng-action="delete" class="d-none">
                                <i class="fas fa-minus-circle"></i>
                            </a>
                        </div>
                        <div class="ng-fileupload-info d-none">
                            <h3 class="ng-fileupload-filename"></h3>
                            <div class="ng-fileupload-filesize"></div>
                        </div>
                        <input type="file" id="file-${key}" ng-action="browse" ng-id="#file-preview-${key}" />
                    </li>
                `;
                $obj.after(html);
            }
            $(".ng-fileupload").find(".ng-fileupload-totalImage").html(length);
            let totalSize = 0;
            $(".ng-fileupload .ng-fileupload-filesize-hidden").each(function() {
                let value = parseInt($.trim($(this).html()));
                totalSize += value;
            });
            $(".ng-fileupload").find(".ng-fileupload-totalSize").html(size_format(totalSize));
            $('.ng-fileupload .ng-fileupload-item.active').removeClass('active');
            $image.cropper("destroy");
            setTimeout(function() {
                $("body #cropImagePop").remove();
                $("body .modal-backdrop").remove();
            }, 300);
        });

    });

    // Delete image
    $(document).on('click', '[ng-action="delete"]', function() {
        let oldFile = $.trim($(this).parents(".ng-fileupload-item").find("input[name='files[]']").val());
        if (/^(data\:image\/)/.test(oldFile) == false) {
            let oldFileHtml = `<input type='hidden' name='oldFile[]' value='${oldFile}' />`;
            $(this).parents(".ng-fileupload").append(oldFileHtml);
        }
        $(this).parents('.ng-fileupload-item').remove();
        let length = $(".ng-fileupload .ng-fileupload-item.has-file").length;
        $(".ng-fileupload .ng-fileupload-totalImage").html(length);
        let totalSize = 0;
        $(".ng-fileupload .ng-fileupload-filesize-hidden").each(function() {
            let value = parseInt($.trim($(this).html()));
            totalSize += value;
        });
        $(".ng-fileupload .ng-fileupload-totalSize").html(size_format(totalSize));
        return false;
    });
});
