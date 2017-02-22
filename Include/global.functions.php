<?php

function Utf8ToGBK($string) {
    return mb_convert_encoding($string, 'GBK', 'UTF-8');
}

function FilterIllegalString($string, $reString = '*') {
    $IllegalStrings = __GlobalParameters('IllegalString');
    if (!$IllegalStrings) {
        return $string;
    }
    $arrIllegalStrings = explode(',', $IllegalStrings);
    return str_replace($arrIllegalStrings, $reString, $string);
}

function rn2br($string) {
    return str_replace("\n", "<br>", $string);
}

function textarea_hacker($string, $newwidth = "90%") {
    $string = str_replace("\n", "<br>", $string);
    if ($newwidth) {
        $string = preg_replace("/(<table|<tr|<td|<th)\s(.*)(width=)(|\"|'|\\\")(\d+)(|px|\%)(|\"|'|\\\")\s/U", "\\1 \\2\\3\"{$newwidth}\"", $string);
    }
    return $string;
}

function FilterRepeatString($string, $max_time = 3, $max_len = 2, $charset = 'UTF-8') {
    $length = mb_strlen($string, $charset);
    $history_char = '';
    $time = 0;
    for ($l = 1; $l <= $max_len; $l ++) {
        for ($i = 0; $i < $length; $i += $l) {
            $char = mb_substr($string, $i, $l, $charset);
            if ($history_char == $char)
                $time ++;
            else
                $time = 1;
            $history_char = $char;
            if ($time >= $max_time) {
                $repeat_chars [$char] = $time;
            }
        }
        if ($repeat_chars) {
            foreach ($repeat_chars as $char => $time) {
                $string = str_replace(str_repeat($char, $time), $char, $string);
            }
        }
    }
    return $string;
}

function ip($ip) {
    return preg_replace("/(\d+).(\d+).(\d+).(\d+)$/", "$1.$2.$3.*", $ip);
}

function HtmlHeaderSetting($PageTitle, $PageKeywords = null, $PageDescription = null) {
    return array('PageTitle' => $PageTitle, 'PageKeywords' => $PageKeywords, 'PageDescription' => $PageDescription);
}

/**
 * 提取指定的网址或域名的二级或三级域名的域名
 * 例 : http://leslie.lesliex.com 得到 leslie
 * @param String $URL
 * @return String
 */
function GetSubDomain($URL) {
    $SubDomain = null;
    if (preg_match('@^(?:http://)?([^/]+)@i', $URL, $matches)) {
        $Host = $matches [1];
        if (preg_match('/[^.]+\.[^.]+$/', $Host, $matches)) {
            $TopDomain = $matches [0];
            $SubDomain = substr($Host, 0, (strlen($Host) - strlen($TopDomain)));
            if (substr($SubDomain, - 1) == '.') {
                $SubDomain = substr($SubDomain, 0, - 1);
            }
            if (strtolower($SubDomain) == 'www') {
                $SubDomain = null;
            }
        }
    }
    return $SubDomain;
}

function GetMainDomain() {
    $domains = explode('.', $_SERVER ['HTTP_HOST']);
    $counts = count($domains);
    for ($i = 1; $i < $counts; $i ++) {
        $newdomain .= '.' . $domains [$i];
    }
    return $newdomain;
}

function GetDomain($subdomains) {
    return $subdomains . GetMainDomain();
}

function UrlRewrite($module, $action, $parameters = array(), $rand = false) {
    global $URL_REWRITE;
    if ($URL_REWRITE) {
        $NewUrl = '/' . $module . '/' . $action;
        if (count($parameters)) {
            foreach ($parameters as $key => $value) {
                $NewUrl .= '/' . $key . '/' . $value;
            }
        }
        $NewUrl .= '.htm';
        if ($rand)
            $NewUrl .= '?r=' . mt_rand();
        return $NewUrl;
    } else {
        if (count($parameters)) {
            foreach ($parameters as $key => $value) {
                $QueryString .= '&' . $key . '=' . urlencode($value);
            }
        }
        return '?module=' . $module . '&action=' . $action . $QueryString . ($rand ? '&r=' . mt_rand() : "");
    }
}

