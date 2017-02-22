<?php

class Api extends ForeVIEWS {

    public function index() {
        //http://cpanel.com/index.php?module=api&action=index
        $public = $this->_GET ['token'];
        if ($public == '') {
            dd(11);
            exit;
        } else {
            $code = '';
            $AgentApiModule = new AgentApiModule();
            $where = "where public='$public'";
            $AgentoInfo = $AgentApiModule->GetLists($where);
            if (!empty($AgentoInfo)) {
                $code = $AgentoInfo[0]['code'];
                $update['code_temp'] = $code;
                $time = time();
                $str = $AgentoInfo[0]['private'] . $time . $AgentoInfo[0]['AgentID'];
                $update['code'] = sha1($str);
                $AgentApiModule->UpdateArrayByKeyID($update, $AgentoInfo[0]['id']);
            }
            echo $code;
            exit;
        }
    }

    public function verify($verify = array(), $token = '') {
        sort($verify, SORT_STRING);
        $tmpStr = implode($verify);
        $code = sha1($tmpStr);
        if ($token == $code) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function fcreate() {
        $public = array();
        $AgentID = $this->_POST['agentid'];
        $token = $this->_POST['_token'];
        $timemap = $this->_POST['timemap'];
        $public['AgentID'] = $AgentID;
        $public['timemap'] = $timemap;
        $AgentApiModule = new AgentApiModule();
        $AgentApiInfo = $AgentApiModule->GetOneInfoByForID($AgentID);
        if ($AgentID == '' || $token == '' || $timemap = '' || empty($AgentApiInfo) ) {
            die(jsonp(array('0', '数据提供错误'), 'JSONP'));
        }
        $type = $this->_POST['type'];
        $public['private'] = $AgentApiInfo['private'];
        $verify = $this->verify($public, $token);
        if ($verify) {
            $username = $this->_POST['username'];
            $company = $this->_POST['company'];
            $realname = $this->_POST['realname'];
            $phone = $this->_POST['phone'];
            $fax = $this->_POST['fax'];
            $email = $this->_POST['email'];
            $address = $this->_POST['address'];
            $weixinname = $this->_POST['weixinname'];
            $weixinid = $this->_POST['weixinid'];
            $weixnno = $this->_POST['weixnno'];
            $remark = $this->_POST['remark'];
            $CustomersModule = new CustomersModule();
            $CustProModule = new CustProModule();
            $where = "where CompanyName='$company'";
            $num = $CustomersModule->GetListsNum($where);
            if ($num['Num']) {
                $where = "CompanyName='$company' and AgentID=$AgentID";
                if ($realname != '') {
                    $update['CustomersName'] = $realname;
                }
                if ($phone != '') {
                    $update['Tel'] = $phone;
                }
                if ($fax != '') {
                    $update['Fax'] = $fax;
                }
                if ($email != '') {
                    $update['Email'] = $email;
                }
                if ($address != '') {
                    $update['Addresss'] = $address;
                }
                $update['UpdateTime'] = date('Y-m-d');
                if ($CustomersModule->UpdateWhere($update, $where)) {
                    $SelectID = $CustomersModule->GetOneInfoByArrayKeys();
                    $id = $SelectID['CustomersID'];
                    $message = '已更新'.$company.'公司的信息';
                    $show = array('err' => 0, 'msg' => $message);
                } else {
                    $show = array('err' => 1001, 'msg' => '更新客户信息失败');
                }
            } else {
                if ($company == '') {
                    $show = array('err' => 1001, 'msg' => '提供一个空的公司名，无法进行处理');
                } else {
                    $insert = array(
                        'CompanyName' => $company,
                        'CustomersName' => $realname,
                        'Tel' => $phone,
                        'Fax' => $fax,
                        'Email' => $email,
                        'Address' => $address,
                        'AgentID' => $AgentID
                    );
                    if ($CustomersModule->InsertArray($insert)) {
                        $id = mysql_insert_id();
                        $show = array('err' => 0, 'msg' => '成功添加一个新的风信客户记录');
                    } else {
                        $show = array('err' => 1001, 'msg' => '添加新的客户记录失败');
                    }
                }
            }
            if ($weixinid != '') {
                $fengxin['AddTime'] = date('Y-m-d');
                $fengxing['StartTime'] = $fengxin['AddTime'];
                $fengxing['EndTime'] = date('Y-m-d',strtotime("$fengxin[AddTime] + 7 days"));
                $fengxing['CustomersID'] = $id;
                $fengxing['WeiXinName'] = $weixinname;
                $fengxing['WeiXinID'] = $weixinid;
                $fengxing['WeiXinNO'] = $weixnno;
                $fengxing['FengXinUserName'] = $username;
                $CustProModule->InsertArray();
                $show['msg'] = $show['msg'] + '，创建风信账号成功';
            }
        } else {
            $show = array('err' => 1001, 'msg' => '提供信息错误，无法进行处理');
        }
        die(jsonp($show, 'JSONP'));
    }
    
    public function gcreate() {
        $public = array();
        $AgentID = $this->_POST['agentid'];
        $token = $this->_POST['_token'];
        $timemap = $this->_POST['timemap'];
        $public['AgentID'] = $AgentID;
        $public['timemap'] = $timemap;
        $AgentApiModule = new AgentApiModule();
        $AgentApiInfo = $AgentApiModule->GetOneInfoByForID($AgentID);
        if ($AgentID == '' || $token == '' || $timemap = '' || empty($AgentApiInfo) ) {
            die(jsonp(array('0', '数据提供错误'), 'JSONP'));
        }
        $type = $this->_POST['type'];
        $public['private'] = $AgentApiInfo['private'];
        $verify = $this->verify($public, $token);
        if ($verify) {
            $username = $this->_POST['username'];
            $company = $this->_POST['company'];
            $realname = $this->_POST['realname'];
            $phone = $this->_POST['phone'];
            $fax = $this->_POST['fax'];
            $email = $this->_POST['email'];
            $address = $this->_POST['address'];
            $weixinname = $this->_POST['weixinname'];
            $weixinid = $this->_POST['weixinid'];
            $weixnno = $this->_POST['weixnno'];
            $remark = $this->_POST['remark'];
            $CustomersModule = new CustomersModule();
            $CustProModule = new CustProModule();
            $where = "where CompanyName='$company'";
            $num = $CustomersModule->GetListsNum($where);
            if ($num['Num']) {
                $where = "CompanyName='$company' and AgentID=$AgentID";
                if ($realname != '') {
                    $update['CustomersName'] = $realname;
                }
                if ($phone != '') {
                    $update['Tel'] = $phone;
                }
                if ($fax != '') {
                    $update['Fax'] = $fax;
                }
                if ($email != '') {
                    $update['Email'] = $email;
                }
                if ($address != '') {
                    $update['Addresss'] = $address;
                }
                $update['UpdateTime'] = date('Y-m-d');
                if ($CustomersModule->UpdateWhere($update, $where)) {
                    $SelectID = $CustomersModule->GetOneInfoByArrayKeys();
                    $id = $SelectID['CustomersID'];
                    $message = '已更新'.$company.'公司的信息';
                    $show = array('err' => 0, 'msg' => $message);
                } else {
                    $show = array('err' => 1001, 'msg' => '更新客户信息失败');
                }
            } else {
                if ($company == '') {
                    $show = array('err' => 1001, 'msg' => '提供一个空的公司名，无法进行处理');
                } else {
                    $insert = array(
                        'CompanyName' => $company,
                        'CustomersName' => $realname,
                        'Tel' => $phone,
                        'Fax' => $fax,
                        'Email' => $email,
                        'Address' => $address,
                        'AgentID' => $AgentID
                    );
                    if ($CustomersModule->InsertArray($insert)) {
                        $id = mysql_insert_id();
                        $show = array('err' => 0, 'msg' => '成功添加一个新的风信客户记录');
                    } else {
                        $show = array('err' => 1001, 'msg' => '添加新的客户记录失败');
                    }
                }
            }
            if ($domain != '') {
                $gbaopen['AddTime'] = date('Y-m-d');
                $gbaopen['StartTime'] = $fengxin['AddTime'];
                $gbaopen['EndTime'] = date('Y-m-d',strtotime("$fengxin[AddTime] + 7 days"));
                $gbaopen['CustomersID'] = $id;
                $gbaopen['G_domain'] = $domain;
                $fengxing['G_beian'] = $isbeian;
                $fengxing['G_name'] = $username;
                $CustProModule->InsertArray();
                $show['msg'] = $show['msg'] + '，创建G宝盆账号成功';
            }
        } else {
            $show = array('err' => 1001, 'msg' => '提供信息错误，无法进行处理');
        }
        print_r($show);
        die(jsonp($show, 'JSONP'));
    }
    
    public function fedit(){
        $public = array();
        $AgentID = $this->_POST['agentid'];
        $token = $this->_POST['_token'];
        $timemap = $this->_POST['timemap'];
        $public['AgentID'] = $AgentID;
        $public['timemap'] = $timemap;
        $AgentApiModule = new AgentApiModule();
        $AgentApiInfo = $AgentApiModule->GetOneInfoByForID($AgentID);
        if ($AgentID == '' || $token == '' || $timemap = '' || empty($AgentApiInfo) ) {
            die(jsonp(array('0', '数据提供错误'), 'JSONP'));
        }
        $type = $this->_POST['type'];
        $id = $this->_POST['pid'];
        $public['private'] = $AgentApiInfo['private'];
        $verify = $this->verify($public, $token);
        if ($verify && $id!='') {
            $edit['FengXinUserName'] = $this->_POST['username'];
            $edit['WeiXinName'] = $this->_POST['weixinname'];
            $edit['WeiXinID'] = $this->_POST['weixinid'];
            $edit['WeiXinNO'] = $this->_POST['weixnno'];
            $edit['Remark'] = $this->_POST['remark'];
            $edit['status'] = $this->_POST['status'];
            $CustProModule = new CustProModule();
            if($CustProModule->UpdateArrayByKeyID($edit,$id)){
                die(jsonp(array('0', '修改成功'), 'JSONP'));
            }
            else{
                die(jsonp(array('1001', '数据提供错误'), 'JSONP'));
            }
        }
        else{
            die(jsonp(array('1001', '数据提供错误'), 'JSONP'));
        }
    }
    
    public function gedit(){
        $public = array();
        $AgentID = $this->_POST['agentid'];
        $token = $this->_POST['_token'];
        $timemap = $this->_POST['timemap'];
        $public['AgentID'] = $AgentID;
        $public['timemap'] = $timemap;
        $AgentApiModule = new AgentApiModule();
        $AgentApiInfo = $AgentApiModule->GetOneInfoByForID($AgentID);
        if ($AgentID == '' || $token == '' || $timemap = '' || empty($AgentApiInfo) ) {
            die(jsonp(array('0', '数据提供错误'), 'JSONP'));
        }
        $type = $this->_POST['type'];
        $id = $this->_POST['pid'];
        $public['private'] = $AgentApiInfo['private'];
        $verify = $this->verify($public, $token);
        if ($verify && $id!='') {
            $edit['FengXinUserName'] = $this->_POST['username'];
            $edit['WeiXinName'] = $this->_POST['weixinname'];
            $edit['WeiXinID'] = $this->_POST['weixinid'];
            $edit['WeiXinNO'] = $this->_POST['weixnno'];
            $edit['Remark'] = $this->_POST['remark'];
            $edit['status'] = $this->_POST['status'];
            $CustProModule = new CustProModule();
            if($CustProModule->UpdateArrayByKeyID($edit,$id)){
                die(jsonp(array('0', '修改成功'), 'JSONP'));
            }
            else{
                die(jsonp(array('1001', '数据提供错误'), 'JSONP'));
            }
        }
        else{
            die(jsonp(array('1001', '数据提供错误'), 'JSONP'));
        }
    }
    
    public function fdelete(){
        $public = array();
        $AgentID = $this->_POST['agentid'];
        $token = $this->_POST['_token'];
        $timemap = $this->_POST['timemap'];
        $public['AgentID'] = $AgentID;
        $public['timemap'] = $timemap;
        $AgentApiModule = new AgentApiModule();
        $AgentApiInfo = $AgentApiModule->GetOneInfoByForID($AgentID);
        if ($AgentID == '' || $token == '' || $timemap = '' || empty($AgentApiInfo) ) {
            die(jsonp(array('0', '数据提供错误'), 'JSONP'));
        }
        $type = $this->_POST['type'];
        $id = $this->_POST['pid'];
        $public['private'] = $AgentApiInfo['private'];
        $verify = $this->verify($public, $token);
        if ($verify && $id!='') {
            $CustProModule = new CustProModule();
            $where = "where CustomersProjectID=$id and AgentID=$AgentID";
            if($CustProModule->DeleteInfoByWhere($where)){
                die(jsonp(array('0', '删除成功'), 'JSONP'));
            }
            else{
                die(jsonp(array('1001', '数据提供错误'), 'JSONP'));
            }
        }
        else{
            die(jsonp(array('1001', '数据提供错误'), 'JSONP'));
        }
    }
    
    public function gdelete(){
        $public = array();
        $AgentID = $this->_POST['agentid'];
        $token = $this->_POST['_token'];
        $timemap = $this->_POST['timemap'];
        $public['AgentID'] = $AgentID;
        $public['timemap'] = $timemap;
        $AgentApiModule = new AgentApiModule();
        $AgentApiInfo = $AgentApiModule->GetOneInfoByForID($AgentID);
        if ($AgentID == '' || $token == '' || $timemap = '' || empty($AgentApiInfo) ) {
            die(jsonp(array('0', '数据提供错误'), 'JSONP'));
        }
        $type = $this->_POST['type'];
        $id = $this->_POST['pid'];
        $public['private'] = $AgentApiInfo['private'];
        $verify = $this->verify($public, $token);
        if ($verify && $id!='') {
            $CustProModule = new CustProModule();
            $where = "where CustomersProjectID=$id and AgentID=$AgentID";
            if($CustProModule->DeleteInfoByWhere($where)){
                die(jsonp(array('0', '删除成功'), 'JSONP'));
            }
            else{
                die(jsonp(array('1001', '数据提供错误'), 'JSONP'));
            }
        }
        else{
            die(jsonp(array('1001', '数据提供错误'), 'JSONP'));
        }
    }
    
    
    public function frenewals(){
        $public = array();
        $AgentID = $this->_POST['agentid'];
        $token = $this->_POST['_token'];
        $timemap = $this->_POST['timemap'];
        $public['AgentID'] = $AgentID;
        $public['timemap'] = $timemap;
        $AgentApiModule = new AgentApiModule();
        $AgentApiInfo = $AgentApiModule->GetOneInfoByForID($AgentID);
        if ($AgentID == '' || $token == '' || $timemap = '' || empty($AgentApiInfo) ) {
            die(jsonp(array('0', '数据提供错误'), 'JSONP'));
        }
        $type = $this->_POST['type'];
        $years = $this->_POST['years'];
        $id = $this->_POST['pid'];
        $public['private'] = $AgentApiInfo['private'];
        $verify = $this->verify($public, $token);
        if ($verify && $id!='') {
            $CustProModule = new CustProModule();
            $where = "where CustomersProjectID=$id and AgentID=$AgentID";
            $CustProInfo = $CustProModule->GetInfoByWhere($where);
            $OldEndTime= $CustProInfo['EndTime'];
            if(strtotime($OldEndTime)<time()){
                $NewEndTime = date('Y-m-d H:i:s',strtotime("now + $years Years"));
            }
            else{
                $NewEndTime = date('Y-m-d H:i:s',strtotime("$OldEndTime + $years Years"));
            }
            $Update['EndTime'] = $NewEndTime;
            $filter['CustomersProjectID'] = $id;
            $filter['AgentID'] = $AgentID;
            if($CustProModule->UpdateArray($Update,$filter)){
                die(jsonp(array('0', '续费成功'), 'JSONP'));
            }
            else{
                die(jsonp(array('1001', '续费失败'), 'JSONP'));
            }
        }
        else{
            die(jsonp(array('1001', '数据提供错误'), 'JSONP'));
        }
    }
    
    
    public function grenewals(){
        $public = array();
        $AgentID = $this->_POST['agentid'];
        $token = $this->_POST['_token'];
        $timemap = $this->_POST['timemap'];
        $public['AgentID'] = $AgentID;
        $public['timemap'] = $timemap;
        $AgentApiModule = new AgentApiModule();
        $AgentApiInfo = $AgentApiModule->GetOneInfoByForID($AgentID);
        if ($AgentID == '' || $token == '' || $timemap = '' || empty($AgentApiInfo) ) {
            die(jsonp(array('0', '数据提供错误'), 'JSONP'));
        }
        $type = $this->_POST['type'];
        $years = $this->_POST['years'];
        $id = $this->_POST['pid'];
        $public['private'] = $AgentApiInfo['private'];
        $verify = $this->verify($public, $token);
        if ($verify && $id!='') {
            $CustProModule = new CustProModule();
            $where = "where CustomersProjectID=$id and AgentID=$AgentID";
            $CustProInfo = $CustProModule->GetInfoByWhere($where);
            $OldEndTime= $CustProInfo['EndTime'];
            if(strtotime($OldEndTime)<time()){
                $NewEndTime = date('Y-m-d H:i:s',strtotime("now + $years Years"));
            }
            else{
                $NewEndTime = date('Y-m-d H:i:s',strtotime("$OldEndTime + $years Years"));
            }
            $Update['EndTime'] = $NewEndTime;
            $filter['CustomersProjectID'] = $id;
            $filter['AgentID'] = $AgentID;
            if($CustProModule->UpdateArray($Update,$filter)){
                die(jsonp(array('0', '续费成功'), 'JSONP'));
            }
            else{
                die(jsonp(array('1001', '续费失败'), 'JSONP'));
            }
        }
        else{
            die(jsonp(array('1001', '数据提供错误'), 'JSONP'));
        }
    }

    public function showList() {
        $public = $this->_POST['_code'];
        $token = $this->_POST['_token'];
        $From = $this->_POST['fistid'] ? $this->_POST['fistid'] : 0;
        $Pagesize = $this->_POST['num'] ? ($this->_POST['num'] + 1) : 11;
        $AgentID = $this->verify($public, $token);
        if ($AgentID) {
            $CustomersModule = new CustomersModule();
            $CustProModule = new CustProModule();
            $where = "where AgentID=$AgentID";
            $CustProInfo = $CustProModule->GetLists($where, $From, $Pagesize);
            foreach ($CustProInfo as $k => $v) {
                $show[$k]['id'] = $v['CustomersProjectID'];
                $show[$k]['project_name'] = $this->GetNamebyProjectID($v['ProjectID']);
                $show[$k]['create_at'] = $v['AddTime'];
                $show[$k]['begin_at'] = $v['StartTime'];
                $show[$k]['end_at'] = $v['EndTime'];
                $show[$k]['status'] = $v['status'];
                $CustomerInfo = $CustomersModule->GetOneInfoByKeyID($v['CustomersID']);
                $show[$k]['company'] = $CustomerInfo['CompanyName'];
                $show[$k]['customer'] = $CustomerInfo['CustomersName'];
                $show[$k]['phone'] = $CustomerInfo['Tel'];
                $show[$k]['email'] = $CustomerInfo['Email'];
                $show[$k]['Vesion'] = $v['GongNeng'];
                $show[$k]['others'] = '';
            }
        } else {
            $show = array(0);
        }
        die(jsonp($show, 'JSONP'));
    }

    /* 获取风信,G宝盆,风帆的项目id
     * add by caicai
     * 参数：$projectname 项目名(风信、G宝盆、风帆)
     */

    public function GetProjectID($projectname = '') {
        $ProjectModule = new ProjectModule ();
        $MysqlWhere = " where $ProjectModule->ProjectName='$projectname'";
        $ProjectList = $ProjectModule->GetProjectLists($MysqlWhere);
        $FengxinID = $ProjectList[0]['ProjectID'];
        return $FengxinID;
    }

    /*
     * 根据项目id获取项目名(风信、G宝盆、风帆)
     * 参数：$id 项目id
     */

    public function GetNamebyProjectID($id = '') {
        $ProjectModule = new ProjectModule ();
        $ProjectInfo = $ProjectModule->GetOneInfoByKeyID($id);
        return $ProjectInfo['ProjectName'];
    }

    /*
     * 根据版本id获取版本名称
     * 参数：$id  版本id
     */

    public function GetNamebyPropertyID($id = '') {
        $PropertyModule = new PropertyModule ();
        $PropertyModule = $PropertyModule->GetOneInfoByKeyID($id);
        return $PropertyModule['ProjectPropertyName'];
    }

    function EditCustomerFengxinInfo() {
        $filters = array();
        $filters2 = array();
        $CustomersModule = new CustomersModule();
        $CustProModule = new CustProModule();
        if (isset($this->_POST)) {
            $CustomersID = intval($this->_POST ['CustomersID']);
            $ProjectId = intval($this->GetFengxinID());
            $sql = "Where CustomersID=$CustomersID and ProjectID=$ProjectId and AgentID=$_SESSION[AgentID]";
            $filters2['CustomersID'] = $CustomersID;
            $filters2['AgentID'] = intval($_SESSION['AgentID']);
            $filters2['ProjectID'] = $ProjectId;
            $IsFengxingCustom = $CustProModule->GetInfoByWhere($sql);
            $LogsFunction = new LogsFunction();
            if (!empty($IsFengxingCustom)) {
                $DB = new DB();
                $Data['Remark'] = $this->_POST['Remark'];
                $DataCustoms['AgentID'] = $_SESSION['AgentID'];
                $Data['CustomersID'] = $CustomersID;
                $Data['UpdateTime'] = date('Y-m-d H:i:s', time());
                $Data['FengXinUserName'] = $this->_POST['FengXinUserName'];
                $Data['WeiXinName'] = $this->_POST['WeiXinName'];
                $Data['WeiXinID'] = $this->_POST['WeiXinID'];
                $Data['WeiXinNO'] = $this->_POST['WeiXinNO'];
                $FengXinUserNameNum = $CustProModule->GetListsNum("where WeiXinID='$Data[WeiXinID]' and CustomersID!=$CustomersID");
                if ($FengXinUserNameNum ['Num'] > 0) {
                    $LogsFunction->logsinfile('107', 2, $CustomersID);
                    JsMessage('该风信账户已经被使用!');
                }
                if (isset($this->_POST['StartTime'])) {
                    $Data['StartTime'] = $this->_POST['StartTime'];
                }
                if ($DB->UpdateArray($CustProModule->TableName, $Data, $filters2)) {
                    $this->ToFengXinEditInfo($IsFengxingCustom['CustomersProjectID']);
                    $LogsFunction->logsinfile('107', 1, $CustomersID);
                    JsMessage('修改客户风信资料成功!', UrlRewriteSimple($this->MyModule, 'Customer', true) . '&Page=' . $Page, '继续操作');
                } else {
                    $LogsFunction->logsinfile('107', 0, $CustomersID);
                    JsMessage('修改客户失败,请再一次尝试!');
                }
            } else {
                if (isset($this->_POST['create']) && isset($this->_POST['new'])) {

                    $Custom['CompanyName'] = $this->_POST['CompanyName'];
                    $Custom['CustomersName'] = $this->_POST['CustomersName'];
                    $Custom['Tel'] = $this->_POST['Tel'];
                    $Custom['Email'] = $this->_POST['Email'];
                    $Custom['Address'] = $this->_POST['Address'];
                    $Custom['Fax'] = $this->_POST['Fax'];
                    $Custom['AddTime'] = date('Y-m-d H:i:s', time());
                    $Custom['UpdateTime'] = $Custom['AddTime'];
                    $Custom['Address'] = $this->_POST['Address'];
                    $Custom['Address'] = $this->_POST['Address'];
                    $Custom['Remark'] = $this->_POST['Remark'];
                    $Custom['AgentID'] = $_SESSION['AgentID'];
                    $CustomersModule->InsertArray($Custom);
                    $CustomersID = mysql_insert_id();
                }
                $Data['ProjectID'] = $ProjectId;
                $Data['AgentID'] = $_SESSION['AgentID'];
                $Data['Remark'] = $this->_POST['Remark'];
                $Data['CustomersID'] = $CustomersID;
                $Data['AddTime'] = date('Y-m-d H:i:s', time());
                $Data['UpdateTime'] = $Data['AddTime'];
                $Data['StartTime'] = $Data['AddTime'];
                $Data['EndTime'] = date('Y-m-d H:i:s', strtotime("$Data[StartTime]+ 7 day"));
                $Data['FengXinUserName'] = $this->_POST['FengXinUserName'];
                $Data['AddTime'] = $Data['UpdateTime'];
                $Data['WeiXinName'] = $this->_POST['WeiXinName'];
                $Data['WeiXinID'] = $this->_POST['WeiXinID'];
                $Data['WeiXinNO'] = $this->_POST['WeiXinNO'];
                $FengXinUserNameNum = $CustProModule->GetListsNum("where WeiXinID='$Data[WeiXinID]' and CustomersID!=$CustomersID");
                if ($FengXinUserNameNum ['Num'] > 0) {
                    $LogsFunction->logsinfile('106', 2, $CustomersID);
                    JsMessage('该风信账户已经被使用!');
                }
                if ($CustProModule->InsertArray($Data)) {
                    $CustomersProjectID = mysql_insert_id();
                    $this->ToFengXinEditInfo($CustomersProjectID);
                    $LogsFunction->logsinfile('106', 1, $CustomersID);
                    JsMessage('添加客户为新的风信客户成功!', UrlRewriteSimple($this->MyModule, 'Customer', true) . '&Page=' . $Page, '继续操作');
                } else {
                    $LogsFunction->logsinfile('106', 0, $CustomersID);
                    JsMessage('修改客户失败,请再一次尝试!');
                }
            }
        }
    }

	public function GetCustomerNeed() 
	{
        $Model = new ModelModule();;
		$Customers = $Model->GetListsAll('tb_customers');
		$CusPro = $Model->GetListsAll('tb_customers_project');
		$CusPro_put_p = array();
		$CusPro_put_m = array();
		$CusPro_put_t = array();
		$Cus_pick = array();
		$num_p = array();
		$num_m = array();
		$num_t = array();
		$out = array(385,430,433,463,464,466,445,446,447,448,449);//测试账号ID
		foreach($CusPro as $v){
			$v['Mobile_model']?:$v['Mobile_model']=0;
			$v['PC_model']?:$v['PC_model']=0;
			//删除数据库默认的值
			if($v['PC_model']!='GP0007' && $v['Mobile_model']!='GM0006'){
				if($v['CPhone'] == 3 && $v['isPackage'])
					$CusPro_put_t[$v['CustomersID']] = $v['PK_model'];
				else{
					$CusPro_put_p[$v['CustomersID']] = $v['PC_model'];
					$CusPro_put_m[$v['CustomersID']] = $v['Mobile_model'];
				}
			}
		}
		//排除测试ID，通过检测公司名字是中文来确定客户
		foreach($Customers as $v){
			if(in_array($v['CustomersID'],$out))
				continue;
			if (preg_match("/[\x7f-\xff]/", $v['CompanyName'])) { 
				$Cus_pick[] = $v['CustomersID'];
			}else
				continue;
		}
		//echo count($Cus_pick);//开户总计
		foreach($Cus_pick as $v){
			if(isset($CusPro_put_t[$v])){
				if(isset($num_t[$CusPro_put_t[$v]]))
					$num_t[$CusPro_put_t[$v]] +=1;
				else
					$num_t[$CusPro_put_t[$v]] =1;
			}
			if(isset($CusPro_put_p[$v])){
				if(isset($num_p[$CusPro_put_p[$v]]))
					$num_p[$CusPro_put_p[$v]] +=1;
				else
					$num_p[$CusPro_put_p[$v]] =1;
			}
			if(isset($CusPro_put_m[$v])){
				if(isset($num_m[$CusPro_put_m[$v]]))
					$num_m[$CusPro_put_m[$v]] +=1;
				else
					$num_m[$CusPro_put_m[$v]] =1;
			}
		}
		arsort($num_t);
		arsort($num_p);
		arsort($num_m);
		echo '<br />套餐模板选择统计<br />';
		foreach($num_t as $k=>$v){
			echo '选择    '.$k.'    '.$v.'  个'.'<br />';
		}
		echo '<br />PC模板选择统计<br />';
		foreach($num_p as $k=>$v){
			echo '选择    '.$k.'    '.$v.'  个'.'<br />';
		}
		echo '<br />手机模板选择统计<br />';
		foreach($num_m as $k=>$v){
			echo '选择    '.$k.'    '.$v.'  个'.'<br />';
		}
		exit;
       
    }
    /**
     *获取微传单是否开启情况（通过用户名）
     */
    public function getGshowByname(){
        header('Access-Control-Allow-Origin:*');
        $post=$this->_GET;
        $custpro=new CustProModule();
        $cusprodata=$custpro->GetInfoByWhere(" where G_name = '".$post["name"]."'");    
        if($cusprodata){
            $gshow=new GshowModule();
            $gshowinfo=$gshow->GetOneByWhere(array(), " where CustomersID = '".$cusprodata["CustomersID"]."'");
            $result["data"]=$gshowinfo;
            if($gshowinfo){
                $result=1;
            }else{
                $result=0;
            }
        }else{
            $result=0;    
        }
        echo $result;
        exit();
    }

}
