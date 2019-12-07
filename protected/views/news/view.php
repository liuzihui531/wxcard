<style type="text/css">
    .main-news-view{background: white}
    body{color:black;line-height:1em}
</style>
<div class="main main-news-view">
    <div class="title"><?php echo $model->title; ?></div>
    <div class="content"><?php echo Utils::deSlashes($model->content); ?></div>
</div>