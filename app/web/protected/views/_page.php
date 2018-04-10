<?php
use yii\widgets\LinkPager;
?>
<div class="pagination mgt-50">
                <?php echo LinkPager::widget(['pagination' => isset($page) ? $page : '', 'nextPageLabel' => '下一页', 'prevPageLabel' => '上一页','firstPageLabel' => '首页', 'lastPageLabel'=>'尾页']);?>
</div>
