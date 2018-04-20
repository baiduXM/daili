<?php


/**
 * Created by PhpStorm.
 * User: user001
 * Date: 2018/4/18
 * Time: 15:38
 * Function: E推过期数据各种操作
 */
class Expired extends ForeVIEWS
{
    public function __Public()
    {
        IsLogin();
        //控制器
        $this->MyModule = 'Expired';
        global $function_config;
        $this->LogsFunction = new LogsFunction;
        $this->function_config = $function_config;
    }

    public function EList(){
        $this->MyAction = 'EList';
        $agent_id = $_SESSION ['AgentID'];
        $data['power'] = $_SESSION ['Power'];
        $this->Data = $data;
    }

}