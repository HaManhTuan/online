CKEDITOR.editorConfig = function( config ) {
    config.filebrowserBrowseUrl = '../../public/admin/ckeditor/ckfinder/ckfinder.html';
    config.filebrowserImageBrowseUrl = '../../public/admin/ckeditor/ckfinder/ckfinder.html?type=Images';
    config.filebrowserFlashBrowseUrl = '../../public/admin/ckeditor/ckfinder/ckfinder.html?type=Flash';
    config.filebrowserUploadUrl = '../../public/admin/ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
    config.filebrowserImageUploadUrl = '../../public/admin/ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
    config.filebrowserFlashUploadUrl = '../../public/admin/ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash';
};