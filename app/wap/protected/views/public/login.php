
<?php
use yii\captcha\Captcha;
use yii\helpers\Url;
$this->title = $settingData['web_name']."-登录";
$this->web_keyword = $settingData['web_keyword'];
$this->web_desc = $settingData['web_desc'];

?>
<style type="text/css">
	.aui-login-l .btn-login {
		display: block;
		background: #5dbf45;
		width: 100%;
		border-radius: 2px;
		height: 44px;
		text-align: center;
		color: #fff;
	}
	.error {
		background: #fb8344;
		color: #fff !important;
		text-align: center;
		line-height: 40px !important;
		margin: 10px 0;
	}
</style>
<div class="header">
	<div class="" style="background:none"></div>
	<div class="toolbar statusbar-padding">
		<button class="bar-button back-button" style="left:-10px" onclick="history.go(-1);" dwz-event-on-click="click"><i class="icon icon-back-s"></i></button>
		<div class="header-title">
			<div class="title"></div>
		</div>
	</div>
</div>

<div class="aui-login-ba" style="position:relative; overflow:hidden">

	<span class="aui-login-logo"><img src="/style/images/logo.png"></span>

	<canvas id="waves" class="waves" style="position:absolute; bottom:-60px; left:-210px;"></canvas>

</div>
<form  method="post" autocomplete="off" id="jsLoginForm">
	<div class="aui-logon-con">
	<div class="b-line">
		<input name="phone" id="account_l" type="text" placeholder="手机号/邮箱" />
	</div>
	<div class="b-line">
		<input name="pawd" id="password_l" type="password" placeholder="请输入您的密码" />
	</div>
	<div class="error btns login-form-tips" id="jsLoginTips"></div>
	<div class="aui-login-l">
		<input class="btn-login" id="jsLoginBtn" type="button" value="立即登录" />
	</div>
	<div class="aui-login-wen">
		<div class="aui-login-wen-a"><a href="<?=Url::toRoute(['public/register'])?>">注册</a> </div>
	</div>
	<div class="aui-login-san">
		<div class="aui-login-qq"><a href="#"></a></div>
		<div class="aui-login-wb"><a href="#"></a></div>
		<div class="aui-login-wx"><a href="#"></a></div>
	</div>
</div>
</form>
<script src="/style/js/jquery.min.js" type="text/javascript"></script>
<script src="/style/js/login.js"  type="text/javascript"></script>
<script src="/style/js/validateDialog.js" type="text/javascript"></script>
