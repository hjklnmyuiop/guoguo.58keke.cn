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
			<li><a href="/">首页</a>></li>
			<li>作者</li>
		</ul>
	</div>
</section>


<section>
	<div class="wp butler_list_box list">
		<div class='left'>
			<div class="butler_list layout">
				<div class="head">
					<ul class="fl tab_header">
						<li <?php if(isset($search['sort'])&&$search['sort']==''):?> class="active"<?php endif;?>><a href="?sort=">全部</a> </li>
						<li <?php if(isset($search['sort'])&&$search['sort']=='hot'):?> class="active"<?php endif;?>><a href="?search[sort]=hot">人气 &#8595;</a></li>
					</ul>
					<div class="fr butler-num">共<span class="key"><?php echo $count; ?></span>人&nbsp;&nbsp;&nbsp;</div>
				</div>

				<?php if(is_array($data) && !empty($data)) :?>
				<?php foreach($data as $k => $v) :?>
				<dl class="des">
					<dt>
						<a href="<?=Url::toRoute(['write/detail','id'=>$v->id])?>">
							<div class="picpic">
								<img width="100" height="100" class="scrollLoading" src="<?=$v->head?>"/>
							</div>
						</a>
					<div class="btn">
						<div class="fr btn2 bdsharebuttonbox"
							 data-text="授课教师-奥巴马-果果在线"
							 data-desc="我在#慕课网#发现了教师“奥巴马”，对学习中的小伙伴很有帮助，一起来看看吧。"
							 data-comment="奥巴马金牌讲师，从业年限：5年"
						>
							<span class="fl">分享</span>
							<a href="#" class="bds_more" data-cmd="more"></a>
						</div>
					</div>
					</dt>
					<dd>
						<a href="<?=Url::toRoute(['write/detail','id'=>$v->id])?>">
							<h1><?=$v->name?><span class="key picbig">热门任务</span></h1>
						</a>
						<ul class="cont">
							<li>性别：<span><?=$v->sex==1?'男':'女'?></span></li>
							<li>文章数：<span><?=$v->arti_num?></span></li>
							<li>登录数：<span><?=$v->login_num?></span></li>
						</ul>
						<span>简介：<span><?=$v->intro?></span>
					</dd>
					<a class="buy buyservice" href="<?=Url::toRoute(['write/detail','id'=>$v->id])?>"><br/>查看<br/>详情</a>
				</dl>
				<?php endforeach;?>
				<?php endif;?>
			</div>
			<div class="pageturn">
				<ul class="pagelist">
					<?= $this->render('../_page', ['count' => $count, 'page' => $page,'pageSize'=>$pageSize]) ?>

				</ul>
			</div>
		</div>
<!--		<div class="right layout">-->
<!--			<div class="head">讲师排行榜</div>-->
<!---->
<!--			<dl class="des">-->
<!--				<span class="num fl">1</span>-->
<!--				<a href="/diary/hk_detail/6/">-->
<!--					<dt>-->
<!--						<img width="50" height="50" class="scrollLoading"  src="../media/teacher/2016/11/aobama_CXWwMef.png"/>-->
<!--					</dt>-->
<!--				</a>-->
<!--				<dd>-->
<!--					<a href="/diary/hk_detail/6/">-->
<!--						<h1 title="bobby">bobby</h1>-->
<!--					</a>-->
<!--					<p>工作年限：<span>5年</span></p>-->
<!--				</dd>-->
<!--			</dl>-->
<!---->
<!--			<dl class="des">-->
<!--				<span class="num fl">1</span>-->
<!--				<a href="/diary/hk_detail/6/">-->
<!--					<dt>-->
<!--						<img width="50" height="50" class="scrollLoading"  src="../media/teacher/2016/11/aobama.png"/>-->
<!--					</dt>-->
<!--				</a>-->
<!--				<dd>-->
<!--					<a href="/diary/hk_detail/6/">-->
<!--						<h1 title="还是bobby">还是bobby</h1>-->
<!--					</a>-->
<!--					<p>工作年限：<span>5年</span></p>-->
<!--				</dd>-->
<!--			</dl>-->
<!---->
<!---->
<!--		</div>-->
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
