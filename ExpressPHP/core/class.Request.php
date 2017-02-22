<?php
class Request {
	public function __construct() {
		if ($_POST) $_POST = $this->__addslashes ( $_POST );
		if ($_GET) $_GET = $this->__addslashes ( $_GET );
		if ($_FILES) $_FILES = $this->__addslashes ( $_FILES );
		if ($_COOKIE) $_COOKIE = $this->__addslashes ( $_COOKIE );
		if ($_SESSION) $_SESSION = $this->__addslashes ( $_SESSION );
	}
	public function __destruct(){
		if ($_POST) unset($_POST);
		if ($_GET) unset($_GET);
		if ($_FILES) unset($_FILES);
		if ($_COOKIE) unset($_COOKIE);
		if ($_SESSION) unset($_SESSION);
		unset($this);
	}
	public function GET($name) {
		return $_GET[$name];
	}
	public function POST($name) {
		return $_POST[$name];
	}
	public function FILE($name) {
		return $_FILES[$name];
	}
	public function COOKIE($name) {
		return $_COOKIE[$name];
	}
	public function SESSION($name) {
		return $_SESSION[$name];
	}
	public function SERVER($name) {
		return $_SERVER[$name];
	}
	public function ENV($name) {
		return $this->GetEnv($name);
	}
	public function HTTP_USER_AGENT() {
		return $this->GetEnv ( 'HTTP_USER_AGENT' );
	}
	public function ClientOS() {
		$HTTP_USER_AGENT = $this->HTTP_USER_AGENT ();
		if (! $HTTP_USER_AGENT) {
			$HTTP_USER_AGENT = '';
		}
		// os
		if (strstr ( $HTTP_USER_AGENT, 'Win' )) {
			return 'Win';
		} elseif (strstr ( $HTTP_USER_AGENT, 'Mac' )) {
			return 'Mac';
		} elseif (strstr ( $HTTP_USER_AGENT, 'Linux' )) {
			return 'Linux';
		} elseif (strstr ( $HTTP_USER_AGENT, 'Unix' )) {
			return 'Unix';
		} elseif (strstr ( $HTTP_USER_AGENT, 'OS/2' )) {
			return 'OS/2';
		} else {
			return 'Other';
		}
	}
	public function USR_BROWSER_AGENT() {
		$HTTP_USER_AGENT = $this->HTTP_USER_AGENT ();
		if (! $HTTP_USER_AGENT) {
			$HTTP_USER_AGENT = '';
		}
		if (preg_match ( '@Opera(/| )([0-9].[0-9]{1,2})@', $HTTP_USER_AGENT, $log_version )) {
			$USR_BROWSER_VER = $log_version[2];
			$USR_BROWSER_AGENT = 'OPERA';
		} elseif (preg_match ( '@MSIE ([0-9].[0-9]{1,2})@', $HTTP_USER_AGENT, $log_version )) {
			$USR_BROWSER_VER = $log_version[1];
			$USR_BROWSER_AGENT = 'IE';
		} elseif (preg_match ( '@OmniWeb/([0-9].[0-9]{1,2})@', $HTTP_USER_AGENT, $log_version )) {
			$USR_BROWSER_VER = $log_version[1];
			$USR_BROWSER_AGENT = 'OMNIWEB';
		} elseif (preg_match ( '@(Konqueror/)(.*)(;)@', $HTTP_USER_AGENT, $log_version )) {
			$USR_BROWSER_VER = $log_version[2];
			$USR_BROWSER_AGENT = 'KONQUEROR';
		} elseif (preg_match ( '@Mozilla/([0-9].[0-9]{1,2})@', $HTTP_USER_AGENT, $log_version ) && preg_match ( '@Safari/([0-9]*)@', $HTTP_USER_AGENT, $log_version2 )) {
			$USR_BROWSER_VER = $log_version[1] . '.' . $log_version2[1];
			$USR_BROWSER_AGENT = 'SAFARI';
		} elseif (preg_match ( '@Mozilla/([0-9].[0-9]{1,2})@', $HTTP_USER_AGENT, $log_version )) {
			$USR_BROWSER_VER = $log_version[1];
			$USR_BROWSER_AGENT = 'MOZILLA';
		} else {
			$USR_BROWSER_VER = 0;
			$USR_BROWSER_AGENT = 'OTHER';
		}
		return $USR_BROWSER_AGENT;
	}
	public function USR_BROWSER_VER() {
		$HTTP_USER_AGENT = $this->HTTP_USER_AGENT ();
		
		if (! $HTTP_USER_AGENT) {
			$HTTP_USER_AGENT = '';
		}
		if (preg_match ( '@Opera(/| )([0-9].[0-9]{1,2})@', $HTTP_USER_AGENT, $log_version )) {
			$USR_BROWSER_VER = $log_version[2];
			$USR_BROWSER_AGENT = 'OPERA';
		} elseif (preg_match ( '@MSIE ([0-9].[0-9]{1,2})@', $HTTP_USER_AGENT, $log_version )) {
			$USR_BROWSER_VER = $log_version[1];
			$USR_BROWSER_AGENT = 'IE';
		} elseif (preg_match ( '@OmniWeb/([0-9].[0-9]{1,2})@', $HTTP_USER_AGENT, $log_version )) {
			$USR_BROWSER_VER = $log_version[1];
			$USR_BROWSER_AGENT = 'OMNIWEB';
		} elseif (preg_match ( '@(Konqueror/)(.*)(;)@', $HTTP_USER_AGENT, $log_version )) {
			$USR_BROWSER_VER = $log_version[2];
			$USR_BROWSER_AGENT = 'KONQUEROR';
		} elseif (preg_match ( '@Mozilla/([0-9].[0-9]{1,2})@', $HTTP_USER_AGENT, $log_version ) && preg_match ( '@Safari/([0-9]*)@', $HTTP_USER_AGENT, $log_version2 )) {
			$USR_BROWSER_VER = $log_version[1] . '.' . $log_version2[1];
			$USR_BROWSER_AGENT = 'SAFARI';
		} elseif (preg_match ( '@Mozilla/([0-9].[0-9]{1,2})@', $HTTP_USER_AGENT, $log_version )) {
			$USR_BROWSER_VER = $log_version[1];
			$USR_BROWSER_AGENT = 'MOZILLA';
		} else {
			$USR_BROWSER_VER = '';
			$USR_BROWSER_AGENT = 'OTHER';
		}
		return $USR_BROWSER_VER;
	}
	public function IP() {
		if ($this->GetEnv ( 'HTTP_CLIENT_IP' ) && strcasecmp ( $this->GetEnv ( 'HTTP_CLIENT_IP' ), 'unknown' )) {
			$onlineip = $this->GetEnv ( 'HTTP_CLIENT_IP' );
		} elseif ($this->GetEnv ( 'HTTP_X_FORWARDED_FOR' ) && strcasecmp ( $this->GetEnv ( 'HTTP_X_FORWARDED_FOR' ), 'unknown' )) {
			$onlineip = $this->GetEnv ( 'HTTP_X_FORWARDED_FOR' );
		} elseif ($this->GetEnv ( 'REMOTE_ADDR' ) && strcasecmp ( $this->GetEnv ( 'REMOTE_ADDR' ), 'unknown' )) {
			$onlineip = $this->GetEnv ( 'REMOTE_ADDR' );
		} elseif (isset ( $_SERVER['REMOTE_ADDR'] ) && $_SERVER['REMOTE_ADDR'] && strcasecmp ( $_SERVER['REMOTE_ADDR'], 'unknown' )) {
			$onlineip = $_SERVER['REMOTE_ADDR'];
		}
		
		preg_match ( "/[\d\.]{7,15}/", $onlineip, $onlineipmatches );
		$onlineip = $onlineipmatches[0] ? $onlineipmatches[0] : 'unknown';
		unset ( $onlineipmatches );
		return $onlineip;
	}
	public function GetEnv($strName) {
		$r = NULL;
		if (isset ( $_SERVER[$strName] )) {
			return $_SERVER[$strName];
		} elseif (isset ( $_ENV[$strName] )) {
			return $_ENV[$strName];
		} elseif ($r = getenv ( $strName )) {
			return $r;
		} elseif (function_exists ( 'apache_getenv' ) && $r = apache_getenv ( $strName, true )) {return $r;}
		return '';
	}
	public function __addslashes($string, $force = 0) {
		! defined ( 'MAGIC_QUOTES_GPC' ) && define ( 'MAGIC_QUOTES_GPC', get_magic_quotes_gpc () );
		if (! MAGIC_QUOTES_GPC || $force) {
			if (is_array ( $string )) {
				foreach ( $string as $key => $val ) {
					$string[$key] = $this->__addslashes ( $val, $force );
				}
			} else {
				$string = addslashes ( $string );
			}
		}
		return $string;
	}
	public function ValidateString(&$String, $Pattern = '', $MinLength = 0, $MaxLength = 0) {
		$String = trim ( $String );
		if ($Pattern) {
			if (! preg_match ( $Pattern, $String )) return false;
		}
		if ($MinLength > 0 && strlen ( $String ) < $MinLength) {return false;}
		if ($MaxLength > 0 && strlen ( $String ) > $MaxLength) {return false;}
		return true;
	}
	public function ValidateNumber(&$Number, $unsigned = false, $Min = null, $Max = null) {
		if (is_string ( $Number )) $Number = trim ( $Number );
		if ($unsigned) $Pattern = "/^([0-9]+)(|\.)([0-9]+)$/";
		else $Pattern = "/^(|\-)([0-9]+)(|\.)([0-9]+)$/";
		if (! preg_match ( $Pattern, $Number )) return false;
		if ($Min !== null && $Number < $Min) {return false;}
		if ($Max !== null && $Number > $Max) {return false;}
		return true;
	}
	
	public function ValidateInt(&$Number, $unsigned = false, $Min = null, $Max = null) {
		if (is_string ( $Number )) $Number = trim ( $Number );
		$Number = intval ( $Number );
		if ($unsigned && $Number < 0) return false;
		if ($Min !== null && $Number < $Min) {return false;}
		if ($Max !== null && $Number > $Max) {return false;}
		return true;
	}
	public function ValidateEmail(&$email) {
		$email = trim ( $email );
		return strlen ( $email ) > 6 && preg_match ( "/^[\w\-\.]+@[\w\-]+(\.\w+)+$/", $email );
	}
	public function ValidateDomain(&$Domain) {
		$Domain = trim ( $Domain );
		if (! $Domain) return false;
		if (substr ( $Domain, 0, 7 ) != 'http://' && substr ( $Domain, 0, 7 ) != 'https://') {
			$Domain = 'http://' . $Domain;
		}
		if (preg_match ( "/^(http|https):\/\/([a-z0-9_\-\/\.]+)(.*)/i", $Domain )) {
			return true;
		} else
			return false;
	}
}