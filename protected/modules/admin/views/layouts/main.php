<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title><?php echo Yii::app()->name ?>后台</title>
        <meta name="keywords" content="" />
        <meta name="description" content="" />
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
        <link rel="stylesheet" href="<?php echo Yii::app()->params['host']; ?>/ace/assets/css/ace-skins.min.css" />

        <!--[if lte IE 8]>
          <link rel="stylesheet" href="<?php echo Yii::app()->params['host']; ?>/ace/assets/css/ace-ie.min.css" />
        <![endif]-->

        <link rel="stylesheet" href="<?php echo Yii::app()->params['host']; ?>/static/admin/css/style.css" />
        <!-- inline styles related to this page -->

        <!-- ace settings handler -->

        <script src="<?php echo Yii::app()->params['host']; ?>/ace/assets/js/ace-extra.min.js"></script>

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

        <!--[if lt IE 9]>
        <script src="<?php echo Yii::app()->params['host']; ?>/ace/assets/js/html5shiv.js"></script>
        <script src="<?php echo Yii::app()->params['host']; ?>/ace/assets/js/respond.min.js"></script>
        <![endif]-->
        <!-- basic scripts -->

        <!--[if !IE]> -->

        <script src="<?php echo Yii::app()->params['host']; ?>/ace/static/js/jquery-2.0.3.min.js"></script>

        <!-- <![endif]-->

        <!--[if IE]>
<script src="<?php echo Yii::app()->params['host']; ?>/ace/static/js/jquery-1.10.2.min.js"></script>
<![endif]-->

        <!--[if !IE]> -->

        <script type="text/javascript">
            window.jQuery || document.write("<script src='<?php echo Yii::app()->params['host']; ?>/ace/static/js/jquery-2.0.3.min.js'>" + "<" + "script>");
            var HOST_URL = "<?php echo Yii::app()->params['host']; ?>";
        </script>

        <!-- <![endif]-->

        <!--[if IE]>
