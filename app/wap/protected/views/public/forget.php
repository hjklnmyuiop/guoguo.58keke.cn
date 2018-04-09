<link rel="stylesheet" type="text/css" href="/style/css/login.css"/>
<?php
use yii\captcha\Captcha;
use yii\helpers\Url;
$this->title = $settingData['web_name']."-忘记密码";
$this->web_keyword = $settingData['web_keyword'];
$this->web_desc = $settingData['web_desc'];
?>
<?php echo $this->render('/public/head', ['uid'=>$uid,'cartData'=>$cartData,'classify'=>$classifylist,'user_cate'=>$user_cate]); ?>
		<div class="login-box register-box">
			<div class="login-main">
				<div class="login-title">忘记密码</div>
				<form action="<?php echo Url::toRoute(["/public/resetlogpwd"]); ?>" method="post">
					<div class="item">
						<span class="icon-user"></span>
						<input type="text" name="User[phone]" id="mobile" placeholder="手机号" />
					</div>
					<div class="item verification">
						<span class="icon-dunpai"></span>
						<input type="text" name="User[code]" id="code" placeholder="验证码" />
					</div>
					<a class="getcode" id="getcode2" href="javascript:;" onclick="sendcode();" >获取验证码</a>
					<div class="item">
						<span class="icon-pwd"></span>
						<input type="password" name="User[pawd]" id="password" placeholder="设置密码" />
					</div>
					<div class="item">
						<span class="icon-pwd"></span>
						<input type="password" name="User[repawd]" id="repass" placeholder="重复密码" />
					</div>
					<input type="submit" style="margin-top: 40px;" class="submit" id="register" value="立即找回">
					<div class="entries">
						<span>如果您已记起密码，可在此<a href="<?php echo Url::toRoute(["/public/login"]); ?>">登录</a></span>
					</div>
				</form>
			</div>
		</div>
<?php echo $this->render('/public/footer'); ?>
<script src="/style/js/lib/jquery-1.7.js"></script>
<script src="/style/js/lib/layer/layer.js"></script>
<script src="/style/js/common.js"></script>
<script src="/style/js/register.js"></script>
<!--<script type="text/javascript">
	function sendcode(){
	alert('af');
		$.post('<?php echo Url::toRoute("public/sendcode");?>', {phone:$.trim($("#mobile").val()),type:2}, function(result){
			if (result.status == 1){
				$(".codeBtn").val("重新发送")

				return true;
			}else{
				alert(result.message);
				return false;
			}
		}, 'json');
	};
</script>-->
