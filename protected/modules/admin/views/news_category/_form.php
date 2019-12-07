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
    <?php echo $form->labelEx($model, 'name', array('class' => 'col-sm-3 control-label no-padding-right')) ?>

    <div class="col-sm-9">
        <?php echo $form->textField($model, 'name', array('class' => 'col-xs-10 col-sm-5', 'placeholder' => '')) ?>
    </div>
</div>
<div class="form-group">
    <?php echo $form->labelEx($model, 'sort', array('class' => 'col-sm-3 control-label no-padding-right')) ?>

    <div class="col-sm-9">
        <?php echo $form->textField($model, 'sort', array('class' => 'col-xs-10 col-sm-4', 'placeholder' => '')) ?>
        &nbsp;数字越小越排前
    </div>
</div>
<div class="form-group">
    <?php echo $form->labelEx($model, 'seo_title', array('class' => 'col-sm-3 control-label no-padding-right')) ?>

    <div class="col-sm-9">
        <?php echo $form->textField($model, 'seo_title', array('class' => 'col-xs-10 col-sm-4', 'placeholder' => '')) ?>
        &nbsp;不填则为分类名称
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
        &nbsp;不填则为首页描述
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