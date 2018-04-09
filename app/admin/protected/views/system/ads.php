<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\helpers\Url;

$this->title = '环球石材管理系统-banner图片';
?>
<div class="dux-tools">
	<div class="tools-function clearfix">
		<div class="float-left">
			<a class="button button-small bg-main icon-list" href=""> banner图片</a>
		</div>
		<div class="button-group float-right">
			<a class="button button-small bg-dot icon-plus dropdown-toggle" href="<?php echo Url::toRoute(yii::$app->params['url']['addAds']);?>">添加</a> 
		</div>
	</div>
</div>
<div class="admin-main">
    <div class="panel dux-box">
		<div class="table-responsive">
			<table id="table" class="table table-hover ">
				<tbody>
					<tr>
						<th>ID</th>
						<th>分类</th>
						<th>名称</th>
						<th>图片</th>
						<th>链接地址</th>
						<th>时间</th>
						<th>操作</th>
					</tr>
					<?php if(is_array($data)&&!empty($data)) :?>
						<?php foreach($data as $v) :?>
							<tr>
								<td><?= Html::encode($v->id)?></td>
								<td><?= yii::$app->params['adsType'][$v->type]?></td>
								<td><?= Html::encode($v->name)?></td>
								<td><img src="<?= Html::encode($v->image)?>" width="128" height="128" class="radius-circle"></td>
								<td><?= Html::encode($v->url)?></td>
								<td><?= Html::encode(date('Y-m-d H:i:s', $v->addtime))?></td>
								<td>				
									<?php if(in_array('upAds', $power)):?>
										<a class="button bg-blue button-small icon-pencil" href="<?php echo Url::toRoute(yii::$app->params['url']['upAds']);?>?id=<?= Html::encode($v->id)?>" title="修改"></a>
									<?php endif; ?>
									<?php if(in_array('delAds', $power)):?>
									 	<a class="button bg-red button-small icon-trash-o js-del"  href="javascript:;"  url="<?php echo Url::toRoute(yii::$app->params['url']['delAds']);?>?isCsrf=0" data="<?= Html::encode($v->id)?>" title="删除"></a>
									<?php endif; ?>
								</td>
							</tr>
						<?php endforeach;?>	
					<?php endif;?>
				</tbody>
			</table>
		</div>
		<div class="panel-foot table-foot clearfix">
			<!-- 分页 start-->
			<?= $this->render('../_page', ['count' => $count, 'page' => $page]) ?>
			<!-- 分页 end-->
		</div>
	</div>
</div>
<script>
	Do.ready('base', function () {
		$('#table').duxTable();
	});
</script>