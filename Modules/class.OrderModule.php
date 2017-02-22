<?php
class OrderModule {
    public function __construct() {
        $this->TableName = 'tb_order';
        $this->KeyID="OrderID";
    }
    public function InsertArray($data=array(),$TureOrFalse=true){
        $DB = new DB ();
        return $DB->insertArray ( $this->TableName, $data, $TureOrFalse );
    }
    public function GetOneInfoByKeyID($KeyID = 0) {
        $DB = new DB ();
        return $DB->GetOne ( 'select * from ' . $this->TableName . ' where ' . $this->KeyID . ' = ' . $KeyID );
    }
    //更新数据
    public function UpdateArray($Info = array(), $Array) {
        $DB = new DB ();
        return $DB->UpdateArray($this->TableName, $Info, $Array);
    }
//    public function GetBalance($AgentID){
//        $DB = new DB ();
//        return $DB->GetOne ( 'select Balance from ' . $this->TableName . ' where ' . $this->AgentID . ' = ' . $AgentID );
//    }
}
