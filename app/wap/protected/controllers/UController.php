<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 2015/5/28
 * Time: 21:15
 */
namespace app\controllers;
use lib\models\Article;
use lib\models\ArticleCollect;
use lib\models\Sysmess;
use Yii;
use yii\helpers\Json;
use yii\helpers\Url;
use lib\models\User;
use lib\models\Setting;
use lib\components\AdCommon;

class UController extends \app\components\WebController
{

	private $_article;
	private $_fav;
	/**
	 * @var用户模型
	 * @access  private
	 */
	private $_user_model;
	private $_sys;
	private $pagesize=10;
	/**
	 * 控制器前操作(non-PHPdoc)
	 * @see \yii\web\Controller::beforeAction()
	 */
	public function init()
	{
		parent::init();

		$this->_user_model = new User();
		$this->_article  = new Article();
		$this->_fav  = new ArticleCollect();
		$this->_sys  = new Sysmess();
		$this->_data['navcss'] = 'u';
	}
	public function beforeAction($action)
	{
		parent::beforeAction($action);
		$route = $this->action->controller->id.'/'.$this->action->id;
		$url = urlencode(\yii\helpers\Url::toRoute(array_merge([$route], $_GET)));
		if (empty($this->userData))
		{
			if ($this->isAjax())
			{
				exit(\yii\helpers\Json::encode(['status' => 2, 'url' => $url]));
			}
			else
			{
				header("location:".Url::toRoute(['public/login', 'ref' => $url]));
				exit;
			}
		}
		return true;
	}
	/**
	 * 错误提示
	 * @author lijunwei
	 * @return type
	 */
	public function actionError()
	{
		$exception = \Yii::$app->errorHandler->exception;
		if ($exception !== null)
		{
			$this->_data['message'] = $exception;
			return $this->render($this->action->id, $this->_data);
			//return $this->render('error', ['message' => $exception]);
		}
	}
	/**
	 * @return string
	 * 个人中心首页
	 */
	public function actionDataset()
	{
		$uid = $this->uid;
		$UserData = $this->_user_model->findOne(['id' => $uid]);
		$collect = $this->_fav->find()->where(['uid'=>$this->uid])->count();
		$sysmess = $this->_sys->find()->where(['uid'=>$this->uid,'read'=>0])->count();
		$UserData->collect = $collect;
		$this->_data['user'] = $UserData;
		$this->_data['sysmess'] = $sysmess;
		return $this->view();
	}
	/**
	 * @return string
	 * 个人中心首页
	 */
	public function actionInfo()
	{
		$uid = $this->uid;
		$UserData = $this->_user_model->findOne(['id' => $uid]);
		$post = Yii::$app->request->post();
		if (!empty($post)) {
			$udata = $post['User'];
			$UserData->name = $udata['name'];
			$UserData->birday = isset($udata['birday'])?$udata['birday']:'';
			$UserData->sex = $udata['sex'];
			$UserData->address = $udata['address'];
			$UserData->email = $udata['email'];
			$UserData->phone = $udata['phone'];
			$UserData->intro = $udata['intro'];
			$UserData->setScenario('dataset');
			$UserData->save();
			if (empty($UserData->errors)) {
				$this->success(\Yii::t('app', '修改成功！'));
			} else {
				$this->error(AdCommon::modelMessage($UserData->errors));
			}
		}
		$this->_data['user'] = $UserData;
		return $this->view();
	}
	/**
	 * 修改登录密码
	 * @author gqa
	 * @return type
	 */
	public function actionUpdate_pwd()
	{
		if ($this->isPost) {
			$uid = $this->uid;
			$findUser = \lib\models\User::findOne(['id' => $uid]);
			if (empty($findUser)) {
				$this->error('用户不存在');
			}

			if ($findUser->pawd && $findUser->pawd != \lib\components\AdCommon::encryption($findUser->codes . $_POST['oldpawd'])) {
				$this->error('抱歉，旧密码错误',null, false,['oldpawd'=>'抱歉，旧密码错误']);
			}
			if(empty($_POST['password1']))	$this->error('抱歉，新密码不能为空',null, false,['password1'=>'抱歉，新密码不能为空']);
			if(empty($_POST['password2']))	$this->error('抱歉，确认密码不能为空',null, false,['password1'=>'抱歉，确认密码不能为空']);
			if($_POST['password1'] !=$_POST['password2'])	$this->error('抱歉，密码不一致',null, false,['password1'=>'抱歉，密码不一致']);
			$codes = \lib\components\AdCommon::uniqueGuid();
			$pawd = \lib\components\AdCommon::encryption($codes . $_POST['password1']);
			$findUser->codes = $codes;
			$findUser->pawd = $pawd;
			$findUser->save();
			if (empty($findUser->errors)) {
				$this->success('恭喜，操作成功');
			} else {
				$this->error(\lib\components\AdCommon::modelMessage($findUser->errors));
			}
		}
		return $this->view();
	}
	/**
	 * 上传头像
	 * @return Ambigous <\lib\hooks\type, multitype:number >|multitype:number
	 */
	public function actionHeadimg()
	{
		header("Access-Control-Allow-Origin:*");
		if (isset($_FILES["image"]) && $_FILES["image"]) {
			$picstatus = Yii::$app->upload->uploadFile($_FILES['image'],'_image_path');
		}
		$user = \lib\models\User::findOne( ['id' => $this->uid]);
		$user ->head = $picstatus['image'];
		$user->save();
		return Json::encode(['status'=>1,'url'=>$user ->head]);

	}
	/**
	 * 我的文章列表
	 * @return Ambigous <string, string>
	 */
	public function actionArticle()
	{
		$query = $this->query($this->_article, 'category', ['uid' => $this->uid],'id desc',$this->pagesize);
		$this->_data['count'] = $query['count'];
		$this->_data['pageSize'] = $query['pageSize'];
		$this->_data['page'] = $query['page'];
		$this->_data['data'] = $query['data'];
		return $this->view();
	}
	/**
	 * 我的收藏列表
	 * @return Ambigous <string, string>
	 */
	public function actionFav()
	{
		$type = intval($this->get('type'));

		return $this->_favlist($type);

	}
	/**
	 * 添加收藏
	 * @return Ambigous <string, string>
	 */
	public function actionAddfav()
	{
			$fav_type = intval($_GET['fav_type']);
			if($fav_type=='1'){
				$source = $this->_addfav_article($_GET);;
			}else{
				$source = $this->_addfav_user($_GET);;
			}
			return Json::encode($source);
	}
	/**
	 * 删除收藏
	 */
	public function actionDelfav()
	{
		if ($this->isPost) {
			$delete = $this->_fav->deleteAll(array('id' => intval($_POST['fav_id']), 'uid' =>intval($this->uid),'type'=>intval($_POST['fav_type'])));
			if ($delete) {
				return Json::encode(array('status' => 1, 'msg' => '操作成功'));
			} else {
				return Json::encode(array('status' => 0, 'msg' => "操作失败"));
			}
		}
		$this->error("错误请求");
	}

