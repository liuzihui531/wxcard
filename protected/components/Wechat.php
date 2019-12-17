<?php

/**
 * wechat php test
 */
//define your token
define("TOKEN", "haicheng");

class Wechat {

    public $appid = "wxecf01afa7fb7a022";
    public $appsecret = "6d12167859b0bbd972de2c02ecb9469e";

    public function valid() {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if ($this->checkSignature()) {
            echo $echoStr;
            exit;
        }
    }

    //响应消息
    public function responseMsg() {
        //根据用户传过来的消息类型进行不同的响应
        //1、接收微信服务器POST过来的数据，XML数据包
        $postData = file_get_contents("php://input");
        //Utils::log('postData:'.var_export($postData,true));
        if (!$postData) {
            echo "error";
            exit();
        }

        //2、解析XML数据包
        $object = simplexml_load_string($postData, "SimpleXMLElement", LIBXML_NOCDATA);
        //获取消息类型
        $MsgType = $object->MsgType;
        switch ($MsgType) {
            case 'event':
                //接收事件推送
                $this->receiveEvent($object);
                break;
            case 'text':
                //接收文本消息
                echo $this->receiveText($object);
                break;
            case 'image':
                //接收图片消息
                echo $this->receiveImage($object);
                break;
            case 'location':
                //接收地理位置消息
                $this->receiveLocation($object);
                break;
            case 'voice':
                //接收语音消息
                echo $this->receiveVoice($object);
                break;
            case 'video':
                //接收视频消息
                echo $this->receiveVideo($object);
                break;
            case 'link':
                //接收链接消息
                echo $this->receiveLink($object);
                break;
            default:
                break;
        }
    }

