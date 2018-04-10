<?php
use yii\helpers\Url;

?>
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