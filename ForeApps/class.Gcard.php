<?php

/**
 * Created by PhpStorm.
 * User: lc
 * Date: 2017/11/3
 * Function: G名片各种客户操作
 * Time: 09:37
 */
class Gcard extends ForeVIEWS
{

    public function __Public()
    {
        IsLogin();
        //控制器
        $this->MyModule = 'Gcard';
        global $function_config;
        $this->LogsFunction = new LogsFunction;
        $this->function_config = $function_config;
        //权限代码
        $this->create = 'create';
    }

    //客户创建/开通页面
    public function Create()
    {
        $this->MyAction = 'Build';
        $agent_id = $_SESSION ['AgentID'];
        $power = $_SESSION ['Power'];
        $account = new AccountModule();
        $data["ExperienceCount"] = $account->GetExperienceCount($agent_id);
        if ($this->Assess($power, $this->create)) {
            $data['power'] = true;
        } else {
            $data['power'] = false;
        }
        $this->Data = $data;
    }

    //G名片客户列表--页面
    public function Customer()
    {
        $this->MyAction = 'Glist';
        $agent_id = $_SESSION ['AgentID'];
        $data['power'] = $_SESSION ['Power'];
    }

    /*权限判定函数，
     * 一个参数获取当前拥有的权限，
     * 两个参数判断是否拥有这个权限
     */
    private function Assess($power, $type = false)
    {
        if ($type) {
            $re = isset($this->function_config[$type]) ? $power & $this->function_config[$type] ? true : false : false;
        } else {
            $re = array();
            foreach ($this->function_config as $k => $v) {
                if ($power & $v) {
                    $re[] = $k;
                }
            }
        }
        return $re;
    }

        /* G名片模拟登陆 */
    public function GcardManage()
    {
        $id = _intval($this->_GET['ID']);
        $power = $_SESSION ['Power'];
        if ($id != 0 && $this->Assess($power, $this->manage)) {
            /* 获取客户G名片信息 */
            $Gcard = new GcardModule();
            $data = $Gcard->GetOneByWhere(array('account'), ' where id = ' . $id);
            $TuUrl = WEIMP_DOMAIN . 'api/loginuser';

            //随机文件名开始生成
            $randomLock = getstr();
            $password = md5(md5($randomLock));

            //生成握手密钥
            $text = getstr();

            //生成dll文件
            $myfile = @fopen('./token/' . $password . '.dll', "w+");
            if (!$myfile) {
                return 0;
            }
            fwrite($myfile, $text);
            fclose($myfile);

            $timemap = $randomLock;
            $taget = md5($text . $password);
            $form_str = '<form action="' . $TuUrl . '" method="post" name="E_FORM" id="payorder_form">';
            $form_str .= '<input type="hidden" name="account"  value="' . $data ['account'] . '">';
            $form_str .= '<input type="hidden" name="timemap"  value="' . $timemap . '">';
            $form_str .= '<input type="hidden" name="taget"  value="' . $taget . '">';
            $form_str .= '</form>';

            echo $form_str;
            echo "<script>document.getElementById('payorder_form').submit();</script>";
        } else {
            echo "<script>alter('失败')</script>";
        }
        exit;
    }

}