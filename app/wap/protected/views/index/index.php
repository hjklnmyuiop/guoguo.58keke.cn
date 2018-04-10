<?php
use yii\helpers\Url;

$this->title = $settingData['web_name']."-首页";
$this->web_keyword = $settingData['web_keyword'];
$this->web_desc = $settingData['web_desc'];

?>
<style>
	.aui-flex{flex-wrap:wrap}
	.aui-flex-items{width: 49%;margin-left: 1px;}
	.aui-flex-items2{width: 46%;margin-left: 5px;}
	.slider .icon-list{width: 100%}
	.aui-title-h{text-align: left}
</style>
<div class="aui-container">
	<div class="aui-page">
		<!-- 头部 begin-->
		<div class="header">
			<div class="aui-header-bg" style="background:#ff5a5f;"></div>
			<div class="toolbar statusbar-padding" style="min-height:50px">
				<button class="bar-button back-button"><img class="search_btn fr" id="jsSearchBtn" src="/style/images/search_btn.png"/></button>
				<div class="header-title" style="height:50px; margin:0 0px">
					<div class="title aui-title-input"><input id="search_keywords" type="text" placeholder="文章"></div>
				</div>
				<a href="<?=Url::toRoute(['u/message'])?>">
					<button class="icon aui-icon-mag"></button>
				</a>
			</div>
		</div>
		<div style="height:50px"></div>
		<!-- 头部 End-->
		<!-- 首页轮播 begin -->
		<div class="aui-banner-content">
			<div id="focus" class="focus">
				<div class="bd">
					<div class="tempWrap" style="overflow:hidden; position:relative;">
						<ul id="Gallery" class="gallery" style="width: 2250px; position: relative; overflow: hidden; padding: 0px; margin: 0px; transition-duration: 200ms; transform: translate(-1125px, 0px) translateZ(0px);">
							<?php if(is_array($banner) && !empty($banner)) :?>
							<?php foreach($banner as $k => $v) :?>
							<li style="display: table-cell; vertical-align: top; width: 375px;" >
								<a href="<?=$v->url?>">
									<img  src="<?=$v->image?>" />
								</a>
							</li>
								<?php endforeach;?>
							<?php endif;?>
						</ul>
					</div>
				</div>
				<div class="hd">
					<ul>
						<?php if(is_array($banner) && !empty($banner)) :?>
						<?php foreach($banner as $k => $v) :?>
						<li class=""><?=$k+1?></li>
							<?php endforeach;?>
						<?php endif;?>
					</ul>
				</div>
			</div>
		</div>
		<!-- 首页轮播 end -->
		<!-- 分类切换 begin -->
		<div class="" id="container" >
			<div id="main" style="transition-timing-function: cubic-bezier(0.1, 0.57, 0.1, 1); transition-duration: 0ms; transform: translate(0px, 0px) translateZ(0px);">
				<div id="scroller">
					<section class="slider" style="margin:0  auto; width:100%">
						<div class="swiper-container swiper-container2 swiper-container-horizontal">
							<div class="swiper-wrapper tuangouwidth" style="transition-duration: 0ms; transform: translate3d( 0px, 0px);">
								<div class="swiper-slide swiper-slide-duplicate " >
									<ul class="icon-list">
										<?php if(is_array($hot_catogory) && !empty($hot_catogory)) :?>
											<?php foreach($hot_catogory as $k => $v) :?>
												<li class="icon">
													<a href="<?=Url::toRoute(['news/list','id'=>$v->id])?>">
														<span class="icon-circle"><img width="80" height="80" src="<?=$v->image?>"></span>
														<span class="icon-desc"><?=$v->name?></span>
													</a>
												</li>
											<?php endforeach;?>
										<?php endif;?>

									</ul>
								</div>
							</div>
						</div>
					</section>
				</div>
			</div>
		</div>
<!--		<div class="my-car-thumbnail"><img src="/style/images/img/banner-car.jpg"></div>-->
		<div class="aui-title-h">
			<h2 style="width: 80%;float: left">推荐作者</h2>
			<a class="more" href="<?=Url::toRoute(['write/list'])?>">更多 ></a>
		</div>
		<div class="aui-flex">
			<?php if(is_array($hot_user) && !empty($com_article)) :?>
			<?php foreach($hot_user as $k => $v) :?>
			<div class="aui-flex-items1 aui-flex-items2">
				<span>
					<img src="<?=$v->head?>">
				</span>
				<a href="<?=Url::toRoute(['write/detail','id'=>$v->id])?>" class="aui-flex-box">
					<h2><?=$v->name?> </h2>
					<em><?=$v->collect?></em>
				</a>
			</div>
				<?php endforeach;?>
			<?php endif;?>
		</div>

		<div class="aui-title-h">
			<h2 style="width: 80%;float: left">推荐文章</h2>
			<a class="more" href="<?=Url::toRoute(['news/list'])?>">更多 ></a>
		</div>
		<div class="aui-flex">
			<?php if(is_array($com_article) && !empty($com_article)) :?>
				<?php foreach($com_article as $k => $v) :?>
				<div class="aui-flex-items">
				<span>
					<a href="<?=Url::toRoute(['news/detail','id'=>$v->id])?>"><img src="<?=$v->thumb?>"></a>
				</span>
				<a href="<?=Url::toRoute(['news/detail','id'=>$v->id])?>" class="aui-flex-box"><?=($v->title)?></a>
			</div>
				<?php endforeach;?>
			<?php endif;?>

		</div>

		<div style="height:44px"></div>
		<?php echo $this->render('/public/footer',['navcss'=>$navcss]); ?>
	</div>
</div>
<script type="text/javascript" src="/style/js/pd/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="/style/js/pd/aui-touchSlide.js"></script>
<script>
	/*banner首页轮播*/
	TouchSlide({
		slideCell : "#focus",
		titCell : ".hd ul", // 开启自动分页 autoPage:true ，此时设置 titCell 为导航元素包裹层
		mainCell : ".bd ul",
		effect : "leftLoop",
		autoPlay : true, // 自动播放
		autoPage : true, // 自动分页
		delayTime: 200, // 毫秒；切换效果持续时间（执行一次效果用多少毫秒）
		interTime: 5000, // 毫秒；自动运行间隔（隔多少毫秒后执行下一个效果）
		switchLoad : "_src" // 切换加载，真实图片路径为"_src"
	});
</script>
<script src="/style/js/ba/aui-scroll.js" type="text/javascript" charset="utf-8"></script>
<script src="/style/js/ba/aui-index.js" type="text/javascript" charset="utf-8"></script>
<script src="/style/js/ba/aui-swipe.js" type="text/javascript" charset="utf-8"></script>
<script>
	$('#jsSearchBtn').on('click',function(){
		search_click();
	});
	//顶部搜索栏搜索方法
	function search_click(){
		var type = 'article',
				keywords = $('#search_keywords').val(),
				request_url = '';
		if(keywords == ""){
			return
		}
		if(type == "article"){
			request_url = "/news/list?search[keyword]="+keywords
		}else if(type == "user"){
			request_url = "/write/index?search[keyword]="+keywords
		}
		window.location.href = request_url
	}
</script>

