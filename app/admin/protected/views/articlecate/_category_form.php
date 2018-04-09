<?php
use yii\helpers\Html;
?>
<?php echo html::beginForm('', 'Post', array('id' => 'form', 'class' => 'form-x dux-form form-auto'));?>
    <div class="panel dux-box  active">
        <div class="panel-head">
            <strong>栏目分类-><?= $title?></strong>
        </div>
        <div class="panel-body">
            <div class="panel-body">
                <div class="form-group">
                    <div class="label"><label>父分类ID</label></div>
                    <div class="field">
                            <select name="ArticleCate[pid]" id="pid" class="input">
                            <option value="0">==请选择==</option>
                            <?php foreach ($parent as $k => $v):?>
                            <option  <?php if (isset($model['pid']) && $model['pid'] == $v['id']) echo "selected"?> value="<?php echo isset($v['id']) ? $v['id'] : '';?>">
                            <?php echo isset($v['str_repeat']) ? $v['str_repeat'] : '';?><?php echo isset($v['name']) ? $v['name'] : '';?>
                            </option>
                            <?php endforeach;?>
                            </select>
                        <div class="input-note"></div>  
                    </div>  
                </div>
                <div class="form-group">
                    <div class="label"><label>分类名称</label></div>
                    <div class="field">
                        <?php echo Html::activeTextInput($model, 'name', ['class' => 'input', 'datatype' => '*', 'size' => 30]);?>  
                        <div class="input-note"></div>      
                    </div>
                </div>  
                <div class="form-group">
                    <div class="label"><label>排序</label></div>
                    <div class="field">
                        <?php echo Html::activeTextInput($model, 'order', ['class' => 'input', 'datatype' => '*', 'size' => 30]);?> 
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
                    <?php echo Html::submitButton('提交', ['class' => 'button bg-main'])?>   
                    <?php echo Html::resetButton('重置', ['class' => 'button bg'])?>
                </div>
            </div>
        </div>
    </div>
<?php echo html::endForm();?>