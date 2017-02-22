<?php

abstract class ExpressPHP_Application {

    protected $CurrentPageID, $timestamp;
    protected $Config = array(
        'DocumentRoot' => null,
        'AppName' => null,
        'ViewPath' => null,
        'DefaultClass' => null,
        'DefaultView' => 'Index',
        'NotAccessMessage' => '很抱歉, 您没有权限进行该操作! 如果您尚未登陆, 请先以您的用户登陆!',
        'NotAccessURL' => null,
        'NotLoginIsAlertMessage' => true,
        'NotAccessURLTitle' => '',
        'DefaultViewerEngine' => 'Template'
    );

    public function __construct() {
        $this->CurrentPageID = md5($_SERVER['REQUEST_URI']);
        $this->timestamp = time();
        $this->Config = $this->__Config();
    }

    public function __destruct() {
        unset($this);
    }

    public function __LoadModules($path) {
        include_once $this->Config['DocumentRoot'] . $path;
    }

    public function __LoadParameters($Name, $path = '/config') {
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

    abstract protected function __Config();

    public function __RuleChecker($RuleID) {
        return true;
    }

    public function __ApplicationConfigHacker($option = null) {
        if (is_array($option)) {
            foreach ($option as $key => $value) {
                if (array_key_exists($key, $this->Config))
                    $this->Config[$key] = $value;
            }
        }
        return $this->Config;
    }

    public function __ArrJsonMessage($Code, $Message, $Data = null) {
        $tmp['Code'] = $Code;
        $tmp['Message'] = $Message;
        if ($Data)
            $tmp['Data'] = $Data;
        return $tmp;
    }

    public function Run($Class = null, $View = null) {
        $option = $this->__ApplicationConfigHacker($this->__Config());
        if (!$Class)
            $Class = $option['DefaultClass'];
        if (!$View)
            $View = $option['DefaultView'];
        $ViewConfig = $View . 'Config';

        $ClassFile = $option['ViewPath'] . '/class.' . $Class . '.php';
        $NotAccessMessage = $option['NotAccessMessage'];
        $NotAccessURL = $option['NotAccessURL'];
        $NotAccessURLTitle = $option['NotAccessURLTitle'];

        if (!file_exists($this->Config['DocumentRoot'] . $ClassFile)) {
            $this->__destruct();
            die('Class "' . $ClassFile . '" Not Found!');
        }
        require $this->Config['DocumentRoot'] . $ClassFile;

        if (!method_exists($Class, $View)) {
            $this->__destruct();
            die("the {$Class}::{$View} not found!");
        }

        $newView = new $Class( );

        //载入视图类对当前视图的配置信息
        if (method_exists($Class, $ViewConfig)) {
            //视图配置存在;
            $tmpConfig = $newView->$ViewConfig();
            foreach ($tmpConfig as $key => $value) {
                $newView->Config[$key] = $value;
            }
            unset($tmpConfig, $key, $value);
        }
        if (!isset($newView->Config['ViewerEngine'])) {
            if (!isset($newView->Config['TemplateEngine']))
                $newView->Config['ViewerEngine'] = $this->Config['DefaultViewerEngine'];
        }

        if ($newView->Config) {
            //检查权限
            if ($newView->Config['RuleProperty']) {
                if (!$this->__RuleChecker($Class . $View)) {
                    if ($newView->Config['ViewerEngine'] == 'Template')
                        $newView->__Message($NotAccessMessage, $NotAccessURL . '&RedirectURL=' . $_SERVER['REQUEST_URI'], $NotAccessURLTitle);
                    elseif ($newView->Config['ViewerEngine'] == 'Json') {
                        echo json_encode($this->__ArrJsonMessage(__ERROR__, $NotAccessMessage, array(
                            'NotAccessURL' => $NotAccessURL,
                            'NotAccessURLTitle' => $NotAccessURLTitle
                        )));
                        exit();
                    } elseif ($newView->Config['ViewerEngine'] == 'PHP') {
                        $newView->__PHP_Template('__Message');
                        exit();
                    } else {
                        echo $NotAccessMessage;
                        exit();
                    }
                }
            }
            //检查header 304
            if ($newView->Config['HeaderCache304'] && $newView->Config['HeaderCache304LifeLimit']) {
                $headers = apache_request_headers();
                $client_time = (isset($headers['If-Modified-Since']) ? strtotime($headers['If-Modified-Since']) : 0);
                $now = gmmktime();
                if ($client_time < $now && $client_time > ($now - $newView->Config['HeaderCache304LifeLimit'])) {
                    header('Last-Modified: ' . gmdate('D, d M Y H:i:s', $client_time) . ' GMT', true, 304);
                    exit(0);
                } else {
                    header('Last-Modified: ' . gmdate('D, d M Y H:i:s', $now) . ' GMT', true, 200);
                }
                unset($headers, $client_time, $now);
            }
        }
        if (function_exists('ob_gzhandler'))
            ob_start('ob_gzhandler');
        elseif (function_exists('ob_start'))
            ob_start();
        if (method_exists($newView, '__Public')) {
            $newView->__Public();
        }
        $ViewResult = $newView->$View();
        if ($newView->Config['ViewerEngine'] == 'Template') {
            if ($newView->Config['TemplateFile'])
                $newView->__Display($newView->Config['TemplateFile']);
            else
                $newView->__Display($Class . $View);
        }elseif ($newView->Config['ViewerEngine'] == 'Json') {
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($ViewResult);
        } elseif ($newView->Config['ViewerEngine'] == 'PHP') {
            if ($newView->Config['TemplateFile']) {
                $newView->__PHP_Template($newView->Config['TemplateFile']);
            } else {
                $newView->__PHP_Template($Class . $View);
            }
        }
        $this->__destruct();
        unset($newView, $this, $ViewResult);
    }

}

?>