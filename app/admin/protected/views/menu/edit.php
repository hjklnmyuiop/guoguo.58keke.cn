<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = '海花岛游戏-修改菜单';
?>
<div class="dux-tools">
    <div class="tools-function clearfix">
        <div class="float-left">
            <a class="button button-small bg-main icon-list" href="<?php echo Url::toRoute(yii::$app->params['url']['menu']);?>">菜单列表</a>
        </div>
    </div>
</div>
<div class="admin-main">
    <?php echo html::beginForm('', 'Post', array('id' => 'form', 'class' => 'form-x dux-form form-auto'));?>
    <div class="panel dux-box  active">
        <div class="panel-head">
            <strong>当前位置：管理员列表&nbsp;&gt;&nbsp;修改管理员</strong>
        </div>
        <div class="panel-body">
            <div class="panel-body">
                <div class="form-group">
                    <div class="label"><label>父菜单：</label></div>
                    <div class="field">
                        <?php echo Html::activeDropDownList($model, 'pid', $power, ['prompt' => '请选择分类','class' => 'input js-assign'], ['size' => 30]);?>
                        <div class="input-note"></div>  
                    </div>  
                </div>
                <div class="form-group">
                    <div class="label"><label>菜单名称：</label></div>
                    <div class="field">
                        <?php echo Html::activeTextInput($model, 'name', ['class' => 'input', 'size' => 30, 'datatype' => '*']);?>      
                    </div>
                </div>  
                <div class="form-group">
                    <div class="label"><label>ICON：</label></div>
                    <div class="field">
                        <?php echo Html::activeTextInput($model, 'icon', ['class' => 'input', 'size' => 30]);?>
                        <div class="input-note"></div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="label"><label>URL：</label></div>
                    <div class="field">
                        <?php echo Html::activeTextInput($model, 'url', ['class' => 'input', 'size' => 30, 'datatype' => '*']);?>
                        <div class="input-note"></div>
                    </div>  
                </div>
                <div class="form-group">
                    <div class="label"><label>排序：</label></div>
                    <div class="field">
                        <?php echo Html::activeTextInput($model, 'order', ['class' => 'input', 'size' => 30]);?>
                        <div class="input-note"></div>                      
                    </div>                          
                </div>
                
                <div class="form-group">
                    <div class="label"><label>是否显示：</label></div>
                    <div class="button-group button-group-small radio">
                        <label class="button <?php if($model['is_show'] == 1): ?>active <?php endif; ?>"><input name="Power[is_show]" value="1"  <?php if($model['is_show'] == 1): ?>checked="checked" <?php endif; ?> type="radio">
                        <span class="icon icon-check"></span>是</label>
                        <label class="button <?php if($model['is_show'] == 0): ?>active <?php endif; ?>"><input name="Power[is_show]" value="0" type="radio" <?php if($model['is_show'] == 0): ?>checked="checked" <?php endif; ?>>
                        <span class="icon icon-times"></span> 否</label>
                    </div>
                    <div class="field">
                        <?php //echo Html::activeRadioList($model, 'menu', [0 => '否', 1 => '是'], ['class' => 'input', 'size' => 30]);?>
                        <div class="input-note"></div>                          
                    </div>
                </div>

                <div class="form-group">
                    <div class="label"><label>状态：</label></div>
                    <div class="button-group button-group-small radio">
                        <label class="button <?php if($model['state'] == 1): ?>active <?php endif; ?>"><input name="Power[state]" value="1" <?php if($model['state'] == 1): ?>checked="checked" <?php endif; ?> type="radio">
                        <span class="icon icon-check"></span> 可用</label>
                        <label class="button <?php if($model['state'] == 0): ?>active <?php endif; ?>"><input name="Power[state]" value="0" type="radio" <?php if($model['state'] == 0): ?>checked="checked" <?php endif; ?>>
                        <span class="icon icon-times"></span> 不可用</label>
                    </div>
                    <div class="field">
                        <?php //echo Html::activeRadioList($model, 'state', [0 => '不可用', 1 => '可用'], ['class' => 'input', 'size' => 30]);?>
                        <div class="input-note"></div>                          
                    </div>
                </div>

                <div class="form-group">
                    <div class="label"><label>是否默认菜单：</label></div>
                    <div class="button-group button-group-small radio">
                        <label class="button <?php if($model['isdefault'] == 1): ?>active <?php endif; ?>"><input name="Power[isdefault]" value="1"  type="radio" <?php if($model['isdefault'] == 1): ?>checked="checked" <?php endif; ?>>
                        <span class="icon icon-check"></span>是</label>
                        <label class="button <?php if($model['isdefault'] == 0): ?>active <?php endif; ?>"><input name="Power[isdefault]" value="0" type="radio" <?php if($model['isdefault'] == 0): ?>checked="checked" <?php endif; ?>>
                        <span class="icon icon-times"></span> 否</label>
                    </div>
                    <div class="field">
                        <?php //echo Html::activeRadioList($model, 'state', [0 => '不可用', 1 => '可用'], ['class' => 'input', 'size' => 30]);?>
                        <div class="input-note"></div>                          
                    </div>
                </div>

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
                    <?php echo Html::submitButton('修改', ['class' => 'button bg-main'])?>   
                    <?php echo Html::resetButton('重置', ['class' => 'button bg'])?>
                </div>
            </div>
            <?php echo html::endForm();?>
        </div>
    </div>
</div>
<script>
    Do.ready('base', function () {
        $('#form').duxFormPage();
    });
</script>   