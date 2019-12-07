<div class="main main-news">
    <div class="slide pc-show">
        <div class="news-cate-list">
            <ul class="clearfix">
                <?php $cate_id = Yii::app()->request->getParam('cate_id', 1);
                $new_model_instance = News::model(); ?>
                <?php foreach ($new_model_instance->getCateKv() as $k => $v): ?>
                    <li class="<?php if ($cate_id == $k): ?> active <?php endif; ?>"><a href="<?php echo $this->createUrl("/news/index", array('cate_id' => $k)) ?>"><?php echo $v; ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <div class="phone-slide phone-show">
        <div class="news-cate-list">
            <ul class="clearfix">
                <?php $cate_id = Yii::app()->request->getParam('cate_id', 1);
                $new_model_instance = News::model(); ?>
                <?php foreach ($cate_list as $k => $v): ?>
                    <li class="<?php if ($cate_id == $k): ?> active <?php endif; ?>"><span class="to-location" data-url="<?php echo $this->createUrl("/news/index", array('cate_id' => $k)) ?>"><?php echo $v; ?></span></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <div class="news-body clearfix pc-show">
        <div class="right">
            <div class="hot-nav">热点资讯</div>
            <div class="hot-body">
                <?php foreach ($hot as $k => $v): ?>
                    <dl class="clearfix"> 
                        <dt><a href="<?php echo $this->createUrl('view', array('id' => $v->id)) ?>"><img src="<?php  echo Utils::getImageUrl($v->image,true) ?>" /></a></dt>
                        <dd>
                            <p class="summary"><?php echo Utils::cutString($v->summary, 30); ?></p>
                            <p class="fenlei"><a href="<?php echo $this->createUrl('/news/index', array('cate_id' => $v->cate_id)) ?>">[<?php echo $new_model_instance->getCateKv($v->cate_id) ?>]</a></p>
                        </dd>
                    </dl>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="left">
                <?php foreach ($model as $k => $v): ?>
                    <dl class="clearfix">
                        <dt>
                            <a href="<?php echo $this->createUrl('view', array('id' => $v->id)) ?>"><img src="<?php echo Utils::getImageUrl($v->image,true) ?>" /></a>
                        </dt>
                        <dd>
                            <p class="title"><a href="<?php echo $this->createUrl('view', array('id' => $v->id)) ?>"><?php echo $v->title ?></a></p>
                            <p class="fenlei">分类：<a href="<?php echo $this->createUrl('/news/index', array('cate_id' => $v->cate_id)) ?>"><?php echo $new_model_instance->getCateKv($v->cate_id) ?></a></p>
                            <p class="summary"><?php echo Utils::cutString($v->summary, 100); ?></p>
                            <p class="information clearfix"><span class="views"><?php echo $v->view_count ?></span><span class="add-time"><?php echo date('Y-m-d H:i:s', $v->create_time) ?></span></p>
                        </dd>
                    </dl>
                <?php endforeach; ?>
        </div>
    </div>
    <div class="phone-news-body clearfix phone-show">
        <div class="right">
            <div class="hot-nav">热点资讯</div>
            <div class="hot-body">
                <?php foreach ($hot as $k => $v): ?>
                    <dl class="clearfix">
                        <dt><a href="<?php echo $this->createUrl('view', array('id' => $v->id)) ?>"><img src="<?php echo Utils::getImageUrl($v->image,true) ?>" /></a></dt>
                        <dd>
                            <p class="fenlei">分类：<a href="<?php echo $this->createUrl('/news/index', array('cate_id' => $v->cate_id)) ?>">[<?php echo $new_model_instance->getCateKv($v->cate_id) ?>]</a></p>
                        </dd>
                    </dl>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="left">
                <?php foreach ($model as $k => $v): ?>
                    <dl class="clearfix">
                        <dt>
                            <a href="<?php echo $this->createUrl('view', array('id' => $v->id)) ?>"><img src="<?php echo Utils::getImageUrl($v->image,true) ?>" /></a>
                        </dt>
                        <dd>
                            <p class="summary"><?php echo Utils::cutString($v->summary, 50); ?></p>
                            <p class="information clearfix">
                                <span class="fenlei"><a href="<?php echo $this->createUrl('/news/index', array('cate_id' => $v->cate_id)) ?>"><?php echo $new_model_instance->getCateKv($v->cate_id) ?></a></span>
                                <span class="views"><?php echo $v->view_count ?></span></p>
                        </dd>
                    </dl>
                <?php endforeach; ?>
        </div>
    </div>
</div>
<script type="text/javascript">
    var actived = $(".news-cate-list ul li.active").index();
    $(".news-cate-list ul li").hover(function () {
        $(this).removeClass('active').addClass('active').siblings("li").removeClass('active');
    });
    $(".news-cate-list").on('mouseleave', function () {
        $(".news-cate-list ul li").removeClass('active');
        $(".news-cate-list ul li:eq(" + actived + ")").addClass('active');
    });
</script>
