<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of WechatController
 *
 * @author lzh
 */
class WechatController extends Controller{
    public function actionIndex(){
        $wechat = new Wechat();
        $wechat->valid();
        //$wechat->responseMsg();
    }

    public function actionApply() {
        $this->render('apply');
    }

    public function actionGetcode() {
        $mobile = Yii::app()->request->getParam('mobile', '');
        $key = "mobile_{$mobile}_code";
        if (Utils::redis()->get($key)) {
            $ret = ['code' => 100, 'msg' => '操作过于频繁'];
            exit(json_encode($ret));
        }
        $code = mt_rand(1000, 9999);
        //发送短信验证码 .................
        Utils::redis()->setex($key,60, $code);
        $ret = ['code' => 200, 'msg' => $code];
        exit(json_encode($ret));
    }
}
