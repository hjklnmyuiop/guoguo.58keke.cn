<?php

namespace lib\models;

use Yii;

/**
 * This is the model class for table "hd_user_share".
 *
 * @property integer $id
 * @property integer $uid
 * @property integer $addtime
 */
class UserShare extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_share}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid'], 'required'],
            [['uid', 'addtime'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => 'uid',
            'addtime' => '分享时间',
        ];
    }
}
