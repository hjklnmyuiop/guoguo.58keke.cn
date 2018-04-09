<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = '海花岛游戏-添加用户';
?>
<div class="dux-tools">
    <div class="tools-function clearfix">
        <div class="float-left">
            <a class="button button-small bg-main icon-list" href="<?php echo Url::toRoute(yii::$app->params['url']['user']);?>">用户列表</a>
        </div>
    </div>
</div>
<div class="admin-main">
    <?php echo html::beginForm('', 'Post', array('id' => 'form', 'name'=> 'creator', 'class' => 'form-x dux-form form-auto'));?>
    <div class="panel dux-box  active">
        <div class="panel-head">
            <strong>用户列表->添加</strong>
        </div>
        <div class="panel-body">
            <div class="panel-body">
            <?php echo $this->render('_form', ['model' => $model]);?>                
            </div>
            <div class="panel-foot">
                <div class="form-button">
                    <div id="tips">
                        <?php if(isset($error)) :?>
                            <div class="alert alert-yellow">
                                <strong>注意：</strong>
                            <?php echo $error;?>
                            </div>   
                        <?php endif;?>  
                    </div>
                    <?php echo Html::submitButton('添加', ['class' => 'button bg-main'])?>   
                    <?php echo Html::resetButton('重置', ['class' => 'button bg'])?>
                </div>
            </div> 
            <?php echo html::endForm();?>
        </div>
    </div>
</div>