<?PHP

class AutoDelete extends InterfaceVIEWS{
	public function DeleteCustomer(){
		$now=date("Y-m-d H:i:s",time());

		//$arr=array('CustomersID','G_name','PC_EndTime','Mobile_EndTime');
		//$where=" where (PC_EndTime<'".$now."' or Mobile_EndTime<'".$now."') and status=1";

		$CustProModule = new CustProModule ();
		$CustomersModule=new CustomersModule ();

        //$CustProInfo = $CustProModule->GetListsByWhere($arr,$where);
		//var_dump($CustProInfo);

		//$db=new DB();
		//$sql="select a.CustomersID,a.G_name,b.CompanyName from tb_customers_project a inner join tb_customers b on a.CustomersID=b.CustomersID where PC_EndTime<'".$now."' or Mobile_EndTime<'".$now."'";
		//$arr=$db->select($sql);
		//var_dump($arr);

		$arr=array(
			array('CustomersID'=>2585,'G_name'=>'xiamen'),
			array('CustomersID'=>22,'G_name'=>'GG0002'),
		);
		foreach($arr as $del){
			$res=$this->DeleteCus($del,$CustProModule,$CustomersModule);
		}		
		unset($CustProModule,$CustomersModule);
		
	}

	public function DeleteCus($arr,$CustProModule,$CustomersModule){

		if ($CustomersModule->UpdateArray(array("Status"=>0), array("CustomersID"=>$arr['CustomersID'])))
        {
            if ($arr) {
                $CustProModule->UpdateArray(array("status"=>0), array("CustomersID"=>$arr['CustomersID']));
                $ToString = 'username=' . $arr['G_name'];
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
                    $CustomersModule->UpdateArray(array("Status"=>1), array("CustomersID"=>$arr['CustomersID']));
                    $result['err'] = 1002;
                    $result['msg'] = '删除客户失败';
 //                   $this->LogsFunction->LogsAgentRecord(119, 0, 2585, 'token文件创建失败');
                    return $result;
                }
                fwrite($myfile, $text);
                fclose($myfile);

                $ToString .= '&timemap=' . $randomLock;
                $ToString .= '&taget=' . md5($text . $password);
                $ReturnString = request_by_other($TuUrl, $ToString);
                $ReturnArray = json_decode($ReturnString, true);
                if ($ReturnArray['err'] == 1000) {
                    $result['data'] = array('name' => $arr['CompanyName']);
                    $result['msg'] = '删除客户成功';
 //                   $this->LogsFunction->LogsAgentRecord(119, 1, $CustomersID, $result['msg']);
                } else {
                    $CustomersModule->UpdateArray(array("Status"=>1), array("CustomersID"=>$arr['CustomersID']));
                    $result['err'] = 1003;
                    $result['data'] = $ReturnArray;
                    $result['msg'] = '统一平台删除客户失败';
//                    $this->LogsFunction->LogsAgentRecord(119, 6, 2585, $result['msg']);
                }
            } else {
                $result['data'] = array('name' => $arr['CompanyName']);
                $result['msg'] = '删除客户成功';
 //               $this->LogsFunction->LogsAgentRecord(119, 1, 2585, $result['msg']);
            }
        }else {
            $result['err'] = 1002;
            $result['msg'] = '本地删除客户失败';
        }
	}
}