<?php

/**
 * Created by PhpStorm.
 * User: user001
 * Date: 2018/4/18
 * Time: 15:38
 * Function: E推过期数据各种操作
 */
class Expired extends InterfaceVIEWS
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
        $this->delete = 'delete';
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

    //E推列表页面初始化
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

    //E推客户数量--数据提供
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

        $level = $_SESSION ['Level'];
        $DB = new DB;
        switch ($type) {
            case -1 :
                //搜索
                $where = '';
                if ($this->_GET['contact'] != '' ){
                    $where .= $this->_GET['contact'] != '' ? ' and (cu.CompanyName like "%' . $this->_GET['contact'] . '%") ' : '';
                } else
                    return false;
                break;
            case 0 :
                //所有
                break;
            case 1 :
                //过期
                $now = date('Y-m-d H:i:s' , time());
                $where = ' and g.EndTime < "' . $now . '" ';
                break;
            case 2 :
                //30天
                $now = date('Y-m-d H:i:s' , time());
                $after = $after = date("Y-m-d H:i:s", strtotime("+30 day"));
                $where = ' and g.EndTime > "' . $now . '" and g.EndTime < "' . $after . '" ';
                break;
            case 3 :
                //75天
                $now = date('Y-m-d H:i:s' , time());
                $after = $after = date("Y-m-d H:i:s", strtotime("+75 day"));
                $where = ' and g.EndTime > "' . $now . '" and g.EndTime < "' . $after . '" ';
                break;
            default:
                return false;
        }
        if($level == 1) {
            $select = 'select count(1) as Num from tb_gshow g inner join tb_customers cu on g.CustomersID=cu.CustomersID where 1=1 ' . $where . $order . $limit;
            $cus = $DB->Select($select);
        }  else {
            return false;
        }

        return $cus[0]['Num'];
    }

    //E推列表
    public function GetCus() {
        $result = array('err' => 0, 'data' => '', 'msg' => '');
        $type = $this->_GET['type'];//0-所有，1-过期，2-30天过期，3-75天过期(选项卡顺序)
        $page = floor($this->_GET['page']);//页码
        $num = floor($this->_GET['num']);//每页记录条数
        $data['cus'] = $this->GetCusByType($type,$page,$num);//获取数据
        $result['data'] = $data;
        return $result;
    }

    //E推根据类型获取列表
    protected function GetCusByType($type = 0, $page = 1, $num = 5) {
        $level = $_SESSION ['Level'];
        $page = $page > 0 ? $page : 1;
        $num = $num > 0 ? $num : 5;
        $start = ($page - 1) * $num;
        $limit = ' limit ' . $start . ',' . $num;
        $order = ' order by g.GshowID desc';
        $DB = new DB;
        switch ($type) {
            case -1 :
                //搜索
                $where = '';
                if ($this->_GET['contact'] != '') {
                    $where .= $this->_GET['contact'] != '' ? ' and (cu.CompanyName like "%' . $this->_GET['contact'] . '%") ' : '';
                } else
                    return false;
                break;
            case 0 :
                //所有
                break;
            case 1 :
                //过期
                $now = date('Y-m-d H:i:s' , time());
                $where = ' and g.EndTime < "' . $now . '" ';
                break;
            case 2 :
                //30天
                $now = date('Y-m-d H:i:s' , time());
                $after = $after = date("Y-m-d H:i:s", strtotime("+30 day"));
                $where = ' and g.EndTime > "' . $now . '" and g.EndTime < "' . $after . '" ';
                break;
            case 3 :
                //75天
                $now = date('Y-m-d H:i:s' , time());
                $after = $after = date("Y-m-d H:i:s", strtotime("+75 day"));
                $where = ' and g.EndTime > "' . $now . '" and g.EndTime < "' . $after . '" ';
                break;
            default:
                return false;
        }
        if($level == 1) {
            $select = 'select g.GshowID, g.CustomersID, g.Email, g.UpdateTime, g.StartTime, g.EndTime, g.combo, cu.CompanyName from tb_gshow g inner join tb_customers cu on g.CustomersID=cu.CustomersID where 1=1 ' . $where . $order . $limit;
            $cus = $DB->Select($select);
        }  else {
            return false;
        }

        return $cus;
    }


    public function exportData(){
        $level = $_SESSION ['Level'];
        $type = (int)$this->_GET['type']; //导出数据列表类型
        $now = date('Y-m-d H:i:s' , time());
        $DB = new DB;
        switch ($type) {
            case 0 :
                //所有
                break;
            case 1 :
                //过期
                $where = ' and g.EndTime < "' . $now . '" ';
                break;
            case 2 :
                //30天
                $after = $after = date("Y-m-d H:i:s", strtotime("+30 day"));
                $where = ' and g.EndTime > "' . $now . '" and g.EndTime < "' . $after . '" ';
                break;
            case 3 :
                //75天
                $after = $after = date("Y-m-d H:i:s", strtotime("+75 day"));
                $where = ' and g.EndTime > "' . $now . '" and g.EndTime < "' . $after . '" ';
                break;
            default:
                return false;
        }
        if($level == 1) {
            $select = 'select g.GshowID, g.CustomersID, g.Email, g.UpdateTime, g.StartTime, g.EndTime, g.combo, cu.CompanyName from tb_gshow g inner join tb_customers cu on g.CustomersID=cu.CustomersID where 1=1 ' . $where;
            $cus = $DB->Select($select);
        }  else {
            return false;
        }
        $xlsData = [];
        foreach ($cus as $k=>$v){
            $data['CompanyName'] = $v['CompanyName'];
            $data['Email'] = $v['Email'];
            $data['UpdateTime'] = $v['UpdateTime'];
            $data['StartTime'] = $v['StartTime'];
            $data['EndTime'] = $v['EndTime'];
            $data['combo'] = $this->combo($v['combo']);
            array_push($xlsData,$data);
        }
        //根据类型设置相应的表名
        switch ($type) {
            case '0':
                $xlsTitle = 'E推全部客户名单-'. date('Y-m-d His');
                break;
            case '1':
                $xlsTitle = 'E推过期客户名单-' . date('Y-m-d His');
                break;
            case '2':
                $xlsTitle = '30天内E推过期客户名单-' . date('Y-m-d His');
                break;
            case '3':
                $xlsTitle = '75天内E推过期客户名单-' . date('Y-m-d His');
                break;
        }
        //设置列名
        $xlsCell= [
            array('CompanyName', '公司名称'),
            array('Email', '客户电子邮件'),
            array('UpdateTime', '产品添加时间'),
            array('StartTime', '产品开始时间'),
            array('EndTime', '产品结束时间'),
            array('combo', 'E推套餐类型'),
        ];
        $this->exportExcel($xlsTitle,$xlsCell, $xlsData);
    }

    /*E推套餐类型*/
    public function combo($com){
        switch ($com) {
            case '0':
                $combo = '免费';
                break;
            case '1':
                $combo = '基础';
                break;
            case '2':
                $combo = '普通';
                break;
            case '3':
                $combo = '升级';
                break;
            case '4':
                $combo = '定制';
                break;
        }
        return $combo;
    }

    /*导出excel*/
    protected function exportExcel($xlsTitle,$xlsCell, $xlsData){
        $fileName = iconv('utf-8', 'gb2312', $xlsTitle);//文件名称可根据自己情况设定
        $cellNum = count($xlsCell);
        $dataNum = count($xlsData);

        include './PHPExcel/PHPExcel.php';
        include './PHPExcel/PHPExcel/Writer/Excel2007.php';
        include './PHPExcel/PHPExcel/Writer/Excel5.php';

        $cellName = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
        $objPHPExcel = new PHPExcel();
        /*设置列宽*/
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(35);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        /*内容水平居中*/
        $objPHPExcel->getActiveSheet()->getStyle('C')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('D')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('E')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('F')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        for($i=0;$i<$cellNum;$i++){
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$i].'1', $xlsCell[$i][1]);
        }
        for($i=0;$i<$dataNum;$i++){
            for($j=0;$j<$cellNum;$j++){
                $objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j].($i+2), $xlsData[$i][$xlsCell[$j][0]]);
            }
        }

        header('pragma:public');
        header('Content-type:application/vnd.ms-excel;charset=utf-8;name="'.$xlsTitle.'.xlsx"');
        header("Content-Disposition:attachment;filename=$fileName.xlsx");//attachment新窗口打印inline本窗口打印
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }




}