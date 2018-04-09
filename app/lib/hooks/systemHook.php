<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 2015/5/29 0029
 * Time: 上午 10:05
 */

namespace lib\hooks;

use Yii;
use yii\helpers\Url;

class systemHook extends \lib\hooks\basicHook
{
	public static function app()
	{
		$class = __CLASS__;
		return new $class;
	}

	/**
	 * 在线安装app
	 * @return array
	 */
	public function install()
	{
		$this->requestData = $_POST;
		if(!isset($this->requestData['version']) || !isset($this->requestData['mark']))
		{
			return self::merge(['status' => -9]);
		}
		$appInstall = \lib\models\AppInstall::findOne(['mark' => $this->requestData['mark'], 'install_type' => $this->retData['from']]);
		if(empty($appInstall))
		{
			$appInstall = new \lib\models\AppInstall();
			$appInstall->sign = \lib\components\AdCommon::uniqueGuid();
			$appInstall->mark = $this->requestData['mark'];
			$appInstall->version = $this->requestData['version'];
			$appInstall->install_type = $this->retData['from'];
			$appInstall->install_time = date('Y-m-d H:i:s');
			$appInstall->save();
		}
		else
		{
			$appInstall->version = $this->requestData['version'];
			$appInstall->install_type = $this->retData['from'];
			$appInstall->install_time = date('Y-m-d H:i:s');
			$appInstall->save();
		}
		return $this->retData;
	}
	/**
	 * 
	 * @return multitype:number
	 */
	public function set()
	{
		$settingData = \lib\models\Setting::find()->all();
		foreach ($settingData as $data)
		{
// 			if (in_array($data->key, ['hot_keyword','web_logo','web_domain','app_name','app_desc','logistics']))
			$setData[$data->key] = $data->value;
		}
		$this->retData['data'] = $setData;
		return $this->retData;
	}
	/**
	 * 系统信息
	 * @return multitype:number
	 */
	public function info()
	{
		$settingData = \lib\models\Setting::find()->all();
		foreach ($settingData as $data)
		{
			if (in_array($data->key, ['kefuphone']))
				$setData[$data->key] = $data->value;
			if (in_array($data->key, ['shouce']))
				$setData[$data->key] = urlencode($data->value);
		}
		$this->retData['data'] = $setData;
		return $this->retData;
	}
	/**
	 * 发送验证码
	 * @return Ambigous <\lib\hooks\type, multitype:number >|multitype:number
	 */
	public function sendcode()
	{
		if (!self::request_verify(['phone'], 'string'))
		{
			return self::returnMerge(-9, '请求参数错误');
		}
		$type = parent::get("type", 3);
		if ($type == 1)
		{
			$findPhone = \lib\models\User::findOne(['phone' => $this->requestData['phone']]);
			if (!empty($findPhone))
			{
				return parent::returnMerge(-3, '抱歉，您注册的手机号码已经使用');
			}
		}
		if ($type == 2)
		{
			$findPhone = \lib\models\User::findOne(['phone' => $this->requestData['phone']]);
			if (empty($findPhone))
			{
				return parent::returnMerge(-3, '抱歉，您输入的手机号码没有注册');
			}
		}
		$codesData = \lib\models\SmsCode::findOne(['phone' => $this->requestData['phone'], 'status' => 1]);
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
			$attributes = array('phone' => $this->requestData['phone'], 'code' => $codes, 'sen_time' => time(), 'status' => 1);
			$_codes->attributes = $attributes;
			if (!$_codes->validate())
			{
				return self::returnMerge(-3, \lib\components\AdCommon::modelMessage($_codes->errors));
			}
			$_codes->save();
		}
		$sms = '您的验证码为：%s，请勿将验证码告知他人';
		$smsReturn = \lib\components\Sms::app()->send($this->requestData['phone'], sprintf($sms, $codes));
		$this->retData['status'] = $smsReturn['status'];
		if (isset($smsReturn['msg']))
		{
			$this->retData['message'] = $smsReturn['msg'];
		}
		else
		{
			$this->retData['status'] = 1;
			$this->retData['message'] = '验证码已发送，请注意查收';//'验证码'.$codes.'已发送，请注意查收';
		}
		return $this->retData;
	}
	/**
	 * 验证验证码
	 */
	public function checkcode()
	{
		if (!self::request_verify(['phone','smscode'], 'string'))
		{
			return self::returnMerge(-9, '请求参数错误');
		}
		$type = parent::get("type", 0);
		$smscode= parent::get('smscode');
		if (!empty($smscode))
		{
			$smscodeData = \lib\models\SmsCode::findOne(['phone' => $this->requestData['phone'], 'code' => $smscode, 'status' => 1]);
			if (empty($smscodeData))
			{
				return parent::returnMerge(-3, '抱歉，短信验证码错误');
			}else {
				$smscodeData->use_time = time();
				$smscodeData->status = 0;
				$smscodeData->save();
				$this->retData['status'] = 1;
				$this->retData['message'] = '验证码正确';
				return $this->retData;
			}
		}else{
			return parent::returnMerge(-3, '请填写验证码');
		}
		$this->retData['status'] = 1;
		$this->retData['message'] = '验证码正确';
		return $this->retData;
	}
	/**
	 * 验证支付密码
	 */
	public function checkpaypwd()
	{
		if (!self::request_verify(['pawd'], 'string'))
		{
			return self::returnMerge(-9, '请求参数错误');
		}
		$userAccount = \lib\models\UserAccount::findOne(['uid' => $this->object->uid]);
		if (empty($userAccount))
		{
			return ['status' => -3, 'message' => '用户不存在'];
		}
	 	if ($userAccount->pawd != \lib\components\AdCommon::encryption($userAccount->codes.$this->requestData['pawd']))
        {
            return ['status' => -3, 'message' => '密码错误'];
        }
        return ['status' => 1, 'message' => '密码正确'];
	}
	
	public function setting()
	{
		$this->retData['data'] = \lib\models\Setting::getSetting();
		return $this->retData;
	}
	/**
	 * 版本升级
	 * @return Ambigous <\lib\hooks\type, multitype:number >|multitype:number
	 */
	public function version()
	{
		$version = \lib\models\App::findOne(['type' => 1,'status'=>1]);
		if(empty($version))
		{
			$this->retData['status'] = -3;
			$this->retData['message'] = '你的已经是最新版本了';
		}
		else
		{
			$this->retData['status'] = 1;
			$this->retData['data']['url'] = \lib\components\AdCommon::dotran($version['remove']);
			$this->retData['data']['version'] = $version['version'];
			$this->retData['message'] = '版本升级';
		}
		return $this->retData;
	}
	/**
	 * 银行协议
	 * @return Ambigous <\lib\hooks\type, multitype:number >|multitype:number
	 */
	public function bankxieyi()
	{
		$article = \lib\models\Article::findOne(['id' => 26]);
		if(empty($article))
		{
			$this->retData['status'] = -3;
			$this->retData['message'] = '协议不存在';
		}
		else
		{
			$this->retData['status'] = 1;
			$this->retData['data']['bank'] = urlencode($article['content']);
			$this->retData['message'] = '银行协议';
		}
		return $this->retData;
	}
	/**
	 * 二维码协议
	 * @return Ambigous <\lib\hooks\type, multitype:number >|multitype:number
	 */
	public function qrcode()
	{
		if ($this->retData['from'] == 1){
			$article = \lib\models\Ads::findOne(['id' => 34]);
		}else {
			$article = \lib\models\Ads::findOne(['id' => 35]);
		}
		
		if(empty($article))
		{
			$this->retData['status'] = -3;
			$this->retData['message'] = '协议不存在';
		}
		else
		{
			$this->retData['status'] = 1;
			$this->retData['data']['code'] = $article->image;
			$this->retData['message'] = '银行协议';
		}
		return $this->retData;
	}
	/**
	 * 添加账号金额变动记录
	 * @param unknown $data
	 * @return boolean
	 */
	public function addmoneyRecode($data){
		$moneyRecodeModel = new \lib\models\UserMoneyRecord();
		$moneyRecodeModel->attributes = [
				'uid' => $data['uid'],
				'b_account_money' => $data['b_account_money'],
				'a_account_money' => $data['a_account_money'],
				'action_money' => $data['action_money'],
				'action_type' => $data['action_type'],
				'action' => $data['action'],
				'time' => time(),
		];
		if (!$moneyRecodeModel->validate())
		{
			return false;
		}
		$moneyRecodeModel->save();
		return true;
	}
	/**
	 * 佣金处理
	 */
	public function commission($money){
		$commission = \lib\models\Setting::findOne(['key'=>'commission'])->toArray();
		$money = (100-$commission['value'])/100*$money;
		return $money;
	}
	/**
	 * 星星处理
	 */
	public function star($score){
		$settingData = $this->set();
		$cwown = $settingData['data']['cwown'];
		$diamond = $settingData['data']['diamond'];
		$star = $settingData['data']['star'];
		$first = floor($score/$cwown);
		$first_data = $score%$cwown;
		$data =[];
		
		for ($i=0;$i<$first;$i++){
			$data[]="4";
		}
		$two = floor($first_data/$diamond);
		$two_data = $first_data%$diamond;
		for ($i=0;$i<$two;$i++){
			$data[]="3";
		}
		$three = floor($two_data/$star);
		$three_data = $two_data%$star;
		for ($i=0;$i<$three;$i++){
			$data[]="2";
		}
		if (count($data)>=5){
			$reData = array($data[0],$data[1],$data[2],$data[3],$data[4]);
		}elseif (count($data) == 4){
			$reData = array($data[0],$data[1],$data[2],$data[3],'1');
		}elseif (count($data) == 3){
			$reData = array($data[0],$data[1],$data[2],'1','1');
		}elseif (count($data) == 2){
			$reData = array($data[0],$data[1],'1','1','1');
		}elseif (count($data) == 1){
			$reData = array($data[0],'1','1','1','1');
		}else {
			$reData = array('1','1','1','1','1');
		}
		return $reData;
	}
}