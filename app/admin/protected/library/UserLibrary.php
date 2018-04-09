<?php
namespace app\library;
use lib\components\AdCommon;
use lib\models\User;
use lib\models\UserBank;
use lib\models\UserAccount;
use lib\models\UserData;
use lib\models\Good;
use lib\models\GoodThumb;
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
     * [addGood 添加服务]
     * @param [type] $uid [用户ID]
     * @param array  $service  [服务内容]
     * @param  array  $thumb [缩略图]
     * @return [array]        [返回值]
     */
    public function addGood($uid, $service,$thumb = array())
    {
		$transaction = \yii::$app->db->beginTransaction();
		try
		{
			$good = new Good();
			$service['uid'] = $uid;
			$good->attributes = $service;
			$good->save();

			$thumbError = '';
			if(isset($thumb['url']) && count($thumb['url']) > 0)
			{
				$result = $this->addThumb($good->id, $thumb);
				if(!$result['state']) $thumbError = $result['msg'];
			}

			if(empty($good->errors) && empty($thumbError))
			{
				$transaction->commit();
				return ['state' => true, 'msg' => ''];
			}
			else
			{
				$transaction->rollback();
				return ['state' => false, 'msg' => AdCommon::modelMessage($good->errors).$thumbError];
			}
		}
		catch (Exception $e)
		{
			$transaction->rollback();
			return ['state' => false, 'msg' => \yii::t('app', 'fail')];
		}
    }
    /**
     * [updateService 修改服务信息]
     * @param   int $gid [服务ID]
     * @param  [array] $form  [表单内容]
     * @param  array  $thumb [缩略图]
     * @return [array]        [返回值]
     */
    public function updateGood($gid, $form, $thumb = array())
    {
    	$transaction = \yii::$app->db->beginTransaction();
    	try
    	{
    		$model = Good::findOne($gid);
    		$model->attributes = $form;
    		$model->save();

    		$thumbError = '';

    		if(isset($thumb['url']) && count($thumb['url']) > 0)
    		{
    			\lib\models\GoodThumb::deleteAll('gid='.$gid);
    			$result = $this->addThumb($gid, $thumb);
    			if(!$result['state']) $thumbError = $result['msg'];
    		}
    		if(empty($model->errors) && empty($thumbError))
    		{
    			$transaction->commit();
    			return ['state' => true, 'msg' => ''];
    		}
    		else
    		{
    			$transaction->rollback();
    			return ['state' => false, 'msg' => AdCommon::modelMessage($model->errors).$thumbError];
    		}
    	}
    	catch (Exception $e)
    	{
    		$transaction->rollback();
    		return ['state' => false, 'msg' => \yii::t('app', 'fail')];
    	}
    }
    /**
     * [addAlbum 添加相册]
     * @param [type] $uid [用户ID]
     * @param array  $service  [服务内容]
     * @param  array  $thumb [缩略图]
     * @return [array]        [返回值]
     */
    public function addAlbum($uid, $album,$thumb = array())
    {
    	$transaction = \yii::$app->db->beginTransaction();
    	try
    	{
    		$UserThumb = new UserThumb();
    		$UserThumb['uid'] = $uid;
    		$UserThumb->attributes = $album;
    		$UserThumb->save();
    		$thumbError = '';
    		if(isset($thumb['url']) && count($thumb['url']) > 0)
    		{
    			$result = $this->addThumblist($UserThumb->id, $thumb);
    			if(!$result['state']) $thumbError = $result['msg'];
    		}
    		if(empty($UserThumb->errors) && empty($thumbError))
    		{
    			$transaction->commit();
    			return ['state' => true, 'msg' => ''];
    		}
    		else
    		{
    			$transaction->rollback();
    			return ['state' => false, 'msg' => AdCommon::modelMessage($UserThumb->errors).$thumbError];
    		}
    	}
    	catch (Exception $e)
    	{
    		$transaction->rollback();
    		return ['state' => false, 'msg' => \yii::t('app', 'fail')];
    	}
    }
    /**
     * [updateService 修改服务信息]
     * @param   int $gid [服务ID]
     * @param  [array] $form  [表单内容]
     * @param  array  $thumb [缩略图]
     * @return [array]        [返回值]
     */
    public function upAlbum($id, $form, $thumb = array())
    {
    	$transaction = \yii::$app->db->beginTransaction();
    	try
    	{

    		$model = UserThumb::findOne($id);
    		$model->attributes = $form;
    		$model->save();

    		$thumbError = '';

    		if(isset($thumb['url']) && count($thumb['url']) > 0)
    		{
    			\lib\models\UserThumbList::deleteAll('thumbid='.$id);
    			$result = $this->addThumblist($model->id, $thumb);
    			if(!$result['state']) $thumbError = $result['msg'];
    		}
    		if(empty($model->errors) && empty($thumbError))
    		{
    			$transaction->commit();
    			return ['state' => true, 'msg' => ''];
    		}
    		else
    		{
    			$transaction->rollback();
    			return ['state' => false, 'msg' => AdCommon::modelMessage($model->errors).$thumbError];
    		}
    	}
    	catch (Exception $e)
    	{
    		$transaction->rollback();
    		return ['state' => false, 'msg' => \yii::t('app', 'fail')];
    	}
    }
    /**
     * [addThumb 上传预约缩略图]
     * @param [int] $gid   [商品ID]
     * @param [array] $thumb [缩略图]
     * @return array  [返回值]
     */
    public function addThumb($gid, $thumb)
    {
    	$model = new \lib\models\GoodThumb();
    	$modelError = '';
    	foreach ($thumb['url'] as $key => $value) {
    		$model->id = '';
    		$model->attributes = ['gid' => $gid,'title'=>$thumb['title'][$key], 'image' => $value, 'order' => $key+1];
    		$model->save();
    		$model->isNewRecord = true;
    		if(!empty($model->errors)) $modelError = $model->errors;
    	}

    	if(empty($modelError))
    	{
    		return ['state' => true, 'msg' => ''];
    	}
    	else
    	{
    		return ['state' => false, 'msg' => AdCommon::modelMessage($modelError)];
    	}
    }
    /**
     * [addThumb 上传相册集缩略图]
     * @param [int] $gid   [商品ID]
     * @param [array] $thumb [缩略图]
     * @return array  [返回值]
     */
    public function addThumblist($thumbid, $thumb)
    {
    	$model = new \lib\models\UserThumbList();
    	$modelError = '';
    	foreach ($thumb['url'] as $key => $value) {
    		$model->id = '';
    		$model->attributes = ['thumbid' => $thumbid,'title'=>$thumb['title'][$key], 'image' => $value, 'order' => $key+1];
    		$model->save();
    		$model->isNewRecord = true;
    		if(!empty($model->errors)) $modelError = $model->errors;
    	}

    	if(empty($modelError))
    	{
    		return ['state' => true, 'msg' => ''];
    	}
    	else
    	{
    		return ['state' => false, 'msg' => AdCommon::modelMessage($modelError)];
    	}
    }
    /**
     * 给数据包添加字段
     * @param unknown $name
     * @param unknown $type
     */
	public function  addElement($name,$type){
		if($type==1){
			\yii::$app->db->createCommand("ALTER TABLE ".UserData::tableName()." ADD `$name` INT( 11 ) DEFAULT NULL ")->query();
		}elseif ($type==2) {
			$result = \yii::$app->db->createCommand("ALTER TABLE ".UserData::tableName()." ADD `$name` FLOAT( 5,2 ) DEFAULT '' ")->query();
		}elseif ($type==3){
			$result = \yii::$app->db->createCommand("ALTER TABLE ".UserData::tableName()." ADD `$name` VARCHAR( 32 ) DEFAULT '' ")->query();
		}
	}
    /**
     * [tree description]
     * @param  integer $pid [description]
     * @return [type]       [description]
     */
    public function tree($pid = 0)
    {
        if($pid == 0) return ['lt' => 1, 'rt' => 2, 'mark' => 0, 'rank' => 1];
        $parent = User::findOne($pid);
        $lt = $parent['lt']+1;
        $rt = $parent['lt']+2;
        \yii::$app->db->createCommand("update ".User::tableName()." set lt=lt+2 where lt>".$parent['lt']." and mark=" . $parent['mark'])->query();
        \yii::$app->db->createCommand("update ".User::tableName()." set rt=rt+2 where lt>=".$parent['lt']." and mark=" . $parent['mark'])->query();
        \yii::$app->db->createCommand("update ".User::tableName()." set rt=rt+2 where lt<".$parent['lt']." and rt>".$parent['rt']." and mark=" . $parent['mark'])->query();
        return ['lt' => $lt, 'rt' => $rt, 'mark' => $parent['mark'], 'rank' => $parent['rank']+1];
    }

    /**
     * [updateTree description]
     * @param  [type] $uid [description]
     * @return [type]      [description]
     */
    public function updateTree($uid)
    {
        $user = User::findOne($uid);
        \yii::$app->db->createCommand("update ".User::tableName()." set lt=lt-2 where lt>".$user['lt']." and mark=" . $user['mark'])->query();
        \yii::$app->db->createCommand("update ".User::tableName()." set rt=rt-2 where rt>".$user['lt']." and mark=" . $user['mark'])->query();
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
			$query->pdc_payment_admin=$admin;
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