<script type="text/javascript">
window.jQuery || document.write("<script src='<?php echo Yii::app()->params['host']; ?>/ace/static/js/jquery-1.10.2.min.js'>"+"<"+"script>");
</script>
<![endif]-->
    </head>

    <body>
        <?php foreach (Yii::app()->user->getFlashes() as $key => $message): ?>
            <div class="alert alert-<?php echo $key ?> alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong><?php echo $key == 'success' ? "正确信息" : "错误信息" ?>:</strong> <?php echo $message ?>
            </div>
        <?php endforeach; ?>
        <div class="navbar navbar-default" id="navbar">
            <script type="text/javascript">
                try {
                    ace.settings.check('navbar', 'fixed')
                } catch (e) {
                }
            </script>

            <div class="navbar-container" id="navbar-container">
                <div class="navbar-header pull-left">
                    <a href="<?php echo $this->createUrl('/admin') ?>" class="navbar-brand">
                        <small>
                            <i class="icon-home"></i>
                            <?php echo Yii::app()->name ?>后台管理系统
                        </small>
                    </a><!-- /.brand -->
                </div><!-- /.navbar-header -->

                <div class="navbar-header pull-right" role="navigation">
                    <ul class="nav ace-nav">
                        <li class="light-blue">
                            <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                                <img class="nav-user-photo" src="<?php echo Yii::app()->params['host']; ?>/ace/assets/avatars/user.jpg" alt="Jason's Photo" />
                                <span class="user-info">
                                    <small>欢迎光临,</small>
                                    <?php echo Yii::app()->user->name ?>
                                </span>

                                <i class="icon-caret-down"></i>
                            </a>

                            <ul class="user-menu pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                                <li>
                                    <a href="#">
                                        <i class="icon-cog"></i>
                                        设置
                                    </a>
                                </li>

                                <li>
                                    <a href="#">
                                        <i class="icon-user"></i>
                                        个人资料
                                    </a>
                                </li>

                                <li class="divider"></li>

                                <li>
                                    <a href="<?php echo $this->createUrl("/admin/login/logout") ?>">
                                        <i class="icon-off"></i>
                                        退出
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul><!-- /.ace-nav -->
                </div><!-- /.navbar-header -->
            </div><!-- /.container -->
        </div>

        <div class="main-container" id="main-container">
            <script type="text/javascript">
                try {
                    ace.settings.check('main-container', 'fixed')
                } catch (e) {
                }
            </script>

            <div class="main-container-inner">
                <a class="menu-toggler" id="menu-toggler" href="#">
                    <span class="menu-text"></span>
                </a>

                <div class="sidebar" id="sidebar">
                    <script type="text/javascript">
                        try {
                            ace.settings.check('sidebar', 'fixed')
                        } catch (e) {
                        }
                    </script>
                    <?php
                    $controller_id = Yii::app()->controller->id;
                    $action_id = Yii::app()->controller->action->id;
                    ?>
                    <ul class="nav nav-list">
                        <li class="active">
                            <a href="<?php echo $this->createUrl('/admin') ?>">
                                <i class="icon-dashboard"></i>
                                <span class="menu-text"> 控制台 </span>
                            </a>

                        </li>
                        <li <?php if (in_array($controller_id, array('news_category', 'news'))): ?>class="active open"<?php endif; ?>>
                            <a href="#" class="dropdown-toggle">
                                <i class="icon-edit"></i>
                                <span class="menu-text"> 新闻资讯 </span>

                                <b class="arrow icon-angle-down"></b>
                            </a>

                            <ul class="submenu">
                                <li <?php if ($controller_id == 'news_category'): ?>class="active"<?php endif; ?>>
                                    <a <?php if ($controller_id == 'news_category'): ?>class="active"<?php endif; ?> href="<?php echo $this->createUrl('/admin/news_category') ?>">
                                        <i class="icon-double-angle-right"></i>
                                        分类管理
                                    </a>
                                </li>

                                <li <?php if ($controller_id == 'news'): ?>class="active"<?php endif; ?>>
                                    <a <?php if ($controller_id == 'news'): ?>class="active"<?php endif; ?> href="<?php echo $this->createUrl('/admin/news') ?>">
                                        <i class="icon-double-angle-right"></i>
                                        资讯管理
                                    </a>
                                </li>
                            </ul>
                        </li>

                    </ul><!-- /.nav-list -->

                    <div class="sidebar-collapse" id="sidebar-collapse">
                        <i class="icon-double-angle-left" data-icon1="icon-double-angle-left" data-icon2="icon-double-angle-right"></i>
                    </div>

                    <script type="text/javascript">
                        try {
                            ace.settings.check('sidebar', 'collapsed')
                        } catch (e) {
                        }
                    </script>
                </div>

                <div class="main-content">
                    <div class="breadcrumbs" id="breadcrumbs">
                        <script type="text/javascript">
                            try {
                                ace.settings.check('breadcrumbs', 'fixed')
                            } catch (e) {
                            }
                        </script>

                        <ul class="breadcrumb"><!--面包屑-->
                            <?php $this->widget('zii.widgets.CBreadcrumbs', array('links' => $this->breadcrumbs, 'homeLink' => CHtml::link('管理中心', $this->createUrl('/admin/')),)); ?>
                        </ul><!-- .breadcrumb -->

                        <div class="nav-search" id="nav-search">
                            <form class="form-search">
                                <span class="input-icon">
                                    <input type="text" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off" />
                                    <i class="icon-search nav-search-icon"></i>
                                </span>
                            </form>
                        </div><!-- #nav-search -->
                    </div>

                    <div class="page-content">
                        <div class="row">
                            <div class="col-xs-12">
                                <?php echo $content; ?>
                            </div>
                        </div>
                    </div><!-- /.page-content -->
                </div><!-- /.main-content -->

                <div class="ace-settings-container" id="ace-settings-container">
                    <div class="btn btn-app btn-xs btn-warning ace-settings-btn" id="ace-settings-btn">
                        <i class="icon-cog bigger-150"></i>
                    </div>

                    <div class="ace-settings-box" id="ace-settings-box">
                        <div>
                            <div class="pull-left">
                                <select id="skin-colorpicker" class="hide">
                                    <option data-skin="default" value="#438EB9">#438EB9</option>
                                    <option data-skin="skin-1" value="#222A2D">#222A2D</option>
                                    <option data-skin="skin-2" value="#C6487E">#C6487E</option>
                                    <option data-skin="skin-3" value="#D0D0D0">#D0D0D0</option>
                                </select>
                            </div>
                            <span>&nbsp; 选择皮肤</span>
                        </div>

                        <div>
                            <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-navbar" />
                            <label class="lbl" for="ace-settings-navbar"> 固定导航条</label>
                        </div>

                        <div>
                            <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-sidebar" />
                            <label class="lbl" for="ace-settings-sidebar"> 固定滑动条</label>
                        </div>

                        <div>
                            <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-breadcrumbs" />
                            <label class="lbl" for="ace-settings-breadcrumbs">固定面包屑</label>
                        </div>

                        <div>
                            <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-rtl" />
                            <label class="lbl" for="ace-settings-rtl">切换到左边</label>
                        </div>

                        <div>
                            <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-add-container" />
                            <label class="lbl" for="ace-settings-add-container">
                                切换窄屏
                                <b></b>
                            </label>
                        </div>
                    </div>
                </div><!-- /#ace-settings-container -->
            </div><!-- /.main-container-inner -->

            <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
                <i class="icon-double-angle-up icon-only bigger-110"></i>
            </a>
        </div><!-- /.main-container -->



        <script type="text/javascript">
            if ("ontouchend" in document)
                document.write("<script src='<?php echo Yii::app()->params['host']; ?>/ace/assets/js/jquery.mobile.custom.min.js'>" + "<" + "script>");
        </script>
        <script src="<?php echo Yii::app()->params['host']; ?>/ace/assets/js/jquery.dataTables.min.js"></script>
        <script src="<?php echo Yii::app()->params['host']; ?>/ace/assets/js/bootstrap.min.js"></script>
        <script src="<?php echo Yii::app()->params['host']; ?>/ace/assets/js/typeahead-bs2.min.js"></script>

        <!-- page specific plugin scripts -->

        <!--[if lte IE 8]>
          <script src="<?php echo Yii::app()->params['host']; ?>/ace/assets/js/excanvas.min.js"></script>
        <![endif]-->

        <script src="<?php echo Yii::app()->params['host']; ?>/ace/assets/js/jquery-ui-1.10.3.custom.min.js"></script>
        <script src="<?php echo Yii::app()->params['host']; ?>/ace/assets/js/jquery.ui.touch-punch.min.js"></script>
        <script src="<?php echo Yii::app()->params['host']; ?>/ace/assets/js/jquery.slimscroll.min.js"></script>
        <script src="<?php echo Yii::app()->params['host']; ?>/ace/assets/js/jquery.easy-pie-chart.min.js"></script>
        <script src="<?php echo Yii::app()->params['host']; ?>/ace/assets/js/jquery.sparkline.min.js"></script>

        <!-- ace scripts -->

        <script src="<?php echo Yii::app()->params['host']; ?>/ace/assets/js/ace-elements.min.js"></script>
        <script src="<?php echo Yii::app()->params['host']; ?>/ace/assets/js/ace.min.js"></script>

        <!-- inline scripts related to this page -->
        <script src="<?php echo Yii::app()->params['host']; ?>/static/admin/js/ace.js"></script>
        <script src="<?php echo Yii::app()->params['host']; ?>/static/admin/js/common.js"></script>
        <!--laydate日期插件-->
        <script type="text/javascript" src="/static/laydate/laydate.js"></script>
        <?php if ($this->is_ueditor)://用到编辑器 ?>
            <script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->params['host']; ?>/static/ueditor/ueditor.config.js"></script>
            <script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->params['host']; ?>/static/ueditor/ueditor.all.min.js"></script>
            <script type="text/javascript" src="<?php echo Yii::app()->params['host']; ?>/static/ueditor/lang/zh-cn/zh-cn.js"></script>
            <!-- 实例化编辑器 -->
            <script src="<?php echo Yii::app()->params['host']; ?>/static/admin/js/ueditor.js"></script>
        <?php endif; ?>
        <?php if ($this->is_upload)://用到编辑器 ?>
            <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->params['host']; ?>/static/webuploader/css/webuploader.css" />
            <script type="text/javascript" src="<?php echo Yii::app()->params['host']; ?>/static/webuploader/dist/webuploader.js"></script>
            <script type="text/javascript" src="<?php echo Yii::app()->params['host']; ?>/static/admin/js/upload.js"></script>
        <?php endif ?>
    </body>
</html>

