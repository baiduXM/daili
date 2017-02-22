<?php

/**
 * Created by PhpStorm.
 * User: lc
 * Date: 2016/5/12
 * Function: G宝盆各种客户操作
 * Time: 09:37
 */
class Gbaopen extends InterfaceVIEWS {

    public function __Public() {
        IsLogin(true);
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

    //客户列表页面初始化
    public function CusInit() {
        $result = array('err' => 0, 'data' => '', 'msg' => '');
        $agent_id = $_SESSION ['AgentID'];
        $power = $_SESSION ['Power'];
        $type = trim($this->_GET['type']);
        $DB = new DB;
        $modelclass = new ModelClassModule;
        if ($type == 'li') {
            $Data['overdue'] = $this->GetCusNumByType(3);
        } else {
            //获取所有模板分类样式
            $typeclass = $modelclass->GetListsByWhere(array('ID', 'CName'));
            foreach ($typeclass as $v) {
                $Data['tag'][$v['ID']] = $v['CName'];
            }
        }
        //获取地区列表
        $sql = 'select level,GROUP_CONCAT(ID,\' \',AreaName,\' \',ParentID) as areas from tb_area group by Level';
        $areamsg = $DB->Select($sql);
        foreach ($areamsg as $v) {
            if ($v['level'] == 1) {
                $areas_arr = explode(',', $v['areas']);
                foreach ($areas_arr as $val) {
                    $area_arr = explode(' ', $val);
                    $top[$area_arr[0]] = array('id' => $area_arr[0], 'name' => $area_arr[1]);
                }
            } elseif ($v['level'] == 2) {
                $areas_arr = explode(',', $v['areas']);
                foreach ($areas_arr as $val) {
                    $area_arr = explode(' ', $val);
                    $sec[$area_arr[0]] = array('id' => $area_arr[0], 'name' => $area_arr[1], 'parent' => $area_arr[2]);
                }
            } elseif ($v['level'] == 3) {
                $areas_arr = explode(',', $v['areas']);
                foreach ($areas_arr as $val) {
                    $area_arr = explode(' ', $val);
                    $thr[$area_arr[0]] = array('id' => $area_arr[0], 'name' => $area_arr[1], 'parent' => $area_arr[2]);
                }
            }
        }
        foreach ($thr as $v) {
            $sec[$v['parent']]['child'][] = $v;
        }
        foreach ($sec as $v) {
            $top[$v['parent']]['child'][] = $v;
        }
        $powerList = $this->Assess($power);
        $Data['operat'] = implode(',', $powerList);
        $Data['num'] = $this->GetCusNumByType(0);
        $Data['area'] = $top;
        $result['data'] = $Data;
        return $result;
    }

    //获取客户案例数据
    public function GetCases() {
        $result = array('err' => 0, 'data' => '', 'msg' => '');
        $cuspro = new CustProModule;
        $cus_id = (int) $this->_GET['num'];
        $power = (int) $_SESSION['Power'];
        if ($cus_id && $this->Assess($power, $this->case)) {
            $casedata = $cuspro->GetOneByWhere(array('CaseImagePC', 'CaseImageMobile', 'CPhone'), ' where CustomersID=' . $cus_id);
            $casedataPC = $casedata['CaseImagePC'];
            $casedataMobile = $casedata['CaseImageMobile'];
            $case['type'] = (int) $casedata['CPhone'];
            $case['pc'] = $case['mobile'] = array();
            if ($casedataPC) {
                $casedata = explode(',', $casedataPC);
                for ($i = 0, $count = count($casedata), $type = 1; $i < $count; $i++) {
                    if ($casedata[$i]) {
                        /* type类型：1为颜色，2为行业标签号，3为图片 */
                        switch ($type) {
                            case 1:
                                if ($casedata[$i] != 'tag') {
                                    $case['pc']['color'][] = $casedata[$i];
                                } else {
                                    $type = 2;
                                }
                                break;
                            case 2:
                                if ($casedata[$i] != 'img') {
                                    $case['pc']['tag'][] = $casedata[$i];
                                } else {
                                    $type = 3;
                                }
                                break;
                            case 3:
                                $case['pc']['img'][] = IMG_DOMAIN . $casedata[$i];
                                break;
                        }
                    }
                }
            }
            if ($casedataMobile) {
                $casedata = explode(',', $casedataMobile);
                for ($i = 0, $count = count($casedata), $type = 1; $i < $count; $i++) {
                    if ($casedata[$i]) {
                        /* type类型：1为颜色，2为行业标签号，3为图片 */
                        switch ($type) {
                            case 1:
                                if ($casedata[$i] != 'tag') {
                                    $case['mobile']['color'][] = $casedata[$i];
                                } else {
                                    $type = 2;
                                }
                                break;
                            case 2:
                                if ($casedata[$i] != 'img') {
                                    $case['mobile']['tag'][] = $casedata[$i];
                                } else {
                                    $type = 3;
                                }
                                break;
                            case 3:
                                $case['mobile']['img'][] = IMG_DOMAIN . $casedata[$i];
                                break;
                        }
                    }
                }
            }
        } else {
            $result["err"] = 1003;
            $result["msg"] = '非法操作';
        }
        $case['pc']['color'] = $case['pc']['color'] ? $case['pc']['color'] : false;
        $case['pc']['tag'] = $case['pc']['tag'] ? $case['pc']['tag'] : false;
        $case['pc']['img'] = $case['pc']['img'] ? $case['pc']['img'] : false;
        $case['mobile']['color'] = $case['mobile']['color'] ? $case['mobile']['color'] : false;
        $case['mobile']['tag'] = $case['mobile']['tag'] ? $case['mobile']['tag'] : false;
        $case['mobile']['img'] = $case['mobile']['img'] ? $case['mobile']['img'] : false;
        $result['data'] = $case;
        return $result;
    }

    //推荐案例
    public function ComExc() {
        $result = array('err' => 0, 'data' => '', 'msg' => '');
        $power = (int) $_SESSION['Power'];
        if ($this->Assess($power, $this->case)) {
            $file1 = 'simgfile';
            $file2 = 'imgfile';
            $area = new AreaModule;
            $cuspro = new CustProModule;
            $cus_id = (int) $this->_POST['num'];
            $area_id = $this->_POST['areaID'];
            $time = time() . getstr();
            /* 搜集需要删除的图片地址 */
            $del = array();
            $caseimg = $cuspro->GetOneByWhere(array('CaseImagePC', 'CaseImageMobile', 'CustomersID', 'CPhone'), ' where CustomersID=' . $cus_id);
            if ($area_id != 0) {
                if ($this->_POST['type']) {
                    $caseType = $this->_POST['type'] == 1 ? 'PC' : 'Mobile';
                } else
                    $caseType = $caseimg['CPhone'] == 1 ? 'PC' : 'Mobile';
                $caseType = 'CaseImage' . $caseType;
                $caseimg[$caseType] = explode(',', $caseimg[$caseType]);
                $count = count($caseimg[$caseType]);
                $color = $this->_POST['color'];
                $tag = $this->_POST['tag'];
                $casedata = $color . 'tag,' . $tag . 'img,';
                $areaName = $area->GetOneByWhere(array('AreaName'), ' where ID=' . $area_id);
                if ($areaName['AreaName'] && $caseimg['CustomersID']) {
                    $needfile = $caseimg[$caseType][$count - 3] == 'img' ? false : true;
                    /* 网站缩略截图 */
                    if (empty($this->_FILES[$file1]['tmp_name']) || $this->_FILES[$file1]['tmp_name'] == 'none') {
                        if (!$needfile) {
                            $simg = $caseimg[$caseType][$count - 2];
                        } else {
                            $result["err"] = 1001;
                            $result["msg"] = '请上传缩略截图';
                            return $result;
                        }
                    } else {
                        if ($this->_FILES["file"]["error"][0] > 0) {
                            $result["err"] = 1000;
                            $result["msg"] = '缩略截图上传失败,请再一次尝试!，(~>__<~)';
                            return $result;
                        } else {
                            $filename = $this->_FILES[$file1]["name"];
                            $filetype = pathinfo($filename, PATHINFO_EXTENSION);
                            if (in_array($filetype, array('jpg', 'png', 'gif', 'jpeg', 'bmp'))) {
                                $newname = $time . '_s.' . $filetype;
                                $cuspro->UpdateArray(array('Cases' => $area_id . '-' . $areaName['AreaName'], $caseType => $newname), $cus_id);
                                $result['data']['place'] = $areaName['AreaName'];
                                $simg = 'cus_cases/' . $newname;
                                $del['now'] = IMG_PICPUT . $simg;
                                $del['before'] = $needfile ? '' : $caseimg[$caseType][$count - 2];
                                move_uploaded_file($_FILES[$file1]['tmp_name'], $del['now']);
                            } else {
                                $result["err"] = 1002;
                                $result["msg"] = '请上传后缀为jpg,png,gif,jpeg或bmp的图片';
                                return $result;
                            }
                        }
                    }
                    /* 网站截图 */
                    if (empty($this->_FILES[$file2]['tmp_name']) || $this->_FILES[$file2]['tmp_name'] == 'none') {
                        if (!$needfile) {
                            $img = $caseimg[$caseType][$count - 1];
                        } else {
                            $del['now'] ? @unlink($del['now']) : '';
                            $result["err"] = 1001;
                            $result["msg"] = '请上传网站截图';
                            return $result;
                        }
                    } else {
                        if ($this->_FILES["file2"]["error"][0] > 0) {
                            $del['now'] ? @unlink($del['now']) : '';
                            $result["err"] = 1000;
                            $result["msg"] = '网站截图上传失败,请再一次尝试!，(~>__<~)';
                            return $result;
                        } else {
                            $filename = $this->_FILES[$file2]["name"];
                            $filetype = pathinfo($filename, PATHINFO_EXTENSION);
                            if (in_array($filetype, array('jpg', 'png', 'gif', 'jpeg', 'bmp'))) {
                                $newname = 'cus_cases/' . $time . '.' . $filetype;
                                $cuspro->UpdateArray(array('Cases' => $area_id . '-' . $areaName['AreaName'], $caseType => $newname), $cus_id);
                                $result['data']['place'] = $areaName['AreaName'];
                                $img = IMG_PICPUT . $newname;
                                $needfile ? '' : @unlink($caseimg[$caseType][$count - 1]);
                                $del['before'] ? @unlink($del['before']) : '';
                                move_uploaded_file($_FILES[$file2]['tmp_name'], $img);
                                $img = $newname;
                            } else {
                                $del['now'] ? @unlink($del['now']) : '';
                                $result["err"] = 1002;
                                $result["msg"] = '请上传后缀为jpg,png,gif,jpeg或bmp的图片';
                                return $result;
                            }
                        }
                    }
                    $cuspro->UpdateArray(array('Cases' => $area_id . '-' . $areaName['AreaName'], $caseType => $casedata . $simg . ',' . $img), $cus_id);
                    $result['data']['place'] = $areaName['AreaName'];
                    $result["msg"] = "文件上传成功";
                } else {
                    $result["err"] = 1003;
                    $result["msg"] = '非法操作';
                }
            } else {
                $caseType = $this->_POST['type'] != 0 ? $this->_POST['type'] == 1 ? 1 : 2 : 3;
                $state = $this->_POST['type'] == 0 ? true : false;
                $result['data']['state'] = $state;
                if ($caseType & 1) {
                    $caseimg['CaseImagePC'] = explode(',', $caseimg['CaseImagePC']);
                    $count = count($caseimg['CaseImagePC']);
                    if ($caseimg['CaseImagePC']) {
                        if ($caseimg['CaseImagePC'][$count - 3] == 'img') {
                            @unlink($caseimg['CaseImagePC'][$count - 2]);
                            @unlink($caseimg['CaseImagePC'][$count - 1]);
                        }
                    }
                }
                if ($caseType & 2) {
                    $caseimg['CaseImageMobile'] = explode(',', $caseimg['CaseImageMobile']);
                    $count = count($caseimg['CaseImageMobile']);
                    if ($caseimg['CaseImageMobile']) {
                        if ($caseimg['CaseImageMobile'][$count - 3] == 'img') {
                            @unlink($caseimg['CaseImageMobile'][$count - 2]);
                            @unlink($caseimg['CaseImageMobile'][$count - 1]);
                        }
                    }
                }
                if ($caseType & 1 && $caseType & 2) {
                    $cuspro->UpdateArray(array('Cases' => 0, 'CaseImagePC' => 0, 'CaseImageMobile' => 0), $cus_id);
                } elseif ($caseType & 1)
                    $cuspro->UpdateArray(array('CaseImagePC' => 0), $cus_id);
                else
                    $cuspro->UpdateArray(array('CaseImageMobile' => 0), $cus_id);
            }
        }else {
            $result["err"] = 1003;
            $result["msg"] = '非法操作';
        }
        return $result;
    }

    //G宝盆修改续费转移操作数据生成
    public function Operation() {
        $result = array('err' => 1000, 'data' => '', 'msg' => '错误的指令--数据获取');
        $cus_id = (int) $this->_GET['cus'];
        if ($this->_GET['type'] && $cus_id) {
            $agent_id = $_SESSION ['AgentID'];
            $level = (int) $_SESSION ['Level'];
            $power = $_SESSION ['Power'];
            $cusmodel = new CustomersModule;
            $cus = $cusmodel->GetOneByWhere('where CustomersID=' . $cus_id);
            if ($level == 3) {
                if ($cus['AgentID'] != $agent_id) {
                    $result['err'] = 1003;
                    $result['msg'] = '您没有此用户资料';
                    $this->LogsFunction->LogsCusRecord(115, 2, $cus_id, $result['msg']);
                    return $result;
                }
            } elseif ($level == 2) {
                if ($cus['AgentID'] != $agent_id) {
                    $agent = new AccountModule;
                    $agentinfo = $agent->GetOneInfoByKeyID($cus['AgentID']);
                    if ($agentinfo['BossAgentID'] != $agent_id) {
                        $result['err'] = 1003;
                        $result['msg'] = '您没有此用户资料';
                        $this->LogsFunction->LogsCusRecord(115, 2, $cus_id, $result['msg']);
                        return $result;
                    }
                }
            } elseif ($level == 1) {
                if (!$cus) {
                    $result['err'] = 1003;
                    $result['msg'] = '此用户资料不存在';
                    $this->LogsFunction->LogsCusRecord(115, 2, $cus_id, $result['msg']);
                    return $result;
                }
            } else {
                $result['err'] = 1001;
                $result['msg'] = '此用户资料不存在';
                $this->LogsFunction->LogsCusRecord(115, 2, $cus_id, $result['msg']);
                return $result;
            }
            $result = array('err' => 0, 'data' => '', 'msg' => '');
            $type = $this->_GET['type'];
            switch ($type) {
                case 'renew':
                    if ($this->Assess($power, $this->renew)) {
                        $cuspromodel = new CustProModule;
                        $lists = array('CPhone', 'PK_model', 'PC_model', 'Mobile_model', 'PC_EndTime', 'Mobile_EndTime','Capacity');
                        $cuspro = $cuspromodel->GetOneByWhere($lists, 'where CustomersID=' . $cus_id);
                        if ($cuspro) {
                            $model = new ModelModule;
                            $package = new ModelPackageModule;
                            $data['state'] = 0;
                            $data['type'] = $cuspro['CPhone'];
                            $data['name'] = $cus['CompanyName'];
                            $data['capacity'] = (int)$cuspro['Capacity'];
                            switch ($cuspro['CPhone']) {
                                case 4:
                                    $pc_price = $mobile_price = array();
                                    $price = $package->GetOneByWhere(array('Price', 'Youhui', 'PCNum', 'PhoneNum'), 'where PackagesNum=\'' . $cuspro['PK_model'] . '\'');
                                    if ($price) {
                                        $data['state'] = 1;
                                        $exist = true;
                                        if (($cuspro['PC_model'] == $price['PCNum']) && ($cuspro['Mobile_model'] == $price['PhoneNum']))
                                            $data['state'] = 2;
                                    }else {
                                        $exist = FALSE;
                                    }
                                    $pc_price = $model->GetOneByWhere(array('Price', 'Youhui'), 'where NO=\'' . $cuspro['PC_model'] . '\'');
                                    $mobile_price = $model->GetOneByWhere(array('Price', 'Youhui'), 'where NO=\'' . $cuspro['Mobile_model'] . '\'');
                                    $data['package'] = array('exist' => $exist, 'name' => $cuspro['PK_model'], 'pc' => $price['PCNum'], 'mobile' => $price['PhoneNum'], 'price' => $price['Price'], 'youhui' => $price['Youhui']);
                                    $exist = $pc_price ? true : false;
                                    $data['pc'] = array('exist' => $exist, 'name' => $cuspro['PC_model'], 'price' => $pc_price['Price'], 'youhui' => $pc_price['Youhui'], 'time' => $cuspro['PC_EndTime']);
                                    $exist = $mobile_price ? true : false;
                                    $data['mobile'] = array('exist' => $exist, 'name' => $cuspro['Mobile_model'], 'price' => $mobile_price['Price'], 'youhui' => $mobile_price['Youhui'], 'time' => $cuspro['Mobile_EndTime']);
                                    break;
                                case 3:
                                    $pc_price = $model->GetOneByWhere(array('Price', 'Youhui'), 'where NO=\'' . $cuspro['PC_model'] . '\'');
                                    $mobile_price = $model->GetOneByWhere(array('Price', 'Youhui'), 'where NO=\'' . $cuspro['Mobile_model'] . '\'');
                                    $exist = $pc_price ? true : false;
                                    $data['pc'] = array('exist' => $exist, 'name' => $cuspro['PC_model'], 'price' => $pc_price['Price'], 'youhui' => $pc_price['Youhui'], 'time' => $cuspro['PC_EndTime']);
                                    $exist = $mobile_price ? true : false;
                                    $data['mobile'] = array('exist' => $exist, 'name' => $cuspro['Mobile_model'], 'price' => $mobile_price['Price'], 'youhui' => $mobile_price['Youhui'], 'time' => $cuspro['Mobile_EndTime']);
                                    $data['package'] = array('exist' => false);
                                    break;
                                case 2:
                                    $mobile_price = $model->GetOneByWhere(array('Price', 'Youhui'), 'where NO=\'' . $cuspro['Mobile_model'] . '\'');
                                    $data['pc'] = array('exist' => false);
                                    $exist = $mobile_price ? true : false;
                                    $data['mobile'] = array('exist' => $exist, 'name' => $cuspro['Mobile_model'], 'price' => $mobile_price['Price'], 'youhui' => $mobile_price['Youhui'], 'time' => $cuspro['Mobile_EndTime']);
                                    $data['package'] = array('exist' => false);
                                    break;
                                case 1:
                                    $pc_price = $model->GetOneByWhere(array('Price', 'Youhui'), 'where NO=\'' . $cuspro['PC_model'] . '\'');
                                    $exist = $pc_price ? true : false;
                                    $data['pc'] = array('exist' => $exist, 'name' => $cuspro['PC_model'], 'price' => $pc_price['Price'], 'youhui' => $pc_price['Youhui'], 'time' => $cuspro['PC_EndTime']);
                                    $data['mobile'] = array('exist' => false);
                                    $data['package'] = array('exist' => false);
                                    break;
                                default:
                                    $result['err'] = 1002;
                                    $result['msg'] = '请联系程序猿协助';
                                    $this->LogsFunction->LogsCusRecord(115, 3, $cus_id, $result['msg']);
                                    break;
                            }
                            $result['data'] = $data;
                        } else {
                            $result['err'] = 1003;
                            $result['msg'] = '您没有此用户资料--续费处理';
                            $this->LogsFunction->LogsCusRecord(115, 2, $cus_id, $result['msg']);
                        }
                    } else {
                        $result['err'] = 1002;
                        $result['msg'] = '非法请求--续费';
                        $this->LogsFunction->LogsCusRecord(115, 3, $cus_id, $result['msg']);
                    }
                    break;
                case 'modify':
                    if ($this->Assess($power, $this->modify)) {
                        $data = array('companyname' => array('公司', $cus['CompanyName']), 'name' => array('联系人姓名', $cus['CustomersName']), 'tel' => array('联系人电话', $cus['Tel']), 'fax' => array('传真', $cus['Fax']), 'email' => array('Email', $cus['Email']), 'address' => array('地址', $cus['Address']), 'remark' => array('备注', $cus['Remark']), 'experience' => array('体验用户', $cus['Experience']));
                        $result['data'] = $data;
                    } else {
                        $result['err'] = 1002;
                        $result['msg'] = '非法请求--客户信息修改';
                        $this->LogsFunction->LogsCusRecord(115, 3, $cus_id, $result['msg']);
                    }
                    break;
                case 'sitemove':
                    if ($this->Assess($power, $this->process)) {
                        $custpromodel = new CustProModule();
                        $custpro = $custpromodel->GetOneByWhere('where CustomersID=' . $cus_id);
                        $data = array("FuwuqiID"=>$custpro["FuwuqiID"]);
                        $result['data'] = $data;
                    } else {
                        $result['err'] = 1002;
                        $result['msg'] = '非法请求--客户信息修改';
                        $this->LogsFunction->LogsCusRecord(115, 3, $cus_id, $result['msg']);
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
                            $agent = $accountModel->GetListByBossAgentID($agentinfo['BossAgentID'], array('ContactName', 'AgentID'));
                            if ($agent_id != $cus['AgentID']) {
                                $self = $accountModel->GetOneInfoByKeyID($agent_id);
                                $data['obj'][$agent_id] = $self['ContactName'];
                            }
                        } else {
                            $where = ' where Level > 1';
                            $agent = $accountModel->GetListsByWhere(array('ContactName', 'AgentID'), $where);
                        }
                        $data['name'] = $cus['CompanyName'];
                        if ($agent) {
                            foreach ($agent as $v) {
                                if ($v['AgentID'] == $cus['AgentID'])
                                    continue;
                                else
                                    $data['obj'][$v['AgentID']] = $v['ContactName'];
                            }
                        }
                        $result['data'] = $data;
                    }else {
                        $result['err'] = 1002;
                        $result['msg'] = '非法请求--转移';
                        $this->LogsFunction->LogsCusRecord(115, 3, $cus_id, $result['msg']);
                    }
                    break;
                case 'process':
                    if ($this->Assess($power, $this->process)) {
                        $cuspromodel = new CustProModule;
                        $fuwuqi = new FuwuqiModule();
                        $lists = array('G_name', 'CPhone', 'PK_model', 'PC_model', 'Mobile_model', 'Link_Cus', 'PC_AddTime', 'Mobile_AddTime', 'PC_StartTime', 'Mobile_StartTime', 'PC_domain', 'Mobile_domain', 'Customization', 'FuwuqiID');
                        $cuspro = $cuspromodel->GetOneByWhere($lists, 'where CustomersID=' . $cus_id);
                        if ($cuspro) {
                            if ($cuspro['FuwuqiID']) {
                                $def_domain = $fuwuqi->GetOneByIDorWhere($cuspro['FuwuqiID']);
                                $def_domain = $def_domain['CName'];
                                $def_domain[0] = '';
                            } else {
                                $def_domain = false;
                            }
                            /* 开户已经送了一个月，所以关闭起始时间修改
                              if(in_array($cuspro['CPhone'], array(1,3,4))){
                              if(strtotime("now") > strtotime("+1 months", strtotime($cuspro['PC_AddTime'])))
                              $cuspro['PC_StartTime'] = false;
                              }else{
                              $cuspro['PC_StartTime'] = false;
                              }
                              if(in_array($cuspro['CPhone'], array(2,3,4))){
                              if(strtotime("now") > strtotime("+1 months", strtotime($cuspro['Mobile_AddTime'])))
                              $cuspro['Mobile_StartTime'] = false;
                              }else{
                              $cuspro['Mobile_StartTime'] = false;
                              }
                             * 
                             */
                            $cuspro['PC_StartTime'] = false;
                            $cuspro['Mobile_StartTime'] = false;
                            $cuspro['Link_Cus'] = $cuspro['Link_Cus'] ? $cuspro['Link_Cus'] : '';
                            $data = array('cusname' => $cuspro['G_name'],
                                'domain_def' => $def_domain,
                                'name' => $cus['CompanyName'],
                                'pc_mobile' => $cuspro['CPhone'],
                                'pkmodel' => $cuspro['PK_model'],
                                'pcmodel' => $cuspro['PC_model'],
                                'mobilemodel' => $cuspro['Mobile_model'],
                                'pc_starttime' => $cuspro['PC_StartTime'],
                                'mobile_starttime' => $cuspro['Mobile_StartTime'],
                                'pcdomain' => $cuspro['PC_domain'] ? $cuspro['PC_domain'] : '',
                                'mobiledomain' => $cuspro['Mobile_domain'] ? $cuspro['Mobile_domain'] : '',
                                'senior' => $cuspro['Customization'],
                                'othercus' => $cuspro['Link_Cus']);
                            $result['data'] = $data;
                        } else {
                            $result['err'] = 1003;
                            $result['msg'] = '您没有此用户资料--网站处理';
                            $this->LogsFunction->LogsCusRecord(115, 2, $cus_id, $result['msg']);
                        }
                    } else {
                        $result['err'] = 1002;
                        $result['msg'] = '非法请求--网站处理';
                        $this->LogsFunction->LogsCusRecord(115, 3, $cus_id, $result['msg']);
                    }
                    break;
                default:
                    $result['err'] = 1002;
                    $result['msg'] = '非法请求--非法字符';
                    $this->LogsFunction->LogsCusRecord(115, 3, $cus_id, $result['msg']);
                    break;
            }
        } else {
            $this->LogsFunction->LogsCusRecord(115, 3, $cus_id, $result['msg']);
        }
        return $result;
    }

