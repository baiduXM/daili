<?php
class CustomersModule {
    public function __construct() {
        $this->CustomersID = 'CustomersID';
        $this->CompanyName = 'CompanyName';
        $this->CustomersName = 'CustomersName';
        $this->DomainName = 'DomainName';
        $this->Area = 'Area';
        $this->Tel = 'Tel';
        $this->Fax = 'Fax';
        $this->Email = 'Email';
        $this->Address = 'Address';
        $this->ServiceName = 'ServiceName';
        $this->UserGroupID = 'UserGroupID';
        $this->AddTime = 'AddTime';
        $this->UpdateTime = 'UpdateTime';
        $this->Remark = 'Remark';
        $this->AgentID = 'AgentID';
        $this->TableName = 'tb_customers';
        $this->KeyID = 'CustomersID';
    }
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
    public function UpdateArray($Info = array(), $Array = array()) {
        $DB = new DB ();
        if (!is_array($Array))
                $Array = array($this->KeyID => $Array);
        return $DB->UpdateArray ( $this->TableName, $Info, $Array );
    }

    //创建数据
    public function InsertArray($Array = array(), $TureOrFalse = false) {
        $DB = new DB ();
        return $DB->insertArray ( $this->TableName, $Array, $TureOrFalse );
    }
    //删除数据
    public function DeleteInfoByKeyID($KeyID = 0) {
        $DB = new DB ();
        $Sql = 'DELETE FROM ' . $this->TableName . ' WHERE ' . $this->KeyID . '=' . $KeyID;
        return $DB->Delete ( $Sql );
    }
    
    public function Updatewhere($Array = array(),$where){
        $DB = new DB ();
        return $DB->UpdateWhere($this->TableName,$Array,$where);
    }

    public function UpdateArrayByKeyID($Array = array(), $KeyID = 0) {
        $DB = new DB ();
        return $DB->UpdateArray ( $this->TableName, $Array, array ($this->KeyID => $KeyID ) );
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
        return $DB->Select ( 'select * from ' . $this->TableName . ' ' . $MysqlWhere . ' order by ' . $this->KeyID . ' DESC  limit ' . $From . ',' . $Pagesize );
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
?>