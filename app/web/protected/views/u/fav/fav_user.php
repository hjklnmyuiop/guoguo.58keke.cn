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
			<li>我的收藏</li>
		</ul>
	</div>
</section>




<section>
	<div class="wp list personal_list">
		<div class="left">
			<ul>
				<li ><a href="<?=Url::toRoute(['u/dataset']) ?>">个人资料</a></li>
				<li><a href="<?=Url::toRoute(['u/article']) ?>">我的文章</a></li>
				<li  class="active2"><a href="<?=Url::toRoute(['u/fav']) ?>">我的收藏</a></li>
				<li >
					<a href="<?=Url::toRoute(['u/message']) ?>" style="position: relative;">
						我的消息
					</a>
				</li>
			</ul>
		</div>
		<div class="right" >
			<div class="personal_des Releasecont">
				<div class="head">
					<h1>我的收藏</h1>
				</div>
			</div>
			<div class="personal_des permessage">
				<div class="head">
					<ul class="tab_header messagehead">
						<li class="active"><a href="javascript::void();">作者 </a></li>
						<li ><a href="<?=Url::toRoute(['u/fav','type'=>1])?>">文章</a></li>
					</ul>
				</div>
				<div class="messagelist">
					<?php if(is_array($data) && !empty($data)) :?>
					<?php foreach($data as $k => $v) :?>
					<div class=" butler_list butler-fav-box">
						<dl class="des users">
							<dt>
								<a href="<?=Url::toRoute(['write/detail','id'=>$v->user->id])?>">
									<img width="100" height="100" src="<?=$v->user->head?>"/>
								</a>
							</dt>
							<dd>
								<h1>
									<a href="<?=Url::toRoute(['write/detail','id'=>$v->user->id])?>">
										<?=$v->user->name?><span class="key">认证教师</span>
									</a>
								</h1>
								<ul class="cont clearfix">
									<li class="c7">性别：<span><?=$v->user->sex==1?'男':'女'?></span></li>
									<li class="c7">文章数：<span><?=$v->user->arti_num?></span></li>
								</ul>
								<ul class="cont clearfix">
									<li class="c7">登录数：<span><?=$v->user->login_num?></span></li>
									<li class="time">最后登录：<span><?=date("Y-m-d",$v->user->lastlogin)?></span></li>
								</ul>
							</dd>
							<div class="delete jsDeleteFav_teacher" data-favid="<?=$v->id?>"></div>
						</dl>
					</div>
					<?php endforeach;?>
					<?php endif;?>
					<div class="pageturn">
						<ul class="pagelist">
							<?= $this->render('../../_page', ['count' => $count, 'page' => $page,'pageSize'=>$pageSize]) ?>
						</ul>
					</div>
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

<script type="text/javascript">
	$('.jsDeleteFav_teacher').on('click', function(){
		var _this = $(this),
				favid = _this.attr('data-favid');
		$.ajax({
			cache: false,
			type: "POST",
			url: "/u/delfav/",
			data: {
				fav_type: 2,
				fav_id: favid,
				csrfmiddlewaretoken: '799Y6iPeEDNSGvrTu3noBrO4MBLv6enY'
			},
			async: true,
			success: function(data) {
				Dml.fun.winReload();
			}
		});
	});
</script>