<?php

class NoticeModule
{
    public function __construct()
    {
        $this->TableName = 'tb_notice';
        $this->KeyID = 'id';
        $this->content = 'content';
        $this->is_on = 'is_on';
    }

    public function GetAll()
    {
        $DB = new DB ();
        return $DB->Select('select * from ' . $this->TableName );
    }

    public function UpdateArrayByKeyID($Array = array(), $KeyID = 0)
    {
        $DB = new DB ();
        return $DB->UpdateArray($this->TableName, $Array, array($this->KeyID => $KeyID));
    }

    public function GetOneInfoByKeyID($KeyID = 0)
    {
        $DB = new DB ();
        return $DB->GetOne('select * from ' . $this->TableName . ' where ' . $this->KeyID . ' = ' . $KeyID);
    }

    public function InsertArray($Array = array(), $TureOrFalse = false)
    {
        $DB = new DB ();
        return $DB->insertArray($this->TableName, $Array, $TureOrFalse);
    }

    public function DeleteInfoByKeyID($KeyID = 0)
    {
        $DB = new DB ();
        $Sql = 'DELETE FROM ' . $this->TableName . ' WHERE ' . $this->KeyID . '=' . $KeyID;
        return $DB->Delete($Sql);
    }

    public function UpdateArray($Info = array(), $Array)
    {
        $DB = new DB ();
        return $DB->UpdateArray($this->TableName, $Info, $Array);
    }

    public function GetOneByWhere($lists = array(), $where = '')
    {
        $DB = new DB();
        if (is_array($lists)) {
            if (count($lists))
                $select = implode(',', $lists);
            else
                $select = '*';
        } else {
            $where = $lists;
            $select = '*';
        }
        return $DB->GetOne('select ' . $select . ' from ' . $this->TableName . ' ' . $where);
    }

    public function GetListsByWhere($lists = array(), $where = '')
    {
        $DB = new DB ();
        if (is_array($lists)) {
            if (count($lists))
                $select = implode(',', $lists);
            else
                $select = '*';
        } else {
            $where = $lists;
            $select = '*';
        }
        return $DB->Select('select ' . $select . ' from ' . $this->TableName . ' ' . $where);
    }

    public function GetListsNum($MysqlWhere = '')
    {
        $DB = new DB ();
        return $DB->GetOne('select count(' . $this->KeyID . ') as Num from ' . $this->TableName . ' ' . $MysqlWhere);
    }
}
