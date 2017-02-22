<?PHP

class Agent extends InterfaceVIEWS {

    public function __Public() {
        global $function_config;
        $this->LogsFunction = new LogsFunction;
        $this->function_config = $function_config;
        IsLogin();
    }

    public function UserInfo() {
        $agent_id = (int) $_SESSION ['AgentID'];
        $usermodel = new AccountModule;
        $userinfo = $this->_POST ['userinfo'];
        $user_up['ContactName'] = $userinfo['name'];
        $user_up['ContactAddress'] = $userinfo['place'];
        $user_up['ContactTel'] = $userinfo['tel'];
        $user_up['ContactEmail'] = $userinfo['email'];
        if ($usermodel->UpdateArrayByKeyID($user_up, $agent_id)) {
            $result = array('err' => 0, 'msg' => '个人资料更新成功', 'data' => array('name' => $user_up['ContactName']));
            $this->LogsFunction->LogsAgentRecord(222, 1, 0, $result['msg']);
        } else {
            $result = array('err' => 1001, 'msg' => '个人资料更新失败', 'data' => '');
            $this->LogsFunction->LogsAgentRecord(222, 0, 0, $result['msg']);
        }
        return $result;
    }

    //根据分页获取客服列表
    public function GetSevList() {
        $level = $_SESSION ['Level'];
        $agent_id = $_SESSION ['AgentID'];
        $result = array('err' => 1000, 'data' => '', 'msg' => '非法请求');
        $page = (int) $this->_GET['page'];
        if ($level == 1) {
            $DB = new DB;
            $usermodel = new AccountModule;
            $start = ($page - 1) * $num;
            $where = 'where Level = 2';
            $agentmsg = $usermodel->GetListsByWhere(array('AgentID', 'UserName', 'ContactName', 'ContactTel', 'ContactEmail'), $where . ' limit ' . $start . ',8');
            $num = $DB->Select('select a.BossAgentID,b.AgentID,count(b.AgentID) Num from tb_account a inner join tb_customers_project b on a.AgentID = b.AgentID group by b.AgentID');
            foreach($agentmsg as $v){
                $data[$v['AgentID']] = $v;
            }
            foreach($num as $v){
                if($v['BossAgentID'] == 0){
                    if($data[$v['AgentID']]){
                        $data[$v['AgentID']]['CusNum'] = $data[$v['AgentID']]['CusNum'] ? $data[$v['AgentID']]['CusNum'] : 0;
                        $data[$v['AgentID']]['CusNum'] += $v['Num'];
                    }
                }else{
                    if($data[$v['BossAgentID']]){
                        $data[$v['BossAgentID']]['CusNum'] = $data[$v['BossAgentID']]['CusNum'] ? $data[$v['BossAgentID']]['CusNum'] : 0;
                        $data[$v['BossAgentID']]['CusNum'] += $v['Num'];
                    }
                }
            }
            $k = 0;
            foreach ($data as $v) {
                $sevList[$k]['id'] = $v['AgentID'];
                $sevList[$k]['name'] = $v['UserName'];
                $sevList[$k]['nickname'] = $v['ContactName'];
                $sevList[$k]['tel'] = $v['ContactTel'];
                $sevList[$k]['email'] = $v['ContactEmail'];
                $sevList[$k]['num'] = $v['CusNum'];
                $k++;
            }
            $result['data']['list'] = $sevList;
            $result['data']['del'] = false;
            $result['err'] = 0;
            $result['msg'] = '';
        } elseif ($level == 2) {
            $sevMsg = $this->GetAgentList('where BossAgentID=' . $agent_id, $page, 8);
            foreach ($sevMsg['AgentMsg'] as $k => $v) {
                $sevList[$k]['id'] = $v['AgentID'];
                $sevList[$k]['name'] = $v['UserName'];
                $sevList[$k]['nickname'] = $v['ContactName'];
                $sevList[$k]['tel'] = $v['ContactTel'];
                $sevList[$k]['email'] = $v['ContactEmail'];
                $sevList[$k]['num'] = $v['CusNum'];
            }
            $result['data']['list'] = $sevList;
            $result['data']['del'] = true;
            $result['err'] = 0;
            $result['msg'] = '';
        }
        return $result;
    }

