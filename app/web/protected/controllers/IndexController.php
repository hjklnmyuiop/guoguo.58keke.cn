<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 2015/5/28
 * Time: 21:51
 */
namespace app\controllers;


use lib\models\Article;
use lib\models\ArticleCate;
use lib\models\User;
use Yii;

class IndexController extends \app\components\WebController
{
    public $_article;
    public $_article_category;
    public $_user;
	public function init()
	{
		parent::init();
        $this->_article = new Article();
        $this->_article_category = new ArticleCate();
        $this->_user = new User();
        $this->_data['navcss'] = 'index';
	}
	

    /**
     * 商城首页
     * @author lijunwei
     * @return type
     */
    public function actionIndex()
    {

        //广告
        $banner = \lib\models\Ads::find()->where(['type'=>1])->all();
        //推荐栏目
        $hot_catogory = $this->_article_category->find()->where(['hot'=>1])->all();
        //推荐文章
        $com_article = $this->_article->find()->where(['commend'=>1])->limit(8)->all();
        //热门作者
        $hot_user = $this->_user->find()->where(['status'=>2])->orderby('arti_num desc, login_num desc')->limit(15)->all();
        $this->_data['banner'] = $banner;
        $this->_data['hot_user'] = $hot_user;
        $this->_data['hot_catogory'] = $hot_catogory;
        $this->_data['com_article'] = $com_article;
        $this->_data['hot_user'] = $hot_user;
        return $this->view();
    }
}