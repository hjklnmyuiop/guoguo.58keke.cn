<?php

namespace lib\models;

use Yii;

/**
* This is the model class for table "hd_article".
 *
 * @property string $id
* @property integer $uid
* @property string $title
* @property string $description
* @property integer $cate_id
* @property string $thumb
* @property string $content
* @property string $tags
* @property string $source
* @property string $clicknum
* @property integer $commend
* @property string $sort_desc
* @property integer $status
* @property integer $collect
* @property string $create_time
*/
class Article extends \yii\db\ActiveRecord
{
    public $is_collet;
    public $user_head;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%article}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'title', 'description', 'content'], 'required'],
            [['uid', 'cate_id', 'clicknum', 'commend', 'sort_desc', 'status', 'collect', 'create_time'], 'integer'],
            [['content', 'source'], 'string'],
            [['title', 'description', 'thumb', 'tags'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => '文章发布者',
            'title' => '标题',
            'description' => '描述',
            'cate_id' => '分类',
            'thumb' => '图片',
            'content' => '内容',
            'tags' => 'tags',
            'source' => 'Source',
            'clicknum' => '查看次数',
            'commend' => '0不推荐 1 推荐',
            'sort_desc' => '排序',
            'status' => '0不显示 1显示',
            'collect' => '收藏数',
            'create_time' => '添加时间',
        ];
    }

    /**
     * [getCategory join db_articleCate]
     * @return [type] [description]
     */
    public function getCategory()
    {
        return $this->hasOne(ArticleCate::className(), ['id' => 'cate_id']);
    }
    /**
     * [getUser join db_user]
     * @return [type] [description]
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'uid']);
    }
}
