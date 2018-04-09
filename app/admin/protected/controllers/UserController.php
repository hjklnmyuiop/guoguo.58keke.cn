<?php
namespace app\controllers;

use app\controllers\SellerController;
use app\library\UserLibrary;
use lib\components\AdCommon;
use lib\models\User;

class UserController extends SellerController
{
    /**
     * [$_user User]
     * @var [type]
     */
    private $_user;
    /**
     * [init 初始化]
     * @return [type] [description]
     */
    public function init()
    {
        parent::init();
        $this->_user = new User();
    }

    /**
     * [actionIndex 用户列表]
     * @return [type] [description]
     */
    public function actionIndex()
    {
        $search = $this->get('search');
        $where  = '1=1';
        $order  = 'id desc';
    	if(!empty($search['type']) && !empty($search['keyword']))
        {
            if($search['type'] == 'username')
            {
                $where .= " and " . $search['type'] ." like '%" . $search['keyword'] . "%'";
            }
            else
            {
                $where .= " and " . $search['type'] ."='" . $search['keyword'] . "'";
            }
        }
        if(!empty($search['stime']))
        {
            $stime = strtotime($search['stime']);
            $etime = empty($search['etime']) ? time() : strtotime($search['etime']);
            $where .= " and register_time between " . $stime ." and " . $etime;
        }
        #排序
        if(isset($search['score']) && !empty($search['score'])) $order = 'score ' . $search['score'];
        $query = $this->query($this->_user, '', $where, $order);
        $this->data['count'] = $query['count'];
        $this->data['page']  = $query['page'];
        $this->data['data']  = $query['data'];
        $this->data['searchvalue'] = $search;
        $this->data['search'] = ['id' => \yii::t('app', '用户ID'),
	        'username' => \yii::t('app', '用户名称'),
        ];
        return $this->view();
    }

    /**
     * [actionAdd 添加用户]
     * @return [type] [description]

    public function actionAdd()
    {
        if($this->isPost())
        {
            $user     = $this->post('User');
            $user['is_auth']   = 0;
            $user['registform']   = 1;
            if ($user['cateid']){
            	$cateinfo = $this->_category->findOne(array('id'=>$user['cateid']));
            	$user['catename'] = $cateinfo->name;
            }
            $password = $this->post('qpawd');
            $bank     = $this->post('UserBank');
            $data  = [];//$this->post('UserData');
            if(empty($user['pawd']))                 $this->error(\yii::t('app', 'emptyPassword'));
            if(!AdCommon::alpha_dash($user['pawd'])) $this->error(\yii::t('app', 'passwordError'));
            if(strlen($user['pawd']) < 6 || strlen($user['pawd']) > 12) $this->error(\yii::t('app', 'lengthPassword'));
            if($user['pawd'] != $password)           $this->error(\yii::t('app', 'qrPassword'));
            $result = UserLibrary::app()->addUser($user, $bank, $data);
            if($result['state'])
            {
                $this->success(\yii::t('app', 'success'), \yii::$app->params['url']['user']);
            }
            else
            {
                $this->error($result['msg']);
            }
        }
        $this->data['cate'] = $this->_category->getCategory(array('is_show'=>1));
        $this->data['model'] = $this->_user;
        $this->data['bank']  = new \lib\models\UserBank;
        $this->data['info']  = new \lib\models\UserData;
        return $this->view();
    }
	*/
    /**
     * [actionAdd 修改用户]
     * @return [type] [description]
     */
    public function actionEdit()
    {
        $id = $this->get('uid');
        if(empty($id)) $this->error(\yii::t('app', 'error'));
        $model = $this->_user->findOne($id);
        if($this->isPost()) {
            $user     = $this->post('User');
            $password = $this->post('qpawd');
            if(!empty($user['pawd'])) {
                if(!AdCommon::alpha_dash($user['pawd'])) $this->error(\yii::t('app', 'passwordError'));
                if(strlen($user['pawd']) < 6 || strlen($user['pawd']) > 12) $this->error(\yii::t('app', 'lengthPassword'));
                if($user['pawd'] != $password)           $this->error(\yii::t('app', 'qrPassword'));
                $user['pawd'] = AdCommon::encryption($model['codes'].$user['pawd']);
            } else {
                $user['pawd'] = $model['pawd'];
            }
            $result = UserLibrary::app()->updateUser($id, $user);
            if($result['state']) {
                $this->success(\yii::t('app', 'success'), \yii::$app->params['url']['user']);
            } else {
                $this->error($result['msg']);
            }
        }

        $this->data['model']   = $model;
        return $this->view();
    }

    /**
     * [actionDelete 删除]
     * @return [type] [description]
     */
    public function actionDelete()
    {
        $id = $this->post('data');
        if(empty($id)) $this->error(\yii::t('app', 'error'));

        $user = $this->_user->findOne($id)->delete();
        if($user)
       	{
           $this->success(\yii::t('app', 'success'));
       	}
       	else
       	{
                
        	$this->error(\yii::t('app', 'fail'));
       	}
    }


    /**
     * [actionInfo 用户详情]
     * @return [type] [description]
     */
    public function actionInfo()
    {
		$id = $this->get('uid');
        if(empty($id)) $this->error(\yii::t('app', 'error'));
        $user =  User::find()->where('id='.$id)->one();
        $where = ['userid' => $id];
       	$this->data['user'] =$user;
        return $this->view();
    }


}