    public function SearchSevList() {
        $level = $_SESSION ['Level'];
        $agent_id = $_SESSION ['AgentID'];
        $search = $this->_GET['search'];
        $result = array('err' => 1000, 'data' => '', 'msg' => '非法请求');
        if ($level == 2) {
            $page = (int) $this->_GET['page'];
            $sevMsg = $this->GetAgentList('where BossAgentID=' . $agent_id . ' and UserName LIKE \'%' . $search . '%\'', true, $page, 8);
            foreach ($sevMsg['AgentMsg'] as $k => $v) {
                $sevList['list'][$k]['id'] = $v['AgentID'];
                $sevList['list'][$k]['name'] = $v['UserName'];
                $sevList['list'][$k]['nickname'] = $v['ContactName'];
                $sevList['list'][$k]['tel'] = $v['ContactTel'];
                $sevList['list'][$k]['email'] = $v['ContactEmail'];
                $sevList['list'][$k]['num'] = $v['CusNum'];
            }
            $sevList['pagenum'] = $sevMsg['Num'] > 0 ? ceil($sevMsg['Num'] / 8) : 0;
            $result['data'] = $sevList;
            $result['err'] = 0;
            $result['msg'] = '';
        }
        return $result;
    }

    //删除客服检测
    public function SevMsg() {
        $level = $_SESSION ['Level'];
        $agent_id = $_SESSION ['AgentID'];
        $usermodel = new AccountModule;
        $result = array('err' => 1000, 'data' => '', 'msg' => '非法请求');
        if ($level == 2) {
            $sev_id = _intval($this->_GET['num']);
            $sev_msg = $usermodel->GetOneInfoByKeyID($sev_id);
            $result['data'][] = $agent_id;
            $result['data'][] = $sev_id;
            if ($agent_id == $sev_msg['BossAgentID']) {
                $cus_count = $this->GetAgentCusNum($sev_id);
                if ($cus_count) {
                    $agent = $usermodel->GetListByBossAgentID($agent_id, array('ContactName', 'AgentID'));
                    $Data[$agent_id] = '自己';
                    if ($agent) {
                        foreach ($agent as $v) {
                            if ($v['AgentID'] == $sev_id)
                                continue;
                            else
                                $Data[$v['AgentID']] = $v['ContactName'];
                        }
                    }
                }
                $result['err'] = 0;
                $result['msg'] = '';
                $result['data'] = $Data ? $Data : false;
            } else {
                $result['msg'] = '您没有这个用户';
            }
        }
        return $result;
    }

    //密码修改
    public function Modify() {
        $agent_id = (int) $_SESSION ['AgentID'];
        $level = (int) $_SESSION ['Level'];
        $pwd = $this->_POST['data'];
        if (strlen($pwd) > 5 && strlen($pwd) < 17) {
            $sev_id = (int) $this->_POST['num'];
            $usermodel = new AccountModule;
            if($level == 1){
                $ser_msg = $usermodel->GetOneInfoByKeyID($sev_id);
                if($ser_msg['Level'] == 2){
                    if ($usermodel->UpdateArrayByKeyID($Data, $sev_id)) {
                        $result['err'] = 0;
                        $result['msg'] = '密码修改成功';
                        $this->LogsFunction->LogsAgentRecord(222, 1, $sev_id, $result['msg']);
                    } else {
                        $result['err'] = 1002;
                        $result['msg'] = '密码修改失败，请重试';
                        $this->LogsFunction->LogsAgentRecord(222, 0, $sev_id, $result['msg']);
                    }
                }else{
                    $result['err'] = 1001;
                    $result['msg'] = '非法请求';
                    $this->LogsFunction->LogsAgentRecord(222, 2, $sev_id, $result['msg']);
                }
            }elseif ($level == 2) {
                $ser_msg = $usermodel->GetOneInfoByKeyID($sev_id);
                if($ser_msg['BossAgentID'] == $agent_id){
                    $Data['PassWord'] = md5($pwd);
                    if ($usermodel->UpdateArrayByKeyID($Data, $sev_id)) {
                        $result['err'] = 0;
                        $result['msg'] = '密码修改成功';
                        $this->LogsFunction->LogsAgentRecord(222, 1, $sev_id, $result['msg']);
                    } else {
                        $result['err'] = 1002;
                        $result['msg'] = '密码修改失败，请重试';
                        $this->LogsFunction->LogsAgentRecord(222, 0, $sev_id, $result['msg']);
                    }
                }else{
                    $result['err'] = 1001;
                    $result['msg'] = '非法请求';
                    $this->LogsFunction->LogsAgentRecord(222, 2, $sev_id, $result['msg']);
                }
            } else {
                $result['err'] = 1001;
                $result['msg'] = '非法请求';
                $this->LogsFunction->LogsAgentRecord(222, 2, $sev_id, $result['msg']);
            }
        } else {
            $result['err'] = 1000;
            $result['msg'] = '密码不得小于6位，大于12位字符';
            $this->LogsFunction->LogsAgentRecord(222, 3, $sev_id, $result['msg']);
        }
        return $result;
    }

