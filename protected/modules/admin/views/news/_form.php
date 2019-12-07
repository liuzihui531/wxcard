<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'id-form',
    'action' => $this->createUrl('save'),
    'htmlOptions' => array(
        'class' => 'form-horizontal',
        'role' => 'form',
    ),
        ));
?>
<?php if ($model->id): ?>
    <input type="hidden" name="id" value="<?php echo $model->id ?>" />
<?php endif; ?>
<div class="form-group">
    <?php echo $form->labelEx($model, 'title', array('class' => 'col-sm-3 control-label no-padding-right')) ?>

    <div class="col-sm-9">
        <?php echo $form->textField($model, 'title', array('class' => 'col-xs-10 col-sm-5', 'placeholder' => '')) ?>
    </div>
</div>
<div class="form-group">
    <?php echo $form->labelEx($model, 'cate_id', array('class' => 'col-sm-3 control-label no-padding-right')) ?>

    <div class="col-sm-9">
        <?php echo $form->dropDownList($model, 'cate_id', News::model()->getCateKv(), array('class' => 'col-xs-10 col-sm-5', 'prompt' => '--请选择分类--')) ?>
    </div>
</div>
<div class="form-group">
    <?php echo $form->labelEx($model, 'summary', array('class' => 'col-sm-3 control-label no-padding-right')) ?>

    <div class="col-sm-9">
        <?php echo $form->textarea($model, 'summary', array('class' => 'col-xs-10 col-sm-5 h140', 'placeholder' => '')) ?>
    </div>
</div>
<div class="form-group">
    <?php echo $form->labelEx($model, 'is_hot', array('class' => 'col-sm-3 control-label no-padding-right')) ?>
    &nbsp;
    <label>
        <?php echo $form->checkBox($model, 'is_hot', array('class' => 'ace ace-switch ace-switch-5')) ?>
        <span class="lbl"></span>
    </label>
</div>
<div class="form-group">
    <?php echo $form->labelEx($model, 'content', array('class' => 'col-sm-3 control-label no-padding-right')) ?>
    <div class="col-sm-9">
        <script id="container" name="News[content]" type="text/plain" data-width="1200"><?php echo $model->content; ?></script>
    </div>
</div>
<div class="form-group">
    <?php echo $form->labelEx($model, 'image', array('class' => 'col-sm-3 control-label no-padding-right')) ?>
    <div class="col-sm-9">
        <div id="uploader-demo">
            <!--用来存放item-->
            <div id="fileList" class="uploader-list"></div>
            <div id="filePicker" data-name="image" data-file-num="2">选择图片</div>
        </div>
        <div class="upload-wrap">
            <?php if ($model->image): ?>
                <?php foreach (explode(",", $model->image) as $k => $v): ?>
                    <div id="WU_FILE2_<?php echo $k ?>" class="file-item thumbnail upload-state-done"><div class="upload-img-wrap">
                            <input type="hidden" name="image[]" class="input-image" value="<?php echo $v; ?>">
                            <img src="<?php echo Utils::getImageUrl($v, true); ?>">
                            <span class="upload-delete">×</span></div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<div class="form-group">
    <?php echo $form->labelEx($model, 'seo_title', array('class' => 'col-sm-3 control-label no-padding-right')) ?>

    <div class="col-sm-9">
        <?php echo $form->textField($model, 'seo_title', array('class' => 'col-xs-10 col-sm-4', 'placeholder' => '')) ?>
        &nbsp;不填则为资讯标题
    </div>
</div>
<div class="form-group">
    <?php echo $form->labelEx($model, 'seo_keyword', array('class' => 'col-sm-3 control-label no-padding-right')) ?>

    <div class="col-sm-9">
        <?php echo $form->textField($model, 'seo_keyword', array('class' => 'col-xs-10 col-sm-4', 'placeholder' => '')) ?>
        &nbsp;不填则为首页关键词
    </div>
</div>
<div class="form-group">
    <?php echo $form->labelEx($model, 'seo_description', array('class' => 'col-sm-3 control-label no-padding-right')) ?>

    <div class="col-sm-9">
        <?php echo $form->textarea($model, 'seo_description', array('class' => 'col-xs-10 col-sm-4 h140', 'placeholder' => '')) ?>
        &nbsp;不填则为摘要内容
    </div>
</div>
<div class="clearfix form-actions">
    <div class="col-md-offset-3 col-md-9">
        <button class="btn btn-info" type="button" id="submit">
            <i class="icon-ok bigger-110"></i>
            提交
        </button>

        &nbsp; &nbsp; &nbsp;
        <button class="btn" type="reset">
            <i class="icon-undo bigger-110"></i>
            重置
        </button>
    </div>
</div>
<?php $this->endWidget(); ?>