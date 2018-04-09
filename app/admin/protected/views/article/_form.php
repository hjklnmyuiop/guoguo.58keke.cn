<?php
use yii\helpers\Html;
?>
<?php echo html::beginForm('', 'Post', array('id' => 'form', 'class' => 'form-x dux-form form-auto'));?>
    <div class="panel dux-box  active">
        <div class="panel-head">
            <strong>文章列表-><?= $title?></strong>
        </div>
        <div class="panel-body">
            <div class="panel-body">
                <div class="form-group">
                    <div class="label"><label>栏目</label></div>
                    <div class="field">
                            <select name="Article[cate_id]" id="cate_id" class="input" datatype="*">
                            <option value="0">==请选择==</option>
                            <?php foreach ($parent as $k => $v):?>
                            <option  <?php if (isset($model['cate_id']) && $model['cate_id'] == $v['id'])  echo "selected"?> value="<?php echo isset($v['id']) ? $v['id'] : '';?>">
                            <?php echo isset($v['str_repeat']) ? $v['str_repeat'] : '';?><?php echo isset($v['name']) ? $v['name'] : '';?>
                            </option>
                            <?php endforeach;?>
                            </select>
                        <div class="input-note"></div>  
                    </div>  
                </div>
                <div class="form-group">
                    <div class="label"><label>标题</label></div>
                    <div class="field">
                        <?php echo Html::activeTextInput($model, 'title', ['class' => 'input', 'datatype' => '*', 'size' => 30]);?>  
                        <div class="input-note"></div>      
                    </div>
                </div>  
                <div class="form-group">
                    <div class="label"><label>图片</label></div>
                    <div class="field">
                        <input type="text" class="input" id="image" name="Article[thumb]" size="38" value="<?=isset($model['thumb']) ? $model['thumb'] : ''?>">
                        <a class="button bg-blue button-small  js-img-upload" data="image" id="image_upload" preview="image_preview" href="javascript:;" ><span class="icon-upload"> 上传</span></a>
                        <a class="button bg-blue button-small icon-picture-o" id="image_preview" href="javascript:;" > 预览</a>
                        <div class="input-note"></div>
                    </div>  
                </div>
                
                
                <div class="form-group">
                    <div class="label"><label>排序</label></div>
                    <div class="field">
                        <?php echo Html::activeTextInput($model, 'sort_desc', ['class' => 'input', 'datatype' => '*', 'size' => 30, 'value' => $model['sort_desc']> 0 ? $model['sort_desc'] : 1]);?> 
                        <div class="input-note"></div>
                    </div>  
                </div>

                <div class="form-group">
                    <div class="label"><label>推荐</label></div>
                    <div class="field">
                        <div class="button-group button-group-small radio">
                            <label class="button <?php if($model['commend'] == 0) echo 'active'; ?>"><input name="Article[commend]" value="0"  type="radio" <?php if($model['commend'] == 0) echo 'checked="checked"'; ?> onClick="typechk(this.value)" />
                            <span class="icon icon-check"></span>否</label>
                            <label class="button <?php if($model['commend'] == 1) echo 'active'; ?>"><input name="Article[commend]" value="1" type="radio" <?php if($model['commend'] == 1) echo 'checked="checked"'; ?> onClick="typechk(this.value)" />
                            <span class="icon icon-check"></span>是</label>
                        </div>
                        <div class="input-note"></div>                          
                    </div>
                </div>
                <div class="form-group">
                    <div class="label"><label>是否显示</label></div>
                    <div class="field">
                        <div class="button-group button-group-small radio">
                            <label class="button <?php if($model['status'] == 1) echo 'active'; ?>"><input name="Article[status]" value="1" type="radio" <?php if($model['status'] == 1) echo 'checked="checked"'; ?> onClick="typechk(this.value)" />
                            <span class="icon icon-check"></span>是</label>
                            <label class="button <?php if($model['status'] == 0) echo 'active'; ?>"><input name="Article[status]" value="0"  type="radio" <?php if($model['status'] == 0) echo 'checked="checked"'; ?> onClick="typechk(this.value)" />
                            <span class="icon icon-check"></span>否</label> 
                        </div>
                        <div class="input-note"></div>                          
                    </div>
                </div>
				<div class="form-group">
                    <div class="label"><label>描述</label></div>
                    <div class="field">
                        <?php echo Html::textarea('Article[description]', $model['description'], ['class' => 'input']);?>
                        <div class="input-note"></div>                      
                    </div>                          
                </div>
                <div class="form-group">
                    <div class="label"><label>内容</label></div>
                    <div class="field">
                        <?php echo Html::textarea('Article[content]', $model['content'], ['class' => 'input js-editor','style' => 'width:300px;height:800px;']);?>
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
<script>
    Do.ready('base', function () {
        $('#form').duxFormPage();
    });

</script>