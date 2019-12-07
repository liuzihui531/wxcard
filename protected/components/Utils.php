<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Utils
 *
 * @author lzh
 */
class Utils {

    //put your code here
    public static function password($password) {
        return md5($password);
    }

    /**
     * 过滤不完整的utf8编码字符
     * @param string $str
     * @return string
     */
    public static function filterPartialUTF8Char($str) {
        $str = preg_replace("/[\\xC0-\\xDF](?=[\\x00-\\x7F\\xC0-\\xDF\\xE0-\\xEF\\xF0-\\xF7]|$)/", "", $str);
        $str = preg_replace("/[\\xE0-\\xEF][\\x80-\\xBF]{0,1}(?=[\\x00-\\x7F\\xC0-\\xDF\\xE0-\\xEF\\xF0-\\xF7]|$)/", "", $str);
        $str = preg_replace("/[\\xF0-\\xF7][\\x80-\\xBF]{0,2}(?=[\\x00-\\x7F\\xC0-\\xDF\\xE0-\\xEF\\xF0-\\xF7]|$)/", "", $str);
        return $str;
    }

    /**
     * 中文字符串截取
     * @param string    $string  需要截取的字符串
     * @param int       $length  截取的长度
     * @param string    $etc     被截取的部分替换的字符串
     * @param bool    $encry     是否需要返回转义后的字符串
     */
    public static function cutString($string, $length, $etc = '...', $charset = 'UTF-8') {
        $string = Utils::deSlashes($string);
        $trans = array('&nbsp;' => ' ');
        $string = strtr($string, $trans);
        $string = trim(strip_tags($string));
        $string = mb_strimwidth($string, 0, $length * 2, $etc, $charset);
        return $string;
    }

    //判断ipv4地址是否是一个局域网地址
    public static function isInternalp($ip) {
        $ip = ip2long($ip);
        $net_a = ip2long('10.255.255.255') >> 24; //A类网预留ip的网络地址 
        $net_b = ip2long('172.31.255.255') >> 20; //B类网预留ip的网络地址 
        $net_c = ip2long('192.168.255.255') >> 16; //C类网预留ip的网络地址 
        return $ip >> 24 === $net_a || $ip >> 20 === $net_b || $ip >> 16 === $net_c;
    }

    /**
     * 有[&#]的数据转换成正常数据
     */
    public static function deSlashes($value, $ucfirst = false) {
        if (empty($value)) {
            return $value;
        }
        if (mb_check_encoding($value, 'GBK') !== true) {
            $value = self::filterPartialUTF8Char($value);
        }
        if (mb_check_encoding($value, 'GBK') == false && mb_check_encoding($value, 'UTF-8') == false) {
            return '';
        }
        if (mb_check_encoding($value, 'GBK') == true && mb_check_encoding($value, 'UTF-8') !== true) {
            $value = mb_convert_encoding($value, 'UTF-8', 'GBK');
        }
        if (strpos($value, '&') !== false) {
            $value = htmlspecialchars_decode($value, ENT_QUOTES | ENT_NOQUOTES);
        }
        if (strpos($value, '&#') === false) {
            return $value;
        }

        $filters = array('&' => '&#' . ord('&') . ';', '#' => '&#' . ord('#') . ';', ' ' => '&#' . ord(' ') . ';', '\'' => '&#' . ord('\'') . ';', '>' => '&#' . ord('>') . ';',
            '<' => '&#' . ord('<') . ';', '=' => '&#' . ord('=') . ';', '!' => '&#' . ord('!') . ';', '^' => '&#' . ord('^') . ';', '+' => '&#' . ord('+') . ';',
            '-' => '&#' . ord('-') . ';', '*' => '&#' . ord('*') . ';', '/' => '&#' . ord('/') . ';', '%' => '&#' . ord('%') . ';', '|' => '&#' . ord('|') . ';',
            '~' => '&#' . ord('~') . ';', '@' => '&#' . ord('@') . ';', '"' => '&#' . ord('"') . ';', ';' => '&#' . ord(';') . ';');
        $value = strtr($value, array_flip($filters));
        if ($ucfirst === true) {
            $value = strtolower($value);
        }
        return $value;
    }

