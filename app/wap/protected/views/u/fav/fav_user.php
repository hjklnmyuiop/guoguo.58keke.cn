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
		<a class="col "  rel="test" href="<?=Url::toRoute(['u/fav','type'=>1]) ?>">
				<span class="img-icon ">
					<img class="img-icon-home" src="/style/images/icon-home/me-1.png" />
				</span>
			<span class="img-icon-name">文章</span>
		</a>
		<a class="col active"  rel="test" href="<?=Url::toRoute(['u/fav','type'=>2]) ?>">
					<span class="img-icon ">
						<img class="img-icon-home" src="/style/images/icon-home/me-2.png" />
					</span>
			<span class="img-icon-name">作者</span>
		</a>
	</div>
</div>
<div style="padding-bottom:20px">
	<?php if(is_array($data) && !empty($data)) :?>
		<?php foreach($data as $k => $v) :?>
			<a href="<?=Url::toRoute(['write/detail','id'=>$v->user->id])?>" >
				<div class="list-s">
					<div class="aui-list-cells aui-list-cell">
						<div class="aui-list-cell-fl"><img src="<?=$v->user->head?>" style="border-radius:100%"></div>
						<div class="aui-list-cell-cn"><?=$v->user->name?></div>
						<div class="aui-list-cell-fr">文章(<?=$v->user->arti_num?>)</div>
					</div>
					<div class="aui-list-si">
						<p><?=date("Y-m-d",$v->user->lastlogin)?></p>
						<h2><?=$v->user->intro?></h2>
					</div>
				</div>
			</a>
		<?php endforeach;?>
	<?php endif;?>
</div>
