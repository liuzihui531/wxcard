$(function () {
    $(document).on("click", $(".close[aria-label='Close']"), function () {
        $(this).parent(".alert").fadeOut('slow');
    });
    setTimeout(function () {
        $(".alert").fadeOut('slow');
    }, 2000);
    //登录方法
    $("#login").bind('click', function () {
        $.post(document.URL, $("#login-form").serialize(), function (data) {
            if (data.sta == 1) {
                window.location.href = data.url;
            } else {
                alert_msg(data);
            }
        }, 'json');
    });
    //表单提交通用
    $("#submit").bind('click', function () {
        var url = $("#id-form").attr("action");
        $.post(url, $("#id-form").serialize(), function (data) {
            alert_msg(data);
        }, 'json');
    });
    //删除多个通用
    $(".delete").bind('click', function () {
        if (!window.confirm('您确定删除所选吗？')) {
            return;
        }
        var params = {};
        $.each($("tbody tr"), function (k, v) {
            var val = $(v).find(".delete-id:checked").val();
            if (typeof (val) != undefined) {
                params["id[" + k + "]"] = val;
            }
        });
        var url = $(this).attr('data-url');
        $.get(url, params, function (data) {
            alert_msg(data);
        }, 'json');
    });
    //删除单个通用
    $(".delete-single").bind('click', function () {
        if (!window.confirm('您确定删除所选吗？')) {
            return;
        }
        var url = $(this).attr('data-url');
        $.get(url, {}, function (data) {
            alert_msg(data);
        }, 'json');
    });
});
//给ajax返回的
function alert_msg(data) {
    if (data.sta == 1) {
        window.location.href = data.url;
        return;
    }
    var status = data.sta > 0 ? "success" : "danger";
    var message_head = data.sta > 0 ? "正确信息：" : "错误信息：";
    var redirect_text = data.sta > 0 ? ",正在跳转..." : "";
    var html = '<div class="alert alert-' + status + ' alert-dismissible" role="alert">\n\
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>\n\
        <strong>' + message_head + '</strong> ' + data.msg + redirect_text + '</div>';
    $("body").append(html);
    setTimeout(function () {
        $(".alert").fadeOut('slow');
    }, 2000);
}

