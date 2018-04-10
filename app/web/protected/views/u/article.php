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
				<li class="active2"><a href="<?=Url::toRoute(['u/article']) ?>">我的文章</a></li>
				<li ><a href="<?=Url::toRoute(['u/fav']) ?>">我的收藏</a></li>
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
					<h1>我的课程</h1>
				</div>
			</div>
			<div class="personal_des permessage">
				<div class="companycenter">
					<div class="group_list brief">
						<?php if(is_array($data) && !empty($data)) :?>
							<?php foreach($data as $k => $v) :?>
								<div class="module1_5 box">
									<a href="<?=Url::toRoute(['news/detail','id'=>$v->id])?>">
										<img width="214" height="190" class="scrollLoading" src="<?=$v->thumb?>"/>
									</a>
									<div class="des">
										<a href="<?=Url::toRoute(['news/detail','id'=>$v->id])?>"><h2><?=$v->title?></h2></a>
										<span class="fl"><?=$v->tags?></span>
										<span class="fr">点击数：<?=$v->clicknum?>&nbsp;&nbsp;</span>
									</div>
									<div class="bottom">
										<span class="fl"><?=$v->title?></span>
										<span class="star fr  notlogin" data-favid="15"><?=$v->collect?></span>
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

<script src='/style/js/plugins/jquery.upload.js' type='text/javascript'></script>
<script src="/style/js/validate.js" type="text/javascript"></script>
<script src="/style/js/deco-user.js"></script>
<script type="text/javascript">
	$('.jsDeleteFav_course').on('click', function(){
		var _this = $(this),
				favid = _this.attr('data-favid');
		alert(favid)
		$.ajax({
			cache: false,
			type: "POST",
			url: "/org/add_fav/",
			data: {
				fav_type: 1,
				fav_id: favid,
				csrfmiddlewaretoken: '799Y6iPeEDNSGvrTu3noBrO4MBLv6enY'
			},
			async: true,
			success: function(data) {
				Dml.fun.winReload();
			}
		});
	});

	$('.jsDeleteFav_teacher').on('click', function(){
		var _this = $(this),
				favid = _this.attr('data-favid');
		$.ajax({
			cache: false,
			type: "POST",
			url: "/org/add_fav/",
			data: {
				fav_type: 3,
				fav_id: favid,
				csrfmiddlewaretoken: '799Y6iPeEDNSGvrTu3noBrO4MBLv6enY'
			},
			async: true,
			success: function(data) {
				Dml.fun.winReload();
			}
		});
	});


	$('.jsDeleteFav_org').on('click', function(){
		var _this = $(this),
				favid = _this.attr('data-favid');
		$.ajax({
			cache: false,
			type: "POST",
			url: "/org/add_fav/",
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


<script>
	var shareUrl = '',
			shareText = '',
			shareDesc = '',
			shareComment = '';
	$(function () {
		$(".bdsharebuttonbox a").mouseover(function () {
			var type = $(this).attr('data-cmd'),
					$parent = $(this).parent('.bdsharebuttonbox'),
					fxurl = $parent.attr('data-url'),
					fxtext = $parent.attr('data-text'),
					fxdesc = $parent.attr('data-desc'),
					fxcomment = $parent.attr('data-comment');
			switch (type){
				case 'tsina':
				case 'tqq':
				case 'renren':
					shareUrl = fxurl;
					shareText = fxdesc;
					shareDesc = '';
					shareComment = '';
					break;
				default :
					shareUrl = fxurl;
					shareText = fxtext;
					shareDesc = fxdesc;
					shareComment = fxcomment;
					break;
			}
		});
	});
	function SetShareUrl(cmd, config) {
		if (shareUrl) {
			config.bdUrl = "" + shareUrl;
		}
		if(shareText){
			config.bdText = shareText;
		}
		if(shareDesc){
			config.bdDesc = shareDesc;
		}
		if(shareComment){
			config.bdComment = shareComment;
		}

		return config;
	}
	window._bd_share_config = {
		"common": {
			"onBeforeClick":SetShareUrl,
			"bdPic":"",
			"bdMini":"2",
			"searchPic":"1",
			"bdMiniList":false
		},
		"share": {
			"bdSize":"16"
		}
	};
	with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com../api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];
</script>