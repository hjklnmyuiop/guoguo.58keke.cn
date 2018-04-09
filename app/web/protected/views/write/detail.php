<script src="/style/js/jquery.min.js" type="text/javascript"></script>
<script src="/style/js/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
<?php
use yii\helpers\Url;
$this->title = $detail->name;
?>
<?php echo $this->render('/public/head', ['uid'=>$uid,'navcss'=>$navcss,'member'=>$member_info]); ?>
<section>
	<div class="wp">
		<ul  class="crumbs">
			<li><a href="index.html">首页</a>></li>
			<li><a href="teachers-list.html">会员列表</a>></li>
			<li>会员详情</li>
		</ul>
	</div>
</section>
<section>
	<div class="wp butler-detail-box butler-diaryd-box clearfix">
		<div class="fl list">
			<div class="butler_detail_list clearfix">
				<div class="brief">
					<dl class="des">
						<dt>
						<div class="picpic">
							<img width="100" height="100" src="<?=$detail->head?>"/>
						</div>
						<div class="btn">
                                <span class="fl btn1 collectionbtn" id="jsLeftBtn">
                                     收藏
                                </span>
                                <span class="fr btn2 shareBtn bdsharebuttonbox"
									  data-text="授课教师-李老师-果果网"
									  data-desc="我在#慕课网#发现了"
									  data-comment="李老师，工作年限：5年；学历：本科；所在公司：阿里巴巴&nbsp;；经典案例：django入门和深入；flask入门"
									  data-url="/diary/hk_detail/10/">
                                    <span class="fl">分享</span>
                                    <a href="#" class="bds_more" data-cmd="more"></a>
                                </span>
						</div>
						</dt>
						<dd>
							<a href="/diary/hk_detail/10/">
								<h1><?=$detail->name?><span class="key picbig"></span></h1>
							</a>
							<ul class="cont">
								<li>性别：<span><?=$detail->sex==1?"男":"女"?></span></li>
								<li>文章数：<span><?=$detail->arti_num?></span></li>
								<li>登录数：<span><?=$detail->login_num?></span></li>
								<li>简介：<span><?=$detail->intro?></span></li>
							</ul>
						</dd>
					</dl>
				</div>
			</div>
			<div class="butler_detail_cont clearfix">
				<div class="left layout">
					<div class="head">
						<ul class="tab_header">
							<li class="active"><a href="/diary/hk_detail/10/">全部课程</a> </li>
						</ul>
					</div>
					<div class="companycenter">
						<div class="group_list brief">
							<?php if(is_array($data) && !empty($data)) :?>
								<?php foreach($data as $k => $v) :?>
								<div class="module1_5 box">
									<a href="<?=Url::toRoute(['news/detail','id'=>$v->id])?>">
										<img width="280" height="350" class="scrollLoading" src="<?=$v->thumb?>"/>
									</a>
									<div class="des">
										<a href="course-detail.html">
											<h2><?=($v->title)?></h2>
										</a>
										<span class="fl"><?=$v->tags?></span>
										<span class="fr">点击数：<?=$v->clicknum?>&nbsp;&nbsp;</span>
									</div>
									<div class="bottom">
										<a href="course-detail.html"><span class="fl"><?=$v->title?></span></a>
                                    <span class="star fr  notlogin" data-favid="15">
                                        <?=$v->collect?>
                                    </span>
									</div>
							</div>
								<?php endforeach;?>
							<?php endif;?>
						</div>
					</div>
					<!--<div class="pageturn">-->
					<!--<ul class="pagelist">-->
					<!--<li class="active"><a href="?page=1">1</a></li>-->
					<!--</ul>-->
					<!--</div>-->
				</div>
			</div>
		</div>
		<div class="fr list">
			<div class="butler_detail_cont">
				<div class="butler_list_box">
					<div class="right layout">
						<div class="head">作者排行榜</div>
						<?php if(is_array($hot_new) && !empty($hot_new)) :?>
						<?php foreach($hot_new as $k => $v) :?>
						<dl class="des">
							<span class="num fl"><?=$k?></span>
							<a href="<?=Url::toRoute(['write/detail','id'=>$v['id']])?>">
								<dt>
									<img width="50" height="50" class="scrollLoading" src="<?=$v->head?>"/>
								</dt>
							</a>
							<dd>
								<a href="<?=Url::toRoute(['write/detail','id'=>$v['id']])?>">
									<h1 title="bobby"><?=$v->name?></h1>
								</a>
								<p>文章数：<span><?=$v->arti_num?></span></p>
							</dd>
						</dl>
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

<script type="text/javascript">
	//收藏分享
	function add_fav(current_elem, fav_id, fav_type){
		$.ajax({
			cache: false,
			type: "POST",
			url:"/org/add_fav/",
			data:{'fav_id':fav_id, 'fav_type':fav_type},
			async: true,
			beforeSend:function(xhr, settings){
				xhr.setRequestHeader("X-CSRFToken", "5I2SlleZJOMUX9QbwYLUIAOshdrdpRcy");
			},
			success: function(data) {
				if(data.status == 'fail'){
					if(data.msg == '用户未登录'){
						window.location.href="login.html";
					}else{
						alert(data.msg)
					}

				}else if(data.status == 'success'){
					current_elem.text(data.msg)
				}
			},
		});
	}

	$('#jsLeftBtn').on('click', function(){
		add_fav($(this), 1, 3);
	});

	$('#jsRightBtn').on('click', function(){
		add_fav($(this), 1, 2);
	});


</script>
