<?php
use yii\captcha\Captcha;
use yii\helpers\Url;
use yii\helpers\Html;
$this->title = $settingData['web_name']."-个人中心";
$this->web_keyword = $settingData['web_keyword'];
$this->web_desc = $settingData['web_desc'];

?>
<div class="scroll-content" >
	<div class="">
		<div class="header home-header" style="" id="headsearch">
			<div class="toolbar statusbar-padding active">
				<button class="bar-button current-city"><i class="icon icon-set" style="left:0;right: inherit"></i></button>

				<button class="bar-button icon-button"><i class="icon icon-msg"></i></button>
			</div>
		</div>
		<div class="my-info">
			<div class="my-info-background"></div>
			<img class="my-avatar" src="<?=$member_info['head']?>">
			<span class="my-vip" style="background:none"><?=$member_info['name']?></span>
		</div>
<!--		<div class="my-car-shortcut">-->
<!--			<div class="layout-column b-line" style="padding:10px 0">-->
<!--				<a class="col"  rel="test" href="wait.html">-->
<!--							<span class="img-icon ">-->
<!--								<img class="img-icon-home" src="images/icon-home/me-1.png" />-->
<!--							</span>-->
<!--					<span class="img-icon-name">待付款</span>-->
<!--				</a>-->
<!--				<a class="col"  rel="test" href="wait.html">-->
<!--							<span class="img-icon ">-->
<!--								<img class="img-icon-home" src="images/icon-home/me-2.png" />-->
<!--							</span>-->
<!--					<span class="img-icon-name">待收货</span>-->
<!--				</a>-->
<!--				<a class="col" href="wait.html" rel="test">-->
<!--							<span class="img-icon ">-->
<!--								<img class="img-icon-home" src="images/icon-home/me-3.png" />-->
<!--							</span>-->
<!--					<span class="img-icon-name">全部订单</span>-->
<!--				</a>-->
<!--			</div>-->
<!--		</div>-->
		<div class="devider b-line"></div>
		<!-- 个人中心 begin-->
		<div>
			<div class="aui-list-cells">
				<a href="<?=Url::toRoute(['u/info']) ?>" class="aui-list-cell">
					<div class="aui-list-cell-fl"><img src="/style/images/icon-home/me-9.png"></div>
					<div class="aui-list-cell-cn">个人信息</div>
					<div class="aui-list-cell-fr"></div>
				</a>
				<a href="<?=Url::toRoute(['u/article']) ?>" class="aui-list-cell">
					<div class="aui-list-cell-fl"><img src="/style/images/icon-home/news.png"></div>
					<div class="aui-list-cell-cn">我的文章</div>
					<div class="aui-list-cell-fr"><?=$user->arti_num?></div>
				</a>
				<a href="<?=Url::toRoute(['u/fav']) ?>" class="aui-list-cell">
					<div class="aui-list-cell-fl"><img src="/style/images/icon-home/fav.png"></div>
					<div class="aui-list-cell-cn">我的收藏</div>
					<div class="aui-list-cell-fr"><?=$user->collect?></div>
				</a>
				<a href="<?=Url::toRoute(['u/message']) ?>" class="aui-list-cell">
					<div class="aui-list-cell-fl"><img src="/style/images/icon-home/mess.png"></div>
					<div class="aui-list-cell-cn">我的消息</div>
					<div class="aui-list-cell-fr"><?=$sysmess?></div>
				</a>
				<div class="devider b-line"></div>
				<a href="<?=Url::toRoute(['public/logout']) ?>" class="aui-list-cell">
					<div class="aui-list-cell-fl"><img src="/style/images/icon-home/me-11.png"></div>
					<div class="aui-list-cell-cn">退出账号</div>
					<div class="aui-list-cell-fr"></div>
				</a>
			</div>
		</div>


	</div>
</div>
<div style="height:48px"></div>
<?php echo $this->render('/public/footer',['navcss'=>$navcss]); ?>
<script type="text/javascript" src="/style/js/jquery-1.7.1.min.js"></script>
<script class="demo-script">
	$(window).scroll(function () {
		if ($(window).scrollTop() > 100) {
			$("#headsearch").addClass("ui-form-color-nav");
		}else if($(window).scrollTop() == 0){
			$("#headsearch").removeClass("ui-form-color-nav");
		}
	});
	(function (){
		var slider = new fz.Scroll('.ui-slider', {
			role: 'slider',
			indicator: true,
			autoplay: true,
			interval: 5000
		});

		slider.on('beforeScrollStart', function(fromIndex, toIndex) {
			console.log(fromIndex,toIndex)
		});

		slider.on('scrollEnd', function(cruPage) {
			console.log(cruPage)
		});
	})();
</script>