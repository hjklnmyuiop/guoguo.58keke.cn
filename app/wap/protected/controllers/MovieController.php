<?php
namespace app\controllers;
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
class MovieController extends \app\components\WebController
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

	private $pagesize = 24;
	
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
		$this->_data['navcss'] = 'movie';
	}

	/**
	* @desc    电影列表
	* @access  public	
	* @param   int $cid 栏目ID
	* @return  void
	*/
	public function actionIndex()
	{
		//正在热映:in_theaters,即将上映:comingSoon,豆瓣Top250：top250
		$this->_data['coming_soon'] = json_decode(file_get_contents('https://api.douban.com/v2/movie/coming_soon?start=0&count=8'));
		$this->_data['top250'] = json_decode(file_get_contents('https://api.douban.com/v2/movie/top250?start=0&count=8'));
		$this->_data['in_theaters'] = json_decode(file_get_contents('https://api.douban.com/v2/movie/in_theaters?start=0&count=8'));
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
		//正在热映:in_theaters,即将上映:comingSoon,豆瓣Top250：top250
		$search = $this->get('search');
		$page = $this->get('page')?$this->get('page'):1;
		$start = ($page-1)*$this->pagesize;
		$search['type'] = isset($search['type']) ?isset($search['type']) :'in_theaters';
		if($search['type']=='comingSoon'){
			$data = json_decode(file_get_contents('https://api.douban.com/v2/movie/coming_soon?start='.$start.'&count='.$this->pagesize));
		}else if($search['type']=='top250'){
			$data = json_decode(file_get_contents('https://api.douban.com/v2/movie/top250?start='.$start.'&count='.$this->pagesize));
		}else{
			$data = json_decode(file_get_contents('https://api.douban.com/v2/movie/in_theaters?start='.$start.'&count='.$this->pagesize));
		}
		$this->_data['type'] = $search['type'];
		$this->_data['page'] = $this->get('page');
		$this->_data['data'] =$data->subjects;
		$this->_data['tuijian'] = [];
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
		$this->_data['detail'] = json_decode(file_get_contents("https://api.douban.com/v2/movie/subject/".$id));
		//最新列表
		//推荐文章
		$this->_data['tuijian'] = $banner = $this->_article->find()->where(['status'=>1,'commend'=>1])->limit(3)->orderBy('id desc')->all();
		return $this->render($this->action->id, $this->_data);
	}

}