function UrlRewriteSimple($module, $action, $rand = false) {
    global $URL_REWRITE;
    if ($URL_REWRITE) {
        $NewUrl = '/' . $module . '/' . $action;
        $NewUrl .= '.htm';
        if ($rand)
            $NewUrl .= '?r=' . mt_rand();
        return $NewUrl;
    } else {
        return '?module=' . $module . '&action=' . $action . ($rand ? '&r=' . mt_rand() : "");
    }
}

function _strip_tags($string, $allowable_tags = null) {
    if (is_array($string)) {
        foreach ($string as $key => $value) {
            $string [$key] = _strip_tags($value, $allowable_tags);
        }
        return $string;
    } else
        return strip_tags($string, $allowable_tags);
}

function substring($String, $BeginString, $EndString = null) {
    $Start = strpos($String, $BeginString);
    if ($Start === false)
        return null;
    $Start += strlen($BeginString);
    $String = substr($String, $Start);
    if (!$EndString)
        return $String;
    $End = strpos($String, $EndString);
    if ($End == false)
        return null;
    return substr($String, 0, $End);
}

function JsonMessage($code, $message = null, $data = null, $ExtData = null) {
    $TmpJson = array('Code' => $code, 'Message' => $message, 'Data' => $data);
    if ($ExtData && is_array($ExtData)) {
        foreach ($ExtData as $key => $value) {
            $TmpJson [$key] = $value;
        }
    }
    return json_encode($TmpJson);
}

function string_implode() {
    $numargs = func_num_args();
    if ($numargs <= 1)
        return '';
    $arg_list = func_get_args();
    for ($i = 0; $i < $numargs; $i ++) {
        if ($i == 0)
            $glue = $arg_list [$i];
        else
            $string .= ($string ? $glue : '') . $arg_list [$i];
    }
    return $string;
}

function _IsEmail($email) {
    return strlen($email) > 6 && preg_match("/^[\w\-\.]+@[\w\-]+(\.\w+)+$/", $email);
}

function word_encode_gbk($word) {
    $word = urlencode(iconv('utf-8', 'gbk', $word));
    return $word;
}

function _file_get_contents_by_url($url, $timeout = 0) {
    if ($timeout) {
        $ctx = stream_context_create(array('http' => array('timeout' => $timeout)));
        return file_get_contents($url, 0, $ctx);
    } else {
        return file_get_contents($url);
    }
}

function Array2_Unique($arrData) {
    foreach ($arrData as $id => $value) {
        if (!$arrTmpAllData) {
            $arrTmpAllData = $value;
        } else {
            $arrData [$id] = array_diff($value, $arrTmpAllData);
            $arrTmpAllData = array_merge($arrTmpAllData, $arrData [$id]);
        }
    }
    unset($arrTmpAllData);
    return $arrData;
}

function _intval($number, $unsigned = false) {
    $number = trim($number);
    if (strlen($number) < 1) {
        return 0;
    }
    if (is_numeric($number)) {
        if ($unsigned) {
            if ($number >= 0)
                return $number;
            else
                return 0;
        } else {
            return $number;
        }
    } else
        return 0;
}

function _ip2long($strIP) {
    $lngIP = ip2long($strIP);
    if ($lngIP == - 1)
        return false;
    else
        return sprintf("%u", $lngIP);
}

function _crc32($string) {
    return sprintf("%u", crc32($string));
}

function ImageFix($string, $width, $height) {
    return preg_replace("/[\n\r\t]*<img ([^>]+)>[\n\r\t]*/is", "<img \\1 onload=\"ImageFix(this," . $width . ", " . $height . ")\">", $string);
}

function _long2ip($intIP) {
    return long2ip($intIP);
}

function IsRobot() {
    if (!defined('IS_ROBOT')) {
        $kw_spiders = 'Bot|Crawl|Spider|slurp|sohu-search|lycos|robozilla';
        $kw_browsers = 'MSIE|Netscape|Opera|Konqueror|Mozilla';
        if (preg_match("/($kw_browsers)/i", $_SERVER ['HTTP_USER_AGENT'])) {
            define('IS_ROBOT', FALSE);
        } elseif (preg_match("/($kw_spiders)/i", $_SERVER ['HTTP_USER_AGENT'])) {
            define('IS_ROBOT', TRUE);
        } else {
            define('IS_ROBOT', FALSE);
        }
    }
    return IS_ROBOT;
}

