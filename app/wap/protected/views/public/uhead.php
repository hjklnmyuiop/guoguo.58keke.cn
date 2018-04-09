<?php
use yii\helpers\Url;
?>
<section class="headerwrap headerwrap2">
	<header>
		<div  class="header2 header">
			<div class="top">
				<div class="wp">
					<div class="fl"><p>服务电话：<b>33333333</b></p></div>
					<!--登录后跳转-->


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


				</div>
			</div>

			<div class="middle">
				<div class="wp">
					<a href="/"><img class="fl" src="/style/images/logo.png"/></a>
					<h1>果果学习网</h1>
				</div>
			</div>
		</div>
	</header>
</section>