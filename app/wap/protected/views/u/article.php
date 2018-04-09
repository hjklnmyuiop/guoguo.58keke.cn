<?php
use yii\helpers\Url;

$this->title = $settingData['web_name']."-文章列表";
$this->web_keyword = $settingData['web_keyword'];
$this->web_desc = $settingData['web_desc'];
?>
<div class="header">
	<div class="header-background"></div>
	<div class="toolbar statusbar-padding">
		<button class="bar-button back-button" onclick="history.go(-1);" dwz-event-on-click="click"><i class="icon icon-back"></i></button>
		<div class="header-title">
			<div class="title">我的文章</div>
		</div>
	</div>
</div>
<div style="height:44px"></div>
<div class="aui-it-content">
	<div class="aui-it-list">
		<ul>
			<?php if(is_array($data) && !empty($data)) :?>
				<?php foreach($data as $k => $v) :?>
					<li>
						<a href="<?=Url::toRoute(['news/detail','id'=>$v->id])?>">
							<div class="aui-it-title"><img src="<?=$v->thumb?>" width="90"></div>
							<div class="aui-it-middle">
								<h2 style="padding-bottom:0;height: 30px; overflow: hidden"><?=($v->title)?></h2>
								<span class="aui-aui-s"><?=$v->clicknum?></span>
								<span class="aui-aui-s"><?=$v->category->name?></span>
								<span class="aui-aui-s"><?=$v->collect?></span>
								<p class="aui-spill"><?=$v->tags?></p>
							</div>
						</a>
					</li>
				<?php endforeach;?>
			<?php endif;?>
		</ul>
	</div>
</div>