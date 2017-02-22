<?php
interface ExpressPHP_CACHE_CORE {
	const NOCACHE = - 19801025;
	const __OneYearSeconds__ = 31536000;
	const __OneMonthSeconds__ = 2592000;
	const __OneDaySeconds__ = 86400;
	const __OneHourSeconds__ = 3600;
	public function Save($CacheID, $Data, $LifeTimeLimit = 0);
	public function Get($CacheID, $dateline = 0);
	public function Drop($CacheID);
	public function Clear();
}
class CacheMysql extends ExpressPHP_MYSQL {
	public function __Config($option = null) {
		return $option;
	}
}
/*
CREATE TABLE `expressphp_mysql_cache` (
  `cacheid` char(32) NOT NULL DEFAULT '',
  `cachename` varchar(255) DEFAULT NULL,
  `data` longtext,
  `expiretime` bigint(15) unsigned NOT NULL DEFAULT '0',
  `lifelimit` bigint(15) unsigned NOT NULL DEFAULT '0',
  `lastmodified` bigint(15) unsigned NOT NULL DEFAULT '0',
  UNIQUE KEY `index_cacheid` (`cacheid`),
  KEY `index` (`lifelimit`,`lastmodified`,`expiretime`),
  KEY `indexes_search` (`expiretime`,`cacheid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
* */
abstract class ExpressPHP_MYSQLCACHE implements ExpressPHP_CACHE_CORE {
	public $Config = array ('host' => null, 'port' => null, 'username' => null, 'password' => null, 'charset' => 'utf-8', 'pconnect' => false, 'dbname' => null );
	private $MysqlObj = null;
	private $timestamp = 0;
	abstract protected function __Config();
	public function __construct() {
		$tmpConfig = $this->__Config ();
		if (is_array ( $tmpConfig )) {
			foreach ( $tmpConfig as $key => $value ) {
				$this->Config [$key] = $value;
			}
		}
		unset ( $tmpConfig );
		$this->MysqlObj = new CacheMysql ( );
		$this->MysqlObj->__Config ( $this->Config );
		$this->MysqlObj->Connect ();
		$this->timestamp = time ();
	}
	public function __destruct() {
		unset ( $this );
	}
	public function Save($CacheID, $Data, $LifeTimeLimit = 0) {
		if ($LifeTimeLimit < $this->timestamp)
			$LifeTimeLimit = $this->timestamp + $LifeTimeLimit;
		if ($LifeTimeLimit <= 0)
			return false;
		$HashCacheID = $this->Hash ( $CacheID );
		$LastModified = $this->timestamp;
		$ExpireTime = $LifeTimeLimit;
		$Data = json_encode ( $Data );
		$this->MysqlObj->delete ( 'delete from expressphp_mysql_cache where cacheid=\'' . $HashCacheID . '\'' );
		$sql = sprintf ( 'replace into `expressphp_mysql_cache`(`cacheid`, `cachename`, `data`, `expiretime`, `lifelimit`, `lastmodified`) values(\'%s\', \'%s\', \'%s\', \'%d\', \'%d\', \'%d\')', $HashCacheID, $CacheID, mysql_escape_string ( $Data ), $ExpireTime, $LifeTimeLimit, $LastModified );
		return $this->MysqlObj->insert ( $sql );
	}
	public function Get($CacheID, $dateline = 0) {
		$HashCacheID = $this->Hash ( $CacheID );
		$this->obj->delete ( 'delete from expressphp_mysql_cache where expiretime<' . $this->timestamp );
		if (! $dateline)
			$sql = 'select `cacheid`, `data`, `expiretime` from `expressphp_mysql_cache` where `cacheid`=\'' . $HashCacheID . '\'';
		else
			$sql = 'select `cacheid`, `data`, `expiretime` from `expressphp_mysql_cache` where `cacheid`=\'' . $HashCacheID . '\'';
		$result = $this->obj->getone ( $sql );
		
		if (is_array ( $result )) {
			if (! $result ['data'] || $result ['data'] == 'false' || $result ['data'] == 'null')
				return self::NOCACHE;
			$data = json_decode ( $result ['data'], true );
			if ($result ['expiretime'] > $this->timestamp)
				return is_array ( $data ) ? $data : self::NOCACHE;
			else {
				$this->Drop ( $CacheID );
				return self::NOCACHE;
			}
		} else
			return self::NOCACHE;
	}
	public function Drop($CacheID) {
		return $this->MysqlObj->delete ( 'delete from expressphp_mysql_cache where cacheid=\'' . $this->Hash ( $CacheID ) . '\'' );
	}
	public function Clear() {
		return $this->MysqlObj->delete ( 'delete from expressphp_mysql_cache where 1' );
	}
	private function Hash($string) {
		return hash ( 'md5', $string );
	}
}
abstract class ExpressPHP_MEMCHACHE implements ExpressPHP_CACHE_CORE {
	public $Config = array ('Host' => 'localhost', 'Port' => 11211, 'TimeOut' => 5, 'HashType' => 'adler32' );
	private $MemcacheOBJ = null;
	private $timestamp = 0;
	abstract protected function __Config();
	public function __construct() {
		$tmpConfig = $this->__Config ();
		if (is_array ( $tmpConfig )) {
			foreach ( $tmpConfig as $key => $value ) {
				$this->Config [$key] = $value;
			}
		}
		unset ( $tmpConfig );
		if (! $this->Config ['Host'] || ! $this->Config ['Port'])
			return false;
		$this->MemcacheOBJ = new Memcache ( );
		$this->timestamp = time ();
		return $this->MemcacheOBJ->pconnect ( $this->Config ['Host'], $this->Config ['Port'], $this->Config ['TimeOut'] );
	}
	public function __destruct() {
		unset ( $this );
	}
	public function Save($CacheID, $Data, $LifeTimeLimit = 0) {
		if ($LifeTimeLimit < $this->timestamp)
			$LifeTimeLimit = $this->timestamp + $LifeTimeLimit;
		if ($LifeTimeLimit <= 0)
			return false;
		$cache ['cacheid'] = $CacheID;
		$cache ['LastModified'] = $this->timestamp;
		$cache ['LifeTimeLimit'] = $LifeTimeLimit;
		$cache ['data'] = $Data;
		$result = $this->MemcacheOBJ->Set ( $CacheID, $cache, MEMCACHE_COMPRESSED, $LifeTimeLimit );
		return $result;
	}
	public function Get($CacheID, $dateline = 0) {
		$cache = $this->MemcacheOBJ->get ( $CacheID );
		if (! is_array ( $cache )) {
			return self::NOCACHE;
		} else {
			if ($dateline && $cache ['LifeTimeLimit'] < $dateline) {
				return self::NOCACHE;
			} elseif ($cache ['LifeTimeLimit'] < $this->timestamp) {
				return self::NOCACHE;
			} else {
				return $cache ['data'];
			}
		}
	}
	public function Drop($CacheID) {
		if (is_array ( $CacheID )) {
			foreach ( $CacheID as $CacheIDList ) {
				$this->Drop ( $CacheIDList );
			}
		}
		return $this->MemcacheOBJ->delete ( $CacheID );
	}
	public function Clear() {
		return $this->MemcacheOBJ->flush ();
	}
}

