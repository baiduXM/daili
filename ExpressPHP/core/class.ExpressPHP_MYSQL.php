<?php
/**
 * MYSQL for Database Driver version 2.0.1
 * Developer : Necylus@126.com  , Copyright(C)Grayant.com.
 * Last Modified: 2009-03-13
 *
 */
abstract class ExpressPHP_MYSQL {
	public $connectid = null;
	public $option = array ();
	public $server_version = '';
	public $table_pre = '';
	public $querycounts = 0;
	public $autocommit = true;
	public $sql = null;
	public $errorString = null;
	
	public function __construct() {
		$option = $this->__Config ();
		if (is_array ( $option )) {
			$this->option ['host'] = ($option ['host'] ? $option ['host'] : 'localhost') . ':' . ($option ['port'] ? $option ['port'] : '3306');
			$this->option ['username'] = substr ( $option ['username'], 0, 16 );
			$this->option ['password'] = $option ['password'];
			if ($option ['charset'])
				$this->option ['charset'] = $option ['charset'] ? str_replace ( '-', '', $option ['charset'] ) : 'utf8';
			$this->option ['pconnect'] = $option ['pconnect'] ? 1 : 0;
			$this->option ['dbname'] = substr ( $option ['dbname'], 0, 16 );
			return $this->connectid = $this->Connect ();
		}
	}
	public function __destruct() {
		unset ( $this );
	}
	/**
	 * 初始化目标数据库参数
	 *  array(
	 * 		'host' => '主机',
	 * 		'port' => 'mysql端口',
	 * 		'username' => 'mysql用户',
	 * 		'password' => 'mysql用户密码',
	 * 		'charset' =>'目标数据库字符集',
	 * 		'pconnect' =>'是否开启持久性连接数据库',
	 * 		'dbname' => '数据库名称'
	 * 	)
	 */
	abstract public function __Config($option = null);
	
	public function Connect() {
		if ($this->option ['pconnect'])
			$this->connectid = mysql_pconnect ( $this->option ['host'], $this->option ['username'], $this->option ['password'] );
		else
			$this->connectid = mysql_connect ( $this->option ['host'], $this->option ['username'], $this->option ['password'] );
		if (! $this->connectid) {
			return false;
		}
		if (! $this->option ['dbname'])
			return $this->connectid;
		if (! $this->SelectDb ( $this->option ['dbname'] )) {
			return false;
		}
		if ($this->option ['charset']) {
			$this->server_version = $this->ServerVersion ();
			if ($this->server_version > '4.1') {
				$sql = 'SET character_set_connection=' . $this->option ['charset'] . ', character_set_results=' . $this->option ['charset'] . ', character_set_client=binary';
			}
			if ($this->server_version > '5.0.1')
				$sql .= ", sql_mode=''";
			$this->Query ( $sql );
			return $this->connectid;
		}
		return $this->connectid;
	}
	public function Error() {
		if ($this->errorString)
			return $this->errorString;
		else
			return $this->connect ? mysql_error ( $this->connectid ) : mysql_error ();
	}
	public function Errno() {
		return $this->connectid ? mysql_errno ( $this->connectid ) : mysql_errno ();
	}
	
	public function SelectDb($dbname) {
		return mysql_select_db ( $dbname, $this->connectid );
	}
	
	public function ServerVersion() {
		if (empty ( $this->server_version )) {
			$this->server_version = mysql_get_server_info ( $this->connectid );
		}
		return $this->server_version;
	}
	public function escape_string($string){
		return mysql_escape_string($string);
	}
	public function Query($sql) {
		$this->sql = $sql;
		$query = mysql_query ( $sql, $this->connectid ) or $this->Halt ();
		$this->querycounts ++;
		return $query;
	}
	public function FreeResult($result) {
		return mysql_free_result ( $result );
	}
	/**
	 * 获取指定的SQL查询第一条结果
	 *
	 * @param string $sql
	 * @return array or int
	 */
	public function GetOne($sql) {
		if (! strstr ( strtolower ( $sql ), "limit" )) {
			$sql .= " LIMIT 0,1";
		}
		$result = $this->query ( $sql );
		if ($result) {
			$r = mysql_fetch_assoc ( $result );
			$this->FreeResult ( $result );
			return $r;
		} else
			return false;
	}
	/**
	 * 查询sql语句并获取结果,并以数组形式返回
	 *
	 * @param string $sql	SQL语句
	 * @param int $limit_row_offset  记录起始号
	 * @param int  $limit_row_count	 记录数
	 * @return array or int
	 */
	public function Select($sql, $limit_row_offset = null, $limit_row_count = null, $rowid = false) {
		$limit_row_offset = intval ( $limit_row_offset );
		$limit_row_count = intval ( $limit_row_count );
		if (! strstr ( $sql, 'limit' ) && $limit_row_count) {
			$sql .= " LIMIT " . $limit_row_offset . "," . $limit_row_count;
		}
		$result = $this->Query ( $sql );
		if ($result) {
			$i = 1;
			while ( $rows = mysql_fetch_assoc ( $result ) ) {
				if ($rowid)
					$rows ['__rowid__'] = $i;
				$rowdatas [] = $rows;
				$i ++;
			}
			$this->FreeResult ( $result );
			return $rowdatas;
		}
		
		$this->FreeResult ( $result );
		return false;
	}
	/**
	 * 插入语句函数
	 *
	 * @param string $sql
	 * @param Booleans $get_last_insertid
	 * @return int
	 */
	public function Insert($sql, $get_last_insertid = false) {
		$result = $this->Query ( $sql );
		if ($result) {
			return ($get_last_insertid ? $this->LastInsertId () : $result);
		} else {
			return false;
		}
	}
	/**
	 * 获得最后插入ID,须数据库支持
	 *
	 * @return int
	 */
	public function LastInsertId() {
		return ($id = mysql_insert_id ( $this->connectid )) >= 0 ? $id : $this->Result ( $this->Query ( "SELECT last_insert_id()" ), 0 );
	}
	
