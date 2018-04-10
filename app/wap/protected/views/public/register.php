<?php
use yii\captcha\Captcha;
use yii\helpers\Url;
$this->title = $settingData['web_name']."-登录";
$this->web_keyword = $settingData['web_keyword'];
$this->web_desc = $settingData['web_desc'];

?>
<link rel="stylesheet" type="text/css" href="/style/css/guoguo.css">
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

<form id="email_register_form" method="post" action="" autocomplete="off">
	<div class="aui-logon-con">
	<div class="b-line">
		<input  type="text" id="id_email" name="User[email]" value="None" placeholder="请输入您的邮箱地址" />
	</div>
	<div class="b-line">
		<input type="password" id="id_password" name="User[pawd]"  value="None" placeholder="请输入6-20位非中文字符密码" />
	</div>
	<div class="b-line">
		<input type="password" placeholder="确认密码">
	</div>
	<div class="aui-login-l">
		<input class="btn-reg" id="jsEmailRegBtn" type="button" value="注册并登录" />
	</div>
	<div class="aui-login-wen">
		<div class="aui-login-wen-a"><a href="<?=Url::toRoute(['public/login'])?>">去登录</a> </div>
		<!--<div><a href="#">忘记密码?</a> </div>-->
	</div>
	<!--<div class="aui-login-san">-->
	<!--<div class="aui-login-qq"><a href="#"></a></div>-->
	<!--<div class="aui-login-wb"><a href="#"></a></div>-->
	<!--<div class="aui-login-wx"><a href="#"></a></div>-->
	<!--</div>-->
</div>
</form>
<div class="dialog" id="jsDialog" style="display: none">
	<div class="successbox dialogbox" id="jsSuccessTips">
		<h1>成功提交</h1>
		<div class="close jsCloseDialog"><img src="/style/images/dig_close.png"/></div>
		<div class="cont">
			<h2>您的需求提交成功！</h2>
			<p></p>
		</div>
	</div>
</div>
<script src="/style/js/jquery.min.js" type="text/javascript"></script>
<script src="/style/js/login.js"  type="text/javascript"></script>
<script src="/style/js/validateDialog.js" type="text/javascript"></script>

