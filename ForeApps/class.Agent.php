<?php

class Agent extends ForeVIEWS {

    public function __Public() {
        IsLogin();
        //当前模块
        $this->MyModule = 'Agent';
        $this->LogsFunction = new LogsFunction();
    }

    /* 初始化 */

    public function Index() {
        $this->MyAction = 'Index';
    }

    /* 首页 */

    public function Customer() {
        $this->MyAction = 'Customer';
        $agent_id = (int) $_SESSION ['AgentID'];
        $level = (int) $_SESSION ['Level'];
        $usermodel = new AccountModule;
        $balance = new BalanceModule;
        //$account = new AgentInterModule;
        $DB = new DB;
        //获取余额信息
        $money = $balance->GetOneInfoByAgentID($agent_id);
        //当前用户的信息
        $user = $usermodel->GetAllByKeyID($agent_id);
        $user = $user[0];
        $boss_id = $user['BossAgentID'];
        //上级操作
        if ($boss_id > 0) {
            $boss = $usermodel->GetAllByKeyID($boss_id);
            $boss = $boss[0];
            $message['name'] = $boss['ContactName'];
            $message['image'] = $boss['Image'];
            $message['tel'] = $boss['ContactTel'];
            //$operation = $account->GetOneByAgentID($agent_id,$boss_id);
            //$message['newmsg'] = $operation['Remarks'];
            $Data['message'] = $message;
        } else {
            $boss = $usermodel->GetAllByKeyID($boss_id);
            $boss = $boss[0];
            $message['name'] = $user['ContactName'];
            $message['image'] = $user['Image'];
            $message['tel'] = $user['ContactTel'];
            //$operation = $account->GetOneByAgentID($agent_id);
            //$message['newmsg'] = $operation['Remarks'];
            $Data['message'] = $message;
        }
        $select = '';
        if ($level == 3) {
            //当前用户已开通G站的客户列表
            $select = 'select count(1) as Num from tb_customers_project where AgentID =' . $agent_id . ' and PC_model>0';
            $pcnum = $DB->Select($select);
            $select = 'select count(1) as Num from tb_customers_project where AgentID =' . $agent_id . ' and Mobile_model>0';
            $phonenum = $DB->Select($select);
            $agent_cusinfo['pcnum'] = $pcnum[0]['Num'];
            $agent_cusinfo['phonenum'] = $phonenum[0]['Num'];
        } elseif ($level == 2) {
            $select = 'select count(1) as Num from tb_customers_project c inner join tb_account b on b.BossAgentID=' . $agent_id . ' and  c.AgentID = b.AgentID where c.PC_model>0';
            $pcnum = $DB->Select($select);
            $select = 'select count(1) as Num from tb_customers_project c inner join tb_account b on b.BossAgentID=' . $agent_id . ' and  c.AgentID = b.AgentID where c.Mobile_model>0';
            $phonenum = $DB->Select($select);
            $agent_cusinfo['pcnum'] = $pcnum[0]['Num'];
            $agent_cusinfo['phonenum'] = $phonenum[0]['Num'];
        } elseif ($level == 1) {
            $select = 'select count(1) as Num from tb_customers_project where PC_model>0';
            $pcnum = $DB->Select($select);
            $select = 'select count(1) as Num from tb_customers_project where Mobile_model>0';
            $phonenum = $DB->Select($select);
            $agent_cusinfo['pcnum'] = $pcnum[0]['Num'];
            $agent_cusinfo['phonenum'] = $phonenum[0]['Num'];
        }
        //数据处理
        $h = date('G');
        if ($h < 11)
            $h = '上午好!';
        else if ($h < 13)
            $h = '中午好!';
        else if ($h < 17)
            $h = '下午好!';
        else
            $h = '晚上好!';
        $user_info['username'] = $user['ContactName'];
        $user_info['friendly'] = $h;
        $user_info['group'] = $user['Remarks'];
        $user_info['img'] = $user['Image'];
        $user_info['contacttel'] = $user['ContactTel'];
        $user_info['contactemail'] = $user['ContactEmail'];
        $user_info['balance'] = $money['Balance'];
        $user_info['consumption'] = $money['Pay'];
        $user_info['pcnum'] = $agent_cusinfo['pcnum'];
        $user_info['phonenum'] = $agent_cusinfo['phonenum'];
        $user_info['ip'] = GetIP();
        $user_info['lasttime'] = $user['LastTime'];
        $user_info['address'] = $user['ContactAddress'];
        //数据合并
        $Data['power'] = $user['Power'];
        $Data['user'] = $user_info;
        $Data['coustomer'] = $agent_cusinfo['cus'];
        $this->Data = $Data;
    }

    //代理商客服列表页面
    public function Process() {
        $this->MyAction = 'Process';
        $agent_id = $_SESSION ['AgentID'];
        $level = $_SESSION ['Level'];
        $power = $_SESSION ['Power'];
        //权限控制
        if ($level == 1) {
            $this->Type = true;     //是否是代理商
            $DB = new DB;
            $usermodel = new AccountModule;
            $where = 'where Level = 2';
            $count = $usermodel->GetListsNum($where);
            $Data['count'] = $count['Num'];
            $agentmsg = $usermodel->GetListsByWhere(array('AgentID', 'UserName', 'ContactName', 'ContactTel', 'ContactEmail'), $where . ' limit 0,8');
            $num = $DB->Select('select a.BossAgentID,b.AgentID,count(b.AgentID) Num from tb_account a inner join tb_customers_project b on a.AgentID = b.AgentID group by b.AgentID');
            foreach($agentmsg as $v){
                $Data['agentlist'][$v['AgentID']] = $v;
            }
            foreach($num as $v){
                if($v['BossAgentID'] == 0){
                    if($Data['agentlist'][$v['AgentID']]){
                        $Data['agentlist'][$v['AgentID']]['CusNum'] = $Data['agentlist'][$v['AgentID']]['CusNum'] ? $Data['agentlist'][$v['AgentID']]['CusNum'] : 0;
                        $Data['agentlist'][$v['AgentID']]['CusNum'] += $v['Num'];
                    }
                }else{
                    if($Data['agentlist'][$v['BossAgentID']]){
                        $Data['agentlist'][$v['BossAgentID']]['CusNum'] = $Data['agentlist'][$v['BossAgentID']]['CusNum'] ? $Data['agentlist'][$v['BossAgentID']]['CusNum'] : 0;
                        $Data['agentlist'][$v['BossAgentID']]['CusNum'] += $v['Num'];
                    }
                }
            }
        }elseif($level == 2){
            $this->Type = false;
            $agent = $this->GetAgentList('where BossAgentID=' . $agent_id, true);
            $Data['count'] = $agent['Num'];
            $Data['agentlist'] = $agent['AgentMsg'];
        }else{
            $result['err'] = 1001;
            $result['msg'] = '非法请求';
            echo jsonp($result);
            exit();
        }
        $this->Data = $Data;
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

    //用户信息展示和修改
    public function UserInfo() {
        $this->MyAction = 'UserInfo';
        $agent_id = (int) $_SESSION ['AgentID'];
        $usermodel = new AccountModule;
        $user = $usermodel->GetAllByKeyID($agent_id);
        $user = $user[0];
        $user['power'] = $_SESSION ['Power'];
        $this->Data = $user;
    }

}
