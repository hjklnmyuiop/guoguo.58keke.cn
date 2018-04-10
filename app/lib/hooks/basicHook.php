<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 2015/5/29 0029
 * Time: 上午 10:05
 */

namespace lib\hooks;

use Yii;

class basicHook
{
	public $retData = ['status' => 1];
    public $requestData = [];
    public $object;
	
    /**
     * 设置配置信息
     */
    public function setSetting()
    {
        $settingData = \lib\hooks\systemHook::app()->setting();
        \Yii::$app->params['setting'] = $settingData['data'];
    }
    /**
     * 保存请求数据
     * @param unknown $data
     * @return multitype:number
     */
    public function insertsearch($data,$acturl){
    	$model = new \lib\models\Search();
    	$content =  ($acturl."#".$data);
    	$model->attributes =['content'=>$content];
    
    	if (!$model->validate())
    	{
    		return parent::returnMerge(-3, \lib\components\AdCommon::modelMessage($model->errors));
    	}
    
    	$model->save();
    	if(!empty($model->errors))
    	{
    
    		return parent::returnMerge(-3, \lib\components\AdCommon::modelMessage($model->errors));
    
    	}
    }
	/**
     * @desc 验证数据
     * @access protected
     * @param int $data 数据
     * @param bool $type 判断类型 string|int|bool
     * @return mixed
     */
    protected function request_verify($data, $type = 'string')
    {
        if(!is_array($data))
        {
            $data = array($data);
        }
        switch($type)
        {
            case 'string':
                foreach($data as $val)
                {
                    if (!isset($this->requestData[$val]) || !is_string($this->requestData[$val]) || empty($this->requestData[$val]))
                    {
                        return '';
                    }
                }
                break;
            case 'int':
                foreach($data as $val)
                {
                    if (!isset($this->requestData[$val]) || !is_numeric($this->requestData[$val]))
                    {
                        return 0;
                    }
                }
                break;
            case 'bool':
                foreach($data as $val)
                {
                    if (!isset($this->requestData[$val]) || !is_bool($this->requestData[$val]))
                    {
                        return false;
                    }
                }
                break;
            case 'date':
                foreach($data as $val)
                {
                    if (!isset($this->requestData[$val]) || !\lib\components\AdCommon::isDate($this->requestData[$val]))
                    {
                        return '';
                    }
                }
                break;
        }   
        return true;
    }

    /**
     * @desc 获取数据
     * @access protected
     * @param $key 获取的变量名称
	 * @param $type 类型
     * @return mixed
     */
    protected function get($key, $type = "")
    {
        if(is_array($key))
        {
            foreach($key as $arr)
            {
                $post = isset($this->requestData[$arr]) ? $this->requestData[$arr] : $type;
                $return[$arr] = $post;
            }
            return $return;
        }
        else
        {
            return isset($this->requestData[$key]) ? $this->requestData[$key] : $type;
        }
    }

    /**
     * @desc 合并数组并返回
     * @param type $values
     * @return type
     */
    public function merge($values)
    {
        return array_merge($this->retData, $values);
    }
	
	/**
	 * 合并数组并返回
	 * @param type $status
	 * @param type $message
	 * @return type
	 */
    public function returnMerge($status, $message)
    {
        $this->retData['status'] = $status;
		$this->retData['message'] = $message;
		return $this->retData;
    }

	/**
     * 获取返回数据后数据合成
     */
    public function requestEnd($returnData)
    {
        $returnData['message'] = $this->requestMessage($returnData);
        return $returnData;
    }
	
	public function requestMessage($returnData)
    {
        if (isset($returnData['message']))
        {
            return $returnData['message'];
        }
        return \Yii::t('app', $returnData['status']);
	}
	
	/**
	 * 转数组
	 * @param type $object
	 * @return type
	 */
	protected function toArray($object)
	{
		if (empty($object))
		{
			return [];
		}
		foreach ($object as $o)
		{
			$return[] = $o->getAttributes();
		}
		return $return;
	}
	function array2object($array) {
		if (is_array($array)) {
			$obj = new \stdClass();
			foreach ($array as $key => $val){
				$obj->$key = $val;
			}
		}
		else { $obj = $array; }
		return $obj;
	}
	/*
	 * 结算  作废了
	 */
	protected function tradeBalance($uid = 0, $orderData = [])
	{
		$userInfo = \lib\models\User::findOne(['id' => $uid]);
		if (empty($userInfo))
		{
			return ['status' => -3, 'message' => '用户数据异常'];
		}
		$total_money = $orderData['total_money'];
		$prime_money = $orderData['prime_money'];
		$transaction = \yii::$app->db->beginTransaction();
		try
		{
			//判断首次交易
			$userState = \lib\models\UserState::findOne(['uid' => $userInfo->id]);
			if (empty($userState))
			{
				$stateModel = new \lib\models\UserState();
				$stateModel->attributes = [
						'uid' => $userInfo->id,
						'first_jy_time' => time(),
						'first_jy_money' => $total_money,
				];
				if (!$stateModel->validate())
				{
					return ['status' => -3, 'message' => \lib\components\AdCommon::modelMessage($stateModel->errors)];
				}
				$stateModel->save();
			}
			//交易额统计
			$year	= date('Y');
			$month	= date('m');
			$day	= date('d');
			$amountData = \lib\models\UserAmount::findOne(['uid' => $userInfo->id, 'year' => $year, 'month' => $month, 'day' => $day]);
			if (empty($amountData))
			{
				$amountModel = new \lib\models\UserAmount();
				$amountModel->attributes = [
						'uid'	=> $userInfo->id, 
						'year'	=> $year, 
						'month' => $month, 
						'day'	=> $day,
						'amount' => $total_money,
						'addtime'=> time(),
				];
				if (!$amountModel->validate())
				{
					return ['status' => -3, 'message' => \lib\components\AdCommon::modelMessage($amountData->errors)];
				}
				$amountModel->save();
			}
			else
			{
				$amountData->amount = $amountData->amount + $total_money;
				$amountData->save();
			}
			$higherReturn = $this->higherProxy($userInfo, $prime_money);
			
			$transaction->commit();
			return ['status' => 1, 'data' => $higherReturn, 'message' => 'success'];
		}
		catch (Exception $ex)
		{
			$transaction->rollback();
			return parent::returnMerge(-3, $ex->getMessage());
		}
	}
	
