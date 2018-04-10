<?php
/**
 * @Copyright (C) 2015
 * @Author
 * @Version  Beta 1.0
 */

namespace app\controllers;

use Yii;
use Yar;
use Yar_Client;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\HttpException;

class SiteController extends Controller
{
	public function actionIndex()
	{
		throw new HttpException(404, "请求错误", -9);

	}

	public function actionPost()
	{
		$url = 'http://'.$_SERVER['SERVER_NAME'].'/post/?url=';
		$apiname = $_GET['url'];
		if(is_array($_GET)){
			foreach ($_GET as $key => $val){
				$postData[$key] = $val;
			}
		}else {
			echo "请传递参数";
			exit;
		}
		echo $return = Yii::$app->curl->post($url.$apiname, $postData);
	}

	/**
	 * @desc 错误提示页面
	 */
	public function actionError()
	{
		$exception = \Yii::$app->errorHandler->exception;
		if($exception!==null)
		{
			echo Json::encode(array('status' => -10/*$exception->getCode()*/, 'message' => $exception->getMessage()));
		}
	}
}