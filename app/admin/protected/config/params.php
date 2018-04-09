<?php
return [
    'url' => require_once dirname(__FILE__).'/url.php',
    'pageSize'     => '20',  # 分页显示条
    'ExprotMaxDay' => '31',
    'uploadprefix' => 'IMG_',
    'uploadPath'   => '../upload',
    'imagePath'    => '/images/',
    'filePath'     => '/file/',
    'thumbPath'    => '/thum/',
	'appInstallType' => ['WEB','andoid','IOS'],
    'is_show'       => [0 => '不显示', 1 => '显示'],
    'userStatus'    => [1 => '待审核', 2 => '正常', 3 => '禁止登陆', 4 => '回收站'],
	'matchtype'      => ['小组赛', '八强赛', '四强赛','半决赛', '冠军赛'],
	'result'      => [1=>'队伍1', 2=>'队伍2', 3=>'平'],
	'teamtype'      => [1=>'冠军', 2=>'四强', 3=>'八强'],
	'adsType'      => [ 1 => 'pc首页',  2 =>'xcx首页'],
];