<?php
namespace app\controllers;
use lib\models\Ads;
use lib\models\Article;
use lib\models\ArticleCate;
use lib\components\AdCommon;

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
		$this->_data['navcss'] = 'news';
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
			if(isset(\Yii::$app->params['article_cate'][$id])){
				$cate_arr =array_column(\Yii::$app->params['article_cate'][$id]['child'],'id');
				array_push($cate_arr,$id);
				$where .= " and cate_id  in (" . implode(',',$cate_arr).")" ;
			}else{
				$where .= " and cate_id  = " . $id ;
			}

		}
		if (!empty($search['keyword']))
		{
			$where .= " and title  like '%" . $search['keyword'] . "%'";

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
		//推荐文章
		$this->_data['tuijian'] = $banner = $this->_article->find()->where(['status'=>1,'commend'=>1])->limit(8)->orderBy('id desc')->all();
		$this->_data['search'] = $search;
		$this->_data['id'] = $id;
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
	/**
	 * @desc    添加文章
	 * @access  public
	 * @param   void
	 * @return  void
	 */
	public function actionAdd()
	{
		$post = $_POST;
//		var_dump(explode(' ',$post['create_time']));die();
		$post['create_time'] = (strtotime($post['create_time']));
		$post['description'] = mb_substr($post['description'],0,250);
		$post['create_time'] = $post['create_time']?$post['create_time']:time();
		$this->_article->attributes = $post;
		$this->_article->save();
		if (empty($this->_article->errors))
		{
			echo '';exit();
		}
		else
		{
			var_dump(AdCommon::modelMessage($this->_article->errors));die();
		}
		$this->data['parent'] = $this->_category->getCategory();
		$this->data['model'] = $this->_article;

		return $this->view();
	}
	/**
	 * @desc    添加文章
	 * @access  public
	 * @param   void
	 * @return  void
	 */
	public function actionAdd1()
	{
		$post = $_POST;

		$post['description'] = substr($post['description'],0,254);
		$post['create_time'] = $post['create_time']?$post['create_time']:time();

		$this->_article->attributes = $post;
		$this->_article->save();
		if (empty($this->_article->errors))
		{
			echo '';exit();
		}
		else
		{
			var_dump(AdCommon::modelMessage($this->_article->errors));die();
		}
		$this->data['parent'] = $this->_category->getCategory();
		$this->data['model'] = $this->_article;

		return $this->view();
	}

}