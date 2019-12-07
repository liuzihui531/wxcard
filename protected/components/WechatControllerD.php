<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of WechatControllerD
 *
 * @author lzh
 */
class WechatControllerD extends Controller {

    //put your code here
    public $openid = null;
    public $user_id = null;
    public $user_model = null;

    public function init() {
        parent::init(); //
        //UtilD::clearOpenid();
//        $this->openid = UtilD::getOpenid();
//        if (!$this->openid) {
//            $this->openid = 'ov8hIxFmONoI0UR6aknvyxnlwNMI';
//            UtilD::setOpenid($this->openid);
//        }
        $this->openid = Yii::app()->session['openid'];
        if (!$this->openid) {
            $wechat = new Wechat();
            $redirect_uri = urlencode($this->createAbsoluteUrl('/wechat'));
            $appid = $wechat->appid;
            $secret = $wechat->appsecret;
            $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$appid}&redirect_uri={$redirect_uri}&response_type=code&scope=snsapi_base&state=123#wechat_redirect";
            if (Yii::app()->request->getParam('state', '')) {
                $code = Yii::app()->request->getParam('code', '');
                $access_url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$appid}&secret={$secret}&code={$code}&grant_type=authorization_code";
                $access_res = UtilD::curl($access_url);
                $access_arr = CJSON::decode($access_res, true);
                $openid = $access_arr['openid'];
                if ($openid) {
                    $this->openid = $openid;
                    Yii::app()->session['openid'] = $openid;
                    UtilD::setOpenid($this->openid);
                    $user_info = $wechat->getUserInfo($openid);
                    $user_info = CJSON::decode($user_info, true);
                    $wechat_res = WeixinUser::model()->addWeixinUser($user_info);
                } else {
                    header("Content-type:text/html;charset=utf-8");
                    die('系统出错');
                }
            } else {
                $this->redirect($url);
            }
        }
        $this->user_model = User::model()->getUserInfo($this->openid);
        if ($this->user_model) {
            $this->user_id = $this->user_model->id;
        }
    }

}