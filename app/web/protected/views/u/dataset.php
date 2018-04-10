<script src="/style/js/jquery.min.js" type="text/javascript"></script>
<script src="/style/js/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
<?php
use yii\captcha\Captcha;
use yii\helpers\Url;
use yii\helpers\Html;
$this->title = $settingData['web_name']."-个人中心";
$this->web_keyword = $settingData['web_keyword'];
$this->web_desc = $settingData['web_desc'];

?>
<?php echo $this->render('/public/uhead', ['uid'=>$uid,'member'=>$member_info]); ?>
<section>
	<div class="wp">
		<ul  class="crumbs">
			<li><a href="/">首页</a>></li>
			<li><a href="<?=Url::toRoute(['u/dataset']) ?>">个人中心</a>></li>
			<li>个人信息</li>
		</ul>
	</div>
</section>

<section>
	<div class="wp list personal_list">
		<div class="left">
			<ul>
				<li class="active2"><a href="<?=Url::toRoute(['u/dataset']) ?>">个人资料</a></li>
				<li ><a href="<?=Url::toRoute(['u/article']) ?>">我的文章</a></li>
				<li ><a href="<?=Url::toRoute(['u/fav']) ?>">我的收藏</a></li>
				<li >
					<a href="<?=Url::toRoute(['u/message']) ?>" style="position: relative;">
						我的消息
					</a>
				</li>
			</ul>
		</div>


		<div class="right">
			<div class="personal_des ">
				<div class="head" style="border:1px solid #eaeaea;">
					<h1>个人信息</h1>
				</div>
				<div class="inforcon">
					<div class="left" style="width:242px;">
						<iframe id='frameFile' name='frameFile' style='display: none;'></iframe>
						<form class="clearfix" id="jsAvatarForm" enctype="multipart/form-data" autocomplete="off" method="post" action="/u/headimg" target='frameFile'>
							<label class="changearea" for="avatarUp">
                            <span id="avatardiv" class="pic">
                                <img width="100" height="100" class="js-img-show" id="avatarShow" src="<?=$member_info['head']?>"/>
                            </span>
                            <span class="fl upload-inp-box" style="margin-left:70px;">
                                <span class="button btn-green btn-w100" id="jsAvatarBtn">修改头像</span>
                                <input type="file" name="image" id="avatarUp" class="js-img-up"/>
                            </span>
							</label>
							<input type='hidden' name='csrfmiddlewaretoken' value='799Y6iPeEDNSGvrTu3noBrO4MBLv6enY' />
						</form>
						<div style="border-top:1px solid #eaeaea;margin-top:30px;">
							<a class="button btn-green btn-w100" id="jsUserResetPwd" style="margin:80px auto;width:100px;">修改密码</a>
						</div>
					</div>
					<form class="perinform" id="jsEditUserForm" autocomplete="off">
						<ul class="right">
							<li>昵&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;称：
								<input type="text" name="User[name]" id="nick_name" value="<?=$member_info['name']?>" maxlength="10">
								<i class="error-tips"></i>
							</li>
							<li>生&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;日：
								<input type="text" id="birth_day" name="User[birday]" value="<?=$member_info['birday']?>" readonly="readonly"/>
								<i class="error-tips"></i>
							</li>
							<li>性&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;别：
								<label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" <?php if($member_info['sex']==1):?> checked="checked" <?php endif ?>  name="User[sex]" value="1" >男</label>
								<label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="User[sex]" value="2" <?php if($member_info['sex']==2):?> checked="checked" <?php endif ?>>女</label>
							</li>
							<li class="p_infor_city">地&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;址：
								<input type="text" name="User[address]" id="address" placeholder="请输入你的地址" value="<?=$member_info['address']?>" maxlength="10">
								<i class="error-tips"></i>
							</li>
							<li>手&nbsp;&nbsp;机&nbsp;&nbsp;号：
								<input type="text" name="User[phone]" id="mobile" placeholder="请输入你的手机号码" value="<?=$member_info['phone']?>" maxlength="10">
							</li>
							<li class="p_infor_city">简&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;介：
								<input type="text" name="User[intro]" id="intro" placeholder="一句话概述" value="<?=$member_info['intro']?>" maxlength="10">
								<i class="error-tips"></i>
							</li>
							<li>邮&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;箱：
								<input class="borderno" type="text" name="User[email]" readonly="readonly" value="<?=$member_info['email']?>"/>
								<span class="green changeemai_btn">[修改]</span>
							</li>
							<li class="button heibtn">
								<input type="button" id="jsEditUserBtn" value="保存">
							</li>
						</ul>
						<input type='hidden' name='csrfmiddlewaretoken' value='799Y6iPeEDNSGvrTu3noBrO4MBLv6enY' />
					</form>
				</div>
			</div>
		</div>


	</div>
