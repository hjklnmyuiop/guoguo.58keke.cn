<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 2015/5/29 0029
 * Time: 上午 10:05
 */

namespace lib\hooks;

use Yii;

class indexHook extends \lib\hooks\basicHook
{
	/**
	 * 找回密码
	 * @return Ambigous <\lib\hooks\type, multitype:number >|multitype:number string
	 */
	public function banner()
	{
		$banner = \lib\models\Ads::find()->where(['type'=>1])->all();
		$this->retData['items'] = $banner;
		return $this->retData;
	}
	public function theme()
	{
		$hot_catogory = \lib\models\ArticleCate::find()->where(['hot'=>1])->all();
		if(is_array($hot_catogory)){
			foreach($hot_catogory as $key=> $value){
				$hot_catogory[$key]['image'] = $value['image_l'];
			}
		}
		$this->retData['items'] = $hot_catogory;
		return $this->retData;
	}
	public function comarticle()
	{
		$com_article = \lib\models\Article::find()->with('user')->where(['commend'=>1])->limit(8)->all();
		if($com_article){
			foreach($com_article as $key=>$val){
				$rd['user_name'] = $val->user->name;
				$rd['id'] = $val->id;
				$rd['title'] = $val->title;
				$rd['thumb'] = $val->thumb;
				$rdata[] =$this->array2object($rd);;
			}
		}
		$this->retData['items'] = $rdata;
		return $this->retData;
	}
	public function category()
	{
		$id = isset($_POST['id'])?$_POST['id']:0;
		$catogory = \lib\models\ArticleCate::find()->where(['pid'=>$id])->all();
		$this->retData['items'] = $catogory;
		return $this->retData;
	}
}