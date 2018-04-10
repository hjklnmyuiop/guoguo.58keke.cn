<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 2015/5/28
 * Time: 21:51
 */
namespace app\controllers;

use Yii;
use yii\helpers\Json;
use yii\helpers\Url;
use lib\models\User;
use lib\models\UserShare;

class OtherController extends \app\components\WebController
{
    public function init()
    {
        parent::init();
    }

    /**
     * 控制器前操作(non-PHPdoc)
     * @see \yii\web\Controller::beforeAction()
     */
    public function beforeAction($action)
    {
        parent::beforeAction($action);

        $route = $this->action->controller->id . '/' . $this->action->id;
        $url = urlencode(\yii\helpers\Url::toRoute(array_merge([$route], $_GET)));
        //判断是否登录
        //$this->uid = 100963;
        if (empty($this->uid)) {
            if ($this->isPost) {
                exit(\yii\helpers\Json::encode(['status' => 2, 'url' => $url]));
            } else {
                header("location:" . Url::toRoute(['u/login', 'redirect' => $url]));
                exit;
            }
        }
        return true;
    }

    /**
     * 微信分享朋友圈加积分
     * @return type
     */
    public function actionWxshare()
    {
        if ($this->isPost()) {
            $id = $this->uid;
            //$id = $this->post('uid');
            $where = "uid=".$id;
            $userShare = new UserShare();
            $userShare->uid = $id;
            $userShare->addtime=time();
            $userShare->save();
            if (empty($userShare->errors)) {
                return Json::encode(array('status' => 1, 'mess' => 'success','num'=>$userShare->find()->where($where)->count()));
            } else {
                return Json::encode(array('status' => 0, 'mess' => 'fail'));
            }
        }
    }
}