	public function Result($sql, $row = 0) {
		$result = $this->Query($sql);
		if(!$result)
			return false;
		if(mysql_num_rows($result)){
			$query = mysql_result ( $result, $row );
			return $query;
		}
		else {
			return false;
		}
	}
	/**
	 * 插入数组数据到数据表
	 *
	 * @param string $tablename
	 * @param array $arrData
	 * @param booleans $get_last_insertid
	 * @return int
	 */
	public function insertArray($tablename, $arrData, $get_last_insertid = false) {
		if (! $tablename || ! is_array ( $arrData ) || ! count ( $arrData )) {
			return false;
		}
		$sql_field_names = $sql_field_values = null;
		foreach ( $arrData as $fieldname => $fieldvalue ) {
			$sql_field_names .= '`' . $fieldname . '`,';
			if (is_numeric ( $fieldvalue ))
				$sql_field_values .= "'" . $fieldvalue . "',";
			else
				$sql_field_values .= "'" .  ( $fieldvalue ) . "',";
		}
		$sql_field_names = substr ( $sql_field_names, 0, - 1 );
		$sql_field_values = substr ( $sql_field_values, 0, - 1 );
		$sql = "INSERT INTO `{$tablename}`({$sql_field_names}) VALUES({$sql_field_values})";
		return $this->Insert ( $sql, $get_last_insertid );
	}
	
	public function ReplaceArray($tablename, $arrData, $get_last_insertid = false) {
		if (! $tablename || ! is_array ( $arrData ) || ! count ( $arrData )) {
			return false;
		}
		$sql_field_names = $sql_field_values = null;
		foreach ( $arrData as $fieldname => $fieldvalue ) {
			$sql_field_names .= '`' . $fieldname . '`,';
			$sql_field_values .= "'{$fieldvalue}',";
		}
		$sql_field_names = substr ( $sql_field_names, 0, - 1 );
		$sql_field_values = substr ( $sql_field_values, 0, - 1 );
		$sql = "REPLACE INTO `{$tablename}`({$sql_field_names}) VALUES({$sql_field_values})";
		return $this->Insert ( $sql, $get_last_insertid );
	}
	/**
	 * 执行更新语句
	 *
	 * @param string $sql
	 * @return int 成功将返回更新的记录数
	 */
	public function Update($sql) {
		return $this->Execute ( $sql );
	}
	public function InsertUpdate($table, $arrData, $where) {
		if (! $where)
			return false;
		$sql = "SELECT * FROM `{$table}` WHERE " . $where;
		$rs = $this->GetOne ( $sql );
		if ($rs) {
			return $this->UpdateWhere ( $table, $arrData, $where );
		} else {
			return $this->InsertArray ( $table, $arrData );
		}
	}
	public function UpdateWhere($tablename, $arrData, $where = '') {
		if (! $tablename || ! is_array ( $arrData ) || ! count ( $arrData )) {
			return false;
		}
		if ($where)
			$where = 'WHERE ' . $where;
		else
			$where = '';
		$sql_ext = null;
		foreach ( $arrData as $fieldname => $fieldvalue ) {
			if ($fieldvalue === null) {
				$sql_ext .= ($sql_ext ? "," : "") . "`{$fieldname}` = null";
			} else {
				$sql_ext .= ($sql_ext ? "," : "") . "`{$fieldname}` = '" .  ( $fieldvalue ) . "'";
			}
		}
		$sql = "UPDATE `{$tablename}` SET {$sql_ext} {$where}";
		$result = $this->Update ( $sql );
		return $result;
	}
	/**
	 * 执行数组形式的更新
	 *
	 * @param string $tablename 表名
	 * @param array $arrData	数据数组
	 * @param array $filters 条件语句
	 * @return int 成功将返回更新的记录数
	 */
	public function UpdateArray($tablename, $arrData, $filters = array()) {
		if (! $tablename || ! is_array ( $arrData ) || ! count ( $arrData ) || ! is_array ( $filters ) || ! count ( $filters )) {
			return false;
		}
		if (count ( $filters ))
			$where = $this->Filters ( $filters );
		else
			$where = '';
		$sql_ext = null;
		foreach ( $arrData as $fieldname => $fieldvalue ) {
			if ($fieldvalue === null) {
				$sql_ext .= ($sql_ext ? "," : "") . "`{$fieldname}` = null";
			} else {
				$sql_ext .= ($sql_ext ? "," : "") . "`{$fieldname}` = '" .  ( $fieldvalue ) . "'";
			}
		}
		$sql = "UPDATE `$tablename` SET {$sql_ext} {$where}";
		//echo $sql;exit;
		$result = $this->Update ( $sql );
		
		return $result;
	}
	/**
	 * 开启事务
	 * @return int 失败返回常量FAILED 成功 返回 SUCCESS
	 */
	public function BeginTransaction() {
		if (mysql_query ( "SET AUTOCOMMIT=0", $this->connectid )) {
			$this->autocommit = false;
			return true;
		} else
			return false;
	}
	public function EndTransaction() {
		if (mysql_query ( "SET AUTOCOMMIT=1", $this->connectid )) {
			$this->autocommit = true;
			return true;
		} else
			return false;
	}
	
