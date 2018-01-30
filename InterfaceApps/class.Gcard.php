<?php

class Gcard extends InterfaceVIEWS
{
	public function __Public()
    {
        IsLogin(true);
        // //控制器
        $this->MyModule = 'Gcard';
        global $function_config;
        $this->LogsFunction = new LogsFunction;
        $this->function_config = $function_config;
        // //权限代码
        $this->create = 'create';
        $this->renew = 'renew';
        $this->modify = 'modify';
        $this->transfer = 'transfer';
        $this->manage = 'manage';
        $this->delete = 'delete';
        //G名片价格
        $this->price = 600;
    }

    //客户开通G名片
    public function NewCus(){
    	$result = array('err' => 0, 'data' => '', 'msg' => '');
        $agent_id = (int)$_SESSION ['AgentID'];
        $power = $_SESSION ['Power'];
        $level = $_SESSION ['Level'];
        $post = $this->_POST;
        $agent = new AccountModule;
        $balance = new BalanceModule;        
        $agentinfo = $agent->GetOneInfoByKeyID($agent_id);
        if ($this->Assess($power, $this->create)) {
        	$Gcard = new GcardModule;
        	//提交的数据
            $crtdata ['account'] = trim($post ['account']);
        	$crtdata ['agent_id'] = $agent_id;
        	$crtdata ['company'] = trim($post ['companyname']);
            $crtdata ['name'] = trim($post ['username']);
            $crtdata ['email'] = trim($post ['email']);
            $crtdata ['tel'] = trim($post ['tel']);
            $crtdata ['address'] = trim($post ['address']);
            $crtdata ['num'] = trim($post ['num']) ? trim($post ['num']) : 10;
            //验证数据
            if(!($crtdata ['account'] && $crtdata ['company'] && $crtdata ['name'] && $crtdata ['tel'])) {
            	$result['err'] = 1002;
                $result['msg'] = '公司账号，名称，联系人，电话都不能为空';
                return $result;
            }
            //验证格式
            if (!preg_match("/^[a-zA-Z0-9][a-zA-Z0-9-]*[a-zA-Z0-9]$/", $crtdata['account'])) {
            	$result['err'] = 1003;
                $result['msg'] = '公司账号只能由数字和字母构成';
                return $result;
            }
            if($crtdata['email']) {
                $email_ptn = "/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i";
                if (!preg_match($email_ptn, $crtdata['email'])) {
                    $result['err'] = 1003;
                    $result['msg'] = '邮箱格式错误';
                    return $result;
                }
            }
            
	        //查看账号是否已存在
	        $GnameNum = $Gcard->GetListsNum("where account='" . $crtdata ['account'] . "'");
            if ($GnameNum ['Num'] > 0) {
                $result['err'] = 1004;
                $result['msg'] = '已存在账号'.$crtdata ['account'].'的客户，请更改账号名';
                $this->LogsFunction->LogsAgentRecord(331, 2, $agent_id, $result['msg']);
                return $result;
            }

            //计算费用
            $agentBalance = $balance->GetOneInfoByAgentID($agent_id);//当前账号的消费信息
            if ($level == 3) {
                $bossBalance = $balance->GetOneInfoByAgentID($agentinfo['BossAgentID']);//代理商消费信息
                if ($bossBalance['Balance'] < $this->price) {
                    $result['err'] = 1003;
                    $result['msg'] = '您的余额不足，请及时充值';
                    $this->LogsFunction->LogsCusRecord(331, 4, $cus_id, $result['msg']);
                    return $result;
                }
                //代理商消费计算
                $updatetime = explode('-', $bossBalance['UpdateTime']);
                $update_boss['CostMon'] = $bossBalance['CostMon'];
                if (date('m', time()) != $updatetime[1]) {
                    $update_boss['UpdateTime'] = date('Y-m-d', time());
                    $update_boss['CostMon'] = 0;
                }
                $update_boss['Balance'] = $bossBalance['Balance'] - $this->price;
                $update_boss['CostMon'] = $update_boss['CostMon'] + $this->price;
                $update_boss['CostAll'] = $bossBalance['CostAll'] + $this->price;
                //客服消费计算
                $updatetime = explode('-', $agentBalance['UpdateTime']);
                $update_self['CostMon'] = $agentBalance['CostMon'];
                if (date('m', time()) != $updatetime[1]) {
                    $update_self['UpdateTime'] = date('Y-m-d', time());
                    $update_self['CostMon'] = 0;
                }
                $update_self['CostMon'] = $update_self['CostMon'] + $this->price;
                $update_self['CostAll'] = $agentBalance['CostAll'] + $this->price;
                $balance_money = $update_boss['Balance'];
            } elseif ($level == 2) {
                if ($agentBalance['Balance'] < $price) {
                    $result['err'] = 1003;
                    $result['msg'] = '您的余额不足，请及时充值';
                    $this->LogsFunction->LogsCusRecord(331, 4, $cus_id, $result['msg']);
                    return $result;
                }
                $updatetime = explode('-', $agentBalance['UpdateTime']);
                $update_self['CostMon'] = $agentBalance['CostMon'];
                if (date('m', time()) != $updatetime[1]) {
                    $update_self['UpdateTime'] = date('Y-m-d', time());
                    $update_self['CostMon'] = 0;
                }
                $update_self['Balance'] = $agentBalance['Balance'] - $this->price;
                $update_self['CostMon'] = $update_self['CostMon'] + $this->price;
                $update_self['CostAll'] = $agentBalance['CostAll'] + $this->price;
                $balance_money = $update_self['Balance'];
            } else {
                $result['err'] = 1001;
                $result['msg'] = '非法请求-扣费';
                $this->LogsFunction->LogsCusRecord(331, 3, $cus_id, $result['msg']);
                return $result;
            }

	        //计算时间
	        if(!trim($post ['starttime'])) {
	        	$crtdata ['starttime'] = date('Y-m-d H:i:s' , time());
	        	$crtdata ['updatetime'] = $crtdata ['starttime'];
	        	$crtdata ['endtime'] = date('Y-m-d H:i:s' , strtotime('+1 year'));
	        } else {
	        	$crtdata ['starttime'] = trim($post ['starttime']);
	        	$crtdata ['updatetime'] = trim($post ['starttime']);
	        	$time = strtotime($crtdata ['starttime']);
	        	$crtdata ['endtime'] = date('Y-m-d H:i:s' , strtotime('+1 year' , $time));
	        }
	        //写入数据库
	        $cusID = $Gcard->InsertArray($crtdata, true);
	        if (!$cusID) {
	            $result['err'] = 1005;
	            $result['msg'] = '创建G名片客户'.$crtdata ['account'].'失败';
	            $this->LogsFunction->LogsAgentRecord(331, 0, $agent_id, $result['msg']);
	            return $result;
	        }

            //扣款
            if(!$balance->UpdateArrayByAgentID($update_self, $agentinfo['AgentID'])) {
                $Gcard->DeleteInfoByKeyID($cusID);//删除创建好的G名片
                $result['err'] = 1007;
                $result['msg'] = '当前账户扣费失败';
                $this->LogsFunction->LogsCusRecord(331, 4, $cusID, $result['msg']);
                return $result;
            }
            if($level == 3) {
                if(!$balance->UpdateArrayByAgentID($update_boss, $agentinfo['BossAgentID'])) {
                    $Gcard->DeleteInfoByKeyID($cusID);//删除创建好的G名片
                    $balance->UpdateArrayByAgentID($agentBalance, $agentinfo['AgentID']);//还原当前账号的扣款
                    $result['err'] = 1007;
                    $result['msg'] = '代理商扣费失败';
                    $this->LogsFunction->LogsCusRecord(331, 4, $cusID, $result['msg']);
                    return $result;
                }
            }

	        //同步到G名片
	        $res = $this->toGcard($crtdata);
            if($res['err'] == 1000) {
                $result['err'] = 0;
                $result['msg'] = '创建成功';
            } else {
                $Gcard->DeleteInfoByKeyID($cusID);
                $balance->UpdateArrayByAgentID($agentBalance, $agentinfo['AgentID']);//还原当前账号的扣款
                if($level == 3) {
                    $balance->UpdateArrayByAgentID($bossBalance, $agentinfo['BossAgentID']);//还原代理商的扣款
                }
                $result['err'] = 1006;
                $result['msg'] = $res['msg'] . ' - 创建失败,已删除该客户';
                $this->LogsFunction->LogsAgentRecord(331, 0, $agent_id, $result['msg']);
            }
        } else {
            $result['err'] = 1001;
            $result['msg'] = '非法请求';
            $this->LogsFunction->LogsAgentRecord(331, 0, $agent_id, $result['msg']);
        }
        return $result;
    }

