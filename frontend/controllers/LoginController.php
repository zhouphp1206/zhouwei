<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/24
 * Time: 14:35
 */

namespace frontend\controllers;

use Codeception\Module\Db;
use common\extend\FrontendController;

use common\models\User;

use common\helps\HelpTool;
use common\models\UserToken;

class LoginController extends FrontendController
{

    /**
     * 手机号加验证码登录登录
     */
    public function actionPhoneLogin()
    {
        //手机号加验证码登录
        $request = \Yii::$app->request;

        if (!$request->post('captcha')) return $this->error('验证码不能为空');


        //失败记录登录失败次数+1,返回失败
        $user = self::getUserByMobile($request->post('mobile'));

        if (!$user) return $this->error('用户不存在');

        $userToken = UserToken::findOne(['user_id'=>$user->id]);

        //查看登录失败次数是否达到限制

        if ($userToken->fair_number>10) return $this->error('失败次数太多,暂不可登录');

        if ($request->post('captcha')!='6666') {

            //记录用户登录失败次数

            $userToken->updateCounters(['fair_number'=>1]);

            return $this->error('验证码输入错误');
        }else{
            //验证码正确
            $token  =  $userToken->token;

            //给出token
            if(!$token){
                $token = self::createToken($user->id);

                $userToken->token = $token;

                $userToken->save();
            }else{
                return $this->success('登录成功',['token'=>$token]);
            }
        }
    }
    /**
     * 手机号注册 暂时未加入验证码
     * 用户手机号注册
     */
    public function actionPhoneRegister()
    {
        $request = \Yii::$app->request;

        $UserModel = new User();

        $UserModel->load($request->post(),'');

        $UserModel->scenario = 'phone_register';

        if (!$UserModel->validate()) return $this->error(HelpTool::getModelError($UserModel));

        $res = self::getUserByMobile($request->post('mobile'));

        if (!$request->post('captcha')) return $this->error('验证码不能为空');

        if ($request->post('captcha')!='6666') return $this->error('验证码输入错误');

        if ($res) return $this->error('手机号已注册');

        //4.信息放入用户表
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $resgiter_res = $UserModel->save(false);

            $userToken = new UserToken();

            $data_token = [
                'user_id'=>$UserModel->id,

                'login_time'=>time(),

                'token'=>self::createToken($UserModel->id)
            ];

            $userToken->load($data_token,'');

            $token_res = $userToken->save(false);

            if (!$resgiter_res || !$token_res) return $this->error('注册失败');

            $transaction->commit();
        } catch (\Exception $e) {

            $transaction->rollBack();

            return $this->error('注册失败');

        }
            return $this->success('注册成功');

    }

    /**
     * 使用用户id生成一个token
     * @param $user_id
     * @return mixed
     */
    private function createToken($user_id){

        $key = mt_rand();

        $hash = hash_hmac("sha1", $user_id . mt_rand() . time(), $key, true);

        $token = str_replace('=', '', strtr(base64_encode($hash), '+/', '-_'));

        return $token;
    }

    /**使用手机号获取用户,如果没有该用户返回false
     * @param $mobile
     * @return bool|User|null
     */
    private function getUserByMobile($mobile){

       $find =  User::findOne(['mobile' =>$mobile, 'status' => User::STATUS_ACTIVE]);

       if (!$find) return false;

       return $find;
    }
    /**
     *
     */
}