    //删除客服
    public function Delete() {
        $agent_id = (int) $_SESSION ['AgentID'];
        $level = $_SESSION ['Level'];
        $del_sev_id = (int) $this->_POST['num'];
        $tran_sev_id = (int) $this->_POST['id'];
        $usermodel = new AccountModule;
        $recovermodel = new RecoverModule;
        $result = array('err' => 1000, 'data' => '', 'msg' => '非法请求');
        if ($level == 2 && $del_sev_id) {
            $cus_count = $this->GetAgentCusNum($del_sev_id);
            if ($cus_count) {
                if ($tran_sev_id) {
                    $cusmodel = new CustomersModule;
                    $cuspromodel = new CustProModule;
                    $cuspromodel->UpdateArray(array('AgentID' => $tran_sev_id), array('AgentID' => $del_sev_id));
                    $cusmodel->UpdateArray(array('AgentID' => $tran_sev_id), array('AgentID' => $del_sev_id));
                } else {
                    $result['msg'] = '不存在转移对象';
                    return $result;
                }
            }
            $del_sev_msg = $usermodel->GetOneInfoByKeyID($del_sev_id);
            $del_sev_msg['DelTime'] = date("Y-m-d H:i:s");
            $recovermodel->InsertArray($del_sev_msg);
            $usermodel->DeleteInfoByKeyID($del_sev_id);
            $result['data']['name'] = $del_sev_msg['ContactName'];
            $result['err'] = 0;
            $result['msg'] = '删除成功';
        }
        return $result;
    }