function _getenv($var_name) {
    if (isset($_SERVER [$var_name])) {
        return $_SERVER [$var_name];
    } elseif (isset($_ENV [$var_name])) {
        return $_ENV [$var_name];
    } elseif (getenv($var_name)) {
        return getenv($var_name);
    } elseif (function_exists('apache_getenv') && apache_getenv($var_name, true)) {
        return apache_getenv($var_name, true);
    }
    return '';
}

function getUsedMemory() {
    $memory_amount = memory_get_usage();
    return number_format($memory_amount / 1024, 2);
}

function getUsedTime() {
    global $thread_starttime;
    $mtime = explode(' ', microtime());
    $thread_endtime = ((float) $mtime [1] + (float) $mtime [0]);
    return number_format(($thread_endtime - $thread_starttime), 2);
}

function _addslashes($string, $force = 0) {
    !defined('MAGIC_QUOTES_GPC') && define('MAGIC_QUOTES_GPC', get_magic_quotes_gpc());
    if (!MAGIC_QUOTES_GPC || $force) {
        if (is_array($string)) {
            foreach ($string as $key => $val) {
                $string [$key] = _addslashes($val, $force);
            }
        } else {
            $string = addslashes($string);
        }
    }
    return $string;
}

function htmlencode($string, $clear_rn = false) {
    if (is_array($string)) {
        foreach ($string as $key => $val) {
            $string [$key] = htmlencode($val);
        }
    } else {
        if ($clear_rn) {
            $string = str_replace(array("\n", "\r"), array('', ''), $string);
        }
        $string = str_replace(array('&amp;', '&quot;', '&lt;', '&gt;', '&nbsp;'), array('&', '"', '<', '>', ' '), $string);
        $string = htmlentities(strip_tags($string), ENT_COMPAT, 'utf-8');
    }
    return $string;
}

function _checkdate($ymd, $sep = '-') {
    if (!empty($ymd)) {
        list ( $year, $month, $day ) = explode($sep, $ymd);
        return checkdate($month, $day, $year);
    } else {
        return FALSE;
    }
}

function _substr($string, $length, $dot = '...', $ClearHtml = true, $charset = 'utf-8') {
    if (mb_strlen($string) <= $length) {
        return $string;
    }
    if ($ClearHtml) {
        $string = str_replace(array('&amp;', '&quot;', '&lt;', '&gt;', '&nbsp;'), array('&', '"', '<', '>', ' '), $string);
        $string = strip_tags($string);
    }
    $string = preg_replace('/([\s]{2,})/', '', $string);
    $strcut = mb_substr($string, 0, $length, $charset);
    return $strcut . (strlen($string) > strlen($strcut) ? $dot : '');
}

function _cutstr($string, $length, $dot = ' ...', $htmlencode = true, $charset = 'utf-8') {
    if (strlen($string) <= $length) {
        return $string;
    }
    if ($htmlencode)
        $string = str_replace(array('&amp;', '&quot;', '&lt;', '&gt;'), array('&', '"', '<', '>'), $string);
    $strcut = '';
    if (strtolower($charset) == 'utf-8') {
        $n = $tn = $noc = 0;
        while ($n < strlen($string)) {
            $t = ord($string [$n]);
            if ($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
                $tn = 1;
                $n ++;
                $noc ++;
            } elseif (194 <= $t && $t <= 223) {
                $tn = 2;
                $n += 2;
                $noc += 2;
            } elseif (224 <= $t && $t < 239) {
                $tn = 3;
                $n += 3;
                $noc += 2;
            } elseif (240 <= $t && $t <= 247) {
                $tn = 4;
                $n += 4;
                $noc += 2;
            } elseif (248 <= $t && $t <= 251) {
                $tn = 5;
                $n += 5;
                $noc += 2;
            } elseif ($t == 252 || $t == 253) {
                $tn = 6;
                $n += 6;
                $noc += 2;
            } else {
                $n ++;
            }
            if ($noc >= $length) {
                break;
            }
        }
        if ($noc > $length) {
            $n -= $tn;
        }
        $strcut = substr($string, 0, $n);
    } else {
        for ($i = 0; $i < $length; $i ++) {
            $strcut .= ord($string [$i]) > 127 ? $string [$i] . $string [++$i] : $string [$i];
        }
    }
    if ($htmlencode)
        $strcut = str_replace(array('&', '"', '<', '>'), array('&amp;', '&quot;', '&lt;', '&gt;'), $strcut);
    return $strcut . (strlen($string) > strlen($strcut) ? $dot : '');
}

