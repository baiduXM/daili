<?php
class FuWuModule {
	public function __construct() {
		$this->FuWuID = 'FuWuID';
		$this->FuWuName = 'FuWuName';
		$this->FuWuPrice = 'FuWuPrice';
		$this->UpdateTime = 'UpdateTime';
		$this->TableName = 'tbl_fuwu';
		$this->KeyID = 'FuWuID';
	}
	public function InsertArray($Array = array(), $TureOrFalse = false) {
		$DB = new DB ();
		return $DB->insertArray ( $this->TableName, $Array, $TureOrFalse );
	}
	public function DeleteInfoByKeyID($KeyID = 0) {
		$DB = new DB ();
		$Sql = 'DELETE FROM ' . $this->TableName . ' WHERE ' . $this->KeyID . '=' . $KeyID;
		return $DB->Delete ( $Sql );
	}
	public function UpdateArrayByKeyID($Array = array(), $KeyID = 0) {
		$DB = new DB ();
		return $DB->UpdateArray ( $this->TableName, $Array, array ($this->KeyID => intval($KeyID )) );
	}
	public function GetOneInfoByKeyID($KeyID = 0) {
		$DB = new DB ();
		return $DB->GetOne ( 'select * from ' . $this->TableName . ' where ' . $this->KeyID . ' = ' . $KeyID );
	}
	public function GetListsNum($MysqlWhere = '') {
		$DB = new DB ();
		return $DB->GetOne ( 'select count(' . $this->KeyID . ') as Num from ' . $this->TableName . ' ' . $MysqlWhere );
	}
	public function GetLists($MysqlWhere = '', $From = 0, $Pagesize = 10) {
		$DB = new DB ();
		return $DB->Select ( 'select * from ' . $this->TableName . ' ' . $MysqlWhere . ' order by ' . $this->KeyID . ' ASC  limit ' . $From . ',' . $Pagesize );
	}
	public function SelectLists($MysqlWhere = '') {
		$DB = new DB ();
		return $DB->Select ( 'select * from ' . $this->TableName . ' ' . $MysqlWhere );
	}
	public function GetInfoByWhere($MysqlWhere = '') {
		$DB = new DB ();
		return $DB->GetOne ( 'select * from ' . $this->TableName . ' ' . $MysqlWhere );
	}

	public function GetOneInfoByName($Name = 0) {
		$DB = new DB ();
		return $DB->GetOne ( 'select * from ' . $this->TableName . ' where ' . $this->FuWuName . ' = \'' . $Name.'\'' );
	}
	public function GetOneInfoByArrayKeys($Array = array()) {
		$DB = new DB ();
		$MysqlWhere = '';
		foreach ( $Array as $Key => $Value ) {
			$MysqlWhere .= $Key . ' = \'' . $Value . '\' and ';
		}
		$MysqlWhere = substr ( $MysqlWhere, 0, - 5 );
		$MysqlWhere = trim ( $MysqlWhere );
		return $DB->GetOne ( 'select * from ' . $this->TableName . ' where ' . $MysqlWhere );
	}
	public function UpdateArray($Info = array(), $Array) {
		$DB = new DB ();
		return $DB->UpdateArray ( $this->TableName, $Info, $Array );
	}
	public function DeleteInfoByWhere($MysqlWhere = '') {
		$DB = new DB ();
		$Sql = 'DELETE FROM ' . $this->TableName . ' ' . $MysqlWhere;
		return $DB->Delete ( $Sql );
	}
	public function DeleteInfoByCustomersID($CustomersID = 0) {
		$DB = new DB ();
		$Sql = 'DELETE FROM ' . $this->TableName . ' WHERE CustomersID=' . $CustomersID;
		return $DB->Delete ( $Sql );
	}
}
?>