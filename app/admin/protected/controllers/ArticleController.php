<?php
namespace app\controllers;
use app\controllers\SellerController;
use lib\components\AdCommon;
use lib\models\ArticleCate;
use lib\models\Article;

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
class ArticleController extends SellerController
{ 
	
	/**
	* @desc   是否实例化Model
	* @var    bool
	* @access private
	*/
	private $_isInit = false;
	
	/**
	* @desc    文章模型
	* @var     Article
	* @access  private
	*/
	private $_article;
	
	/**
	* @desc    栏目模型
	* @var     Category
	* @access  private
	*/
	private $_category;
	
	/**
	* @desc 
	* @access  
	* @param  
	* @return 
	*/
	public function init()
	{
		parent::init();
		
		$this->_initModel();
		
	}

	/**
	* @desc    文章列表
	* @access  public	
	* @param   int $cid 栏目ID
	* @return  void
	*/
	public function actionIndex()
	{
		$id     = $this->get('id');
		$search = $this->get('search');
		$where  = '1=1';
		
		if (!empty($search['type']) && !empty($search['keyword']))
		{
			if (isset($search['type']) && $search['type'] == 'title')
			{
				$where .= " and " . $search['type'] . " like '%" . $search['keyword'] . "%'";
			}
			else
			{
				$where .= " and " . $search['type'] . "='" . $search['keyword'] . "'";
			}
		}

		if(!empty($search['cate_id'])) $where .= " and cate_id='" . $search['cate_id'] . "'";
		
		# 推荐
		if (isset($search['isrecom']) && $search['isrecom'] != '')
		{
			$where .= " and commend='" . $search['isrecom'] . "'";
		}

		# 状态
		if (isset($search['isshow']) && $search['isshow'] != '')
		{
			$where .= " and status='" . $search['isshow'] . "'";
		}
		
		if (!empty($search['stime']))
		{
			$stime = strtotime($search['stime']);
			$etime = empty($search['etime']) ? time() : strtotime($search['etime'] . ' 23:59:59');
			
			$where .= " and create_time between " . $stime . " and " . $etime;
		}
		$query = $this->query($this->_article, 'category', $where);
		
		$this->data['data'] = $query['data'];
		$this->data['page'] = $query['page'];
		$this->data['count'] = $query['count'];
		$this->data['category'] = $this->_category->getCategory();
		$this->data['searchvalue'] = $search;
		$this->data['search']   = array(
			'id'      => \yii::t('app', 'id'),
			'title'   => \yii::t('app', 'title'),
		);
		
		return $this->view();
	}
	
	/**
	* @desc    添加文章
	* @access  public
	* @param   void
	* @return  void
	*/
	public function actionAdd()
	{
		if ($this->isPost())
		{
			$post = $this->post('Article');
			$post['create_time'] = time();
			
			$this->_article->attributes = $post;
			$this->_article->save();

			if (empty($this->_article->errors))
			{
				$this->success(\yii::t('app', 'success'), \yii::$app->params['url']['article']);
			}
			else 
			{
				$this->error(AdCommon::modelMessage($this->_article->errors));
			}
		}
		
		$this->data['parent'] = $this->_category->getCategory();
		$this->data['model'] = $this->_article;
		
		return $this->view();
	}
	
	/**
	* @desc    修改文章
	* @access  public
	* @param   int $id 文章ID
	* @return  void
	*/
	public function actionUpdate()
	{
		$id = $this->get('id');
		if(empty($id)) $this->error(\yii::t('app', 'error'));
		$article = $this->_article->findOne($id);
		if ($this->isPost())
		{
			$post = $this->post('Article');
			$article->attributes = $post;
			$article->save();
			if (empty($article->errors))
			{
				$this->success(\yii::t('app', 'success'), \yii::$app->params['url']['article']);
			}
			else 
			{
				$this->error(AdCommon::modelMessage($article->errors));
			}
		}
		
		$this->data['parent'] = $this->_category->getCategory();
		$this->data['model'] = $article;
		
		return $this->view('add');
	}
	
	/**
	* @desc    删除文章
	* @access  public
	* @param   int $id 删除文章ID
	* @return  void
	*/
	public function actionDelete()
	{
		$id = $this->post('data');
		if(empty($id)) $this->error(\yii::t('app', 'error'));
		$result = $this->_article->findOne($id)->delete();
		if ($result) 
		{
			$this->success(\yii::t('app', 'success'));
		}
		else
		{
			$this->error(\yii::t('app', 'fail'));
		}
	}
	
	/**
	* @desc    推荐/取消推荐文章
	* @access  public
	* @param   int $id 文章ID
	* @return  json 
	*/
	public function actionCommon()
	{
		$id = $this->post('data');
		if(empty($id)) $this->error(\yii::t('app', 'error'));
		$article = $this->_article->findOne($id);
		if (isset($article['commend']) && $article['commend'] == 1)
		{
			$article->commend = 0;
			$article->save();
		}
		else if (isset($article['commend']) && $article['commend'] == 0)
		{
			$article->commend = 1;
			$article->save();
		}
		
		if(empty($article->errors))
		{
			$this->success(\yii::t('app', 'success'));
		}
		else
		{
			$this->error(\yii::t('app', 'fail'));
		}
	}
	/**
	 * [actionPut 文章上架]
	 * @return [type] [description]
	 */
	public function actionPut()
	{
		$id = $this->post('data');
		if(empty($id)) $this->error(\yii::t('app', 'error'));
		$article = $this->_article->findOne($id);
		$isput = $article['status'];
		if($isput == 1) $article->status = 0;
		if($isput == 0) $article->status = 1;
		$article->save();
		if(empty($article->errors))
		{
			$this->success(\yii::t('app', 'success'));
		}
		else
		{
			$this->error(AdCommon::modelMessage($article->errors));
		}
	}
	/**
	* @desc    批量推荐
	* @access  public
	* @param   string $id 文章ID
	* @param   string $type 推荐状态
	* @return  void
	*/
	public function actionComall()
	{
		$id   = $this->post('id');
		$type = $this->post('type');
		
		if ($type == 1)
		{
			$type = 'Y';
		}
		else
		{
			$type = 'N';
		}
		
		if ($id != '')
		{
			$uid = explode(',', $id);
			
			foreach ($uid as $k => $v)
			{
				if (!empty($v) && AdCommon::isNumber($v))
				{
					$this->_article->updateAll(array('commend' => $type), 'id=' . $v);
				}
			}	
		}

		$this->success(\yii::t('app', 'success'));
	}
	
	/**
	* @desc    实例化Model
	* @access  
	* @param  
	* @return 
	*/
	private function _initModel()
	{
		if (!$this->_isInit)
		{
			$this->_article  = new Article();
			$this->_category = new ArticleCate();
			
			$this->_isInit = true;
		}
	}
}