	/**
	 * 实施事务
	 * @return int 失败返回常量FAILED 成功 返回 SUCCESS
	 */
	public function Commit() {
		if (! $this->autocommit)
			return mysql_query ( "COMMIT", $this->connectid );
		else
			return true;
	}
	/**
	 * 事务回滚, 取消实施
	 * @return int 失败返回常量FAILED 成功 返回 SUCCESS
	 */
	public function RollBack() {
		if (! $this->autocommit)
			return mysql_query ( "ROLLBACK", $this->connectid );
		else {
			return false;
		}
	}
	/**
	 * 自动生成条件语句
	 *
	 * @param array $filters
	 * @return string
	 */
	public function Filters($filters) {
		$sql_where = '';
		if (is_array ( $filters )) {
			foreach ( $filters as $f => $v ) {
				$f_type = gettype ( $v );
				if ($f_type == 'array') {
					$sql_where .= ($sql_where ? " AND " : "") . "(`{$f}` " . $v ['operator'] . " '" . $v ['value'] . "')";
				}else {
					$sql_where .= ($sql_where ? " AND " : "") . "(`{$f}` = '{$v}')";
				}
			}
		} elseif (strlen ( $filters )) {
			$sql_where = $filters;
		} else
			return '';
		$sql_where = $sql_where ? " WHERE " . $sql_where : '';
		return $sql_where;
	}
	public function Multi($recordcount, $page, $pagecount, $pagesize) {
		$data ['recordcount'] = $recordcount;
		$data ['firstpage'] = 1;
		$data ['lastpage'] = $pagecount;
		$data ['backpage'] = ($page > 1) ? $page - 1 : 1;
		$data ['nextpage'] = ($page < $pagecount) ? $page + 1 : $pagecount;
		$data ['limit_start'] = ($page - 1) * $pagesize + 1;
		$data ['limit_end'] = $page * $pagesize;
		return $data;
	}
	/**
	 * 执行删除语句专用函数
	 *
	 * @param string $sql
	 * @return int
	 */
	public function Delete($sql) {
		return $this->Execute ( $sql );
	}
	/**
	 * 执行sql语句
	 *
	 * @param string $sql
	 * @return int
	 */
	public function Execute($sql) {
		$result = $this->Query ( $sql );
		$syntax = strtolower ( substr ( $sql, 0, strpos ( $sql, ' ' ) ) );
		$syntax_affected_rows = array ("delete" => 'mysql_affected_rows', "insert" => 'mysql_affected_rows', 'replace' => 'mysql_affected_rows', 'update' => 'mysql_affected_rows' );
		$syntax_num_rows = array ('select' => 'mysql_num_rows' );
		if ($syntax_affected_rows [$syntax]) {
			//return $result ? $syntax_affected_rows [$syntax] ( $this->connectid ) : $result;
			//修改后
			return $result ? $syntax_affected_rows [$syntax] ( $this->connectid )?$syntax_affected_rows [$syntax] ( $this->connectid ) : $syntax_affected_rows [$syntax] ( $this->connectid )== mysql_errno()?true:$syntax_affected_rows [$syntax] ( $this->connectid ) : $result;
		} elseif ($syntax_num_rows [$syntax])
			return $result ? $syntax_num_rows [$syntax] ( $result ) : $result;
		else
			return $result;
	}
	public function RunSQL($sql) {
		$result = mysql_query ( $sql, $this->connectid );
		return $result;
	}
	public function Halt($errno = null, $error = null) {
		if (! $errno)
			$errno = $this->connectid ? mysql_errno ( $this->connectid ) : mysql_errno ();
		if (! $error)
			$error = $this->connectid ? mysql_error ( $this->connectid ) : mysql_error ();
		throw new Exception ( "[MYSQL-{$errno}]" . $error . "\n[SQL]\n" . $this->sql, E_USER_ERROR );
	}
}
?>