	/**
	 * @return string
	 * 我的消息列表
	 */
	public function actionMessage(){
		$mess_model =  new Sysmess();
		$delete = $mess_model->updateAll(['read'=>1],['uid'=>$this->uid]);
		$query = $this->query($mess_model, 'user', ['uid' => $this->uid],'id desc',$this->pagesize);
		$this->_data['count'] = $query['count'];
		$this->_data['pageSize'] = $query['pageSize'];
		$this->_data['page'] = $query['page'];
		$this->_data['data'] = $query['data'];
		return $this->view();
	}
	private function _favlist($type){
		$where['uid'] = $this->uid;
		if(!in_array($type,array_keys(Yii::$app->params['favtype'])))  $type=1;
		$where['type'] = $type;
		$query = $this->_fav->find()->where($where)->orderBy('id desc')->all();
		switch ($type){
			case 1: //文章

				//$this->query($this->_fav, '', $where,'id desc',100);
				$view = 'fav/fav_article';
				break;
			case 2://作者
//				$query = $this->query($this->_fav, '', $where,'id desc',100);
				$view = 'fav/fav_user';
				break;
		}
//		var_dump( $where);die();
		$this->_data['data'] = $query;
		return $this->view($view);
	}

	/**
	 * @param $data
	 * 收藏文章
	 */
	private function _addfav_article($data){
		$article = new Article();
		$info = $article->findOne(intval($data['fav_id']));
		if(empty($info)){
			return (array('status' => 0, 'msg' => '数据已不存在'));
		}
		if($info->uid==$this->uid){
			return (array('status' => 0, 'msg' => '不可收藏自己文章'));
		}
		$collectinfo = $this->_fav->findOne(['uid' => $this->uid, 'cid' => $data['fav_id'],'type'=>1]);

		if (!empty($collectinfo))
			return (array('status' => 0, 'msg' => '已在收藏夹'));
		$this->_fav->uid =$this->uid;
		$this->_fav->title =$info->title;
		$this->_fav->cid =$data['fav_id'];
		$this->_fav->type = 1;
		$this->_fav->addtime = time();
		$this->_fav->save();
		if ($this->_fav->errors) {
			return(array('status' => 0, 'msg' => \lib\components\AdCommon::modelMessage($this->_fav->errors)));
		}
		$info->collect += 1;
		$info->save();

		return (array('status' => 1, 'msg' => '恭喜，收藏成功','num'=>$info->collect));
	}
	/**
	 * @param $data
	 * 收藏作者
	 */
	private function _addfav_user($data){
		$user = new User();
		$info = $user->findOne(intval($data['fav_id']));
		if(empty($info)){
			return (array('status' => 0, 'msg' => '数据已不存在'));
		}
		if($info->id==$this->uid){
			return (array('status' => 0, 'msg' => '不可收藏自己'));
		}
		$collectinfo = $this->_fav->findOne(['uid' => $this->uid, 'cid' => $data['fav_id'],'type'=>2]);
		if (!empty($collectinfo))
			return (array('status' => 0, 'msg' => '已在收藏夹'));
		$this->_fav->uid =$this->uid;
		$this->_fav->title =$info->name?$info->name:'匿名';
		$this->_fav->cid =$data['fav_id'];
		$this->_fav->type = 1;
		$this->_fav->addtime = time();
		$this->_fav->save();
		if ($this->_fav->errors) {
			return(array('status' => 0, 'msg' => \lib\components\AdCommon::modelMessage($this->_fav->errors)));
		}
		$info->collect += 1;
		$info->save();

		return (array('status' => 1, 'msg' => '恭喜，收藏成功','num'=>$info->collect));
	}
}