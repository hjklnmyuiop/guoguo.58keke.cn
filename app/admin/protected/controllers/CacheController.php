<?php
namespace app\controllers;

use app\controllers\SellerController;
use lib\components\AdCommon;
use lib\models\Area;
use lib\models\Article;
use lib\models\ArticleCate;
use lib\models\GoodsCate;
use lib\models\MaterialCate;
use lib\models\MemberMsgTpl;
use lib\models\Setting;

class CacheController extends SellerController
{
    /**
     * [$_user User]
     * @var [type]
     */
    private $_user;
    /**
     * [init 初始化]
     * @return [type] [description]
     */
    public function init()
    {
        parent::init();
    }
    public  function actionSetcache(){
//        $this->arealist();
        $this->setting();
        $this->ArticleCategory();
    }
    /**
     * 系统设置
     */
    public function actionSetting(){
        $this->setting();
    }
    /**
     * 商品分类
     */
    public function actionArticlecategory(){
        $this->ArticleCategory();
    }


    /**
     * @return bool
     * 地区
     */
    public function arealist(){
        $filename = ROOT."../lib/config/area.php";
        $model_area= new Area();
        $area = $model_area->find()->asArray()->all();
        foreach($area as $key=>$val){
            $list[$val['area_id']]=$val;
        }
        $value = var_export($list, true);
        $value = "<?php return ".$value.";";
        file_put_contents($filename,$value);
        if (false == file_put_contents($filename,$value,null)){
            return false;
        }else{
            return true;
        }
    }

    /**
     * @return bool
     * 系统设置
     */
    public function setting(){
        $filename = ROOT."../lib/config/setting.php";
        $model_area= new Setting();
        $area = $model_area->find()->asArray()->all();
        foreach($area as $key=>$val){
            $list[$val['key']]=$val['value'];
        }
        $value = var_export($list, true);
        $value = "<?php return ".$value.";";
        file_put_contents($filename,$value);
        if (false == file_put_contents($filename,$value,null)){
            return false;
        }else{
            return true;
        }
    }

    /**
     * @desc    商品分类列表
     * @access  public
     * @param   int $categoryid 栏目ID
     * @return  void
     */
    public function ArticleCategory($categoryId = 0)
    {
        $where = array();
        if (!empty($categoryId)) $where['pid'] = $categoryId;
        $model_area= new ArticleCate();
        $data = $model_area->find()->where($where)->orderBy('pid asc ,order ASC')->asArray()->all();
        $arr2 =[];
        foreach ( ( array ) $data as $value )
        {
            if($value['pid']==0){
                $arr2[$value['id']] = $value;
            }else{
                $arr2[$value['pid']]['child'][]  = $value;
            }

        }

        $filename = ROOT."../lib/config/article_cate.php";
        $value = var_export($arr2, true);
        $value = "<?php return ".$value.";";
        file_put_contents($filename,$value);
        if (false == file_put_contents($filename,$value,null)){
            return false;
        }else{
            return true;
        }
    }

    public function getTreeCategory($parentid = 0, $arr = array())
    {
        $newarray=[];
        foreach ( ( array ) $arr as $v )
        {
            if (!empty($v) && $v['pid'] == $parentid)
            {
                $newarray[$v['id']] = $v;
                $newarray[$v['id']]['childlist'] = self::getTreeCategory( $v ['id'], $arr );
            }
        }

        return $newarray;
    }
}