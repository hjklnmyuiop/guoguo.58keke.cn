<script src="/style/js/jquery.min.js" type="text/javascript"></script>
<script src="/style/js/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
<?php
use yii\captcha\Captcha;
use yii\helpers\Url;
use yii\helpers\Html;
$this->title = $settingData['web_name']."-资讯";
$this->web_keyword = $settingData['web_keyword'];
$this->web_desc = $settingData['web_desc'];

?>
<?php echo $this->render('/public/head', ['uid'=>$uid,'navcss'=>$navcss,'member'=>$member_info]); ?>
<section>
	<div class="wp">
		<ul  class="crumbs">
			<li><a href="index.html">首页</a>></li>
			<li>公开课</li>
		</ul>
	</div>
</section>


<section>
	<div class="wp">

		<div class="list" style="margin-top:0;">

			<div class="left layout">
				<div class="listoptions">
					<ul>
						<li>
							<h2>分类</h2>
							<div class="cont">
								<a <?php if($id==''):?>class="active" <?php endif?> href="<?=Url::toRoute(['/news/list'])?>"><span >全部</span></a>
								<?php if(is_array(\Yii::$app->params['article_cate']) && !empty(\Yii::$app->params['article_cate'])) :?>
								<?php foreach(\Yii::$app->params['article_cate'] as $k => $v) :?>
									<a  <?php if($v['id'] == $id):?>class="active" <?php endif?>  href="<?=Url::toRoute(['/news/list','id'=>$v['id']])?>"><span><?=$v['name']?></span></a>
								<?php endforeach;?>
								<?php endif;?>

							</div>
						</li>
					</ul>
				</div>
				<div class="head">
					<ul class="tab_header">
						<li <?php if(isset($search['sort'])&&$search['sort']==''):?> class="active"><?php endif;?><a href="?search[sort]=">最新 </a></li>
						<li <?php if(isset($search['sort']) && $search['sort']=='hot'):?> class="active"><?php endif;?>><a href="?search[sort]=hot">最热门</a></li>
					</ul>
				</div>
				<div id="inWindow">
					<div class="tab_cont " id="content">
						<div class="group_list">
							<?php if(is_array($data) && !empty($data)) :?>
								<?php foreach($data as $k => $v) :?>
								<div class="box">
								<a href="<?=Url::toRoute(['news/detail','id'=>$v->id])?>">
									<img width="280" height="350" class="scrollLoading" src="<?=$v->thumb?>"/>
								</a>
								<div class="des">
									<a  href="<?=Url::toRoute(['news/detail','id'=>$v->id])?>">
										<h2 style="overflow: hidden;height: 30px" ><?=($v->title)?></h2>
									</a>
									<span class="fl"><?=$v->tags?></span>
									<span class="fr">点击数：<?=$v->clicknum?>&nbsp;&nbsp;</span>
								</div>
								<div class="bottom">
									<a href="course-detail.html"><span class="fl"><?=$v->category->name?></span></a>
									<span class="star fr"><?=$v->collect?></span>
								</div>
							</div>
								<?php endforeach;?>
							<?php endif;?>

						</div>
						<div class="pageturn">
							<ul class="pagelist">
								<?= $this->render('../_page', ['count' => $count, 'page' => $page,'pageSize'=>$pageSize]) ?>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="right layout">
				<div class="head">热门文章推荐</div>
				<div class="group_recommend">
					<?php if(is_array($tuijian) && !empty($tuijian)) :?>
					<?php foreach($tuijian as $k => $v) :?>
					<dl>
						<dt>
							<a target="_blank" href="<?=Url::toRoute(['news/detail','id'=>$v->id])?>">
								<img width="240" height="220" class="scrollLoading" src="<?=$v->thumb?>"/>
							</a>
						</dt>
						<dd>
							<a target="_blank" href=""><h2> <?=$v->title?></h2></a>
							<span class="fl">学习人数：<i class="key"><?=$v->clicknum?></i></span>
						</dd>
</dl>
						<?php endforeach;?>
						<?php endif;?>
				</div>
			</div>
		</div>
	</div>
</section>
<?php echo $this->render('/public/footer'); ?>
<script src="/style/js/selectUi.js" type='text/javascript'></script>
<script src="/style/js/deco-common.js" type='text/javascript'></script>
<script type="text/javascript" src="/style/js/plugins/laydate/laydate.js"></script>
<script src="/style/js/plugins/layer/layer.js"></script>
<script src="/style/js/plugins/queryCity/js/public.js" type="text/javascript"></script>
<script src="/style/js/unslider.js" type="text/javascript"></script>
<script src="/style/js/plugins/jquery.scrollLoading.js"  type="text/javascript"></script>
<script src="/style/js/deco-common.js"  type="text/javascript"></script>
