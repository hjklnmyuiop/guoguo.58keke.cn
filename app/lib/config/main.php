<?php
/**
 * @Copyright (C) 2015
 * @Author
 * @Description 公共配置文件
 */

namespace lib\config;

return [
		'bootstrap' => ['gii'],
		'modules' => [
				'gii' => ['class' => 'yii\gii\Module'],
				//'debug' => ['class' => 'yii\debug\Module']
		],
		'language' => 'zh-CN',
		'components' => [
				'request' => [
						'cookieValidationKey' => 'qw1r32q16we54tw65443236r1321dfa35s',
				],
				'db' => require_once __DIR__ . DS . 'db.php',
				'curl' => [
						'class' => 'lib\vendor\curl\Curl',
				],
				'json' => [
						'class' => 'lib\vendor\json\JsonClient',
				],
				'upload' => [
						'class' => 'lib\upload\Uploader'
				],
				'encrypt' => [
						'class' => 'lib\vendor\encrypt\Encrypt',
				],
				'easemob' => [
					'class' => 'lib\vendor\easemob\Easemob',
				],
				'user' => [
						'identityClass' => 'app\models\User',
						'enableAutoLogin' => true,
				],
				'errorHandler' => [
						'errorAction' => 'site/error',
				],
				'mailer' => [
						'class' => 'yii\swiftmailer\Mailer',
						'transport' => [
								'class' => 'Swift_SmtpTransport',
								'host' => 'smtp.qq.com',
								'username' => '1985315251@qq.com',
								'password' => 'Er309uFs',
								'port' => '25',
								'encryption' => 'tls',
						],
						'messageConfig' => [
								'charset' => 'UTF-8',
								'from' => ['1985315251@qq.com' => '卡客一线通']
						],
				],
				'redis' => [
						'class' => 'yii\redis\Connection',
						'hostname' => '120.25.84.17',
						'port' => 6379,
						'database' => 0,
				],
				'urlManager' => [
						'class' => 'yii\web\UrlManager',
						'enablePrettyUrl' => true,
						'showScriptName' => false,
						'rules' => [
								'<controller:\w+>/<id:\d+>' => '<controller>/view',
								'<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
								'<controller:\w+>/<action:\w+>' => '<controller>/<action>',
						]
				],
				'log' => [
						'traceLevel' => YII_DEBUG ? 3 : 0,
						'targets' => [
								[
										'class' => 'yii\log\FileTarget',
										'levels' => ['error', 'warning'],
								],
						],
				],
		],
		'params' => [
				'setting'		=> [],
				'adminEmail'	=> 'admin@example.com',
		],
];
