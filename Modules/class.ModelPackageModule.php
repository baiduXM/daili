<?php

class ModelPackageModule {

    public function __construct() {
        $this->ID = 'ID';
        $this->NO = 'PackagesNum';
        $this->TableName = 'tb_model_packages';
        $this->KeyID = 'ID';
    }

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

    public function GetListByWhere($lists = array(), $where = '') {
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

    public function GetListsNum($MysqlWhere = '') {
        $DB = new DB ();
        return $DB->GetOne('select count(' . $this->KeyID . ') as Num from ' . $this->TableName . ' ' . $MysqlWhere);
    }

    public function InsertArray($Array = array(), $TureOrFalse = false) {
        $DB = new DB ();
        return $DB->insertArray($this->TableName, $Array, $TureOrFalse);
    }

    public function UpdateArrayByKeyID($Array = array(), $KeyID = 0) {
        $DB = new DB ();
        return $DB->UpdateArray($this->TableName, $Array, array($this->KeyID => $KeyID));
    }

    public function UpdateArrayByNO($Array = array(), $KeyID = 0) {
        $DB = new DB ();
        return $DB->UpdateArray($this->TableName, $Array, array('NO' => $KeyID));
    }


}
