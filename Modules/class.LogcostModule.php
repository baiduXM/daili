<?php
class LogcostModule {
    public function __construct() {
        $this->TableName = 'tb_logcost';
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
}
