<?php
use yii\helpers\Url;
$this->title = '环球石材管理系统-修改文章';
?>
<div class="dux-tools">
    <div class="tools-function clearfix">
        <div class="float-left">
            <a class="button button-small bg-main icon-list" href="<?php echo Url::toRoute(yii::$app->params['url']['article']);?>">文章列表</a>
        </div>
    </div>
</div>
<div class="admin-main">
    <?php echo $this->render('_form', ['title' => '修改', 'model' => $model, 'parent' => $parent]); ?>
</div>
    