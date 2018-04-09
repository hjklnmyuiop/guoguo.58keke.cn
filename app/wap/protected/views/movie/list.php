<script src="/style/js/jquery.min.js" type="text/javascript"></script>
<script src="/style/js/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
<?php
use yii\captcha\Captcha;
use yii\helpers\Url;
use yii\helpers\Html;
$this->title = $settingData['web_name']."-资讯";
$this->web_keyword = $settingData['web_keyword'];
$this->web_desc = $settingData['web_desc'];

?>
<?php echo $this->render('/public/head', ['uid'=>$uid,'navcss'=>$navcss,'member'=>$member_info]); ?>
<section>
	<div class="wp">
		<ul  class="crumbs">
			<li><a href="index.html">首页</a>></li>
			<li>公开课</li>
		</ul>
	</div>
</section>


<section>
	<div class="wp">

		<div class="list" style="margin-top:0;">

			<div class="layout">
				<div class="head">
					<ul class="tab_header">
						<li <?php if($type=="in_theaters"):?>class="active"<?php endif ?>><a href="?search[type]=in_theaters">正在热映 </a></li>
						<li <?php if($type=="comingSoon"):?>class="active"<?php endif ?>><a href="?search[type]=comingSoon">即将上映</a></li>
						<li <?php if($type=="top250"):?>class="active"<?php endif ?>><a href="?search[type]=top250">Top250</a></li>
					</ul>
				</div>
				<div id="inWindow">
					<div class="tab_cont " id="content">
						<div class="group_list">
							<?php if(is_array($data) && !empty($data)) :?>
							<?php foreach($data as $k => $v) :?>
							<div style="width: 278px;height: 496px" class="box">
								<a href="<?=Url::toRoute(['movie/detail','id'=>$v->id])?>">
									<img width="278" style="height: 376px" class="scrollLoading" src="<?=$v->images->large?>"/>
								</a>
								<div class="des">
									<a href="<?=Url::toRoute(['movie/detail','id'=>$v->id])?>">
										<h2><?=($v->title)?></h2>
									</a>
									<span class="fl"><?=implode(' ',$v->genres)?></span>
									<span class="fr">评分：<?=$v->rating->average?>&nbsp;&nbsp;</span>
								</div>
								<div class="bottom">
									<span class="fl" title="慕课网">年份：<?=$v->year?></span>
									<span class="star fr"><?=$v->rating->stars?></span>
								</div>
							</div>
								<?php endforeach;?>
							<?php endif;?>

						</div>
						<div class="pageturn">
							<ul class="pagelist">

								<ul class="pagination"><li <?php if($page==1): ?>class="active"<?php endif?>>
										<a href="/movie/list?search[type]=<?=$type?>&page=1">首页</a>
									</li>
									<?php for($i=2;$i<10;$i++){?>
										<li <?php if($page==$i): ?>class="active"<?php endif?>>
											<a href="/movie/list?search[type]=<?=$type?>&page=<?=$i?>"><?=$i?></a>
											</li>
									<?php }?>
									<li <?php if($page==10): ?>class="active"<?php endif?>><a href="/movie/list?search[type]=<?=$type?>&&page=10">尾页</a></li></ul>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php echo $this->render('/public/footer'); ?>
