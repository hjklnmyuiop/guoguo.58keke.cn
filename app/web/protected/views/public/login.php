
<link rel="stylesheet" type="text/css" href="/style/css/reset.css">
<link rel="stylesheet" type="text/css" href="/style/css/login.css"/>
<?php
use yii\captcha\Captcha;
use yii\helpers\Url;
$this->title = $settingData['web_name']."-登录";
$this->web_keyword = $settingData['web_keyword'];
$this->web_desc = $settingData['web_desc'];

?>
<header>
	<div class="c-box fff-box">
		<div class="wp header-box">
			<p class="fl hd-tips">果果学习，在线学习平台！</p>
			<ul class="fr hd-bar">
				<li class="active"><a href="<?=Url::toRoute(['public/login'])?>">[登录]</a></li>
				<li><a href="<?=Url::toRoute(['public/register'])?>">[注册]</a></li>
			</ul>
		</div>
	</div>
</header>
<section>
	<div class="c-box bg-box">
		<div class="login-box clearfix">
			<div class="hd-login clearfix">
				<a class="index-logo" href="/"></a>
				<h1>用户登录</h1>
				<a class="index-font" href="/">回到首页</a>
			</div>
			<div class="fl slide" style="width: 314px">
				<div class="imgslide" style="width: 314px">
					<ul class="imgs">
						<li><a href=""><img width="314" height="472" src="/style/images/guoguo1.jpg" /></a></li>
						<li><a href=""><img width="314" height="472" src="/style/images/guoguo2.jpg" /></a></li>
<!--						<li><a href=""><img width="314" height="472" src="/style/images/guoguo3.jpg" /></a></li>-->
					</ul>
				</div>
				<div class="unslider-arrow prev"></div>
				<div class="unslider-arrow next"></div>
			</div>
			<div class="fl form-box">
				<h2>帐号登录</h2>
				<form  method="post" autocomplete="off" id="jsLoginForm">
					<input type='hidden' name='csrfmiddlewaretoken' value='mymQDzHWl2REXIfPMg2mJaLqDfaS1sD5' />
					<div class="form-group marb20 ">
						<label>用&nbsp;户&nbsp;名</label>
						<input name="phone" id="account_l" type="text" placeholder="手机号/邮箱" />
					</div>
					<div class="form-group marb8 ">
						<label>密&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;码</label>
						<input name="pawd" id="password_l" type="password" placeholder="请输入您的密码" />
					</div>
					<div class="error btns login-form-tips" id="jsLoginTips"></div>
					<div class="auto-box marb38">

						<a class="fr" href="forgetpwd.html">忘记密码？</a>
					</div>
					<input class="btn btn-green" id="jsLoginBtn" type="button" value="立即登录 > " />
				</form>
				<p class="form-p">没有果果学习帐号？<a href="<?=Url::toRoute(['public/register'])?>">[立即注册]</a></p>
			</div>
		</div>
	</div>
</section>
<script src="/style/js/jquery.min.js" type="text/javascript"></script>
<script src="/style/js/unslider.js" type="text/javascript"></script>
<script src="/style/js/login.js"  type="text/javascript"></script>
<script src="/style/js/validateDialog.js" type="text/javascript"></script>
