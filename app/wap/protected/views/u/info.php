<?php
use yii\captcha\Captcha;
use yii\helpers\Url;
use yii\helpers\Html;
$this->title = $settingData['web_name']."-个人中心";
$this->web_keyword = $settingData['web_keyword'];
$this->web_desc = $settingData['web_desc'];

?>
<link rel="stylesheet" type="text/css" href="/style/css/guoguo.css">
<div class="header">
	<div class="header-background"></div>
	<div class="toolbar statusbar-padding">
		<button class="bar-button back-button" onclick="history.go(-1);" dwz-event-on-click="click"><i class="icon icon-back"></i></button>
		<!--<a class="bar-button" data-href="home.html?dwz_callback=home_render" target="navTab" rel="home"><i class="icon icon-back"></i></a>-->
		<div class="header-title">
			<div class="title">个人信息</div>
		</div>
	</div>
</div>
<div style="height:44px"></div>

<form class="perinform" id="jsEditUserForm" autocomplete="off">
	<div class="aui-logon-con">
		<div class="b-line">
			昵       称：
			<input type="text" name="User[name]" id="nick_name" placeholder="昵称" value="<?=$member_info['name']?>" maxlength="10">
			<i class="error-tips"></i>
		</div>
		<div>生&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;日：
			<input type="text" id="birth_day" name="User[birday]" value="<?=$member_info['birday']?>" readonly="readonly"/>
			<i class="error-tips"></i>
		</div>
		<div class="b-line">
			性       别：
			<label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" <?php if($member_info['sex']==1):?> checked="checked" <?php endif ?>  name="User[sex]" value="1" >男</label>
			<label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="User[sex]" value="2" <?php if($member_info['sex']==2):?> checked="checked" <?php endif ?>>女</label>
		</div>
		<div class="b-line">
			地       址：
			<input type="text" name="User[address]" id="address" placeholder="请输入你的地址" value="<?=$member_info['address']?>" maxlength="10">
		</div>
		<div class="b-line">手机号：
			<input type="text" name="User[phone]" id="mobile" placeholder="请输入你的手机号码" value="<?=$member_info['phone']?>" maxlength="10">
		</div>
		<div class="b-line">
			简       介：
			<input type="text" name="User[intro]" id="intro" placeholder="一句话概述" value="<?=$member_info['intro']?>" maxlength="10">
			<i class="error-tips"></i>
		</div>
		<div class="b-line">邮&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;箱：
			<input class="borderno" type="text" name="User[email]" readonly="readonly" value="<?=$member_info['email']?>"/>
		</div>
		<div class="aui-login-l">
			<input type="button" id="jsEditUserBtn" value="保存">
		</div>
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
<script src="/style/js/validate.js" type="text/javascript"></script>
<script>
	$('#jsEditUserBtn').on('click', function(){
		var _self = $(this),
				$jsEditUserForm = $('#jsEditUserForm')
		verify = verifySubmit(
				[
					{id: '#nick_name', tips: Dml.Msg.epNickName, require: true},
					{id: '#intro', tips: Dml.Msg.epIntro, require: true}
				]
		);
		if(!verify){
			return;
		}
		$.ajax({
			cache: false,
			type: 'post',
			dataType:'json',
			url:"/u/info/",
			data:$jsEditUserForm.serialize(),
			async: true,
			beforeSend:function(XMLHttpRequest){
				_self.val("保存中...");
				_self.attr('disabled',true);
			},
			success: function(data) {
				if(data.status == "failure"){
					Dml.fun.showTipsDialog({
						title: '保存失败',
						h2: data.msg
					});
				}else if(data.status == "success"){
					Dml.fun.showTipsDialog({
						title: '保存成功',
						h2: '个人信息修改成功！'
					});
					setTimeout(function(){window.location.href = window.location.href;},1500);
				}
			},
			complete: function(XMLHttpRequest){
				_self.val("保存");
				_self.removeAttr("disabled");
			}
		});
	});
	//弹出框关闭按钮
	$('.jsCloseDialog').on('click', function(){
		$('#jsDialog').hide();
		$('html').removeClass('dialog-open');
		$(this).parents('.dialogbox').hide();
		$('#dialogBg').hide();
		if($(this).parent().find('form')[0]){
			$(this).parent().find('form')[0].reset();
		}
	});
</script>