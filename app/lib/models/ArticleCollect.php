<?php

namespace lib\models;

use Yii;

/**
 * This is the model class for table "hd_article_collect".
 *
 * @property string $id
 * @property integer $uid
 * @property string $title
 * @property integer $cid
 * @property string $addtime
 * @property integer $type
 */
class ArticleCollect extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%favorite}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'cid'], 'required'],
            [['uid', 'cid', 'addtime', 'type'], 'integer'],
            [['title'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => '该条收藏记录的会员id，取值于user表的id ',
            'title' => '标题',
            'cid' => '收藏相对应数据ID',
            'addtime' => '收藏时间',
            'type' => '收藏类型1文章',
        ];
    }
    /**
     * [getUser join db_user]
     * @return [type] [description]
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'cid']);
    }
    /**
     * [getUser join db_user]
     * @return [type] [description]
     */
    public function getArticle()
    {
        return $this->hasOne(Article::className(), ['id' => 'cid']);
    }
}
