<?php

class BalanceModule
{
    public function __construct()
    {
        $this->AgentID = 'AgentID';
        $this->Balance = 'Balance';
        $this->Remarks = 'Remarks';
        $this->CostMon = 'CostMon';
        $this->CostAll = 'CostAll';
        $this->Power = 'Power';
        $this->UpdataTime = 'UpdataTime';
        $this->TableName = 'tb_balance';
        $this->KeyID = 'AgentID';
    }

    /**
     * 根据条件获取列表
     *
     * @param array $lists
     * @param string $where
     * @return array
     */
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

    /**
     * 根据AgentID获取列表
     *
     * @param array $lists
     * @param $agentID
     * @return array
     */
    public function GetListsOneByAgentID($lists = array(), $agentID)
    {
        $DB = new DB ();
        if (is_array($lists)) {
            if (count($lists))
                $select = implode(',', $lists);
            else
                $select = '*';
        } else {
            $agentID = $lists;
            $select = '*';
        }
        return $DB->GetOne('select ' . $select . ' from ' . $this->TableName . ' where ' . $this->AgentID . '=' . $agentID);
    }

    /**
     * 插入数据
     *
     * @param array $Array
     * @param bool $TureOrFalse
     * @return int
     */
    public function InsertArray($Array = array(), $TureOrFalse = false)
    {
        $DB = new DB ();
        return $DB->insertArray($this->TableName, $Array, $TureOrFalse);
    }

    /**
     * 根据AgentID更新数据
     *
     * @param array $Array  更新的字段数组
     * @param int $AgentID  代理商ID
     * @return int
     */
    public function UpdateArrayByAgentID($Array = array(), $AgentID = 0)
    {
        $DB = new DB ();
        return $DB->UpdateArray($this->TableName, $Array, array($this->AgentID => $AgentID));
    }

    /**
     * 根据AgentID删除数据
     *
     * @param $AgentID
     * @return int
     */
    public function DeleteInfoByAgentID($AgentID)
    {
        $DB = new DB ();
        $Sql = 'DELETE FROM ' . $this->TableName . ' WHERE ' . $this->AgentID . '=' . $AgentID;
        return $DB->Delete($Sql);
    }

    /**
     * 根据AgentID获取一条数据
     *
     * @param $AgentID
     * @return array
     */
    public function GetOneInfoByAgentID($AgentID)
    {
        $DB = new DB ();
        return $DB->GetOne('select * from ' . $this->TableName . ' where ' . $this->AgentID . ' = ' . $AgentID);
    }

    public function GetListsNum($MysqlWhere = '')
    {
        $DB = new DB ();
        return $DB->GetOne('select count(' . $this->KeyID . ') as Num from ' . $this->TableName . ' ' . $MysqlWhere);
    }

    public function GetLists($MysqlWhere = '', $From = 0, $Pagesize = 10)
    {
        $DB = new DB ();
        return $DB->Select('select * from ' . $this->TableName . ' ' . $MysqlWhere . ' order by ' . $this->KeyID . ' DESC  limit ' . $From . ',' . $Pagesize);
    }

    public function GetOneInfoByArrayKeys($Array = array())
    {
        $DB = new DB ();
        $KeyInfo = array_keys($Array);
        $Where = '1';
        foreach ($KeyInfo As $Value) {
            $Where .= ' and `' . $Value . '`=\'' . $Array[$Value] . '\'';
        }
        return $DB->GetOne('select * from ' . $this->TableName . ' where ' . $Where);
    }

    public function GetBalance($AgentID)
    {
        $DB = new DB ();
        return $DB->GetOne('select Balance from ' . $this->TableName . ' where ' . $this->AgentID . ' = ' . $AgentID);
    }



}
