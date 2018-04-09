<script src="/style/js/jquery.min.js" type="text/javascript"></script>
<script src="/style/js/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
<style>
	/*.comenlist .box {*/
		/*height: 394px;*/
		/*border: 1px solid #ccc;*/
		/*width: 257px;*/
		/*float: left;*/
		/*overflow: hidden;*/
		/*position: relative;*/
		/*margin: 3px;*/
	/*}*/
	.comenlist .box {
		height: 284px;
		border: 1px solid #ccc;
		width: 172px;
		float: left;
		overflow: hidden;
		position: relative;
		margin: 3px;
	}
	.comenlist .box a {
		width: 100%;
	}
	.comenlist .box img {
		width: 172px;
		height: 244px;
	}
	.comenlist .box .des {
		height: 40px;
		/*width: 100%;*/
	}

	.comenlist .box .des h2 {
		font-size: 18px;
		line-height: 30px;
		text-align: center;
	}

	.comenlist .des span {
		font-size: 14px;
	}
</style>
<?php
use yii\helpers\Url;
$this->title = $detail->title;
?>
<?php echo $this->render('/public/head', ['uid'=>$uid,'navcss'=>$navcss,'member'=>$member_info]); ?>
<section>
	<div class="wp">
		<div class="crumbs">
			<ul>
				<li><a href="index.html">首页</a>></li>
				<li><a href="<?=Url::toRoute(['movie/list'])?>">电影</a>></li>
				<li>电影详情</li>
			</ul>
		</div>
	</div>
</section>

<section>
	<div class="wp">
		<div class="groupPurchase_detail detail">
			<div class="toppro">
				<div class="left">
					<div class="picbox" style=" width: 270px">
						<div class="tb-booth tb-pic" style="height: 378px">
							<img width="270" height="378" src="<?=$detail->images->large?>" class="jqzoom" />
						</div>

					</div>
					<div class="des">
						<h1 title="django 从入门到精通体验开始了"><?=$detail->title?></h1>
						<span class="key"><?=$detail->countries[0]?><?=$detail->year?></span>
						<div class="prize">
							<span class="fl"><i class="key"><?=$detail->wish_count?></i>人喜欢</span>
							<span class="fr"><?=$detail->comments_count?>条评论</span>
						</div>
						<ul class="parameter">
							<li><span class="pram word3">评&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;分：</span><span><?=$detail->rating->average?></span></li>
							<li><span class="pram word3">导&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;演：</span><span><?=$detail->directors[0]->name?></span></li>
							<li><span class="pram word3">类&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;型：</span><span><?=implode(' ',$detail->genres)?></span></li>

							</li>
						</ul>
					</div>
<!--					<div class="group-share-box">-->
<!--						<div class="bdsharebuttonbox"-->
<!--							 data-text="django开始了"-->
<!--							 data-desc="我在#慕课网#发现了"-->
<!--							 data-comment=""-->
<!--							 data-url="/group/groupdetail/15/">-->
<!--							<span class="fl">分享到：</span>-->
<!--							<a href="#" class="bds_more" data-cmd="more"></a>-->
<!--							<a title="分享到QQ空间" href="#" class="bds_qzone" data-cmd="qzone"></a>-->
<!--							<a title="分享到新浪微博" href="#" class="bds_tsina" data-cmd="tsina"></a>-->
<!--							<a title="分享到腾讯微博" href="#" class="bds_tqq" data-cmd="tqq"></a>-->
<!--							<a title="分享到人人网" href="#" class="bds_renren" data-cmd="renren"></a>-->
<!--							<a title="分享到微信" href="#" class="bds_weixin" data-cmd="weixin"></a>-->
<!--						</div>-->
<!--					</div>-->
				</div>
			</div>
		</div>
	</div>
</section>
<section>
	<div class="wp">
		<div class="list groupPurchase_detail_pro">
			<div class="left layout">
				<div class="head">
					<ul class="tab_header">
						<li class="active">课程详情</li>
					</ul>
				</div>
				<div class="tab_cont tab_cont1">
					<?=$detail->summary?>
				</div>
				<div class="tab_cont tab_cont2" style="display: block" >
					<div class="comment">
						<div class="comenlist">
							<?php if(is_array($detail->casts) && !empty($detail->casts)) :?>
							<?php foreach($detail->casts as $k => $v) :?>
							<div class="box">
								<a>
									<img class="scrollLoading" src="<?=$v->avatars->large?>"/>
								</a>
								<div class="des">
									<a href="course-detail.html">
										<h2> <?=$v->name?></h2>
									</a>
								</div>
							</div>
								<?php endforeach;?>
							<?php endif;?>
						</div>
					</div>
				</div>
			</div>
			<div class="right layout">
				<div class="head">热门文章推荐</div>
				<div class="group_recommend">
					<?php if(is_array($tuijian) && !empty($tuijian)) :?>
						<?php foreach($tuijian as $k => $v) :?>
							<dl>
								<dt>
									<a target="_blank" href="<?=Url::toRoute(['news/detail','id'=>$v->id])?>">
										<img width="240" height="220" class="scrollLoading" src="<?=$v->thumb?>"/>
									</a>
								</dt>
								<dd>
									<a target="_blank" href=""><h2> <?=$v->title?></h2></a>
									<span class="fl">学习人数：<i class="key"><?=$v->clicknum?></i></span>
								</dd>
							</dl>
						<?php endforeach;?>
					<?php endif;?>
				</div>
			</div>
		</div>
	</div>
</section>

<?php echo $this->render('/public/footer'); ?>

