<?php
namespace app\controllers;

use lib\components\AdCommon;
use lib\models\Ads;
use lib\models\Setting;

class SystemController extends SellerController
{
	/**
	* @desc    
	* @access  
	* @param   
	* @return  
	*/
	public function init()
	{
		parent::init();
	}
	
	/**
	* @desc     系统设置
	* @access  
	* @param     void
	* @return    void
	*/
	public function actionIndex()
	{
		$data = Setting::find()->where(['type'=>1])->orderBy('id ASC')->all();

		$this->data['data'] = $data;
		
		return $this->view();
	}
	/**
	 * @desc     设置
	 * @access
	 * @param     void
	 * @return    void
	 */
	public function actionPayset()
	{
		$data = Setting::find()->where(['type'=>2])->orderBy('id ASC')->all();
	
		$this->data['data'] = $data;
	
		return $this->view();
	}
	/**
	 * @desc     系统设置
	 * @access
	 * @param     void
	 * @return    void
	 */
	public function actionXieyi()
	{
		$data = Setting::findOne(['type'=>5,'key'=>'shouce']);
	
		$this->data['info'] = $data;
	
		return $this->view();
	}
	/**
	* @desc     修改公共配置
	* @access   
	* @param     void
	* @return    void
	*/
	public function actionUpdate()
	{
		if ($this->isPost())
		{
			$post = $this->post('system');
			if (is_array($post))
			{
				foreach ($post as $k => $v)
				{
					$result = Setting::updateAll(['value' => $v], ['key' => $k]);
				}
			}
			\Yii::$app->runAction('/cache/setting');
			$this->success(\yii::t('app', 'success'));	
		}
		else{
			$this->error(\yii::t('app', 'error'));
		}
	}

	/**
	* @desc    广告列表
	* @access  public
	* @param   void
	* @return  void
	*/
	public function actionAds()
	{
		$ads = new Ads();
		 $query = $this->query($ads);
		 $this->data['count'] = $query['count'];
		 $this->data['data']  = $query['data'];
		 $this->data['page']  = $query['page'];
		 $this->data['adstype']  =  \yii::$app->params['adsType'];
		 return $this->view();
	}
	
	/**
	* @desc    添加广告
	* @access  public
	* @param   void
	* @return  void
	*/
	public function actionAddads()
	{
		$ads = new Ads();
		if ($this->isPost())
		{
			$post = $this->post('Ads');
			$post['addtime'] = time();
			
			$ads->attributes = $post;
			$ads->save();
			
			if (empty($ads->errors))
			{
				$this->success(\yii::t('app', 'success'), \yii::$app->params['url']['ads']);
			}
			else
			{
				$this->error(AdCommon::modelMessage($ads->errors));
			}
		}
		$this->data['adstype']  =  \yii::$app->params['adsType'];
		$this->data['model'] = $ads;
		return $this->view();
	}
	
	/**
	* @desc   修改广告
	* @access  public
	* @param   int $id 
	* @return  void
	*/
	public function actionUpads()
	{
		$id = $this->get('id');
		$ad = Ads::findOne($id);
		if ($this->isPost())
		{
			$post = $this->post('Ads');
			$ad->attributes = $post;
			$ad->save();
			
			if (empty($ad->errors))
			{
				$this->success(\yii::t('app', 'success'), \yii::$app->params['url']['ads']);
			}
			else
			{
				$this->error(AdCommon::modelMessage($ad->errors));
			}
		}
		$this->data['adstype']  =  \yii::$app->params['adsType'];
		$this->data['model'] = $ad;
		return $this->view();
	}
	
	/**
	* @desc    删除广告
	* @access  public
	* @param   int $id
	* @return  void
	*/
	public function actionDelads()
	{
		$id = $this->post('data');
		if (empty($id)) $this->error(\yii::t('app', 'error'));
		$result = Ads::findOne($id)->delete();
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
	 * [actionFeedback反馈意见列表]
	 * @return [type] [description]
	 */
	public function actionFeedback()
	{
		$Feedback = new Feedback();
	
		$where  = '1=1';
		$query = $this->query($Feedback, '', $where);
		$this->data['count'] = $query['count'];
		$this->data['page']  = $query['page'];
		$this->data['data']  = $query['data'];
	
		 
		return $this->view();
	}
}