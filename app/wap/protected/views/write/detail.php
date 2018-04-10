<?php
use yii\helpers\Url;
$this->title = $detail->name;
?>
<style>
	.fav {
		background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0, #feab47), color-stop(1, #ff5200));
		width: 90%;
		padding: 10px 0;
		text-align: center;
		color: #fff;
		display: block;
		border-radius: 2px;
		margin: 0 5%;
	}
</style>
<div class="header">
	<div class="header-background"></div>
	<div class="toolbar statusbar-padding">
		<button class="bar-button back-button" onclick="history.go(-1);" dwz-event-on-click="click"><i class="icon icon-back"></i></button>
		<!--<a class="bar-button" data-href="home.html?dwz_callback=home_render" target="navTab" rel="home"><i class="icon icon-back"></i></a>-->
		<div class="header-title">
			<div class="title"><?=$this->title?></div>
		</div>
	</div>
</div>
<div style="height:44px"></div>


<div style="padding-bottom:20px">
	<div class="list-s">
		<div class="aui-list-cells">
			<a class="aui-list-cell">
				<div class="aui-list-cell-fl"><img src="<?=$detail->head?>" style="border-radius:100%"></div>
				<div class="aui-list-cell-cn"><?=$detail->name?></div>
				<div class="aui-list-cell-fl">(<?=$detail->arti_num?>)</div>
			</a>
		</div>
		<div class="aui-list-si">
			<p><?=date("Y-m-d",$detail->lastlogin)?></p>
			<h2><?=$detail->intro?></h2>
		</div>
		<div class="main_con" style="margin-bottom:0;">
			<div class="main_con_goods">
				<ul>
					<?php if(is_array($data) && !empty($data)) :?>
					<?php foreach($data as $k => $v) :?>
					<li>
						<section class="aui-crl" style="padding-left:15px">
							<img src="<?=$v->thumb?>">
						</section>
						<div style="width: 225px; padding-left: 10px;" class="">
							<h2><?=$v->title?></h2>
							<p class="aui-o"><?=$v->tags?></p>
							<p class="money">收藏数：<em class="aui-redd"><?=$v->collect?>&nbsp;&nbsp;</em>
							</p>
						</div>
					</li>
						<?php endforeach;?>
					<?php endif;?>
				</ul>
			</div>
		</div>
	</div>
</div>

<div class="t-line aui-wallet-recharge fav" id="jsRightBtn" data-favid="<?=$detail->id?>" style="padding-bottom:20px">
	收藏
</div>
<div style="height:44px"></div>
<?php echo $this->render('/public/footer',['navcss'=>$navcss]); ?>
<script src="/style/js/page/js/jquery.min.js"></script>
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
	$('#jsRightBtn').on('click', function(){

		add_fav($(this), $(this).data("favid"), 2);
	});


</script>