abstract class ExpressPHP_CACHE_FILE implements ExpressPHP_CACHE_CORE {
	public $Config = array ('SavePath' => null, 'HashType' => 'adler32', 'HashLevel' => 2 );
	private $timestamp = 0;
	/**
	 * ExpressPHP 文件缓存类配置函数
	 * 函数返回一个数组类型参数, 参数如下
	 * array(
	 * 	'SavePath' => 'f:/wwwroot/data/cache',  // Cache文件保存目录
	 * 	'HashType' => 'md5', //CacheID的保密方法, 可选 md5, adler32,crc32  默认为adler32
	 * 	'HashLevel'=> 3 //Cache文件根据CacheID字段串分割目录级别保存
	 * )
	 * example:
	 * class CacheFile extends ExpressPHP_CACHE_FILE {
	 * 	protected function __Config() {
	 * 		global $cache_config;
	 * 		return $cache_config;
	 * 	}
	 * }
	 */
	abstract protected function __Config();
	public function __construct() {
		$tmpConfig = $this->__Config ();
		if (is_array ( $tmpConfig )) {
			foreach ( $tmpConfig as $key => $value ) {
				$this->Config [$key] = $value;
			}
		}
		unset ( $tmpConfig );
		$this->timestamp = time ();
	}
	public function __destruct() {
		unset ( $this );
	}
	/**
	 * 保存Cache数据
	 *
	 * @param string $CacheID
	 * @param string or array $Data
	 * @param int $LifeTimeLimit
	 * @return boolean
	 */
	public function Save($CacheID, $Data, $LifeTimeLimit = 0) {
		if ($LifeTimeLimit < $this->timestamp)
			$LifeTimeLimit = $this->timestamp + $LifeTimeLimit;
		
		$path = $this->GetPath ( $CacheID, true );
		if (! $path)
			return false;
		if ($LifeTimeLimit <= 0)
			return false;
		$cache ['cacheid'] = $CacheID;
		$cache ['LastModified'] = $this->timestamp;
		$cache ['LastModified_string'] = date ( 'Y-m-d H:i:s', $this->timestamp );
		$cache ['LifeTimeLimit'] = $LifeTimeLimit;
		$cache ['LifeTimeLimit_string'] = date ( 'Y-m-d H:i:s', $LifeTimeLimit );
		
		$cache ['data'] = $Data;
		foreach ( $cache as $key => $value ) {
			$cache_code .= '$cache[' . $key . ']=' . var_export ( $value, true ) . ";\r\n";
		}
		$source = '<?php ' . "\r\n //Create by Cache File Class!\r\n" . $cache_code . "?>";
		$filename = $this->Hash ( $CacheID ) . '.php.cache';
		$path .= '/' . $filename;
		clearstatcache ();
		$result = $this->_filePutContents ( $path, $source );
		if ($result) {
			return true;
		} else
			return false;
	}
	/**
	 * 获取Cache数据
	 *
	 * @param string $CacheID
	 * @param int $dateline
	 * @return unknown
	 */
	public function Get($CacheID, $dateline = 0) {
		$path = $this->GetPath ( $CacheID );
		$filename = $this->Hash ( $CacheID ) . '.php.cache';
		$path .= $filename;
		if (file_exists ( $path ) && is_file ( $path )) {
			$cache = false;
			include $path;
			if (! is_array ( $cache )) {
				return self::NOCACHE;
			} else {
				if ($dateline && $cache ['LifeTimeLimit'] < $dateline) {
					return self::NOCACHE;
				} else if ($cache ['LifeTimeLimit'] < $this->timestamp) {
					return self::NOCACHE;
				} else {
					return $cache ['data'];
				}
			}
		} else {
			return self::NOCACHE;
		}
	}
	public function Drop($CacheID) {
		clearstatcache ();
		if (is_array ( $CacheID )) {
			foreach ( $CacheID as $CacheIDList ) {
				$this->Drop ( $CacheIDList );
			}
		} else {
			$path = $this->GetPath ( $CacheID ) . '/' . $this->Hash ( $CacheID ) . '.php';
			if (file_exists ( $path ) && is_file ( $path )) {
				if (@unlink ( $path )) {
					return true;
				} else {
					return false;
				}
			} else {
				return true;
			}
		}
		return false;
	}
	public function Clear() {
		return $this->_ClearPath ();
	}
	private function _ClearPath($path = null) {
		clearstatcache ();
		$strCurrentPath = $path ? $path : $this->Config ['SavePath'];
		if (! $strCurrentPath || ! file_exists ( $strCurrentPath ) || ! is_dir ( $strCurrentPath )) {
			return false;
		}
		$d = dir ( $strCurrentPath );
		while ( false !== ($entry = $d->read ()) ) {
			if ($entry != "." && $entry != "..") {
				if (is_dir ( $strCurrentPath . '/' . $entry )) {
					$this->_ClearPath ( $strCurrentPath . '/' . $entry );
					if (! @rmdir ( $strCurrentPath . '/' . $entry ))
						return false;
				}
				if (is_file ( $strCurrentPath . '/' . $entry )) {
					if (! @unlink ( $strCurrentPath . '/' . $entry ))
						return false;
				}
			}
		}
		$d->close ();
		unset ( $d );
		return true;
	}
	private function _fileGetContents($file) {
		$result = false;
		if (! is_file ( $file )) {
			return false;
		}
		if (function_exists ( 'get_magic_quotes_runtime' )) {
			$mqr = @get_magic_quotes_runtime ();
			@set_magic_quotes_runtime ( 0 );
		}
		$f = @fopen ( $file, 'rb' );
		if ($f) {
			@flock ( $f, LOCK_SH );
			$result = stream_get_contents ( $f );
			@flock ( $f, LOCK_UN );
			@fclose ( $f );
		}
		if (function_exists ( 'set_magic_quotes_runtime' )) {
			@set_magic_quotes_runtime ( $mqr );
		}
		return $result;
	}
	private function _filePutContents($file, $string) {
		$result = false;
		$f = @fopen ( $file, 'ab+' );
		if ($f) {
			@flock ( $f, LOCK_EX );
			fseek ( $f, 0 );
			ftruncate ( $f, 0 );
			$tmp = @fwrite ( $f, $string );
			if (! ($tmp === FALSE)) {
				$result = true;
			}
			@fclose ( $f );
		}
		@chmod ( $file, 0777 );
		return $result;
	}
	private function Hash($Data) {
		return hash ( $this->Config ['HashType'], $Data );
	}
	private function GetPath($CacheID, $mode = false) {
		$root = $this->Config ['SavePath'] . '/';
		$level = $this->Config ['HashLevel'];
		if ($level > 0) {
			$hash = $this->Hash ( $CacheID );
			$length = ceil ( strlen ( $hash ) / $level );
			for($i = 0; $i < $level; $i ++) {
				$root = $root . substr ( $hash, $i * $length, $length );
				if ($mode && ! file_exists ( $root )) {
					if (! @mkdir ( $root, 0777 )) {
						return false;
					}
				}
				$root .= '/';
			}
		}
		return $root;
	}
}

?>