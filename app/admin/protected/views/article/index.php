<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\helpers\Url;

$this->title = '环球石材管理系统-文章列表';
?>
<div class="dux-tools">
	<div class="tools-function clearfix">
		<div class="float-left">
			<a class="button button-small bg-main icon-list" href="">文章列表</a>
		</div>
		<div class="button-group float-right">
			<a class="button button-small bg-dot icon-plus dropdown-toggle" href="<?php echo Url::toRoute(yii::$app->params['url']['addArticle']);?>">发布</a> 
		</div>
	</div>
</div>
<div class="admin-main">
    <div class="panel dux-box">
    <div class="table-tools clearfix">
        <div class="float-left">
			<?php echo html::beginForm(Url::toRoute(yii::$app->params['url']['article']), 'GET');?>
                <div class="form-inline">
					 <div class="form-group">搜索： </div>
					 <div class="form-group">
                        <div class="field">
                             <select class="input" name="search[type]" id="class_id">
                              <option value=>请选择</option>
                              <?php if(!empty($search) && is_array($search)) :?>
                              <?php foreach($search as $k=>$v):?>
                              <option value="<?= Html::encode($k)?>" <?php if(isset($searchvalue['type']) && $searchvalue['type']==$k){?> selected="selected"<?php }?>><?= Html::encode($v)?></option>
                              <?php endforeach;?>
                              <?php endif;?>
                         </select>
                        </div>
                    </div>
					<div class="form-group" style="margin-left: 10px;">
                        <div class="field">
                            <input type="text" class="input" id="keyword" name="search[keyword]" size="20" value="<?=isset($searchvalue['keyword'])?$searchvalue['keyword']:''?>" placeholder="关键词">
                        </div>
                    </div>
                    <div class="form-group">栏目： </div>
                    <div class="form-group" style="margin-left: 10px;">
                        <div class="field">
                            <select name="search[cate_id]" id="cate_id" class="input">
                            <option value="0">==请选择==</option>
                            <?php foreach ($category as $k => $v):?>
                            <option <?php if (isset($searchvalue['cate_id']) && $searchvalue['cate_id'] == $v['id'])  echo "selected"?> value="<?php echo isset($v['id']) ? $v['id'] : '';?>">
                            <?php echo isset($v['str_repeat']) ? $v['str_repeat'] : '';?><?php echo isset($v['name']) ? $v['name'] : '';?>
                            </option>
                            <?php endforeach;?>
                            </select>
                        </div>
                    </div>
					<div class="form-group" style="margin-left: 10px;">起止时间：</div>
					 <div class="form-group">
                        <div class="field">
                            <?php echo html::textInput('search[stime]', null, ['class' => 'input', 'size' => 25, 'id' => 'stime', 'placeholder' => '开始时间']); ?>
                            <?php echo html::textInput('search[etime]', null, ['class' => 'input', 'size' => 25, 'id' => 'etime', 'placeholder' => '结束时间']); ?>
                        </div>
                    </div>
                    <div class="form-button">
                        <button class="button" type="submit">查询</button>
                    </div>
                </div>
            <?php echo html::endForm();?>
        </div>
    </div>	
		<div class="table-responsive">
		<?php echo html::beginForm(Url::toRoute(yii::$app->params['url']['article']), 'GET', ['id' => 'tableform']);?>
			<table id="table" class="table table-hover ">
				<tbody>
					<tr>
						<tr>
							<th>ID</th>
							<th>栏目名称</th>
							<th>标题</th>
							<th>点击次数</th>
							<th>推荐<br/>
								<input type="radio" name="search[isrecom]" id="isrecom" value="1" onclick="$('#tableform').submit();" />是
								<input type="radio" name="search[isrecom]" id="isrecom" value="0" onclick="$('#tableform').submit();" />否
							</th>
						<th>上下架<br/>
							<input type="radio" name="search[isshow]" id="isshow" value="1" onclick="$('#tableform').submit();" />是
							<input type="radio" name="search[isshow]" id="isshow" value="0" onclick="$('#tableform').submit();" />否
						</th>
							<th>时间</th>														
							<th>操作</th>												
						</tr>
					</tr>
					<?php if(is_array($data)&&!empty($data)) :?>
						<?php foreach($data as $v) :?>
							<tr>
								<td><?php echo isset($v['id']) ? $v['id'] : '-';?></td>
								<td><?= Html::encode($v->category->name)?></td>
								<td>
									<?php if($v['commend'] == 1):?><span class="icon-star text-big text-red"></span><?php endif; ?>
									<?php if($v['thumb'] != ''):?><span class="tag bg-green">图</span><?php endif; ?>
									<?php echo isset($v['title']) ? $v['title'] : '-';?>
								</td>
								<td><?php echo isset($v['view']) ? $v['view'] : '-';?></td>								
								<td>
                                    <span class="button-group button-group-little border-dot check">
                                    	<a class="button <?php if($v['commend'] == 0): ?> js-action <?php else: ?> active <?php endif; ?>" href="javascript:;" <?php if($v['commend'] == 0): ?> url="<?php echo Url::toRoute(yii::$app->params['url']['commonArticle']);?>?isCsrf=0" data="<?= Html::encode($v->id)?>" <?php endif ?>  title="【推荐】">是</a>    
                                        <a class="button <?php if($v['commend'] == 1): ?> js-action <?php else: ?> active <?php endif; ?>" href="javascript:;" <?php if($v['commend'] == 1): ?> url="<?php echo Url::toRoute(yii::$app->params['url']['commonArticle']);?>?isCsrf=0" data="<?= Html::encode($v->id)?>" <?php endif ?>  title="【取消推荐】">否</a> 
                                    </span>
                                </td>
								<td>
									<?php if(in_array('articlePut', $power)): ?>
										<span class="button-group button-group-little border-dot check">
                                        <a class="button <?php if($v['status'] == 0): ?> js-action <?php else: ?> active <?php endif; ?>" href="javascript:;" <?php if($v['status'] == 0): ?> url="<?php echo Url::toRoute(yii::$app->params['url']['articlePut']);?>?isCsrf=0" data="<?= Html::encode($v->id)?>" <?php endif ?>  title="【上架】">上架</a>
                                        <a class="button <?php if($v['status'] == 1): ?> js-action <?php else: ?> active <?php endif; ?>" href="javascript:;" <?php if($v['status'] == 1): ?> url="<?php echo Url::toRoute(yii::$app->params['url']['articlePut']);?>?isCsrf=0" data="<?= Html::encode($v->id)?>" <?php endif ?>  title="【下架】">下架</a>
                                    </span>
									<?php else: ?>
										<?php if(1==$v['status']):?><span class="tag bg-green">是</span><?php else:?><span class="tag bg-red">否</span>
										<?php endif;?>
									<?php endif; ?>
								</td>
								<td><?php echo isset($v['create_time']) && $v['create_time'] > 0 ? date('Y-m-d H:i:s', $v['create_time']) : '-';?></td>								
								<td>
									<?php if (in_array('upArticle', $power)):?>
									<a class="button bg-blue button-small icon-pencil" href="<?php echo Url::toRoute(Yii::$app->params['url']['upArticle']);?>?id=<?php echo isset($v['id']) ? $v['id'] : '';?>"><span class="pen icon"></span>修改</a>								
									<?php endif;?>
									
									<?php if (in_array('delArticle', $power)):?>
									<a class="button bg-red button-small icon-trash-o js-del"  href="javascript:;"  url="<?php echo Url::toRoute(yii::$app->params['url']['delArticle']);?>?isCsrf=0" data="<?= Html::encode($v['id'])?>" title="删除"></a>
									<?php endif?>
								</td>			
							</tr>
						<?php endforeach;?>	
					<?php endif;?>
				</tbody>
			</table>
			<?php echo html::endForm(); ?>
		</div>
		<div class="panel-foot table-foot clearfix">
			<!-- 分页 start-->
			<?php echo $this->render('../_page', ['page' => $page, 'count' => $count]); ?>
			<!-- 分页 end-->
		</div>
	</div>
</div>
<script>
	Do.ready('base', function () {
		$('#table').duxTable();
		$('#stime').duxTime();
        $('#etime').duxTime();
	});	
</script>