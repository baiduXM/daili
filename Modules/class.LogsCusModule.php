<?php
class LogsModule {
	public function __construct() {
		$this->id = 'id';
		$this->code = 'code';
		$this->ip = 'ip';
		$this->status = 'status';
		$this->time = 'time';
		$this->AgentID = 'AgentID';
		$this->CustomersID = 'CustomersID';
		$this->Remark = 'Remark';
		$this->OrderNO = 'OrderNO';
		$this->TableName = 'tbl_logs';
		$this->KeyID = 'id';
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
		return $DB->UpdateArray ( $this->TableName, $Array, array ($this->KeyID => $KeyID ) );
	}
	public function UpdateArray($Info = array(), $Array) {
		$DB = new DB ();
		return $DB->UpdateArray ( $this->TableName, $Info, $Array );
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
		return $DB->Select ( 'select * from ' . $this->TableName . ' ' . $MysqlWhere . ' order by ' . $this->time . '  limit ' . $From . ',' . $Pagesize );
	}
	public function GetOneInfoByArrayKeys($Array = array()) {
		$DB = new DB ();
		$KeyInfo = array_keys($Array);
		$Where = '1';
		foreach ($KeyInfo As $Value)
		{
			$Where .= ' and `'.$Value .'`=\''. $Array[$Value].'\'';
		}
		return $DB->GetOne ( 'select * from ' . $this->TableName . ' where '. $Where);
	}
}