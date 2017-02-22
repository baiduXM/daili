<?php

session_start();
# 屏蔽警告提示错误
//error_reporting(7);
//set_magic_quotes_runtime(0);
//ini_set('display_errors', 1);

//定义网站根目录物理路径
define('DocumentRoot', dirname(__FILE__));

define('SYSTEM_ROOTPATH', dirname(__FILE__));
//加载ExpressPHP
require DocumentRoot . '/ExpressPHP/ExpressPHP.php';
require DocumentRoot . '/Include/global.functions.php';
require DocumentRoot . '/Include/LogsFunction.php';

//加载配置参数
include DocumentRoot . '/Data/Config/Config.php';

//创建数据库连接对像
class DB extends ExpressPHP_MYSQL {

    public function __Config($option = null) {
        global $function_config;
        global $db_config;
        if ($option)
            return $option;
        else
            return $db_config;
    }

}

class Sessions extends ExpressPHP_SESSIONS {

    protected function __Config() {
        global $session_config;
        return $session_config;
    }

}

//创建服务器页面缓存类
class CacheFile extends ExpressPHP_CACHE_FILE {

    protected function __Config($path = null) {
        global $cache_config;
        if ($path)
            $cache_config['SavePath'] = DocumentRoot . $path;
        return $cache_config;
    }

}

//创建视图对像
class ForeVIEWS extends ExpressPHP_VIEWER {

    protected function __Config() {
        return array(
            'charset' => 'utf-8',
            'timezone_set' => 'Asia/Shanghai',
            'DocumentRoot' => DocumentRoot,
            'TemplatePath' => '/Templates',
            'ViewerEngine' => 'PHP'
        );
    }

}

//创建控制器接口
class ForeAPPS extends ExpressPHP_Application {

    protected function __Config() {
        return array(
            'DocumentRoot' => DocumentRoot,
            'ViewPath' => '/ForeApps',
            'DefaultClass' => 'Home',
            'DefaultView' => 'Index'
        );
    }

}

//创建接口视图对象
class InterfaceVIEWS extends ExpressPHP_VIEWER {

    protected function __Config() {
        return array(
            'charset' => 'utf-8',
            'timezone_set' => 'Asia/Shanghai',
            'DocumentRoot' => DocumentRoot,
            'ViewerEngine' => 'Json'
        );
    }

}

//创建控制器接口
class InterfaceApps extends ExpressPHP_Application {
    
    protected function __Config() {
        return array(
            'DocumentRoot' => DocumentRoot,
            'ViewPath' => '/InterfaceApps',
            'DefaultClass' => 'Gbaopen',
            'DefaultView' => 'Index',
            'DefaultViewerEngine' => 'Json'
        );
    }
}
?>