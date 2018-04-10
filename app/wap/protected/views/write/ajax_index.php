<?php
use yii\helpers\Url;

?>
	<?php if(is_array($data) && !empty($data)) :?>
	<?php foreach($data as $k => $v) :?>
		<a href="<?=Url::toRoute(['write/detail','id'=>$v->id])?>" >
			<div class="list-s">
		<div class="aui-list-cells aui-list-cell">
				<div class="aui-list-cell-fl"><img src="<?=$v->head?>" style="border-radius:100%"></div>
				<div class="aui-list-cell-cn"><?=$v->name?></div>
				<div class="aui-list-cell-fr">文章(<?=$v->arti_num?>)</div>
		</div>
		<div class="aui-list-si">
			<p><?=date("Y-m-d",$v->lastlogin)?></p>
			<h2><?=$v->intro?></h2>
		</div>
	</div>
		</a>
		<?php endforeach;?>
	<?php endif;?>
