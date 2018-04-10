<?php
namespace app\controllers;
use app\controllers\SellerController;
use app\components\AdCommon;
use lib\models\ArticleCate;

/**
 * 
 * @Copyright (C), 2014-12-16, gqa.
 * @Name CategoryController.php
 * @Author gqa ()
 * @Version  Beta 1.0
 * @Date: 
 * @Description  栏目类
 * @Class List
 *  	
 *  @Function List
 *  
 *  @History
 *      <author>    <time>                       <version >     <desc>
 *       gqa                                           Beta 1.0
 *
 */
class ArticlecateController extends SellerController
{
	/**
	* @desc   是否实例化MODEL
	* @var    bool
	* @access private
	*/
	private $_isInit = false;
	
	/**
	* @desc   栏目表
	* @var    Category
	* @access public
	*/
	private $_category;
	
	/**
	* @desc   析构方法
	* @access  public
	* @param   void
	* @return  void
	*/
	public function init()
	{
		parent::init();
		
		$this->_initModel();
	}
	
	/**
	* @desc    栏目列表
	* @access  public
	* @param   void
	* @return  void
	*/
	public function actionIndex()
	{	
		$category = $this->_category->getCategory();
		
		$this->data['data'] = $category;
		return $this->view();
	}
	
	/**
	* @desc    添加栏目
	* @access  public
	* @param   int $pid 父栏目ID
	* @return  void
	*/
	public function actionAdd()
	{
		if ($this->isPost())
		{
			$post = $this->post('ArticleCate');
			if($post['pid']>0){
				$ArticleCate = $this->_category->find()->where(array('id'=>$post['pid']))->one();
				$post['grade'] = $ArticleCate->grade +1;
				if($ArticleCate->grade>2){
					$this->error('最多添加三级');
				}
			}else{
				$post['grade'] = 1;
			}
			$this->_category->attributes = $post;
			$this->_category->save();
			
			if (empty($this->_category->errors))
			{
				$this->success(\yii::t('app', 'success'), \yii::$app->params['url']['category']);
			}
			else 
			{
				$this->error(AdCommon::modelMessage($this->_category->errors));
			}
		}
		
		$this->data['parent'] = $this->_category->getCategory();
		$this->data['model'] =  $this->_category;

		return $this->view();
	}
	
	/**
	* @desc   修改栏目
	* @access  public
	* @param   int $id 栏目ID
	* @return  void
	*/
	public function actionUpdate()
	{
		$id = $this->get('id');
		if(empty($id)) $this->error(\yii::t('app', 'error'));
		$category = $this->_category->findOne($id);
		
		if ($this->isPost())
		{
			$post = $this->post('ArticleCate');  
			$category->attributes = $post;
			$category->save();
			if (empty($category->errors))
			{
				$this->success(\yii::t('app', 'success'), \yii::$app->params['url']['category']);
			}
			else 
			{
				$this->error(AdCommon::modelMessage($category->errors));
			}
		}
		
		$this->data['parent'] = $this->_category->getCategory();
		$this->data['model'] = $category;

		return $this->view();
	}
	
	/**
	* @desc    删除栏目 (栏目下有子栏目或者文章时不允许删除)
	* @access  public
	* @param   int $id 栏目ID
	* @return  void
	*/
	public function actionDelete()
	{
		$id = $this->post('data');
		if(empty($id)) $this->error(\yii::t('app', 'error'));
		$count = $this->_category->find()->where(array('pid' => $id))->count();
		if ($count > 0) 
		{
			$this->error(\yii::t('app', 'hasSon'));
		}
		
		$acount = \lib\models\Article::find()->where(array('cate_id' => $id))->count();
		if ($acount > 0) 
		{
			$this->error(\yii::t('app', 'hasArticle'));
		}
		
		$result = $this->_category->findOne($id)->delete();
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
	* @desc    实例化MODEL
	* @access  private
	* @param   void
	* @return  void
	*/
	private function _initModel()
	{
		if (!$this->_isInit)
		{
			$this->_category = new ArticleCate();
			
			$this->_isInit   = true;
		}
	}
}