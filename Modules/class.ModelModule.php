<?php

class ModelModule {

    public function __construct() {
        $this->ID = 'ID';
        $this->NO = 'NO';
        $this->Color = 'Color';
        $this->BaiDuXingPing = 'BaiDuXingPing';
        $this->Price = 'Price';
        $this->ModelClassID = 'ModelClassID';
        $this->ZhuSeDiao = 'ZhuSeDiao';
        $this->Language = 'Language';
        $this->Url = 'Url';
        $this->AddTime = 'AddTime';
        $this->Content = 'Content';
        $this->Type = 'Type';
        $this->Pic = 'Pic';
        $this->TuiJian = 'TuiJian';
        $this->TableName = 'tb_model';
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

    public function GetOneForNew($Type = '', $lang = 'CN', $TableName = 'tb_model') {
        $DB = new DB ();
        if ($Type)
            return $DB->GetOne('select * from ' . $TableName . ' where Type=\'' . $Type . '\' and ModelLan=\'' . $lang . '\' order by Num desc');
        else
            return $DB->GetOne('select * from ' . $TableName . ' and ModelLan=\'' . $lang . '\' order by Num desc');
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

    public function UpdateArrayByID($Array = array(), $KeyID = 0) {
        $DB = new DB ();
        return $DB->UpdateArray($this->TableName, $Array, array('ID' => $KeyID));
    }

    public function UpdateArrayByNO($Array = array(), $KeyID = 0) {
        $DB = new DB ();
        return $DB->UpdateArray($this->TableName, $Array, array('NO' => $KeyID));
    }

    public function UpdateArray($Info = array(), $Array) {
        $DB = new DB ();
        return $DB->UpdateArray($this->TableName, $Info, $Array);
    }

    public function GetOneListForAll($KeyID = 'NO', $TableName = 'tb_model') {
        $DB = new DB ();
        return $DB->Select('select ' . $KeyID . ' from ' . $TableName);
    }

    public function GetOneInfoByKeyID($KeyID = 0, $Name = 'ID') {
        $DB = new DB ();
        return $DB->GetOne('select * from ' . $this->TableName . ' where ' . $Name . ' = ' . $KeyID);
    }

    public function GetOnePackagesInfoByKeyID($KeyID = 0, $Name = 'ID') {
        $DB = new DB ();
        return $DB->GetOne('select * from tb_model_packages where ' . $Name . ' = ' . $KeyID);
    }

    public function GetListsNum($MysqlWhere = '') {
        $DB = new DB ();
        return $DB->GetOne('select count(' . $this->KeyID . ') as Num from ' . $this->TableName . ' ' . $MysqlWhere);
    }

    public function GetPackagesListsNum($MysqlWhere = '') {
        $DB = new DB ();
        return $DB->GetOne('select count(' . $this->KeyID . ') as Num from tb_model_packages ' . $MysqlWhere);
    }

    public function GetTaocanListsNum($MysqlWhere = '', $KeyID = 'ID', $TableName = 'tb_model') {
        $DB = new DB ();
        return $DB->GetOne('select count(' . $KeyID . ') as Num from ' . $TableName . ' ' . $MysqlWhere);
    }

    public function GetLists($MysqlWhere = '', $From = 0, $Pagesize = 10, $Paixu = 'DESC') {
        $DB = new DB ();
        return $DB->Select('select * from ' . $this->TableName . ' ' . $MysqlWhere . ' order by NO ' . $Paixu . '  limit ' . $From . ',' . $Pagesize);
    }

    public function GetListsAll($TableName = 'tb_model', $MysqlWhere) {
        $DB = new DB ();
        return $DB->Select('select * from ' . $TableName . ' ' . $MysqlWhere);
    }

    public function GetPackagesLists($MysqlWhere = '', $From = 0, $Pagesize = 10, $Paixu = 'DESC') {
        $DB = new DB ();
        return $DB->Select('select * from tb_model_packages ' . $MysqlWhere . ' order by ' . $this->KeyID . ' ' . $Paixu . '  limit ' . $From . ',' . $Pagesize);
    }

    public function GetTaocanLists($MysqlWhere = '', $From = 0, $Pagesize = 10, $Paixu = 'DESC') {
        $DB = new DB ();
        return $DB->Select('select * from tb_model_packages ' . $MysqlWhere . ' order by ' . $this->KeyID . ' ' . $Paixu . '  limit ' . $From . ',' . $Pagesize);
    }

    //上一篇
    public function GetOneInfoByKeyIDBack($KeyID = 0, $Add = '') {
        $DB = new DB ();
        return $DB->GetOne('select * from ' . $this->TableName . ' where ' . $this->KeyID . ' < ' . $KeyID . $Add . ' order by ' . $this->KeyID . ' desc');
    }

    public function GetOneInfoPackagesByKeyIDBack($KeyID = 0, $Add = '') {
        $DB = new DB ();
        return $DB->GetOne('select * from tb_model_packages where ' . $this->KeyID . ' < ' . $KeyID . $Add . ' order by ' . $this->KeyID . ' desc');
    }

    //下一篇
    public function GetOneInfoByKeyIDzNext($KeyID = 0, $Add = '') {
        $DB = new DB ();
        return $DB->GetOne('select * from ' . $this->TableName . ' where ' . $this->KeyID . ' > ' . $KeyID . $Add . ' order by ' . $this->KeyID . ' asc');
    }

    public function GetOneInfoPackagesByKeyIDzNext($KeyID = 0, $Add = '') {
        $DB = new DB ();
        return $DB->GetOne('select * from tb_model_packages where ' . $this->KeyID . ' > ' . $KeyID . $Add . ' order by ' . $this->KeyID . ' asc');
    }

}
