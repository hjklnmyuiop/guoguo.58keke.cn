<?php
use yii\helpers\Url;
use yii\helpers\Html;
$this->title = $settingData['web_name']."-文章收藏";
$this->web_keyword = $settingData['web_keyword'];
$this->web_desc = $settingData['web_desc'];
?>
<style>
	.layout-column .active {  color: #ee5351;
	}
</style>
<div class="header">
	<div class="header-background"></div>
	<div class="toolbar statusbar-padding">
		<button class="bar-button back-button" onclick="window.location.href='<?=Url::toRoute(['u/dataset']) ?>';" dwz-event-on-click="click"><i class="icon icon-back"></i></button>
		<!--<a class="bar-button" data-href="home.html?dwz_callback=home_render" target="navTab" rel="home"><i class="icon icon-back"></i></a>-->
		<div class="header-title">
			<div class="title">我的收藏</div>
		</div>
	</div>
</div>
		<div class="my-car-shortcut">
			<div class="layout-column b-line " style="padding:10px 0">
				<a class="col active"  rel="test" href="<?=Url::toRoute(['u/fav','type'=>1]) ?>">
							<span class="img-icon ">
								<img class="img-icon-home" src="/style/images/icon-home/me-1.png" />
							</span>
					<span class="img-icon-name">文章</span>
				</a>
				<a class="col"  rel="test" href="<?=Url::toRoute(['u/fav','type'=>2]) ?>">
							<span class="img-icon ">
								<img class="img-icon-home" src="/style/images/icon-home/me-2.png" />
							</span>
					<span class="img-icon-name">作者</span>
				</a>
			</div>
		</div>

<div>
	<div class="main_con" style="margin-bottom:0;">

		<div class="main_con_goods">
			<ul>
				<?php if(is_array($data) && !empty($data)) :?>
					<?php foreach($data as $k => $v) :?>
						<li >
					<section class="aui-crl" style="padding-left:15px">
						<img src="<?=$v->article->thumb?>">
					</section>
					<div style="width: 225px; padding-left: 10px;" class="">
						<h2><?=$v->article->title?></h2>
						<p class="aui-o"><?=$v->article->tags?></p>
						<p class="money"><em class="aui-redd">点击数：<?=$v->article->clicknum?></em>
							<a href="<?=Url::toRoute(['news/detail','id'=>$v->article->id])?>" style="color:#ff5000;border:1px solid #ff5000; padding:2px 5px;font-size:12px; border-radius:3px">查看</a>
						</p>
					</div>
				</li>
					<?php endforeach;?>
				<?php endif;?>
			</ul>
		</div>
	</div>
</div>
