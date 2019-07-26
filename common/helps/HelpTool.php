<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/25
 * Time: 17:02
 */

namespace common\helps;

class HelpTool
{
    /**
     * 获取错误信息的第一条
     * @param $model
     * @return bool|mixed
     */
    public static function getModelError($model) {
        $errors = $model->getErrors();    //得到所有的错误信息
        if(!is_array($errors)){
            return true;
        }
        $firstError = array_shift($errors);
        if(!is_array($firstError)) {
            return true;
        }
        return array_shift($firstError);
    }


}