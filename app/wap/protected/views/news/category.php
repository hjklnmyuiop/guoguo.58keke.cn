<?php
use yii\helpers\Url;

$this->title = $settingData['web_name']."-首页";
$this->web_keyword = $settingData['web_keyword'];
$this->web_desc = $settingData['web_desc'];

?>
<style>
	.menu-left ul li{width: 5.6rem;}
	.menu-right {
		margin-left: 5.6rem;
		left: 5.6rem;
	}
</style>
<div class="header">
	<div class="header-background"></div>
	<div class="toolbar statusbar-padding">
		<button class="bar-button back-button" onclick="history.go(-1);" dwz-event-on-click="click"><i class="icon icon-back"></i></button>
		<div class="header-title">
			<div class="title">分类</div>
		</div>
	</div>
</div>
<div id="loading"><img src="images/loading.gif" /></div>
<div class="con">

	<aside>
		<div class="menu-left scrollbar-none r-line" id="sidebar">
			<ul>
				<?php if(is_array($catogory) && !empty($catogory)) :?>
					<?php foreach($catogory as $k => $v) :?>
					<li <?php if($class==$v['id']):?> class="active"<?php endif;?>><?=$v['name']?></li>
					<?php endforeach;?>
				<?php endif;?>
			</ul>
		</div>
	</aside>
	<?php if(is_array($catogory) && !empty($catogory)) :?>
	<?php $i=0; foreach($catogory as $k => $v) :$i++;?>
	<section class="menu-right padding-all j-content" <?php if($i!=1): ?>style="display: none" <?php endif;?>>
		<h5><?=$v['name']?></h5>
		<ul>
			<?php if(is_array($v['child']) && !empty($v['child'])) :?>
				<?php foreach($v['child'] as $kk => $vv) :?>
			<li class="w-3"><a href="<?=Url::toRoute(['news/list','id'=>$vv['id']])?>"></a> <img src="<?=$vv['image']?>" /><span><?=$vv['name']?></span></li>
				<?php endforeach;?>
			<?php endif;?>
		</ul>
	</section>
		<?php endforeach;?>
	<?php endif;?>
</div>

<?php echo $this->render('/public/footer',['navcss'=>$navcss]); ?>



<script type="text/javascript">
	//设置cookie
	function setCookie(cname, cvalue, exdays) {
		var d = new Date();
		d.setTime(d.getTime() + (exdays*24*60*60*1000));
		var expires = "expires="+d.toUTCString();
		document.cookie = cname + "=" + cvalue + "; " + expires;
	}
	function clearHistroy(){
		setCookie('ECS[keywords]', '', -1);
		document.getElementById("search_histroy").style.visibility = "hidden";
	}
</script>
<script type="text/javascript" src="/style/js/class/jquery.min.js"></script>
<script type="text/javascript" src="/style/js/class/swiper-3.2.5.min.js"></script>
<script type="text/javascript" src="/style/js/class/ectouch.js"></script>
<script type="text/javascript" src="/style/js/class/jquery.json.js"></script>
<script type="text/javascript" src="/style/js/class/common.js"></script>
<script type="text/javascript">
	$(function($){
		$('#sidebar ul li').click(function(){
			$(this).addClass('active').siblings('li').removeClass('active');
			var index = $(this).index();
			$('.j-content').eq(index).show().siblings('.j-content').hide();
		})
	})
</script>
