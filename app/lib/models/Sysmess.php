<?php

namespace lib\models;

use Yii;

/**
 * This is the model class for table "hd_sysmess".
 *
 * @property integer $id
 * @property integer $uid
 * @property string $title
 * @property string $content
 * @property integer $addtime
 */
class Sysmess extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sysmess}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'addtime'], 'required'],
            [['uid', 'addtime'], 'integer'],
            [['title', 'content'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => '消息所属人',
            'title' => 'Title',
            'content' => 'Content',
            'addtime' => '添加时间',
        ];
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
