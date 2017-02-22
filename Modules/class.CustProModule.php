<?php

class CustProModule {

    public function __construct() {
        $this->CustomersProjectID = 'CustomersProjectID';
        $this->ProjectID = 'ProjectID';
        $this->PropertyPropertyID = 'PropertyPropertyID';
        $this->StartTime = 'StartTime';
        $this->EndTime = 'EndTime';
        $this->AddTime = 'AddTime';
        $this->UpdateTime = 'UpdateTime';
        $this->CustomersID = 'CustomersID';
        $this->Remark = 'Remark';
        $this->AgentID = 'AgentID';
        $this->TableName = 'tb_customers_project';
        $this->KeyID = 'CustomersProjectID';
    }

    //获取所有
    public function GetAllByWhere($where = '', $From = 0, $Pagesize = 0) {
        $DB = new DB ();
        if (!is_string($where)) {
            $Pagesize = $From;
            $From = $where;
            $where = '';
        }
        $limit = $From ? $Pagesize ? ' limit ' . $Pagesize . ' offset ' . $From : ' limit ' . $Pagesize : '';
        return $DB->Select('select * from ' . $this->TableName . ' ' . $where . ' ' . $limit);
    }

    //获取多个列
    public function GetListsByWhere($lists = array(), $where = '') {
        $DB = new DB ();
        if (is_array($lists)) {
            if (count($lists))
                $select = implode(',', $lists);
            else
                $select = '*';
        }else {
            $where = $lists;
            $select = '*';
        }
        return $DB->Select('select ' . $select . ' from ' . $this->TableName . ' ' . $where);
    }

    //获取单条记录的
    public function GetOneByWhere($lists = array(), $where = '') {
        $DB = new DB ();
        if (is_array($lists)) {
            if (count($lists))
                $select = implode(',', $lists);
            else
                $select = '*';
        }else {
            $where = $lists;
            $select = '*';
        }
        return $DB->GetOne('select ' . $select . ' from ' . $this->TableName . ' ' . $where);
    }

    //更新数据
    public function UpdateArray($Info = array(), $Array) {
        $DB = new DB ();
        if (!is_array($Array))
            $Array = array($this->CustomersID => $Array);
        return $DB->UpdateArray($this->TableName, $Info, $Array);
    }

    //插入数据
    public function InsertArray($Array = array(), $TureOrFalse = false) {
        $DB = new DB ();
        return $DB->insertArray($this->TableName, $Array, $TureOrFalse);
    }

    //查询满足指定条件的数量
    public function GetListsNum($MysqlWhere = '') {
        $DB = new DB ();
        return $DB->GetOne('select count(' . $this->KeyID . ') as Num from ' . $this->TableName . ' ' . $MysqlWhere);
    }

    //根据where删除客户
    public function DeleteInfoByWhere($where) {
        $DB = new DB ();
        $Sql = 'DELETE FROM ' . $this->TableName . ' ' . $where;
        return $DB->Delete($Sql);
    }

    public function DeleteInfoByKeyID($KeyID = 0) {
        $DB = new DB ();
        $Sql = 'DELETE FROM ' . $this->TableName . ' WHERE ' . $this->KeyID . '=' . $KeyID;
        return $DB->Delete($Sql);
    }

    public function UpdateArrayByKeyID($Array = array(), $KeyID = 0) {
        $DB = new DB ();
        return $DB->UpdateArray($this->TableName, $Array, array($this->KeyID => $KeyID));
    }

    public function GetOneInfoByKeyID($KeyID = 0) {
        $DB = new DB ();
        return $DB->GetOne('select * from ' . $this->TableName . ' where ' . $this->KeyID . ' = ' . $KeyID);
    }

    public function GetLists($MysqlWhere = '', $From = 0, $Pagesize = 10) {
        $DB = new DB ();
        return $DB->Select('select * from ' . $this->TableName . ' ' . $MysqlWhere . ' order by ' . $this->KeyID . ' DESC  limit ' . $From . ',' . $Pagesize);
    }

    public function GetAll($MysqlWhere = '') {
        $DB = new DB ();
        return $DB->Select('select * from ' . $this->TableName . ' ' . $MysqlWhere . ' order by ' . $this->KeyID . ' DESC');
    }

    public function GetInfoByWhere($MysqlWhere = '') {
        $DB = new DB ();
        return $DB->GetOne('select * from ' . $this->TableName . ' ' . $MysqlWhere);
    }

    public function GetOneInfoByArrayKeys($Array = array()) {
        $DB = new DB ();
        $MysqlWhere = '';
        foreach ($Array as $Key => $Value) {
            $MysqlWhere .= $Key . ' = \'' . $Value . '\' and ';
        }
        $MysqlWhere = substr($MysqlWhere, 0, - 5);
        $MysqlWhere = trim($MysqlWhere);
        return $DB->GetOne('select * from ' . $this->TableName . ' where ' . $MysqlWhere);
    }

}

?>