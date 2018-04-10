<?php
/**
 * Created by zendstudio.
 * User: Dev
 * Date: 2016/01/25 1612
 * Time: 上午 9:55
 */

namespace app\components;

use lib\models\ArticleCollect;
use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use yii\data\Pagination;

class WebController extends Controller
{
    /**
     * 提交查询验证
     * @var boolean
     */
    public $enableCsrfValidation = false;
    public $isPost = false;
    public $_data;
	public $_setting = array();
	public $apiData = false;
	public $userData = [];
	public $uid = 0;
	public $discount = 1;
	public $proxy_code = '';
	public $_gen_path = '';
	public $gen_path = '';
	public $member_info;
	public function init()
    {
        parent::init();
		$redirect = \Yii::$app->request->get('redirect', null);
		$this->_data['redirect'] = $redirect === null ? Yii::$app->request->getReferrer() : urldecode($redirect);
		if (Yii::$app->request->isPost) {
			$this->isPost = true;
		}
		$this->userData = \Yii::$app->session->get('LOGIN');
		$this->_data['uid'] = $this->uid = !empty($this->userData) ? $this->userData['id'] : 0;
		\Yii::$app->params['setting'] =$this->_data['settingData'] = require_once LIB . '/config/setting.php';
		\Yii::$app->params['article_cate'] =$this->_data['article_cate'] = require_once LIB . '/config/article_cate.php';
		$this->_data['member_info'] = $this->member_info = $this->useracountinfo();
    }

   

    /**
     * [page 分页]
     * @param  [int] $count [总条数]
     * @return [type]        [description]
     */
    public function page($count,$pageSize)
    {
    	return $pagination = new Pagination([
    			'pageSize'   => $pageSize,
    			'totalCount' => $count,
    			]);
    }

    /**
     * [query 查询所有记录]
     * @param  [type] $model [Model]
     * @param  string $with  [联表]
     * @param  array $where [条件]
     * @param  string $order [排序]
     * @return [type]        [description]
     */
    public function query($model, $with = '', $where = [], $order = 'id desc',$pageSize=10)
    {
    	$query = $model->find();
    	if ($with != '') $query = $query->innerJoinWith($with);
    	if ($where != '') $query  =  $query->where($where);

    	$count = $query->count();
    	$page  = $this->page($count,$pageSize);
    	$query  = $query->orderBy($order)->offset($page->offset)->limit($page->limit)->all();

    	return ['count' => $count, 'page' => $page, 'data' => $query,'pageSize'=>$pageSize];
    }
    /**
     * [view 渲染视图]
     * @param  string $view [视图名称]
     * @return [type]       [nul]
     */
    public function view($view = '')
    {
    	if ($view == '')
    	{
    		$view = $this->action->id;
    	}
    	return $this->render($view, $this->_data);
    }
	protected function getThisUrl($action)
	{
		if (!empty($this->userData))
		{
			$_GET['c'] = $this->userData['proxy_code'];
		}
		return Yii::$app->request->getHostInfo().Url::toRoute(array_merge([$action], $_GET));
	}




	/**
	 * 获取客户端IP地址
	 * @return array
	 */
	public function clientIp() {
		header("Content-type: text/html; charset=gb2312");
		$ip138 = \Yii::$app->curl->post('http://1111.ip138.com/ic.asp', '');
		preg_match("#<center[^>]*>(.*?)<\/center>#", $ip138, $ipinfo);
		preg_match("/(?:\[)(.*)(?:\])/i", $ipinfo[1], $ip);
		$getaddress = empty($ipinfo[1]) ? '' : $ipinfo[1];
		$getip = empty($ip[1]) ? '' : $ip[1];
		return ['address' => iconv('GBK//IGNORE', 'UTF-8', $getaddress), 'ip' => $getip];
	}
	/**
	 * [get 获取GET参数]
	 * @param  string $key [参数名称]
	 * @return [string]      [参数值]
	 */
	public function get($key = '')
	{
		$get  = \Yii::$app->request->get($key);

		if (is_array($get))
		{
			foreach ($get as $k => $v)
			{
				$get[$k] = trim($v);
			}

			return $get;
		}
		else
		{
			return trim($get);
		}

	}
	/**
	 * [post post参数获取]
	 * @param  string $key [表单Name]
	 * @return [type]      [表单值]
	 */
	public function post($key = '')
	{
		$post = \Yii::$app->request->post($key);
		if (is_array($post))
		{
			foreach ($post as $k => $v)
			{
				$post[$k] = trim($v);
			}
			return $post;
		}
		else
		{
			return trim($post);
		}

	}