	/**
	 * 扣除上级补货资金
	 * @param type $userInfo
	 * @param type $prime_money
	 */
	public function higherProxy($userInfo, $prime_money)
	{
		$userProxy = \lib\models\UserProxy::findOne(['id' => $userInfo->proxy]);
		if ($userInfo->pid == 0)
		{
			return true;
		}
		//我的上级
		$higher = \lib\models\User::findOne(['id' => $userInfo->pid]);
		if (empty($higher))
		{
			return true;
		}
		$accountData = \lib\models\UserAccount::findOne(['uid' => $higher->id]);
		$proxyData	 = \lib\models\UserProxy::findOne(['id' => $higher->proxy]);
		//需扣除的补货资金
		$vol = $prime_money * $proxyData->discount;
		//折扣差
		$discount = ($userProxy->discount - $proxyData->discount) * $prime_money;
		if ($discount < 0)
		{
			return true;
		}
		//增加扣除补货资金记录
		$userFillRecord = new \lib\models\UserFillRecode();
		$userFillRecord->attributes = [
				'uid' => $higher->id,
				'b_account_money' => $accountData->account_fill,
				'a_account_money' => $accountData->account_fill - $vol,
				'action_money' => -$vol,
				'action_type' => 2,
				'action' => '下级补货',
				'time' => time(),
		];
		if (!$userFillRecord->validate())
		{
			return self::returnMerge(-4, \lib\components\AdCommon::modelMessage($userFillRecord->errors));
		}
		$userFillRecord->save();

		//下级补货
		$action_money = $discount + $vol;
		$a_account_money = $accountData->account + $vol;
		$userMoneyRecord = new \lib\models\UserMoneyRecord();
		$userMoneyRecord->attributes = [
				'uid' => $higher->id,
				'b_account_money' => $accountData->account,
				'a_account_money' => $a_account_money,
				'action_money' => $vol,
				'action_type' => 3,
				'action' => '下级补货',
				'time' => time(),
		];
		if (!$userMoneyRecord->validate())
		{
			return self::returnMerge(-5, \lib\components\AdCommon::modelMessage($userMoneyRecord->errors));
		}
		$userMoneyRecord->save();
		
		//下级补货折扣差记录
		$moneyRecord = new \lib\models\UserMoneyRecord();
		$moneyRecord->attributes = [
				'uid' => $higher->id,
				'b_account_money' => $a_account_money,
				'a_account_money' => $a_account_money + $discount,
				'action_money' => $discount,
				'action_type' => 4,
				'action' => '下级补货返折扣差',
				'time' => time(),
		];
		if (!$moneyRecord->validate())
		{
			return self::returnMerge(-5, \lib\components\AdCommon::modelMessage($moneyRecord->errors));
		}
		$moneyRecord->save();

		//返折扣差记录
		$userDiscountModel = new \lib\models\UserDiscount();
		$userDiscountModel->attributes = [
				'uid' => $higher->id,
				'back_uid' => $userInfo->id,
				'discount' => $discount,
				'money' => $prime_money,
				'addtime' => time(),
		];
		if (!$userDiscountModel->validate())
		{
			return self::returnMerge(-6, \lib\components\AdCommon::modelMessage($userDiscountModel->errors));
		}
		$userDiscountModel->save();

		//扣除补货资金
		$account_int = $accountData->account_int + $action_money;
		$account = $accountData->account + $action_money;
		$account_fill = $accountData->account_fill - $vol;

		\lib\models\UserAccount::updateAll(['account_int' => $account_int, 'account' => $account, 'account_fill' => $account_fill], ['id' => $accountData->id]);
		
		if ($account_fill <= 0)
		{
			$sms = '您目前补货账户资金不足，为了不影响您的正常交易，请尽快补货';
			\lib\components\Sms::app()->send($higher->phone, $sms);
		}
		
		return true;
	}
}