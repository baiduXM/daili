<?php
class GshowModule {
    public function __construct() {
        $this->TableName = 'tb_gshow';
        $this->KeyID="GshowID";
    }
    public function InsertArray($data=array(),$TureOrFalse=false){
        $DB = new DB ();
        return $DB->insertArray ( $this->TableName, $data, $TureOrFalse );
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
    //更新数据
    public function UpdateArray($Info = array(), $Array = array()) {
        $DB = new DB ();
        if (!is_array($Array))
                $Array = array($this->KeyID => $Array);
        return $DB->UpdateArray ( $this->TableName, $Info, $Array );
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
    //删除数据
    public function DeleteInfo($where) {
        $DB = new DB ();
        $Sql = 'DELETE FROM ' . $this->TableName ." ".$where;
        return $DB->Delete ( $Sql );
    }
}