	/**
	 * [isPost 是否Post方式提交]
	 * @return boolean [返回值]
	 */
	public function isPost()
	{
		return Yii::$app->request->getIsPost();
	}

	/**
	 * [isGet 是否GET方式提交]
	 * @return boolean [description]
	 */
	public function isGet()
	{
		return Yii::$app->request->getIsAjax();
	}
	/**
	 * [isAjax 是否Ajax提交]
	 * @return boolean [返回值]
	 */
	public function isAjax()
	{
		return Yii::$app->request->getIsAjax();
	}

	/**
	 * [error 错误提示]
	 * @param  [type] $msg [提示语]
	 * @param  [type] $url [跳转URL]
	 * @param  [type] $close [是否关闭弹出层]
	 * @return [type]      [description]
	 */
	public function error($msg, $url = null, $close = false,$re_arr=[])
	{
		if($this->isAjax()){
			$array = array(
					'msg' => $msg,
					'status' => 'failure',
					'url' => $url,
					'close' => $close,
			);
			$array = array_merge($array,$re_arr);
			$this->ajaxReturn($array);
		}else{
			$this->alert($msg, $url);
		}
	}

	/**
	 * [success 成功提示]
	 * @param  [type] $msg [提示语]
	 * @param  [type] $url [跳转UrL]
	 * @param  [type] $close [是否关闭弹出层]
	 * @return [type]      [description]
	 */
	public function success($msg, $url = null, $close = false)
	{
		if($this->isAjax()){
			$array = array(
					'msg' => $msg,
					'status' => 'success',
					'url' => $url,
					'close' => $close,
			);
			$this->ajaxReturn($array);
		}else{
			$this->alert($msg, $url);
		}
	}

	/**
	 * AJAX返回
	 * @param string $message 提示内容
	 * @param bool $status 状态
	 * @param string $jumpUrl 跳转地址
	 * @return array
	 */
	public function ajaxReturn($data)
	{
		header('Content-type:text/json');
		echo json_encode($data);
		exit;
	}

	/**
	 * [alert description]
	 * @param  [type] $msg     [description]
	 * @param  [type] $url     [description]
	 * @param  string $charset [description]
	 * @return [type]          [description]
	 */
	public function alert($msg, $url = NULL, $charset='utf-8')
	{
		header("Content-type: text/html; charset={$charset}");
		$alert_msg="alert('$msg');";
		if( empty($url) ) {
			$go_url = 'history.go(-1);';
		}else{
			$go_url = "window.location.href = '{$url}'";
		}
		echo "<script>$alert_msg $go_url</script>";
		exit;
	}
	/**
	 * 个人信息
	 * @return
	 */
	private function useracountinfo()
	{
		$User = new \lib\models\User();
		if ($this->uid>0) {
			$userinfo = $User->getUserInfo(['id' => $this->uid], '*');
			$membinfo = $userinfo->toArray();
			$membinfo['unread_mes']  = \lib\models\Sysmess::find()->where(['read' => 0, 'UID' => $this->uid])->count();
		}else{
			$membinfo =[];
		}

		return $membinfo;
	}
	/**
	 * 判断是否收藏
	 * 1文章2作者
	 */
	public function is_collec($id, $type = '1')
	{
		if($this->uid ==0) return false;
		$result = false;
		$data = ArticleCollect::findOne(['uid'=>$this->uid,'cid'=>$id,'type'=>$type]);
		if($data){
			$result = true;
		}
		return $result?true:false;
	}
}
