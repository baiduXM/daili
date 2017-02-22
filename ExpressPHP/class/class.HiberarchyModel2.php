<?php
abstract class HiberarchyModel2{
	protected $TableName = null;
	protected $ID = null;
	protected $Name = null;
	protected $ParentID = null;
	protected $IDS = null;
	protected $Level = null;
	protected $GlobalDisplayOrder = null;
	protected $DisplayOrder = null;
	public $MaxLevel = 3;
	public function __construct(){
		$this->__Config();
	}
	abstract protected function __Config();
	abstract protected function __InitDB();
	public function Create($Data){
		$DB = $this->__InitDB();
		if(!$Data[$this->DisplayOrder]) $Data[$this->DisplayOrder] = $this->GetDisplayOrder($Data[$this->ParentID]);
		if($Data[$this->ParentID]){
			$ParentDetail = $this->Get($Data[$this->ParentID]);
			if($ParentDetail){
				$Data[$this->Level] = $ParentDetail[$this->Level]+1;
				$Data[$this->IDS] = $ParentDetail[$this->IDS].','.$Data[$this->ParentID];
				$Data[$this->GlobalDisplayOrder] = $ParentDetail[$this->GlobalDisplayOrder].','.$Data[$this->DisplayOrder];
			}
		}else{
			$Data[$this->Level] = 1;
			$Data[$this->IDS] = '0';
			$Data[$this->GlobalDisplayOrder] = $Data[$this->DisplayOrder];
		}
		if($r = $DB->insertArray($this->TableName, $Data, true)){
			$DB->Update('UPDATE `'.$this->TableName.'` SET `'.$this->IDS.'`=\''.$Data[$this->IDS].','.$r.'\' WHERE `'.$this->ID.'` = \''.$r.'\'');
			return $r;
		}else
			return false;
	}
	public function GetLevel($ID){
		$DB = $this->__InitDB();
		$sql = 'SELECT `'.$this->Level.'` FROM `'.$this->TableName.'` WHERE `'.$this->ID.'`='.$ID;
		$result = $DB->getone($sql);
		return $result ? $result[$this->Level] : 0;
	}
	public function Get($ID){
		$DB = $this->__InitDB();
		$sql = 'SELECT * FROM `'.$this->TableName.'` WHERE `'.$this->ID.'`='.$ID;
		return $DB->getone($sql);
	}
	public function GetParents($ID){
		$detail = $this->Get($ID);
		if($detail){
			$data[] = array(
					$this->ID => $detail[$this->ID], 
					$this->Name => $detail[$this->Name] 
			);
			if($detail[$this->ParentID]){
				$subdata = $this->GetParents($detail[$this->ParentID]);
				if($subdata) return array_merge($subdata, $data);
			}
			return $data;
		}
	}
	public function GetToOptions($Level = 2){
		$DB = $this->__InitDB();
		$sql = 'SELECT * FROM `'.$this->TableName.'` WHERE `'.$this->Level.'`<='.$Level.' ORDER BY `'.$this->GlobalDisplayOrder.'` ASC';
		return $DB->select($sql);
	}
	public function GetName($ID){
		$detail = $this->Get($ID);
		if($detail) return $detail[$this->Name];
		else return null;
	}
	public function GetDisplayOrder($ParentID){
		$DB = $this->__InitDB();
		$sql = 'SELECT MAX(`'.$this->DisplayOrder.'`) AS m FROM `'.$this->TableName.'` WHERE `'.$this->ParentID.'`='.$ParentID;
		$result = $DB->getone($sql);
		return $result ? min(255, $result['m']+1) : 1;
	}
	public function GetParentID($ID){
		$DB = $this->__InitDB();
		$sql = 'SELECT `'.$this->ParentID.'` FROM `'.$this->TableName.'` WHERE `'.$this->ID.'`='.$ID;
		$result = $DB->getone($sql);
		return $result ? $result[$this->ParentID] : 0;
	}
	
	public function Update($ID, $Data){
		$DB = $this->__InitDB();
		$ParentDetail = $this->Get($Data[$this->ParentID]);
		if($ParentDetail){
			$Data[$this->GlobalDisplayOrder] = $ParentDetail[$this->GlobalDisplayOrder].','.$Data[$this->DisplayOrder];
			$Data[$this->IDS] = $ParentDetail[$this->IDS].','.$ID;
		}
		return $DB->UpdateWhere($this->TableName, $Data, '`'.$this->ID.'` ='.$ID);
	}
	public function UpdateDisplayOrder($ParentID){
		$DB = $this->__InitDB();
		if($ParentID){
			$ParentDetail = $this->Get($ParentID);
		}
		$sql = 'SELECT `'.$this->ID.'` FROM `'.$this->TableName.'` WHERE `'.$this->ParentID.'`=\''.$ParentID.'\' ORDER BY `'.$this->DisplayOrder.'` ASC';
		$rs = $DB->Select($sql);
		if($rs){
			foreach($rs as $i => $list){
				$NewDisplayOrder = $i+1;
				if($ParentDetail) {
					$NewGlobalDisplayOrder = $ParentDetail[$this->GlobalDisplayOrder].','.$NewDisplayOrder;
					$NewIDS = $ParentDetail[$this->IDS].','.$list[$this->ID];
					$NewLevel = $ParentDetail[$this->Level]+1;
				}
				else {
					$NewGlobalDisplayOrder = '0,'.$NewDisplayOrder;
					$NewIDS ='0,'.$list[$this->ID];
					$NewLevel = 1;
				}
				$DB->Update('UPDATE `'.$this->TableName.'` SET `'.$this->GlobalDisplayOrder.'`=\''.$NewGlobalDisplayOrder.'\',`'.$this->DisplayOrder.'`=\''.$NewDisplayOrder.'\',`'.$this->IDS.'`=\''.$NewIDS.'\', `'.$this->Level.'`=\''.$NewLevel.'\' WHERE `'.$this->ID.'`=\''.$list[$this->ID].'\'');
				$this->UpdateDisplayOrder($list[$this->ID]);
			}
		}
	}
	public function GetCategories($Level){
		$DB = $this->__InitDB();
		$sql = 'SELECT * FROM `'.$this->TableName.'` WHERE `'.$this->Level.'`<='.$Level.' ORDER BY `'.$this->GlobalDisplayOrder.'` ASC';
		return $DB->Select($sql);
	}
	public function GetLocation($ID){
		$Detail = $this->Get($ID);
		$result = array();
		if(!$Detail) return false;
		$CategoryIDS = explode(',', $Detail[$this->IDS]);
		if(is_array($CategoryIDS)){
			foreach($CategoryIDS as $CategoryID){
				if($CategoryID){
					$CategoryDetail = $this->Get($CategoryID);
					if($CategoryDetail){
						$result[] = $CategoryDetail;
					}
				}
			}
		}
		return $result;
	}
}
?>