function GetPaging(&$Page, &$PageCount, $RecordCount, $PageSize = 20, $PageListNumber = 10) {
    if ($RecordCount <= 0) {
        $Data ['RecordCount'] = 0;
        $Data ['Page'] = 1;
        $Data ['PageCount'] = 1;
        $Data ['Offset'] = 0;
        $Data ['Limit'] = 0;
        return $Data;
    }
    $Data ['RecordCount'] = $RecordCount;
    $Data ['PageCount'] = $PageCount = ceil($RecordCount / $PageSize);
    $Page = max(1, $Page);
    $Data ['Page'] = $Page;
    if ($Data ['Page'] <= $Data ['PageCount']) {
        $Data ['Offset'] = ($Page - 1) * $PageSize;
        $Data ['Limit'] = $PageSize;
    }
    if ($Data ['Page'] - 3 > 0)
        $Data ['FirstPage'] = 1;
    if ($Data ['Page'] - 1 > 0)
        $Data ['BackPage'] = $Data ['Page'] - 1;
    if ($Data ['Page'] < $Data ['PageCount'])
        $Data ['NextPage'] = ($Data ['Page'] + 1);
    if ($Data ['Page'] + $n < $Data ['PageCount'])
        $Data ['LastPage'] = $Data ['PageCount'];
    $PageListNumber = $PageListNumber - 1;
    $min = ($Data ['Page'] - 3) > 0 ? $Data ['Page'] - 3 : 1;
    $max = ($min + $PageListNumber) < $Data ['PageCount'] ? ($min + $PageListNumber) : $Data ['PageCount'];
    for ($i = $min; $i <= $max; $i ++) {
        $Data ['PageNums'] [$i] = $i;
    }
    return $Data;
}

function MultiPage(&$multipages, $n = 10) {
    if ($multipages ['Page'] - 3 > 0)
        $multipages ['FirstPage'] = 1;
    if ($multipages ['Page'] - 1 > 0)
        $multipages ['BackPage'] = $multipages ['Page'] - 1;
    if ($multipages ['Page'] < $multipages ['PageCount'])
        $multipages ['NextPage'] = ($multipages ['Page'] + 1);
    if ($multipages ['Page'] + $n < $multipages ['PageCount'])
        $multipages ['LastPage'] = $multipages ['PageCount'];
    $n = $n - 1;
    $min = ($multipages ['Page'] - 3) > 0 ? $multipages ['Page'] - 3 : 1;
    $max = ($min + $n) < $multipages ['PageCount'] ? ($min + $n) : $multipages ['PageCount'];
    for ($i = $min; $i <= $max; $i ++) {
        $multipages ['PageNums'] [$i] = $i;
    }
}

function Unicode10Char($ord) {
    if ($ord < 0x7F) { // 0000-007F
        $c .= chr($ord);
    } elseif ($ord < 0x800) { // 0080-0800
        $c .= chr(0xC0 | ($ord / 64));
        $c .= chr(0x80 | ($ord % 64));
    } else { // 0800-FFFF
        $c .= chr(0xE0 | (($ord / 64) / 64));
        $c .= chr(0x80 | (($ord / 64) % 64));
        $c .= chr(0x80 | ($ord % 64));
    }
    return $c;
}

function Unicode($string, $html_ntity_decode = false) {
    if (is_array($string)) {
        foreach ($string as $key => $value) {
            $string [$key] = Unicode($value);
        }
        return $string;
    } else {
        if (!$html_ntity_decode)
            return preg_replace("/(\&\#)(\d+)(;)/ies", "Unicode10Char(\\2)", $string);
        else
            return htmlspecialchars_decode(preg_replace("/(\&\#)(\d+)(;)/ies", "Unicode10Char(\\2)", $string));
    }
}

