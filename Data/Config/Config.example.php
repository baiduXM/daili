<?php
/*接口信息*/
define('FENGXIN_DOMAIN','http://wx.dn160.com.cn/');
define('FENGXIN_MD5KEY', '@sdSW$5&125*');
define('GBAOPEN_DOMAIN','http://ht.5067.org/'); // 统一平台地址 http://ht.5067.org/
define('DAILI_DOMAIN','http://dl2.5067.org/'); // 代理平台 http://dl2.5067.org/
define('GUANWANG_DOMAIN','http://www.gbpen.com/'); // 官网地址 http://www.gbpen.com/
define('WEICD_DOMAIN','http://http://cd.5067.org/'); // 微传单 http://cd.5067.org/
//对外图片访问地址
define('IMG_DOMAIN','http://daili.example.com/'); // http://dl2.5067.org/
//对外图片保存路径
define('IMG_PICPUT','ImagerOut/');
/*产品ID*/
define('GBAOPEN_ID',1);
define('FENGXIN_ID',7);
define('TONGYI_ID',9);
/*权限定义*/
define('CUS_MODIFY',1);         //客户信息修改
define('CUS_CASE',2);           //客户案例推荐
define('CUS_RENEW',4);          //续费操作
define('CUS_PROCESS',8);	//网站处理
define('CUS_TRANSFER',16);	//客户转移
define('CUS_MANAGE',32);        //客户管理
define('CUS_CREATE',64);	//客户创建
define('CUS_DELETE',128);	//客户删除

$db_config = array (
	'host' => 'localhost', 
	'username' => 'root', 
	'password' => '', 
	'charset' => 'utf-8', 
	'pconnect' => true, 
	'dbname' => 'db_daili2' 
);
$cache_config = array (
	'SavePath' => DocumentRoot . '/Data/FileCache', 
	'HashLevel' => 2 
);
$session_config = array (
	'domains' => '', 
	'path' => '/', 
	'expiretime' => 120000, 
	'hashcode' => '1a2b3y4t', 
	'prefix' => 'Leslie_1900_' 
);

$system_config = array (
	'timezone_set' => 'Asia/Shanghai', 
	'captcha_hashcode' => '@2014 12t.cn', 
	'captcha_interval' => 10 
);

$function_config = array(
    'renew'=>CUS_RENEW,
    'modify'=>CUS_MODIFY,
    'transfer'=>CUS_TRANSFER,
    'process'=>CUS_PROCESS,
    'case'=>CUS_CASE,
    'create'=>CUS_CREATE,
    'manage'=>CUS_MANAGE,
    'delete'=>CUS_DELETE,
);