    //创建客服
    public function CreateUser() {
        $agent_id = $_SESSION ['AgentID'];
        $level = $_SESSION ['Level'];
        $post = $this->_POST['userinfo'];
        if (strlen($post['pwd']) > 5 && strlen($post['pwd']) < 17) {
            if ($level != 3 && $post['account']) {
                $agent = new AccountModule;
                if ($agent->GetListsByWhere('where UserName=\'' . $post['account'] . '\'')) {
                    $result['err'] = 1002;
                    $result['msg'] = '该账号已存在，请选择其他账号名';
                    $this->LogsFunction->LogsAgentRecord(221, 2, 0, $result['msg']);
                } else {
                    $balance = new BalanceModule;
                    $agent_Data['Level'] = $level == 1 ? 2 : 3;
                    $agent_Data['BossAgentID'] = $level == 1 ? 0 : $agent_id;
                    $agent_Data['UserName'] = $post['account'];
                    $agent_Data['PassWord'] = md5($post['pwd']);
                    $agent_Data['RegTime'] = time();
                    $agent_Data['FromIP'] = GetIP();
                    $agent_Data['ContactName'] = $post['name'];
                    $agent_Data['ContactTel'] = $post['tel'];
                    $agent_Data['ContactEmail'] = $post['email'];
                    $agent_Data['GBaoPenAgentPriceID'] = 6;
                    $agent_Data['ExperienceCount'] = $level == 1 ? 3 : 0;
                    $ser_id = $agent->InsertArray($agent_Data, true);
                    if ($ser_id) {
                        $power = 0;
                        if($level == 1){
                            $power = 127;
                        }else{
                            $powList = explode(',', trim($post['list'], ','));
                            if ($powList) {
                                foreach ($powList as $v) {
                                    $power += $this->function_config[$v] ? $this->function_config[$v] : 0;
                                }
                            }
                        }
                        $bal_Data['AgentiD'] = $ser_id;
                        $bal_Data['Power'] = $power;
                        $bal_Data['Balance'] = 0;
                        $bal_Data['CostMon'] = 0;
                        $bal_Data['CostAll'] = 0;
                        $bal_Data['UpdateTime'] = date('Y-m-d', time());
                        $balance->InsertArray($bal_Data);
                        $result['err'] = 0;
                        $result['msg'] = '成功创建账号：' . $post['account'];
                        $this->LogsFunction->LogsAgentRecord(221, 1, 0, $result['msg']);
                    } else {
                        $result['err'] = 1003;
                        $result['msg'] = '创建失败，酌情联系管理员';
                        $this->LogsFunction->LogsAgentRecord(221, 0, 0, $result['msg']);
                    }
                }
            } else {
                $result['err'] = 1001;
                $result['msg'] = '非法请求';
                $this->LogsFunction->LogsAgentRecord(221, 3, 0, $result['msg']);
            }
        } else {
            $result['err'] = 1000;
            $result['msg'] = '密码不得小于6位，大于12位字符';
            $this->LogsFunction->LogsAgentRecord(221, 3, 0, $result['msg']);
        }
        return $result;
    }

    //获取相应客服的客户数量
    protected function GetAgentCusNum($agent_arr = array()) {
        $agent_str = is_array($agent_arr) ? implode(',', $agent_arr) : $agent_arr;
        $result = array();
        if ($agent_str) {
            $db = new DB;
            $sql = 'select AgentID,count(AgentID) as Num from tb_customers_project where AgentID in (' . $agent_str . ') group by AgentID';
            $agent = $db->Select($sql);
            foreach ($agent as $v) {
                $result[$v['AgentID']] = $v['Num'];
            }
        }
        return $result;
    }

    //获取相应页码的客服信息列表
    protected function GetAgentList($where, $needall = false, $page = 1, $num = 8) {
        $num = is_bool($needall) ? $num : $page;
        $page = is_bool($needall) ? $page : $needall;
        $needall = is_bool($needall) ? $needall : false;
        $usermodel = new AccountModule;
        //获取拥有的客服数量
        if ($needall)
            $return = $usermodel->GetListsNum($where);
        $page = $page > 0 ? $page : 1;
        $num = $num > 0 ? $num : 1;
        $start = ($page - 1) * $num;
        $agentmsg = $usermodel->GetListsByWhere(array('AgentID', 'UserName', 'ContactName', 'ContactTel', 'ContactEmail'), $where . ' limit ' . $start . ',' . $num);
        $agent = array();
        if ($agentmsg) {
            foreach ($agentmsg as $v) {
                $agent[] = $v['AgentID'];
            }
        }
        $agentnum = $this->GetAgentCusNum($agent);
        foreach ($agentmsg as &$v) {
            $v['CusNum'] = isset($agentnum[$v['AgentID']]) ? $agentnum[$v['AgentID']] : 0;
        }
        $return['AgentMsg'] = $agentmsg;
        return $return;
    }

