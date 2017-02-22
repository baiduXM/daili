<?php
# ExpressPHP 核心文件
# Team : Kyle Less(necylus@126.com)
error_reporting(7);
set_magic_quotes_runtime(0);

define('__ERROR__', 'Error');
define('__SUCC__', 'Succ');

# 定义网站根目录物理路径
define('__ExpressPHP_Path__', dirname(__FILE__));
define('__ExpressPHP_NOT__', false);
define('__ExpressPHP_YES__', true);
define('__ExpressPHP_NOTURL__','NOTURL');
define('__ExpressPHP_ViewEngine_None','None');
define('__ExpressPHP_ViewEngine_JSON','Json');
define('__ExpressPHP_ViewEngine_Template','Template');
define('__ExpressPHP_ViewEngine_PHP','PHP');
define('__ExpressPHP_HISTORY__','HISTORY');
define('__ExpressPHP_CONTINUE__','CONTINUE');

!defined('DocumentRoot') && define('DocumentRoot', substr(__ExpressPHP_Path__, 0, -11));

require __ExpressPHP_Path__ . '/core/class.ExpressPHP_Exception.php';
# 载入MYSQL类文件
require __ExpressPHP_Path__ . '/core/class.ExpressPHP_MYSQL.php';
# 载入视图解析类文件
require __ExpressPHP_Path__ . '/core/class.ExpressPHP_Template.php';
require __ExpressPHP_Path__ . '/core/class.ExpressPHP_VIEWER.php';

# 载入CACHE类文件
require __ExpressPHP_Path__ . '/core/class.ExpressPHP_CACHE.php';
# 载入SESSIONS类文件
require __ExpressPHP_Path__ . '/core/class.ExpressPHP_SESSIONS.php';

# 载入ExpressPHP类文件
require __ExpressPHP_Path__ . '/core/class.ExpressPHP_Application.php';

# 载入ExpressPHP辅助类及函数
require __ExpressPHP_Path__ . '/core/class.Request.php';
require __ExpressPHP_Path__ . '/functions/globalparameter.functions.php';

# 载入目录模型类文件
require __ExpressPHP_Path__ . '/class/class.HiberarchyModel.php';
require __ExpressPHP_Path__ . '/class/class.HiberarchyModel2.php';

if($_GET['ExpressPHP_Action'] == 'DataClear'){
	_ExpressPHP_Default_DIR_Clear();
}
function __autoload($class_name) {
    require_once DocumentRoot.'/Modules/class.'.$class_name . '.php';
}

function __ExpressPHP_GetViewsConfig($AppsPath, $Class, $Action) {
	$ClassFilePath = DocumentRoot . $AppsPath . '/class.' . $Class . '.php';
	$ViewConfig = $Action . 'Config';
	include_once $ClassFilePath;
	$ViewClass = new $Class();
	if(method_exists($Class, 'GlobalConfig')){
		$tmpConfig = $ViewClass->GlobalConfig();
		if($tmpConfig['GlobalConfig']){
			foreach($tmpConfig['GlobalConfig'] as $key => $value){
				$newView->Config[$key] = $value;
			}
			unset($key, $value);
		}
		if($tmpConfig[$ViewConfig]){
			foreach($tmpConfig[$ViewConfig] as $key => $value){
				$newView->Config[$key] = $value;
			}
			unset($key, $value);
		}
		unset($tmpConfig);
	}
	if(method_exists($Class, $ViewConfig)){
		$tmpConfig = $ViewClass->$ViewConfig();
		if(is_array($tmpConfig)){
			foreach($tmpConfig as $key => $value){
				$ViewClass->Config[$key] = $value;
			}
		}
		unset($tmpConfig);
	}
	$tmpConfig = $ViewClass->Config;
	unset($ViewClass);
	return $tmpConfig;
}
function _ExpressPHP_Default_DIR_Clear() {
	$paths = array( 
		'/data/ExpressPHP', 
		'/data/FileCache', 
		'/data/TemplatesCompiled', 
		'/data/Uploads', 
		'/data/ViewCache' 
	);
	foreach($paths as $path){
		_ExpressPHP_DIR_Clear($path);
	}
	return true;
}
function _ExpressPHP_Default_DIR_Check() {
	$paths = array( 
		'/data/ExpressPHP', 
		'/data/FileCache', 
		'/data/TemplatesCompiled', 
		'/data/Uploads', 
		'/data/ViewCache' 
	);
	foreach($paths as $path){
		if(_ExpressPHP_MKDIR($path)){
			$result[$path] = __SUCC__;
		}else{
			$result[$path] = __ERROR__;
		}
	}
	return $result;
}
function _ExpressPHP_DIR_Clear($path) {
	if(!defined("DocumentRoot")) return false;
	if($path && (substr($path, 0, 1) != '/')){
		$path = '/' . $path;
	}
	if(!file_exists(DocumentRoot . $path)) return false;
	$d = dir(DocumentRoot . $path);
	$wait_delete_dirs = array();
	while(false !== ($entry = $d->read())){
		if($entry != "." && $entry != ".."){
			if(is_dir(DocumentRoot . $path . '/' . $entry)){
				_ExpressPHP_DIR_Clear($path . '/' . $entry);
				$wait_delete_dirs[] = $path . '/' . $entry;
			}else{
				if(@unlink(DocumentRoot . $path . '/' . $entry)){
					echo $path . '/' . $entry . ' deleted succ!<br>';
				}else{
					echo $path . '/' . $entry . ' deleted failed!<br>';
				}
			}
		}
	}
	$d->close();
	unset($d);
	if(is_array($wait_delete_dirs)){
		foreach($wait_delete_dirs as $dir){
			if($dir && file_exists(DocumentRoot . $dir)){
				if(@rmdir(DocumentRoot . $dir)){
					echo $dir . ' deleted succ!<br>';
				}else{
					echo $dir . ' deleted failed!<br>';
				}
			}
		}
	}
	return true;
}
function _ExpressPHP_MKDIR($path) {
	if(!defined("DocumentRoot")) return false;
	$arrPath = explode('/', $path);
	foreach($arrPath as $dirname){
		if($dirname && $dirname != '.'){
			$newPath .= '/' . $dirname;
			if(!file_exists(DocumentRoot . $newPath) || !is_dir(DocumentRoot . $newPath)){
				if(!@mkdir(DocumentRoot . $newPath, 0777)) return false;
			}
		}
	}
	return $newPath;
}

?>