(function ($) {
    // 初始化Web Uploader
    var file_num = $("#filePicker").attr("data-file-num");
    var name = $("#filePicker").attr("data-name");
    file_num = file_num ? file_num : 1;
    name = name ? name : 'image';
    var uploader = WebUploader.create({
        // 选完文件后，是否自动上传。
        auto: true,
        multiple: false,
        fileNumLimit : file_num,
        // swf文件路径
        swf: HOST_URL + '/static/webuploader/dist/Uploader.swf',
        // 文件接收服务端。
        server: HOST_URL + '/upload/ajax_upload',
        // 选择文件的按钮。可选。
        // 内部根据当前运行是创建，可能是input元素，也可能是flash.
        pick: '#filePicker',
        // 只允许选择图片文件。
        accept: {
            title: 'Images',
            extensions: 'gif,jpg,jpeg,bmp,png',
            mimeTypes: 'image/*'
        }
    });
    // 当有文件添加进来的时候
    uploader.on('fileQueued', function (file) {
        var $li = $(
                '<div id="' + file.id + '" class="file-item thumbnail">' +
                '<div class="upload-img-wrap"><input type="hidden" name="'+name+'[]" class="input-image" /><img><span class="upload-delete">×</span></div>' +
                //'<div class="info">' + file.name + '</div>' +
                '</div>'
                ),
                $img = $li.find('img');


        // $list为容器jQuery实例
        $(".upload-wrap").append($li);

        // 创建缩略图
        // 如果为非图片文件，可以不用调用此方法。
        // thumbnailWidth x thumbnailHeight 为 100 x 100
        /*uploader.makeThumb(file, function (error, src) {
         if (error) {
         $img.replaceWith('<span>不能预览</span>');
         return;
         }
         
         $img.attr('src', src);
         }, thumbnailWidth, thumbnailHeight);*/
    });
    // 文件上传过程中创建进度条实时显示。
    uploader.on('uploadProgress', function (file, percentage) {
        var $li = $('#' + file.id),
                $percent = $li.find('.progress span');

        // 避免重复创建
        if (!$percent.length) {
            $percent = $('<p class="progress"><span></span></p>')
                    .appendTo($li)
                    .find('span');
        }

        $percent.css({
            'width': percentage * 100 + '%',
            'background': "red"
        });
    });

    // 文件上传成功，给item添加成功class, 用样式标记上传成功。
    uploader.on('uploadSuccess', function (file, response) {
        $('#' + file.id).addClass('upload-state-done');
        $('#' + file.id).find('img').attr('src', response.domain_url);
        $('#' + file.id).find('.input-image').val(response.url);
    });

    // 文件上传失败，显示上传出错。
    uploader.on('uploadError', function (file) {
        var $li = $('#' + file.id),
                $error = $li.find('div.error');

        // 避免重复创建
        if (!$error.length) {
            $error = $('<div class="error"></div>').appendTo($li);
        }
        $error.text('上传失败');
    });
    uploader.on('error',function(err_no){
       if(err_no == 'Q_EXCEED_NUM_LIMIT'){
           alert('文件上传数量超过限制');
       } 
    });
    // 完成上传完了，成功或者失败，先删除进度条。
    uploader.on('uploadComplete', function (file) {
        $('#' + file.id).find('.progress').remove();
    });
    $(document).on("click", ".upload-delete", function () {
        //$(this).parents(".file-item").remove();
        var id = $(this).parents('.file-item').attr('id');
        var file = uploader.getFile(id);
        console.log(file);
        if(file !== undefined){
            uploader.removeFile(file);
        }
        $('#' + id).remove();
    });
})(jQuery);