    /**
     * 数据转换成有[&#]
     */
    public static function enSlashes($value, $ucfirst = false) {
        if (empty($value)) {
            return $value;
        }
        //过滤不完整的utf8字符
        if (mb_check_encoding($value, 'GBK') !== true) {
            $value = self::filterPartialUTF8Char($value);
        }
        if (mb_check_encoding($value, 'GBK') == false && mb_check_encoding($value, 'UTF-8') == false) {
            return '';
        }
        if (mb_check_encoding($value, 'GBK') == true && mb_check_encoding($value, 'UTF-8') !== true) {
            $value = mb_convert_encoding($value, 'UTF-8', 'GBK');
        }
        if (strpos($value, '&') !== false) {
            $value = htmlspecialchars_decode($value, ENT_QUOTES | ENT_NOQUOTES);
        }
        $filters = array('&' => '&#' . ord('&') . ';', '#' => '&#' . ord('#') . ';', ' ' => '&#' . ord(' ') . ';', '\'' => '&#' . ord('\'') . ';', '>' => '&#' . ord('>') . ';',
            '<' => '&#' . ord('<') . ';', '=' => '&#' . ord('=') . ';', '!' => '&#' . ord('!') . ';', '^' => '&#' . ord('^') . ';', '+' => '&#' . ord('+') . ';',
            '-' => '&#' . ord('-') . ';', '*' => '&#' . ord('*') . ';', '/' => '&#' . ord('/') . ';', '%' => '&#' . ord('%') . ';', '|' => '&#' . ord('|') . ';',
            '~' => '&#' . ord('~') . ';', '@' => '&#' . ord('@') . ';', '"' => '&#' . ord('"') . ';', ';' => '&#' . ord(';') . ';');
        $value = strtr($value, $filters);
        if (strpos($value, '&#38;&#35;') !== false) {//如果本身就含转义字符
            $value = str_replace('&#38;&#35;', '&#', $value);
        }
        if ($ucfirst === true) {
            $value = strtolower($value);
        }
        return $value;
    }

    /*
     * 加密字符串
     * @param int $string   明文
     * @param int $operation   DECODE解密
     * @param int $key   密钥
     * @param int $expiry   过期时间，秒
     */

