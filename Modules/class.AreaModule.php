<?php
class AreaModule {
	public function __construct() {
		$this->ID = 'ID';
		$this->ParentID = 'ParentID';
		$this->AreaName = 'AreaName';
		$this->ShortName = 'ShortName';
		$this->EnName = 'EnName';
		$this->ParentEnName = 'ParentEnName';
		$this->Level = 'Level';
		$this->TableName = 'tb_area';
		$this->KeyID = 'ID';
	}
	//获取所有
	public function GetAllByWhere($where = '', $From = 0, $Pagesize = 0) {
		$DB = new DB ();
		if (!is_string($where)){
			$Pagesize = $From;
			$From = $where;
			$where = '';
		}
		$limit = $From ? $Pagesize ? ' limit '.$Pagesize.' offset '.$From : ' limit '.$Pagesize : '';
		return $DB->Select ( 'select * from ' . $this->TableName . ' ' . $where . ' ' . $limit);
	}
	//获取多个列
	public function GetListsByWhere($lists = array(), $where = '') {
		$DB = new DB ();
		if(is_array($lists)){
			if(count($lists))
				$select = implode(',',$lists);
			else
				$select = '*';
		}else{
			$where = $lists;
			$select = '*';
		}
		return $DB->Select ( 'select ' . $select . ' from ' . $this->TableName . ' ' .$where);
	}
	//获取单条记录的
	public function GetOneByWhere($lists = array(),$where = '') {
		$DB = new DB ();
		if(is_array($lists)){
			if(count($lists))
				$select = implode(',',$lists);
			else
				$select = '*';
		}else{
			$where = $lists;
			$select = '*';
		}
		return $DB->GetOne ( 'select ' . $select . ' from ' . $this->TableName . ' ' .$where);
	}
	//更新数据
	public function UpdateArray($Info = array(), $Array) {
		$DB = new DB ();
		if (!is_array($Array))
			$Array = array($this->CustomersID => $Array);
		return $DB->UpdateArray ( $this->TableName, $Info, $Array );
	}
	//插入数据
	public function InsertArray($Array = array(), $TureOrFalse = false) {
		$DB = new DB ();
		return $DB->insertArray ( $this->TableName, $Array, $TureOrFalse );
	}
	//查询满足指定条件的数量
	public function GetListsNum($MysqlWhere = '') {
		$DB = new DB ();
		return $DB->GetOne ( 'select count(' . $this->KeyID . ') as Num from ' . $this->TableName . ' ' . $MysqlWhere );
	}
	//根据where删除客户
	public function DeleteInfoByWhere($where) {
		$DB = new DB ();
		$Sql = 'DELETE FROM ' . $this->TableName . ' ' . $where;
		return $DB->Delete ( $Sql );
	}
	
}
?>