</section>


<!--sidebar start-->
<section>
	<ul class="sidebar">
		<li class="qq">
			<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=2023525077&site=qq&menu=yes"></a>
		</li>
		<li class="totop"></li>
	</ul>
</section>
<!--sidebar end-->
<!--header start-->

<div class="dialog" id="jsDialog">
	<div class="successbox dialogbox" id="jsSuccessTips">
		<h1>成功提交</h1>
		<div class="close jsCloseDialog"><img src="/style/images/dig_close.png"/></div>
		<div class="cont">
			<h2>您的需求提交成功！</h2>
			<p></p>
		</div>
	</div>
	<!--提示弹出框-->
	<div class="bidtips dialogbox promptbox" id="jsComfirmDialig">
		<h1>确认提交</h1>
		<div class="close jsCloseDialog"><img src="/style/images/dig_close.png"/></div>
		<div class="cont">
			<h2>您确认提交吗？</h2>
			<dd class="autoTxtCount">
				<div class="button">
					<input type="button" class="fl half-btn" value="确定" id="jsComfirmBtn"/>
					<span class="fr half-btn jsCloseDialog">取消</span>
				</div>
			</dd>
		</div>
	</div>
	<div class="resetpwdbox dialogbox" id="jsResetDialog">
		<h1>修改密码</h1>
		<div class="close jsCloseDialog"><img src="/style/images/dig_close.png"/></div>
		<div class="cont">
			<form id="jsResetPwdForm" autocomplete="off">
				<div class="box">
					<span class="word2" >旧&nbsp;&nbsp;密&nbsp;&nbsp;码</span>
					<input type="password" id="oldpawd" name="oldpawd" placeholder="旧密码"/>
				</div>
				<div class="box">
					<span class="word2" >新&nbsp;&nbsp;密&nbsp;&nbsp;码</span>
					<input type="password" id="pwd" name="password1" placeholder="6-20位非中文字符"/>
				</div>
				<div class="box">
					<span class="word2" >确定密码</span>
					<input type="password" id="repwd" name="password2" placeholder="6-20位非中文字符"/>
				</div>
				<div class="error btns" id="jsResetPwdTips"></div>
				<div class="button">
					<input id="jsResetPwdBtn" type="button" value="提交" />
				</div>
				<input type='hidden' name='csrfmiddlewaretoken' value='DaP7IUKm9FA9nELA9YUlYYWpyIDdCiIP' />
				<input type='hidden' name='csrfmiddlewaretoken' value='799Y6iPeEDNSGvrTu3noBrO4MBLv6enY' />
			</form>
		</div>
	</div>
	<div class="dialogbox changeemai1 changephone" id="jsChangeEmailDialog">
		<h1>修改邮箱</h1>
		<div class="close jsCloseDialog"><img src="/style/images/dig_close.png"/></div>
		<p>请输入新的邮箱地址</p>
		<form id="jsChangeEmailForm" autocomplete="off">
			<div class="box">
				<input class="fl change_email" name="email" id="jsChangeEmail" type="text" placeholder="输入重新绑定的邮箱地址">
			</div>
			<div class="box">
				<input class="fl email_code" type="text" id="jsChangeEmailCode" name="code" placeholder="输入邮箱验证码">
				<input class="getcode getting" type="button" id="jsChangeEmailCodeBtn" value="获取验证码">
			</div>
			<div class="error btns change_email_tips" id="jsChangeEmailTips" >请输入...</div>
			<div class="button">
				<input class="changeemai_btn" id="jsChangeEmailBtn" type="button" value="完成"/>
			</div>
			<input type='hidden' name='csrfmiddlewaretoken' value='DaP7IUKm9FA9nELA9YUlYYWpyIDdCiIP' />
			<input type='hidden' name='csrfmiddlewaretoken' value='799Y6iPeEDNSGvrTu3noBrO4MBLv6enY' />
		</form>
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
	<div class="resetpassbox dialogbox" id="jsSetNewPwd">
		<h1>重新设置密码</h1>
		<div class="close jsCloseDialog"><img src="/style/images/dig_close.png"/></div>
		<p class="green">请输入新密码</p>
		<form id="jsSetNewPwdForm">
			<div class="box">
				<span class="word2">密&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;码</span>
				<input type="password" name="password" id="jsResetPwd" placeholder="请输入新密码"/>
			</div>
			<div class="box">
				<span class="word2">确&nbsp;认&nbsp;密&nbsp;码</span>
				<input type="password" name="password2" id="jsResetPwd2" placeholder="请再次输入新密码"/>
			</div>
			<div class="box">
				<span class="word2">验&nbsp;&nbsp;证&nbsp;&nbsp;码</span>
				<input type="text" name="code" id="jsResetCode" placeholder="请输入手机验证码"/>
			</div>
			<div class="error btns" id="jsSetNewPwdTips"></div>
			<div class="button">
				<input type="hidden" name="mobile" id="jsInpResetMobil" />
				<input id="jsSetNewPwdBtn" type="button" value="提交" />
			</div>
			<input type='hidden' name='csrfmiddlewaretoken' value='DaP7IUKm9FA9nELA9YUlYYWpyIDdCiIP' />
		</form>
	</div>
	<div class="forgetbox dialogbox">
		<h1>忘记密码</h1>
		<div class="close jsCloseDialog"><img src="/style/images/dig_close.png"/></div>
		<div class="cont">
			<form id="jsFindPwdForm" autocomplete="off">
				<input type='hidden' name='csrfmiddlewaretoken' value='DaP7IUKm9FA9nELA9YUlYYWpyIDdCiIP' />
				<div class="box">
					<span class="word2" >账&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;号</span>
					<input type="text" id="account" name="account" placeholder="手机/邮箱"/>
				</div>
				<div class="box">
					<span class="word3">验证码</span>
					<input autocomplete="off" class="form-control-captcha find-password-captcha" id="find-password-captcha_1" name="captcha_f_1" placeholder="请输入验证码" type="text" /> <input class="form-control-captcha find-password-captcha" id="find-password-captcha_0" name="captcha_f_0" placeholder="请输入验证码" type="hidden" value="5f3c00e47fb1be12d2fd15b9a860711597721b3f" /> &nbsp;<img src="/captcha/image/5f3c00e47fb1be12d2fd15b9a860711597721b3f/" alt="captcha" class="captcha" />
				</div>
				<div class="error btns" id="jsForgetTips"></div><!--忘记密码错误-->
				<div class="button">
					<input type="hidden" name="sms_type" value="1">
					<input id="jsFindPwdBtn" type="button" value="提交" />
				</div>
			</form>
		</div>
	</div>
