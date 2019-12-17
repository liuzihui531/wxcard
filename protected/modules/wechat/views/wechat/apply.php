<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta id="viewport" name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title></title>
    <meta name="description" content="" />
    <meta content="telephone=no" name="format-detection" />
    <meta content="email=no" name="format-detection" />

    <link rel="stylesheet" href="/static/apply/css/weui.css">

    <style>

    </style>
</head>
<body>


<div class="page">
    <div class="weui-form">

        <div class="weui-form__text-area">
            <h2 class="weui-form__title">会员卡申请</h2>
            <div class="weui-form__desc"></div>
        </div>

        <div class="weui-cells weui-cells_form">

            <div class="weui-cell weui-cell_disabled">
                <div class="weui-cell__hd"><label class="weui-label">昵称</label></div>
                <div class="weui-cell__bd">
                    <input class="weui-input" placeholder="" value="ALways" disabled/>
                </div>
            </div>
            <div class="weui-cell">
                <div class="weui-cell__hd"><label class="weui-label">手机号</label></div>
                <div class="weui-cell__bd">
                    <input class="weui-input" type="number" pattern="[0-9]*" placeholder="请输入手机号" value="" id="phone" />
                </div>
            </div>

            <div class="weui-cell weui-cell_vcode">
                <div class="weui-cell__hd"><label class="weui-label">验证码</label></div>
                <div class="weui-cell__bd">
                    <input   class="weui-input" type="text" pattern="[0-9]*" id="js_input" placeholder="输入验证码" maxlength="6"/>
                </div>
                <div class="weui-cell__ft">
                    <button class="weui-btn_default weui-vcode-btn" style="padding:0 25px;" id="code"  >获取验证码</button>
                </div>

            </div>

            <div class="weui-cell">
                <div class="weui-cell__hd"><label class="weui-label">姓名</label></div>
                <div class="weui-cell__bd">
                    <input class="weui-input" type="number" pattern="[0-9]*" placeholder="请输入手机号" value=""/>
                </div>
            </div>


            <div class="weui-cell weui-cell_access" id="showDatePicker">
                <div class="weui-cell__hd"><label class="weui-label">出生日期</label></div>
                <div class="weui-cell__bd" id="birthday"><strong style="color:#ccc;font-weight: normal;">请选择</strong></div>
                <div class="weui-cell__ft"></div>
            </div>

            <div class="weui-cell weui-cell_access weui-cell_select weui-cell_select-after"  id="showPicker" >
                <div class="weui-cell__hd"><label class="weui-label">性别</label></div>
                <div class="weui-cell__bd" id="gender"><strong style="color:#ccc;font-weight: normal;">请选择</strong></div>
            </div>



        </div>


        <div class="weui-form__tips-area" style="margin-top:30px;">
            <label id="weuiAgree" for="weuiAgreeCheckbox" class="weui-agree">
                <input id="weuiAgreeCheckbox" type="checkbox" class="weui-agree__checkbox"/><span class="weui-agree__text">阅读并同意<a href="javascript:void(0);">《相关条款》</a></span>
            </label>
        </div>

        <a class="weui-btn weui-btn_primary" href="javascript:" id="showTooltips">确定</a>

    </div>

</div>

<div id="toast" style="display: none;">
    <div class="weui-toast" style="width: 50%;height:auto;padding:20px;line-height: 30px;">
        <p class="weui-toast__content">请输入有效的手机号码！</p>
    </div>
</div>

<script type="text/javascript" src="/static/apply/js/zepto.min.js"></script>
<script type="text/javascript" src="/static/apply/js/weui.min.js"></script>
<script>
    $('#showPicker').on('click', function () {
        weui.picker([{
                label: '男',
                value:0
            }, {
                label: '女',
                value:1
            }],
            {
                onConfirm: function (result) {
                    console.log(result[0].label);
                    $("#gender").html(result[0].label)
                },
            });
    });
    $('#showDatePicker').on('click', function () {
        weui.datePicker({
            start: 1990,
            end: new Date().getFullYear(),

            onConfirm: function (result) {
                console.log(result[0].label);
                console.log(result[1].label);
                console.log(result[2].label);
                $("#birthday").html("<span>"+result[0].label+"</span><span>"+result[1].label+"</span><span>"+result[2].label+"</span>")
            },
        });
    });

    $('#code').on('click', function () {

        var phonenum = $("#phone").val();
        var reg = /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/;
        if(!reg.test(phonenum)){

            $('#toast').fadeIn(100);
            setTimeout(function () {
                $('#toast').fadeOut(100);
            }, 2000);

        }else{
            $.post("<?php echo $this->createUrl('/wechat/wechat/getcode') ?>", {mobile:phonenum}, function(data) {
                if (data.code == 200) {
                    setTime($('#code'));
                } else {
                    alert('获取失败');
                }
            }, 'json');

        }

    });

    var countdown = 60;
    function setTime(obj) {
        if (countdown == 0) {
            obj.prop('disabled', false);
            obj.text("获取验证码");
            countdown = 60;//60秒过后button上的文字初始化,计时器初始化;
            return;
        } else {
            obj.prop('disabled', true);
            obj.text("("+countdown+"s)后重新发送") ;
            countdown--;
        }
        setTimeout(function() { setTime(obj) },1000) //每1000毫秒执行一次
    }



</script>
</body>
</html>