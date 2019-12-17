<?php
/**
 * Created by PhpStorm.
 * User: liuzihui
 * Date: 2019/12/7
 * Time: 14:34
 */
class MenuController extends Controller{
    public function actionIndex() {
        $json = '{
    "button": [
        {
            "name": "书店介绍", 
            "sub_button": [
                {
                   "type": "view_limited", 
                   "name": "海呈简介", 
                   "media_id": "MEDIA_ID2"
                }, 
                {
                   "type": "view_limited", 
                   "name": "海呈书店一览", 
                   "media_id": "MEDIA_ID2"
                },
                {
                   "type": "click", 
                   "name": "走进海呈", 
                   "media_id": "zoujinhaicheng"
                }
            ]
        }, 
        {
            "name": "不止读书", 
            "sub_button": [
                {
                   "type": "view_limited", 
                   "name": "爱心活动", 
                   "media_id": "MEDIA_ID3"
                }
            ]
        }, 
        {
            "name": "更多海呈", 
            "sub_button": [
                {
                   "type": "view", 
                   "name": "微博", 
                   "url": "https://weibo.com/p/1006066279064403/home?from=page_100606&mod=TAB&is_all=1#place"
                },
                {
                   "type": "view", 
                   "name": "好书推荐", 
                   "url": "http://mp.weixin.qq.com/s?__biz=MzI5NzU1MTM3NA==&mid=2247486627&idx=1&sn=056a79e0964f364583bce3163fd00019&chksm=ecb21fc2dbc596d430acc9b58282fcfb8e766164aa241954b8e41e9ab8f9894da438ca2992b4&scene=18#wechat_redirect"
                }
            ]
        }
    ]
}';
        $arr = json_decode($json, true);
        $wechat = new Wechat();
        $ret = $wechat->createMenu($arr);
        var_dump($ret);
    }

    public function actionGetsucai() {
        $wechat = new Wechat();
        $ret = $wechat->getBatchgetMaterial('news', 0, 50);
        echo json_encode($ret);exit;
    }
}