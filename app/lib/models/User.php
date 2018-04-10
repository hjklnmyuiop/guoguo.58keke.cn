<?php

namespace lib\models;

use Yii;

/**
 * This is the model class for table "hd_user".
 *
 * @property string $id
 * @property string $name
 * @property string $head
 * @property string $address
 * @property string $phone
 * @property string $email
 * @property integer $sex
 * @property string $intro
 * @property string $pawd
 * @property string $codes
 * @property integer $status
 * @property integer $register_time
 * @property string $register_ip
 * @property integer $lastlogin
 * @property integer $arti_num
 */
class User extends \yii\db\ActiveRecord
{
    public $file;
    public $newpawd;
    public $repawd;
    public $auth;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

  /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sex', 'status', 'register_time', 'lastlogin', 'arti_num', 'login_num','collect'], 'integer'],
            [['birday'], 'safe'],
            [['name', 'address', 'codes'], 'string', 'max' => 32],
            [['head', 'email', 'intro'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 11],
            [['pawd'], 'string', 'max' => 33],
            [['register_ip'], 'string', 'max' => 30],
            [['phone','intro','name','sex','birday','address'], 'required', 'on' => 'dataset'],
            [['email'], 'unique', 'message' => '邮箱已被注册', 'on' => 'register'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '自增id',
            'name' => '昵称',
            'head' => '头像',
            'address' => 'Address',
            'phone' => '电话',
            'email' => '邮件',
            'sex' => '性别1男2女',
            'birday' => 'Birday',
            'intro' => '介绍',
            'pawd' => '登录密码',
            'codes' => '加密密码的字符串',
            'status' => '状态 1待审核 2正常 3禁止登陆 3回收站',
            'register_time' => '注册时间',
            'register_ip' => '注册IP',
            'lastlogin' => '最后登录时间',
            'arti_num' => '发布文章数量',
            'login_num' => '登录次数',
            'collect' => '收藏数',
        ];
    }
    /**
     * 会员详细信息（查库）
     * @param array $condition
     * @param string $field
     * @return array
     */
    public function getUserInfo($condition, $field = '*') {
        return $this->find()->select($field)->where($condition)->one();
    }
}