    //客服充值(接口已关闭)
    public function Recharge() {
        $result = array('err' => 1000, 'data' => '', 'msg' => '非法请求');
        $boss_id = (int) $_SESSION ['AgentID'];
        $power = $_SESSION ['Power'];
        $agent_id = (int) $this->_POST['num'];
        $add = (int)$this->_POST['price'];
        if (($power & CUS_AGENT) && is_numeric($agent_id) && is_numeric($add)&&$_SESSION["Level"]==1) {
            $account=new AccountModule();
            $account_info=$account->GetOneInfoByKeyID($agent_id);
            if($account_info["Level"]==2){
                $self_update=array();
                $balancemodel = new BalanceModule;
                $balance_info=$balancemodel->GetBalance($agent_id);
                $updatetime = explode('-', $balance_info['UpdateTime']);
                if (date('m', time()) != $updatetime[1]) {
                    $self_update['UpdateTime'] = date('Y-m-d', time());
                    $self_update['CostMon'] = 0;
                }
                $self_update['Balance'] = $balance_info['Balance'] + $add;
                if($balancemodel->UpdateArrayByAgentID($self_update, $agent_id)){
                    $logcost_data = array("ip" => $_SERVER["REMOTE_ADDR"], "cost" => $add, "type" => 3, "description" => "账户充值", "adddate" => date('Y-m-d H:i:s', time()), "CustomersID" => "","AgentID"=>$boss_id,"CostID"=>$agent_id,"Balance"=>$self_update['Balance'],"OrderID"=>"");
                    $logcost = new LogcostModule();
                    $logcost->InsertArray($logcost_data);
                    $result = array('err' => 0,'data' => array('name' => $account_info['UserName']), 'msg' => '充值成功');
                }
            }else{
                $result = array('err' => 1001, 'msg' => '充值对象出错');
            }
            
//            $balancemodel = new BalanceModule;
//            $db = new DB;
//            $sql = 'select a.UserName,b.Balance,b.Pay from tb_account a inner join tb_balance b on a.AgentID=' . $agent_id . ' and a.BossAgentID=' . $boss_id . ' and a.AgentID=b.AgentID';
//            $agentmsg = $db->Select($sql);
//            if ($agentmsg) {
//                $agentmsg = $agentmsg[0];
//                $sql = 'select a.UserName,b.Balance,b.Pay,b.UpdateTime from tb_account a inner join tb_balance b on a.AgentID=' . $boss_id . ' and a.AgentID=b.AgentID';
//                $bossmsg = $db->Select($sql);
//                $bossmsg = $bossmsg[0];
//                if ($bossmsg['Balance'] < $add) {
//                    $result = array('err' => 1001, 'msg' => '充值失败，您的余额不足，您的余额为' . $bossmsg['Balance'] . '请及时充值');
//                } else {
//                    $boss_update = $agent_update = array();
//                    $updatetime = explode('-', $bossmsg['UpdateTime']);
//                    $boss_update['Pay'] = $bossmsg['Pay'] + $add;
//                    if (date('m', time()) != $updatetime[1]) {
//                        $boss_update['UpdateTime'] = date('Y-m-d', time());
//                        $boss_update['Pay'] = 0;
//                    }
//                    $boss_update['Balance'] = $bossmsg['Balance'] - $add;
//                    $agent_update['Balance'] = $agentmsg['Balance'] + $add;
//                    $balancemodel->UpdateArrayByAgentID($boss_update, $boss_id);
//                    $balancemodel->UpdateArrayByAgentID($agent_update, $agent_id);
//                    $result = array('err' => 0, 'data' => array('name' => $agentmsg['UserName']), 'msg' => '充值成功');
//                }
//            }
        }
        return $result;
    }

    /* 删除客户(接口已关闭) */

