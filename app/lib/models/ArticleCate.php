<?php

namespace lib\models;

use Yii;

/**
 * This is the model class for table "{{%goods_cate}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $image
 * @property integer $pid
 * @property integer $order
 */
class ArticleCate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%article_cate}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['pid', 'order','grade','hot'], 'integer'],
            [['name'], 'string', 'max' => 30],
            [['image','image_l'], 'string', 'max' => 128]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', '名称'),
            'image' => Yii::t('app', '分类图标'),
            'image_l' => Yii::t('app', '分类大图标'),
            'pid' => Yii::t('app', '分类父id'),
            'grade' => Yii::t('app', '等级'),
            'order' => Yii::t('app', '排序id'),
        ];
    }

    /**
    * @desc    查询栏目树
    * @access  public
    * @param   int $categoryid 栏目ID
    * @return  void
    */
    public function getCategory($categoryId = 0)
    {
        $where = array();
        if (!empty($categoryId)) $where['pid'] = $categoryId;

        $data = $this->find()->where($where)->orderBy('id ASC')->all();
       if(empty($data)) return $data;
        $category = $this->getTreeArr(0, $data);
        
        return $category;
    }
    
    /**
    * @desc    循环查询栏目树
    * @access  public
    * @param   int $categoryId 栏目ID
    * @return  void
    */
    public function getTree($categoryId = 0)
    {
        $category = $this->getCategory($categoryId);
        
        $ps = $category;
        
        foreach ($category as $k => $v)
        {
            $ps = $this->getParent($ps, $v['pid'], $v['id']);
        }
        
        foreach ($ps as $k => $v)
        {
            if ($v['pid'] > 0)
            {
                unset($ps[$k]);
            }
        }
        
        return $ps;
    }
    
    /**
    * @desc    查询父栏目
    * @access  public
    * @param   array $category 栏目
    * @param   int $pid  父栏目ID
    * @param   int $cid  栏目ID
    * @return  array
    */
    public function getParent($category, $pid, $cid)
    {       
        if($pid > 0)
        {
            $category[$pid]['son'][$cid] = $category[$cid];
        }   
        
        if ($pid > 0 && $category[$pid]['pid'] > 0)
        {
            $category = $this->getParent($category, $category[$pid]['pid'], $category[$pid]['id']);
        }

        return $category;
    }
    
    /**
    * @desc    查询频道ID
    * @access  public
    * @param   int $categoryid 栏目ID
    * @return  int
    */
    public function getChannelid($categoryid)
    {
        $category = $this->findOne($categoryid);
        
        if ($category['pid'] > 0 )
        {
            $category = $this->getChannelid($category['parent_id']);
        }
        
        return $category;
    }
    
    /**
    * @desc    所有栏目分类
    * @access  public
    * @param   int $parentid default 0 父栏目ID
    * @param   array $array  所有栏目
    * @param   int $level    栏目等级
    * @param   string $repeat 替换符
    * @return  array
    */
    public function getTreeArr($parentid = 0, $array = array(), $level = 0, $repeat = '&nbsp;&nbsp;') 
    {
    
        $str_repeat = '';
        
        if ($level) 
        {
            for($i = 0; $i < $level; $i ++) 
            {
                $str_repeat .= $repeat;
            }
        }
        
        $newarray  = array();
        $temparray = array();
        $arr = '';
        foreach ( ( array ) $array as $value ) 
        {
            $arr[$value['id']] = $value->attributes;    
        }

        foreach ( ( array ) $arr as $v ) 
        {
            if (!empty($v) && $v['pid'] == $parentid) 
            {
                $v['level'] = $level;
                $v['str_repeat'] = $str_repeat;
                $newarray[$v['id']] = $v;
                
                $temparray = self::getTreeArr( $v ['id'], $array, ($level + 2) );
                if ($temparray) 
                {
                    $newarray = array_merge ( $newarray, $temparray );
                }
            }
        }
        
        return $newarray;
    }

    /**
     * @param int $categoryId
     * @return array|\yii\db\ActiveRecord[]
     * 查询所以栏目以及字栏目
     */
    public function getAllCategory($categoryId = 0)
    {
        $where = array();
        if (!empty($categoryId)) $where['pid'] = $categoryId;

        $data = $this->find()->where($where)->orderBy('id ASC')->asArray()->all();
        foreach ( ( array ) $data as $value )
        {
            if (!empty($value) && $value['pid'] == 0)
            {
                $return_d[$value['id']] = $value;
            }
        }
        foreach ( ( array ) $data as $key =>&$v )
        {
            if (!empty($v) && $v['pid']!=0)
            {
                $return_d[$v['pid']]['child'][] = $v;
            }
        }

        return $return_d;
    }
}
