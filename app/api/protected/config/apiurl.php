<?php

namespace app\config;
/**
 * api接口URL构造
 * name：接口名称
 * make：接口权限 1：公开，2：登录， 3：商家使用
 * status：接口状态，1：开放，-1：关闭
 * logs: 0:不记录，1：记录日志
 * mark: false 不需要版本校验, 不设置或者true则校验版本
 * vist: 每分钟最大访问量
 */

$apiUrl['banner']		= ['name'=>'banner','controller' =>'index',	'method' => 'banner','status'=>1, 'mark' => false];
$apiUrl['theme']		= ['name'=>'theme','controller' =>'index',	'method' => 'theme','status'=>1, 'mark' => false];
$apiUrl['comarticle']		= ['name'=>'hotarticle','controller' =>'index',	'method' => 'comarticle','status'=>1, 'mark' => false];
$apiUrl['category']		= ['name'=>'hotarticle','controller' =>'index',	'method' => 'category','status'=>1, 'mark' => false];
$apiUrl['articlelist']	= ['name'=>'article','controller' =>'article',	'method' => 'articlelist','status'=>1, 'mark' => false];
$apiUrl['articledetail']= ['name'=>'article','controller' =>'article',	'method' => 'detail','status'=>1, 'mark' => false];
/**************作者模块********************/
$apiUrl['user']= ['name'=>'user','controller' =>'user',	'method' => 'index','status'=>1, 'mark' => false];
$apiUrl['userlist']= ['name'=>'list','controller' =>'user',	'method' => 'lists','status'=>1, 'mark' => false];
$apiUrl['userdetail']= ['name'=>'detail','controller' =>'user',	'method' => 'detail','status'=>1, 'mark' => false];
return $apiUrl;