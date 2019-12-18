<?php
/**
 * Created by PhpStorm.
 * User: liuzihui
 * Date: 2019/12/7
 * Time: 14:34
 */
class MenuController extends Controller{
    public function actionIndex() {
        //海呈门店一览
        //如果正好
        $json = '{
    "button": [
        {
            "name": "书店介绍", 
            "sub_button": [
                {
                   "type": "click", 
                   "name": "海呈简介", 
                   "key": "haichengjianjie"
                }, 
                {
                   "type": "click", 
                   "name": "海呈门店一览", 
                   "key": "haichengmendianyilan"
                },
                {
                   "type": "click", 
                   "name": "走进海呈", 
                   "key": "zoujinhaicheng"
                }
            ]
        }, 
        {
            "name": "不止读书", 
            "sub_button": [
                {
                   "type": "click", 
                   "name": "爱心活动", 
                   "key": "aixinhuodong"
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

    //创建会员卡
    public function actionCreatecard() {
        $arr = array (
            'card' => array (
                'card_type' => 'MEMBER_CARD',
                'member_card' => array (
                    'background_pic_url' => 'https://mmbiz.qlogo.cn/mmbiz/',
                    'base_info' => array (
                        'logo_url' => 'http://mmbiz.qpic.cn/mmbiz/iaL1LJM1mF9aRKPZ/0',
                        'brand_name' => '海呈',
                        'code_type' => 'CODE_TYPE_TEXT',
                        'title' => '海呈会员卡',
                        'color' => 'Color010',
                        'notice' => '使用时向服务员出示此券',
                        'service_phone' => '020-88888888',
                        'description' => '不可与其他优惠同享',
                        'date_info' => array (
                            'type' => 'DATE_TYPE_PERMANENT',
                            ),
                        'sku' => array (
                            'quantity' => 50000000,
                            ),
                        'get_limit' => 3,
                        'use_custom_code' => false,
                        'can_give_friend' => true,
                        'location_id_list' => array (
                            0 => 123, 1 => 12321,
                            ),
                        'custom_url_name' => '立即使用',
                        'custom_url' => 'http://weixin.qq.com',
                        'custom_url_sub_title' => '6个汉字tips',
                        'promotion_url_name' => '营销入口1',
                        'promotion_url' => 'http://www.qq.com',
                        'need_push_on_view' => true,
                    ),
                    'advanced_info' => array (
                        'use_condition' => array (
                            'accept_category' => '鞋类',
                            'reject_category' => '阿迪达斯',
                            'can_use_with_other_discount' => true,
                        ), 'abstract' => array (
                            'abstract' => '微信餐厅推出多种新季菜品，期待您的光临',
                            'icon_url_list' => array (
                                0 => 'http://mmbiz.qpic.cn/mbizp98FjXy8LacgHxp3sJ3vn97bGLz0ib0Sfz1bjiaoOYA027iasqSG0sjpiby4vce3AtaPu6cIhBHkt6IjlkY9YnDsfw/0',
                            ),
                        ),
                        'text_image_list' => array (
                            0 => array (
                                'image_url' => 'http://mmbiz.qpic.cn/mmbiz/p98FjXy8LacgHxp3sJ3vn97bGLz0ib0Sfz1bjiaoOYA027iasqSG0sjpiby4vce3AtaPu6cIhBHkt6IjlkY9YnDsfw/0',
                                'text' => '此菜品精选食材，以独特的烹饪方法，最大程度地刺激食 客的味蕾',
                            ),
                            1 => array (
                                'image_url' => 'http://mmbiz.qpic.cn/mmbiz/p98FjXy8LacgHxp3sJ3vn97bGLz0ib0Sfz1bjiaoOYA027iasqSG0sj piby4vce3AtaPu6cIhBHkt6IjlkY9YnDsfw/0',
                                'text' => '此菜品迎合大众口味，老少皆宜，营养均衡',
                            ),
                        ),
                        'time_limit' => array (
                            0 => array (
                                'type' => 'MONDAY',
                                'begin_hour' => 0,
                                'end_hour' => 10,
                                'begin_minute' => 10,
                                'end_minute' => 59,
                            ),
                            1 => array (
                                'type' => 'HOLIDAY',
                            ),
                        ),
                        'business_service' => array (
                            0 => 'BIZ_SERVICE_FREE_WIFI',
                            1 => 'BIZ_SERVICE_WITH_PET',
                            2 => 'BIZ_SERVICE_FREE_PARK',
                            3 => 'BIZ_SERVICE_DELIVER',
                        ),
                    ),
                    'supply_bonus' => true,
                    'supply_balance' => false,
                    'prerogative' => 'test_prerogative',
                    'auto_activate' => true,
                    'custom_field1' => array (
                        'name_type' => 'FIELD_NAME_TYPE_LEVEL',
                        'url' => 'http://www.qq.com',
                    ),
                    'activate_url' => 'http://www.qq.com',
                    'custom_cell1' => array (
                        'name' => '使用入口2',
                        'tips' => '激活后显示',
                        'url' => 'http://www.qq.com',
                    ),
                    'bonus_rule' => array (
                        'cost_money_unit' => 100,
                        'increase_bonus' => 1,
                        'max_increase_bonus' => 200,
                        'init_increase_bonus' => 10,
                        'cost_bonus_unit' => 5,
                        'reduce_money' => 100,
                        'least_money_to_use_bonus' => 1000,
                        'max_reduce_bonus' => 50,
                    ),
                    'discount' => 10,
                ),
            ),
        );
        $wechat = new Wechat();
        $ret = $wechat->createCard($arr);
        var_export($ret);
    }
}