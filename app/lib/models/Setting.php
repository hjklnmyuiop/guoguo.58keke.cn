<?php

namespace lib\models;

use Yii;

/**
 * This is the model class for table "{{%setting}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $key
 * @property string $value
 */
class Setting extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%setting}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['key'], 'required'],
            [['value'], 'string'],
            [['type'], 'integer'],
            [['name'], 'string', 'max' => 100],
            [['key'], 'string', 'max' => 50],
            [['key'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '名称',
            'key' => '变量',
            'value' => '值',
            'type' => '1系统设置2支付设置3其他',
        ];
    }

    /**
    * @desc    查询所有系统参数
    * @access  public
    * @param   void
    * @return  array
    */
    public static function getSetting()
    {
        $settingArray = array();
        $setting      = self::find()->all();
        if (empty($setting))
        {
            return $settingArray;
        }
        
        foreach ($setting as $set)
        {
            $settingArray[$set['key']] = $set['value'];
        }
        
        return $settingArray;
    }
}
