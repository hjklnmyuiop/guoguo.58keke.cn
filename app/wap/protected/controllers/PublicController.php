<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 2015/5/28
 * Time: 21:15
 */
namespace app\controllers;

use app\library\UserLibrary;
use lib\components\AdCommon;
use lib\models\User;
use Yii;
use yii\helpers\Json;
use yii\helpers\Url;


class PublicController extends \app\components\WebController
{

	public function actions()
	{
		return  [
				'captcha' => [
						'class' => 'yii\captcha\CaptchaAction',
						'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
						'backColor'=>0x000000,//背景颜色
						'maxLength' => 4, //最大显示个数
						'minLength' => 4,//最少显示个数
						'padding' => 5,//间距
						'height'=>40,//高度
						'width' => 90,  //宽度
						'foreColor'=>0xffffff,     //字体颜色
						'offset'=>4,        //设置字符偏移量 有效果
					//'controller'=>'login',        //拥有这个动作的controller
				],
		];
	}
	/**
	 * 用户注册
	 * @author gqa
	 */
	public function actionRegister()
	{
		$user = new User();
		$userArr = Yii::$app->request->post('User');
		if(!empty($userArr)) {
			if (!empty($userArr['email']) && !empty($userArr['pawd'])) {
//				if ($userArr['pawd'] == $userArr['repawd']) {
					//注册用户的主表数据
					$userArr['head'] = isset($userArr['head']) ? $userArr['head'] : "/style/images/defaultpic.png";
					$userArr['status'] = 2;
					$result = UserLibrary::app()->addUser($userArr);
					if (($result['state'])) {
						$userInfo = \lib\models\User::findOne($result['id']);
						$returnData['info'] = [
								'id'        	=> $userInfo->id,
								'name'  	=> !empty($userInfo->name)?$userInfo->name:"",
								'phone'     	=> !empty($userInfo->phone)?$userInfo->phone:"",
								'head'			=> !empty($userInfo->head)?$userInfo->head:"",
						];
						\Yii::$app->session->set('LOGIN', $returnData['info']);
						if(isset($_REQUEST['ref'])){
							$goToUrl = urldecode($_REQUEST['ref']);//从url参数获取跳转前页面
						}else{
							$goToUrl = Url::toRoute(['index/index']);
						}
						$this->success('用户注册成功',$goToUrl);
					} else {
						$this->error($result['msg']);
					}
//				} else {
//					$this->error(\Yii::t('app', '两次密码输入不一致！'));
//				}
			} else {
				$this->error(\Yii::t('app', '用户数据不能为空！'));
			}
		}
		$this->_data['user'] = $user;
		return $this->view();
	}

	/**
	 * 登录
	 * @author gqa
	 */
	/**
	 * 用户登录
	 * @author gqa
	 * @return type
	 */
	public function actionLogin()
	{

		if($this->uid>0) {
			$this->redirect(['index/index']);
		}
		if ($this->isPost)
		{
			$userInfo = \lib\models\User::findOne(['phone' => $this->post('phone')]);
			if (empty($userInfo))
			{
				$this->error('抱歉，用户不存在', null, false,['account_l'=>'抱歉，用户不存在']);
			}
			if ($userInfo->status != 2)
			{
				$this->error('no_active');
			}
			if ($userInfo->pawd != \lib\components\AdCommon::encryption($userInfo->codes.$this->post('pawd')))
			{
				$this->error('抱歉，密码错误', null, false,['password_l'=>'抱歉，密码错误']);
			}

			$userModel = new \lib\models\User();
			$attributeLabels = $userModel->attributeLabels();
			$returnData['info'] = [
					'id'        	=> $userInfo->id,
					'name'  	=> !empty($userInfo->name)?$userInfo->name:"",
					'phone'     	=> !empty($userInfo->phone)?$userInfo->phone:"",
					'head'			=> !empty($userInfo->head)?$userInfo->head:"",
			];
			\Yii::$app->session->set('PHONE', Yii::$app->request->post('phone'));
			\Yii::$app->session->set('LOGIN', $returnData['info']);
			$loginData = \Yii::$app->session->get('LOGIN');
			if (!empty($loginData))
			{
				if(isset($_REQUEST['ref'])){
					$goToUrl = urldecode($_REQUEST['ref']);//从url参数获取跳转前页面
				}else{
					$goToUrl = Url::toRoute(['index/index']);
				}
				$this->success('登录成功',$goToUrl);
			}else{
				$this->error('登录失败');
			}
		}
		return $this->render($this->action->id, $this->_data);
	}


	//检查用户是否登录
	public function checklogin()
	{
		if (empty($_SESSION['LOGIN'])) { //检查一下session是不是为空
			if (empty($_COOKIE['username']) || empty($_COOKIE['password'])) { //如果session为空，并且用户没有选择记录登录状
				header("location:login.php?req_url=" . $_SERVER['REQUEST_URI']); //转到登录页面，记录请求的url，登录后跳转过去，用户体验好。
			} else { //用户选择了记住登录状态
				$user['username'] = $_COOKIE['username']; //去取用户的个人资料
				$user['password'] = $_COOKIE['password']; //去取用户的个人资料
				if (empty($user)) { //用户名密码不对没到取到信息，转到登录页面
					header("location:login.php?req_url=" . $_SERVER['REQUEST_URI']);
				} else {
					$_SESSION['LOGIN'] = $user; //用户名和密码对了，把用户的个人资料放到session里面
				}
			}
		}
	}
	/**
	 * 退出登录
	 * @author gqa
	 */
	public function actionLogout()
	{
		\Yii::$app->session->set('LOGIN', null);
		if(!empty($_COOKIE['username']) || !empty($_COOKIE['password'])){
			setcookie("username", null, time()-3600*24*7);
			setcookie("password", null, time()-3600*24*7);
		}
		$this->redirect(Url::toRoute(['index/index']));
	}