    //同步G名片
    public function toGcard($data , $type = 'create') {
    	if(!$data) {
    		$result['err'] = 1001;
            $result['msg'] = '空数据';
            return $result;
    	}

    	//随机文件名开始生成
        $randomLock = getstr();
        $password = md5($randomLock);
        $password = md5($password);

        //生成握手密钥
        $text = getstr();

        //生成dll文件
        $myfile = @fopen('./token/' . $password . '.dll', "w+");
        if (!$myfile) {
            return 0;
        }
        fwrite($myfile, $text);
        fclose($myfile);

        $data['timemap'] = $randomLock;
        $data['taget'] = md5($text . $password);

        if($type == 'create') {
            $TuUrl = WEIMP_DOMAIN . 'api/createGcard';
        } elseif ($type == 'modify') {
            $TuUrl = WEIMP_DOMAIN . 'api/modifyGcard';
        } elseif ($type == 'renew') {
            $TuUrl = WEIMP_DOMAIN . 'api/renewGcard';
        } elseif ($type == 'delete') {
            $TuUrl = WEIMP_DOMAIN . 'api/deleteGcard';
        } else {
            $ReturnArray['err'] = 1001;
            $ReturnArray['msg'] = '非法类型';
            return $ReturnArray;
        }

        $ReturnString = curl_post($TuUrl, $data);
        $ReturnArray = json_decode($ReturnString, true);
        return $ReturnArray;
    }

