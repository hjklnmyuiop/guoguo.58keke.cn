<?php
/**
 * @Copyright (C) 2015
 * @Author
 * @Version  Beta 1.0
 */

namespace app\controllers;

/**
 * 系统调用
 */
use Yii;
use yii\web\Controller;

class SiteController extends Controller
{
	/**
	 * 默认访问首页
	 * @author kevin
	 */
	public function actionIndex()
	{
	}

    /**
     * 错误处理
     * @author kevin
     * @return type
     */
    public function actionError()
    {
        $exception = \Yii::$app->errorHandler->exception;
        if ($exception !== null) {
            return $this->render('error', ['message' => $exception]);
        }
    }
}