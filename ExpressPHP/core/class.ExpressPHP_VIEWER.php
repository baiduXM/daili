<?php

abstract class ExpressPHP_VIEWER {

    public $timestamp = 0, $thread_begin_timestamp = 0;
    //用于继承全局变量
    protected $_POST, $_GET, $_FILES, $_COOKIE, $_SESSION, $_REQUEST;
    protected $Variables = array();
    //配置参数,及默认参数信息
    // charset 默认输出编码utf-8
    // timezone_set 指定时区, 缺省时为不指定时区 中国时区为 Asia/Shanghai
    // HeaderCache304 默认Header 304不设置
    // HeaderCache304LifeLimit 设置Header 304 有效时间  单位:秒数
    // CompilerMode 默认为编译模式
    // 模板编译模式, debug 为调试模式，会根据模板的更新时间判断是否重新解析模板. 
    // 若应用为高流量的的项目时，建议不要设置为debug 避免模板更新时导致IO读写过高及CPU过高.
    // 若设置为非debug值时，又需要更新模板那请使用视图对像的父级函数$obj->__CompileAllTemplates一次性完成.
    // RuleID 权限唯一ID, 若缺少,将采用 视图类名+视图方法名作为权限权限的唯一标识.
    // ViewName 视图名称  
    // TemplateEngine 默认开启模板解析功能


    public $Config = array(
        'charset' => 'utf-8',
        'DocumentRoot' => null,
        'timezone_set' => 'Asia/Shanghai',
        'HeaderCache304' => false,
        'HeaderCache304LifeLimit' => 0,
        'RuleProperty' => false,
        'ViewName' => null,
        'ViewerEngine' => 'Template'  //None, Json, Template,PHP
    );
    //HTML模板参数项
    //'GlobalsAutoImport' => true, 
    //'CompilerMode' => 'normal',  //normal,manual,debug
    //'TemplatePath' => null, 
    //'TemplateCompiledPath' => '/Data/TemplateCompiled', 
    //'TemplateDefaultPath' => null, 
    //'TemplateFileExt' => '.htm', 
    //'TemplateCompiledFileExt' => '.tpl.php'  
    //PHP模板参数项
    //'TemplatePath' => null, 
    //'TemplateDefaultPath' => null, 


    protected $TemplateClass = null;
    protected $__REQUEST_URI__ = null;

