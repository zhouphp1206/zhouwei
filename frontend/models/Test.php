<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/11
 * Time: 11:23
 */

namespace frontend\models;


use yii\db\ActiveRecord;

class Test extends ActiveRecord
{
    public static function tableName()
    {
        return '{{tb_test}}';
    }
}