	/**
	 * 找回登录密码
	 * @author gqa
	 * @return type
	 */
	public function actionResetlogpwd()
	{
		$user = new User();
		$userArr = Yii::$app->request->post('User');
		if(!empty($userArr)) {
			if (!empty($userArr['phone']) && !empty($userArr['pawd']) && !empty($userArr['repawd'])) {
				$userinfo = $user->findOne(['phone'=>$userArr['phone']]);

				if(empty($userinfo)){
					$this->error('没有这用户');
				}
				if ($userArr['pawd'] == $userArr['repawd']) {
					//验证验证码
					$smscodeData = \lib\models\SmsCode::findOne(['phone' => $userArr['phone'], 'code' => $userArr['code'], 'status' => 1]);
					if (empty($smscodeData)) {
						$this->error('抱歉，短信验证码错误');
					} else {
						$smscodeData->use_time = time();
						$smscodeData->status = 0;
						$smscodeData->save();
					}
					//修改密码
					$newuser['pawd'] = AdCommon::encryption($userinfo['codes'].$userArr['pawd']);
					$result = UserLibrary::app()->updateUser($userinfo->id, $newuser);
					if (($result['state'])) {
						$this->success( '修改登录密码成功!',"/public/login?phone=".$userArr['phone']);
					} else {
						$this->error($result['msg']);
					}
				} else {
					$this->error(\Yii::t('app', '两次密码输入不一致！'));
				}
			} else {
				$this->error(\Yii::t('app', '用户数据不能为空！'));
				$this->redirect(['public/login']);
			}
		}
		$this->_data['routeaction'] =  $this->action->controller->id.'/'.$this->action->id;
		$this->_data['user'] = $user;
		return $this->view('forget');
	}

	/**手机验证码
	 * @return string
	 * $type 1注册 2找回密码 3支付 4绑定账号
	 */
	public function actionSendcode()
	{

		if ($this->isPost)
		{
			/**
			 * 发送验证码
			 * @return Ambigous <\lib\hooks\type, multitype:number >|multitype:number
			 */
			$phone =trim($this->post('phone'));
			if (!self::request_verify(['phone'], 'string',array('phone'=>$phone)))
			{
				return Json::encode(['status'=>-3, 'msg'=>'请求参数错误']);
			}
			$type = parent::post("type");
			if (!self::request_verify(['type'], 'int',array('type'=>$type)))
			{
				return Json::encode(['status'=>-3, 'msg'=>'请求参数错误']);
			}
			if ($type == 1)
			{
				$findPhone = \lib\models\User::findOne(['phone' =>$phone]);
				if (!empty($findPhone))
				{
					return Json::encode(['status'=>-3, 'msg'=>'抱歉，您注册的手机号码已经使用']);
				}
			}elseif($type == 2|| $type == 3){
				$findPhone = \lib\models\User::findOne(['phone' =>$phone]);
				if (empty($findPhone))
				{
					return Json::encode(['status'=>-3, 'msg'=>'抱歉，您输入的手机号码没有注册']);
				}
			}
			$codesData = \lib\models\SmsCode::findOne(['phone' =>$phone, 'status' => 1,'type'=>$type]);
			$codes = (string) rand(1000,9999);
			if (!empty($codesData))
			{
				$codesData->code = $codes;
				$codesData->sen_time = time();
				$codesData->save();
			}
			else
			{
				$_codes = new \lib\models\SmsCode();
				$attributes = array('phone' => $phone, 'code' => $codes, 'sen_time' => time(), 'status' => 1,'type'=>$type);
				$_codes->attributes = $attributes;
				if (!$_codes->validate())
				{
					return Json::encode(['status'=>-3, 'msg'=>\lib\components\AdCommon::modelMessage($_codes->errors)]);
				}
				$_codes->save();
			}
//			$sms = '手机短信验证码：请输入验证码%s（15分钟内有效）。如非本人操作请忽略。【果果学习网】';
//			$smsReturn = \lib\components\Sms::app()->send($phone, sprintf($sms, $codes));
			$mmt_code_array = array(1=>'login_code',2=>'forget_code',3=>'money_change',4=>'login_code',);
			$mmt_short_code = \lib\models\MemberMsgTpl::findOne(['mmt_code' =>$mmt_code_array[$type],'mmt_short_switch'=>1]);
			if(empty($mmt_short_code))	$this->error('短信模板不存在');
			$param =array('code'=>$codes,'product'=>"果果学习网");
			$smsReturn = \lib\components\Sms::app()->aliyusend($phone,$mmt_short_code['mmt_short_code'], $param);
			if (isset($smsReturn->Code) &&$smsReturn->Code=='OK')
			{
				$data['status'] = 1;
				$data['msg'] = '验证码已发送，请注意查收';//'验证码'.$codes.'已发送，请注意查收';
			}
			else
			{
				$data['status'] = 0;
				$data['msg'] = $smsReturn->Message;

			}
			return Json::encode($data);
		}
	}

	public function actionSignpage()
	{
		$id = (int)\Yii::$app->request->get('id', '');
		$view = \Yii::$app->request->get('view', '');
		//获取单页面信息
		$xieyi = \lib\models\Separate::find()->where(['id'=>$id])->one();
		$this->_data['xieyi']  = $xieyi;

		return $this->view($view);
	}
	public function actionError()
	{
		$exception = \Yii::$app->errorHandler->exception;
		if ($exception !== null)
		{
			$this->_data['message'] = $exception;
			return $this->render($this->action->id, $this->_data);
			//return $this->render('error', ['message' => $exception]);
		}
	}
}