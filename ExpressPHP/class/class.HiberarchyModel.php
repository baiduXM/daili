<?php
abstract class HiberarchyModel {
	protected $MaxLevel = 3;
	protected $MaxNums = 100;
	protected $TableName = null;
	protected $ID = null;
	protected $Name = null;
	protected $ParentID = null;
	protected $Level = null;
	protected $DisplayOrder = null;
	protected $GlobalDisplayOrder = null;
	public function __construct(){
		$this->__Config();
	}
	abstract protected function __Config();
	abstract protected function __InitDB();
	public function Create($Data){
		$DB = $this->__InitDB();
		$Data[$this->ID] = $this->NewID($Data[$this->ParentID], $NewLevel, $ParentGlobalDisplayOrder);
		if (! $Data[$this->ID]) return false;
		if (! $Data[$this->ParentID]) {
			$Data[$this->ParentID] = $this->TopID();
		}
		$Data[$this->Level] = $NewLevel;
		if (! $Data[$this->DisplayOrder]) $Data[$this->DisplayOrder] = $this->GetDisplayOrder($Data[$this->ParentID]);
		
		$Data[$this->GlobalDisplayOrder] = $this->GetNewGlobalDisPlayOrder($NewLevel, $Data[$this->DisplayOrder], $ParentGlobalDisplayOrder);
		if ($DB->insertArray($this->TableName, $Data)) return $Data[$this->ID];
		else
			return false;
	}
	public function BaseID($CurrentLevel){
		return pow($this->MaxNums, $this->MaxLevel - $CurrentLevel);
	}
	public function UpdateGlobalDisplayOrder($ParentID = 0, $ParentDisplayOrder = 0){
		$DB = $this->__InitDB();
		if (! $ParentID) $ParentID = $this->TopID();
		$sql = 'SELECT * FROM `' . $this->TableName . '` WHERE `' . $this->ParentID . '`=' . $ParentID . ' ORDER BY `' . $this->ID . '` ASC';
		$RS = $DB->Select($sql);
		if ($RS) {
			foreach ( $RS as $list ) {
				$newParentDisplayOrder = $this->GetNewGlobalDisPlayOrder($list[$this->Level], $list[$this->DisplayOrder], $ParentDisplayOrder);
				$sql = 'update `' . $this->TableName . '` set `' . $this->GlobalDisplayOrder . '` =' . $newParentDisplayOrder . ' WHERE `' . $this->ID . '`=' . $list[$this->ID];
				$DB->update($sql);
				$this->UpdateGlobalDisplayOrder($list[$this->ID], $newParentDisplayOrder);
			}
		}
	}
	public function GetNewGlobalDisPlayOrder($Level, $DisplayOrder, $ParentDisplayOrder = 0){
		if (! $ParentDisplayOrder) $TopID = $this->TopID();
		else
			$TopID = $ParentDisplayOrder;
		$BaseID = $this->BaseID($Level);
		return $TopID + $BaseID * $DisplayOrder;
	}
	public function TopID(){
		return pow($this->MaxNums, $this->MaxLevel);
	}
	public function GetBase($CurrentLevel){
		if ($CurrentLevel > $this->MaxLevel) {
			return false;
		}
		$CurrentLevel += 1;
		return pow($this->MaxNums, $this->MaxLevel - $CurrentLevel);
	}
	public function GetLevel($ID){
		$DB = $this->__InitDB();
		$sql = 'SELECT `' . $this->Level . '` FROM `' . $this->TableName . '` WHERE `' . $this->ID . '`=' . $ID;
		$result = $DB->getone($sql);
		return $result ? $result[$this->Level] : 0;
	}
	public function GetNextID($ID, $Level = 0){
		if (! $Level) $Level = $this->GetLevel($ID);
		return $ID + $this->BaseID($Level);
	}
	public function NewID($ParentID, &$Level, &$ParentGlobalDisplayOrder){
		$DB = $this->__InitDB();
		if ($ParentID) {
			$ParentDetail = $this->Get($ParentID);
			if (! $ParentDetail) return false;
			$Level = $ParentDetail[$this->Level] + 1;
			$ParentGlobalDisplayOrder = $ParentDetail[$this->GlobalDisplayOrder];
		} else {
			$ParentID = $this->TopID();
			$Level = 1;
			$ParentGlobalDisplayOrder = $ParentID;
		}
		if ($Level > $this->MaxLevel) return false;
		$BaseID = $this->BaseID($Level);
		for($i = 1; $i < $this->MaxNums; $i ++) {
			$sql = 'SELECT `' . $this->ID . '` FROM `' . $this->TableName . '` WHERE `' . $this->ID . '`=' . ($ParentID + $BaseID * $i);
			$result = $DB->GetOne($sql);
			if (! $result) return $ParentID + $BaseID * $i;
		}
		return false;
	}
	public function Get($ID){
		$DB = $this->__InitDB();
		$sql = 'SELECT * FROM `' . $this->TableName . '` WHERE `' . $this->ID . '`=' . $ID;
		return $DB->getone($sql);
	}
	public function GetParents($ID){
		$detail = $this->Get($ID);
		if ($detail) {
			$data[] = array (
				$this->ID => $detail[$this->ID], 
				$this->Name => $detail[$this->Name] 
			);
			if ($detail[$this->ParentID]) {
				$subdata = $this->GetParents($detail[$this->ParentID]);
				if ($subdata) return array_merge($subdata, $data);
			}
			return $data;
		}
	}
	public function GetToOptions($Level = 2){
		$DB = $this->__InitDB();
		$sql = 'SELECT * FROM `' . $this->TableName . '` WHERE `' . $this->Level . '`<=' . $Level . ' ORDER BY `' . $this->ID . '` ASC, `' . $this->DisplayOrder . '` ASC';
		return $DB->select($sql);
	}
	public function GetName($ID){
		$detail = $this->Get($ID);
		if ($detail) return $detail[$this->Name];
		else
			return null;
	}
	public function GetDisplayOrder($ParentID){
		$DB = $this->__InitDB();
		$sql = 'SELECT MAX(`' . $this->DisplayOrder . '`) AS m FROM `' . $this->TableName . '` WHERE `' . $this->ParentID . '`=' . $ParentID;
		$result = $DB->getone($sql);
		return $result ? min(255, $result['m'] + 1) : 1;
	}
	public function GetParentID($ID){
		$DB = $this->__InitDB();
		$sql = 'SELECT `' . $this->ParentID . '` FROM `' . $this->TableName . '` WHERE `' . $this->ID . '`=' . $ID;
		$result = $DB->getone($sql);
		return $result ? $result[$this->ParentID] : 0;
	}
	
	public function Update($ID, $Data){
		$DB = $this->__InitDB();
		return $DB->UpdateWhere($this->TableName, $Data, '`' . $this->ID . '` =' . $ID);
	}
	
	public function GetCategories($Level){
		$DB = $this->__InitDB();
		$sql = 'SELECT `' . $this->ID . '`,`' . $this->Name . '` FROM `' . $this->TableName . '` WHERE `' . $this->Level . '`<=' . $Level . ' ORDER BY `' . $this->DisplayOrder . '` ASC';
		return $DB->Select($sql);
	}
	public function GetLocation($ID){
		$Detail = $this->Get($ID);
		$result = array ();
		if (! $Detail) return false;
		if ($Detail[$this->ParentID]) {
			$ParentDetail = $this->GetLocation($Detail[$this->ParentID]);
			if ($ParentDetail) {
				array_unshift($result, $Detail);
				foreach ( $ParentDetail as $tmpDetail ) {
					array_unshift($result, $tmpDetail);
				}
			}
		} else {
			array_unshift($result, $Detail);
		}
		return $result;
	}
}
?>