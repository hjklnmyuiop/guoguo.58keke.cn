<?php
use yii\helpers\Url;

$this->title = $settingData['web_name']."-首页";
$this->web_keyword = $settingData['web_keyword'];
$this->web_desc = $settingData['web_desc'];

?>
<?php echo $this->render('/public/head', ['uid'=>$uid,'navcss'=>$navcss,'member'=>$member_info]); ?>
<script src="/style/js/jquery.min.js" type="text/javascript"></script>
<script src="/style/js/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
<div class="banner">
	<div class="wp">
		<div class="fl">
			<div class="imgslide">
				<ul class="imgs">
					<?php if(is_array($banner) && !empty($banner)) :?>
					<?php foreach($banner as $k => $v) :?>
					<li>
						<a href="<?=$v->url?>">
							<img width="1200" height="478" src="<?=$v->image?>" />
						</a>
					</li>
						<?php endforeach;?>
					<?php endif;?>
				</ul>
			</div>
			<div class="unslider-arrow prev"></div>
			<div class="unslider-arrow next"></div>
		</div>

	</div>


</div>
<!--banner end-->
<!--feature start-->
<section>
	<div class="wp">
		<ul class="feature">
			<?php if(is_array($hot_catogory) && !empty($hot_catogory)) :?>
			<?php foreach($hot_catogory as $k => $v) :?>
			<li class="feature1">
				<a href="<?=Url::toRoute(['news/list','id'=>$v->id])?>">
				<img class="pic" src="<?=$v->image?>"/>
				<p class="center"><?=$v->name?></p>
				</a>
			</li>
				<?php endforeach;?>
			<?php endif;?>
		</ul>
	</div>
</section>
<!--feature end-->
<!--module1 start-->
<section>
	<div class="module">
		<div class="wp">
			<h1>推荐文章</h1>
			<div class="module1 eachmod">
				<div class="module1_1 left">
					<img width="228" height="614" src="/style/images/module1_1.jpg"/>
					<a class="more" href="<?=Url::toRoute(['news/list'])?>">查看更多文章 ></a>
				</div>
				<div class="right group_list">
					<?php if(is_array($com_article) && !empty($com_article)) :?>
					<?php foreach($com_article as $k => $v) :?>
						<?php if($k<2):?>
					<div class="box module1_3" style="margin-right: 10px;width: 229px">
						<?php else:?>
					<div class="module1_<?=$k+1?> box">
						<?php endif;?>
						<a href="<?=Url::toRoute(['news/detail','id'=>$v->id])?>">
							<img width="233" height="190" src="<?=$v->thumb?>"/>
						</a>
						<div class="des">
							<a href="<?=Url::toRoute(['news/detail','id'=>$v->id])?>">
								<h2 style="overflow: hidden;height: 50px" ><?=($v->title)?></h2>
							</a>
							<span class="fl"><?=$v->tags?></span>
							<span class="fr">点击数：<?=$v->clicknum?>&nbsp;&nbsp;</span>
						</div>
						<div class="bottom">
							<span class="fl" title="慕课网"><?=$v->category->name?></span>
							<span class="star fr"><?=$v->collect?></span>
						</div>
					</div>
						<?php endforeach;?>
					<?php endif;?>
				</div>
			</div>
		</div>
	</div>
</section>
<section>
	<div class="module greybg">
		<div class="wp">
			<h1>推荐作者</h1>
			<div class="module3 eachmod">
				<div class="module3_1 left">
					<img width="228" height="463" src="/style/images/module3_1.jpg"/>
					<a class="more" href="<?=Url::toRoute(['write'])?>">查看更多作者 ></a>
				</div>
				<div class="right">
					<ul>
						<?php if(is_array($hot_user) && !empty($com_article)) :?>
						<?php foreach($hot_user as $k => $v) :?>
						<li class="<?php if(($k+1)%5==0 ):?>five<?php endif;?>">
							<a href="<?=Url::toRoute(['write/detail','id'=>$v->id])?>">
								<div class="company">
									<img width="184" height="100" src="<?=$v->head?>"/>
									<div class="score">
										<div class="circle">
											<h2><?=$v->name?></h2>
										</div>
									</div>
								</div>
								<p><span class="key" title="<?=$v->name?>"><?=$v->name?></span></p>
							</a>
						</li>
							<?php endforeach;?>
						<?php endif;?>


					</ul>
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

<script type="text/javascript" src="/style/js/index.js"></script>
</body>
</html>


