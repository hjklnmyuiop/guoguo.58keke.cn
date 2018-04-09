<?php
use yii\helpers\Url;
$this->title = $detail->title;
?>
<style>
	 .desc{
		clear: both;
		width: 96%;
		padding: 2%;
		height: auto;
		overflow: hidden;
		line-height: 200%;
		margin-bottom: 50px;
	}
	 .aui-li {
		 /*padding:0 40px;*/
		 float: left;
		 position: relative;
		 display: -webkit-box;
		 display: -webkit-flex;
		 display: flex;
		 -webkit-box-align: center;
		 -webkit-align-items: center;
		 align-items: right;
	 }
	 .aui-icon-gz {
		 height: 40px;
		 margin-top: 10px;;
	 }
</style>
<div class="item">
	<div class="header">
		<div class="" style="background:none"></div>
		<div class="toolbar statusbar-padding">
			<button class="bar-button back-button" onclick="history.go(-1);" dwz-event-on-click="click"><i class="icon icon-back-i"></i></button>
			<div class="header-title">
				<div class="title"></div>
			</div>
		</div>
	</div>

	<!-- 首页轮播 begin -->
	<div class="aui-banner-content">
		<div id="focus" class="focus">
			<div class="bd">
				<div class="tempWrap" style="overflow:hidden; position:relative;">
					<ul>
						<li>
							<a href="#"><img src="<?=$detail->thumb?>"></a>
						</li>

					</ul>
				</div>
			</div>
		</div>
	</div>
	<!-- 首页轮播 end -->

	<section class="header" style="position:inherit">
		<h2 class="title"><?=$detail->title?></h2>
		<div class="price ">
			<div class="current-price">
				<span class="current-price"><small>学习人数：</small><?=$detail->clicknum?></span>
			</div>
			<span class="express"><?=$detail->category->name?></span>
		</div>
		<div class="sales">收藏人数:<?=$detail->collect?></div>
	</section>

	<section class="sku">
		<dl class="sku-group">
			<dt><?=$detail->tags?></dt>
		</dl>
	</section>
</div>


<section class="content">
	<div class="desc">
		<?=$detail->content?>
	</div>

</section>

<footer class="footer t-line">
	<div class="aui-car-ear">
		<div class="aui-car-ear-cell">
			<div class="aui-li">

			</div>
		</div>
		<div class="aui-car-all"  id="jsLeftBtn" data-favid="<?=$detail->id?>">
			收藏
		</div>

	</div>

</footer>
<script src="/style/js/page/js/jquery.min.js"></script>
<script>

	var path = "{:U('buy')}?id=";
	//兼容性：字体大小，全局尺寸(rem)
	(function(doc, win) {
		var docEl = doc.documentElement,
				resizeEvt = 'orientationchange' in window ? 'orientationchange' : 'resize',
				recalc = function() {
					var clientWidth = docEl.clientWidth;
					if (!clientWidth) return;
					var docElWidth = 100 * (clientWidth / 640);
					if (docElWidth > 100) docElWidth = 100;
					docEl.style.fontSize = docElWidth + 'px';
				};
		if (!doc.addEventListener) return;
		win.addEventListener(resizeEvt, recalc, false);
		doc.addEventListener('DOMContentLoaded', recalc, false);
	})(document, window);

	(function(){
		//轮播图
		new Swiper('.swiper-container', {
			pagination: '.swiper-pagination',
			paginationClickable: true,
			autoplay:3000
		});

		$('.nav a').click(function(){
			$('.nav a').removeClass('active');
			$(this).addClass('active');
		})
		//sku
		$('.sku,.buy').click(function(){
			$('.layer').addClass('acitve');
		})
		$('.close').click(function(){
			$('.layer').removeClass('acitve');
		});
		//却动
		$('#sku a').click(function(){
			console.log(this);
			$('#sku a').removeClass('active');
			$(this).addClass('active');
			$('.next').attr('href',path + $(this).data('sku'));
			$('.sku-group dd').text($(this).text());
		});
		//图片懒加载
		$("img").lazyload({
			effect : 'fadeIn',
			placeholder :'http://img.weizhi.so/placeholder.png'
		});

	})();

</script>
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