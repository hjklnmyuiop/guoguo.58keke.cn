
<link rel="stylesheet" type="text/css" href="/style/css/reset.css">
<link rel="stylesheet" type="text/css" href="/style/css/login.css"/>
<?php
use yii\captcha\Captcha;
use yii\helpers\Url;
$this->title = $settingData['web_name']."-登录";
$this->web_keyword = $settingData['web_keyword'];
$this->web_desc = $settingData['web_desc'];

?>
<div class="dialog" id="jsDialog">
	<!--提示弹出框-->
	<div class="successbox dialogbox" id="jsSuccessTips">
		<h1>成功提交</h1>
		<div class="close jsCloseDialog"><img src="/style/images/dig_close.png"/></div>
		<div class="cont">
			<h2>您的需求提交成功！</h2>
			<p></p>
		</div>
	</div>
	<div  class="noactivebox dialogbox" id="jsUnactiveForm" >
		<h1>邮件验证提示</h1>
		<div class="close jsCloseDialog"><img src="/style/images/dig_close.png"/></div>
		<div class="center">
			<img src="/style/images/send.png"/>
			<p>我们已经向您的邮箱<span class="green" id="jsEmailToActive">12@13.com</span>发送了邮件，<br/>为保证您的账号安全，请及时验证邮箱</p>
			<p class="a"><a class="btn" id="jsGoToEmail" target="_blank" href="http://mail.qq.com">去邮箱验证</a></p>
			<p class="zy_success upmove"></p>
			<p style="display: none;" class="sendE2">没收到，您可以查看您的垃圾邮件和被过滤邮件，也可以再次发送验证邮件（<span class="c5c">60s</span>）</p>
			<p class="sendE">没收到，您可以查看您的垃圾邮件和被过滤邮件，<br/>也可以<span class="c5c green" id="jsSenEmailAgin" style="cursor: pointer;">再次发送验证邮件</span></p>
		</div>
	</div>
</div>

<div class="bg" id="dialogBg"></div>
<header>
	<div class="c-box fff-box">
		<div class="wp header-box">
			<p class="fl hd-tips">果果在线，在线学习平台！</p>
			<ul class="fr hd-bar">
				<li><a href="<?=Url::toRoute(['public/login'])?>">[登录]</a></li>
				<li class="active"><a href="<?=Url::toRoute(['public/register'])?>">[注册]</a></li>
			</ul>
		</div>
	</div>
</header>
<section>
	<div class="c-box bg-box">
		<div class="login-box clearfix">
			<div class="hd-login clearfix">
				<a class="index-logo" href="/"></a>
				<h1>用户注册</h1>
				<a class="index-font" href="/">回到首页</a>
			</div>
			<div class="fl slide">
				<div class="imgslide">
					<ul class="imgs">

						<li><a href=""><img width="483" height="472" src="/style/img/php.png" /></a></li>

						<li><a href=""><img width="483" height="472" src="/style/img/mysql.png" /></a></li>

						<li><a href=""><img width="483" height="472" src="/style/img/linux.png" /></a></li>

					</ul>
				</div>
				<div class="unslider-arrow prev"></div>
				<div class="unslider-arrow next"></div>
			</div>
			<div class="fl form-box">
				<div class="tab">
					<!--<h2 class="active">手机注册</h2>-->
					<h2>邮箱注册</h2>
				</div>

				<div class="tab-form">
					<form id="email_register_form" method="post" action="" autocomplete="off">
						<input type='hidden' name='csrfmiddlewaretoken' value='gTZljXgnpvxn0fKZ1XkWrM1PrCGSjiCZ' />
						<div class="form-group marb20 ">
							<label>邮&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;箱</label>
							<input  type="text" id="id_email" name="User[email]" value="None" placeholder="请输入您的邮箱地址" />
						</div>
						<div class="form-group marb8 ">
							<label>密&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;码</label>
							<input type="password" id="id_password" name="User[pawd]"  value="None" placeholder="请输入6-20位非中文字符密码" />
						</div>
						<div class="form-group marb8 captcha1 ">
							<label>验&nbsp;证&nbsp;码</label>
							<?php echo Captcha::widget(['captchaAction' => 'public/captcha', 'name' => 'captcha', 'template' => '{image}', 'imageOptions' => ['class' => 'captcha','title' => '看不清楚？点击切换']]);?>
							<input autocomplete="off" id="id_captcha_1" name="captcha_1" type="text" />
						</div>
						<div class="error btns" id="jsEmailTips"></div>
						<div class="auto-box marb8">
						</div>
						<input class="btn btn-green" id="jsEmailRegBtn" type="button" value="注册并登录" />
					</form>
				</div>
				<p class="form-p">已有账号？<a href="<?=Url::toRoute(['public/login'])?>">[立即登录]</a></p>
			</div>
		</div>
	</div>
</section>

<input id="isLogin" type="hidden" value="False"/>
<script src="/style/js/jquery.min.js" type="text/javascript"></script>
<script src="/style/js/unslider.js" type="text/javascript"></script>
<script src="/style/js/login.js"  type="text/javascript"></script>
<script src="/style/js/validateDialog.js" type="text/javascript"></script>

