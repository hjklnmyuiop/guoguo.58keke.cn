<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 2015/5/29 0029
 * Time: 上午 10:05
 */

namespace lib\hooks;

use lib\models\Article;
use lib\models\User;
use Yii;

class userHook extends \lib\hooks\basicHook
{

	public function index(){
		$id = (int)$this->get('id');
		switch ($id){
			//发布最多/活跃
			case '1':
				$order = 'arti_num desc';
				break;
			//登录最多/活跃
			case '2':
				$order = 'login_num desc';
				break;
			case '3':
				$order = 'id desc';
				break;
		}
		$user = \lib\models\User::find()->where(['status'=>2])->limit(3)->orderBy($order)->all();
		$this->retData['items'] = $user;
		return $this->retData;
	}
	/**
	 *
	 * @return Ambigous <\lib\hooks\type, multitype:number >|multitype:number string
	 */
	public function lists()
	{
		$id = (int)$this->get('id');
		switch ($id){
			//发布最多/活跃
			case '1':
				$order = 'arti_num desc';
				break;
			//登录最多/活跃
			case '2':
				$order = 'login_num desc';
				break;
			case '3':
				$order = 'id desc';
				break;
		}
		$where  = 'status=2';
		$pagesize = !empty($this->requestData['pagesize'])?$this->requestData['pagesize']:15;
		$page = !empty($this->requestData['page'])?$this->requestData['page']:1;
		$user_model =  new User();
		$count = $user_model->find()->where($where)->count();
		$userList = $user_model->find()->where($where)
				->orderBy($order)
				->limit($pagesize)
				->offset(($page-1)*$pagesize)
				->all();
		$this->retData['count'] = $count;
		$this->retData['items'] = $userList;
		return $this->retData;
	}
	/**
	 * 资讯详情页
	 */
	public function detail()
	{
		$id = (int)$this->get('id');
		$user_model =  new User();
		$user = $user_model->findOne(['id' => $id,'status'=>2]);
		$this->retData['items'] = $user;
		return $this->retData;
	}
}