function ChineseToPinyin($string) {
    global $__pinyins__;
    $restring = '';
    $str = trim($string);
    $slen = strlen($string);
    if ($slen < 2)
        return $str;
    if (!$__pinyins__) {
        $fp = file(SYSTEM_ROOTPATH . '/data/pinyin.dat');
        foreach ($fp as $line) {
            $tmp = explode('`', $line);
            $__pinyins__ [$tmp [0]] = str_replace(array("\r", "\n"), array('', ''), $tmp [1]);
        }
        unset($fp);
    }
    $n = 0;
    while ($n < $slen) {
        $start = $n;
        $t = ord($string [$n]);
        if ($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
            $tn = 1;
        } elseif (194 <= $t && $t <= 223) {
            $tn = 2;
        } elseif (224 <= $t && $t < 239) {
            $tn = 3;
        } elseif (240 <= $t && $t <= 247) {
            $tn = 4;
        } elseif (248 <= $t && $t <= 251) {
            $tn = 5;
        } elseif ($t == 252 || $t == 253) {
            $tn = 6;
        } else {
            $tn = 1;
        }
        if ($tn > 1) {
            $substring = substr($string, $start, $tn);
            if ($__pinyins__ [$substring])
                $restring .= $__pinyins__ [$substring];
            else
                $restring .= '';
        } else
            $restring .= '';
        $n += $tn;
    }
    return $restring;
}

function JsMessage($message, $URL = 'HISTORY', $charset = 'utf-8') {
    echo '
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
        <meta http-equiv="Content-Type" content="text/html; charset=' . $charset . '" />
        <title>系统提示</title>
        </head>
        <body>
        <script type="text/javascript">
        alert("' . $message . '");
        ' . (strtoupper($URL) == 'HISTORY' ? 'history.back();' : 'location.href="' . $URL . '";') . '
        </script>
        </body>
        </html>		
    ';
    exit();
}

function _mkdir($dir) {
    if (file_exists($dir))
        return true;
    $u = umask(0);
    $r = @mkdir($dir, 0777);
    umask($u);
    return $r;
}

function _mkdirs($dir, $rootpath = '.') {
    if (!$rootpath)
        return false;
    if ($rootpath == '.')
        $rootpath = realpath($rootpath);
    $forlder = explode('/', $dir);
    $path = '';
    for ($i = 0; $i < count($forlder); $i ++) {
        if ($current_dir = trim($forlder [$i])) {
            if ($current_dir == '.')
                continue;
            $path .= '/' . $current_dir;
            if ($current_dir == '..') {
                continue;
            }
            if (file_exists($rootpath . $path)) {
                @chmod($rootpath . $path, 0777);
            } else {
                if (!_mkdir($rootpath . $path)) {
                    return false;
                }
            }
        }
    }
    return true;
}

/* 获取IP地址 */
function GetIP() {
    if (getenv('HTTP_CLIENT_IP')) {
        $ip = getenv('HTTP_CLIENT_IP');
    } elseif (getenv('HTTP_X_FORWARDED_FOR')) { //获取客户端用代理服务器访问时的真实ip 地址
        $ip = getenv('HTTP_X_FORWARDED_FOR');
    } elseif (getenv('HTTP_X_FORWARDED')) {
        $ip = getenv('HTTP_X_FORWARDED');
    } elseif (getenv('HTTP_FORWARDED_FOR')) {
        $ip = getenv('HTTP_FORWARDED_FOR');
    } elseif (getenv('HTTP_FORWARDED')) {
        $ip = getenv('HTTP_FORWARDED');
    } else {
        $ip = $_SERVER ['REMOTE_ADDR'];
    }
    return $ip;
}

/* 模拟POST */
function ToPost($PostUrl, $PostArray = array()) {
    foreach ($PostArray as $Key => $Value) {
        $PostString .= $Key . '=' . $Value . '&';
    }
    $PostString = substr($PostString, 0, - 1);
    $Context = array('http' => array('method' => 'POST', 'header' => 'Content-type: application/x-www-form-urlencoded' . '\r\n' . 'User-Agent : Jimmy\'s POST Example beta' . '\r\n' . 'Content-length:' . strlen($PostString) + 8, 'content' => $PostString));
    $StreamContext = stream_context_create($Context);
    return @file_get_contents($PostUrl, false, $StreamContext);
}

function PostInfo($PostUrl, $PostString) {
    $Context = array('http' => array('method' => 'POST', 'header' => 'Content-type: application/x-www-form-urlencoded' . '\r\n' . 'User-Agent : Jimmy\'s POST Example beta' . '\r\n' . 'Content-length:' . strlen($PostString) + 8, 'content' => $PostString));
    $StreamContext = stream_context_create($Context);
    $Data = @file_get_contents($PostUrl, false, $StreamContext);
    return $Data;
}

