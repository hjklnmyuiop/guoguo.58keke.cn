<?php
use yii\helpers\Url;
?>
<div class="tab-bar tab-bottom">
    <a class="tab-button <?php if($navcss=='index'):?>active<?php endif;?>" href="<?=Url::toRoute(['index/'])?>"><i class="tab-button-icon icon icon-home"></i><span class="tab-button-txt">首页</span></a>
    <a class="tab-button <?php if($navcss=='news'):?>active<?php endif;?>" href="<?=Url::toRoute(['news/category'])?>"><i class="tab-button-icon icon icon-service" ></i><span class="tab-button-txt">文章</span></a>
    <a class="tab-button <?php if($navcss=='write'):?>active<?php endif;?>" href="<?=Url::toRoute(['write/index'])?>"><i class="tab-button-icon icon icon-exhibition" ></i><span class="tab-button-txt">作者</span></a>
    <a class="tab-button <?php if($navcss=='u'):?>active<?php endif;?>" href="<?=Url::toRoute(['u/dataset'])?>"><i class="tab-button-icon icon icon-my"></i><span class="tab-button-txt">我的</span></a>
</div>