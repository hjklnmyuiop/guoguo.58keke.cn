<?php

namespace lib\models;

use Yii;

/**
 * This is the model class for table "{{%ads}}".
 *
 * @property integer $id
 * @property integer $type
 * @property string $name
 * @property string $image
 * @property string $url
 * @property integer $addtime
 */
class Ads extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%ads}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'addtime'], 'integer'],
            [['addtime'], 'required'],
            [['name'], 'string', 'max' => 100],
            [['image'], 'string', 'max' => 200],
            [['url'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'type' => Yii::t('app', '广告位 1=首页banner'),
            'name' => Yii::t('app', '名称'),
            'image' => Yii::t('app', '图片'),
            'url' => Yii::t('app', '链接地址'),
            'addtime' => Yii::t('app', '添加时间'),
        ];
    }
}
