<?php
class AccountModule {
    public function __construct() {
        $this->TableName = 'tb_account';
        $this->AgentID = 'AgentID';
        $this->UserName = 'UserName';
        $this->PassWord = 'PassWord';
        $this->EnterpriseName = 'EnterpriseName';
        $this->ContactName = 'ContactName';
        $this->ContactTel = 'ContactTel';
        $this->ContactEmail = 'ContactEmail';
        $this->ContactAddress = 'ContactAddress';
        $this->Remarks = 'Remarks';
        $this->RegTime = 'RegTime';
        $this->FromIP = 'FromIP';
        $this->KeyID = 'AgentID';
        $this->Power = 'Power';
        $this->BossAgentID = 'BossAgentID';
    }
    public function GetAllByKeyID($KeyID, $Order='', $From = 0, $Pagesize = 0) {
        $DB = new DB ();
        if (!is_string($Order)){
            $Pagesize = $From;
            $From = $Order;
            $Order = '';
        }
        $limit = $From ? $Pagesize ? ' limit '.$Pagesize.' offset '.$From : ' limit '.$Pagesize : '';
        return $DB->Select ( 'select * from ' . $this->TableName . ' where '  . $this->AgentID . '=' . $KeyID . $Order . $limit);
    }

    public function GetAllByPower($power,$list=''){
        if ($list){
            if (is_string($list))
                $select = $list;
            elseif (is_array($list)){
                $select = implode(',',$list);
            }
        }else
            $select = '*';
        $DB = new DB ();
        return $DB->Select ( 'select '.$select.' from ' . $this->TableName . ' where '  . $this->Power . '=' . $power);
    }

    public function GetListByBossAgentID($bossagent,$list=''){
        if ($list){
            if (is_string($list))
                $select = $list;
            elseif (is_array($list)){
                $select = implode(',',$list);
            }
        }else
            $select = '*';
        $DB = new DB ();
        return $DB->Select ( 'select '.$select.' from ' . $this->TableName . ' where '  . $this->BossAgentID . '=' . $bossagent);
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

    public function GetListsNum($MysqlWhere = '') {
        $DB = new DB ();
        return $DB->GetOne ( 'select count(' . $this->KeyID . ') as Num from ' . $this->TableName . ' ' . $MysqlWhere );
    }

    public function UpdateArrayByKeyID($Array = array(), $KeyID = 0) {
        $DB = new DB ();
        return $DB->UpdateArray ( $this->TableName, $Array, array ($this->KeyID => $KeyID ) );
    }

    public function GetOneInfoByKeyID($KeyID = 0) {
        $DB = new DB ();
        return $DB->GetOne ( 'select * from ' . $this->TableName . ' where ' . $this->KeyID . ' = ' . $KeyID );
    }

    public function InsertArray($Array = array(), $TureOrFalse = false) {
        $DB = new DB ();
        return $DB->insertArray ( $this->TableName, $Array, $TureOrFalse );
    }

    public function DeleteInfoByKeyID($KeyID = 0) {
        $DB = new DB ();
        $Sql = 'DELETE FROM ' . $this->TableName . ' WHERE ' . $this->KeyID . '=' . $KeyID;
        return $DB->Delete ( $Sql );
    }

    public function UpdateArray($Info = array(), $Array) {
        $DB = new DB ();
        return $DB->UpdateArray ( $this->TableName, $Info, $Array );
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
    public function GetExperienceCount($agent_id) {
        $DB = new DB ();
        $data=$DB->Select ( 'select ExperienceCount from ' . $this->TableName . ' where AgentID='.$agent_id);
        return (int)$data[0]["ExperienceCount"];
    }
}