    //G宝盆续费操作
    public function Renew() {
        $result = array('err' => 0, 'data' => '', 'msg' => '');
        $agent_id = (int) $_SESSION ['AgentID'];
        $level = (int) $_SESSION ['Level'];
        $power = (int) $_SESSION ['Power'];
        $cus_id = (int) $this->_POST['num'];
        $addyear = intval($this->_POST['yearnum']);
        $capacity = intval($this->_POST['capacity']);
        if ($cus_id && $this->Assess($power, $this->renew) && $addyear > 0) {
            $agent = new AccountModule;
            $cusmodel = new CustomersModule;
            $cuspromodel = new CustProModule;
            $model = new ModelModule;
            $package = new ModelPackageModule;
            $balance = new BalanceModule;
            $cuspro = $cuspromodel->GetOneByWhere('where CustomersID=' . $cus_id);
            $type = $cuspro['CPhone'];
            $agentinfo = $agent->GetOneInfoByKeyID($cuspro["AgentID"]);
            if ($agentinfo["Level"] == 3) {
//                $agentinfo = $agent->GetOneInfoByKeyID($agent_id);
                $costID = $agentinfo['BossAgentID'];
                $agent_bal = $balance->GetOneInfoByAgentID($agent_id);
                $boss_agent_bal = $balance->GetOneInfoByAgentID($costID);
                unset($agent_bal['ID']);
                unset($boss_agent_bal['ID']);
//                $cuspro = $cuspromodel->GetOneByWhere('where AgentID=' . $agent_id . ' and CustomersID=' . $cus_id);
            } elseif ($agentinfo["Level"] == 2 or $agentinfo["Level"] == 1) {
//                $cuspro = $cuspromodel->GetOneByWhere('where CustomersID=' . $cus_id);
//                if ($level == 2) {
//                    if ($cuspro['AgentID'] != $agent_id) {
//                        $agentinfo = $agent->GetOneInfoByKeyID($cuspro['AgentID']);
//                        if ($agentinfo['BossAgentID'] != $agent_id) {
//                            $result['err'] = 1001;
//                            $result['msg'] = '此用户资料不存在';
//                            $this->LogsFunction->LogsCusRecord(115, 2, $cus_id, $result['msg']);
//                            return $result;
//                        }
//                    }
//                }
                $costID = $agentinfo["AgentID"];
                $boss_agent_bal = $balance->GetOneInfoByAgentID($agentinfo["AgentID"]);
                unset($boss_agent_bal['ID']);
            } else {
                $result['err'] = 1001;
                $result['msg'] = '此用户资料不存在';
                $this->LogsFunction->LogsCusRecord(115, 2, $cus_id, $result['msg']);
                return $result;
            }
            if ($cuspro && $type >= $cuspro['CPhone']) {
//                switch ($cuspro['CPhone']) {
//                    case 4:
//                        $price = $package->GetOneByWhere(array('Youhui', 'PCNum', 'PhoneNum'), 'where PackagesNum=\'' . $cuspro['PK_model'] . '\'');
//                        if ($price) {
//                            if (($cuspro['PC_model'] == $price['PCNum']) && ($cuspro['Mobile_model'] == $price['PhoneNum'])) {
//                                $pk_exist = true;
//                            } else {
//                                $pk_exist = false;
//                            }
//                        } else {
//                            $pk_exist = false;
//                        }
//                        $pc_price = $model->GetOneByWhere(array('Youhui'), 'where NO=\'' . $cuspro['PC_model'] . '\'');
//                        $mobile_price = $model->GetOneByWhere(array('Youhui'), 'where NO=\'' . $cuspro['Mobile_model'] . '\'');
//                        break;
//                    case 3:
//                        $pc_price = $model->GetOneByWhere(array('Youhui'), 'where NO=\'' . $cuspro['PC_model'] . '\'');
//                        $mobile_price = $model->GetOneByWhere(array('Youhui'), 'where NO=\'' . $cuspro['Mobile_model'] . '\'');
//                        break;
//                    case 2:
//                        $mobile_price = $model->GetOneByWhere(array('Youhui'), 'where NO=\'' . $cuspro['Mobile_model'] . '\'');
//                        break;
//                    case 1:
//                        $pc_price = $model->GetOneByWhere(array('Youhui'), 'where NO=\'' . $cuspro['PC_model'] . '\'');
//                        break;
//                    default:
//                        $result['err'] = 1002;
//                        $result['msg'] = '请联系程序猿协助';
//                        $this->LogsFunction->LogsCusRecord(115, 3, $cus_id, $result['msg']);
//                        return $result;
//                        break;
//                }
//                switch ($type) {
//                    case 4:
//                        if ($pk_exist) {
//                            $price = $price['Youhui'];
//                        } else {
//                            $result['err'] = 1003;
//                            $result['msg'] = '套餐--非法请求，不存在的续费请求';
//                            $this->LogsFunction->LogsCusRecord(115, 3, $cus_id, $result['msg']);
//                            return $result;
//                        }
//                        break;
//                    case 3:
//                        if ($pc_price && $mobile_price) {
//                            $price = $pc_price['Youhui'] + $mobile_price['Youhui'];
//                        } else {
//                            $result['err'] = 1003;
//                            $result['msg'] = '双站--非法请求，不存在的续费请求';
//                            $this->LogsFunction->LogsCusRecord(115, 3, $cus_id, $result['msg']);
//                            return $result;
//                        }
//                        break;
//                    case 2:
//                        if ($mobile_price) {
//                            $price = $mobile_price['Youhui'];
//                        } else {
//                            $result['err'] = 1003;
//                            $result['msg'] = '手机--非法请求，不存在的续费请求';
//                            $this->LogsFunction->LogsCusRecord(115, 3, $cus_id, $result['msg']);
//                            return $result;
//                        }
//                        break;
//                    case 1:
//                        if ($pc_price) {
//                            $price = $pc_price['Youhui'];
//                        } else {
//                            $result['err'] = 1003;
//                            $result['msg'] = 'PC--非法请求，不存在的续费请求';
//                            $this->LogsFunction->LogsCusRecord(115, 3, $cus_id, $result['msg']);
//                            return $result;
//                        }
//                        break;
//                    default :
//                        $result['err'] = 1003;
//                        $result['msg'] = '非法请求，不存在的续费请求';
//                        $this->LogsFunction->LogsCusRecord(115, 3, $cus_id, $result['msg']);
//                        return $result;
//                        break;
//                }
                $price=0;
                if ($capacity == 300) {
                    $price+=500;
                } elseif($capacity == 500){
                    $price+=800;
                }elseif($capacity == 1000){
                    $price+=1500;
                }elseif($capacity == 100){
                    $price+=300;
                }else{
                    $result['err'] = 1003;
                    $result['msg'] = '容量空间选择错误';
                    return $result;
                }
                
                if ($agentinfo['Level'] == 3) {
                    if ($boss_agent_bal['Balance'] < $price) {
                        $result['err'] = 1003;
                        $result['msg'] = '您的余额不足，请及时充值';
                        $this->LogsFunction->LogsCusRecord(115, 4, $cus_id, $result['msg']);
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
                    $update_boss['CostAll'] = $update_boss['CostAll'] + $price;
                    //客服消费计算
                    $updatetime = explode('-', $agent_bal['UpdateTime']);
                    $update_self['CostMon'] = $agent_bal['CostMon'];
                    if (date('m', time()) != $updatetime[1]) {
                        $update_self['UpdateTime'] = date('Y-m-d', time());
                        $update_self['CostMon'] = 0;
                    }
                    $update_self['CostMon'] = $update_self['CostMon'] + $price;
                    $update_self['CostAll'] = $update_self['CostAll'] + $price;
                    $balance_money=$update_boss['Balance'];
                } else {
                    if ($boss_agent_bal['Balance'] < $price) {
                        $result['err'] = 1003;
                        $result['msg'] = '您的余额不足，请及时充值';
                        $this->LogsFunction->LogsCusRecord(115, 4, $cus_id, $result['msg']);
                        return $result;
                    }
                    $updatetime = explode('-', $boss_agent_bal['UpdateTime']);
                    $update_self['CostMon'] = $boss_agent_bal['CostMon'];
                    if (date('m', time()) != $updatetime[1]) {
                        $update_self['UpdateTime'] = date('Y-m-d', time());
                        $update_self['CostMon'] = 0;
                    }
                    $update_self['Balance'] = $boss_agent_bal['Balance'] - $price;
                    $update_self['CostMon'] = $update_self['CostMon'] + $price;
                    $update_self['CostAll'] = $update_self['CostAll'] + $price;
                    $balance_money=$update_self['Balance'];
                }
                //PC续费处理
                $cuspro_time = array('UpdateTime' => date('Y-m-d H:i:s', time()));
                if ($type == 1 or $type == 3 or $type == 4) {
                    $nowyear = (strtotime($cuspro['PC_EndTime'])>time())?strtotime($cuspro['PC_EndTime']):time();
                    $newyear = (date('Y', $nowyear) + $addyear) . '-' . date('m-d H:i:s', $nowyear);
                    $cuspro_time['PC_EndTime'] = $newyear;
                }
                if ($type == 2 or $type == 3 or $type == 4) {
                    $nowyear =  (strtotime($cuspro['Mobile_EndTime'])>time())?strtotime($cuspro['Mobile_EndTime']):time();
                    $newyear = (date('Y', $nowyear) + $addyear) . '-' . date('m-d H:i:s', $nowyear);
                    $cuspro_time['Mobile_EndTime'] = $newyear;
                }
                $modify_cuspro_info=$cuspro_time;
                $modify_cuspro_info["Capacity"]=$capacity*1024*1024;
                $IsOk = $this->ToGbaoPenEditInfo(array_replace($cuspro, $modify_cuspro_info));
                if ($IsOk['err'] != 1000) {
                    $result['err'] = 1002;
                    $result['msg'] = '数据同步失败，请重试';
                    $this->LogsFunction->LogsCusRecord(115, 6, $cus_id, $result['msg']);
                    $result['data'] = $IsOk;
                    return $result;
                }
                if (!$balance->UpdateArrayByAgentID($update_self, $costID)) {
                    $this->ToGbaoPenEditInfo($cuspro);
                    $result['err'] = 1004;
                    $result['msg'] = '续费失败，请重试，若依然无效，酌情联系管理员1';
                    $this->LogsFunction->LogsCusRecord(115, 0, $cus_id, $result['msg']);
                    return $result;
                }
                if ($agentinfo['Level'] == 3) {
                    if (!$balance->UpdateArrayByAgentID($update_boss, $agentinfo['BossAgentID'])) {
                        $this->ToGbaoPenEditInfo($cuspro);
                        $balance->UpdateArrayByAgentID($agent_bal, $costID);
                        $result['err'] = 1004;
                        $result['msg'] = '续费失败，请重试，若依然无效，酌情联系管理员2';
                        $this->LogsFunction->LogsCusRecord(115, 0, $cus_id, $result['msg']);
                        return $result;
                    }
                }
                if (!$cuspromodel->UpdateArray($modify_cuspro_info, $cus_id)) {
                    $this->ToGbaoPenEditInfo($cuspro);
                    $balance->UpdateArrayByAgentID($agent_bal, $costID);
                    $agentinfo['Level'] == 3 ? $balance->UpdateArrayByAgentID($boss_agent_bal, $costID) : '';
                    $result['err'] = 1004;
                    $result['msg'] = '续费失败，请重试，若依然无效，酌情联系管理员3';
                    $this->LogsFunction->LogsCusRecord(115, 0, $cus_id, $result['msg']);
                    return $result;
                }
                $CustProModule=new CustProModule();
                $orderID= time().rand(1000,9999);
                $order_data = array("OrderID"=>$orderID,"OrderAmount" => $price, "CustomersID" => $cus_id, "CreateTime" => date('Y-m-d H:i:s', time()), "StillTime" =>1, "CPhone" => $cuspro["CPhone"], "PK_model" => $cuspro["PK_model"], "PC_model" => $cuspro["PC_model"], "Mobile_model" => $cuspro["Mobile_model"],"Capacity"=>$cuspro["Capacity"]);
                $ordermodule = new OrderModule();
                $ordermodule->InsertArray($order_data);
                $logcost_data = array("ip" => $_SERVER["REMOTE_ADDR"], "cost" => (0-$price), "type" => 2, "description" => "网站续费", "adddate" => date('Y-m-d H:i:s', time()), "CustomersID" => $cus_id,"AgentID"=>$agent_id,"CostID"=>$costID,"Balance"=>$balance_money,"OrderID"=>$orderID);
                $logcost = new LogcostModule();
                $logcost->InsertArray($logcost_data);
                $this->LogsFunction->LogsCusRecord(115, 5, $cus_id, '续费同步成功');
                $cus = $cusmodel->GetOneByWhere(array('CompanyName'), 'where CustomersID=' . $cus_id);
                $result['data']['name'] = $cus['CompanyName'];
            } else {
                if (!$cuspro) {
                    $result['err'] = 1003;
                    $result['msg'] = '您没有此用户资料,或者此用户还未开通';
                    $this->LogsFunction->LogsCusRecord(115, 2, $cus_id, $result['msg']);
                } else {
                    $result['err'] = 1003;
                    $result['msg'] = '非法操作，不支持此续费类型选择';
                    $this->LogsFunction->LogsCusRecord(115, 3, $cus_id, $result['msg']);
                }
            }
        } else {
            if ($this->Assess($power, $this->renew)) {
                $result['err'] = 1003;
                $result['msg'] = '非法操作,用户ID不存在';
                $this->LogsFunction->LogsCusRecord(115, 2, $cus_id, $result['msg']);
            } elseif ($addyear < 1) {
                $result['err'] = 1003;
                $result['msg'] = '非法操作，年份不得小于1年';
                $this->LogsFunction->LogsCusRecord(115, 3, $cus_id, $result['msg']);
            } else {
                $result['err'] = 1001;
                $result['msg'] = '非法请求';
                $this->LogsFunction->LogsCusRecord(115, 3, $cus_id, $result['msg']);
            }
        }
        return $result;
    }

    //客户信息修改
    public function Modify() {
        $result = array('err' => 0, 'data' => '', 'msg' => '');
        $agent_id = (int) $_SESSION ['AgentID'];
        $power = (int) $_SESSION ['Power'];
        $level = (int) $_SESSION ['Level'];
        $cus_id = (int) $this->_POST['num'];
        if ($cus_id && $this->Assess($power, $this->modify)) {
            $data['CompanyName'] = $this->_POST['companyname'];
            $data['CustomersName'] = $this->_POST['name'];
            $data['Tel'] = $this->_POST['tel'];
            $data['Fax'] = $this->_POST['fax'];
            $data['Address'] = $this->_POST['address'];
            $cusmodel = new CustomersModule;
            $cus = $cusmodel->GetOneByWhere(array('CompanyName', 'AgentID'), 'where CustomersID=' . $cus_id);
            if ($cus) {
                if ($level == 3) {
                    if ($cus['AgentID'] != $agent_id) {
                        $result['err'] = 1003;
                        $result['msg'] = '您没有此用户资料';
                        $this->LogsFunction->LogsCusRecord(112, 2, $cus_id, $result['msg']);
                    }
                } elseif ($level == 2) {
                    if ($cus['AgentID'] != $agent_id) {
                        $agent = new AccountModule;
                        $agentinfo = $agent->GetOneInfoByKeyID($cus['AgentID']);
                        if ($agentinfo['BossAgentID'] != $agent_id) {
                            $result['err'] = 1003;
                            $result['msg'] = '您没有此用户资料';
                            $this->LogsFunction->LogsCusRecord(112, 2, $cus_id, $result['msg']);
                        }
                    }
                } elseif ($level == 1) {
                    
                } else {
                    $result['err'] = 1001;
                    $result['msg'] = '此用户资料不存在';
                    $this->LogsFunction->LogsCusRecord(115, 2, $cus_id, $result['msg']);
                    return $result;
                }
                if ($cusmodel->UpdateArray($data, $cus_id)) {
                    $this->LogsFunction->LogsCusRecord(112, 1, $cus_id);
                    $result['data']['name'] = $data['CompanyName'];
                } else {
                    $result['err'] = 1004;
                    $result['msg'] = '信息处理失败，请重试';
                    $this->LogsFunction->LogsCusRecord(112, 0, $cus_id, $result['msg']);
                }
            } else {
                $result['err'] = 1003;
                $result['msg'] = '您没有此用户资料';
                $this->LogsFunction->LogsCusRecord(112, 2, $cus_id, $result['msg']);
            }
        } else {
            $result['err'] = 1001;
            $result['msg'] = '非法请求';
            $this->LogsFunction->LogsCusRecord(112, 3, $cus_id, $result['msg']);
        }
        return $result;
    }

    //客户转移
    public function Custransfer() {
        $result = array('err' => 0, 'data' => '', 'msg' => '');
        $agent_id = (int) $_SESSION ['AgentID'];
        $power = (int) $_SESSION ['Power'];
        $level = (int) $_SESSION ['Level'];
        $cus_id = (int) $this->_POST['num'];
        $exc = (int) $this->_POST['id'];
        if ($cus_id && $exc && $this->Assess($power, $this->transfer)) {
            $accountModel = new AccountModule;
            $exc_msg = $accountModel->GetOneInfoByKeyID($exc);
            if ($level == 3) {
                $agent_msg = $accountModel->GetOneInfoByKeyID($agent_id);
                if ($agent_msg['BossAgentID'] == $exc_msg['BossAgentID']) {
                    $cusmodel = new CustomersModule;
                    $cuspromodel = new CustProModule;
                    $cus = $cusmodel->GetOneByWhere(array('CompanyName'), 'where AgentID=' . $agent_id . ' and CustomersID=' . $cus_id);
                    if ($cus) {
                        $cuspro = $cuspromodel->GetOneByWhere('where AgentID=' . $agent_id . ' and CustomersID=' . $cus_id);
                        if ($cuspro) {
                            $cuspromodel->UpdateArray(array('AgentID' => $exc), $cus_id);
                        }
                        $cusmodel->UpdateArray(array('AgentID' => $exc), $cus_id);
                        $result['data'] = array('name' => $cus['CompanyName']);
                        $this->LogsFunction->LogsCusRecord(118, 1, $cus_id);
                        $this->LogsFunction->LogsCusExc(1, $agent_id, $exc, '转移成功');
                    } else {
                        $result['err'] = 1003;
                        $result['msg'] = '您没有此用户资料';
                        $this->LogsFunction->LogsCusRecord(118, 2, $cus_id, $result['msg']);
                        $this->LogsFunction->LogsCusExc(0, $agent_id, $exc, $result['msg']);
                    }
                } else {
                    $result['err'] = 1003;
                    $result['msg'] = '非法操作';
                    $this->LogsFunction->LogsCusRecord(118, 2, $cus_id, '非同一代理商下的客户');
                    $this->LogsFunction->LogsCusExc(0, $agent_id, $exc, $cus_id, '非同一代理商下的客户');
                }
            } elseif ($level == 2) {
                if ($agent_id == $exc_msg['BossAgentID']) {
                    $cusmodel = new CustomersModule;
                    $cuspromodel = new CustProModule;
                    $cus = $cusmodel->GetOneByWhere(array('CompanyName', 'AgentID'), 'where CustomersID=' . $cus_id);
                    if ($cus) {
                        $agent_msg = $accountModel->GetOneInfoByKeyID($cus['AgentID']);
                        if ($agent_msg['BossAgentID'] == $agent_id) {
                            $cuspro = $cuspromodel->GetOneByWhere('where CustomersID=' . $cus_id);
                            if ($cuspro) {
                                $cuspromodel->UpdateArray(array('AgentID' => $exc), $cus_id);
                            }
                            $cusmodel->UpdateArray(array('AgentID' => $exc), $cus_id);
                            $result['data'] = array('name' => $cus['CompanyName']);
                            $this->LogsFunction->LogsCusRecord(118, 1, $cus_id);
                            $this->LogsFunction->LogsCusExc(1, $agent_id, $exc, '转移成功');
                        } else {
                            $result['err'] = 1003;
                            $result['msg'] = '您没有此用户资料';
                            $this->LogsFunction->LogsCusRecord(118, 2, $cus_id, $result['msg']);
                            $this->LogsFunction->LogsCusExc(0, $agent_id, $exc, $result['msg']);
                        }
                    } else {
                        $result['err'] = 1003;
                        $result['msg'] = '您没有此用户资料';
                        $this->LogsFunction->LogsCusRecord(118, 2, $cus_id, $result['msg']);
                        $this->LogsFunction->LogsCusExc(0, $agent_id, $exc, $result['msg']);
                    }
                } else {
                    $result['err'] = 1003;
                    $result['msg'] = '非法操作,非法转移对象';
                    $this->LogsFunction->LogsCusRecord(118, 2, $cus_id, '非同一代理商下的客户');
                    $this->LogsFunction->LogsCusExc(0, $agent_id, $exc, $cus_id, '非同一代理商下的客户');
                }
            } elseif ($level == 1) {
                $cusmodel = new CustomersModule;
                $cuspromodel = new CustProModule;
                $cus = $cusmodel->GetOneByWhere(array('CompanyName'), 'where CustomersID=' . $cus_id);
                if ($cus && $exc) {
                    $cuspro = $cuspromodel->GetOneByWhere('where CustomersID=' . $cus_id);
                    if ($cuspro) {
                        $cuspromodel->UpdateArray(array('AgentID' => $exc), $cus_id);
                    }
                    $cusmodel->UpdateArray(array('AgentID' => $exc), $cus_id);
                    $result['data'] = array('name' => $cus['CompanyName']);
                    $this->LogsFunction->LogsCusRecord(118, 1, $cus_id);
                    $this->LogsFunction->LogsCusExc(1, $agent_id, $exc, '转移成功');
                } else {
                    $result['err'] = 1003;
                    $result['msg'] = '您没有此用户资料';
                    $this->LogsFunction->LogsCusRecord(118, 2, $cus_id, $result['msg']);
                    $this->LogsFunction->LogsCusExc(0, $agent_id, $exc, $result['msg']);
                }
            } else {
                $result['err'] = 1001;
                $result['msg'] = '此用户资料不存在';
                $this->LogsFunction->LogsCusRecord(115, 2, $cus_id, $result['msg']);
            }
        } else {
            $result['err'] = 1001;
            $result['msg'] = '非法请求';
            $this->LogsFunction->LogsCusRecord(118, 3, $cus_id, $result['msg']);
            $this->LogsFunction->LogsCusExc(0, $agent_id, $exc, $result['msg']);
        }
        return $result;
    }

    //客户网站信息修改处理
    public function Processing() {
        $result = array('err' => 0, 'data' => '', 'msg' => '');
        $agent_id = (int) $_SESSION ['AgentID'];
        $level = (int) $_SESSION ['Level'];
        $power = (int) $_SESSION ['Power'];
        $post = $this->_POST;
        $cus_id = (int) $post['num'];
        if ($cus_id && $this->Assess($power, $this->process)) {
            $cuspromodel = new CustProModule;
            if ($level == 3)
                $cuspro = $cuspromodel->GetOneByWhere('where AgentID=' . $agent_id . ' and CustomersID=' . $cus_id);
            else
                $cuspro = $cuspromodel->GetOneByWhere('where CustomersID=' . $cus_id);
            if (!$cuspro) {
                $result['err'] = 1002;
                $result['msg'] = '您没有此用户资料';
                $this->LogsFunction->LogsCusRecord(114, 2, $cus_id, $result['msg']);
                return $result;
            }
            //时间处理
            if ($post['pc_starttime']) {
                $Data['PC_StartTime'] = strtotime($post['pc_starttime']);
                $addtime = strtotime($cuspro['PC_AddTime']);
                if ($Data['PC_StartTime'] < $addtime or $Data['PC_StartTime'] > strtotime('+1 month', $addtime)) {
                    $result['err'] = 1003;
                    $result['msg'] = '错误的PC上线时间';
                    $this->LogsFunction->LogsCusRecord(114, 3, $cus_id, $result['msg']);
                    return $result;
                }
                $Data['PC_EndTime'] = strtotime($cuspro['PC_EndTime']) + $Data['PC_StartTime'] - strtotime($cuspro['PC_StartTime']);
                $Data['PC_StartTime'] = date('Y-m-d H:i:s', $Data['PC_StartTime']);
                $Data['PC_EndTime'] = date('Y-m-d H:i:s', $Data['PC_EndTime']);
            }
            if ($post['mobile_starttime']) {
                $Data['Mobile_StartTime'] = strtotime($post['mobile_starttime']);
                $addtime = strtotime($cuspro['Mobile_AddTime']);
                if ($Data['Mobile_StartTime'] < $addtime or $Data['Mobile_StartTime'] > strtotime('+1 month', $addtime)) {
                    $result['err'] = 1003;
                    $result['msg'] = '错误的手机上线时间';
                    $this->LogsFunction->LogsCusRecord(114, 3, $cus_id, $result['msg']);
                    return $result;
                }
                $Data['Mobile_EndTime'] = strtotime($cuspro['Mobile_EndTime']) + $Data['Mobile_StartTime'] - strtotime($cuspro['Mobile_StartTime']);
                $Data['Mobile_StartTime'] = date('Y-m-d H:i:s', $Data['Mobile_StartTime']);
                $Data['Mobile_EndTime'] = date('Y-m-d H:i:s', $Data['Mobile_EndTime']);
            }
            //中英关联
            $linkcus = $post['othercus'] ? $post['othercus'] : 0;
            $Data['Link_Cus'] = $linkcus ? $cuspromodel->GetOneByWhere('where G_name=\'' . $linkcus . '\'') ? $linkcus : 0 : 0;
            //模板号域名处理
            $Model = new ModelModule();
            $Data['CPhone'] = $post['pc_mobile'];
            $Data['Customization'] = $post['senior'];
            if ($Data['CPhone'] == 1) {
                if ($Data['Customization'] != 1 && $Data['Customization'] != 0) {
                    $result['err'] = 1004;
                    $result['msg'] = '您选择的高级定制与您选择的类型不相符';
                    $this->LogsFunction->LogsCusRecord(114, 2, $cus_id, $result['msg']);
                    return $result;
                }
                $Data['PK_model'] = 0;
                $Data['PC_model'] = $post['pcmodel'];
                if ($this->GetModleIDByName($Data['PC_model']) > 0) {
                    if ($post['pcdomain']) {
                        $Data['PC_domain'] = 'http://' . str_replace('http://', '', $post['pcdomain']);
                        $Data['PC_domain'] = str_replace(' ', '', $Data['PC_domain']);
                    } else {
                        $result['err'] = 1004;
                        $result['msg'] = '请填写 PC域名';
                        return $result;
                    }
                    $Data['Mobile_model'] = 0;
                    $Data['Mobile_domain'] = $post['outmobile_add'] ? 'http://' . str_replace('http://', '', $post['outmobiledomain']) : '';
                    $Data['Mobile_domain'] = $Data['Mobile_domain'] ? str_replace(' ', '', $Data['Mobile_domain']) : '';
                } else {
                    $result['err'] = 1002;
                    $result['msg'] = '当前PC模板不存在';
                    return $result;
                }
            } elseif ($Data['CPhone'] == 2) {
                if ($Data['Customization'] != 2 && $Data['Customization'] != 0) {
                    $result['err'] = 1004;
                    $result['msg'] = '您选择的高级定制与您选择的类型不相符';
                    $this->LogsFunction->LogsCusRecord(114, 2, $cus_id, $result['msg']);
                    return $result;
                }
                $Data['PK_model'] = 0;
                $Data['Mobile_model'] = $post['mobilemodel'];
                if ($this->GetModleIDByName($Data['Mobile_model']) > 0) {
                    $Data['PC_model'] = 0;
                    $Data['PC_domain'] = $post['outpc_add'] ? 'http://' . str_replace('http://', '', $post['outpcdomain']) : '';
                    $Data['PC_domain'] = str_replace(' ', '', $Data['PC_domain']);
                    if ($post['mobiledomain']) {
                        $Data['Mobile_domain'] = 'http://' . str_replace('http://', '', $post['mobiledomain']);
                        $Data['Mobile_domain'] = str_replace(' ', '', $Data['Mobile_domain']);
                    } else {
                        $result['err'] = 1004;
                        $result['msg'] = '请填写 手机域名';
                        return $result;
                    }
                } else {
                    $result['err'] = 1002;
                    $result['msg'] = '当前手机模板不存在';
                    return $result;
                }
            } elseif ($Data['CPhone'] == 3) {
                $Data['PK_model'] = 0;
                $Data['PC_model'] = $post['pcmodel'];
                if ($this->GetModleIDByName($Data['PC_model']) > 0) {
                    if ($post['pcdomain']) {
                        $Data['PC_domain'] = 'http://' . str_replace('http://', '', $post['pcdomain']);
                        $Data['PC_domain'] = str_replace(' ', '', $Data['PC_domain']);
                    } else {
                        $result['err'] = 1004;
                        $result['msg'] = '请填写 PC域名';
                        return $result;
                    }
                } else {
                    $result['err'] = 1002;
                    $result['msg'] = '当前PC模板不存在';
                    return $result;
                }
                $Data['Mobile_model'] = $post['mobilemodel'];
                if ($this->GetModleIDByName($Data['Mobile_model']) > 0) {
                    if ($post['mobiledomain']) {
                        $Data['Mobile_domain'] = 'http://' . str_replace('http://', '', $post['mobiledomain']);
                        $Data['Mobile_domain'] = str_replace(' ', '', $Data['Mobile_domain']);
                    } else {
                        $result['err'] = 1004;
                        $result['msg'] = '请填写 手机域名';
                        return $result;
                    }
                } else {
                    $result['err'] = 1002;
                    $result['msg'] = '当前手机模板不存在';
                    return $result;
                }
            } else {
                $Data['CPhone'] = 4;
                $Data['PK_model'] = $post['pkmodel'];
                $package_model = $this->GetModleIDByName($Data['PK_model'], true);
                if ($package_model) {
                    $Data['PC_model'] = $package_model['PCNum'];
                    $Data['Mobile_model'] = $package_model['PhoneNum'];
                    /* //判断选择的套餐中
                      if ($this->GetModleIDByName($Data['PK_model'])<1){
                      $result['err'] = 1002;
                      $result['msg'] = '当前选择的套餐中包含的PC模板不存在';
                      echo jsonp($result);
                      exit();
                      }
                      if ($this->GetModleIDByName($Data['PK_model'])<1){
                      $result['err'] = 1002;
                      $result['msg'] = '当前选择的套餐中包含的手机模板不存在';
                      echo jsonp($result);
                      exit();
                      } */
                    if ($post['pcdomain']) {
                        $Data['PC_domain'] = 'http://' . str_replace('http://', '', $post['pcdomain']);
                        $Data['PC_domain'] = str_replace(' ', '', $Data['PC_domain']);
                    } else {
                        $result['err'] = 1004;
                        $result['msg'] = '请填写 PC域名';
                        return $result;
                    }
                    if ($post['mobiledomain']) {
                        $Data['Mobile_domain'] = 'http://' . str_replace('http://', '', $post['mobiledomain']);
                        $Data['Mobile_domain'] = str_replace(' ', '', $Data['Mobile_domain']);
                    } else {
                        $result['err'] = 1004;
                        $result['msg'] = '请填写 手机域名';
                        return $result;
                    }
                } else {
                    $result['err'] = 1002;
                    $result['msg'] = '当前套餐模板不存在';
                    return $result;
                }
            }
//            $ordermodule = new OrderModule();
//            $order_data = $ordermodule->GetOneInfoByKeyID($cuspro["OrderID"]);
//            $ordermodule->UpdateArray(array("OrderEndDate"=> date("Y-m-d H:i:s",time())),array("OrderID"=>$order_data["OrderID"]));
//            $price = 0;
//            $all_month = ceil((strtotime($order_data["OrderEndDate"]) - strtotime($order_data["OrderStartDate"])) / 60 / 60 / 24 / 30);
//            if (strtotime($order_data["OrderEndDate"]) > time()) {
//                $need_month = ceil((strtotime($order_data["OrderEndDate"]) - time()) / 60 / 60 / 24 / 30);
//            } else {
//                $need_month = 0;
//            }
//            $model = new ModelModule();
//            if ($cuspro["CPhone"] == $Data["CPhone"]) {
//                if ($Data["CPhone"] == 1) {
//                    if ($cuspro["PC_model"] != $Data["PC_model"]) {
//                        //重新计费
//                        $price = 0;
//                        $modelinfo = $model->GetOneByWhere(array(), array("NO" => $Data["PC_model"]));
//                        $have_p_month = ceil((strtotime($cuspro["PC_EndTime"]) - time()) / 60 / 60 / 24 / 30);
//                        $price = ($modelinfo["Youhui"] / 12 * $have_p_month) - ($need_month / $all_month * $order_data["OrderAmount"]);
//                    }
//                }
//                if ($Data["CPhone"] == 2) {
//                    if ($cuspro["Mobile_model"] != $Data["Mobile_model"]) {
//                        //重新计费
//                        $price = 0;
//                        $modelinfo = $model->GetOneByWhere(array(), array("NO" => $Data["Mobile_model"]));
//                        $have_m_month = ceil((strtotime($cuspro["Mobile_EndTime"]) - time()) / 60 / 60 / 24 / 30);
//                        $price = ($modelinfo["Youhui"] / 12 * $have_m_month) - ($need_month / $all_month * $order_data["OrderAmount"]);
//                    }
//                }
//                if ($Data["CPhone"] == 3) {
//                    if ($cuspro["Mobile_model"] != $Data["Mobile_model"] || $cuspro["PC_model"] != $Data["PC_model"]) {
//                        //重新计费
//                        $price = 0;
//                        $Mobile_modelinfo = $model->GetOneByWhere(array(), array("NO" => $Data["Mobile_model"]));
//                        $PC_modelinfo = $model->GetOneByWhere(array(), array("NO" => $Data["PC_model"]));
//                        $have_p_month = ceil((strtotime($cuspro["PC_EndTime"]) - time()) / 60 / 60 / 24 / 30);
//                        $have_m_month = ceil((strtotime($cuspro["Mobile_EndTime"]) - time()) / 60 / 60 / 24 / 30);
//                        $price = ($Mobile_modelinfo["Youhui"] / 12 * $have_m_month) + ($PC_modelinfo["Youhui"] / 12 * $have_p_month) - ($need_month / $all_month * $order_data["OrderAmount"]);
//                    }
//                }
//                if ($Data["CPhone"] == 4) {
//                    if ($cuspro["PK_model"] != $Data["PK_model"]) {
//                        //重新计费
//                        $price = 0;
//                        $model = new ModelPackageModule();
//                        $modelinfo = $model->GetOneByWhere(array(), array("PackagesNum" => $Data["PK_model"]));
//                        $have_p_month = ceil((strtotime($cuspro["PC_EndTime"]) - time()) / 60 / 60 / 24 / 30);
//                        $price = ($modelinfo["Youhui"] / 12 * $have_p_month) - ($need_month / $all_month * $order_data["OrderAmount"]);
//                    }
//                }
//            } else {
//                //重新计费
//                if ($Data["CPhone"] == 1) {
//                    //重新计费
//                    $price = 0;
//                    $modelinfo = $model->GetOneByWhere(array(), array("NO" => $Data["PC_model"]));
//                    $have_p_month = ceil((strtotime($cuspro["PC_EndTime"]) - time()) / 60 / 60 / 24 / 30);
//                    $price = ($modelinfo["Youhui"] / 12 * $have_p_month) - ($need_month / $all_month * $order_data["OrderAmount"]);
//                }
//                if ($Data["CPhone"] == 2) {
//                    //重新计费
//                    $price = 0;
//                    $modelinfo = $model->GetOneByWhere(array(), array("NO" => $Data["Mobile_model"]));
//                    $have_m_month = ceil((strtotime($cuspro["Mobile_EndTime"]) - time()) / 60 / 60 / 24 / 30);
//                    $price = ($modelinfo["Youhui"] / 12 * $have_m_month) - ($need_month / $all_month * $order_data["OrderAmount"]);
//                }
//                if ($Data["CPhone"] == 3) {
//                    //重新计费
//                    $price = 0;
//                    $Mobile_modelinfo = $model->GetOneByWhere(array(), array("NO" => $Data["Mobile_model"]));
//                    $PC_modelinfo = $model->GetOneByWhere(array(), array("NO" => $Data["PC_model"]));
//                    $have_p_month = ceil((strtotime($cuspro["PC_EndTime"]) - time()) / 60 / 60 / 24 / 30);
//                    $have_m_month = ceil((strtotime($cuspro["Mobile_EndTime"]) - time()) / 60 / 60 / 24 / 30);
//                    $price = ($Mobile_modelinfo["Youhui"] / 12 * $have_m_month) + ($PC_modelinfo["Youhui"] / 12 * $have_p_month) - ($need_month / $all_month * $order_data["OrderAmount"]);
//                }
//                if ($Data["CPhone"] == 4) {
//                    //重新计费
//                    $price = 0;
//                    $model = new ModelPackageModule();
//                    $modelinfo = $model->GetOneByWhere(array(), array("PackagesNum" => $Data["PK_model"]));
//                    $have_p_month = ceil((strtotime($cuspro["PC_EndTime"]) - time()) / 60 / 60 / 24 / 30);
//                    $price = ($modelinfo["Youhui"] / 12 * $have_p_month) - ($need_month / $all_month * $order_data["OrderAmount"]);
//                }
//            }
//            //价格计算开始，根据等级得到扣款的代理商账户
//            
//            $balance=new BalanceModule();
//            $agent=new AccountModule();
//            $costID=$cuspro["AgentID"];
//            $agentinfo = $agent->GetOneInfoByKeyID($cuspro["AgentID"]);
//            if ($cuspro["level"] == 3) {
//                $costAccount = $balance->GetOneInfoByAgentID($agentinfo['BossAgentID']);
//                $agentAccount = $balance->GetOneInfoByAgentID($cuspro["AgentID"]);
//                unset($agentAccount['ID']);
//                unset($costAccount['ID']);
//                if ($costAccount['Balance'] < $price) {
//                    $result['err'] = 1003;
//                    $result['msg'] = '您的余额不足，请及时充值';
//                    $this->LogsFunction->LogsCusRecord(115, 4, $cus_id, $result['msg']);
//                    return $result;
//                }
//                //代理商消费计算
//                $updatetime = explode('-', $costAccount['UpdateTime']);
//                $update_boss['CostMon'] = $costAccount['CostMon'];
//                if (date('m', time()) != $updatetime[1]) {
//                    $update_boss['UpdateTime'] = date('Y-m-d', time());
//                    $update_boss['CostMon'] = 0;
//                }
//                $update_boss['Balance'] = $costAccount['Balance'] - $price;
//                $update_boss['CostMon'] = $update_boss['CostMon'] + $price;
//                $update_boss['CostAll'] = $update_boss['CostAll'] + $price;
//                //客服消费计算
//                $updatetime = explode('-', $agentAccount['UpdateTime']);
//                $update_self['CostMon'] = $agentAccount['CostMon'];
//                if (date('m', time()) != $updatetime[1]) {
//                    $update_self['UpdateTime'] = date('Y-m-d', time());
//                    $update_self['CostMon'] = 0;
//                }
//                $update_self['CostMon'] = $update_self['CostMon'] + $price;
//                $update_self['CostAll'] = $update_self['CostAll'] + $price;
//            } else {
//                $costAccount = $balance->GetOneInfoByAgentID($agentinfo['AgentID']);
//                unset($costAccount['ID']);
//                if ($costAccount['Balance'] < $price) {
//                    $result['err'] = 1003;
//                    $result['msg'] = '您的余额不足，请及时充值';
//                    $this->LogsFunction->LogsCusRecord(115, 4, $cus_id, $result['msg']);
//                    return $result;
//                }
//                //扣款消费
//                $updatetime = explode('-', $costAccount['UpdateTime']);
//                $update_self['CostMon'] = $costAccount['CostMon'];
//                if (date('m', time()) != $updatetime[1]) {
//                    $update_self['UpdateTime'] = date('Y-m-d', time());
//                    $update_self['CostMon'] = 0;
//                }
//                $update_self['Balance'] = $costAccount['Balance'] - $price;
//                $update_self['CostMon'] = $update_self['CostMon'] + $price;
//                $update_self['CostAll'] = $update_self['CostAll'] + $price;
//            }
            $Data['UpdateTime'] = date('Y-m-d H:i:s', time());
            $IsOk = $this->ToGbaoPenEditInfo(array_replace($cuspro, $Data));
            if ($IsOk['err'] != 1000) {
                $result['err'] = 1001;
                $result['msg'] = '统一平台同步失败，请重试';
                $this->LogsFunction->LogsCusRecord(114, 6, $cus_id, $result['msg']);
                $result['data'] = $IsOk;
                return $result;
            }
//            if (!$balance->UpdateArrayByAgentID($update_self, $costID)) {
//                $this->ToGbaoPenEditInfo($cuspro);
//                $result['err'] = 1004;
//                $result['msg'] = '网站处理失败，请重试，若依然无效，酌情联系管理员1';
//                $this->LogsFunction->LogsCusRecord(115, 0, $cus_id, $result['msg']);
//                return $result;
//            }
//            if ($agentinfo['Level'] == 3) {
//                if (!$balance->UpdateArrayByAgentID($update_boss, $agentinfo['BossAgentID'])) {
//                    $this->ToGbaoPenEditInfo($cuspro);
//                    $balance->UpdateArrayByAgentID($agent_bal, $costID);
//                    $result['err'] = 1004;
//                    $result['msg'] = '网站处理失败，请重试，若依然无效，酌情联系管理员2';
//                    $this->LogsFunction->LogsCusRecord(115, 0, $cus_id, $result['msg']);
//                    return $result;
//                }
//            }
            $cuspromodel->UpdateArray($Data, $cus_id);
            $result['data']['name'] = '您选择的客户';
            $result['msg'] = '修改成功';
            $this->LogsFunction->LogsCusRecord(114, 5, $cus_id, $result['msg']);
//            $order_data = array("OrderAmount" => $price, "CustomersID" => $cuspro['CustomersID'], "OrderStartDate" => date('Y-m-d H:i:s', time()), "OrderEndDate" => $cuspro["PC_EndTime"], "CPhone" => $Data["CPhone"], "PK_model" => $Data["PK_model"], "PC_model" => $Data["PC_model"], "Mobile_model" => $Data["Mobile_model"]);
//            $ordermodule = new OrderModule();
//            $orderID = $ordermodule->InsertArray($order_data);
//            $CustProModule=new CustProModule;
//            $CustProModule->UpdateArrayByKeyID(array("OrderID" => $orderID), $cuspro["CustomersProjectID"]);
//            $logcost_data = array("ip" => $_SERVER["REMOTE_ADDR"], "cost" => $price, "type" => 2, "description" => "修改订单", "adddate" => date('Y-m-d H:i:s', time()), "CustomersID" => $Data['CustomersID']);
//            $logcost = new LogcostModule();
//            $logcost->InsertArray($logcost_data);
        } else {
            $result['err'] = 1001;
            $result['msg'] = '非法请求';
            $this->LogsFunction->LogsCusRecord(114, 6, $cus_id, $result['msg']);
        }
        return $result;
    }

    //客户开通G宝盆
    public function NewCus() {
        $result = array('err' => 0, 'data' => '', 'msg' => '');
        $agent_id = (int) $_SESSION ['AgentID'];
        $power = $_SESSION ['Power'];
        $level = $_SESSION ['Level'];
        $post = $this->_POST;
        $post['cus'] = (int) $post['cus'];
        $agent = new AccountModule;
        $balance = new BalanceModule;
        $CustProModule = new CustProModule;
        $agentinfo = $agent->GetOneInfoByKeyID($agent_id);
        if ($this->Assess($power, $this->create)) {
            $CustomersModule = new CustomersModule ();
            $crtdata ['CompanyName'] = trim($post ['companyname']);
            $crtdata ['CustomersName'] = trim($post ['name']);
            $crtdata ['Tel'] = trim($post ['tel']);
            $crtdata ['Fax'] = trim($post ['fax']);
            $crtdata ['Address'] = trim($post ['address']);
            $crtdata ['Remark'] = addslashes($post ['remark']);
            $crtdata ['UpdateTime'] = date('Y-m-d H:i:s', time());
            $crtdata ['Experience'] = trim(isset($post['experience']) && $level == 2 && $agentinfo["ExperienceCount"] > 0 ? $post['experience'] : 0);
            if (!($crtdata ['CompanyName'] && $crtdata ['CustomersName'] && $crtdata ['Tel'])) {
                $result['err'] = 1004;
                $result['msg'] = '公司名称，联系人，电话都不能为空';
                return $result;
            }
            //客户创建和开通
            if ($post['type'] == 'cus') {
                $crtdata['Email'] = trim($post['email']);
                $crtdata ['GOpen'] = '0';
                $return = $this->CreateCus($crtdata, $agent_id, $CustomersModule);
                if ($return['err']) {
                    $result['err'] = $return['err'];
                    $result['msg'] = $return['msg'];
                    return $result;
                } else {
                    $result['msg'] = $return['msg'];
                    if ($crtdata ['Experience'] == "1") {
                        $agent->UpdateArray(array("ExperienceCount" => ($agentinfo["ExperienceCount"] - 1)), array('AgentID' => $agent_id));
                    }
                }
                $this->LogsFunction->LogsCusRecord(111, 1, 0, $result['msg']);
            } elseif ($post['type'] == 'cuspro') {
                //默认值设置
                $Data['Capacity'] = 300 * 1024 * 1024;//$post['capacity'] * 1024 * 1024;默认300M
                $Data['Link_Cus'] = '0';
                $Data['status'] = 1;

                $Data['AgentID'] = $agent_id;
                $Data['G_name'] = trim($post ['account']);
                if (!$Data['G_name'] || preg_match("/[\x{4e00}-\x{9fa5}]/u", $Data['G_name'])) {
                    $result['err'] = 1004;
                    $result['msg'] = 'G宝盆账号不能为中文或为空';
                    return $result;
                }
                if (!preg_match("/^[a-zA-Z0-9][a-zA-Z0-9-]*[a-zA-Z0-9]$/", $Data['G_name'])) {
                    $result['err'] = 1004;
                    $result['msg'] = 'G宝盆账号只能由数字，字母，分隔号构成。首字符和尾字符只能是数字或字母';
                    return $result;
                }
                //FTP处理
                if ($post['ftp_c']) {
                    $FuwiqiModule = new FuwuqiModule ();
                    $sever_msg = $FuwiqiModule->GetOneByIDorWhere($post['ftp']);
                    $Data['FTP'] = 1;
                    $Data['FuwuqiID'] = $sever_msg['ID'];
                    if ($sever_msg['State']) {
                        $Data['G_Ftp_Address'] = $sever_msg['FTP'];
                        $Data['G_Ftp_User'] = $sever_msg['FTPName'];
                        $Data['G_Ftp_Pwd'] = $sever_msg['FTPPassword'];
                        $Data['G_Ftp_FwAdress'] = $sever_msg['FwAdress'];
                        $Data['G_Ftp_Duankou'] = $sever_msg['FTPDuankou'];
                        $Data['G_Ftp_Mulu'] = $sever_msg['FTPMulu'];
                    } else {
                        $result['err'] = 1002;
                        $result['msg'] = $sever_msg['FuwuqiName'] . '已停用';
                        $this->LogsFunction->LogsCusRecord(113, 2, 0, $result['msg']);
                        return $result;
                    }
                } else {
                    $Data['G_Ftp_Address'] = $post['ftp_address'];
                    $Data['G_Ftp_User'] = $post['ftp_user'];
                    $Data['G_Ftp_Pwd'] = $post['ftp_pwd'];
                    $Data['G_Ftp_FwAdress'] = $post['ftp_fwaddress'];
                    $Data['G_Ftp_Duankou'] = $post['ftp_duankou'];
                    $Data['G_Ftp_Mulu'] = $post['ftp_mulu'];
                }
                //模板号域名处理,费用计算
                $Data['CPhone'] = $post['pc_mobile'];
                $Data['Customization'] = $post['super'];
                if ($Data['CPhone'] == 1) {
                    if ($Data['Customization'] != 1 && $Data['Customization'] != 0) {
                        $result['err'] = 1004;
                        $result['msg'] = '您选择的高级定制与您选择的类型不相符';
                        $this->LogsFunction->LogsCusRecord(113, 2, 0, $result['msg']);
                        return $result;
                    }
                    $Data['PK_model'] = 0;
                    $Data['PC_model'] = $post['pcmodel'];
                    $modelMsg = $this->GetModleIDByName($Data['PC_model']);
                    if (is_array($modelMsg)) {
                        if ($post['pcdomain']) {
                            $Data['PC_domain'] = 'http://' . str_replace('http://', '', $post['pcdomain']);
                            $Data['PC_domain'] = str_replace(' ', '', $Data['PC_domain']);
                        } else {
                            $result['err'] = 1004;
                            $result['msg'] = '请填写 PC域名';
                            return $result;
                        }
                        $Data['Mobile_model'] = 0;
                        if ($post['outmobile_add']) {
                            $Data['Mobile_domain'] = 'http://' . str_replace('http://', '', $post['outmobiledomain']);
                            $Data['Mobile_domain'] = str_replace(' ', '', $Data['Mobile_domain']);
                        }
                    } else {
                        $result['err'] = 1002;
                        $result['msg'] = '当前PC模板不存在';
                        return $result;
                    }
                    $price = $modelMsg['Youhui'];
                } elseif ($Data['CPhone'] == 2) {
                    if ($Data['Customization'] != 2 && $Data['Customization'] != 0) {
                        $result['err'] = 1004;
                        $result['msg'] = '您选择的高级定制与您选择的类型不相符';
                        $this->LogsFunction->LogsCusRecord(113, 2, 0, $result['msg']);
                        return $result;
                    }
                    $Data['PK_model'] = 0;
                    $Data['Mobile_model'] = $post['mobilemodel'];
                    $modelMsg = $this->GetModleIDByName($Data['Mobile_model']);
                    if (is_array($modelMsg)) {
                        $Data['PC_model'] = 0;
                        if ($post['outpc_add']) {
                            $Data['PC_domain'] = 'http://' . str_replace('http://', '', $post['outpcdomain']);
                            $Data['PC_domain'] = str_replace(' ', '', $Data['PC_domain']);
                        }
                        if ($post['mobiledomain']) {
                            $Data['Mobile_domain'] = 'http://' . str_replace('http://', '', $post['mobiledomain']);
                            $Data['Mobile_domain'] = str_replace(' ', '', $Data['Mobile_domain']);
                        } else {
                            $result['err'] = 1004;
                            $result['msg'] = '请填写 手机域名';
                            return $result;
                        }
                    } else {
                        $result['err'] = 1002;
                        $result['msg'] = '当前手机模板不存在';
                        return $result;
                    }
                    $price = $modelMsg['Youhui'];
                } elseif ($Data['CPhone'] == 3) {
                    $Data['PK_model'] = 0;
                    $Data['PC_model'] = $post['pcmodel'];
                    $modelMsg = $this->GetModleIDByName($Data['PC_model']);
                    if (is_array($modelMsg)) {
                        if ($post['pcdomain']) {
                            $Data['PC_domain'] = 'http://' . str_replace('http://', '', $post['pcdomain']);
                            $Data['PC_domain'] = str_replace(' ', '', $Data['PC_domain']);
                        } else {
                            $result['err'] = 1004;
                            $result['msg'] = '请填写 PC域名';
                            return $result;
                        }
                    } else {
                        $result['err'] = 1002;
                        $result['msg'] = '当前PC模板不存在';
                        return $result;
                    }
                    $Data['Mobile_model'] = $post['mobilemodel'];
                    //pc价格
                    $price = $modelMsg['Youhui'];

                    $modelMsg = $this->GetModleIDByName($Data['Mobile_model']);
                    if (is_array($modelMsg)) {
                        if ($post['mobiledomain']) {
                            $Data['Mobile_domain'] = 'http://' . str_replace('http://', '', $post['mobiledomain']);
                            $Data['Mobile_domain'] = str_replace(' ', '', $Data['Mobile_domain']);
                        } else {
                            $result['err'] = 1004;
                            $result['msg'] = '请填写 手机域名';
                            return $result;
                        }
                    } else {
                        $result['err'] = 1002;
                        $result['msg'] = '当前手机模板不存在';
                        return $result;
                    }
                    //pc+手机 总价格
                    $price += $modelMsg['Youhui'];
                } else {
                    $Data['CPhone'] = 4;
                    $Data['PK_model'] = $post['pkmodel'];
                    $modelMsg = $this->GetModleIDByName($Data['PK_model'], true);
                    if ($modelMsg) {
                        $Data['PC_model'] = $modelMsg['PCNum'];
                        $Data['Mobile_model'] = $modelMsg['PhoneNum'];
                        /* //判断选择的套餐中
                          if ($this->GetModleIDByName($Data['PK_model'])<1){
                          $result['err'] = 1002;
                          $result['msg'] = '当前选择的套餐中包含的PC模板不存在';
                          return $result;
                          }
                          if ($this->GetModleIDByName($Data['PK_model'])<1){
                          $result['err'] = 1002;
                          $result['msg'] = '当前选择的套餐中包含的手机模板不存在';
                          return $result;
                          } */
                        if ($post['pcdomain']) {
                            $Data['PC_domain'] = 'http://' . str_replace('http://', '', $post['pcdomain']);
                            $Data['PC_domain'] = str_replace(' ', '', $Data['PC_domain']);
                        } else {
                            $result['err'] = 1004;
                            $result['msg'] = '请填写 PC域名';
                            return $result;
                        }
                        if ($post['mobiledomain']) {
                            $Data['Mobile_domain'] = 'http://' . str_replace('http://', '', $post['mobiledomain']);
                            $Data['Mobile_domain'] = str_replace(' ', '', $Data['Mobile_domain']);
                        } else {
                            $result['err'] = 1004;
                            $result['msg'] = '请填写 手机域名';
                            return $result;
                        }
                    } else {
                        $result['err'] = 1002;
                        $result['msg'] = '当前套餐模板不存在';
                        return $result;
                    }
                    //模板价格
                    $price = $modelMsg['Youhui'];
                }
//                if ($Data["Capacity"] == (300 * 1024 * 1024)) {
//                    $price+=500;
//                } elseif($Data["Capacity"] == (500 * 1024 * 1024)){
//                    $price+=800;
//                }elseif($Data["Capacity"] == (1000 * 1024 * 1024)){
//                    $price+=1500;
//                }elseif($Data["Capacity"] == (100 * 1024 * 1024)){
//                    $price+=300;
//                }else{
//                    $result['err'] = 1004;
//                    $result['msg'] = '容量空间选择错误';
//                    return $result;
//                }
                
                //时间处理给成默认值年限1年
//                if ($post['stilltime'])
//                    $stilltime = intval($post['stilltime'])>0?intval($post['stilltime']):1;
//                else{
//                    $stilltime = 1;
//                }
                $stilltime = 1;
                $price = $price * $stilltime;
                if ($crtdata ['Experience'] == "1") {
                    $price = 0;
                    $stilltime = 0;
                }
                $nowtime = time();

                //优惠码处理
                $coupons = $post['coupons'];
                $couprice=0;
                if ($coupons) {
                    $couponsprice = file_get_contents(DAILI_DOMAIN . '?module=ApiModel&action=GetCoupons&code=' . $coupons);
                    if ($couponsprice > 0) {
                        $Data['Coupons'] = $coupons;
                        $Data['CouponsPrice'] = $couponsprice;
                        $couprice=$couponsprice;
                    }
                }
                $price=$price-$couprice;
                
                //价格计算开始，根据等级得到扣款的代理商账户
                if ($level == 3) {
                    $costAccount = $balance->GetOneInfoByAgentID($agentinfo['BossAgentID']);
                    $agentAccount = $balance->GetOneInfoByAgentID($agent_id);
                    $CostID=$agentinfo['BossAgentID'];
                    unset($agentAccount['ID']);
                    unset($costAccount['ID']);
                    if ($costAccount['Balance'] < $price) {
                        $result['err'] = 1003;
                        $result['msg'] = '您的余额不足，请及时充值';
                        $this->LogsFunction->LogsCusRecord(115, 4, $cus_id, $result['msg']);
                        return $result;
                    }
                    //扣款
                    $updatetime = explode('-', $costAccount['UpdateTime']);
                    $update_boss['CostMon'] = $costAccount['CostMon'];
                    if (date('m', $nowtime) != $updatetime[1]) {
                        $update_boss['UpdateTime'] = date('Y-m-d', $nowtime);
                        $update_boss['CostMon'] = 0;
                    }
                    $update_boss['Balance'] = $costAccount['Balance'] - $price;
                    $update_boss['CostMon'] = $update_cost['CostMon'] + $price;
                    $update_boss['CostAll'] = $update_cost['CostAll'] + $price;
                    //消费
                    $updatetime = explode('-', $agentAccount['UpdateTime']);
                    $update_self['CostMon'] = $agentAccount['CostMon'];
                    if (date('m', $nowtime) != $updatetime[1]) {
                        $update_self['UpdateTime'] = date('Y-m-d', $nowtime);
                        $update_self['CostMon'] = 0;
                    }
                    $update_self['CostMon'] = $update_cost['CostMon'] + $price;
                    $update_self['CostAll'] = $update_cost['CostAll'] + $price;
                    $balance_money=$update_boss['Balance'];
                } else {
                    $costAccount = $balance->GetOneInfoByAgentID($agent_id);
                    $CostID=$agent_id;
                    unset($costAccount['ID']);
                    if ($costAccount['Balance'] < $price) {
                        $result['err'] = 1003;
                        $result['msg'] = '您的余额不足，请及时充值';
                        $this->LogsFunction->LogsCusRecord(115, 4, $cus_id, $result['msg']);
                        return $result;
                    }
                    //扣款消费
                    $updatetime = explode('-', $costAccount['UpdateTime']);
                    $update_self['CostMon'] = $costAccount['CostMon'];
                    if (date('m', $nowtime) != $updatetime[1]) {
                        $update_self['UpdateTime'] = date('Y-m-d', $nowtime);
                        $update_self['CostMon'] = 0;
                    }
                    $update_self['Balance'] = $costAccount['Balance'] - $price;
                    $update_self['CostMon'] = $update_cost['CostMon'] + $price;
                    $update_self['CostAll'] = $update_cost['CostAll'] + $price;
                    $balance_money=$update_self['Balance'];
                }

//                $balance=new BalanceModule();
//                $agent=new AccountModule();
//                $costID=$cuspro["AgentID"];
//                $agentinfo = $agent->GetOneInfoByKeyID($cuspro["AgentID"]);
//                if ($cuspro["level"] == 3) {
//                    $costAccount = $balance->GetOneInfoByAgentID($agentinfo['BossAgentID']);
//                    $agentAccount = $balance->GetOneInfoByAgentID($cuspro["AgentID"]);
//                    unset($agentAccount['ID']);
//                    unset($costAccount['ID']);
//                    if ($costAccount['Balance'] < $price) {
//                        $result['err'] = 1003;
//                        $result['msg'] = '您的余额不足，请及时充值';
//                        $this->LogsFunction->LogsCusRecord(115, 4, $cus_id, $result['msg']);
//                        return $result;
//                    }
//                    //代理商消费计算
//                    $updatetime = explode('-', $costAccount['UpdateTime']);
//                    $update_boss['CostMon'] = $costAccount['CostMon'];
//                    if (date('m', time()) != $updatetime[1]) {
//                        $update_boss['UpdateTime'] = date('Y-m-d', time());
//                        $update_boss['CostMon'] = 0;
//                    }
//                    $update_boss['Balance'] = $costAccount['Balance'] - $price;
//                    $update_boss['CostMon'] = $update_boss['CostMon'] + $price;
//                    $update_boss['CostAll'] = $update_boss['CostAll'] + $price;
//                    //客服消费计算
//                    $updatetime = explode('-', $agentAccount['UpdateTime']);
//                    $update_self['CostMon'] = $agentAccount['CostMon'];
//                    if (date('m', time()) != $updatetime[1]) {
//                        $update_self['UpdateTime'] = date('Y-m-d', time());
//                        $update_self['CostMon'] = 0;
//                    }
//                    $update_self['CostMon'] = $update_self['CostMon'] + $price;
//                    $update_self['CostAll'] = $update_self['CostAll'] + $price;
//                } else {
//                    $costAccount = $balance->GetOneInfoByAgentID($agentinfo['AgentID']);
//                    unset($costAccount['ID']);
//                    if ($costAccount['Balance'] < $price) {
//                        $result['err'] = 1003;
//                        $result['msg'] = '您的余额不足，请及时充值';
//                        $this->LogsFunction->LogsCusRecord(115, 4, $cus_id, $result['msg']);
//                        return $result;
//                    }
//                    //扣款消费
//                    $updatetime = explode('-', $costAccount['UpdateTime']);
//                    $update_self['CostMon'] = $costAccount['CostMon'];
//                    if (date('m', time()) != $updatetime[1]) {
//                        $update_self['UpdateTime'] = date('Y-m-d', time());
//                        $update_self['CostMon'] = 0;
//                    }
//                    $update_self['Balance'] = $costAccount['Balance'] - $price;
//                    $update_self['CostMon'] = $update_self['CostMon'] + $price;
//                    $update_self['CostAll'] = $update_self['CostAll'] + $price;
//                }

                $addtime = strtotime("+1 month", $nowtime);
                if (in_array($Data['CPhone'], array(1, 3, 4))) {
                    $Data['PC_StartTime'] = date('Y-m-d H:i:s', $nowtime);
                    $Data['PC_EndTime'] = date('Y-m-d H:i:s', strtotime("+" . $stilltime . " year", $addtime));
                    $Data['PC_AddTime'] = date('Y-m-d H:i:s', strtotime("-1 minute", $nowtime));
                }
                if (in_array($Data['CPhone'], array(2, 3, 4))) {
                    $Data['Mobile_StartTime'] = date('Y-m-d H:i:s', $nowtime);
                    $Data['Mobile_EndTime'] = date('Y-m-d H:i:s', strtotime("+" . $stilltime . " year", $addtime));
                    $Data['Mobile_AddTime'] = date('Y-m-d H:i:s', strtotime("-1 minute", $nowtime));
                }
                $Data['UpdateTime'] = $nowtime;
                $Data['ProjectID'] = 1;
                //新建G宝盆信息，并同步统一平台
                $GnameNum = $CustProModule->GetListsNum("where G_name='" . $Data['G_name'] . "'");
                if ($GnameNum ['Num'] > 0) {
                    $result['err'] = 1001;
                    $result['msg'] = '已存在该账号的客户，请更改账号名';
                    $this->LogsFunction->LogsCusRecord(113, 2, 0, $result['msg']);
                    return $result;
                }
                if (intval($post['cus'])) {
                    $Data['CustomersID'] = intval($post['cus']);
                    $CustomersModule->UpdateArray($crtdata, array('AgentID' => $agent_id, 'CustomersID' => $Data['CustomersID'], 'GOpen' => '1'));
                    $customerinfo = $CustomersModule->GetOneInfoByKeyID($Data['CustomersID']);
                    if ($crtdata ['Experience'] == "1" && $customerinfo['Experience'] != '1') {
                        $agent->UpdateArray(array("ExperienceCount" => ($agentinfo["ExperienceCount"] - 1)), array('AgentID' => $agent_id));
                    }
                } else {
                    $crtdata ['Email'] = trim($post ['email']);
                    $crtdata ['GOpen'] = '1';
                    $return = $this->CreateCus($crtdata, $agent_id, $CustomersModule, true);
                    if ($return['err']) {
                        $result['err'] = $return['err'];
                        $result['msg'] = $return['msg'];
                        return $result;
                    } else
                        $Data['CustomersID'] = $return['msg'];
                    if ($crtdata ['Experience'] == "1") {
                        $agent->UpdateArray(array("ExperienceCount" => ($agentinfo["ExperienceCount"] - 1)), array('AgentID' => $agent_id));
                    }
                }
                $Data['CreateTime'] = date('Y-m-d H:i:s', time());
                $IsOk = $this->ToGbaoPenEditInfo(array_replace($Data, $crtdata));
                if ($IsOk['err'] != 1000) {
                    $result['err'] = 1001;
                    if (!intval($post['cus'])) {
                        $CustomersModule->DeleteInfoByKeyID($Data['CustomersID']);
                        $result['msg'] = '统一平台创建客户失败，已删除此客户';
                    } else {
                        $result['msg'] = '统一平台创建客户失败，请重试';
                    }
                    $this->LogsFunction->LogsCusRecord(113, 6, $Data['CustomersID'], $result['msg']);
                    $result['data'] = $IsOk;
                    return $result;
                }
                $CustomersProjectID = $CustProModule->InsertArray($Data, true);
                $balance = new BalanceModule();
                if (!$balance->UpdateArrayByAgentID($update_self, $agent_id)) {
                    $result['err'] = 1004;
                    $result['msg'] = '新建用户失败，请重试，若依然无效，酌情联系管理员1';
                    $this->LogsFunction->LogsCusRecord(113, 0, $Data['CustomersID'], $result['msg']);
                    return $result;
                }
                if ($level == 3) {
                    if (!$balance->UpdateArrayByAgentID($update_boss, $agentinfo['BossAgentID'])) {
                        $result['err'] = 1004;
                        $result['msg'] = '新建用户失败，请重试，若依然无效，酌情联系管理员2';
                        $this->LogsFunction->LogsCusRecord(113, 0, $Data['CustomersID'], $result['msg']);
                        return $result;
                    }
                }
                if ($CustomersProjectID) {
                    $coupons ? file_get_contents(DAILI_DOMAIN . '?module=ApiModel&action=GetCoupons&code=' . $coupons . '&use=1') : '';
                    $result['msg'] = '创建客户及开通G宝盆成功';
                    $this->LogsFunction->LogsCusRecord(113, 5, $Data['CustomersID'], $result['msg']);
                    $orderID= time().rand(1000,9999);
                    $order_data = array("orderID"=>$orderID,"OrderAmount" => $price, "CustomersID" => $Data['CustomersID'], "CreateTime" => date('Y-m-d H:i:s', time()), "StillTime" => $stilltime, "CPhone" => $Data["CPhone"], "PK_model" => $Data["PK_model"], "PC_model" => $Data["PC_model"], "Mobile_model" => $Data["Mobile_model"],"Capacity"=>$Data["Capacity"]);
                    $ordermodule = new OrderModule();
                    $ordermodule->InsertArray($order_data);
                    $logcost_data = array("ip" => $_SERVER["REMOTE_ADDR"], "cost" => (0-$price), "type" => 1, "description" => ($crtdata ['Experience']==1?"创建体验客户及开通G宝盆":"创建客户及开通G宝盆"), "adddate" => date('Y-m-d H:i:s', time()), "CustomersID" => $Data['CustomersID'],"AgentID"=>$agent_id,"CostID"=>$CostID,"Balance"=>$balance_money,"OrderID"=>$orderID);
                    $logcost = new LogcostModule();
                    $logcost->InsertArray($logcost_data);
                } else {
                    if (!intval($post['cus'])) {
                        $CustomersModule->DeleteInfoByKeyID($Data['CustomersID']);
                        $result['msg'] = '创建G宝盆账号失败，请重试';
                    } else
                        $result['msg'] = '创建G宝盆账号失败，已删除此客户';
                    $result['err'] = 1001;
                    $this->LogsFunction->LogsCusRecord(113, 0, $Data['CustomersID'], $result['msg']);
                }
            }else {
                $result = array('err' => 1005, 'data' => '', 'msg' => '错误的信息提交');
                $this->LogsFunction->LogsCusRecord(113, 0, $CustomersID, '非法类型选择操作');
            }
        } else {
            $result['err'] = 1006;
            $result['msg'] = '非法请求';
            $this->LogsFunction->LogsCusRecord(113, 0, $CustomersID, $result['msg']);
        }
        return $result;
    }

    //客户信息创建
    protected function CreateCus($crtdata, $agent_id, $CustomersModule, $returnID = false) {
        $crtdata ['AgentID'] = $agent_id;
        $crtdata ['AddTime'] = date('Y-m-d H:i:s', strtotime("-2 seconds", strtotime($crtdata ['UpdateTime'])));
        $email_ptn = "/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i";
        if (!preg_match($email_ptn, $crtdata['Email'])) {
            $result['err'] = 1003;
            $result['msg'] = '邮箱格式错误';
            return $result;
        }
        if ($CustomersModule->GetAllByWhere('where Email="' . $crtdata ['Email'] . '"')) {
            $result['err'] = 1004;
            $result['msg'] = '创建客户失败,已存在使用此邮箱的客户';
            $this->LogsFunction->LogsCusRecord(111, 2, 0, $result['msg']);
            return $result;
        }
        $cusID = $CustomersModule->InsertArray($crtdata, $returnID);
        if ($cusID) {
            $result['err'] = 0;
            $result['msg'] = $returnID ? $cusID : '创建客户成功';
        } else {
            $result['err'] = 1005;
            $result['msg'] = '创建客户失败';
            $this->LogsFunction->LogsCusRecord(111, 0, 0, $result['msg']);
        }
        return $result;
    }

    /* G宝盆开通和修改接口 */

    protected function ToGbaoPenEditInfo($CustomersProject = 0) {
        if (!$CustomersProject) {
            return 0;
        }
        if (is_array($CustomersProject)) {
            $CustProInfo = $CustomersProject;
        } else {
            $CustProModule = new CustProModule();
            $CustProInfo = $CustProModule->GetOneInfoByKeyID($CustomersProject);
        }
        if (empty($CustProInfo)) {
            return 0;
        }
        $CustomersModule = new CustomersModule ();
        $CustomersInfo = $CustomersModule->GetOneByWhere('where CustomersID=' . $CustProInfo ['CustomersID']);
        $CustProInfo = array_replace($CustProInfo, $CustomersInfo);

        $TuUrl = GBAOPEN_DOMAIN . 'api/modifyuser';
        $ToString .= 'name=' . $CustProInfo ['G_name'];

        if ($CustProInfo ['PC_model']) {
            preg_match('/[A-Z]{2}[0]*(\d*)/', $CustProInfo ['PC_model'], $have);
            $ToString .= '&pc_tpl_id=' . $have[1];
        } else
            $ToString .= '&pc_tpl_id=' . $CustProInfo ['PC_model'];

        if ($CustProInfo ['Mobile_model']) {
            preg_match('/[A-Z]{2}[0]*(\d*)/', $CustProInfo ['Mobile_model'], $have);
            $ToString .= '&mobile_tpl_id=' . $have[1];
        } else
            $ToString .= '&mobile_tpl_id=' . $CustProInfo ['Mobile_model'];

        $ToString .= '&stage=' . $CustProInfo ['CPhone'];
        $ToString .= '&pc_domain=' . $CustProInfo ['PC_domain'];
        $ToString .= '&mobile_domain=' . $CustProInfo ['Mobile_domain'];
        $ToString .= '&customization=' . $CustProInfo ['Customization'];
        $ToString .= '&email=' . $CustProInfo ['Email'];
        $ToString .= '&capacity=' . $CustProInfo ['Capacity'];
        $ToString .= '&ftp=' . $CustProInfo ['FTP'];
        $ToString .= '&ftp_address=' . $CustProInfo ['G_Ftp_Address'];
        $ToString .= '&ftp_user=' . $CustProInfo ['G_Ftp_User'];
        $ToString .= '&ftp_pwd=' . $CustProInfo ['G_Ftp_Pwd'];
        $ToString .= '&weburl=' . $CustProInfo['G_Ftp_FwAdress'];
        $ToString .= '&ftp_port=' . $CustProInfo['G_Ftp_Duankou'];
        $ToString .= '&ftp_dir=' . $CustProInfo['G_Ftp_Mulu'];
        $ToString .= '&pc_endtime=' . $CustProInfo ['PC_EndTime'];
        $ToString .= '&mobile_endtime=' . $CustProInfo ['Mobile_EndTime'];
        $ToString .= '&switch_cus_name=' . $CustProInfo ['Link_Cus'];
        $ToString .= '&status=' . $CustProInfo ['status'];
        if(isset($_POST["password"])&&!empty($_POST["password"])){
            $ToString .= '&password=' . $_POST["password"];
        }
        /*
          $myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
          fwrite($myfile, GBAOPEN_MD5KEY.'|');
          fwrite($myfile, strtotime($CustProInfo ['EndTime']).'|');
          fwrite($myfile, md5(GBAOPEN_MD5KEY . strtotime($CustProInfo ['EndTime'])));
          fclose($myfile);
         */
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

        $ToString .= '&timemap=' . $randomLock;
        $ToString .= '&taget=' . md5($text . $password);
        $ReturnString = request_by_other($TuUrl, $ToString);
        $ReturnArray = json_decode($ReturnString, true);
        return $ReturnArray;
    }

    //检查模板是否存在,存在则返回价格
    protected function GetModleIDByName($name, $ispackage = false) {
        if ($ispackage) {
            if (!$name) {
                return -1;
            }
            $model = new ModelPackageModule();
            $modelmsg = $model->GetOneByWhere(array('PhoneNum', 'PCNum', 'Youhui'), 'where PackagesNum="' . $name . '"');
            return $modelmsg;
        } else {
            if (!$name) {
                return -1;
            }
            $model = new ModelModule();
            $modelmsg = $model->GetOneByWhere(array('ID', 'Youhui'), 'where NO="' . $name . '"');
            if ($modelmsg)
                return $modelmsg;
            else
                return 0;
        }
    }

    //G宝盆客户列表--数据提供
    public function GetCus() {
        $result = array('err' => 0, 'data' => '', 'msg' => '');
        $type = $this->_GET['type'];
        $data['cus'] = $this->GetCusByType($type, floor($this->_GET['page']), floor($this->_GET['num']));
        $result['data'] = $data;
        return $result;
    }

    //G宝盆客户数量--数据提供
    public function GetCusNum() {
        $result = array('err' => 0, 'data' => '', 'msg' => '');
        $type = $this->_GET['type'];
        $result['data'] = $this->GetCusNumByType($type);
        return $result;
    }

    //根据类型获取想要的客户列表的数量
    protected function GetCusNumByType($type = 0) {
        $agent_id = $_SESSION ['AgentID'];
        $level = $_SESSION ['Level'];
        $DB = new DB;
        switch ($type) {
            case -1:
                $search_cuspro = $search_cus = '';
                if ($this->_GET['contact'] != '' || $this->_GET['name'] != '' || $this->_GET['domain'] != '') {
                    $search_cus .= $this->_GET['contact'] != '' ? '(CompanyName LIKE \'%' . $this->_GET['contact'] . '%\' or CustomersName LIKE \'%' . $this->_GET['contact'] . '%\')' : '';
                    $search_cuspro .= $this->_GET['name'] != '' ? 'G_name LIKE \'%' . $this->_GET['name'] . '%\'' : '';
                    $search_cuspro .= $search_cuspro ? $this->_GET['domain'] ? ' and ' : '' : '';
                    $search_cuspro .= $this->_GET['domain'] != '' ? '(PC_domain LIKE \'%' . $this->_GET['domain'] . '%\' or Mobile_domain LIKE \'%' . $this->_GET['domain'] . '%\')' : '';
                    //查询优化
                    $sel1 = $search_cus ? '(select AgentID,CustomersID,Status from tb_customers where ' . $search_cus . ')' : 'tb_customers';
                    //根据权限来获取客户信息量
                    if ($level == 1) {
                        if ($search_cuspro)
                            $select = 'select count(1) as Num from ' . $sel1 . ' as d inner join '
                                    . '(select CustomersID from tb_customers_project where ' . $search_cuspro . ') c on d.CustomersID = c.CustomersID ';
                        else
                            $select = 'select count(1) as Num from tb_customers where ' . $search_cus;
                        $data = $DB->Select($select);
                    }elseif ($level == 2) {
                        if ($search_cuspro)
                            $select = 'select count(1) as Num from (select a.CustomersID from '
                                    . '(select AgentID from tb_account where BossAgentID=' . $agent_id . ' or AgentID=' . $agent_id . ') as b inner join '
                                    . '' . $sel1 . ' a on a.AgentID = b.AgentID and a.Status>0) as d inner join '
                                    . '(select CustomersID from tb_customers_project where ' . $search_cuspro . ') c on d.CustomersID = c.CustomersID ';
                        else
                            $select = 'select count(1) as Num from tb_account b inner join '
                                    . '' . $sel1 . ' a on a.AgentID = b.AgentID and a.Status>0 and (b.BossAgentID=' . $agent_id . ' or b.AgentID=' . $agent_id . ')';
                        $data = $DB->Select($select);
                    }elseif ($level == 3) {
                        if ($search_cuspro) {
                            $search_cus = $search_cus ? ' and ' . $search_cus : '';
                            $select = 'select count(1) as Num from (select CustomersID from tb_customers where AgentID=' . $agent_id . $search_cus . ' and Status>0) as d inner join '
                                    . '(select CustomersID from tb_customers_project where ' . $search_cuspro . ') c on d.CustomersID = c.CustomersID';
                        } else
                            $select = 'select count(1) as Num from tb_customers where AgentID=' . $agent_id . ' and Status>0 and (' . $search_cus . ')';
                        $data = $DB->Select($select);
                    }else {
                        return false;
                    }
                } else
                    return false;
                break;
            case 0:
                //根据权限来获取客户信息量--所有
                if ($level == 1) {
                    $select = 'select count(1) as Num from tb_customers where Status>0 ';
                    $data = $DB->Select($select);
                } elseif ($level == 2) {
                    $select = 'select count(1) as Num from tb_account b inner join tb_customers a on a.AgentID = b.AgentID and a.Status>0 and (b.BossAgentID=' . $agent_id . ' or b.AgentID=' . $agent_id . ')';
                    $data = $DB->Select($select);
                } elseif ($level == 3) {
                    $select = 'select count(1) as Num from tb_customers a where AgentID=' . $agent_id.' and a.Status>0 ';
                    $data = $DB->Select($select);
                } else {
                    return false;
                }
                break;
            case 1:
                //根据权限来获取客户信息量--开通
                if ($level == 1) {
                    $select = 'select count(1) as Num from tb_customers a inner join tb_customers_project c on a.CustomersID = c.CustomersID and a.GOpen = 1 and a.Status>0 ';
                    $data = $DB->Select($select);
                } elseif ($level == 2) {
                    $select = 'select count(1) as Num from tb_customers a inner join tb_account b on a.AgentID = b.AgentID and (b.BossAgentID=' . $agent_id . ' or b.AgentID=' . $agent_id . ')' . ' inner join tb_customers_project c on a.CustomersID = c.CustomersID and a.GOpen = 1 and a.Status>0 ';
                    $data = $DB->Select($select);
                } elseif ($level == 3) {
                    $select = 'select count(1) as Num from tb_customers a inner join tb_customers_project c  on a.CustomersID = c.CustomersID and a.GOpen = 1 and a.Status>0  and a.AgentID=' . $agent_id;
                    $data = $DB->Select($select);
                } else {
                    return false;
                }
                break;
            case 2:
                //根据权限来获取客户信息量--未开通
                if ($level == 1) {
                    $select = 'select count(1) as Num from tb_customers where GOpen = 0';
                    $data = $DB->Select($select);
                } elseif ($level == 2) {
                    $select = 'select count(1) as Num from tb_account b inner join tb_customers a on a.AgentID = b.AgentID and (b.BossAgentID=' . $agent_id . ' or b.AgentID=' . $agent_id . ') and a.GOpen = 0';
                    $data = $DB->Select($select);
                } elseif ($level == 3) {
                    $select = 'select count(1) as Num from tb_customers where GOpen = 0 and AgentID=' . $agent_id;
                    $data = $DB->Select($select);
                } else {
                    return false;
                }
                break;
            case 3:
                $now = date("Y-m-d H:i:s", time());
                //根据权限来获取客户信息量--过期
                if ($level == 1) {
                    $select = 'select count(1) as Num from tb_customers_project c inner join tb_customers a on c.CustomersID=a.CustomersID and (c.PC_EndTime<"' . $now . '" or c.Mobile_EndTime<"' . $now . '") and a.GOpen = 1 and a.Status>0 ';
                    $data = $DB->Select($select);
                } elseif ($level == 2) {
                    $select = 'select count(1) as Num from tb_account b inner join tb_customers_project c on c.AgentID = b.AgentID inner join tb_customers a on c.CustomersID=a.CustomersID  and (b.BossAgentID=' . $agent_id . ' or b.AgentID=' . $agent_id . ') and (c.PC_EndTime<"' . $now . '" or c.Mobile_EndTime<"' . $now . '") and a.GOpen = 1 and a.Status>0 ';
                    $data = $DB->Select($select);
                } elseif ($level == 3) {
                    $select = 'select count(1) as Num from tb_customers_project c inner join tb_customers a on c.CustomersID=a.CustomersID  where (c.PC_EndTime<"' . $now . '" or c.Mobile_EndTime<"' . $now . '") and a.GOpen = 1 and a.Status>0  and c.AgentID=' . $agent_id;
                    $data = $DB->Select($select);
                } else {
                    return false;
                }
                break;
            case 4:
                $now = date("Y-m-d H:i:s", time());
                $after = date("Y-m-d H:i:s", strtotime("+30 day"));
                //根据权限来获取客户信息量--快过期
                if ($level == 1) {
                    $select = 'select count(1) as Num from tb_customers_project c inner join tb_customers a on c.CustomersID=a.CustomersID where ((c.PC_EndTime<"' . $after . '" and c.PC_EndTime>"' . $now . '") or (c.Mobile_EndTime<"' . $after . '" and c.Mobile_EndTime>"' . $now . '")) and a.GOpen = 1 and a.Status>0 ';
                    $data = $DB->Select($select);
                } elseif ($level == 2) {
                    $select = 'select count(1) as Num from tb_customers_project c inner join tb_account b on c.AgentID = b.AgentID inner join tb_customers a on c.CustomersID=a.CustomersID and (b.BossAgentID=' . $agent_id . ' or b.AgentID=' . $agent_id . ') and ((c.PC_EndTime<"' . $after . '" and c.PC_EndTime>"' . $now . '") or (c.Mobile_EndTime<"' . $after . '" and c.Mobile_EndTime>"' . $now . '")) and a.GOpen = 1 and a.Status>0 ';
                    $data = $DB->Select($select);
                } elseif ($level == 3) {
                    $select = 'select count(1) as Num from tb_customers_project c inner join tb_customers a on c.CustomersID=a.CustomersID where ((c.PC_EndTime<"' . $after . '" and c.PC_EndTime>"' . $now . '") or (c.Mobile_EndTime<"' . $after . '" and c.Mobile_EndTime>"' . $now . '")) and c.AgentID=' . $agent_id.' and a.GOpen = 1 and a.Status>0 ';
                    $data = $DB->Select($select);
                } else {
                    return false;
                }
                break;
                case 5:
                //根据权限来获取客户信息量--快过期
                if ($level == 1) {
                    $select = 'select count(1) as Num from tb_customers a where a.Status=0 ';
                    $data = $DB->Select($select);
                } else {
                    return false;
                }
                break;
            default:
                $data[0]['Num'] = false;
                break;
        }
        return $data[0]['Num'];
    }

    //根据类型获取想要的客户列表
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
        $order = ' order by d.CustomersID desc';
        $DB = new DB;
        switch ($type) {
            case -1:
                $search_cuspro = $search_cus = '';
                if ($this->_GET['contact'] != '' || $this->_GET['name'] != '' || $this->_GET['domain'] != '') {
                    $search_cus .= $this->_GET['contact'] != '' ? 'CompanyName LIKE \'%' . $this->_GET['contact'] . '%\' or CustomersName LIKE \'%' . $this->_GET['contact'] . '%\'' : '';
                    $search_cuspro .= $this->_GET['name'] != '' ? 'G_name LIKE \'%' . $this->_GET['name'] . '%\'' : '';
                    $search_cuspro .= $search_cuspro ? $this->_GET['domain'] ? ' and ' : '' : '';
                    $search_cuspro .= $this->_GET['domain'] != '' ? '(PC_domain LIKE \'%' . $this->_GET['domain'] . '%\' or Mobile_domain LIKE \'%' . $this->_GET['domain'] . '%\')' : '';
                    //查询优化
                    $sel1 = $search_cus ? '(select AgentID,CustomersID,CompanyName,CustomersName,Status from tb_customers where ' . $search_cus . ')' : 'tb_customers';
                    $sel2 = $search_cuspro ? 'inner join (select CustomersID,G_name,Cases,CPhone,PC_StartTime,PC_EndTime,Mobile_StartTime,Mobile_EndTime,AgentID from tb_customers_project where ' . $search_cuspro . ')' : 'left join tb_customers_project';
                    $search_cus = $search_cus ? ' and (' . $search_cus . ')' : '';
                    //根据权限来获取客户信息量
                    if ($level == 1) {
                        $select = 'select d.CustomersID,d.CompanyName,d.Status,d.UserName,c.G_name,c.Cases,c.CPhone,c.PC_StartTime,c.PC_EndTime,c.Mobile_StartTime,c.Mobile_EndTime,c.AgentID from '
                                . '(select a.CustomersID,a.CompanyName,a.CustomersName,b.UserName,a.Status from tb_account b inner join ' . $sel1 . ' a on a.AgentID = b.AgentID) as d '
                                . $sel2 . ' c on d.CustomersID = c.CustomersID ' . $limit;
                        $cus = $DB->Select($select);
                    } elseif ($level == 2) {
                        $select = 'select d.CustomersID,d.CompanyName,d.UserName,d.Status,c.G_name,c.Cases,c.CPhone,c.PC_StartTime,c.PC_EndTime,c.Mobile_StartTime,c.Mobile_EndTime,c.AgentID from '
                                . '(select a.CustomersID,a.CompanyName,a.CustomersName,b.UserName,a.Status from '
                                . '(select AgentID,UserName from tb_account where BossAgentID=' . $agent_id . ' or AgentID=' . $agent_id . ') as b inner join ' . $sel1 . ' a on a.AgentID = b.AgentID and a.Status>0) as d '
                                . $sel2 . ' c on d.CustomersID = c.CustomersID ' . $order . $limit;
                        $cus = $DB->Select($select);
                    } elseif ($level == 3) {
                        $select = 'select d.CustomersID,d.CompanyName,d.Status,c.G_name,c.Cases,c.CPhone,c.PC_StartTime,c.PC_EndTime,c.Mobile_StartTime,c.Mobile_EndTime,c.AgentID from '
                                . '(select CustomersID,CompanyName,Status from tb_customers where Status>0 and AgentID=' . $agent_id . $search_cus . ') as d '
                                . $sel2 . ' c on d.CustomersID = c.CustomersID' . $order . $limit;
                        $cus = $DB->Select($select);
                    } else {
                        return false;
                    }
                } else
                    return false;
                foreach ($cus as $key => $val) {
                    $data[$key]['type'] = $val['CPhone'] ? $val['CPhone'] : false;
                    $data[$key]['id'] = $val['CustomersID'];
                    $data[$key]['company'] = $val['CompanyName'];
                    $data[$key]['agent'] = $val['UserName'];
                    $data[$key]['Status'] = $val['Status'];
                    $data[$key]['name'] = $val['G_name'] ? $val['G_name'] : false;
                    $data[$key]['PCTimeStart'] = $val['PC_StartTime'] ? $val['PC_StartTime'] : false;
                    $data[$key]['PCTimeEnd'] = $val['PC_EndTime'] ? $val['PC_EndTime'] : false;
                    $data[$key]['MobileTimeStart'] = $val['Mobile_StartTime'] ? $val['Mobile_StartTime'] : false;
                    $data[$key]['MobileTimeEnd'] = $val['Mobile_EndTime'] ? $val['Mobile_EndTime'] : false;
                    $cases = explode('-', $val['Cases']);
                    $data[$key]['PlaceName'] = $cases[0] ? $cases[1] : '关闭';
                    $data[$key]['Place'] = $cases[0];
                    $data[$key]['agent_username'] = $usernames[$val["AgentID"]];
                }
                break;
            case 0:
                //根据权限来获取客户信息量
                if ($level == 1) {
                    $select = 'select d.CustomersID,d.CompanyName,d.UserName,d.Status,c.G_name,c.Cases,c.CPhone,c.PC_StartTime,c.PC_EndTime,c.Mobile_StartTime,c.Mobile_EndTime,c.AgentID from '
                            . '(select a.CustomersID,a.CompanyName,b.UserName,a.Status from tb_account b inner join tb_customers a on b.AgentID = a.AgentID and a.Status>0 ' . $limit . ') as d '
                            . 'left join tb_customers_project c on d.CustomersID = c.CustomersID';
                    $cus = $DB->Select($select);
                } elseif ($level == 2) {
                    $select = 'select d.CustomersID,d.CompanyName,d.Status,d.UserName,c.G_name,c.Cases,c.CPhone,c.PC_StartTime,c.PC_EndTime,c.Mobile_StartTime,c.Mobile_EndTime,c.AgentID from '
                            . '(select a.CustomersID,a.CompanyName,a.Status,b.UserName from tb_account b inner join tb_customers a on (b.BossAgentID=' . $agent_id . ' or b.AgentID=' . $agent_id . ') and b.AgentID = a.AgentID  and a.Status>0 ' . $limit . ') as d '
                            . 'left join tb_customers_project c on d.CustomersID = c.CustomersID' . $order;
                    $cus = $DB->Select($select);
                } elseif ($level == 3) {
                    $select = 'select d.CustomersID,d.CompanyName,d.Status,c.G_name,c.Cases,c.CPhone,c.PC_StartTime,c.PC_EndTime,c.Mobile_StartTime,c.Mobile_EndTime,c.AgentID from '
                            . '(select CustomersID,CompanyName,Status from tb_customers where AgentID=' . $agent_id.' and Status>0 ' . $limit . ') as d '
                            . 'left join tb_customers_project c on d.CustomersID = c.CustomersID' . $order;
                    $cus = $DB->Select($select);
                } else {
                    return false;
                }
                foreach ($cus as $key => $val) {
                    $data[$key]['type'] = $val['CPhone'] ? $val['CPhone'] : false;
                    $data[$key]['id'] = $val['CustomersID'];
                    $data[$key]['company'] = $val['CompanyName'];
                    $data[$key]['agent'] = $val['UserName'];
                    $data[$key]['name'] = $val['G_name'];
                    $data[$key]['Status'] = $val['Status'];
                    $data[$key]['PCTimeStart'] = $val['PC_StartTime'] ? $val['PC_StartTime'] : false;
                    $data[$key]['PCTimeEnd'] = $val['PC_EndTime'] ? $val['PC_EndTime'] : false;
                    $data[$key]['MobileTimeStart'] = $val['Mobile_StartTime'] ? $val['Mobile_StartTime'] : false;
                    $data[$key]['MobileTimeEnd'] = $val['Mobile_EndTime'] ? $val['Mobile_EndTime'] : false;
                    $cases = explode('-', $val['Cases']);
                    $data[$key]['PlaceName'] = $cases[0] ? $cases[1] : '关闭';
                    $data[$key]['Place'] = $cases[0];
                    $data[$key]['agent_username'] = $usernames[$val["AgentID"]];
                }
                break;
            case 1:
                //根据权限来获取客户信息量
                if ($level == 1) {
                    $select = 'select d.CustomersID,d.CompanyName,d.Status,d.UserName,c.G_name,c.Cases,c.CPhone,c.PC_StartTime,c.PC_EndTime,c.Mobile_StartTime,c.Mobile_EndTime,c.AgentID from '
                            . '(select a.CustomersID,a.CompanyName,a.Status,b.UserName from tb_account b inner join tb_customers a on b.AgentID = a.AgentID and a.GOpen = 1 and a.Status>0 ) as d '
                            . 'inner join tb_customers_project c on d.CustomersID = c.CustomersID' . $order . $limit;
                    $cus = $DB->Select($select);
                } elseif ($level == 2) {
                    $select = 'select d.CustomersID,d.CompanyName,d.Status,d.UserName,c.G_name,c.Cases,c.CPhone,c.PC_StartTime,c.PC_EndTime,c.Mobile_StartTime,c.Mobile_EndTime,c.AgentID from '
                            . '(select a.CustomersID,a.CompanyName,a.Status,b.UserName from tb_account b inner join tb_customers a on b.AgentID = a.AgentID and a.GOpen = 1 and a.Status>0  and (b.BossAgentID=' . $agent_id . ' or b.AgentID=' . $agent_id . ')' . ') as d '
                            . 'inner join tb_customers_project c on d.CustomersID = c.CustomersID' . $order . $limit;
                    $cus = $DB->Select($select);
                } elseif ($level == 3) {
                    $select = 'select d.CustomersID,d.CompanyName,d.Status,c.G_name,c.Cases,c.CPhone,c.PC_StartTime,c.PC_EndTime,c.Mobile_StartTime,c.Mobile_EndTime,c.AgentID from tb_customers d '
                            . 'inner join tb_customers_project c on d.CustomersID = c.CustomersID and d.GOpen = 1 and d.Status>0  and d.AgentID=' . $agent_id . $order . $limit;
                    $cus = $DB->Select($select);
                } else {
                    return false;
                }
                foreach ($cus as $key => $val) {
                    $data[$key]['type'] = $val['CPhone'] ? $val['CPhone'] : false;
                    $data[$key]['id'] = $val['CustomersID'];
                    $data[$key]['company'] = $val['CompanyName'];
                    $data[$key]['agent'] = $val['UserName'];
                    $data[$key]['name'] = $val['G_name'];
                    $data[$key]['Status'] = $val['Status'];
                    $data[$key]['PCTimeStart'] = $val['PC_StartTime'] ? $val['PC_StartTime'] : false;
                    $data[$key]['PCTimeEnd'] = $val['PC_EndTime'] ? $val['PC_EndTime'] : false;
                    $data[$key]['MobileTimeStart'] = $val['Mobile_StartTime'] ? $val['Mobile_StartTime'] : false;
                    $data[$key]['MobileTimeEnd'] = $val['Mobile_EndTime'] ? $val['Mobile_EndTime'] : false;
                    $cases = explode('-', $val['Cases']);
                    $data[$key]['PlaceName'] = $cases[0] ? $cases[1] : '关闭';
                    $data[$key]['Place'] = $cases[0];
                    $data[$key]['agent_username'] = $usernames[$val["AgentID"]];
                }
                break;
            case 2:
                //根据权限来获取客户信息量
                if ($level == 1) {
                    $select = 'select CustomersID,CompanyName,b.UserName,d.AgentID,d.Status from tb_account b inner join tb_customers d on b.AgentID = d.AgentID and d.GOpen = 0 and d.Status>0 ' . $order . $limit;
                    $cus = $DB->Select($select);
                } elseif ($level == 2) {
                    $select = 'select CustomersID,CompanyName,b.UserName,d.AgentID,d.Status from tb_account b inner join tb_customers d on b.AgentID = d.AgentID and d.GOpen = 0 and d.Status>0  and (b.BossAgentID=' . $agent_id . ' or b.AgentID=' . $agent_id . ')' . $order . $limit;
                    $cus = $DB->Select($select);
                } elseif ($level == 3) {
                    $select = 'select CustomersID,CompanyName,d.AgentID,d.Status from tb_customers d where d.GOpen = 0 and d.Status>0  and d.AgentID=' . $agent_id . $order . $limit;
                    $cus = $DB->Select($select);
                } else {
                    return false;
                }
                foreach ($cus as $key => $val) {
                    $data[$key]['type'] = $val['CPhone'] ? $val['CPhone'] : false;
                    $data[$key]['id'] = $val['CustomersID'];
                    $data[$key]['company'] = $val['CompanyName'];
                    $data[$key]['agent'] = $val['UserName'];
                    $data[$key]['name'] = $val['G_name'];
                    $data[$key]['Status'] = $val['Status'];
                    $data[$key]['PCTimeStart'] = false;
                    $data[$key]['PCTimeEnd'] = false;
                    $data[$key]['MobileTimeStart'] = false;
                    $data[$key]['MobileTimeEnd'] = false;
                    $data[$key]['agent_username'] = $usernames[$val["AgentID"]];
                }
                break;
            case 3:
                $now = date("Y-m-d H:i:s", time());
                //根据权限来获取客户信息量
                if ($level == 1) {
                    $select = 'select d.CustomersID,a.CompanyName,a.Status,d.UserName,d.G_name,d.Cases,d.CPhone,d.PC_StartTime,d.PC_EndTime,d.Mobile_StartTime,d.Mobile_EndTime,a.AgentID from '
                            . '(select b.UserName,c.CustomersID,c.G_name,c.Cases,c.CPhone,c.PC_StartTime,c.PC_EndTime,c.Mobile_StartTime,c.Mobile_EndTime from tb_account b inner join tb_customers_project c on c.AgentID = b.AgentID and (c.PC_EndTime<"' . $now . '" or c.Mobile_EndTime<"' . $now . '")) as d '
                            . 'inner join tb_customers a on d.CustomersID=a.CustomersID and a.GOpen = 1 and a.Status>0 ' . $order . $limit;
                    $cus = $DB->Select($select);
                } elseif ($level == 2) {
                    $select = 'select d.CustomersID,a.CompanyName,a.Status,d.UserName,d.G_name,d.Cases,d.CPhone,d.PC_StartTime,d.PC_EndTime,d.Mobile_StartTime,d.Mobile_EndTime,a.AgentID from '
                            . '(select c.CustomersID,b.UserName,c.G_name,c.Cases,c.CPhone,c.PC_StartTime,c.PC_EndTime,c.Mobile_StartTime,c.Mobile_EndTime from tb_account b inner join tb_customers_project c on c.AgentID = b.AgentID and (b.BossAgentID=' . $agent_id . ' or b.AgentID=' . $agent_id . ') and (c.PC_EndTime<"' . $now . '" or c.Mobile_EndTime<"' . $now . '")) d '
                            . 'inner join tb_customers a on a.CustomersID=d.CustomersID and a.Status>0 ' . $order . $limit;
                    $cus = $DB->Select($select);
                } elseif ($level == 3) {
                    $select = 'select d.CustomersID,d.CompanyName,d.Status,c.G_name,c.Cases,c.CPhone,c.PC_StartTime,c.PC_EndTime,c.Mobile_StartTime,c.Mobile_EndTime,c.AgentID from '
                            . 'tb_customers_project c inner join tb_customers d on c.CustomersID=d.CustomersID and d.Status>0  and c.AgentID = ' . $agent_id . ' and (c.PC_EndTime<"' . $now . '" or c.Mobile_EndTime<"' . $now . '")' . $order . $limit;
                    $cus = $DB->Select($select);
                } else {
                    return false;
                }
                foreach ($cus as $key => $val) {
                    $data[$key]['type'] = $val['CPhone'] ? $val['CPhone'] : false;
                    $data[$key]['id'] = $val['CustomersID'];
                    $data[$key]['company'] = $val['CompanyName'];
                    $data[$key]['agent'] = $val['UserName'];
                    $data[$key]['name'] = $val['G_name'];
                    $data[$key]['Status'] = $val['Status'];
                    $data[$key]['PCTimeStart'] = $val['PC_StartTime'] ? $val['PC_StartTime'] : false;
                    $data[$key]['PCTimeEnd'] = $val['PC_EndTime'] ? $val['PC_EndTime'] : false;
                    $data[$key]['MobileTimeStart'] = $val['Mobile_StartTime'] ? $val['Mobile_StartTime'] : false;
                    $data[$key]['MobileTimeEnd'] = $val['Mobile_EndTime'] ? $val['Mobile_EndTime'] : false;
                    $cases = explode('-', $val['Cases']);
                    $data[$key]['PlaceName'] = $cases[0] ? $cases[1] : '关闭';
                    $data[$key]['Place'] = $cases[0];
                    $data[$key]['agent_username'] = $usernames[$val["AgentID"]];
                }
                break;
            case 4:
                $now = date("Y-m-d H:i:s", time());
                $after = date("Y-m-d H:i:s", strtotime("+30 day"));
                //根据权限来获取客户信息量
                if ($level == 1) {
                    $select = 'select d.CustomersID,d.CompanyName,d.Status,d.UserName,c.G_name,c.Cases,c.CPhone,c.PC_StartTime,c.PC_EndTime,c.Mobile_StartTime,c.Mobile_EndTime,c.AgentID from tb_customers_project c '
                            . 'inner join (select a.CustomersID,a.CompanyName,a.Status,b.UserName from tb_account b inner join tb_customers a on a.AgentID = b.AgentID and a.GOpen = 1 and a.Status>0 ) d '
                            . 'on c.CustomersID=d.CustomersID and ((c.PC_EndTime<"' . $after . '" and c.PC_EndTime>"' . $now . '") or (c.Mobile_EndTime<"' . $after . '" and c.Mobile_EndTime>"' . $now . '"))' . $order . $limit;
                    $cus = $DB->Select($select);
                } elseif ($level == 2) {
                    $select = 'select d.CustomersID,d.CompanyName,d.Status,d.UserName,c.G_name,c.Cases,c.CPhone,c.PC_StartTime,c.PC_EndTime,c.Mobile_StartTime,c.Mobile_EndTime,c.AgentID from tb_customers_project c '
                            . 'inner join (select a.CustomersID,a.CompanyName,a.Status,b.UserName from tb_account b inner join tb_customers a on a.AgentID = b.AgentID and a.GOpen = 1 and a.Status>0  and (b.BossAgentID=' . $agent_id . ' or b.AgentID=' . $agent_id . ')) d '
                            . 'on c.CustomersID=d.CustomersID and ((c.PC_EndTime<"' . $after . '" and c.PC_EndTime>"' . $now . '") or (c.Mobile_EndTime<"' . $after . '" and c.Mobile_EndTime>"' . $now . '"))' . $order . $limit;
                    $cus = $DB->Select($select);
                } elseif ($level == 3) {
                    $select = 'select d.CustomersID,d.CompanyName,d.Status,c.G_name,c.Cases,c.CPhone,c.PC_StartTime,c.PC_EndTime,c.Mobile_StartTime,c.Mobile_EndTime,c.AgentID from tb_customers_project c inner join tb_customers d on c.CustomersID=d.CustomersID and d.Status>0  and ((c.PC_EndTime<"' . $after . '" and c.PC_EndTime>"' . $now . '") or (c.Mobile_EndTime<"' . $after . '" and c.Mobile_EndTime>"' . $now . '")) and c.AgentID=' . $agent_id . $order . $limit;
                    $cus = $DB->Select($select);
                } else {
                    return false;
                }
                foreach ($cus as $key => $val) {

                    $data[$key]['type'] = $val['CPhone'] ? $val['CPhone'] : false;
                    $data[$key]['id'] = $val['CustomersID'];
                    $data[$key]['company'] = $val['CompanyName'];
                    $data[$key]['agent'] = $val['UserName'];
                    $data[$key]['name'] = $val['G_name'];
                    $data[$key]['Status'] = $val['Status'];
                    $data[$key]['PCTimeStart'] = $val['PC_StartTime'] ? $val['PC_StartTime'] : false;
                    $data[$key]['PCTimeEnd'] = $val['PC_EndTime'] ? $val['PC_EndTime'] : false;
                    $data[$key]['MobileTimeStart'] = $val['Mobile_StartTime'] ? $val['Mobile_StartTime'] : false;
                    $data[$key]['MobileTimeEnd'] = $val['Mobile_EndTime'] ? $val['Mobile_EndTime'] : false;
                    $cases = explode('-', $val['Cases']);
                    $data[$key]['PlaceName'] = $cases[0] ? $cases[1] : '关闭';
                    $data[$key]['Place'] = $cases[0];
                    $data[$key]['agent_username'] = $usernames[$val["AgentID"]];
                }
                break;
            case 5:
                //根据权限来获取客户信息量
                if ($level == 1) {
                    $select = 'select d.CustomersID,d.CompanyName,d.Status,d.UserName,c.G_name,c.Cases,c.CPhone,c.PC_StartTime,c.PC_EndTime,c.Mobile_StartTime,c.Mobile_EndTime,c.AgentID from '
                            . '(select a.CustomersID,a.CompanyName,a.Status,b.UserName from tb_account b inner join tb_customers a on b.AgentID = a.AgentID and a.Status=0 ) as d '
                            . 'inner join tb_customers_project c on d.CustomersID = c.CustomersID' . $order . $limit;
                    $cus = $DB->Select($select);
                } else {
                    return false;
                }
                foreach ($cus as $key => $val) {
                    $data[$key]['type'] = $val['CPhone'] ? $val['CPhone'] : false;
                    $data[$key]['id'] = $val['CustomersID'];
                    $data[$key]['company'] = $val['CompanyName'];
                    $data[$key]['agent'] = $val['UserName'];
                    $data[$key]['name'] = $val['G_name'];
                    $data[$key]['Status'] = $val['Status'];
                    $data[$key]['PCTimeStart'] = $val['PC_StartTime'] ? $val['PC_StartTime'] : false;
                    $data[$key]['PCTimeEnd'] = $val['PC_EndTime'] ? $val['PC_EndTime'] : false;
                    $data[$key]['MobileTimeStart'] = $val['Mobile_StartTime'] ? $val['Mobile_StartTime'] : false;
                    $data[$key]['MobileTimeEnd'] = $val['Mobile_EndTime'] ? $val['Mobile_EndTime'] : false;
                    $cases = explode('-', $val['Cases']);
                    $data[$key]['PlaceName'] = $cases[0] ? $cases[1] : '关闭';
                    $data[$key]['Place'] = $cases[0];
                    $data[$key]['agent_username'] = $usernames[$val["AgentID"]];
                }
                break;
            default:
                $data = false;
                break;
        }
        return $data;
    }

