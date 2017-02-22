<?php
class Modelprice extends ForeVIEWS {

	public function __Public() {
		IsLogin();
		
		$this->MyModule = 'Modelprice';
	}
	
	public function Lists() {
		$this->MyAction = 'Lists';
		$Model=new ModelModule();
		if ($this->_POST['searchtxt']){
			$Searchtxt = '\''.trim($this->_POST['searchtxt']).'\'';
			$DB = new DB ();
			$Agent = $DB->Select('select * from tb_agent where UserName = '.$Searchtxt);
			$Agent = $Agent[0]['AgentID'];
			$Data['Data'] = $DB->Select ( 'select * from tb_exchangelogs where AgentID_bef = '.$Agent.' or AgentID = '.$Agent.' order by Time DESC');
			$this->Data=$Data;
			
		}else{
			$Agent = (int)$_SESSION['AgentID'];
			$Page = intval ( $this->_GET ['Page'] );
			$Page = $Page ? $Page : 1;
			$PageSize=10;
			$From=($Page-1)*$PageSize;
			$Data['state']=$this->_GET['state'];
			$Data['Page']=$Page;
			$DB = new DB ();
			$Data['Data']=$DB->Select ( 'select * from tb_exchangelogs where AgentID_bef = '.$Agent.' or AgentID = '.$Agent.' order by Time DESC limit ' . $From . ',' . $PageSize );
			$RecordCount=$DB->GetOne ( 'select count(*) as Num from tb_exchangelogs where AgentID_bef = '.$Agent.' or AgentID = '.$Agent);
			$Data['RecordCount']=$RecordCount['Num'];
			$Data['PageCount']=ceil($RecordCount['Num']/$PageSize);
			$Data['PageSize']=$PageSize;
			$this->Data=$Data;
		}
	}
	
	
}

?>