<?php
namespace app\controllers;
use lib\models\Ads;
use lib\models\Article;
use lib\models\ArticleCate;

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
class NewsController extends \app\components\WebController
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

	private $pagesize = 10;

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
		$this->_data['navcss'] = 'news';
	}
	/**
	 * @desc    文章分类
	 * @access  public
	 * @param   int $cid 栏目ID
	 * @return  void
	 */
	public function actionCategory()
	{
		$catogory = $this->_category->getAllCategory();
		$this->_data['catogory'] = $catogory;
		$this->_data['class'] = $catogory;
		return $this->view();
	}
	/**
	* @desc    文章列表
	* @access  public	
	* @param   int $cid 栏目ID
	* @return  void
	*/
	public function actionList()
	{
		$search = $this->get('search');
		$id = $this->get('id');
		$where  = 'status=1';
		if (!empty($id))
		{
			$where .= " and cate_id  = " . $id ;
		}
		if (!empty($search['keyword']))
		{
			$where .= " and title  like '%" . $search['keyword'] . "%'";
		}else{
			$search['keyword']='';
		}
		$order = 'id desc';
		if(isset($search['sort']) && !empty($search['sort']) &&$search['sort']=='hot' ) {
			$order = 'clicknum desc ';
		}else{
			$search['sort'] = '';
		}
		$query = $this->query($this->_article, 'category', $where,$order,$this->pagesize);
		$this->_data['count'] = $query['count'];
		$this->_data['pageSize'] = $query['pageSize'];
		$this->_data['page'] = $query['page'];
		$this->_data['data'] = $query['data'];
		$this->_data['l_page'] = ceil($query['count']/$query['pageSize']);
		$this->_data['search'] = $search;
		$this->_data['id'] = $id;
		return $this->view();
	}
	/**
	 * @desc    文章列表
	 * @access  public
	 * @param   int $cid 栏目ID
	 * @return  void
	 */
	public function actionAjax_newslist()
	{
		$this->layout='ajax';
		$search = $this->get('search');
		$id = $this->get('id');
		$where  = 'status=1';
		if (!empty($id))
		{
			$where .= " and cate_id  = " . $id ;
		}
		if (!empty($search['keyword']))
		{
			$where .= " and title  like '%" . $search['keyword'] . "%'";
		}
		$order = 'id desc';
		$query = $this->query($this->_article, 'category', $where,$order,$this->pagesize);
		$this->_data['count'] = $query['count'];
		$this->_data['pageSize'] = $query['pageSize'];
		$this->_data['page'] = $query['page'];
		$this->_data['data'] = $query['data'];
		$html =  $this->view();
		echo json_encode(['status'=>1,'html'=>$html]);exit();
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
		$newsData = $this->_article->findOne(['id' => $id,'status'=>1]);
		if(empty($newsData)) { $this->error('文章已删除','/news/index'); }
		$newsData->is_collet = $this->is_collec($newsData->id,'article');
		if (isset($_SERVER['HTTP_REFERER'])) {
			//更新资讯点击数
			$data['clicknum'] = $newsData['clicknum'] + 1;
			$newsData->attributes = $data;
			$newsData->save();
		}
		//最新列表
		$laset_new = $this->_article->find()->limit(3)->orderBy('create_time desc')->all();

		$this->_data['detail'] = $newsData;
		$this->_data['laset_new'] = $laset_new;
		$this->_data['navcss'] = 'news';
		return $this->render($this->action->id, $this->_data);
	}

}