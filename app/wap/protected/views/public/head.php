<?php
use yii\helpers\Url;
?>
<section class="headerwrap ">
	<header>
		<div  class=" header">
			<div class="top">
				<div class="wp">
<!--					<div class="fl"><p>服务电话：<b>33333333</b></p></div>-->
					<!--登录后跳转-->

					<?php if ($uid == 0): ?>
					 <a style="color:white" class="fr registerbtn" href="<?php echo Url::toRoute(['public/register']); ?>">注册</a>
					 <a style="color:white" class="fr loginbtn" href="<?php echo Url::toRoute(['public/login']); ?>">登录</a>
					<?php else: ?>
					<div class="personal">
						<dl class="user fr">
							<dd><?=$member['name']?><img class="down fr" src="/style/images/top_down.png"/></dd>
							<dt><img width="20" height="20" src="<?=$member['head']?>"/></dt>
						</dl>
						<div class="userdetail">
							<dl>
								<dt><img width="80" height="80" src="<?=$member['head']?>"/></dt>
								<dd>
									<h2><?=$member['name']?></h2>
									<p><?=$member['intro']?></p>
								</dd>
							</dl>
							<div class="btn">
								<a class="personcenter fl" href="<?php echo Url::toRoute(['u/dataset']); ?>">进入个人中心</a>
								<a class="fr" href="<?php echo Url::toRoute(['public/logout']); ?>/">退出</a>
							</div>
						</div>
					</div>
					<a href="<?=Url::toRoute(['u/message']) ?>">
						<div class="msg-num"><span id="MsgNum"><?=$member['unread_mes']?></span></div>
					</a>
					<?php endif; ?>

				</div>
			</div>

			<div class="middle">
				<div class="wp">
					<a href="index.html"><img class="fl" src="/style/images/logo.jpg"/></a>
					<div class="searchbox fr">
						<div class="selectContainer fl">
                            <span class="selectOption" id="jsSelectOption" data-value="article">
                                文章
                            </span>
							<ul class="selectMenu" id="jsSelectMenu">
								<li data-value="article">文章</li>
								<li data-value="user">作者</li>
							</ul>
						</div>
						<input id="search_keywords" class="fl" type="text" value="" placeholder="请输入搜索内容"/>
						<img class="search_btn fr" id="jsSearchBtn" src="/style/images/search_btn.png"/>
					</div>
				</div>
			</div>


			<nav>
				<div class="nav">
					<div class="wp">
						<ul>
							<li <?php if($navcss=='index'): ?>class="active"<?php endif;?> ><a href="/">首页</a></li>
							<li <?php if($navcss=='news'): ?>class="active"<?php endif;?> ><a href="<?=Url::toRoute(['/news/list'])?>">技术资讯</a>
							<li <?php if($navcss=='write'): ?>class="active"<?php endif;?> ><a href="<?=Url::toRoute(['/write'])?>">作者</a>
							<li <?php if($navcss=='movie'): ?>class="active"<?php endif;?> ><a href="<?=Url::toRoute(['/movie'])?>">电影推荐</a>
<!--							<li --><?php //if($navcss=='me'): ?><!--class="active"--><?php //endif;?><!-- ><a href="org-list.html">我的风采</a></li>-->
						</ul>
					</div>
				</div>
			</nav>

		</div>
	</header>
</section>