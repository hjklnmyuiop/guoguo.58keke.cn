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
			<li><a href="/">首页</a>></li>
			<li>电影推荐</li>
		</ul>
	</div>
</section>

<section>
	<div class="module">
		<div class="wp">
			<div class="module1 eachmod">
				<div class="module1_1 left" style="height: 900px">
					<img width="228" height="900" src="/style/images/module1_1.jpg"/>
					<p class="fisrt_word">正在<br/>热映</p>
					<a class="more" href="<?=Url::toRoute(['movie/list','search[type]'=>'in_theaters'])?>">查看更多电影 ></a>
				</div>
				<div class="right group_list">
					<?php if(is_array($in_theaters->subjects) && !empty($in_theaters->subjects)) :?>
					<?php foreach($in_theaters->subjects as $k => $v) :?>
					<?php if($k<2):?>
					<div class="box module1_3" style="margin-right: 10px;width: 229px;height: 443px">
						<?php else:?>
						<div class="module1_<?=$k+1?> box" style="height: 443px">
							<?php endif;?>
							<a href="<?=Url::toRoute(['movie/detail','id'=>$v->id])?>">
								<img style="height: 333px" width="233" src="<?=$v->images->large?>"/>
							</a>
							<div class="des">
								<a href="<?=Url::toRoute(['news/detail','id'=>$v->id])?>">
									<h2 style="overflow: hidden;height: 50px" ><?=($v->title)?></h2>
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
				</div>
			</div>
		</div>
	</div>
</section>
<section>
	<div class="module">
		<div class="wp">
<!--			<h1>即将上映</h1>-->
			<div class="module1 eachmod">
				<div class="module1_1 left" style="height: 900px">
					<img width="228" height="900" src="/style/images/module1_1.jpg"/>
					<p class="fisrt_word">即将<br/>上映</p>
					<a class="more" href="<?=Url::toRoute(['movie/list','search[type]'=>'coming_soon'])?>">查看更多电影 ></a>
				</div>
				<div class="right group_list">
					<?php if(is_array($coming_soon->subjects) && !empty($coming_soon->subjects)) :?>
					<?php foreach($coming_soon->subjects as $k => $v) :?>
					<?php if($k<2):?>
					<div class="box module1_3" style="margin-right: 10px;width: 229px;height: 443px">
						<?php else:?>
						<div class="module1_<?=$k+1?> box" style="height: 443px">
							<?php endif;?>
							<a href="<?=Url::toRoute(['movie/detail','id'=>$v->id])?>">
								<img style="height: 333px" width="233" src="<?=$v->images->large?>"/>
							</a>
							<div class="des">
								<a href="<?=Url::toRoute(['news/detail','id'=>$v->id])?>">
									<h2 style="overflow: hidden;height: 50px" ><?=($v->title)?></h2>
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
				</div>
			</div>
		</div>
	</div>
</section>
<section>
	<div class="module">
		<div class="wp">
<!--			<h1>Top250</h1>-->
			<div class="module1 eachmod">
				<div class="module1_1 left" style="height: 900px">
					<img width="228" height="900" src="/style/images/module1_1.jpg"/>
					<p class="fisrt_word">Top<br/>250</p>
					<a class="more" href="<?=Url::toRoute(['movie/list','search[type]'=>'top250'])?>">查看更多电影 ></a>
				</div>
				<div class="right group_list">
					<?php if(is_array($top250->subjects) && !empty($top250->subjects)) :?>
					<?php foreach($top250->subjects as $k => $v) :?>
					<?php if($k<2):?>
					<div class="box module1_3" style="margin-right: 10px;width: 229px;height: 443px">
						<?php else:?>
						<div class="module1_<?=$k+1?> box" style="height: 443px">
							<?php endif;?>
							<a href="<?=Url::toRoute(['movie/detail','id'=>$v->id])?>">
								<img style="height: 333px" width="233" src="<?=$v->images->large?>"/>
							</a>
							<div class="des">
								<a href="<?=Url::toRoute(['news/detail','id'=>$v->id])?>">
									<h2 style="overflow: hidden;height: 50px" ><?=($v->title)?></h2>
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
				</div>
			</div>
		</div>
	</div>
</section>
<?php echo $this->render('/public/footer'); ?>
<script src="/style/js/selectUi.js" type='text/javascript'></script>
<script src="/style/js/deco-common.js" type='text/javascript'></script>
<script type="text/javascript" src="/style/js/plugins/laydate/laydate.js"></script>
<script src="/style/js/plugins/layer/layer.js"></script>
<script src="/style/js/plugins/queryCity/js/public.js" type="text/javascript"></script>
<script src="/style/js/unslider.js" type="text/javascript"></script>
<script src="/style/js/plugins/jquery.scrollLoading.js"  type="text/javascript"></script>
<script src="/style/js/deco-common.js"  type="text/javascript"></script>
