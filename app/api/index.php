<?php
//header("charset=utf-8");
// 框架路径，配置信息路径，项目路径
$yii = dirname(__FILE__).'/../../frame/Yii.php';
$main = dirname(__FILE__).'/protected/config/main.php';
$app_root = dirname(__FILE__).DIRECTORY_SEPARATOR;

//项目目录绝对路径
defined('ROOT') or define('ROOT', $app_root);
defined('APPROOT') or define('APPROOT', $app_root.'protected');
// 是否开启DEBUG
defined('YII_DEBUG') or define('YII_DEBUG', FALSE);
// Yii 将然后追加文件名和调用栈的行号到每条跟踪信息中。 数字 YII_TRACE_LEVEL 决定每个调用栈的几层应当被记录
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);
//k开始
require_once($yii);
$config = require_once($main);
(new yii\web\Application($config))->run();