    public static function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {

        $ckey_length = 4;

        $key = md5($key ? $key : 'authcode^6key(9');
        $keya = md5(substr($key, 0, 16));
        $keyb = md5(substr($key, 16, 16));
        $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length) : substr(md5(microtime()), -$ckey_length)) : '';

        $cryptkey = $keya . md5($keya . $keyc);
        $key_length = strlen($cryptkey);

        $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0) . substr(md5($string . $keyb), 0, 16) . $string;
        $string_length = strlen($string);

        $result = '';
        $box = range(0, 255);

        $rndkey = array();
        for ($i = 0; $i <= 255; $i++) {
            $rndkey[$i] = ord($cryptkey[$i % $key_length]);
        }

        for ($j = $i = 0; $i < 256; $i++) {
            $j = ($j + $box[$i] + $rndkey[$i]) % 256;
            $tmp = $box[$i];
            $box[$i] = $box[$j];
            $box[$j] = $tmp;
        }

        for ($a = $j = $i = 0; $i < $string_length; $i++) {
            $a = ($a + 1) % 256;
            $j = ($j + $box[$a]) % 256;
            $tmp = $box[$a];
            $box[$a] = $box[$j];
            $box[$j] = $tmp;
            $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
        }

        if ($operation == 'DECODE') {
            if ((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26) . $keyb), 0, 16)) {
                return substr($result, 26);
            } else {
                return '';
            }
        } else {
            return $keyc . str_replace('=', '', base64_encode($result));
        }
    }

    /**
     * 取得IP
     * @return string 字符串类型的返回结果
     */
    public static function getIp() {
        if (@$_SERVER['HTTP_CLIENT_IP'] && $_SERVER['HTTP_CLIENT_IP'] != 'unknown') {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (@$_SERVER['HTTP_X_FORWARDED_FOR'] && $_SERVER['HTTP_X_FORWARDED_FOR'] != 'unknown') {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return preg_match('/^\d[\d.]+\d$/', $ip) ? $ip : '';
    }

    /**
      汉字转拼音
     * */
    public static function cnToPinyin($str, $_Code = 'utf-8') {
        if (mb_check_encoding($str, 'UTF-8')) {
            $str = mb_convert_encoding($str, 'GBK', 'UTF-8');
        }
        $len = mb_strlen($str, 'GBK');
        $ret = '';
        for ($i = 0; $i < $len; $i++) {

            try {
                $char = mb_substr($str, $i, 1, 'GBK');
                $xx = self::toPinyin($char);
            } catch (Exception $e) {
                $xx = array();
            }
            if (isset($xx['py'])) {
                $ret.=$xx['py'];
            } else {
                $ret.='unkown';
            }
        }
        return $ret;
    }

    /*
     * 重写$_SERVER['REQUREST_URI']
     */

    public static function request_uri() {
        if (isset($_SERVER['REQUEST_URI'])) {
            $uri = $_SERVER['REQUEST_URI'];
        } else {
            if (isset($_SERVER['argv'])) {
                $uri = $_SERVER['PHP_SELF'] . '?' . $_SERVER['argv'][0];
            } else {
                $uri = $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING'];
            }
        }
        return $uri;
    }

    /**
     * 取得上一页的url;
     * @return type
     */
    public static function referer_url() {
        $url = $_SERVER['HTTP_REFERER'];
        $url = $url ? $url : Yii::app()->controller->createAbsoluteUrl('/');
        $url = strstr($url, '/login') ? Yii::app()->controller->createAbsoluteUrl('/') : $url;
        return $url;
    }

    /**
     * 加密函数
     *
     * @param string $txt 需要加密的字符串
     * @param string $key 密钥
     * @return string 返回加密结果
     */
    public static function encrypt($txt, $key = '') {
        if (empty($key) || empty($txt)) {
            return $txt;
        }
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-_.";
        $ikey = "-x6g6ZWm2G9g_vr0Bo.pOq3kRIxsZ6rm";
        $nh1 = rand(0, 64);
        $nh2 = rand(0, 64);
        $nh3 = rand(0, 64);
        $ch1 = $chars{$nh1};
        $ch2 = $chars{$nh2};
        $ch3 = $chars{$nh3};
        $nhnum = $nh1 + $nh2 + $nh3;
        $knum = 0;
        $i = 0;
        while (isset($key{$i}))
            $knum +=ord($key{$i++});
        $mdKey = substr(md5(md5(md5($key . $ch1) . $ch2 . $ikey) . $ch3), $nhnum % 8, $knum % 8 + 16);
        $txt = base64_encode($txt);
        $txt = str_replace(array('+', '/', '='), array('-', '_', '.'), $txt);
        $tmp = '';
        $j = 0;
        $k = 0;
        $tlen = strlen($txt);
        $klen = strlen($mdKey);
        for ($i = 0; $i < $tlen; $i++) {
            $k = $k == $klen ? 0 : $k;
            $j = ($nhnum + strpos($chars, $txt{$i}) + ord($mdKey{$k++})) % 64;
            $tmp .= $chars{$j};
        }
        $tmplen = strlen($tmp);
        $tmp = substr_replace($tmp, $ch3, $nh2 % ++$tmplen, 0);
        $tmp = substr_replace($tmp, $ch2, $nh1 % ++$tmplen, 0);
        $tmp = substr_replace($tmp, $ch1, $knum % ++$tmplen, 0);
        return $tmp;
    }

    /**
     * 解密函数
     *
     * @param string $txt 需要解密的字符串
     * @param string $key 密匙
     * @return string 字符串类型的返回结果
     */
    public static function decrypt($txt, $key = '') {
        if (empty($key) || empty($txt)) {
            return $txt;
        }

        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-_.";
        $ikey = "-x6g6ZWm2G9g_vr0Bo.pOq3kRIxsZ6rm";
        $knum = 0;
        $i = 0;
        $tlen = strlen($txt);
        while (isset($key{$i}))
            $knum +=ord($key{$i++});
        $ch1 = $txt{$knum % $tlen};
        $nh1 = strpos($chars, $ch1);
        $txt = substr_replace($txt, '', $knum % $tlen--, 1);
        $ch2 = $txt{$nh1 % $tlen};
        $nh2 = strpos($chars, $ch2);
        $txt = substr_replace($txt, '', $nh1 % $tlen--, 1);
        $ch3 = $txt{$nh2 % $tlen};
        $nh3 = strpos($chars, $ch3);
        $txt = substr_replace($txt, '', $nh2 % $tlen--, 1);
        $nhnum = $nh1 + $nh2 + $nh3;
        $mdKey = substr(md5(md5(md5($key . $ch1) . $ch2 . $ikey) . $ch3), $nhnum % 8, $knum % 8 + 16);
        $tmp = '';
        $j = 0;
        $k = 0;
        $tlen = strlen($txt);
        $klen = strlen($mdKey);
        for ($i = 0; $i < $tlen; $i++) {
            $k = $k == $klen ? 0 : $k;
            $j = strpos($chars, $txt{$i}) - $nhnum - ord($mdKey{$k++});
            while ($j < 0)
                $j+=64;
            $tmp .= $chars{$j};
        }
        $tmp = str_replace(array('-', '_', '.'), array('+', '/', '='), $tmp);
        return trim(base64_decode($tmp));
    }

    /**
     * 读取目录列表
     * 不包括 . .. 文件 三部分
     * @param string $path 路径
     * @return array 数组格式的返回结果
     */
    public static function readDirList($path) {
        if (is_dir($path)) {
            $handle = @opendir($path);
            $dir_list = array();
            if ($handle) {
                while (false !== ($dir = readdir($handle))) {
                    if ($dir != '.' && $dir != '..' && is_dir($path . DS . $dir)) {
                        $dir_list[] = $dir;
                    }
                }
                return $dir_list;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * 获取文件列表(所有子目录文件)     *
     * @param string $path 目录
     * @param array $file_list 存放所有子文件的数组
     * @param array $ignore_dir 需要忽略的目录或文件
     * @return array 数据格式的返回结果
     */
    public static function readFileList($path, &$file_list, $ignore_dir = array()) {
        $path = rtrim($path, '/');
        if (is_dir($path)) {
            $handle = @opendir($path);
            if ($handle) {
                while (false !== ($dir = readdir($handle))) {
                    if ($dir != '.' && $dir != '..') {
                        if (!in_array($dir, $ignore_dir)) {
                            if (is_file($path . DS . $dir)) {
                                $file_list[] = $path . DS . $dir;
                            } elseif (is_dir($path . DS . $dir)) {
                                readFileList($path . DS . $dir, $file_list, $ignore_dir);
                            }
                        }
                    }
                }
                @closedir($handle);
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * unicode转为utf8
     * @param string $str 待转的字符串
     * @return string
     */
    public static function unicodeToUtf8($str, $order = "little") {
        $utf8string = "";
        $n = strlen($str);
        for ($i = 0; $i < $n; $i++) {
            if ($order == "little") {
                $val = str_pad(dechex(ord($str[$i + 1])), 2, 0, STR_PAD_LEFT) .
                        str_pad(dechex(ord($str[$i])), 2, 0, STR_PAD_LEFT);
            } else {
                $val = str_pad(dechex(ord($str[$i])), 2, 0, STR_PAD_LEFT) .
                        str_pad(dechex(ord($str[$i + 1])), 2, 0, STR_PAD_LEFT);
            }
            $val = intval($val, 16); // 由于上次的.连接，导致$val变为字符串，这里得转回来。
            $i++; // 两个字节表示一个unicode字符。
            $c = "";
            if ($val < 0x7F) { // 0000-007F
                $c .= chr($val);
            } elseif ($val < 0x800) { // 0080-07F0
                $c .= chr(0xC0 | ($val / 64));
                $c .= chr(0x80 | ($val % 64));
            } else { // 0800-FFFF
                $c .= chr(0xE0 | (($val / 64) / 64));
                $c .= chr(0x80 | (($val / 64) % 64));
                $c .= chr(0x80 | ($val % 64));
            }
            $utf8string .= $c;
        }
        /* 去除bom标记 才能使内置的iconv函数正确转换 */
        if (ord(substr($utf8string, 0, 1)) == 0xEF && ord(substr($utf8string, 1, 2)) == 0xBB && ord(substr($utf8string, 2, 1)) == 0xBF) {
            $utf8string = substr($utf8string, 3);
        }
        return $utf8string;
    }

    /**
     * 获取文件后缀
     * @param string $str
     * @return string
     */
    public static function file_ext($str) {
        $a = explode('.', $str);
        return end($a);
    }

    // 循环创建目录
    public static function mk_dir($dir, $mode = 0777) {
        if (is_dir($dir) || @mkdir($dir, $mode))
            return true;
        if (!self::mk_dir(dirname($dir), $mode))
            return false;
        return @mkdir($dir, $mode);
    }

    /**
     * 取得一个文件的后缀
     * @param type $filename
     * @return type
     */
    public static function fileext($filename) {
        return substr(strrchr($filename, '.'), 1);
    }

    /**
     * index.php目录
     * @return type
     */
    public static function webRoot() {
        return Yii::getPathOfAlias('webroot') . '/';
    }

    /**
     * 将对象转化成数组
     * @param type $object
     * @param type $keyBy
     * @return type
     */
    public static function object2array($object, $keyBy = '') {
        $array = array();
        if (is_array($object)) {
            foreach ($object as $value) {
                if ($keyBy != '')
                    $array[$value->$keyBy] = $value->attributes;
                else
                    $array[] = $value->attributes;
            }
        }
        return $array;
    }

    //格式化返回的数据
    public static function formatReturn($status, $message, $isJson = false) {
        $return = array('status' => $status, 'message' => $message);
        if ($isJson) {
            return CJSON::encode($return);
        }
        return $return;
    }

    /**
     * 获取文字的首字母
     * @param type $str
     * @return string
     */
    public static function getFirstLetter($str) {
        if (empty($str)) {
            return '';
        }
        $fchar = ord($str{0});
        if ($fchar >= ord('A') && $fchar <= ord('z'))
            return strtoupper($str{0});
        $s1 = iconv('UTF-8', 'gb2312', $str);
        $s2 = iconv('gb2312', 'UTF-8', $s1);
        $s = $s2 == $str ? $s1 : $str;
        $asc = ord($s{0}) * 256 + ord($s{1}) - 65536;
        if ($asc >= -20319 && $asc <= -20284)
            return 'A';
        if ($asc >= -20283 && $asc <= -19776)
            return 'B';
        if ($asc >= -19775 && $asc <= -19219)
            return 'C';
        if ($asc >= -19218 && $asc <= -18711)
            return 'D';
        if ($asc >= -18710 && $asc <= -18527)
            return 'E';
        if ($asc >= -18526 && $asc <= -18240)
            return 'F';
        if ($asc >= -18239 && $asc <= -17923)
            return 'G';
        if ($asc >= -17922 && $asc <= -17418)
            return 'H';
        if ($asc >= -17417 && $asc <= -16475)
            return 'J';
        if ($asc >= -16474 && $asc <= -16213)
            return 'K';
        if ($asc >= -16212 && $asc <= -15641)
            return 'L';
        if ($asc >= -15640 && $asc <= -15166)
            return 'M';
        if ($asc >= -15165 && $asc <= -14923)
            return 'N';
        if ($asc >= -14922 && $asc <= -14915)
            return 'O';
        if ($asc >= -14914 && $asc <= -14631)
            return 'P';
        if ($asc >= -14630 && $asc <= -14150)
            return 'Q';
        if ($asc >= -14149 && $asc <= -14091)
            return 'R';
        if ($asc >= -14090 && $asc <= -13319)
            return 'S';
        if ($asc >= -13318 && $asc <= -12839)
            return 'T';
        if ($asc >= -12838 && $asc <= -12557)
            return 'W';
        if ($asc >= -12556 && $asc <= -11848)
            return 'X';
        if ($asc >= -11847 && $asc <= -11056)
            return 'Y';
        if ($asc >= -11055 && $asc <= -10247)
            return 'Z';
        return null;
    }

    /**
     * 强制转换成数字
     * @param type $var
     * @return type
     */
    public static function numeric($var) {
        $return = 0;
        if (is_numeric($var) && $var > 0) {
            $return = intval($var);
        }
        return $return;
    }

    /**
     * 取得“是否”的数组
     * @param type $key
     * @return string
     */
    public static function getTrueOrFalse($key = '') {
        $return = array(
            '1' => '是',
            '0' => '否',
        );
        if (key_exists($key, $return)) {
            return $return[$key];
        }
        return $return;
    }

    /**
     * 取得“有无”的数组
     * @param type $key
     * @return string
     */
    public static function getIsHas($key = '') {
        $return = array(
            '1' => '有',
            '0' => '无',
        );
        if (key_exists($key, $return)) {
            return $return[$key];
        }
        return $return;
    }

    /**
     * 取得启用禁用数组
     * @param type $key
     * @return string
     */
    public static function getIfUse($key = '') {
        $return = array(
            '1' => '启用',
            '0' => '禁用',
        );
        if (key_exists($key, $return)) {
            return $return[$key];
        }
        return $return;
    }

    /**
     * 格式化时间
     * @param type $time
     * @param type $type
     * @return type
     */
    public static function formatDate($time, $type = 'Y-m-d H:i:s') {
        return date($type, $time);
    }

    public static function returnTrueOrFalse($int) {
        return $int ? true : false;
    }

    public static function getFirstError($errors) {
        $return = "";
        foreach ($errors as $k => $v) {
            $return = $v[0];
        }
        return $return;
    }

    /**
     * 发送短信
     * @param type $mobile
     * @param type $content
     * @return type 
     */
    public static function sendSms($mobile, $content) {
        $mobiles = is_array($mobile) ? $mobile : array(trim($mobile));
        $mode = '999';
        if ($mode == '999') {
            /**
             * 网关地址
             */
            $gwUrl = 'http://sdkhttp.eucp.b2m.cn/sdk/SDKService';
            /**
             * 序列号,请通过亿美销售人员获取
             */
            $serialNumber = '3SDK-EMY-0130-JIWUP';
            /**
             * 密码,请通过亿美销售人员获取
             */
            $password = '479803';
            $sessionKey = '123456';
        } else {
            $gwUrl = 'http://sdk4report.eucp.b2m.cn:8080/sdk/SDKService?wsdl';
            $serialNumber = '6SDK-EMY-6688-JGSTR';
            $password = '148457'; //148457
            $sessionKey = 'bc68d8259e8c5af';
        }
        /**
         * 登录后所持有的SESSION KEY，即可通过login方法时创建
         */
        /**
         * 连接超时时间，单位为秒
         */
        $connectTimeOut = 2;
        /**
         * 远程信息读取超时时间，单位为秒
         */
        $readTimeOut = 10;
        /**
         * $proxyhost       可选，代理服务器地址，默认为 false ,则不使用代理服务器
         * $proxyport       可选，代理服务器端口，默认为 false
         * $proxyusername   可选，代理服务器帐号，默认为 false
         * $proxypassword   可选，代理服务器密码，默认为 false
         */
        $proxyhost = false;
        $proxyport = false;
        $proxyusername = false;
        $proxypassword = false;
        $client = new MobileApi($gwUrl, $serialNumber, $password, $sessionKey, $proxyhost, $proxyport, $proxyusername, $proxypassword, $connectTimeOut, $readTimeOut);
        $rs = $client->sendSMS($mobiles, $content);
        //记录短信发送日志以便查询
        $model = new SmsLog();
        $model->mobile = $mobile;
        $model->content = $content;
        $model->statusCode = $rs;
        $model->created = time();
        if ($rs != null && $rs == 0) {
            //发送成功            
            $model->sms_status = 1;
        } else {
            $model->sms_status = 0;
        }
        $model->save();
        return Utils::formatReturn(1, '');
    }

    /**
     * 生成随机码 [0-9]/[aA-zZ]
     *
     * @param $num 验证码数量
     */
    public static function getVerifyCode($num = 4) {
        $vcode = '';
        for ($i = 0; $i < $num; $i += 1) {
            $hit = rand(0, 2);
            switch ($hit) {
                case 0 :
                    $ran_code = rand(48, 57);
                    break; // 数字
                case 1 :
                    $ran_code = rand(65, 90);
                    break; // 大写字母
                case 2 :
                    $ran_code = rand(97, 122);
                    break; // 小写字母
            }
            $ran_code = sprintf("%c", $ran_code);
            $vcode = $vcode . $ran_code;
        }
        $vcode = strtolower($vcode);
        return $vcode;
    }

    /**
     * 格式化价格
     * @param type $price
     * @return type
     */
    public static function formatPrice($price) {
        $price_format = number_format($price, 2, '.', '');
        return $price_format;
    }

    /**
     * 取无限级分类
     * @param type $cate
     * @param type $pid
     * @param type $html
     * @param type $level
     * @return type
     */
    public static $top_id = 0;

    public static function getUnLimitClass($cate, $pid = 0, $html = '　　', $level = 0) {
        $arr = array();
        foreach ($cate as $v) {
            if ($v['pid'] == $pid) {
                self::$top_id = $pid == 0 ? $v['id'] : self::$top_id;
                $v['html'] = str_repeat($html, $level);
                $v['level'] = $level + 1;
                $v['top_id'] = self::$top_id;
                $arr[] = $v;
                $arr = array_merge($arr, self::getUnLimitClass($cate, $v['id'], $html, $level + 1));
            }
        }
        return $arr;
    }

    public static function getOrderSn() {
        return date('YmdHi') . rand(10000, 99999);
    }

    public static function cookie($name, $value = NULL, $expired = 3600, $domain = "", $path = "") {
        if ($expired <= 0) { //删除值
            $cookie = Yii::app()->request->getCookies();
            unset($cookie[$name]);
            return true;
        } elseif ($value === NULL) { //取值
            $cookie = Yii::app()->request->getCookies();
            return $cookie[$name]->value;
        } else { //设值
            $cookie = new CHttpCookie($name, $value);
            $cookie->expire = time() + $expired;  //有限期30天
            Yii::app()->request->cookies[$value] = $cookie;
            return true;
        }
    }

    /**
     * 计算两个日期相差几天
     * @param type $date1
     * @param type $date2
     * @return type
     */
    public static function dateDiff($date1, $date2) {
        if (strpos($date1, '-')) {
            $date1 = strtotime($date1);
        }
        if (strpos($date2, '-')) {
            $date2 = strtotime($date2);
        }
        $days = round((abs($date2 - $date1)) / 3600 / 24);
        return $days;
    }

    public static function curl_post($url, $data, $https = FALSE) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1); //模拟POST
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data); //POST内容
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        $outopt = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Errno' . curl_error($ch);
        }
        curl_close($ch);
        return $outopt;
    }

    public static function curl($url, $data = array(), $type = 'get') {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if ($type == 'post') {
            $req = http_build_query($data);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
        } else {
            if (!empty($data)) {
                $url = $url . '?' . http_build_query($data);
            }
            curl_setopt($ch, CURLOPT_URL, $url);
        }
        if (substr($url, 0, 5) == 'https') {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        }
        $res = curl_exec($ch);
        curl_close($ch);
        return $res;
    }

    public static function log($msg, $file = "", $is_var_export = true) {
        if (!$file) {
            $file = Yii::app()->basePath . '/runtime/log.log';
        }
        if ($is_var_export) {
            $msg = var_export($msg, true);
        }
        file_put_contents($file, $msg . PHP_EOL, FILE_APPEND);
    }

    /**
     * 获取订单数量信息--待送气和待完成的
     */
    public function getOrderCount($store_id = '', $type = '') {
        //待送气订单
        $criteria = new CDbCriteria();
        $criteria->addCondition("status = 0 or status = 1");
        $criteria->addCondition("refund_status = 0");
        if (!empty($store_id) || $type != '') {
            $store_id = !is_array($store_id) ? array($store_id) : $store_id;
            $criteria->addInCondition("store_id", $store_id);
        }

        $order_going = Order::model()->findAll($criteria);
        //待完成订单
        $criteria_f = new CDbCriteria();
        $criteria_f->addCondition("status = 10 ");
        $criteria_f->addCondition("refund_status = 0");
        if (!empty($store_id) || $type != '') {
            $store_id = !is_array($store_id) ? array($store_id) : $store_id;
            $criteria_f->addInCondition("store_id", $store_id);
        }
        $order_finish = Order::model()->findAll($criteria_f);
        return array('going_count' => count($order_going), 'finish_count' => count($order_finish));
    }

    /**
     * 记录两个经纬度的距离
     * @param type $lat_a
     * @param type $lng_a
     * @param type $lat_b
     * @param type $lng_b
     * @return type
     */
    public static function getDistance($lat_a, $lng_a, $lat_b, $lng_b) {
        //R是地球半径（米）
        $R = 6366000;
        $pk = doubleval(180 / 3.14169);

        $a1 = doubleval($lat_a / $pk);
        $a2 = doubleval($lng_a / $pk);
        $b1 = doubleval($lat_b / $pk);
        $b2 = doubleval($lng_b / $pk);

        $t1 = doubleval(cos($a1) * cos($a2) * cos($b1) * cos($b2));
        $t2 = doubleval(cos($a1) * sin($a2) * cos($b1) * sin($b2));
        $t3 = doubleval(sin($a1) * sin($b1));
        $tt = doubleval(acos($t1 + $t2 + $t3));

        return round($R * $tt);
    }

    /**
     * 获取汉字的首字母
     * @param type $str
     * @return string
     */
    public static function getFirstCharter($str) {
        if (empty($str)) {
            return '';
        }
        $fchar = ord($str{0});
        if ($fchar >= ord('A') && $fchar <= ord('z'))
            return strtoupper($str{0});
        $s1 = iconv('UTF-8', 'gb2312', $str);
        $s2 = iconv('gb2312', 'UTF-8', $s1);
        $s = $s2 == $str ? $s1 : $str;
        $asc = ord($s{0}) * 256 + ord($s{1}) - 65536;
        if ($asc >= -20319 && $asc <= -20284)
            return 'A';
        if ($asc >= -20283 && $asc <= -19776)
            return 'B';
        if ($asc >= -19775 && $asc <= -19219)
            return 'C';
        if ($asc >= -19218 && $asc <= -18711)
            return 'D';
        if ($asc >= -18710 && $asc <= -18527)
            return 'E';
        if ($asc >= -18526 && $asc <= -18240)
            return 'F';
        if ($asc >= -18239 && $asc <= -17923)
            return 'G';
        if ($asc >= -17922 && $asc <= -17418)
            return 'H';
        if ($asc >= -17417 && $asc <= -16475)
            return 'J';
        if ($asc >= -16474 && $asc <= -16213)
            return 'K';
        if ($asc >= -16212 && $asc <= -15641)
            return 'L';
        if ($asc >= -15640 && $asc <= -15166)
            return 'M';
        if ($asc >= -15165 && $asc <= -14923)
            return 'N';
        if ($asc >= -14922 && $asc <= -14915)
            return 'O';
        if ($asc >= -14914 && $asc <= -14631)
            return 'P';
        if ($asc >= -14630 && $asc <= -14150)
            return 'Q';
        if ($asc >= -14149 && $asc <= -14091)
            return 'R';
        if ($asc >= -14090 && $asc <= -13319)
            return 'S';
        if ($asc >= -13318 && $asc <= -12839)
            return 'T';
        if ($asc >= -12838 && $asc <= -12557)
            return 'W';
        if ($asc >= -12556 && $asc <= -11848)
            return 'X';
        if ($asc >= -11847 && $asc <= -11056)
            return 'Y';
        if ($asc >= -11055 && $asc <= -10247)
            return 'Z';
        return null;
    }

    public static function getArticleImageUrl($img, $cate_id = 0) {
        $defualt_img = "/static/wechat/images/pic2.jpg";
        $base_path = Yii::app()->basePath;
        if (!$img) {
            return $defualt_img;
        }
        if (strstr($img, '/upload') || strstr($img, '/promote')) {
            if (is_file($base_path . '/../www/' . $img)) {
                return $img;
            } else {
                return $defualt_img;
            }
        }
        if (is_file($base_path . "/../www/promote/images/article/wgg/{$cate_id}/{$img}")) {
            return "/promote/images/article/wgg/{$cate_id}/{$img}";
        } elseif (is_file($base_path . "/../www/promote/images/article/wechat/{$img}")) {
            return "/promote/images/article/wechat/{$img}";
        } else {
            return "/static/wechat/images/pic2.jpg";
        }
    }

    /**
     * 价格格式化
     *
     * @param int   $price
     * @return string   $price_format
     */
    public static function ncPriceFormat($price, $point = 2) {
        $price_format = number_format(floatval($price), $point, '.', '');
        return $price_format;
    }

    /**
     * @desc 发送邮件
     * @param string $to 收件人
     * @param string $title 邮件标题
     * @param string $content 邮件内容
     * @return boolean $return
     * @author wg
     */
    public static function sendMail($to, $title, $content) {
        //发邮件
        $email = new Email();
        $email_params = Yii::app()->params['email'];
        $email->set('email_server', $email_params['email_server']);
        $email->set('email_port', $email_params['email_port']);
        $email->set('email_user', $email_params['email_user']);
        $email->set('email_password', $email_params['email_password']);
        $email->set('email_from', $email_params['email_from']);
        $email->set('site_name', $email_params['site_name']);
        $rs = $email->send($to, $title, $content);
        $msg = $email->getErrMsg();
        return Utils::formatReturn($rs, $msg);
    }

    public static function getImageName($img) {
        if (!$img) {
            return "";
        }
        $img = substr($img, strrpos($img, '/') + 1);
        $img = substr($img, 0, strrpos($img, '.'));
        return $img;
    }

    public static function getImageUrl($img, $thumb = '', $is_domain = true) {
        if (!$img) {
            return "";
        }
        $domain = Yii::app()->request->hostInfo;
        if ($thumb) {
            $img_left = substr($img, 0, strrpos($img, '.'));
            $img_right = substr($img, strrpos($img, '.'));
            if (strrpos($img, '_')) {
                $img_left = substr($img_left, 0, strrpos($img, '_'));
            }
            $return = $img_left . '_' . $thumb . $img_right;
            $is_domain && $return = $domain . $return;
            return $return;
        } else {
            $is_domain && $return = $domain . $return;
            return $return;
        }
    }

    public static function getImageNameNotExt($img) {
        if (!$img)
            return "";
        $img = substr($img, 0, strrpos($img, '.'));
        $img = substr($img, strrpos($img, '/') + 1);
        return $img;
    }

    public static function printr($data, $is_exit = true) {
        header("Content-type:text/html;charset=utf-8");
        echo "<pre>";
        print_r($data);
        echo "</pre>";
        $is_exit && exit;
    }

    // 远程请求（不获取内容）函数
    public static function sock_request($url) {
        $host = parse_url($url, PHP_URL_HOST);
        $port = parse_url($url, PHP_URL_PORT);
        $port = $port ? $port : 80;
        $scheme = parse_url($url, PHP_URL_SCHEME);
        $path = parse_url($url, PHP_URL_PATH);
        $query = parse_url($url, PHP_URL_QUERY);
        if ($query)
            $path .= '?' . $query;
        if ($scheme == 'https') {
            $host = 'ssl://' . $host;
        }
        $error_code = 0;
        $error_msg = "";
        $fp = fsockopen($host, $port, $error_code, $error_msg, 1);
        if (!$fp) {
            $error_code = 1;
            $error_msg = "远程错误";
            return array('error_code' => $error_code, 'error_msg' => $error_msg);
        } else {
            stream_set_blocking($fp, true); //开启了手册上说的非阻塞模式
            stream_set_timeout($fp, 1); //设置超时
            $header = "GET $path HTTP/1.1\r\n";
            $header.="Host: $host\r\n";
            $header.="Connection: close\r\n\r\n"; //长连接关闭
            fwrite($fp, $header);
            usleep(1000); // 这一句也是关键，如果没有这延时，可能在nginx服务器上就无法执行成功
            fclose($fp);
            return array('error_code' => 0);
        }
    }

    /**
     * 将二维数组的某个值如id的值作为上级数组的key
     * @param type $items
     * @param type $key
     * @return type
     */
    public static function getSubColumnValueToParentKey($items, $key) {
        return array_combine(array_column($items, $key), $items);
    }

    /**
     * 取无限级
     */
    public static function getSubUnlimit($model) {
        $items = self::getSubColumnValueToParentKey(self::object2array($model), 'id');
        $tree = array();
        foreach ($items as $item) {
            if (isset($items[$item['pid']])) {
                $items[$item['pid']]['sub'][$item['id']] = &$items[$item['id']];
            } else {
                $tree[$item['id']] = &$items[$item['id']];
            }
        }
        return $tree;
    }

    /**
     * 获取网站访问者信息
     */
    public static function getNapsBot() {
        $useragent = strtolower($_SERVER['HTTP_USER_AGENT']);
        if (strpos($useragent, 'googlebot') !== false) {
            return 'google';
        }
        if (strpos($useragent, 'baiduspider') !== false) {
            return 'baidu';
        }
        if (strpos($useragent, 'msnbot') !== false) {
            return 'bing';
        }
        if (strpos($useragent, 'slurp') !== false) {
            return 'yahoo';
        }
        if (strpos($useragent, 'sosospider') !== false) {
            return 'soso';
        }
        if (strpos($useragent, 'sogou spider') !== false) {
            return 'sogou';
        }
        if (strpos($useragent, 'yodaobot') !== false) {
            return 'yodao';
        }
        return NULL;
    }

    /**
     * 将gb2312转换成utf-8格式之后，每个中文的字节数从2个增加到3个之后导致了反序列化的时候判断字符长度出现了问题，所以需要使用正则表达式将序列化的数组中的表示字符长度的值重新计算一遍
     * @param type $serial_str
     * @return type
     */
    public static function mb_unserialize($serial_str) {
        $serial_str = preg_replace_callback('!s:(\d+):"(.*?)";!s', create_function('$math', "return 's:'.strlen(\$math[2]).':\"'.\$math[2].'\";';"), $serial_str);
        return unserialize($serial_str);
    }

}