    public function DeleteCustomer() {
        $result = array('err' => 0, 'data' => '', 'msg' => '');
        $this->MyAction = 'UserInfo';
        $level=$_SESSION["Level"];
        $Agent_id = $_SESSION ['AgentID'];
        $Power = $_SESSION ['Power'];
        $CustomersID = $this->_POST ['num'];
//        $this->Assess($Power, 'delete');
        if (!($Power & CUS_DELETE)) {
            $result['err'] = 1001;
            $result['msg'] = '非法请求';
            $this->LogsFunction->LogsAgentRecord(119, 3, $CustomersID, $result['msg']);
            return $result;
        }
        $CustomersModule = new CustomersModule ();
        $Usermodel = new AccountModule;
        $Users = $Usermodel->GetListsByWhere(array('AgentID'), 'where BossAgentID=' . $Agent_id);
        foreach ($Users as $k => $v) {
            $Users[$k] = $v['AgentID'];
        }
        $CustomersInfo = $CustomersModule->GetOneByWhere('where CustomersID=' . $CustomersID);
        if (!in_array($CustomersInfo['AgentID'], $Users)&&$level!=1) {
            $result['err'] = 1001;
            $result['msg'] = '您没有这个用户的信息';
            $this->LogsFunction->LogsAgentRecord(119, 2, $CustomersID, $result['msg']);
            return $result;
        }
        $CustProModule = new CustProModule ();
        $CustProInfo = $CustProModule->GetInfoByWhere(' where CustomersID = ' . $CustomersID);
        if ($CustomersModule->UpdateArray(array("Status"=>0), array("CustomersID"=>$CustomersID))/*$CustomersModule->DeleteInfoByKeyID($CustomersID)*/) {
            if ($CustProInfo) {
                $CustProModule->UpdateArray(array("status"=>0), array("CustomersID"=>$CustomersID));
//                $CustProModule->DeleteInfoByWhere(' where CustomersID = ' . $CustomersID);
                $ToString = 'username=' . $CustProInfo['G_name'];
                $TuUrl = GBAOPEN_DOMAIN . 'api/deleteuser';
                //随机文件名开始生成
                $randomLock = getstr();
                $password = md5($randomLock);
                $password = md5($password);

                //生成握手密钥
                $text = getstr();

                //生成dll文件
                $myfile = @fopen('./token/' . $password . '.dll', "w+");
                if (!$myfile) {
                    $CustomersModule->UpdateArray(array("Status"=>1), array("CustomersID"=>$CustomersID));
//                    $CustomersModule->InsertArray($CustomersInfo);
//                    $CustProModule->InsertArray($CustProInfo);
                    $result['err'] = 1002;
                    $result['msg'] = '删除客户失败';
                    $this->LogsFunction->LogsAgentRecord(119, 0, $CustomersID, 'token文件创建失败');
                    return $result;
                }
                fwrite($myfile, $text);
                fclose($myfile);

                $ToString .= '&timemap=' . $randomLock;
                $ToString .= '&taget=' . md5($text . $password);
                $ReturnString = request_by_other($TuUrl, $ToString);
                $ReturnArray = json_decode($ReturnString, true);
                if ($ReturnArray['err'] == 1000) {
                    $result['data'] = array('name' => $CustomersInfo['CompanyName']);
                    $result['msg'] = '删除客户成功';
                    $this->LogsFunction->LogsAgentRecord(119, 1, $CustomersID, $result['msg']);
                } else {
                    $CustomersModule->UpdateArray(array("Status"=>1), array("CustomersID"=>$CustomersID));
//                    $CustomersModule->InsertArray($CustomersInfo);
//                    $CustProModule->InsertArray($CustProInfo);
                    $result['err'] = 1003;
                    $result['data'] = $ReturnArray;
                    $result['msg'] = '统一平台删除客户失败';
                    $this->LogsFunction->LogsAgentRecord(119, 6, $CustomersID, $result['msg']);
                    return $result;
                }
            } else {
                $result['data'] = array('name' => $CustomersInfo['CompanyName']);
                $result['msg'] = '删除客户成功';
                $this->LogsFunction->LogsAgentRecord(119, 1, $CustomersID, $result['msg']);
            }
        } else {
            $result['err'] = 1002;
            $result['msg'] = '本地删除客户失败';
            return $result;
        }
        return $result;
    }
    public function reductionCustomer() {
        $result = array('err' => 0, 'data' => '', 'msg' => '');
        $this->MyAction = 'UserInfo';
        $level=$_SESSION["Level"];
        $Agent_id = $_SESSION ['AgentID'];
        $Power = $_SESSION ['Power'];
        $CustomersID = $this->_POST ['num'];
//        $this->Assess($Power, 'delete');
        if (!($Power & CUS_DELETE)) {
            $result['err'] = 1001;
            $result['msg'] = '非法请求';
            $this->LogsFunction->LogsAgentRecord(119, 3, $CustomersID, $result['msg']);
            return $result;
        }
        $CustomersModule = new CustomersModule ();
        $Usermodel = new AccountModule;
        $Users = $Usermodel->GetListsByWhere(array('AgentID'), 'where BossAgentID=' . $Agent_id);
        foreach ($Users as $k => $v) {
            $Users[$k] = $v['AgentID'];
        }
        $CustomersInfo = $CustomersModule->GetOneByWhere('where Status=0 and CustomersID=' . $CustomersID);
        if (!in_array($CustomersInfo['AgentID'], $Users)&&$level!=1) {
            $result['err'] = 1001;
            $result['msg'] = '您没有这个用户的信息';
            $this->LogsFunction->LogsAgentRecord(120, 2, $CustomersID, $result['msg']);
            return $result;
        }
        $CustProModule = new CustProModule ();
        $CustProInfo = $CustProModule->GetInfoByWhere(' where CustomersID = ' . $CustomersID);
        if ($CustomersModule->UpdateArray(array("Status"=>1), array("CustomersID"=>$CustomersID))/*$CustomersModule->DeleteInfoByKeyID($CustomersID)*/) {
            if ($CustProInfo) {
//                $CustProModule->UpdateArray(array("status"=>1), array("CustomersID"=>$CustomersID));
//                $CustProModule->DeleteInfoByWhere(' where CustomersID = ' . $CustomersID);
                $ToString = 'username=' . $CustProInfo['G_name'];
                $TuUrl = GBAOPEN_DOMAIN . 'api/reductionCustomer';
                //随机文件名开始生成
                $randomLock = getstr();
                $password = md5($randomLock);
                $password = md5($password);

                //生成握手密钥
                $text = getstr();

                //生成dll文件
                $myfile = @fopen('./token/' . $password . '.dll', "w+");
                if (!$myfile) {
                    $CustomersModule->UpdateArray(array("Status"=>0), array("CustomersID"=>$CustomersID));
//                    $CustomersModule->InsertArray($CustomersInfo);
//                    $CustProModule->InsertArray($CustProInfo);
                    $result['err'] = 1002;
                    $result['msg'] = '还原客户失败';
                    $this->LogsFunction->LogsAgentRecord(120, 0, $CustomersID, 'token文件创建失败');
                    return $result;
                }
                fwrite($myfile, $text);
                fclose($myfile);

                $ToString .= '&timemap=' . $randomLock;
                $ToString .= '&taget=' . md5($text . $password);
                $ReturnString = request_by_other($TuUrl, $ToString);
                $ReturnArray = json_decode($ReturnString, true);
                if ($ReturnArray['err'] == 1000) {
                    $result['data'] = array('name' => $CustomersInfo['CompanyName']);
                    $result['msg'] = '还原客户成功';
                    $this->LogsFunction->LogsAgentRecord(120, 1, $CustomersID, $result['msg']);
                } else {
                    $CustomersModule->UpdateArray(array("Status"=>0), array("CustomersID"=>$CustomersID));
//                    $CustomersModule->InsertArray($CustomersInfo);
//                    $CustProModule->InsertArray($CustProInfo);
                    $result['err'] = 1003;
                    $result['data'] = $ReturnArray;
                    $result['msg'] = '统一平台还原客户失败';
                    $this->LogsFunction->LogsAgentRecord(120, 6, $CustomersID, $result['msg']);
                    return $result;
                }
            } else {
                $result['data'] = array('name' => $CustomersInfo['CompanyName']);
                $result['msg'] = '还原客户成功';
                $this->LogsFunction->LogsAgentRecord(120, 1, $CustomersID, $result['msg']);
            }
        } else {
            $result['err'] = 1002;
            $result['msg'] = '本地还原客户失败';
            return $result;
        }
        return $result;
    }
    //获取余额
    public function getbalance(){
        $Agent_id = $_SESSION ['AgentID'];
        $balancemodule=new BalanceModule();
        $balance=$balancemodule->GetBalance($Agent_id);
        return json_encode($balance);
    }

}