</div>
<div class="bg" id="dialogBg"></div>
<?php echo $this->render('/public/footer'); ?>
<script src="/style/js/selectUi.js" type='text/javascript'></script>
<script src="/style/js/deco-common.js" type='text/javascript'></script>
<script type="text/javascript" src="/style/js/plugins/laydate/laydate.js"></script>
<script src="/style/js/plugins/layer/layer.js"></script>
<script src="/style/js/plugins/queryCity/js/public.js" type="text/javascript"></script>
<script src="/style/js/unslider.js" type="text/javascript"></script>
<script src="/style/js/plugins/jquery.scrollLoading.js"  type="text/javascript"></script>
<script src="/style/js/deco-common.js"  type="text/javascript"></script>

<script src='/style/js/plugins/jquery.upload.js' type='text/javascript'></script>
<script src="/style/js/validate.js" type="text/javascript"></script>
<script src="/style/js/deco-user.js"></script>
<script type="text/javascript">
	$('.jsDeleteFav_course').on('click', function(){
		var _this = $(this),
				favid = _this.attr('data-favid');
		alert(favid)
		$.ajax({
			cache: false,
			type: "POST",
			url: "/org/add_fav/",
			data: {
				fav_type: 1,
				fav_id: favid,
				csrfmiddlewaretoken: '799Y6iPeEDNSGvrTu3noBrO4MBLv6enY'
			},
			async: true,
			success: function(data) {
				Dml.fun.winReload();
			}
		});
	});

	$('.jsDeleteFav_teacher').on('click', function(){
		var _this = $(this),
				favid = _this.attr('data-favid');
		$.ajax({
			cache: false,
			type: "POST",
			url: "/org/add_fav/",
			data: {
				fav_type: 3,
				fav_id: favid,
				csrfmiddlewaretoken: '799Y6iPeEDNSGvrTu3noBrO4MBLv6enY'
			},
			async: true,
			success: function(data) {
				Dml.fun.winReload();
			}
		});
	});


	$('.jsDeleteFav_org').on('click', function(){
		var _this = $(this),
				favid = _this.attr('data-favid');
		$.ajax({
			cache: false,
			type: "POST",
			url: "/org/add_fav/",
			data: {
				fav_type: 2,
				fav_id: favid,
				csrfmiddlewaretoken: '799Y6iPeEDNSGvrTu3noBrO4MBLv6enY'
			},
			async: true,
			success: function(data) {
				Dml.fun.winReload();
			}
		});
	});
