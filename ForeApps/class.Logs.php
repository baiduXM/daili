<?php
/**
 * Created by Zend Studio.
 * User: caicai
 * Date: 14-9-13
 * Time: 上午10:25
 */
class Logs extends ForeVIEWS {
	public function __Public() {
		IsLogin ();
		//控制器
		$this->MyModule = 'Logs';
	}
	
	/*
	 * 登陆日志
	 */
	public function login() {
		$this->MyAction = 'login';
		$Page = intval ( $this->_GET ['Page'] );
		$Page = $Page ? $Page : 1;
		$MysqlWhere = "where AgentID=$_SESSION[AgentID]";//echo $MysqlWhere;exit;
		include 'Modules/class.LoginlogsModule.php';
		$Loginlogs = new Loginlogs();
		$Page = intval ( $this->_GET ['Page'] );
		$Page = $Page ? $Page : 1;
		$PageSize = 20;
		$ListsNum = $Loginlogs->GetListsNum($MysqlWhere);
		$Rscount = $ListsNum ['Num'];
		if ($Rscount) {
			$this->Data = $Data;
			$Data ['RecordCount'] = $Rscount;
			$Data ['PageSize'] = ($PageSize ? $PageSize : $Data ['RecordCount']);
			$Data ['PageCount'] = ceil ( $Data ['RecordCount'] / $PageSize );
			$Data ['Page'] = min ( $Page, $Data ['PageCount'] );
			$Offset = ($Page - 1) * $Data ['PageSize'];
			if ($Page > $Data ['PageCount'])
				$Page = $Data ['PageCount'];
			$Data['Data'] = $Loginlogs->GetLists ( $MysqlWhere, $Offset, $Data ['PageSize'] );
			MultiPage ( $Data, 10 );
			$this->Data = $Data;
		}
	}
	
	/*
	 * 资金明细，包含充值与消费记录
	*/
	public function AllProperty(){
		$this->MyAction = 'AllProperty';
		$Page = intval ( $this->_GET ['Page'] );
		$Page = $Page ? $Page : 1;
		$OrderModule = new OrderModule();
		$OrderDescriptionModule = new OrderDescriptionModule();
		$MysqlWhere = "where AgentID=$_SESSION[AgentID]";
		$Searchtxt = $this->_POST['searchtxt'];
		if($Searchtxt!=''){
			$MysqlWhere .=" and OrderNO='$Searchtxt'";
		}
		$OrderInfo = $OrderModule->GetLists($MysqlWhere);
		$ListsNum = $OrderModule->GetListsNum($MysqlWhere);
		$Rscount = $ListsNum ['Num'];
		$PageSize = 10;
		if ($Rscount) {
			$Data ['RecordCount'] = $Rscount;
			$Data ['PageSize'] = ($PageSize ? $PageSize : $Data ['RecordCount']);
			$Data ['PageCount'] = ceil ( $Data ['RecordCount'] / $PageSize );
			$Data ['Page'] = min ( $Page, $Data ['PageCount'] );
			$Offset = ($Page - 1) * $Data ['PageSize'];
			if ($Page > $Data ['PageCount'])
				$Page = $Data ['PageCount'];
			$Data['Data'] = $OrderModule->GetLists ( $MysqlWhere, $Offset, $Data ['PageSize'] );
			//dd($Data);
			$FengxinID =FENGXIN_ID;
			$GBaoPenID = GBAOPEN_ID;
			foreach($Data['Data'] as $k=>$v){
				$Description = $OrderDescriptionModule->GetOneInfoByKeyID($v[DescriptionID]);
				$Data['Data'][$k]['Description'] = $Description['Description'];
				if($v['ProjectID']==$FengxinID){
					$Data['Data'][$k]['ProjectID']='风信';
				}
				if($v['ProjectID']==$GBaoPenID){
					$Data['Data'][$k]['ProjectID']='G宝盆';
				}
			}
			//dd($Data);
			MultiPage ( $Data, 10 );
			$this->Data = $Data;
		}
	}
	/*
	 * 风信消费记录
	 */
	public function FengxinCost(){
		$this->MyAction = 'FengxinCost';
		$Page = intval ( $this->_GET ['Page'] );
		$Page = $Page ? $Page : 1;
		$OrderModule = new OrderModule();
		$OrderDescriptionModule = new OrderDescriptionModule();
		$ProjectID = FENGXIN_ID;
		$MysqlWhere = "where AgentID=$_SESSION[AgentID] and Type=0 and ProjectID=$ProjectID";
		$Searchtxt = $this->_POST['searchtxt'];
		if($Searchtxt!=''){
			$MysqlWhere .=" and OrderNO='$Searchtxt'";
		}
		$OrderInfo = $OrderModule->GetLists($MysqlWhere);
		$ListsNum = $OrderModule->GetListsNum($MysqlWhere);
		$Rscount = $ListsNum ['Num'];
		$PageSize = 10;
		if ($Rscount) {
			$Data ['RecordCount'] = $Rscount;
			$Data ['PageSize'] = ($PageSize ? $PageSize : $Data ['RecordCount']);
			$Data ['PageCount'] = ceil ( $Data ['RecordCount'] / $PageSize );
			$Data ['Page'] = min ( $Page, $Data ['PageCount'] );
			$Offset = ($Page - 1) * $Data ['PageSize'];
			if ($Page > $Data ['PageCount'])
				$Page = $Data ['PageCount'];
			$Data['Data'] = $OrderModule->GetLists ( $MysqlWhere, $Offset, $Data ['PageSize'] );
			//dd($Data);
			$FengxinID =FENGXIN_ID;
			$GBaoPenID = GBAOPEN_ID;
			foreach($Data['Data'] as $k=>$v){
				$Description = $OrderDescriptionModule->GetOneInfoByKeyID($v[DescriptionID]);
				$Data['Data'][$k]['Description'] = $Description['Description'];
				if($v['ProjectID']==$FengxinID){
					$Data['Data'][$k]['ProjectID']='风信';
				}
				if($v['ProjectID']==$GBaoPenID){
					$Data['Data'][$k]['ProjectID']='G宝盆';
				}
			}
			//dd($Data);
			MultiPage ( $Data, 10 );
			$this->Data = $Data;
		}
	}
	
	
	/*
	 * G宝盆消费记录
	*/
	public function GbaopenCost(){
		$this->MyAction = 'GbaopenCost';
		$Page = intval ( $this->_GET ['Page'] );
		$Page = $Page ? $Page : 1;
		$OrderModule = new OrderModule();
		$OrderDescriptionModule = new OrderDescriptionModule();
		$ProjectID = GBAOPEN_ID;
		$MysqlWhere = "where AgentID=$_SESSION[AgentID] and Type=0 and ProjectID=$ProjectID";
		$Searchtxt = $this->_POST['searchtxt'];
		if($Searchtxt!=''){
			$MysqlWhere .=" and OrderNO='$Searchtxt'";
		}
		$OrderInfo = $OrderModule->GetLists($MysqlWhere);
		$ListsNum = $OrderModule->GetListsNum($MysqlWhere);
		$Rscount = $ListsNum ['Num'];
		$PageSize = 10;
		if ($Rscount) {
			$Data ['RecordCount'] = $Rscount;
			$Data ['PageSize'] = ($PageSize ? $PageSize : $Data ['RecordCount']);
			$Data ['PageCount'] = ceil ( $Data ['RecordCount'] / $PageSize );
			$Data ['Page'] = min ( $Page, $Data ['PageCount'] );
			$Offset = ($Page - 1) * $Data ['PageSize'];
			if ($Page > $Data ['PageCount'])
				$Page = $Data ['PageCount'];
			$Data['Data'] = $OrderModule->GetLists ( $MysqlWhere, $Offset, $Data ['PageSize'] );
			//dd($Data);
			$FengxinID =FENGXIN_ID;
			$GBaoPenID = GBAOPEN_ID;
			foreach($Data['Data'] as $k=>$v){
				$Description = $OrderDescriptionModule->GetOneInfoByKeyID($v[DescriptionID]);
				$Data['Data'][$k]['Description'] = $Description['Description'];
				if($v['ProjectID']==$FengxinID){
					$Data['Data'][$k]['ProjectID']='风信';
				}
				if($v['ProjectID']==$GBaoPenID){
					$Data['Data'][$k]['ProjectID']='G宝盆';
				}
			}
			//dd($Data);
			MultiPage ( $Data, 10 );
			$this->Data = $Data;
		}
	}
	
