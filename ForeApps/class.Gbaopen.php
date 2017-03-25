<?php

/**
 * Created by PhpStorm.
 * User: lc
 * Date: 2016/5/12
 * Function: G宝盆各种客户操作
 * Time: 09:37
 */
class Gbaopen extends ForeVIEWS
{

    public function __Public()
    {
        IsLogin();
        //控制器
        $this->MyModule = 'Gbaopen';
        global $function_config;
        $this->LogsFunction = new LogsFunction;
        $this->function_config = $function_config;
        //权限代码
        $this->create = 'create';
        $this->renew = 'renew';
        $this->case = 'case';
        $this->modify = 'modify';
        $this->process = 'process';
        $this->transfer = 'transfer';
        $this->manage = 'manage';
        $this->delete = 'delete';
    }

    //客户创建/开通页面
    public function Create()
    {
        $this->MyAction = 'Create';
        $agent_id = $_SESSION ['AgentID'];
        $power = $_SESSION ['Power'];
        $account = new AccountModule();
        $data["ExperienceCount"] = $account->GetExperienceCount($agent_id);
        if ($this->Assess($power, $this->create)) {
            $fuwuqi = new FuwuqiModule();
            $fuwuqiinfo = $fuwuqi->GetListsByWhere(array('ID', 'FuwuqiName', 'CName'), ' order by ID asc');
            $data['power'] = true;
            $cusmodel = new CustomersModule;
            $cuspromodel = new CustProModule;
            $cuspro = $cuspromodel->GetListsByWhere(array('CustomersID'), 'where AgentID=' . $agent_id);
            $cus = $cusmodel->GetListsByWhere(array('CustomersID', 'CompanyName'), 'where AgentID=' . $agent_id . ' order by UpdateTime desc');
            foreach ($cuspro as $val) {
                $cusprolist[$val['CustomersID']] = '';
            }
            foreach ($cus as $v) {
                if (!isset($cusprolist[$v['CustomersID']]))
                    $cuslist[] = $v;
            }
            if ($this->_GET['cus']) {
                $data['cussel'] = $cusmodel->GetOneByWhere('where AgentID=' . $agent_id . ' and CustomersID=' . $this->_GET['cus']);
            }
            $data['cus'] = $cuslist;
            $data['server'] = $fuwuqiinfo;
        } else {
            $data['power'] = false;
        }
        $this->Data = $data;
    }

    //G宝盆客户列表--页面
    public function Customer()
    {
        $this->MyAction = 'Customer';
        $agent_id = $_SESSION ['AgentID'];
        $data['power'] = $_SESSION ['Power'];
        $this->Data = $data;
    }

