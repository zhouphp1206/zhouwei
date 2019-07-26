<?php

namespace common\models;

/**
 * This is the model class for table "user_token".
 *
 * @property string $id token 表主键id
 * @property int $user_id
 * @property string $token
 * @property int $login_time
 * @property int $fair_number 登录失败次数
 */
class UserToken extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_token';
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'token', 'login_time'], 'required'],
            [['user_id', 'login_time', 'fair_number'], 'integer'],
            [['token'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '主键id',
            'user_id' => '用户id',
            'token' => '认证token',
            'login_time' => '登录时间',
            'fair_number' => '失败次数',
        ];
    }
}
