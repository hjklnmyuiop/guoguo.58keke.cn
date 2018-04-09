<?php
namespace lib\config;

return [
		//主数据库配置
		'class' => 'yii\db\Connection',
		'dsn' => 'mysql:host=47.96.23.158;dbname=guoguo.58keke.cn',
		'username' => 'root',
		'password' => 'ce9d5c8169',
		'charset' => 'utf8',
		'tablePrefix' => 'hd_',
		//从数据库配置
		/*'slaveConfig' => [
				'username' => 'xuwenhu',
				'password' => 'xwh_admin!1',
				'charset' => 'utf8',
		],
		'slaves' => [
				['dsn' => 'mysql:host=localhost;dbname=yuese'],
		],*/
];
