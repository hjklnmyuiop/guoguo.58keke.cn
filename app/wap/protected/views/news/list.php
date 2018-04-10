<?php
use yii\helpers\Url;

$this->title = $settingData['web_name']."-文章列表";
$this->web_keyword = $settingData['web_keyword'];
$this->web_desc = $settingData['web_desc'];
$title = !empty($search['keyword'])?$search['keyword']:'文章列表';
?>
<style type="text/css">
	.wrapper{
		height: 100%;
		overflow: hidden;
	}
	.pullup{
		display: block;
		width: 100%;
		text-align: center;
		padding: 10px 0;
	}
	.pulldowm{
		position: absolute;
		top: -40px;
		width: 100%;
		z-index: 100;
		text-align: center;
		height: 40px;
		background: #909090;
	}
	.img{
		transition: all .3s;
	}
</style>
<div class="header">
	<div class="header-background"></div>
	<div class="toolbar statusbar-padding">
		<button class="bar-button back-button" onclick="history.go(-1);" dwz-event-on-click="click"><i class="icon icon-back"></i></button>
		<div class="header-title">
			<div class="title"><?=$title?></div>
		</div>
	</div>
</div>
<div style="height:44px"></div>
<div class="aui-it-content wrapper">
	<div class="aui-it-list">
		<ul>
			<?php if(is_array($data) && !empty($data)) :?>
				<?php foreach($data as $k => $v) :?>
					<li>
						<a href="<?=Url::toRoute(['news/detail','id'=>$v->id])?>">
							<div class="aui-it-title"><img src="<?=$v->thumb?>" width="90"></div>
							<div class="aui-it-middle">
								<h2 style="padding-bottom:0;height: 30px; overflow: hidden"><?=($v->title)?></h2>
								<span class="aui-aui-s"><?=$v->clicknum?></span>
								<span class="aui-aui-s"><?=$v->category->name?></span>
								<span class="aui-aui-s"><?=$v->collect?></span>
								<p class="aui-spill"><?=$v->tags?></p>
							</div>
						</a>
					</li>
				<?php endforeach;?>
			<?php endif;?>
		</ul>
		<div class="pullup"><img src="/style/images/loading-2.gif" style="vertical-align: middle;" />加载中...</div>
	</div>
	<div class="pulldowm"><img class="img" src="/style/images/tou.png" style="vertical-align: middle;" />
		<span class="pulltext">下拉刷新</span></div>
</div>
<script type="text/javascript" src="/style/js/jquery-3.1.1.min.js"></script>
<script src="/style/js/bscroll.min.js"></script>
<script>
	var _url = "<?php echo  Url::toRoute(['news/ajax_newslist','id'=>$id,'search[keyword]'=>$search['keyword']]); ?>";
	var scroll = new BScroll('.wrapper',{
		click:true,
		pullUpLoad:true,
		scrollbar:true,
		pullDownRefresh:true,
		probeType:2
	})
	var data = [];
	var str = '';
	var page = 2;
	var l_page=<?=$l_page?>;
	$("li").click(function(){
		console.log($(this).index())
	})
	scroll.on('scrollEnd',function(pos){
		var y = pos.y;
		console.log(y)
		if(y == scroll.maxScrollY){
			console.log('shuaxin');
			if(page<=l_page){
				$.get(_url+'&page='+page,function(data){
					if(data.status == 1){
						var str = $(data.html);
						setTimeout(function(){
							$(".wrapper ul").append(str);
							scroll.finishPullUp();
							scroll.refresh()
							page++;
						},200)

					}
				},'json')
			}else {
//				$(".pullup").hide();
				$(".pullup").text('没有啦')
			}
		}
	})
	scroll.on("scroll",function(){
		var top = scroll.y-40;
		$(".pulldowm").css({top:top+'px'});
		if(scroll.y >= 90){
			$(".img").css({transform:'rotate(180deg)'})
		} else{
			$(".img").css({transform:'rotate(0deg)'})
		}
	})
	scroll.on('touchEnd',function(pos){
		console.log(pos)
		if(pos.y > 90){
			console.log('正在加载')
			$(".pulltext").text('正在加载').siblings(".img").attr("src","/style/images/loading-2.gif");
			setTimeout(function(){
				$(".pulldowm").css({top:-40+'px'});
//				$(".wrapper ul").prepend('<li>b</li>');
				window.location.reload();
				scroll.finishPullDown();
				scroll.refresh();
				$(".pulltext").text('下拉刷新').siblings(".img").attr("src","/style/images/tou.png")
			},2000)
		}
	})
</script>