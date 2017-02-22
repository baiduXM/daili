<?php
class LogsFunction {
    public $operate = array(
        '100'=>'登陆系统',

        '111'=>'添加客户',
        '112'=>'修改客户',
        '113'=>'开通G宝盆客户',
        '114'=>'修改G宝盆客户资料',
        '115'=>'G宝盆客户续费',
        '116'=>'暂停G宝盆客户',
        '117'=>'开启G宝盆客户',
        '118'=>'G宝盆客户转移',
        '119'=>'删除客户',
        '120'=>'还原客户',
        '121'=>'网站迁移',
        '122'=>'G宝盆客户扩容',
        '123'=>'微传单',

        '221'=>'新建客服',
        '222'=>'修改客服',
        '223'=>'客服充值',
        '224'=>'删除客服',

    );
    public $operate_status = array(
        '0'=>'失败',
        '1'=>'成功',
        '2'=>'与存在对象冲突',
        '3'=>'错误操纵',
        '4'=>'资金不足',
        '5'=>'同步成功',
        '6'=>'同步失败',
    );
    
    public function LogsCusRecord($code=111, $status=1, $CustomersID =0, $remark=''){
        $root = DocumentRoot.'/../';
        if (!is_dir($root.'dl-log'))
            mkdir($root.'dl-log/');
        if (!is_dir($root.'dl-log/'.date("Ym")))
            mkdir($root.'dl-log/'.date("Ym"));
        if($code!='' && $status!=''){
            $line['Code'] = $code;
            $line['Status'] = $status;
            $line['CustomersID'] = $CustomersID;
            $line['IP'] = GetIP();
            $line['Time'] = date ( "Y-m-d H:i:s" );
            $line['AgentID'] = $_SESSION['AgentID'];
            $line['Remark'] = $remark;
            $DB = new DB ();
            $DB ->insertArray('tbl_logscus', $line);
            $this->add_write($root.'dl-log/'.date("Ym").'/'.'customer.log', $line);
        }
    }
    
	/*生产客户报表文件*/
    public function getcus(){
        $DB = new DB ();
        $sql = 'select a.CompanyName,b.G_name,b.CPhone,b.PC_model,b.Mobile_model from tb_customers a inner join tb_customers_project b on a.CustomersID = b.CustomersID where a.AgentID = b.AgentID';
        $a = $DB->Select($sql);
		$sql = 'select NO,Youhui,TuiJian from tb_model';
		$b = $DB->Select($sql);
		$sql = 'select PackagesNum as NO,Youhui,TuiJian from tb_model_packages';
		$c = $DB->Select($sql);
		$line['公司名'] = iconv('UTF-8','GBK','公司名');
		$line['用户名'] = iconv('UTF-8','GBK','用户名');
		$line['模板'] = iconv('UTF-8','GBK','模板类型');
		$line['PC'] = iconv('UTF-8','GBK','PC站');
		$line['Mobile'] = iconv('UTF-8','GBK','手机站');
		$this->add_write('./cust_pc.csv', $line);
		$this->add_write('./cust_mo.csv', $line);
		$this->add_write('./cust_du.csv', $line);
		$this->add_write('./cust_tao.csv', $line);
		$this->add_write('./cust_all.csv', $line);
        foreach($a as $v){
			$ac = iconv('UTF-8','GBK',$v['CompanyName']);
			$line['公司名'] = $ac;
			$line['用户名'] = $v['G_name'];
			if($v['CPhone'] == 1){
				$line['模板'] = 'PC';
				$line['PC'] = $v['PC_model'];
				$line['Mobile'] = '';
				$this->add_write('./cust_pc.csv', $line);
				$this->add_write('./cust_all.csv', $line);
			}elseif($v['CPhone'] == 2){
				$line['模板'] = iconv('UTF-8','GBK','手机');
				$line['PC'] = '';
				$line['Mobile'] = $v['Mobile_model'];
				$this->add_write('./cust_mo.csv', $line);
				$this->add_write('./cust_all.csv', $line);
			}elseif($v['CPhone'] == 3){
				$line['模板'] = iconv('UTF-8','GBK','双站');
				$line['PC'] = $v['PC_model'];
				$line['Mobile'] = $v['Mobile_model'];
				$this->add_write('./cust_du.csv', $line);
				$this->add_write('./cust_all.csv', $line);
			}elseif($v['CPhone'] == 4){
				$line['模板'] = iconv('UTF-8','GBK','套餐');
				$line['PC'] = $v['PC_model'];
				$line['Mobile'] = $v['Mobile_model'];
				$this->add_write('./cust_tao.csv', $line);
				$this->add_write('./cust_all.csv', $line);
			}
        }
		$line1['模板号'] = iconv('UTF-8','GBK','模板号');
		$line1['价格'] = iconv('UTF-8','GBK','价格');
		$line1['推荐'] = iconv('UTF-8','GBK','推荐');
		$this->add_write('./cust_bao.csv', $line1);
		foreach($b as $v){
			$line1['模板号'] = $v['NO'];
			$line1['价格'] = $v['Youhui'];
			$line1['推荐'] = $v['TuiJian'];
			$this->add_write('./cust_bao.csv', $line1);
		}
		foreach($c as $v){
			$line1['模板号'] = $v['NO'];
			$line1['价格'] = $v['Youhui'];
			$line1['推荐'] = $v['TuiJian'];
			$this->add_write('./cust_bao.csv', $line1);
		}
    }
	

    public function LogsAgentRecord($code=100, $status=1, $agent=NULL, $remark=''){
        $root = DocumentRoot.'/../';
        if (!is_dir($root.'dl-log'))
            mkdir($root.'dl-log/');
        if (!is_dir($root.'dl-log/'.date("Ym")))
            mkdir($root.'dl-log/'.date("Ym"));
        if($code!='' && $status!=''){
            $line['Code'] = $code;
            $line['Status'] = $status;
            $line['IP'] = GetIP();
            $line['Time'] = date ( "Y-m-d H:i:s" );
            if ($agent){
                $line['AgentID'] = $agent;
                $line['BossAgentID'] = $_SESSION['AgentID'];
            }else{
                $line['AgentID'] = $_SESSION['AgentID'];
                $line['BossAgentID'] = 0;
            }
            $line['Remark'] = $remark;
            $DB = new DB ();
            $DB ->insertArray('tbl_logsagent', $line);
            $this->add_write($root.'dl-log/'.date("Ym").'/'.'agent.log', $line);
        }
    }
	
    public function LogsCusExc($status=1, $agent, $agentto ='', $CustomersID, $remark=''){
        $root = DocumentRoot.'/../';
        if (!is_dir($root.'dl-log'))
            mkdir($root.'dl-log/');
        if (!is_dir($root.'dl-log/'.date("Ym")))
            mkdir($root.'dl-log/'.date("Ym"));
        if($status!=''){
            $line['Status'] = $status;
            $line['IP'] = GetIP();
            $line['Time'] = date ( "Y-m-d H:i:s" );
            $line['AgentID'] = $agentto;
            $line['AgentIDBef'] = $agent;
            $line['CustomersID'] = $CustomersID;
            $line['Remark'] = $remark;
            $DB = new DB ();
            $DB ->insertArray('tbl_logsexchange', $line);
            $this->add_write($root.'dl-log/'.date("Ym").'/'.'exchange.log', $line);
        }
    }
	
    protected function add_write($file,$new){
        $f=fopen($file,"a");
        flock($f,LOCK_EX);
        fputcsv($f,$new);
        flock($f,LOCK_UN);
        fclose($f);
    }
	
}