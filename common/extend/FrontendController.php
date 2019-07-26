<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/25
 * Time: 15:13
 */
namespace common\extend;

use yii\web\Controller;

class FrontendController extends  Controller
{
    public function success($msg="", array $data = [])
    {
        $array = [
            'code'=>1,
            'msg'=>$msg,
            'data'=>$data
        ];

        return $this->asJson($array);
    }

    public function error($msg="", array $data = [])
    {
        $array = [
            'code'=>0,
            'msg'=>$msg,
            'data'=>$data
        ];

        return $this->asJson($array);
    }
}