    //更改客户状态---(未启用，需要重新编写设计)
    public function ChangeStatus() {
        $CustProModule = new CustProModule();
        $CustomersID = $this->_GET['ID'];
        $Status = intval($this->_GET['Status']);

        $UpdateArray['status'] = ($Status == 1) ? 0 : 1;
        $filter['CustomersID'] = intval($this->_GET ['ID']);
        $filter['AgentID'] = intval($_SESSION['AgentID']);
        $filter['status'] = $Status;
        if ($CustProModule->UpdateArray($UpdateArray, $filter)) {
            $filter['status'] = ($Status == 1) ? 0 : 1;
            $CustProInfo = $CustProModule->GetOneInfoByArrayKeys($filter);
            $this->ToGbaoPenEditInfo($CustProInfo['CustomersProjectID']);
            if ($Status) {
                $this->LogsFunction->LogsCusRecord(116, 1, $CustomersID, $result['msg']);
            } else {
                $this->LogsFunction->LogsCusRecord(117, 1, $CustomersID, $result['msg']);
            }
        }
        exit;
    }

    /* 权限判定函数，
     * 一个参数获取当前拥有的权限，
     * 两个参数判断是否拥有这个权限
     */

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

    public function test() {
        $a = array('sdafsdfsdf');
        echo implode('and', $a);
        exit;
    }
    
