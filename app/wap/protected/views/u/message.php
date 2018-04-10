<?php
use yii\captcha\Captcha;
use yii\helpers\Url;
use yii\helpers\Html;
$this->title = $settingData['web_name']."-个人中心";
$this->web_keyword = $settingData['web_keyword'];
$this->web_desc = $settingData['web_desc'];

?>
<div class="header">
	<div class="header-background"></div>
	<div class="toolbar statusbar-padding">
		<button class="bar-button back-button" onclick="history.go(-1);" dwz-event-on-click="click"><i class="icon icon-back"></i></button>
		<!--<a class="bar-button" data-href="home.html?dwz_callback=home_render" target="navTab" rel="home"><i class="icon icon-back"></i></a>-->
		<div class="header-title">
			<div class="title">我的评价</div>
		</div>
	</div>
</div>
<div style="height:44px"></div>


<div style="padding-bottom:20px">
	<?php if(is_array($data) && !empty($data)) :?>
	<?php foreach($data as $k => $v) :?>
	<div class="list-s">
		<div class="aui-list-si">
			<p><?=date("Y-m-d H:i:s",$v->addtime)?></p>
			<h2><?=$v->content?></h2>
		</div>
	</div>
		<?php endforeach;?>
	<?php endif;?>
</div>