    //权限判定
    private function Assess($power, $type = false) {
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

    //G名片列表页面初始化
    public function CusInit()
    {
        $result = array('err' => 0, 'data' => '', 'msg' => '');
        $agent_id = $_SESSION ['AgentID'];
        $power = $_SESSION ['Power'];
        $powerList = $this->Assess($power);
        $Data['operat'] = implode(',', $powerList);
        $Data['num'] = $this->GetCusNumByType(0);
        $result['data'] = $Data;
        return $result;
    }

    //G名片客户数量--数据提供
    public function GetCusNum()
    {
        $result = array('err' => 0, 'data' => '', 'msg' => '');
        $type = $this->_GET['type'];
        $result['data'] = $this->GetCusNumByType($type);
        return $result;
    }

    //根据类型获取想要的客户列表的数量
    protected function GetCusNumByType($type = 0)
    {
        $agent_id = $_SESSION ['AgentID'];
        $level = $_SESSION ['Level'];
        $DB = new DB;
        switch ($type) {
            case -1 :
                //搜索
                $where = '';
                if ($this->_GET['contact'] != '' || $this->_GET['name'] != '') {
                    $where .= $this->_GET['contact'] != '' ? ' and (b.company like "%' . $this->_GET['contact'] . '%" or b.name like "%' . $this->_GET['contact'] . '%") ' : '';
                    $where .= $this->_GET['name'] != '' ? ' and b.account like "%' . $this->_GET['name'] . '%" ' : '';
                } else
                    return false;
                break;            
            case 0 :
                //所有
                break;
            case 1 :
                //过期
                $now = date('Y-m-d H:i:s' , time());
                $where = ' and b.endtime < "' . $now . '" ';
                break;
            case 2 :
                //30天
                $now = date('Y-m-d H:i:s' , time());
                $after = $after = date("Y-m-d H:i:s", strtotime("+30 day"));
                $where = ' and b.endtime > "' . $now . '" and b.endtime < "' . $after . '" ';
                break;
            case 3 :
                //75天
                $now = date('Y-m-d H:i:s' , time());
                $after = $after = date("Y-m-d H:i:s", strtotime("+75 day"));
                $where = ' and b.endtime > "' . $now . '" and b.endtime < "' . $after . '" ';
                break;
            default:
                return false;
        }
        if($level == 1) {
            $select = 'select count(1) as Num from tb_account a inner join tb_gcard b on a.AgentID=b.agent_id where 1=1 ' . $where . $order . $limit;
            $cus = $DB->Select($select);
        } elseif($level == 2) {
            $cond = ' and (a.AgentID = "' . $agent_id . '" or a.BossAgentID = "' . $agent_id . '") ';
            $select = 'select count(1) as Num from tb_account a inner join tb_gcard b on a.AgentID=b.agent_id where 1=1 ' . $cond . $where . $order . $limit;
            $cus = $DB->Select($select);
        } elseif($level == 3) {
            $cond = ' and a.AgentID = "' . $agent_id . '" ';
            $select = 'select count(1) as Num from tb_account a inner join tb_gcard b on a.AgentID=b.agent_id where 1=1 ' . $cond . $where . $order . $limit;
            $cus = $DB->Select($select);
        } else {
            return false;
        }
        
        return $cus[0]['Num'];
    }

    //G名片列表
    public function GetCus() {
        $result = array('err' => 0, 'data' => '', 'msg' => '');        
        $type = $this->_GET['type'];//0-所有，1-过期，2-30天过期，3-75天过期(选项卡顺序)
        $page = floor($this->_GET['page']);//页码
        $num = floor($this->_GET['num']);//每页记录条数
        $data['cus'] = $this->GetCusByType($type,$page,$num);//获取数据
        $result['data'] = $data;
        return $result;
    }

    //G名片根据类型获取列表
    protected function GetCusByType($type = 0, $page = 1, $num = 5) {
        $agent_id = $_SESSION ['AgentID'];
        $level = $_SESSION ['Level'];
        $usernames = array();
        $account = new AccountModule();
        $account_infos = $account->GetListsByWhere(array("0" => "AgentID", "1" => "UserName"), array());
        foreach ($account_infos as $k => $v) {
            $usernames[$v["AgentID"]] = $v["UserName"];
        }
        $page = $page > 0 ? $page : 1;
        $num = $num > 0 ? $num : 5;
        $start = ($page - 1) * $num;
        $limit = ' limit ' . $start . ',' . $num;
        $order = ' order by b.id desc';
        $DB = new DB;
        switch ($type) { 
            case -1 :
                //搜索
                $where = '';
                if ($this->_GET['contact'] != '' || $this->_GET['name'] != '') {
                    $where .= $this->_GET['contact'] != '' ? ' and (b.company like "%' . $this->_GET['contact'] . '%" or b.name like "%' . $this->_GET['contact'] . '%") ' : '';
                    $where .= $this->_GET['name'] != '' ? ' and b.account like "%' . $this->_GET['name'] . '%" ' : '';
                } else
                    return false;
                break;            
            case 0 :
                //所有
                break;
            case 1 :
                //过期
                $now = date('Y-m-d H:i:s' , time());
                $where = ' and b.endtime < "' . $now . '" ';
                break;
            case 2 :
                //30天
                $now = date('Y-m-d H:i:s' , time());
                $after = $after = date("Y-m-d H:i:s", strtotime("+30 day"));
                $where = ' and b.endtime > "' . $now . '" and b.endtime < "' . $after . '" ';
                break;
            case 3 :
                //75天
                $now = date('Y-m-d H:i:s' , time());
                $after = $after = date("Y-m-d H:i:s", strtotime("+75 day"));
                $where = ' and b.endtime > "' . $now . '" and b.endtime < "' . $after . '" ';
                break;
            default:
                return false;
        }
        if($level == 1) {
            $select = 'select a.AgentID, a.UserName, b.id, b.account, b.company, b.starttime, b.endtime from tb_account a inner join tb_gcard b on a.AgentID=b.agent_id where 1=1 ' . $where . $order . $limit;
            $cus = $DB->Select($select);
        } elseif($level == 2) {
            $cond = ' and (a.AgentID = "' . $agent_id . '" or a.BossAgentID = "' . $agent_id . '") ';
            $select = 'select a.AgentID, a.UserName, b.id, b.account, b.company, b.starttime, b.endtime from tb_account a inner join tb_gcard b on a.AgentID=b.agent_id where 1=1 ' . $cond . $where . $order . $limit;
            $cus = $DB->Select($select);
        } elseif($level == 3) {
            $cond = ' and a.AgentID = "' . $agent_id . '" ';
            $select = 'select a.AgentID, a.UserName, b.id, b.account, b.company, b.starttime, b.endtime from tb_account a inner join tb_gcard b on a.AgentID=b.agent_id where 1=1 ' . $cond . $where . $order . $limit;
            $cus = $DB->Select($select);
        } else {
            return false;
        }

        return $cus;
    }

    //G名片修改续费转移操作数据生成
    public function Operation()
    {
        $result = array('err' => 1000, 'data' => '', 'msg' => '错误的指令--数据获取');
        $cus_id = (int)$this->_GET['cus'];
        if ($this->_GET['type'] && $cus_id) {
            $agent_id = $_SESSION ['AgentID'];
            $level = (int)$_SESSION ['Level'];
            $power = $_SESSION ['Power'];
            $Gcard = new GcardModule;
            $cus = $Gcard->GetOneByWhere('where id=' . $cus_id);
            if ($level == 3) {
                if ($cus['agent_id'] != $agent_id) {
                    $result['err'] = 1001;
                    $result['msg'] = '您没有此用户资料';
                    $this->LogsFunction->LogsCusRecord(332, 2, $cus_id, $result['msg']);
                    return $result;
                }
            } elseif ($level == 2) {
                if ($cus['agent_id'] != $agent_id) {
                    $agent = new AccountModule;
                    $agentinfo = $agent->GetOneInfoByKeyID($cus['agent_id']);
                    if ($agentinfo['BossAgentID'] != $agent_id) {
                        $result['err'] = 1002;
                        $result['msg'] = '您没有此用户资料';
                        $this->LogsFunction->LogsCusRecord(332, 2, $cus_id, $result['msg']);
                        return $result;
                    }
                }
            } elseif ($level == 1) {
                if (!$cus) {
                    $result['err'] = 1003;
                    $result['msg'] = '此用户资料不存在';
                    $this->LogsFunction->LogsCusRecord(332, 2, $cus_id, $result['msg']);
                    return $result;
                }
            } else {
                $result['err'] = 1004;
                $result['msg'] = '此用户资料不存在';
                $this->LogsFunction->LogsCusRecord(332, 2, $cus_id, $result['msg']);
                return $result;
            }
            $result = array('err' => 0, 'data' => '', 'msg' => '');
            $type = $this->_GET['type'];
            switch ($type) {
                case 'renew':
                    if ($this->Assess($power, $this->renew)) {
                        $data['name'] = $cus['account'];
                        $data['endtime'] = $cus['endtime'];
                        $result['data'] = $data;
                    } else {
                        $result['err'] = 1005;
                        $result['msg'] = '非法请求--续费';
                        $this->LogsFunction->LogsCusRecord(332, 3, $cus_id, $result['msg']);
                    }
                    break;
                case 'modify':
                    if ($this->Assess($power, $this->renew)) {
                        $data = array('account' => $cus['account'], 'company' => array('公司', $cus['company']), 'username' => array('联系人', $cus['name']), 'tel' => array('电话', $cus['tel']), 'email' => array('email', $cus['email']), 'address' => array('地址', $cus['address']));
                        $result['data'] = $data;
                    } else {
                        $result['err'] = 1005;
                        $result['msg'] = '非法请求--续费';
                        $this->LogsFunction->LogsCusRecord(332, 3, $cus_id, $result['msg']);
                    }
                    break;
                case 'transfer':
                    if ($this->Assess($power, $this->transfer)) {
                        $accountModel = new AccountModule;
                        $data['obj'] = false;
                        if ($level == 3) {
                            $agent = $accountModel->GetOneInfoByKeyID($agent_id);
                            $agent = $accountModel->GetListByBossAgentID($agent['BossAgentID'], array('ContactName', 'AgentID'));
                        } elseif ($level == 2) {
                            $agent = $accountModel->GetListByBossAgentID($agent_id, array('ContactName', 'AgentID'));
                        } else {
                            $where = ' where Level > 1';
                            $agent = $accountModel->GetListsByWhere(array('ContactName', 'AgentID'), $where);
                        }
                        $data['name'] = $cus['account'];
                        if ($agent) {
                            foreach ($agent as $v) {
                                if ($v['AgentID'] == $cus['agent_id'])
                                    continue;
                                else
                                    $data['obj'][$v['AgentID']] = $v['ContactName'];
                            }
                        }
                        $result['data'] = $data;
                    } else {
                        $result['err'] = 1002;
                        $result['msg'] = '非法请求--转移';
                        $this->LogsFunction->LogsCusRecord(115, 3, $cus_id, $result['msg']);
                    }
                    break;
                default:
                    $result['err'] = 1006;
                    $result['msg'] = '非法请求--非法字符';
                    $this->LogsFunction->LogsCusRecord(332, 3, $cus_id, $result['msg']);
                    break;
            }
        } else {
            $this->LogsFunction->LogsCusRecord(332, 3, $cus_id, $result['msg']);
        }
        return $result;
    }

    //G名片续费
    public function Renew()
    {
        $result = array('err' => 0, 'data' => '', 'msg' => '');
        $agent_id = (int)$_SESSION ['AgentID'];
        $level = (int)$_SESSION ['Level'];
        $power = (int)$_SESSION ['Power'];
        $cus_id = (int)$this->_POST['num'];
        $addyear = intval($this->_POST['yearnum']);
        if ($cus_id && $this->Assess($power, $this->renew) && $addyear > 0) {
            $agent = new AccountModule;
            $Gcard = new GcardModule;
            $balance = new BalanceModule;
            $data = $Gcard->GetOneByWhere('where id=' . $cus_id);//G名片当前信息
            $agentinfo = $agent->GetOneInfoByKeyID($data["agent_id"]);//G名片所属客服的信息
            $agent_bal = $balance->GetOneInfoByAgentID($agentinfo['AgentID']);//所属客服的消费信息
            if ($agentinfo["Level"] == 3) {                
                $boss_agent_bal = $balance->GetOneInfoByAgentID($agentinfo['BossAgentID']);//代理商消费信息
                unset($agent_bal['ID']);
                unset($boss_agent_bal['ID']);
            } elseif ($agentinfo["Level"] == 2 or $agentinfo["Level"] == 1) {
                unset($boss_agent_bal['ID']);
            } else {
                $result['err'] = 1001;
                $result['msg'] = '此用户资料不存在';
                $this->LogsFunction->LogsCusRecord(332, 2, $cus_id, $result['msg']);
                return $result;
            }
            if ($data) {
                $price = (int)$this->_POST['price'];
                //费用计算
                if ($agentinfo['Level'] == 3) {
                    if ($boss_agent_bal['Balance'] < $price) {
                        $result['err'] = 1003;
                        $result['msg'] = '您的余额不足，请及时充值';
                        $this->LogsFunction->LogsCusRecord(332, 4, $cus_id, $result['msg']);
                        return $result;
                    }
                    //代理商消费计算
                    $updatetime = explode('-', $boss_agent_bal['UpdateTime']);
                    $update_boss['CostMon'] = $boss_agent_bal['CostMon'];
                    if (date('m', time()) != $updatetime[1]) {
                        $update_boss['UpdateTime'] = date('Y-m-d', time());
                        $update_boss['CostMon'] = 0;
                    }
                    $update_boss['Balance'] = $boss_agent_bal['Balance'] - $price;
                    $update_boss['CostMon'] = $update_boss['CostMon'] + $price;
                    $update_boss['CostAll'] = $boss_agent_bal['CostAll'] + $price;
                    //客服消费计算
                    $updatetime = explode('-', $agent_bal['UpdateTime']);
                    $update_self['CostMon'] = $agent_bal['CostMon'];
                    if (date('m', time()) != $updatetime[1]) {
                        $update_self['UpdateTime'] = date('Y-m-d', time());
                        $update_self['CostMon'] = 0;
                    }
                    $update_self['CostMon'] = $update_self['CostMon'] + $price;
                    $update_self['CostAll'] = $agent_bal['CostAll'] + $price;
                    $balance_money = $update_boss['Balance'];
                } elseif ($agentinfo["Level"] == 2 or $agentinfo["Level"] == 1) {
                    if ($agent_bal['Balance'] < $price) {
                        $result['err'] = 1003;
                        $result['msg'] = '您的余额不足，请及时充值';
                        $this->LogsFunction->LogsCusRecord(332, 4, $cus_id, $result['msg']);
                        return $result;
                    }
                    $updatetime = explode('-', $agent_bal['UpdateTime']);
                    $update_self['CostMon'] = $agent_bal['CostMon'];
                    if (date('m', time()) != $updatetime[1]) {
                        $update_self['UpdateTime'] = date('Y-m-d', time());
                        $update_self['CostMon'] = 0;
                    }
                    $update_self['Balance'] = $agent_bal['Balance'] - $price;
                    $update_self['CostMon'] = $update_self['CostMon'] + $price;
                    $update_self['CostAll'] = $agent_bal['CostAll'] + $price;
                    $balance_money = $update_self['Balance'];
                } else {
                    $result['err'] = 1001;
                    $result['msg'] = '非法请求-扣费';
                    $this->LogsFunction->LogsCusRecord(332, 3, $cus_id, $result['msg']);
                }

                //续费时间
                $nowyear = (strtotime($data['endtime']) > time()) ? strtotime($data['endtime']) : time();
                $newyear = date('Y-m-d H:i:s', strtotime('+' . $addyear . ' year', $nowyear));
                $new_time['endtime'] = $newyear;
                $new_time['account'] = $data['account'];

                //扣费
                if (!$Gcard->UpdateArray(array('endtime' => $new_time['endtime']), $cus_id)) {
                    $result['err'] = 1004;
                    $result['msg'] = '续费失败';
                    $this->LogsFunction->LogsCusRecord(332, 0, $cus_id, $result['msg']);
                    return $result;
                }

                if(!$balance->UpdateArrayByAgentID($update_self, $agentinfo['AgentID'])) {
                    $Gcard->UpdateArray(array('endtime' => $data['endtime'], $cus_id));//还原G名片的到期时间
                    $result['err'] = 1007;
                    $result['msg'] = '当前账户扣费失败';
                    $this->LogsFunction->LogsCusRecord(331, 4, $cusID, $result['msg']);
                    return $result;
                }
                if($agentinfo['Level'] == 3) {
                    if(!$balance->UpdateArrayByAgentID($update_boss, $agentinfo['BossAgentID'])) {
                        $Gcard->UpdateArray(array('endtime' => $data['endtime'], $cus_id));//还原G名片的到期时间
                        $balance->UpdateArrayByAgentID($agent_bal, $agentinfo['AgentID']);//还原当前账号的扣款
                        $result['err'] = 1007;
                        $result['msg'] = '代理商扣费失败';
                        $this->LogsFunction->LogsCusRecord(331, 4, $cusID, $result['msg']);
                        return $result;
                    }
                }

                $IsOk = $this->toGcard($new_time , 'renew');
                if ($IsOk['err'] != 1000) {
                    $Gcard->UpdateArray(array('endtime' => $data['endtime'], $cus_id));//还原G名片的到期时间
                    $balance->UpdateArrayByAgentID($agent_bal, $agentinfo['AgentID']);//还原当前账号的扣款
                    if($agentinfo['Level'] == 3) {
                        $balance->UpdateArrayByAgentID($boss_agent_bal, $agentinfo['BossAgentID']);//还原代理商的扣款
                    }                    
                    $result['err'] = 1002;
                    $result['msg'] = $IsOk['msg'] . ' - 数据同步失败，请重试';
                    $this->LogsFunction->LogsCusRecord(332, 6, $cus_id, $result['msg']);
                    $result['data'] = $IsOk;
                    return $result;
                }

                $logcost_data = array("ip"          => $_SERVER["REMOTE_ADDR"], "cost" => (0 - $price), "type" => 2,
                                      "description" => "G名片续费", "adddate" => date('Y-m-d H:i:s', time()), "CustomersID" => $cus_id,
                                      "AgentID"     => $agent_id, "CostID" => $costID, "Balance" => $balance_money);
                $logcost = new LogcostModule();
                $logcost->InsertArray($logcost_data);
                $this->LogsFunction->LogsCusRecord(332, 5, $cus_id, '续费同步成功');
                $result['data']['name'] = $data['account'];
            } else {
                $result['err'] = 1003;
                $result['msg'] = '您没有此用户资料,或者此用户还未开通';
                $this->LogsFunction->LogsCusRecord(332, 2, $cus_id, $result['msg']);
            }
        } else {
            if ($this->Assess($power, $this->renew)) {
                $result['err'] = 1003;
                $result['msg'] = '非法操作,用户ID不存在';
                $this->LogsFunction->LogsCusRecord(332, 2, $cus_id, $result['msg']);
            } elseif ($addyear < 1) {
                $result['err'] = 1003;
                $result['msg'] = '非法操作，年份不得小于1年';
                $this->LogsFunction->LogsCusRecord(332, 3, $cus_id, $result['msg']);
            } else {
                $result['err'] = 1001;
                $result['msg'] = '非法请求';
                $this->LogsFunction->LogsCusRecord(332, 3, $cus_id, $result['msg']);
            }
        }
        return $result;
    }

    //G名片信息修改
    public function Modify() {
        $result = array('err' => 0, 'data' => '', 'msg' => '');
        $agent_id = (int)$_SESSION ['AgentID'];
        $power = (int)$_SESSION ['Power'];
        $level = (int)$_SESSION ['Level'];
        $cus_id = (int)$this->_POST['num'];
        if ($cus_id && $this->Assess($power, $this->modify)) {
            $data['company'] = $this->_POST['company'];
            $data['name'] = $this->_POST['username'];
            $data['email'] = $this->_POST['email'];
            $data['tel'] = $this->_POST['tel'];
            $data['address'] = $this->_POST['address'];
            $Gcard = new GcardModule;
            $cus = $Gcard->GetOneByWhere('where id=' . $cus_id);
            $data['account'] = $cus['account'];
            if ($cus) {
                if ($level == 3) {
                    if ($cus['agent_id'] != $agent_id) {
                        $result['err'] = 1003;
                        $result['msg'] = '您没有此用户资料';
                        $this->LogsFunction->LogsCusRecord(333, 2, $cus_id, $result['msg']);
                    }
                } elseif ($level == 2) {
                    if ($cus['agent_id'] != $agent_id) {
                        $agent = new AccountModule;
                        $agentinfo = $agent->GetOneInfoByKeyID($cus['agent_id']);
                        if ($agentinfo['BossAgentID'] != $agent_id) {
                            $result['err'] = 1003;
                            $result['msg'] = '您没有此用户资料';
                            $this->LogsFunction->LogsCusRecord(333, 2, $cus_id, $result['msg']);
                        }
                    }
                }
                $res = $this->toGcard($data , 'modify');
                if($res['err'] == 1000) {
                    if ($Gcard->UpdateArray($data, $cus_id)) {
                        $this->LogsFunction->LogsCusRecord(333, 1, $cus_id);
                        $result['data']['name'] = $data['account'];
                    } else {
                        $result['err'] = 1004;
                        $result['msg'] = '信息处理失败，请重试';
                        $this->LogsFunction->LogsCusRecord(333, 0, $cus_id, $result['msg']);
                    }
                } else {
                    $result['err'] = 1005;
                    $result['msg'] = $res['msg'] . ' - 数据同步失败，请重试';
                    $this->LogsFunction->LogsCusRecord(333, 0, $cus_id, $result['msg']);
                }                
            } else {
                $result['err'] = 1003;
                $result['msg'] = '此用户资料不存在';
                $this->LogsFunction->LogsCusRecord(333, 2, $cus_id, $result['msg']);
            }
        } else {
            $result['err'] = 1001;
            $result['msg'] = '非法请求';
            $this->LogsFunction->LogsCusRecord(333, 3, $cus_id, $result['msg']);
        }
        return $result;
    }

    //客户转移
    public function Custransfer() {
        $result = array('err' => 0, 'data' => '', 'msg' => '');
        $agent_id = (int)$_SESSION ['AgentID'];//当前操作账号
        $power = (int)$_SESSION ['Power'];
        $level = (int)$_SESSION ['Level'];
        $cus_id = (int)$this->_POST['num'];//客户id
        $exc = (int)$this->_POST['id'];//要转接的客服
        if ($cus_id && $exc && $this->Assess($power, $this->transfer)) {
            $accountModel = new AccountModule;
            $Gcard = new GcardModule;
            $cus = $Gcard->GetOneByWhere(array('account', 'agent_id'), 'where id=' . $cus_id);//客户信息
            $agent_msg = $accountModel->GetOneInfoByKeyID($agent_id);//当前账号信息            
            $exc_msg = $accountModel->GetOneInfoByKeyID($exc);//要转接的客服信息
            if ($cus) {
                if($level == 3) {
                    if($cus['agent_id'] == $agent_id) {//该客服是否属于该客服
                        if ($agent_msg['BossAgentID'] == $exc_msg['BossAgentID']) {
                            $Gcard->UpdateArray(array('agent_id' => $exc), $cus_id);
                            $result['data'] = array('name' => $cus['account']);
                            $this->LogsFunction->LogsCusRecord(334, 1, $cus_id);
                            // $this->LogsFunction->LogsCusExc(1, $agent_id, $exc, '转移成功');
                        } else {
                            $result['err'] = 1003;
                            $result['msg'] = '非法操作,非同一代理商下的客户';
                            $this->LogsFunction->LogsCusRecord(334, 2, $cus_id, '非同一代理商下的客户');
                            // $this->LogsFunction->LogsCusExc(0, $agent_id, $exc, $cus_id, '非同一代理商下的客户');
                        }
                    } else {
                        $result['err'] = 1004;
                        $result['msg'] = '您没有此用户资料';
                        $this->LogsFunction->LogsCusRecord(334, 2, $cus_id, $result['msg']);
                        // $this->LogsFunction->LogsCusExc(0, $agent_id, $exc, $result['msg']);
                    }                    
                } elseif ($level == 2) {
                    if($cus['agent_id'] == $agent_id) {//该账号是否直属于该代理商
                        $Gcard->UpdateArray(array('agent_id' => $exc), $cus_id);
                        $result['data'] = array('name' => $cus['account']);
                        $this->LogsFunction->LogsCusRecord(334, 1, $cus_id);
                        // $this->LogsFunction->LogsCusExc(1, $agent_id, $exc, '转移成功');
                    } else {
                        $agent = $accountModel->GetOneInfoByKeyID($cus['agent_id']);//当前客服信息
                        if($agent['BossAgentID'] == $agent_id) {//该账号的客服是否属于该代理商
                            if($exc_msg['BossAgentID'] == $agent_id) {//要转接的客服是否同样属于该代理商
                               $Gcard->UpdateArray(array('agent_id' => $exc), $cus_id);
                                $result['data'] = array('name' => $cus['account']);
                                $this->LogsFunction->LogsCusRecord(334, 1, $cus_id);
                                // $this->LogsFunction->LogsCusExc(1, $agent_id, $exc, '转移成功'); 
                            }
                        } else {
                            $result['err'] = 1004;
                            $result['msg'] = '您没有此用户资料';
                            $this->LogsFunction->LogsCusRecord(334, 2, $cus_id, $result['msg']);
                            // $this->LogsFunction->LogsCusExc(0, $agent_id, $exc, $result['msg']);
                        }
                    }
                } elseif ($level == 1) {
                    $Gcard->UpdateArray(array('agent_id' => $exc), $cus_id);
                    $result['data'] = array('name' => $cus['account']);
                    $this->LogsFunction->LogsCusRecord(334, 1, $cus_id);
                    // $this->LogsFunction->LogsCusExc(1, $agent_id, $exc, '转移成功');
                }
            } else {
                $result['err'] = 1002;
                $result['msg'] = '此用户不存在';
                $this->LogsFunction->LogsCusRecord(334, 2, $cus_id, $result['msg']);
                // $this->LogsFunction->LogsCusExc(0, $agent_id, $exc, $result['msg']);
            }
        } else {
            $result['err'] = 1001;
            $result['msg'] = '非法请求';
            $this->LogsFunction->LogsCusRecord(334, 3, $cus_id, $result['msg']);
            // $this->LogsFunction->LogsCusExc(0, $agent_id, $exc, $result['msg']);
        }
        return $result;
    }

    public function DeleteGcard()
    {
        $result = array('err' => 0, 'data' => '', 'msg' => '');
        $level = $_SESSION["Level"];
        $Agent_id = $_SESSION ['AgentID'];
        $power = $_SESSION ['Power'];
        $id = $this->_POST ['num'];
        if ($id != 0 && $this->Assess($power, $this->delete)) {
            $GcardModule = new GcardModule ();
            $Usermodel = new AccountModule;
            $Users = $Usermodel->GetListsByWhere(array('AgentID'), 'where BossAgentID=' . $Agent_id);
            foreach ($Users as $k => $v) {
                $Users[$k] = $v['AgentID'];
            }
            $GcardInfo = $GcardModule->GetOneByWhere('where id=' . $id);
            if (!in_array($GcardInfo['AgentID'], $Users) && $level != 1) {
                $result['err'] = 1001;
                $result['msg'] = '您没有这个用户的信息';
                $this->LogsFunction->LogsAgentRecord(335, 2, $id, $result['msg']);
                return $result;
            }
            $data['account'] = $GcardInfo['account'];
            $res = $this->toGcard($data , 'delete');
            if($res['err'] == 1000) {
                $del = $GcardModule->DeleteInfoByKeyID($GcardInfo['id']);
                if($del) {
                    $result['data'] = array('name' => $GcardInfo['account']);
                    $this->LogsFunction->LogsAgentRecord(335, 1, $id, $result['msg']);
                } else {
                    $result['err'] = 1003;
                    $result['msg'] = '本地删除失败';
                    $this->LogsFunction->LogsAgentRecord(335, 2, $id, $result['msg']);
                }                
            } else {
                $result['err'] = 1002;
                $result['msg'] = $res['msg'];
                $this->LogsFunction->LogsAgentRecord(335, 6, $id, $result['msg']);
            }
        } else {
            $result['err'] = 1001;
            $result['msg'] = '非法请求';
            $this->LogsFunction->LogsCusRecord(335, 3, $id, $result['msg']);
        }

        return $result;
    }


}