    public function __construct() {
        // 对全局外部变量进行自动转义, $_POST, $_GET, $_FILES, $_COOKIE, $_SESSION
        if ($_POST)
            $this->_POST = $this->__addslashes($_POST);
        if ($_GET)
            $this->_GET = $this->__addslashes($_GET);
        if ($_FILES)
            $this->_FILES = $this->__addslashes($_FILES);
        if ($_COOKIE)
            $this->_COOKIE = $this->__addslashes($_COOKIE);
        if ($_SESSION)
            $this->_SESSION = $this->__addslashes($_SESSION);
        if ($_REQUEST)
            $this->_REQUEST = $this->__addslashes($_REQUEST);
        $tmpConfig = $this->__Config();
        if (is_array($tmpConfig)) {
            foreach ($tmpConfig as $key => $value) {
                $this->Config[$key] = $value;
            }
        }
        unset($tmpConfig);
        //初始化时区.
        if ($this->Config['timezone_set'] && function_exists('date_default_timezone_set'))
            date_default_timezone_set($this->Config['timezone_set']);
        //获取当前 unix_timestamp值
        $this->timestamp = time();
        //初始化输出编码.
        if ($this->Config['charset'] && !$this->Config['HeaderCharset'])
            header('Content-Type: text/html; charset=' . $this->Config['charset']);
        //初始化模板
        if ($this->Config['ViewerEngine'] == 'Template') {
            $this->__TemplateConfig();
        }
        $SCRIPT_URL = $_SERVER['REQUEST_URI'] ? $_SERVER['REQUEST_URI'] : $_SERVER['SCRIPT_NAME'] . ($_SERVER['QUERY_STRING'] ? "?" . $_SERVER['QUERY_STRING'] : '');
        $SCRIPT_HOST = $_SERVER["HTTP_HOST"];
        $this->__REQUEST_URI__ = 'http://' . $SCRIPT_HOST . ($_SERVER["SERVER_PORT"] == 80 ? '' : $_SERVER["SERVER_PORT"]) . (isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING']);
    }

    abstract protected function __Config();

    protected function __TemplateConfig() {
        $this->TemplateClass = new ExpressPHP_Template($this->Config);
    }

    public function __Message($Message = null, $URL = 'HISTORY', $Title = null, $ExtData = array()) {
        if (count($ExtData)) {
            foreach ($ExtData as $key => $value) {
                $this->$key = $value;
            }
        }
        if ($Title) {
            $this->Title = $Title;
        }
        if ($URL)
            $this->URL = $URL;
        if ($Message)
            $this->Message = $Message;
        $this->__Display('__Message');
        unset($this);
        exit();
    }

    public function __ArrJsonMessage($Code, $Message, $Data = null) {
        $tmp['Code'] = $Code;
        $tmp['Message'] = $Message;
        $tmp['Data'] = $Data;
        return $tmp;
    }

    public function __CompileAllTemplates() {
        $this->TemplateClass->__CompileAllTemplates();
    }

    public function __Display($tpl) {
        $this->TemplateClass->__setVariables($this->Variables);
        $this->TemplateClass->Display($tpl);
    }

    public function __PHP_Template($tpl) {
        $tpl = $this->Config['TemplatePath'] . '/' . $tpl . '.php';
        if (!file_exists(DocumentRoot . $tpl)) {
            if ($this->Config['TemplateDefaultPath'] && file_exists(DocumentRoot . $this->Config['TemplateDefaultPath'] . '/' . $tpl . '.php')) {
                $tpl = $this->Config['TemplateDefaultPath'] . '/' . $tpl . '.php';
            } else {
                echo $tpl . ' NOT FOUND.';
                exit();
            }
        }
        extract($this->Variables, EXTR_OVERWRITE);
        include DocumentRoot . $tpl;
    }

    public function __LoadParameters($Name, $path = '/Data/Config') {
        $ParametersPath = $this->Config['DocumentRoot'] . $path . '/' . $Name . '.parameters.php';
        if (!file_exists($ParametersPath)) {
            return false;
        }
        include $ParametersPath;
        if ($Parameter)
            return $Parameter;
        else
            return false;
    }

    public function __LoadModules($path) {
        include_once $this->Config['DocumentRoot'] . $path;
    }

    public function __destruct() {
        unset($this);
    }

    public function __UseTime($unit = 's') {
        $mtime = explode(' ', microtime());
        $thread_endtime = ((float) $mtime[1] + (float) $mtime[0]);
        unset($mtime);
        return number_format(($thread_endtime - $this->thread_begin_timestamp), 4) . ' ' . $unit;
    }

    public function __UseMemory($unit = 'K') {
        $memory_get_usage = memory_get_usage();
        if ($unit == 'M') {
            return number_format($memory_get_usage / 1024 / 1024, 2) . ' MB';
        } elseif ($unit == 'K') {
            return number_format($memory_get_usage / 1024, 2) . ' KB';
        } else {
            return $memory_get_usage . ' Byte';
        }
    }

    public function __addslashes($string, $force = 0) {
        !defined('MAGIC_QUOTES_GPC') && define('MAGIC_QUOTES_GPC', get_magic_quotes_gpc());
        if (!MAGIC_QUOTES_GPC || $force) {
            if (is_array($string)) {
                foreach ($string as $key => $val) {
                    $string[$key] = $this->__addslashes($val, $force);
                }
            } else {
                $string = addslashes($string);
            }
        }
        return $string;
    }

    public function __htmlencode($string, $clear_rn = false) {
        if (is_array($string)) {
            foreach ($string as $key => $val) {
                $string[$key] = $this->htmlencode($val);
            }
        } else {
            if ($clear_rn) {
                $string = strtr($string, array(
                    "\n" => '',
                    "\r" => ''
                        ));
            }
            $string = preg_replace('/&amp;((#(\d{3,5}|x[a-fA-F0-9]{4})|[a-zA-Z][a-z0-9]{2,5});)/', '&\\1', strtr($string, array(
                '&' => '&amp;',
                '"' => '&quot;',
                '<' => '&lt;',
                '>' => '&gt;'
                    )));
        }
        return $string;
    }

    public function __get($varibale_name) {
        if (isset($this->Variables[$varibale_name])) {
            return $this->Variables[$varibale_name];
        } else {
            return false;
        }
    }

    public function __setVariables($Variables) {
        if (is_array($Variables)) {
            foreach ($Variables as $key => $value) {
                $this->Variables[$key] = $value;
                if (is_object($this->TemplateClass)) {
                    $this->TemplateClass->Variables[$key] = $value;
                }
            }
        }
    }

    public function __setArray($variable_name, $key, $value) {
        $this->Variables[$variable_name][$key] = $value;
        if (is_object($this->TemplateClass)) {
            $this->TemplateClass->Variables[$variable_name][$key] = $value;
        }
    }

    public function __clear() {
        $this->Variables = array();
        if (is_object($this->TemplateClass)) {
            $this->TemplateClass->Variables = array();
        }
    }

    public function __set($varibale_name, $varibale_value) {
        $this->Variables[$varibale_name] = $varibale_value;
        if (is_object($this->TemplateClass)) {
            $this->TemplateClass->Variables[$varibale_name] = $varibale_value;
        }
    }

    public function __isset($varibale_name) {
        return isset($this->Variables[$varibale_name]);
    }

    public function __unset($varibale_name) {
        unset($this->Variables[$varibale_name]);
        if (is_object($this->TemplateClass)) {
            unset($this->TemplateClass->Variables[$varibale_name]);
        }
    }

}

?>