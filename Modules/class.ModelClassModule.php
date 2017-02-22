<?php

class ModelClassModule {

    public function __construct() {
        $this->ID = 'ID';
        $this->CName = 'CName';
        $this->AddTime = 'AddTime';
        $this->TableName = 'tb_model_class';
        $this->KeyID = 'ID';
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

    public function InsertArray($Array = array(), $TureOrFalse = false) {
        $DB = new DB ();
        return $DB->insertArray($this->TableName, $Array, $TureOrFalse);
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

    public function UpdateArray($Info = array(), $Array) {
        $DB = new DB ();
        return $DB->UpdateArray($this->TableName, $Info, $Array);
    }

    public function GetOneInfoByKeyID($KeyID = 0) {
        $DB = new DB ();
        return $DB->GetOne('select * from ' . $this->TableName . ' where ' . $this->KeyID . ' = ' . $KeyID);
    }

    public function GetListsNum($MysqlWhere = '') {
        $DB = new DB ();
        return $DB->GetOne('select count(' . $this->KeyID . ') as Num from ' . $this->TableName . ' ' . $MysqlWhere);
    }

    public function GetLists($MysqlWhere = '', $From = 0, $Pagesize = 10) {
        $DB = new DB ();
        return $DB->Select('select * from ' . $this->TableName . ' ' . $MysqlWhere . ' order by ' . $this->KeyID . ' DESC  limit ' . $From . ',' . $Pagesize);
    }

    public function GetListsAll($MysqlWhere = '') {
        $DB = new DB ();
        return $DB->Select('select * from ' . $this->TableName . ' ' . $MysqlWhere);
    }

}
