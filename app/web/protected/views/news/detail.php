<script src="/style/js/jquery.min.js" type="text/javascript"></script>
<script src="/style/js/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
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
				<li><a href="<?=Url::toRoute(['news/list','id'=>$detail->cate_id])?>">公开课程</a>></li>
				<li>课程详情</li>
			</ul>
		</div>
	</div>
</section>
<section>
	<div class="wp">
		<div class="groupPurchase_detail detail">
			<div class="toppro">
				<div class="left">
					<div class="picbox">
						<div class="tb-booth tb-pic">
							<img width="440" height="445" src="<?=$detail->thumb?>" class="jqzoom" />
						</div>

					</div>
					<div class="des">
						<h1 title="<?=$detail->title?>"><?=$detail->title?></h1>
						<span class="key"><?=$detail->title?></span>
						<div class="prize">
							<span class="fl">难度：<i class="key">高级</i></span>
							<span class="fr">学习人数：<?=$detail->clicknum?></span>
						</div>
						<ul class="parameter">
							<li><span class="pram word3">收&nbsp;藏&nbsp;数：</span><span><?=$detail->collect?></span></li>
							<li><span class="pram word3">课程类别：</span><span title=""><?=$detail->category->name?></span></li>
							<li><span class="pram word4">标签：</span><span title=""><?=$detail->tags?></span></li>
						</ul>
						<div class="btns">
							<div class="btn colectgroupbtn"  id="jsLeftBtn" data-favid="<?=$detail->id?>">
								收藏
							</div>
<!--							<div class="buy btn"><a style="color: white" href="course-video.html">开始学习</a></div>-->
						</div>
					</div>
					<div class="group-share-box">
						<div class="bdsharebuttonbox"
							 data-text="django开始了"
							 data-desc="我在#慕课网#发现了"
							 data-comment=""
							 data-url="/group/groupdetail/15/">
							<span class="fl">分享到：</span>
							<a href="#" class="bds_more" data-cmd="more"></a>
							<a title="分享到QQ空间" href="#" class="bds_qzone" data-cmd="qzone"></a>
							<a title="分享到新浪微博" href="#" class="bds_tsina" data-cmd="tsina"></a>
							<a title="分享到腾讯微博" href="#" class="bds_tqq" data-cmd="tqq"></a>
							<a title="分享到人人网" href="#" class="bds_renren" data-cmd="renren"></a>
							<a title="分享到微信" href="#" class="bds_weixin" data-cmd="weixin"></a>
						</div>
					</div>
				</div>
				<div class="right">
					<div class="head">
						<h1>作者</h1>
						<p><?=$detail->user->intro?></p>
					</div>
					<div class="pic">
						<a href="/company/14/">
							<img width="150" height="80" src="<?=$detail->user->head?>"/>
						</a>
					</div>
					<a href="/company/14/">
						<h2 class="center" title="<?=$detail->user->name?>"><?=$detail->user->name?></h2>
					</a>
					<div class="btn  notlogin
					     "data-favid="<?=$detail->user->id?>" id="jsRightBtn">
						收藏
					</div>
					<div class="clear">
						<ul>
							<li>
								<span>文 &nbsp;章&nbsp; 数：&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   <?=$detail->user->arti_num?></span>
							</li>
							<li><span>收 &nbsp;藏&nbsp; 数：&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   <?=$detail->user->collect?></span>
							</li>
							<li>所在地区：&nbsp;&nbsp;<?=$detail->user->address?></li>
						</ul>
					</div>
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
					<?=$detail->content?>
				</div>
				<div class="tab_cont tab_cont2" >
					<div class="comment">
						<div class="comenlist">

						</div>
					</div>
				</div>
			</div>
			<div class="right layout">
				<div class="head">相关文章推荐</div>
				<div class="group_recommend">
					<?php if(is_array($laset_new) && !empty($laset_new)) :?>
					<?php foreach($laset_new as $k => $v) :?>
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
			type: "GET",
			url:"/u/addfav/",
			data:{'fav_id':fav_id, 'fav_type':fav_type},
			dataType: 'json',
			async: true,
			success: function(data) {
				if(data.status == '2'){
					window.location.href = '/public/login?ref='+window.location.href;
				}else if(data.status == '1'){
					current_elem.text(data.msg)
				}else {
					alert(data.msg)
				}
			},
		});
	}

	$('#jsLeftBtn').on('click', function(){
		add_fav($(this), $(this).data("favid"), 1);
	});

	$('#jsRightBtn').on('click', function(){
		add_fav($(this), $(this).data("favid"), 2);
	});


</script>
