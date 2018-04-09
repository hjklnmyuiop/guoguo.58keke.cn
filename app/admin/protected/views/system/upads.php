<?php
use yii\helpers\Url;
$this->title = '环球石材管理系统-修改广告';
?>
<div class="dux-tools">
    <div class="tools-function clearfix">
        <div class="float-left">
            <a class="button button-small bg-main icon-list" href="<?php echo Url::toRoute(yii::$app->params['url']['ads']);?>">广告</a>
        </div>
    </div>
</div>
<div class="admin-main">
    <?php echo $this->render('_ad_form', ['title' => '修改', 'model' => $model]); ?>
</div>
    