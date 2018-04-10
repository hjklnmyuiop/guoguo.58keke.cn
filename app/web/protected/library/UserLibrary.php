<?php
namespace app\library;
use lib\components\AdCommon;
use lib\models\User;
use lib\models\UserAuthen;
use lib\models\UserBank;
use lib\models\UserAccount;
use lib\models\UserData;
use lib\models\UserRecharge;
use lib\models\UserThumb;
class UserLibrary
{

	/**
	 * [app description]
	 * @return [type] [description]
	 */
	public static function app()
	{
		$class = __class__;
		$object = new $class;
		return $object;
	}
    /**
     * [addUser 添加用户]
     * @param [type] $user    [description]
     * @param [type] $bank    [description]
     * @param [type] $address [description]
     */
    public function addUser($user)
    {
        $user['codes'] = AdCommon::uniqueGuid();
        if($user['pawd'])	$user['pawd']  = AdCommon::encryption($user['codes'].$user['pawd']);
        $user['register_time'] = time();
        $user['lastlogin'] 		= $user['register_time'];
        $user['register_ip']  	= \Yii::$app->request->getUserIP();
        $transaction = \yii::$app->db->beginTransaction();
        try
        {
            $model = new User();
            $model->attributes = $user;
            $model->setScenario('register');
            $model->save();
            if(empty($model->errors))
            {
                $transaction->commit();
                return ['state' => true,'id'=>$model->id ];
            }else {
                return ['state' => false, 'msg' => AdCommon::modelMessage($model->errors)];
            }
        }
        catch (Exception $e) {
            $transaction->rollback();
            return ['state' => false, 'msg' => \yii::t('app', 'fail')];
        }
    }

 /**
     * [updateUser 修改用户]
     * @param  [type] $uid     [description]
     * @param  [type] $user    [description]
     * @param  [type] $bank    [description]
     * @param  [type] $address [description]
     * @return [type]          [description]
     */
    public function updateUser($uid, $user)
    {
        $model  = User::findOne($uid);
        $transaction = \yii::$app->db->beginTransaction();
        try
        {
            #用户基本信息
            $model->attributes = $user;
            $model->save();

            if(empty($model->errors))
            {
                $transaction->commit();
                return ['state' => true, 'msg' => \yii::t('app', 'success')];
            }
            else
            {
                $transaction->rollback();
                return ['state' => false, 'msg' => AdCommon::modelMessage($model->errors)];
            }
        } catch (Exception $e) {
            $transaction->rollback();
            return ['state' => false, 'msg' => \yii::t('app', 'fail')];
        }
    }
   

    /**
     * [doDraw 处理出款]
     * @param  [type] $id     [description]
     * @param  [type] $state  [description]
     * @param  [type] $remark [description]
     * @return [type]         [description]
     */
    public function doDraw($id, $state, $remark, $admin)
    {
		$model_pd = new UserRecharge();
        $query = \lib\models\UserPdCash::findOne($id);

        if(empty($query['pdc_id']))   return ['state' => false, 'msg' => \yii::t('app', 'noRow')];
        if($query['pdc_payment_state'] != 0) return ['state' => false, 'msg' => \yii::t('app', 'backFinish')];
        $transaction = \yii::$app->db->beginTransaction();
        try
        {
            $query->pdc_payment_state      = $state;
            $query->pdc_payment_time = time();
            $query->remark      = $remark;
			$query->pdc_payment_admin=admin;
            $query->save();

			$member_info = \lib\models\User::find()->where(['id' => $query['pdc_member_id']])->one();
			//扣除冻结的预存款
			$data = array();
			$data['member_id'] = $member_info['id'];
			$data['member_name'] = $member_info['username'];
			$data['amount'] = $query['pdc_amount'];
			$data['order_sn'] = $query['pdc_sn'];
			$data['admin_name'] =  $admin;
            if($state == 1)
            {
				$result = $model_pd->changePd('cash_pay',$data);
            }else{
				$result = $model_pd->changePd('cash_del',$data);
			}

            if(empty($query->errors) && $result['state'])
            {
                $transaction->commit();
                return ['state' => true, 'msg' => '提现完成'];
            }
            else
            {
                $transaction->rollback();
                return ['state' => false, 'msg' => AdCommon::modelMessage($query->errors)];
            }
        }
        catch (Exception $e)
        {
            $transaction->rollback();
            return ['state' => false, 'msg' => \yii::t('app', 'fail')];
        }
    }
}