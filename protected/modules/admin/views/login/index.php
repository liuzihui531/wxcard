<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>后台登录</title>
        <meta name="keywords" content="Bootstrap模版,Bootstrap模版下载,Bootstrap教程,Bootstrap中文" />
        <meta name="description" content="站长素材提供Bootstrap模版,Bootstrap教程,Bootstrap中文翻译等相关Bootstrap插件下载" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <!-- basic styles -->

        <link href="<?php echo Yii::app()->params['host']; ?>/ace/assets/css/bootstrap.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="<?php echo Yii::app()->params['host']; ?>/ace/assets/css/font-awesome.min.css" />

        <!--[if IE 7]>
          <link rel="stylesheet" href="<?php echo Yii::app()->params['host']; ?>/ace/assets/css/font-awesome-ie7.min.css" />
        <![endif]-->

        <!-- page specific plugin styles -->

        <!-- fonts -->

        <link rel="stylesheet" href="<?php echo Yii::app()->params['host']; ?>/ace/static/css/css.css" />

        <!-- ace styles -->

        <link rel="stylesheet" href="<?php echo Yii::app()->params['host']; ?>/ace/assets/css/ace.min.css" />
        <link rel="stylesheet" href="<?php echo Yii::app()->params['host']; ?>/ace/assets/css/ace-rtl.min.css" />
        <link rel="stylesheet" href="<?php echo Yii::app()->params['host']; ?>/static/admin/css/style.css" />

        <!--[if lte IE 8]>
          <link rel="stylesheet" href="<?php echo Yii::app()->params['host']; ?>/ace/assets/css/ace-ie.min.css" />
        <![endif]-->

        <!-- inline styles related to this page -->

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

        <!--[if lt IE 9]>
        <script src="<?php echo Yii::app()->params['host']; ?>/ace/assets/js/html5shiv.js"></script>
        <script src="<?php echo Yii::app()->params['host']; ?>/ace/assets/js/respond.min.js"></script>
        <![endif]-->
    </head>

    <body class="login-layout">
        <div class="main-container">
            <div class="main-content">
                <div class="row">
                    <div class="col-sm-10 col-sm-offset-1">
                        <div class="login-container">
                            <div class="center">
                                <h1>
                                    <span class="white"><?php echo Yii::app()->name ?>后台管理登录</span>
                                </h1>
                            </div>

                            <div class="space-6"></div>

                            <div class="position-relative clearfix">
                                <div id="login-box" class="login-box visible widget-box no-border" style="position:static">
                                    <div class="widget-body">
                                        <div class="widget-main">
                                            <h4 class="header blue lighter bigger">
                                                <i class="icon-coffee green"></i>
                                                请输入您的信息
                                            </h4>

                                            <div class="space-6"></div>

                                            <form method="post" id="login-form">
                                                <fieldset>
                                                    <label class="block clearfix">
                                                        <span class="block input-icon input-icon-right">
                                                            <input type="text" name="LoginForm[username]" class="form-control" placeholder="请输入用户名" />
                                                            <i class="icon-user"></i>
                                                        </span>
                                                    </label>

                                                    <label class="block clearfix">
                                                        <span class="block input-icon input-icon-right">
                                                            <input type="password" name="LoginForm[password]" class="form-control" placeholder="请输入密码" />
                                                            <i class="icon-lock"></i>
                                                        </span>
                                                    </label>

                                                    <div class="space"></div>

                                                    <div class="clearfix">

                                                        <button type="button" style="width:100%" id="login" class="pull-right btn btn-sm btn-primary">
                                                            <i class="icon-key"></i>
                                                            登录
                                                        </button>
                                                    </div>

                                                    <div class="space-4"></div>
                                                </fieldset>
                                            </form>
                                        </div><!-- /widget-main -->
                                    </div><!-- /widget-body -->
                                </div><!-- /login-box -->
                            </div><!-- /position-relative -->
                        </div>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div>
        </div><!-- /.main-container -->

        <!-- basic scripts -->

        <!--[if !IE]> -->

        <script src="<?php echo Yii::app()->params['host']; ?>/ace/assets/js/jquery-2.0.3.min.js"></script>

        <!-- <![endif]-->

        <!--[if IE]>
<script src="<?php echo Yii::app()->params['host']; ?>/ace/assets/js/jquery-1.10.2.min.js"></script>
<![endif]-->

        <!--[if !IE]> -->

        <script type="text/javascript">
            window.jQuery || document.write("<script src='<?php echo Yii::app()->params['host']; ?>/ace/assets/js/jquery-2.0.3.min.js'>" + "<" + "/script>");
        </script>

        <!-- <![endif]-->

        <!--[if IE]>
<script type="text/javascript">
window.jQuery || document.write("<script src='<?php echo Yii::app()->params['host']; ?>/ace/assets/js/jquery-1.10.2.min.js'>"+"<"+"/script>");
</script>
<![endif]-->

        <script type="text/javascript">
            if ("ontouchend" in document)
                document.write("<script src='<?php echo Yii::app()->params['host']; ?>/ace/assets/js/jquery.mobile.custom.min.js'>" + "<" + "/script>");
        </script>

        <!-- inline scripts related to this page -->

        <script type="text/javascript">
            function show_box(id) {
                jQuery('.widget-box.visible').removeClass('visible');
                jQuery('#' + id).addClass('visible');
            }
        </script>
        <script src="<?php echo Yii::app()->params['host']; ?>/static/admin/js/common.js"></script>
        <?php foreach (Yii::app()->user->getFlashes() as $key => $message): ?>
            <div class="alert alert-<?php echo $key ?> alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong><?php echo $key == 'success' ? "正确信息：" : "错误信息：" ?>:</strong> <?php echo $message ?>
            </div>
        <?php endforeach; ?>
    </body>
</html>
