<?php
error_reporting ( 7 );
set_magic_quotes_runtime ( 0 );
define ( 'SYSTEM_ROOTPATH', substr ( dirname ( __FILE__ ), 0, - 8 ) ); //定义根目录
$config = array ('DebugMode' => true, 'charset' => 'utf-8', 'timezone_default' => 'Asia/Shanghai' );
if (! $HeaderCharset) {
	header ( 'Content-Type: text/html; charset=' . $config ['charset'] );
}
$templates_cfg = array ('templates_dir' => '/templates', 'templates_compiled_dir' => '/templats_c/website', 'realrootpath' => SYSTEM_ROOTPATH, 'template_file_ext' => '.htm', 'template_compiled_file_ext' => '.tpl.php', 'templates_default_dir' => null );

if ($config ['DebugMode']) {
	ini_set ( 'display_errors', 1 );
} //启用日志
include SYSTEM_ROOTPATH . '/include/template.functions.php'; //模版编译类
include SYSTEM_ROOTPATH . '/include/global.functions.php'; //常用函数
include SYSTEM_ROOTPATH . '/include/class.databasedriver_mysql.php'; //数据库类
include SYSTEM_ROOTPATH . '/include/database_config.php'; //数据库连接
include SYSTEM_ROOTPATH . '/include/template.php'; //分页函数
include SYSTEM_ROOTPATH . '/include/get_weather.php'; //采集天气
include SYSTEM_ROOTPATH . '/include/hot_city.php'; //采集天气

include SYSTEM_ROOTPATH . '/include/tq.php'; //天气网函数
//如果php版本大于5.1则使用北京时间（而不是系统默认的格林威治标准时间） 等同在php.ini的date.timezone语句前的;号去掉
if (PHP_VERSION > '5.1') {
	date_default_timezone_set ( $config ['timezone_default'] );
}
//get和post提交字符串处理
//if ($_GET)
//	$_GET = nl_addslashes ( $_GET );
//if ($_POST)
//	$_GET = nl_addslashes ( $_POST );

$_NL_DebugMode = $config ['DebugMode'];


//域名后面的地址
$SCRIPT_URL = $_SERVER ['REQUEST_URI'] ? $_SERVER ['REQUEST_URI'] : $_SERVER ['SCRIPT_NAME'] . ($_SERVER ['QUERY_STRING'] ? "?" . $_SERVER ['QUERY_STRING'] : '');
//域名（主机名）
$SCRIPT_HOST = $_SERVER ["HTTP_HOST"];
//页面地址
$REQUEST_URI = 'http://' . $SCRIPT_HOST . ($_SERVER ["SERVER_PORT"] == 80 ? '' : $_SERVER ["SERVER_PORT"]) . (isset ( $_SERVER ['REQUEST_URI'] ) ? $_SERVER ['REQUEST_URI'] : $_SERVER ['PHP_SELF'] . '?' . $_SERVER ['QUERY_STRING']);

/*if(strstr($SCRIPT_URL,"/weather.php?citypinyin=")){
$chenshi = str_replace ( "/weather.php?citypinyin=", "", $SCRIPT_URL );
header ( 'Location://tianqi/'.$chenshi.'.html' );
}
echo $REQUEST_URI;
if(strstr($REQUEST_URI,'/province/')){
	$ToUrl = str_replace("/province/","/",$REQUEST_URI);
	Header("HTTP/1.1 301 Moved Permanently");
	Header("Location: ".$ToUrl);
}
if(strstr($REQUEST_URI,'/news/')){
	Header("HTTP/1.1 301 Moved Permanently");
	Header("Location: http://".$SCRIPT_HOST."/404.html");
}
if(strstr($REQUEST_URI,'/city/')){
	echo $REQUEST_URI;exit;
	$ToUrl = str_replace("/city/","/weather/",$REQUEST_URI);
	Header("HTTP/1.1 301 Moved Permanently");
	Header("Location: ".$ToUrl);
}

/*
if($REQUEST_URI=='http://www.20tianqi.com/province/hunan/'){
	Header("HTTP/1.1 301 Moved Permanently");
	Header("Location: http://www.20tianqi.com/hunan/");
}
if($REQUEST_URI=='http://www.20tianqi.com/news/10821'){
	Header("HTTP/1.1 301 Moved Permanently");
	Header("Location: http://www.20tianqi.com/404.html");
}
if($REQUEST_URI=='http://20tianqi.com/city/bijie/'){
	Header("HTTP/1.1 301 Moved Permanently");
	Header("Location: http://20tianqi.com/weather/bijie/");
}
*/
//时间戳定义
$timestamp = time();
$timestamp = time();
$year=date("Y",$timestamp);
$month=date("m",$timestamp);
$day=date("d",$timestamp);

//初始化数据库连接类
$db = new DatabaseDriver_MySql ( $database_cfg );

$weekarray=array("日","一","二","三","四","五","六");
?>
