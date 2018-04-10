<script src="/style/js/jquery.min.js" type="text/javascript"></script>
<script src="/style/js/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
<?php
use yii\captcha\Captcha;
use yii\helpers\Url;
use yii\helpers\Html;
$this->title = $settingData['web_name']."-个人中心";
$this->web_keyword = $settingData['web_keyword'];
$this->web_desc = $settingData['web_desc'];

?>
<?php echo $this->render('/public/uhead', ['uid'=>$uid,'member'=>$member_info]); ?>
<section>
	<div class="wp">
		<ul  class="crumbs">
			<li><a href="/">首页</a>></li>
			<li><a href="<?=Url::toRoute(['u/dataset']) ?>">个人中心</a>></li>
			<li>个人信息</li>
		</ul>
	</div>
</section>



<section>
	<div class="wp list personal_list">
		<div class="left">
			<ul>
				<li ><a href="<?=Url::toRoute(['u/dataset']) ?>">个人资料</a></li>
				<li ><a href="<?=Url::toRoute(['u/article']) ?>">我的文章</a></li>
				<li ><a href="<?=Url::toRoute(['u/fav']) ?>">我的收藏</a></li>
				<li class="active2">
					<a href="<?=Url::toRoute(['u/message']) ?>" style="position: relative;">
						我的消息
					</a>
				</li>
			</ul>
		</div>

		<div class="right" >
			<div class="personal_des Releasecont">
				<div class="head">
					<h1>我的消息</h1>
				</div>

			</div>
			<div class="personal_des permessage">
				<div class="messagelist">
					<?php if(is_array($data) && !empty($data)) :?>
					<?php foreach($data as $k => $v) :?>
						<div class="messages">
						<div class="fr">
							<div class="top"><span class="fl time"><?=date("Y-m-d H:i:s",$v->addtime)?></span><span class="fr btn foldbtn"></span></div>
							<p>
								<?=$v->content?>
							</p>
						</div>
					</div>
					<?php endforeach;?>
					<?php endif;?>
				</div>

				<div class="pageturn pagerright">
					<ul class="pagelist">
						<?= $this->render('../_page', ['count' => $count, 'page' => $page,'pageSize'=>$pageSize]) ?>
					</ul>
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