    private function checkSignature() {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        $token = TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);
        if ($tmpStr == $signature) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 获取access_token
     * @return type
     */
    public function getAccessToken() {
        //$access_token = Yii::app()->cache->get('access_token');
        //if (!$access_token) {
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$this->appid}&secret={$this->appsecret}";
        $rtn = Utils::curl($url);
        $rtn_arr = CJSON::decode($rtn, true);
        $access_token = $rtn_arr['access_token'];
        Yii::app()->cache->set('access_token', $access_token, 5000);
        //}
        return $access_token;
    }

    /**
     * 自定义菜单
     * @param type $arr
     */
    public function createMenu($arr) {
        $access_token = $this->getAccessToken();
        //echo $access_token;exit;
        $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=" . $access_token;
        $data = json_encode($arr, JSON_UNESCAPED_UNICODE);
        $r = Utils::curl_post($url, $data);
        $r = CJSON::decode($r, true);
        return $r;
        //echo $r['errcode'] == 0 ? 1 : 0;
    }

    /**
     * 获取用户菜单
     * @return type
     */
    public function getMenu() {
        $access_token = $this->getAccessToken();
        $url = "https://api.weixin.qq.com/cgi-bin/menu/get?access_token={$access_token}";
        return Utils::curl($url);
    }

    /**
     * 获取用户列表
     * @param type $next_openid ，开始的用户列表，不填写则择选取所有用户
     * @return type
     */
    public function getUserList($next_openid = null) {
        $access_token = $this->getAccessToken();
        $url = "https://api.weixin.qq.com/cgi-bin/user/get?access_token={$access_token}";
        if ($next_openid) {
            $url .= "&next_openid={$next_openid}";
        }
        return Utils::curl($url);
    }

    /**
     * 获取用户详情
     * @param type $openid
     * @return type
     */
    public function getUserInfo($openid) {
        $access_token = $this->getAccessToken();
        $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token={$access_token}&openid={$openid}&lang=zh_CN";
        return Utils::curl($url);
    }

    //接收事件推送
    private function receiveEvent($obj) {        Utils::log($obj->Event);
        switch ($obj->Event) {
            //关注事件
            case 'subscribe':
                Utils::log($obj);
                //扫描带参数的二维码，用户未关注时，进行关注后的事件
                if (!empty($obj->EventKey)) {
                    //做相关处理
                }
                $openid = $obj->FromUserName;
                $user_info = $this->getUserInfo($openid);
                $user_info = CJSON::decode($user_info, true);
                $content = "";
                if ($user_info) {
                    WeixinUser::model()->addWeixinUser($user_info);
                }
                //$content .= "　　欢迎关注深南燃气，目前深南燃气订气服务只开通了南山、福田、盐田、宝安。其他区域陆续上线，敬请期待。\r\n　　通过深南燃气微信平台下单，将会享受优惠折扣。\r\n　　如您是送气工推荐的，<a href='http://m.szlnny.com/wechat/select_invite'>请点击选择送气工</a>";
                //$content .= "　　欢迎关注深南燃气，目前深南燃气订气服务只开通了南山、福田、盐田、宝安。其他区域陆续上线，敬请期待。\r\n　　通过深南燃气微信平台下单，将会享受优惠折扣。\r\n　　温馨提示：下单时请认准“<span style='font-weight:bold;color:red'>深南燃气</span>”的钢瓶下单，钢瓶统一银灰色或者紫色，上面印有“<span style='font-weight:bold;color:red'>深南燃气</span>“及“<span style='font-weight:bold;color:red'>BSN</span>”的钢瓶编码字样，其他颜色钢瓶或其他字样本公司一律不接收。";//\r\n　　如您是送气工推荐的，<a href='http://m.szlnny.com/wechat/select_invite'>请点击选择送气工</a>";
                $content .= "　　欢迎关注六南燃气";
                echo $this->replyText($obj, $content , true);
                break;
            //取消关注事件
            case 'unsubscribe':
                $openid = $obj->FromUserName;
                $weixin_user_model = WeixinUser::model()->findByPk($openid);
                if ($weixin_user_model) {
                    $weixin_user_model->subscribe = 0;
                    $weixin_user_model->save();
                }
                break;
            case "LOCATION":
                //if (!Yii::app()->session['location']) {
                //Utils::log($obj);
                $openid = $obj->FromUserName;
                $weixin_user_model = WeixinUser::model()->findByPk($openid);
                if ($weixin_user_model) {
                    $weixin_user_model->latitude = $obj->Latitude;
                    $weixin_user_model->longitude = $obj->Longitude;
                    $weixin_user_model->precision = $obj->Precision;
                    $weixin_user_model->save();
                    //Yii::app()->session['location'] = 1;
                }
                //}
                break;
            //扫描带参数的二维码，用户已关注时，进行关注后的事件
            case 'SCAN':
                //做相关的处理
                break;
            //自定义菜单事件
            case 'CLICK':
                //
                switch ($obj->EventKey) {
                    case 'PRODUCE_INTRODUCE':
                        //IgZJlAIuMQVCfANfxJlCh4YEaccRnG_V7eDNr77AWQs
                        $media_id = "CPz0nW_vQ6xCGLrAdQPKaTS5pbwX3mk2w-6AW8uohtU";
                        $media_list = $this->getBatchgetMaterial('news', 0, 10);
                        $media_info = array();
                        foreach ($media_list['item'] as $k => $v) {
                            if ($v['media_id'] == $media_id) {
                                $media_info = $v;
                            }
                        }
                        $newArr = array();
                        foreach ($media_info['content']['news_item'] as $k => $v) {
                            $newArr[$k] = array(
                                'Title' => $v['title'],
                                'Description' => $v['digest'],
                                'PicUrl' => $v['title'],
                                'Url' => $v['url'],
                            );
                            if (!is_file(dirname(Yii::app()->basePath) . '/www/upload/weixin/' . $v['thumb_media_id'] . '.jpg')) {
                                $img = $this->getThumbMediaId($v['thumb_media_id']);
                                file_put_contents(dirname(Yii::app()->basePath) . '/www/upload/weixin/' . $v['thumb_media_id'] . '.jpg', $img);
                            }
                            $newArr[$k]['PicUrl'] = Yii::app()->request->hostInfo . '/upload/weixin/' . $v['thumb_media_id'] . '.jpg';
                        }
                        echo $this->replyNews($obj, $newArr);
                        break;
                    case 'SAFE_USE':
                        $media_id = "CPz0nW_vQ6xCGLrAdQPKae59z0W0br06BmWGLQcDjB4";
                        $media_list = $this->getBatchgetMaterial('news', 0, 10);
                        $media_info = array();
                        foreach ($media_list['item'] as $k => $v) {
                            if ($v['media_id'] == $media_id) {
                                $media_info = $v;
                            }
                        }
                        $newArr = array();
                        foreach ($media_info['content']['news_item'] as $k => $v) {
                            $newArr[$k] = array(
                                'Title' => $v['title'],
                                'Description' => $v['digest'],
                                'PicUrl' => $v['title'],
                                'Url' => $v['url'],
                            );
                            if (!is_file(dirname(Yii::app()->basePath) . '/www/upload/weixin/' . $v['thumb_media_id'] . '.jpg')) {
                                $img = $this->getThumbMediaId($v['thumb_media_id']);
                                file_put_contents(dirname(Yii::app()->basePath) . '/www/upload/weixin/' . $v['thumb_media_id'] . '.jpg', $img);
                            }
                            $newArr[$k]['PicUrl'] = Yii::app()->request->hostInfo . '/upload/weixin/' . $v['thumb_media_id'] . '.jpg';
                        }
                        echo $this->replyNews($obj, $newArr);
                        break;
                    case 'NEW_ACTIVITY':
                        $media_id = "CPz0nW_vQ6xCGLrAdQPKabB5CmaEfSNc423jE40Z6AU";
                        $media_list = $this->getBatchgetMaterial('news', 0, 10);
                        $media_info = array();
                        foreach ($media_list['item'] as $k => $v) {
                            if ($v['media_id'] == $media_id) {
                                $media_info = $v;
                            }
                        }
                        $newArr = array();
                        foreach ($media_info['content']['news_item'] as $k => $v) {
                            $newArr[$k] = array(
                                'Title' => $v['title'],
                                'Description' => $v['digest'],
                                'PicUrl' => $v['title'],
                                'Url' => $v['url'],
                            );
                            if (!is_file(dirname(Yii::app()->basePath) . '/www/upload/weixin/' . $v['thumb_media_id'] . '.jpg')) {
                                $img = $this->getThumbMediaId($v['thumb_media_id']);
                                file_put_contents(dirname(Yii::app()->basePath) . '/www/upload/weixin/' . $v['thumb_media_id'] . '.jpg', $img);
                            }
                            $newArr[$k]['PicUrl'] = Yii::app()->request->hostInfo . '/upload/weixin/' . $v['thumb_media_id'] . '.jpg';
                        }
                        echo $this->replyNews($obj, $newArr);
                        break;
                    case 'USE_HELP':
                        $media_id = "CPz0nW_vQ6xCGLrAdQPKabJlcxE0XkQzcqcIaMi8x8k";
                        $media_list = $this->getBatchgetMaterial('news', 0, 10);
                        $media_info = array();
                        foreach ($media_list['item'] as $k => $v) {
                            if ($v['media_id'] == $media_id) {
                                $media_info = $v;
                            }
                        }
                        $newArr = array();
                        foreach ($media_info['content']['news_item'] as $k => $v) {
                            $newArr[$k] = array(
                                'Title' => $v['title'],
                                'Description' => $v['digest'],
                                'PicUrl' => $v['title'],
                                'Url' => $v['url'],
                            );
                            if (!is_file(dirname(Yii::app()->basePath) . '/www/upload/weixin/' . $v['thumb_media_id'] . '.jpg')) {
                                $img = $this->getThumbMediaId($v['thumb_media_id']);
                                file_put_contents(dirname(Yii::app()->basePath) . '/www/upload/weixin/' . $v['thumb_media_id'] . '.jpg', $img);
                            }
                            $newArr[$k]['PicUrl'] = Yii::app()->request->hostInfo . '/upload/weixin/' . $v['thumb_media_id'] . '.jpg';
                        }
                        echo $this->replyNews($obj, $newArr);
                        break;
                    case 'MY_ADDRESS':
                        $openid = $obj->FromUserName;
                        echo $this->replyText($obj, $html);
                        break;
                    default:
                        echo $this->replyText($obj, "你的点击的是其他事件");
                        break;
                }
                break;
        }
    }

    //客服接口-发送文本消息，支持群发
    public function sendMsg($openid, $content) {
        $access_token = $this->getAccessToken();
        if (is_array($openid)) { //群发
            $url = "https://api.weixin.qq.com/cgi-bin/message/mass/send?access_token=" . $access_token;
        } else { //单发
            $url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=" . $access_token;
        }
        $arr = array(
            'touser' => $openid,
            'msgtype' => 'text',
            'text' => array(
                'content' => urlencode($content),
            ),
        );
        $data = urldecode(CJSON::encode($arr));
        $r = Utils::curl_post($url, $data);
        $r = CJSON::decode($r, true);
        return $r['errcode'] == 0 ? 1 : 0;
    }

    /**
     * 根据media_id获取素材
     * @return type
     */
    public function getMaterial($media_id) {
        $access_token = $this->getAccessToken();
        $url = 'https://api.weixin.qq.com/cgi-bin/material/get_material?access_token=' . $access_token;
        $data = array(
            'media_id' => $media_id,
        );
        $data = CJSON::encode($data);
        $rs = Utils::curl_post($url, $data);
        return CJSON::decode($rs, true);
    }

    /**
     * 获取图片缩略图
     * @param type $thumb_media_id
     * @return type
     */
    public function getThumbMediaId($thumb_media_id) {
        $access_token = $this->getAccessToken();
        $url = 'https://api.weixin.qq.com/cgi-bin/material/get_material?access_token=' . $access_token;
        $data = array(
            'media_id' => $thumb_media_id,
        );
        $data = CJSON::encode($data);
        $rs = Utils::curl_post($url, $data);
        return $rs;
    }

    /**
     * 获取素材列表
     * @return type
     */
    public function getBatchgetMaterial($type = 'news', $offset = 0, $count = 10) {
        $access_token = $this->getAccessToken();
        $url = "https://api.weixin.qq.com/cgi-bin/material/batchget_material?access_token=" . $access_token;
        $data = array(
            'type' => $type,
            'offset' => $offset,
            'count' => $count
        );
        $data = CJSON::encode($data);
        $rs = Utils::curl_post($url, $data);
        return CJSON::decode($rs, true);
    }

    //接收文本消息
    private function receiveText($obj) {
        //获取文本消息的内容
        $content = $obj->Content;
        $content = '如对公众号使用有疑问请咨询8992777.';
        //发送文本消息
        return $this->replyText($obj, $content);
    }

    //接收图片消息
    private function receiveImage($obj) {
        //获取图片消息的内容
        $imageArr = array(
            "PicUrl" => $obj->PicUrl,
            "MediaId" => $obj->MediaId
        );
        //发送图片消息
        return $this->replyImage($obj, $imageArr);
    }

    //接收地理位置消息
    private function receiveLocation($obj) {
        //获取地理位置消息的内容
        $openid = $obj->FromUserName;
        $user_model = WeixinUser::model()->findByAttributes(array('openid' => $openid));
        $user_model->latitude = $obj->Location_X;
        $user_model->longitude = $obj->Location_Y;
        $user_model->save();
        //回复文本消息
        $content = "您的经度是：" . $obj->Location_Y . ",纬度是：" . $obj->Location_X;
        return $this->replyText($obj, $content);
    }

    //接收语言消息
    private function receiveVoice($obj) {
        //获取语言消息内容
        $voiceArr = array(
            "MediaId" => $obj->MediaId,
            "Format" => $obj->Format
        );
        //回复语言消息
        return $this->replyVoice($obj, $voiceArr);
    }

    //接收视频消息
    private function receiveVideo($obj) {
        //获取视频消息的内容
        $videoArr = array(
            "MediaId" => $obj->MediaId
        );
        //回复视频消息
        return $this->replyVideo($obj, $videoArr);
    }

    //接收链接消息
    private function receiveLink($obj) {
        //接收链接消息的内容
        $linkArr = array(
            "Title" => $obj->Title,
            "Description" => $obj->Description,
            "Url" => $obj->Url
        );
        //回复文本消息
        return $this->replyText($obj, "你发过来的链接地址是{$linkArr['Url']}");
    }

    //发送文本消息
    private function replyText($obj, $content , $is_abs = false) {
        $replyXml = "<xml>
						<ToUserName><![CDATA[%s]]></ToUserName>
						<FromUserName><![CDATA[%s]]></FromUserName>
						<CreateTime>%s</CreateTime>
						<MsgType><![CDATA[text]]></MsgType>
						<Content><![CDATA[%s]]></Content>
						</xml>";
        //返回一个进行xml数据包
        if ($content == 'tj') {
            //$content = '<a href="http://m.szlnny.com/tongji/store">查看统计</a>';
        } else {
            if (!$is_abs) {
                $content = '感谢关注六南能源微信公众平台，如有疑问请致电0755-89927777。';
            }
        }
        $resultStr = sprintf($replyXml, $obj->FromUserName, $obj->ToUserName, time(), $content);
        return $resultStr;
    }

    //发送图片消息
    private function replyImage($obj, $imageArr) {
        $replyXml = "<xml>
						<ToUserName><![CDATA[%s]]></ToUserName>
						<FromUserName><![CDATA[%s]]></FromUserName>
						<CreateTime>%s</CreateTime>
						<MsgType><![CDATA[image]]></MsgType>
						<Image>
						<MediaId><![CDATA[%s]]></MediaId>
						</Image>
						</xml>";
        //返回一个进行xml数据包

        $resultStr = sprintf($replyXml, $obj->FromUserName, $obj->ToUserName, time(), $imageArr['MediaId']);
        return $resultStr;
    }

    //回复语音消息
    private function replyVoice($obj, $voiceArr) {
        $replyXml = "<xml>
						<ToUserName><![CDATA[%s]]></ToUserName>
						<FromUserName><![CDATA[%s]]></FromUserName>
						<CreateTime>%s</CreateTime>
						<MsgType><![CDATA[voice]]></MsgType>
						<Voice>
						<MediaId><![CDATA[%s]]></MediaId>
						</Voice>
						</xml>";
        //返回一个进行xml数据包

        $resultStr = sprintf($replyXml, $obj->FromUserName, $obj->ToUserName, time(), $voiceArr['MediaId']);
        return $resultStr;
    }

    //回复视频消息
    private function replyVideo($obj, $videoArr) {
        $replyXml = "<xml>
						<ToUserName><![CDATA[%s]]></ToUserName>
						<FromUserName><![CDATA[%s]]></FromUserName>
						<CreateTime>%s</CreateTime>
						<MsgType><![CDATA[video]]></MsgType>
						<Video>
						<MediaId><![CDATA[%s]]></MediaId>
						</Video> 
						</xml>";
        //返回一个进行xml数据包

        $resultStr = sprintf($replyXml, $obj->FromUserName, $obj->ToUserName, time(), $videoArr['MediaId']);
        return $resultStr;
    }

    //回复音乐消息
    private function replyMusic($obj, $musicArr) {
        $replyXml = "<xml>
						<ToUserName><![CDATA[%s]]></ToUserName>
						<FromUserName><![CDATA[%s]]></FromUserName>
						<CreateTime>%s</CreateTime>
						<MsgType><![CDATA[music]]></MsgType>
						<Music>
						<Title><![CDATA[%s]]></Title>
						<Description><![CDATA[%s]]></Description>
						<MusicUrl><![CDATA[%s]]></MusicUrl>
						<HQMusicUrl><![CDATA[%s]]></HQMusicUrl>
						<ThumbMediaId><![CDATA[%s]]></ThumbMediaId>
						</Music>
						</xml>";
        //返回一个进行xml数据包

        $resultStr = sprintf($replyXml, $obj->FromUserName, $obj->ToUserName, time(), $musicArr['Title'], $musicArr['Description'], $musicArr['MusicUrl'], $musicArr['HQMusicUrl'], $musicArr['ThumbMediaId']);
        return $resultStr;
    }

    //回复图文消息
    private function replyNews($obj, $newsArr) {
        $itemStr = "";
        if (is_array($newsArr)) {
            foreach ($newsArr as $item) {
                $itemXml = "<item>
						<Title><![CDATA[%s]]></Title> 
						<Description><![CDATA[%s]]></Description>
						<PicUrl><![CDATA[%s]]></PicUrl>
						<Url><![CDATA[%s]]></Url>
						</item>";
                $itemStr .= sprintf($itemXml, $item['Title'], $item['Description'], $item['PicUrl'], $item['Url']);
            }
        }

        $replyXml = "<xml>
						<ToUserName><![CDATA[%s]]></ToUserName>
						<FromUserName><![CDATA[%s]]></FromUserName>
						<CreateTime>%s</CreateTime>
						<MsgType><![CDATA[news]]></MsgType>
						<ArticleCount>%s</ArticleCount>
						<Articles>
							{$itemStr}
						</Articles>
						</xml> ";
        //返回一个进行xml数据包

        $resultStr = sprintf($replyXml, $obj->FromUserName, $obj->ToUserName, time(), count($newsArr));
        return $resultStr;
    }

}

?>