    /**
     * 计算费用
     */
    public function getcost($data=array()){
        if(count($data)>0){
            $post=$data;
        }else{
            $post=$this->_POST;
        }
        $price=0;
        if($post["Experience"]==1){
            $price=0;
            $result["price"]=$price;
            return $result;
        }else{
            $package=new ModelPackageModule();
            $model=new ModelModule();
            switch ($post['CPhone']) {
                case 4:
                    $price = $package->GetOneByWhere(array('Youhui', 'PCNum', 'PhoneNum'), 'where PackagesNum=\'' . $post['PK_model'] . '\'');
                    if ($price) {
                        $pk_exist = true;
                    } else {
                        $pk_exist = false;
                    }
                    break;
                case 3:
                    $pc_price = $model->GetOneByWhere(array('Youhui'), 'where NO=\'' . $post['PC_model'] . '\'');
                    $mobile_price = $model->GetOneByWhere(array('Youhui'), 'where NO=\'' . $post['Mobile_model'] . '\'');
                    break;
                case 2:
                    $mobile_price = $model->GetOneByWhere(array('Youhui'), 'where NO=\'' . $post['Mobile_model'] . '\'');
                    break;
                case 1:
                    $pc_price = $model->GetOneByWhere(array('Youhui'), 'where NO=\'' . $post['PC_model'] . '\'');
                    break;
                default:
                    $result['err'] = 1002;
                    $result['msg'] = '请联系程序猿协助';
                    return $result;
                    break;
            }
            switch ($post['CPhone']) {
                case 4:
                    if ($pk_exist) {
                        $price = $price['Youhui'];
                    } else {
                        $result['err'] = 1003;
                        $result['msg'] = '套餐--非法请求，不存在';
                        return $result;
                    }
                    break;
                case 3:
                    if ($pc_price && $mobile_price) {
                        $price = $pc_price['Youhui'] + $mobile_price['Youhui'];
                    } else {
                        $result['err'] = 1003;
                        $result['msg'] = '双站--非法请求，不存在';
                        return $result;
                    }
                    break;
                case 2:
                    if ($mobile_price) {
                        $price = $mobile_price['Youhui'];
                    } else {
                        $result['err'] = 1003;
                        $result['msg'] = '手机--非法请求，不存在';
                        return $result;
                    }
                    break;
                case 1:
                    if ($pc_price) {
                        $price = $pc_price['Youhui'];
                    } else {
                        $result['err'] = 1003;
                        $result['msg'] = 'PC--非法请求，不存在';
                        return $result;
                    }
                    break;
                default :
                    $result['err'] = 1003;
                    $result['msg'] = '非法请求，不存在';
                    return $result;
                    break;
            }
            $result["model_price"]=$price;
//            if ($post["Capacity"] == 300) {
//                $price+=500;
//                $result["capacity_price"]=500;
//            } elseif($post["Capacity"] == 500){
//                $price+=800;
//                $result["capacity_price"]=800;
//            }elseif($post["Capacity"] == 1000){
//                $price+=1500;
//                $result["capacity_price"]=1500;
//            }elseif($post["Capacity"] == 100){
//                $price+=300;
//            }else{
//                $result['err'] = 1003;
//                $result['msg'] = '容量空间选择错误';
//                return $result;
//            }
            $coupons=$post["coupons"];
            $couprice=0;
            if ($coupons) {
                $couponsprice = file_get_contents(DAILI_DOMAIN . '?module=ApiModel&action=GetCoupons&code=' . $coupons);
                if ($couponsprice > 0) {
                    $couprice=$couponsprice;
                }
            }
            $result["price"]=$price*$post["stilltime"]-$couprice;
            return $result;
        }
    }
    public function SiteMove(){
        set_time_limit(0);
        $result = array('err' => 0, 'data' => '', 'msg' => '');
        $post=$this->_POST;
        $CustmoersID=$post["num"];
        $level=$_SESSION["Level"];
        $agent_id=$_SESSION["AgentID"];
        $customer=new CustomersModule();
        $customerInfo=$customer->GetOneInfoByKeyID($CustmoersID);
        if($level!=1){
            if($level==2){
                $account=new AccountModule();
                $account_lists=$account->GetListsByWhere(array("AgentID","BossAgentID"), " where BossAgentID=".$agent_id);
                $childAgentIDs=array();
                foreach($account_lists as $v){
                    $childAgentIDs[]=$v["AgentID"];
                }
                $childAgentIDs[]=$agent_id;
                if(!in_array($customerInfo["AgentID"], $childAgentIDs)){
                    $result['err'] = 1003;
                    $result['msg'] = '没有该用户';
                    return $result;
                }
            }else if($level==3){
                if($customerInfo["AgentID"]!= $agent_id){
                    $result['err'] = 1003;
                    $result['msg'] = '没有该用户';
                    return $result;
                }
            }
        }
        $info=array();
        if($post["FTP"]==0){
            $info["FuwuqiID"]="";
            $info["G_Ftp_Address"]=$post["address"];
            $info["G_Ftp_User"]=$post["user"];
            $info["G_Ftp_Pwd"]=$post["pwd"];
            $info["G_Ftp_FwAdress"]=$post["ftp_url"];
            $info["G_Ftp_Duankou"]=$post["port"];
            $info["G_Ftp_Mulu"]=$post["dir"];
            $info["FTP"]=2;
        }else{
            $info["FuwuqiID"]=$post["FuwuqiID"];
            $fuwuqi=new FuwuqiModule();
            $fuwuqi_info=$fuwuqi->GetOneInfoByKeyID($info["FuwuqiID"]);
            if($fuwuqi_info){
                $info["G_Ftp_Address"]=$fuwuqi_info["FTP"];
                $info["G_Ftp_User"]=$fuwuqi_info["FTPName"];
                $info["G_Ftp_Pwd"]=$fuwuqi_info["FTPPassword"];
                $info["G_Ftp_FwAdress"]=$fuwuqi_info["FwAdress"];
                $info["G_Ftp_Duankou"]=$fuwuqi_info["FTPDuankou"];
                $info["G_Ftp_Mulu"]=$fuwuqi_info["FTPMulu"];
                $info["FTP"]=1;
            }else{
                $result['err'] = 1003;
                $result['msg'] = '未找到该服务器';
                $this->LogsFunction->LogsCusRecord(121, 3, $CustmoersID, $result['msg']);
                return $result;
            }
        }
        $custpro=new CustProModule();
        $cuspro_old=$cuspro_info=$custpro->GetOneByWhere(array(), " where CustomersID=".$CustmoersID);
        if(strpos($cuspro_old["Mobile_domain"], '.5067.org')!==false){
            $info["Mobile_domain"]=  preg_replace("/^http:\/\/c/", 'http://m.'.$cuspro_info["G_name"], $info ['G_Ftp_FwAdress']);
        }
        if(strpos($cuspro_old["PC_domain"], '.5067.org')!==false){
            $info["PC_domain"]=  preg_replace("/^http:\/\/c/", 'http://'.$cuspro_info["G_name"], $info ['G_Ftp_FwAdress']);
        }
        if($custpro->UpdateArray($info,$CustmoersID)){
            $cuspro_info=$custpro->GetOneByWhere(array(), " where CustomersID=".$CustmoersID);
            $TuUrl = GBAOPEN_DOMAIN . 'api/webremove';
            $ToString .= 'username=' . $cuspro_info["G_name"];
            $ToString .= '&ftp_address=' . $info ['G_Ftp_Address'];
            $ToString .= '&ftp_port=' . $info ['G_Ftp_Duankou'];
            $ToString .= '&ftp_user=' . $info ['G_Ftp_User'];
            $ToString .= '&ftp_pwd=' . $info ['G_Ftp_Pwd'];
            $ToString .= '&ftp_dir=' . $info ['G_Ftp_Mulu'];
            $ToString .= '&ftp_flag=' . ($info ['FuwuqiID']>0?"1":"0");
            $ToString .= '&ftp_url=' . ($info ['FuwuqiID']>0?  preg_replace("/^http:\/\/c/", "http://".$cuspro_info["G_name"], $info ['G_Ftp_FwAdress']):$info ['G_Ftp_FwAdress']);
            //随机文件名开始生成
            $randomLock = getstr();
            $password = md5($randomLock);
            $password = md5($password);

            //生成握手密钥
            $text = getstr();

            //生成dll文件
            $myfile = @fopen('./token/' . $password . '.dll', "w+");
            if (!$myfile) {
                $custpro->UpdateArray($cuspro_old,$CustmoersID);
                $result['err'] = 1003;
                $result['msg'] = '网站迁移失败';
                $this->LogsFunction->LogsCusRecord(121, 0, $CustmoersID, $result['msg']);
                return $result;
            }
            fwrite($myfile, $text);
            fclose($myfile);
            $ToString .= '&timemap=' . $randomLock;
            $ToString .= '&taget=' . md5($text . $password);
            $ReturnString = request_by_other($TuUrl, $ToString);
            $ReturnArray = json_decode($ReturnString, true);
            $IsOk = $this->ToGbaoPenEditInfo($cuspro_info);
            if ($IsOk['err'] != 1000) {
                $result['err'] = 1002;
                $result['msg'] = '数据同步失败，请重试';
                $this->LogsFunction->LogsCusRecord(121, 6, $CustmoersID, $result['msg']);
                $result['data'] = $IsOk;
                return $result;
            }
            $result['msg'] = '网站迁移成功';
            $result['data']['name'] = $customerInfo['CompanyName'];
            $this->LogsFunction->LogsCusRecord(121, 1, $CustmoersID, $result['msg']);
            return $result;
        }else{
            $result['err'] = 1003;
            $result['msg'] = '网站迁移失败';
            $this->LogsFunction->LogsCusRecord(121, 0, $CustmoersID, $result['msg']);
            return $result;
        }
    }
    /**
     * 获取服务器列表
     */
    public function getFuwuqi() {
        $fuwuqi=new FuwuqiModule();
        $fuwuqiinfo = $fuwuqi->GetListsByWhere(array('ID','FuwuqiName','CName'),' order by ID asc');
        return json_encode($fuwuqiinfo);
    }
    /**
     * 获取扩容计费信息
     */
    public function getCusCapacityInfo(){
        $post=  $this->_POST;
        $cuspro=new CustProModule();
        $cuspro_info=$cuspro->GetOneByWhere(array(), " where CustomersID=".$post["num"]);
        if($cuspro_info){
            $l_time=($cuspro_info["PC_EndTime"]>$cuspro_info["Mobile_EndTime"]?$cuspro_info["PC_EndTime"]:$cuspro_info["Mobile_EndTime"]);
            $s_time=($cuspro_info["PC_StartTime"]<$cuspro_info["Mobile_StartTime"]?$cuspro_info["PC_StartTime"]:$cuspro_info["Mobile_StartTime"]);
            $now_time=date("Y-m-d H:i:s",time());
            $now=time();
            if($now_time<$s_time){
                $now_time=$s_time;
                $now=strtotime($s_time);
            }
            if($l_time>$now_time){
                $months=ceil((strtotime($l_time)-$now)/60/60/24/30);
                return array("err"=>0,"months"=>$months,"capacity"=>$cuspro_info["Capacity"]);
            }else{
                return array("err"=>0,"months"=>0,"capacity"=>$cuspro_info["Capacity"]);
            }
        }else{
            return array("err"=>1001,"msg"=>"为找到该用户或该用户未开通");
        }
    }
    /**
     * 扩容
     */
    public function morecapacity() {
        $result = array('err' => 0, 'data' => '', 'msg' => '');
        $post=  $this->_POST;
        $cus_id=$post["num"];
        $morecapacity=$post["morecapacity"]*1024*1024;
        $agent_id = (int) $_SESSION ['AgentID'];
        $level = (int) $_SESSION ['Level'];
        $cuspro=new CustProModule();
        $cuspro_info=$cuspro->GetOneByWhere(array(), " where CustomersID=".$cus_id);
        if($cuspro_info){
            $l_time=($cuspro_info["PC_EndTime"]>$cuspro_info["Mobile_EndTime"]?$cuspro_info["PC_EndTime"]:$cuspro_info["Mobile_EndTime"]);
            $s_time=($cuspro_info["PC_StartTime"]<$cuspro_info["Mobile_StartTime"]?$cuspro_info["PC_StartTime"]:$cuspro_info["Mobile_StartTime"]);
            $now_time=date("Y-m-d H:i:s",time());
            $now=time();
            if($now_time<$s_time){
                $now_time=$s_time;
                $now=strtotime($s_time);
            }
            if($l_time>$now_time){
                $months=ceil((strtotime($l_time)-$now)/60/60/24/30);
            }else{
                $months=0;
            }
            if($cuspro_info["Capacity"]<=$morecapacity){
                switch ($cuspro_info["Capacity"]){
                    case 100*1024*1024:$old_price=300;break;
                    case 300*1024*1024:$old_price=500;break;
                    case 500*1024*1024:$old_price=800;break;
                    case 1000*1024*1024:$old_price=1500;break;
                    default :$old_price=0;break;
                }

                switch ($morecapacity){
                    case 100*1024*1024:$new_price=300;break;
                    case 300*1024*1024:$new_price=500;break;
                    case 500*1024*1024:$new_price=800;break;
                    case 1000*1024*1024:$new_price=1500;break;
                    default :
                        $result['err']=1003;
                        $result['msg']='非法请求';
                        return $result;
                }
                $price=number_format(($new_price-$old_price)*$months/12,0);
                $balance=new BalanceModule();
                $agent=new AccountModule();
                $agentinfo = $agent->GetOneInfoByKeyID($cuspro_info["AgentID"]);
                if ($agentinfo["Level"] == 3) {
                    $costID = $agentinfo['BossAgentID'];
                    $agent_bal = $balance->GetOneInfoByAgentID($agent_id);
                    $boss_agent_bal = $balance->GetOneInfoByAgentID($costID);
                    unset($agent_bal['ID']);
                    unset($boss_agent_bal['ID']);
                } elseif ($agentinfo["Level"] == 2 or $agentinfo["Level"] == 1) {
                    $costID = $agentinfo["AgentID"];
                    $boss_agent_bal = $balance->GetOneInfoByAgentID($agentinfo["AgentID"]);
                    unset($boss_agent_bal['ID']);
                } else {
                    $result['err'] = 1004;
                    $result['msg'] = '此用户资料不存在';
                    $this->LogsFunction->LogsCusRecord(122, 2, $cus_id, $result['msg']);
                    return $result;
                }
                if ($agentinfo['Level'] == 3) {
                    if ($boss_agent_bal['Balance'] < $price) {
                        $result['err'] = 1003;
                        $result['msg'] = '您的余额不足，请及时充值';
                        $this->LogsFunction->LogsCusRecord(122, 4, $cus_id, $result['msg']);
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
                    $update_boss['CostAll'] = $update_boss['CostAll'] + $price;
                    //客服消费计算
                    $updatetime = explode('-', $agent_bal['UpdateTime']);
                    $update_self['CostMon'] = $agent_bal['CostMon'];
                    if (date('m', time()) != $updatetime[1]) {
                        $update_self['UpdateTime'] = date('Y-m-d', time());
                        $update_self['CostMon'] = 0;
                    }
                    $update_self['CostMon'] = $update_self['CostMon'] + $price;
                    $update_self['CostAll'] = $update_self['CostAll'] + $price;
                    $balance_money=$update_boss['Balance'];
                } else {
                    if ($boss_agent_bal['Balance'] < $price) {
                        $result['err'] = 1003;
                        $result['msg'] = '您的余额不足，请及时充值';
                        $this->LogsFunction->LogsCusRecord(122, 4, $cus_id, $result['msg']);
                        return $result;
                    }
                    $updatetime = explode('-', $boss_agent_bal['UpdateTime']);
                    $update_self['CostMon'] = $boss_agent_bal['CostMon'];
                    if (date('m', time()) != $updatetime[1]) {
                        $update_self['UpdateTime'] = date('Y-m-d', time());
                        $update_self['CostMon'] = 0;
                    }
                    $update_self['Balance'] = $boss_agent_bal['Balance'] - $price;
                    $update_self['CostMon'] = $update_self['CostMon'] + $price;
                    $update_self['CostAll'] = $update_self['CostAll'] + $price;
                    $balance_money=$update_self['Balance'];
                }
                
                $IsOk = $this->ToGbaoPenEditInfo(array_replace($cuspro_info, array("Capacity"=>$morecapacity)));
                if ($IsOk['err'] != 1000) {
                    $result['err'] = 1002;
                    $result['msg'] = '数据同步失败，请重试';
                    $this->LogsFunction->LogsCusRecord(122, 6, $cus_id, $result['msg']);
                    $result['data'] = $IsOk;
                    return $result;
                }
                if (!$balance->UpdateArrayByAgentID($update_self, $costID)) {
                    $this->ToGbaoPenEditInfo($cuspro_info);
                    $result['err'] = 1004;
                    $result['msg'] = '扩容失败，请重试，若依然无效，酌情联系管理员1';
                    $this->LogsFunction->LogsCusRecord(122, 0, $cus_id, $result['msg']);
                    return $result;
                }
                if ($agentinfo['Level'] == 3) {
                    if (!$balance->UpdateArrayByAgentID($update_boss, $agentinfo['BossAgentID'])) {
                        $this->ToGbaoPenEditInfo($cuspro_info);
                        $balance->UpdateArrayByAgentID($agent_bal, $costID);
                        $result['err'] = 1004;
                        $result['msg'] = '扩容失败，请重试，若依然无效，酌情联系管理员2';
                        $this->LogsFunction->LogsCusRecord(122, 0, $cus_id, $result['msg']);
                        return $result;
                    }
                }
                if (!$cuspro->UpdateArray(array("Capacity"=>$morecapacity), $cus_id)) {
                    $this->ToGbaoPenEditInfo($cuspro_info);
                    $balance->UpdateArrayByAgentID($agent_bal, $costID);
                    $agentinfo['Level'] == 3 ? $balance->UpdateArrayByAgentID($boss_agent_bal, $costID) : '';
                    $result['err'] = 1004;
                    $result['msg'] = '扩容失败，请重试，若依然无效，酌情联系管理员3';
                    $this->LogsFunction->LogsCusRecord(122, 0, $cus_id, $result['msg']);
                    return $result;
                }
                $logcost_data = array("ip" => $_SERVER["REMOTE_ADDR"], "cost" => (0-$price), "type" => 4, "description" => "网站扩容", "adddate" => date('Y-m-d H:i:s', time()), "CustomersID" => $cus_id,"AgentID"=>$agent_id,"CostID"=>$costID,"Balance"=>$balance_money,"OrderID"=>'');
                $logcost = new LogcostModule();
                $logcost->InsertArray($logcost_data);
                $this->LogsFunction->LogsCusRecord(122, 5, $cus_id, '扩容同步成功');
                $cusmodel=new CustomersModule();
                $cus = $cusmodel->GetOneByWhere(array('CompanyName'), 'where CustomersID=' . $cus_id);
                $result['data']['name'] = $cus['CompanyName'];
            }else{
                $result['err']=1002;
                $result['msg']='非法请求';
            }
        }else{
            $result['err']=1001;
            $result['msg']='为找到该用户或该用户未开通';
        }
        return $result;
    }
    /**
     *获取微传单是否开启情况
     */
    public function getGshow(){
        $result = array('err' => 0, 'data' => '', 'msg' => '');
        $post=$this->_POST;
        $gshow=new GshowModule();
        $gshowinfo=$gshow->GetOneByWhere(array(), " where CustomersID = ".$post["num"]);
        $result["data"]=$gshowinfo;
        return $result;
    }
    /**
     *设置开启微传单
     */
    public function Gshow(){
        $result = array('err' => 0, 'data' => '', 'msg' => '');
        $post=$this->_POST;
        $cus_id=$post["num"];
        $gshow=new GshowModule();
        $gshowinfo=$gshow->GetOneByWhere(array(), " where CustomersID = ".$post["num"]);
        if($gshowinfo){
            $madify_info=$gshowinfo;
            $nowtime=strtotime($gshowinfo["EndTime"])>time()?strtotime($gshowinfo["EndTime"]):time();
            $madify_info["EndTime"]=(date('Y', $nowtime) + $post["year"]) . '-' . date('m-d H:i:s',$nowtime);
            $madify_info["UpdateTime"]=date('Y-m-d H:i:s',time());
            $ret=$gshow->UpdateArray($madify_info, array("CustomersID"=>$post["num"]));
            if($ret){
                $ret=$this->toGshow($madify_info);
                if($ret["code"]!=200){
                    $gshow->UpdateArray($gshowinfo, array("CustomersID"=>$post["num"]));
                    $result["err"]=1;
                    $result["msg"]="微传单同步数据失败";
                }else{
                    $result["msg"]="微传单操作成功";
                }
            }else{
                $result["err"]=2;
                $result["msg"]="微传单数据更新失败";
            }
        }else{
            $cust=new CustomersModule();
            $cust_info=$cust->GetOneByWhere(array(), " where CustomersID = ".$post["num"]);
            $ins_info=array();
            $ins_info["EndTime"]=(date('Y', time()) + $post["year"]) . '-' . date('m-d H:i:s', time());
            $ins_info["UpdateTime"]=date('Y-m-d H:i:s',time());
            $ins_info["StartTime"]=date('Y-m-d H:i:s',time());
            $ins_info["Email"]=$cust_info["Email"];
            $ins_info["CustomersID"]=$post["num"];
            $ret=$gshow->InsertArray($ins_info);
            if($ret){
                $ret=$this->toGshow($ins_info);
                if($ret["code"]!=200){
                    $gshow->DeleteInfo(' where CustomersID='.$post["num"]);
                    $result["err"]=1;
                    $result["msg"]="微传单同步数据失败";
                    $this->LogsFunction->LogsCusRecord(123, 6, $cus_id, $result['msg']);
                }else{
                    $result["msg"]="微传单操作成功";
                    $this->LogsFunction->LogsCusRecord(123, 1, $cus_id, $result['msg']);
                }
            }else{
                $result["err"]=2;
                $result["msg"]="微传单数据更新失败";
                $this->LogsFunction->LogsCusRecord(123, 0, $cus_id, $result['msg']);
            }
        }
        return $result;
    }
    private function toGshow($data){
        if (!$data) {
            return 0;
        }
        $cust=new CustomersModule();
        $cust_info=$cust->GetOneByWhere(array(), " where CustomersID = ".$data["CustomersID"]);
        if (!$cust_info) {
            return 0;
        }
        $TuUrl = 'http://cd.5067.org/index.php?c=user&a=dlregister';
        $ToString .= 'uname=' . $cust_info ['CompanyName'];

        $ToString .= '&email_varchar=' . $data ['Email'];
        $ToString .= '&tel=' . $cust_info ['Tel'];
        $ToString .= '&allow_nums=10';
        $ToString .= '&end_time=' . $data ['EndTime'];
        $ToString .= '&type=1';
        $ToString .= '&level_int=0';
        $ToString .= '&status_int=1';
        $ToString .= '&password_varchar=passwords';
        $ToString .= '&phone=';
        $ToString .= '&qq=';
        $ToString .= '&id=';
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

        $ToString .= '&timemap=' . $randomLock;
        $ToString .= '&taget=' . md5($text . $password);
        $ReturnString = request_by_other($TuUrl, $ToString);
        $ReturnArray = json_decode($ReturnString, true);
        return $ReturnArray;
    }
}