	/*
	 * 消费记录
	*/
	public function Recharge(){
		$this->MyAction = 'Recharge';
		$Page = intval ( $this->_GET ['Page'] );
        $type = $this->_GET ['type'];
		$Page = $Page ? $Page : 1;
		$OrderModule = new OrderModule();
		$OrderDescriptionModule = new OrderDescriptionModule();
		$MysqlWhere = "where AgentID=$_SESSION[AgentID] and Type=1";
		$Searchtxt = $this->_POST['searchtxt'];
        $FengxinID =FENGXIN_ID;
		$GBaoPenID = GBAOPEN_ID;
		if($Searchtxt!=''){
			$MysqlWhere .=" and OrderNO='$Searchtxt'";
		}
        if($type=='f'){
            $MysqlWhere .=" and ProjectID='$FengxinID'";
        }
        elseif($type=='g'){
            $MysqlWhere .=" and ProjectID='$GBaoPenID'";
        }
        else{
            
        }
		$OrderInfo = $OrderModule->GetLists($MysqlWhere);
		$ListsNum = $OrderModule->GetListsNum($MysqlWhere);
		$Rscount = $ListsNum ['Num'];
		$PageSize = 10;
		if ($Rscount) {
			$Data ['RecordCount'] = $Rscount;
			$Data ['PageSize'] = ($PageSize ? $PageSize : $Data ['RecordCount']);
			$Data ['PageCount'] = ceil ( $Data ['RecordCount'] / $PageSize );
			$Data ['Page'] = min ( $Page, $Data ['PageCount'] );
			$Offset = ($Page - 1) * $Data ['PageSize'];
			if ($Page > $Data ['PageCount'])
				$Page = $Data ['PageCount'];
			$Data['Data'] = $OrderModule->GetLists ( $MysqlWhere, $Offset, $Data ['PageSize'] );
			//dd($Data);
			
			foreach($Data['Data'] as $k=>$v){
				$Description = $OrderDescriptionModule->GetOneInfoByKeyID($v[DescriptionID]);
				$Data['Data'][$k]['Description'] = $Description['Description'];
				if($v['ProjectID']==$FengxinID){
					$Data['Data'][$k]['ProjectID']='风信';
				}
				if($v['ProjectID']==$GBaoPenID){
					$Data['Data'][$k]['ProjectID']='G宝盆';
				}
			}
			MultiPage ( $Data, 10 );
			$this->Data = $Data;
		}
	}
}