</script>


<script>
	var shareUrl = '',
			shareText = '',
			shareDesc = '',
			shareComment = '';
	$(function () {
		$(".bdsharebuttonbox a").mouseover(function () {
			var type = $(this).attr('data-cmd'),
					$parent = $(this).parent('.bdsharebuttonbox'),
					fxurl = $parent.attr('data-url'),
					fxtext = $parent.attr('data-text'),
					fxdesc = $parent.attr('data-desc'),
					fxcomment = $parent.attr('data-comment');
			switch (type){
				case 'tsina':
				case 'tqq':
				case 'renren':
					shareUrl = fxurl;
					shareText = fxdesc;
					shareDesc = '';
					shareComment = '';
					break;
				default :
					shareUrl = fxurl;
					shareText = fxtext;
					shareDesc = fxdesc;
					shareComment = fxcomment;
					break;
			}
		});
	});
	function SetShareUrl(cmd, config) {
		if (shareUrl) {
			config.bdUrl = "" + shareUrl;
		}
		if(shareText){
			config.bdText = shareText;
		}
		if(shareDesc){
			config.bdDesc = shareDesc;
		}
		if(shareComment){
			config.bdComment = shareComment;
		}

		return config;
	}
	window._bd_share_config = {
		"common": {
			"onBeforeClick":SetShareUrl,
			"bdPic":"",
			"bdMini":"2",
			"searchPic":"1",
			"bdMiniList":false
		},
		"share": {
			"bdSize":"16"
		}
	};
	with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com../api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];
</script>