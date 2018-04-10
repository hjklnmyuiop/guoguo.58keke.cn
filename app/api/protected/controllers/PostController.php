<?php

/**
* @Copyright (C) 2015
* @Author
* @Version  Beta 1.0
*/

/**
 * POST API请求处理
 */
namespace app\controllers;

use yii;
use yii\web\Controller;
use yii\web\HttpException;
use app\components\ApiPost;

class PostController extends Controller
{
    /**
     * 提交查询验证
     * @var boolean
     */
    public $enableCsrfValidation = false;

    /**
     * 用户ID
     * @var integer
     */
    public $uid = 0;

    /**
     * 来源
     * @var integer
     */
    public $from = 1;

    /**
     * 继承
     */
    public function init()
	{
		parent::init();
        // request请求校验
        ApiPost::requestCheck();
        //来源
        $this->from = Yii::$app->request->post('from');
    }

		/**
     * 默认访问页面
     * @throws HttpException
     */
    public function actionIndex()
    {
        if (!isset(Yii::$app->params['apiurl'][Yii::$app->request->get('url')]))
        {
            ApiPost::error("api config method error");
        }
        $apiData    = Yii::$app->params['apiurl'][Yii::$app->request->get('url')];
        $controller = (string) ucfirst($apiData['controller']);
        $action     = (string) (isset($apiData['method']) ? $apiData['method'] : 'index');
        $retData    = ApiPost::requestStart($apiData);
        $param      = Yii::$app->request->post('param', array());
        //用户ID
        $this->uid  = $retData['uid'];
        //控制器文件
        $className       = (string) strtolower($controller) . 'Hook';
        $controller_file = dirname(ROOT).DS.'lib'.DS.'hooks'.DS.$className.'.php';
        if (!file_exists($controller_file))
        {
            ApiPost::error("api model file error");
        }
		$controller_obj = "\lib\\hooks\\".$className;
		$model = new $controller_obj($this);
		$class_methods = get_class_methods($model);
		if (!in_array($action, $class_methods))
		{
			ApiPost::error("api model action error");
		}
        $model->setSetting();
        $model->object = $this;
        $model->apiData = $apiData;
        $model->retData = $retData;
        $model->requestData = ApiPost::requestPostData($_POST);
        ApiPost::requestEnd($model->requestEnd($model->$action()));
    }
}