/* 判断登陆状态 */

function IsLogin($json = false) {
    if (!$_SESSION ['AgentID'] || !$_SESSION ['UserName'] || !$_SESSION ['Level']) {
        if($json){
            $result = array('err'=>2000, 'data'=>0, 'msg'=>'登入超时，请重新登入');
            echo jsonp($result);
            exit();
        }else{
            JsMessage("您还未登陆，请重新登陆!", '/');
        }
    }
}

function GetReturnInfo($ReturnShouJiCX = '') {
    $ReturnShouJiCXArray = explode('&', $ReturnShouJiCX);
    $ReturnShouJiCXInfo = array();
    foreach ($ReturnShouJiCXArray As $Key => $Value) {
        $ValueSTring = explode('=', $Value);
        $ReturnShouJiCXInfo[$ValueSTring[0]] = $ValueSTring[1];
    }
    unset($ReturnShouJiCXArray);
    return $ReturnShouJiCXInfo;
}

//生成随机数
function getstr() {
    $time = rand(6, 12);
    $lockstream = 'stlDEFABCNOPyzghijQRSTUwxkVWXYZabcdefIJK67nopqr89LMmGH012345uv';
    //随机找一个数字，并从密锁串中找到一个密锁值
    $lockLen = strlen($lockstream);
    $randomLock = '';
    for ($i = 1; $i <= $time; $i++) {
        $lockCount = rand(0, $lockLen - 1);
        $randomLock .= $lockstream[$lockCount];
    }
    return $randomLock;
}

function request_by_other($remote_server, $post_string) {
    $context = array(
        'http' => array(
            'method' => 'POST',
            'header' => 'content-type:application/x-www-form-urlencoded' .
            '\r\n' . 'User-Agent : Jimmy\'s POST Example beta' .
            '\r\n' . 'Content-length:' . strlen($post_string) + 11,
            'content' => $post_string
        )
    );
    $stream_context = stream_context_create($context);
    $data = file_get_contents($remote_server, false, $stream_context);
    return $data;
}

//删除文件夹
function deldir($dir) {
    //先删除目录下的文件：
    $dh = opendir($dir);
    while ($file = readdir($dh)) {
        if ($file != "." && $file != "..") {
            $fullpath = $dir . "/" . $file;
            if (!is_dir($fullpath)) {
                unlink($fullpath);
            } else {
                deldir($fullpath);
            }
        }
    }
    closedir($dh);
    //删除当前文件夹：
    if (rmdir($dir)) {
        return true;
    } else {
        return false;
    }
}

/** php 发送流文件 
 * @param  String  $url  接收的路径 
 * @param  String  $file 要发送的文件 
 * @return boolean 
 */
function sendStreamFile($url, $file) {
    if (file_exists($file)) {
        $ch = curl_init();
        //加@符号curl就会把它当成是文件上传处理
        $data = array('file' => '@' . realpath($file));
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    } else {
        return false;
    }
}

//计算两个日期相差的月份，时间格式：年月日，例如：2015-10-15  2015-12-15
function getMonthBetween($date1, $date2) {
    $time = strtotime($date1) - strtotime($date2);
    $date = $time / (60 * 60 * 24 * 30);

    if ($date > 0) {
        $date--;
    }
    return $date;
}

function dd($x, $showtype = '') {
    echo '<pre>';
    if ($showtype != '') {
        var_dump($x);
    } else {
        $type = gettype($x);
        if ($type == 'array') {
            print_r($x);
        } else {
            echo $x;
        }
    }
    echo '</pre>';
    exit;
}

function jsonp($data, $type = '') {
    header('Content-type: application/json; charset=utf-8');
    $type = $type ? $type : 'JSON';
    if ($data) {
        // header('Content-type: application/json');
        if (strtoupper($type) == 'JSON') {
            return json_encode($data);
        } elseif (strtoupper($type) == 'JSONP') {
            $callback = $_GET['callback'];
            return $callback . "(" . json_encode($data) . ")";
        } else {
            // TODO 增加其它格式
        }
    } else {
        //错误后返回错误的操作状态和提示信息
        return json_encode(0, "新增错误！", 0);
    }
}

//获取代理商订单号
function GetOrderNO() {
    return date("YmdHis") . rand(100000, 999999);
}