    /* G宝盆模拟登陆 */
    public function GbaoPenManage()
    {
        $CustomersID = _intval($this->_GET['ID']);
        $power = $_SESSION ['Power'];
        if ($CustomersID != 0 && $this->Assess($power, $this->manage)) {
            /* 获取客户G宝盆信息 */
            $CustProModule = new CustProModule();
            $CustProInfo = $CustProModule->GetOneByWhere(array('G_name'), ' where CustomersID = ' . $CustomersID);
            //使用用户名自动登录
            /* 组成G宝盆发送字符串并POST到G宝盆平台模拟登陆 */
            $TuUrl = GBAOPEN_DOMAIN . 'api/loginuser';

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
            $ToString = 'cus_name=' . $CustProInfo ['G_name'];
            $form_str = '<form action="' . $TuUrl . '" method="post" name="E_FORM" id="payorder_form">';
            $form_str .= '<input type="hidden" name="name"  value="' . $CustProInfo ['G_name'] . '">';
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

    /**
     * E推自动登录
     */
    public function EtuiManage()
    {
        $CustomersID = _intval($this->_GET['ID']);
        $power = $_SESSION ['Power'];
        //===？登录验证当前用户===
        if ($CustomersID != 0 && $this->Assess($power, $this->manage)) {
            //获取客户信息，用户E推登录
            $cust = new CustomersModule();
            $cust_info = $cust->GetOneByWhere(array(), " where CustomersID = " . $CustomersID);
            $TuUrl = WEICD_DOMAIN . "index.php?c=user&a=autologinFromDaili";//$TuUrl = GBAOPEN_DOMAIN . 'api/loginuser';

            /* 组成G宝盆发送字符串并POST到G宝盆平台模拟登陆 */

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
            $form_str .= '<input type="hidden" name="name"  value="' . $cust_info ['Email'] . '">';
            $form_str .= '<input type="hidden" name="timemap"  value="' . $timemap . '">';
            $form_str .= '<input type="hidden" name="taget"  value="' . $taget . '">';
            $form_str .= '</form>';
            echo $form_str;
            echo "<script>document.getElementById('payorder_form').submit();</script>";
        } else {
            echo "<script>alter('失败')</script>";
        }
    }

//    /**
//     * 跳转至微传单握手验证
//     */
//    public function cdShakeHands(){
//        $remember=Input::get("remember");
//        $username=Input::get("username");
//        $cust=Customer::where("email",$username)->first();
//        if(md5($cust["remember_token"].$cust["email"])==$remember){
//            return json_encode(array("err"=>0));
//        }else{
//            return json_encode(array("err"=>1));
//        }
//    }

//    public function autoLogin() {
//        echo '<meta charset="utf-8">';
//        $datas = $_GET;
//        $field = 'email_varchar';
//
//        $userinfo[$field] = $datas['username'];
//        $userinfo['status_int'] = 1;
//
//        $User = M('users');
//
//        $returnInfo = $User->where($userinfo)->find();
//        if ($returnInfo) {
//            $url = 'http://www.db.com/cdshakehands';
//            $post = array("username" => $datas['username'], "remember" => md5($datas['remember'] . $datas['username']));
//            $ret = $this->PostCurl($url, $post, $cookie = '');
//            $ret = json_decode($ret, true);
//            if ($ret["err"]) {
//                echo "错误登录！";
//                exit();
//            }
//            if (intval($returnInfo['end_time']) > 0 && $returnInfo['end_time'] < time()) {
//                echo '<script>alert("您的账号已过期，请与管理员联系");window.history.go(-1);</script>'; //{"success":false,"code":1004,"msg":"您的账号已过期，请与管理员联系","map":{"isValidateCodeLogin":false}}';
//            } else {
//
//                session('userid', $returnInfo["userid_int"]);
//                session('name', $returnInfo["uname"]);
//                session('username', $returnInfo[$field]);
//                session('phone', $returnInfo['phone']);
//                session('level_int', $returnInfo["level_int"]);
//                session('type', $returnInfo["type"]);
//                session('email', $returnInfo["email_varchar"]);
//                session('md5str', md5('adklsj[]999875sssee,' . $returnInfo["id"]));
//                cookie('USERID', $returnInfo["userid_int"]);
//                cookie('MD5STR', md5('adklsj[]999875sssee,' . $returnInfo["id"]));
//                header('HTTP/1.1 200 ok');
//
//
//                $update['last_time'] = date('y-m-d H:i:s', time());
//                $User->where(array('userid_int' => $returnInfo["userid_int"]))->save($update);
//                echo '<script>alert("登录成功");window.location="/#/main";</script>';
//            }
//            exit;
//        } else {
//            echo '<script>alert("账号不存在或者已经被禁用");window.history.go(-1);</script>';
//            exit;
//        }
//    }


    public function ToOne()
    {
        if (isset($_SESSION['AgentID']) and ($_SESSION['AgentID'] == 45)) {
            if ($this->_POST['searchtxt']) {
                $Searchtxt = $this->_POST['searchtxt'];
                $ProjectId = GBAOPEN_ID;
                $MysqlWhere = " where PC_domain like '%$Searchtxt%' or Mobile_domain like '%$Searchtxt%'";
                $CustProModule = new CustProModule();
                $Data = $CustProModule->GetLists($MysqlWhere, 0, 1000);
                $accountModule = new AccountModule ();
                $Lists = $accountModule->GetLists('', 0, 1000);
                $List = array();
                foreach ($Lists as $key => $v) {
                    $List[$v['AgentID']] = $v;
                }
                foreach ($Data as $k => $v) {
                    $Data[$k]['UserName'] = $List[$v['AgentID']]['UserName'];
                }
                $this->Data = $Data;
            }
        } else {
            echo 'the Gbaopen::ToOne not found!';
            exit;
        }
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

    /**
     *代理消费日志展示
     */
    public function LogCost()
    {
        $this->MyAction = 'LogCost';
        $get = $this->_GET;
        if (isset($get["month"])) {
            $date_start = $get["month"];
        } else {
            $date_start = date('Y-m', strtotime(date("Y-m")));
        }
        $DB = new DB();
        $Data = array();
        $log_cost = $DB->Select("select a.OrderID,a.cost,a.description,a.type,a.adddate,a.Balance,b.CompanyName,c.ContactName from tb_logcost a inner join tb_customers b on a.CostID='" . $_SESSION['AgentID'] . "' and a.type<3 and a.CustomersID=b.CustomersID and a.adddate>'" . $date_start . "' and a.adddate like '" . $date_start . "%' inner join tb_account c on a.AgentID=c.AgentID order by a.adddate desc");
        $log_recharge = $DB->Select("select '--' as OrderID,a.cost,a.description,a.type,a.adddate,a.Balance,'--' as CompanyName,c.ContactName from tb_logcost a inner join tb_account c on a.AgentID=c.AgentID and a.type='3' and a.CostID='" . $_SESSION['AgentID'] . "' and a.adddate>'" . $date_start . "' and a.adddate like '" . $date_start . "%' order by a.adddate desc");
        $log_morecapacity = $DB->Select("select '--' as OrderID,a.cost,a.description,a.type,a.adddate,a.Balance,b.CompanyName,c.ContactName from tb_logcost a inner join tb_customers b on a.CostID='" . $_SESSION['AgentID'] . "' and a.type='4' and a.CustomersID=b.CustomersID and a.adddate>'" . $date_start . "' and a.adddate like '" . $date_start . "%' inner join tb_account c on a.AgentID=c.AgentID order by a.adddate desc");
        $Data["log"] = $this->myAdddteArrayMerge($log_cost, $log_recharge);
        $Data["log"] = $this->myAdddteArrayMerge($Data["log"], $log_morecapacity);
        $Data["month"] = $date_start;
        $this->Data = $Data;
    }

    private function myAdddteArrayMerge($arr1, $arr2)
    {
        $num_1 = 0;
        $num_2 = 0;
        $len_1 = count($arr1);
        $len_2 = count($arr2);
        $ret = array();
        while ($num_1 < $len_1 && $num_2 < $len_2) {
            if ($arr1[$num_1]["adddate"] < $arr2[$num_2]["adddate"]) {
                $ret[] = $arr2[$num_2];
                $num_2++;
            } else {
                $ret[] = $arr1[$num_1];
                $num_1++;
            }
        }
        while ($num_1 < $len_1) {
            $ret[] = $arr1[$num_1];
            $num_1++;
        }
        while ($num_2 < $len_2) {
            $ret[] = $arr2[$num_2];
            $num_2++;
        }
        return $ret;
    }
}