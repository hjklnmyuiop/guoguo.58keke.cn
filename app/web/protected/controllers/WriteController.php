<?php
namespace app\controllers;
use app\controllers\SellerController;
use lib\components\AdCommon;
use lib\models\Ads;
use lib\models\ArticleCate;
use lib\models\Article;
use lib\models\User;

/**
 * 
 * @Copyright (C), 2014-12-18, gqa.
 * @Name ArticleController.php
 * @Author gqa
 * @Version  Beta 1.0
 * @Date: 
 * @Description   文章类
 * @Class List
 *  	
 *  @Function List
 *  
 *  @History
 *      <author>    <time>                       <version >     <desc>
 *       gqa                                           Beta 1.0
 *
 */
class WriteController extends \app\components\WebController
{ 

	
	/**
	* @desc    文章模型
	* @var     Article
	* @access  private
	*/
	private $_article;
	
	/**
	* @desc    文章栏目模型
	* @var     Category
	* @access  private
	*/
	private $_category;
	private $_user;

	private $pagesize = 5;
	
	/**
	* @desc 
	* @access  
	* @param  
	* @return
	 * 实例化Model
	*/
	public function init()
	{
		parent::init();

		$this->_article  = new Article();
		$this->_category = new ArticleCate();
		$this->_user = new User();
		$this->_data['navcss'] = 'write';
	}

	/**
	* @desc    文章列表
	* @access  public	
	* @param   int $cid 栏目ID
	* @return  void
	*/
	public function actionIndex()
	{
		$search = $this->get('search');
		$where  = 'status=2 and arti_num>0';
		if (!empty($search['keyword']))
		{
			$where .= " and name  like '%" . $search['keyword'] . "%'";
		}
		$order = 'id desc';
		if(isset($search['sort']) && !empty($search['sort']) &&$search['sort']=='hot' ) {
			$order = 'arti_num desc ';
		}else{
			$search['sort'] = '';
		}
		$query = $this->query($this->_user,'' , $where,$order,$this->pagesize);
		$this->_data['count'] = $query['count'];
		$this->_data['pageSize'] = $query['pageSize'];
		$this->_data['page'] = $query['page'];
		$this->_data['data'] = $query['data'];
		//推荐文章
//		$this->_data['tuijian'] = $banner = $this->_article->find()->where(['status'=>1,'commend'=>1])->orderBy('id desc')->all();

		$this->_data['navcss'] = 'write';
		$this->_data['search'] = $search;
		return $this->view();
	}
	/**
	 * 资讯详情页
	 */
	public function actionDetail()
	{

		$id = (int)\Yii::$app->request->get('id', '');
		if (empty($id)) {
			$this->error('参数错误');
		}
		$newsData = $this->_user->findOne(['id' => $id,'status'=>2]);
		if(empty($newsData)) { $this->error('数据已删除','/write/index'); }
		//文章列表
		$query = $this->query($this->_article, 'category', ['status'=>1,'uid'=>$id],'id desc',$this->pagesize);
		$this->_data['count'] = $query['count'];
		$this->_data['pageSize'] = $query['pageSize'];
		$this->_data['page'] = $query['page'];
		$this->_data['data'] = $query['data'];
		//hot作者
		$hot_user = $this->_user->find()->limit(3)->orderBy('arti_num desc')->all();
		$this->_data['detail'] = $newsData;
		$this->_data['hot_new'] = $hot_user;
		$this->_data['navcss'] = 'news';
		return $this->render($this->action->id, $this->_data);
	}

}