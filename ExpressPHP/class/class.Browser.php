<?php
class Browser {
	public $HTTP_USER_AGENT;
	public function __construct(&$ip, &$os, &$software, &$version){
		$this->HTTP_USER_AGENT = $this->HTTP_USER_AGENT();
		$ip = $this->getIP();
		$os = $this->getClientOS();
		$this->getClient($software, $version);
	}
	public function getIP(){
		if ($this->getenv('HTTP_CLIENT_IP') && strcasecmp($this->getenv('HTTP_CLIENT_IP'), 'unknown')) {
			$onlineip = $this->getenv('HTTP_CLIENT_IP');
		} elseif ($this->getenv('HTTP_X_FORWARDED_FOR') && strcasecmp($this->getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
			$onlineip = $this->getenv('HTTP_X_FORWARDED_FOR');
		} elseif ($this->getenv('REMOTE_ADDR') && strcasecmp($this->getenv('REMOTE_ADDR'), 'unknown')) {
			$onlineip = $this->getenv('REMOTE_ADDR');
		} elseif (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
			$onlineip = $_SERVER['REMOTE_ADDR'];
		}
		
		preg_match("/[\d\.]{7,15}/", $onlineip, $onlineipmatches);
		$onlineip = $onlineipmatches[0] ? $onlineipmatches[0] : 'unknown';
		unset($onlineipmatches);
		return $onlineip;
	}
	public function getenv($strName){
		$r = NULL;
		if (isset($_SERVER[$strName])) {
			return $_SERVER[$strName];
		} elseif (isset($_ENV[$strName])) {
			return $_ENV[$strName];
		} elseif ($r = getenv($strName)) {
			return $r;
		} elseif (function_exists('apache_getenv') && $r = apache_getenv($strName, true)) {
			return $r;
		}
		return '';
	}
	public function HTTP_USER_AGENT(){
		return $this->getenv('HTTP_USER_AGENT');
	}
	public function getClientOS(){
		$HTTP_USER_AGENT = $this->HTTP_USER_AGENT;
		if (! $HTTP_USER_AGENT) {
			$HTTP_USER_AGENT = '';
		}
		// os
		if (strstr($HTTP_USER_AGENT, 'Win')) {
			return 'Win';
		} elseif (strstr($HTTP_USER_AGENT, 'Mac')) {
			return 'Mac';
		} elseif (strstr($HTTP_USER_AGENT, 'Linux')) {
			return 'Linux';
		} elseif (strstr($HTTP_USER_AGENT, 'Unix')) {
			return 'Unix';
		} elseif (strstr($HTTP_USER_AGENT, 'OS/2')) {
			return 'OS/2';
		} else {
			return 'Other';
		}
	}
	public function getClient(&$USR_BROWSER_AGENT, &$USR_BROWSER_VER){
		$HTTP_USER_AGENT = $this->HTTP_USER_AGENT;
		
		if (! $HTTP_USER_AGENT) {
			$HTTP_USER_AGENT = '';
		}
		
		if (preg_match('@Opera(/| )([0-9].[0-9]{1,2})@', $HTTP_USER_AGENT, $log_version)) {
			$USR_BROWSER_VER = $log_version[2];
			$USR_BROWSER_AGENT = 'OPERA';
		} elseif (preg_match('@MSIE ([0-9].[0-9]{1,2})@', $HTTP_USER_AGENT, $log_version)) {
			$USR_BROWSER_VER = $log_version[1];
			$USR_BROWSER_AGENT = 'IE';
		} elseif (preg_match('@OmniWeb/([0-9].[0-9]{1,2})@', $HTTP_USER_AGENT, $log_version)) {
			$USR_BROWSER_VER = $log_version[1];
			$USR_BROWSER_AGENT = 'OMNIWEB';
		} elseif (preg_match('@(Konqueror/)(.*)(;)@', $HTTP_USER_AGENT, $log_version)) {
			$USR_BROWSER_VER = $log_version[2];
			$USR_BROWSER_AGENT = 'KONQUEROR';
		} elseif (preg_match('@Mozilla/([0-9].[0-9]{1,2})@', $HTTP_USER_AGENT, $log_version) && preg_match('@Safari/([0-9]*)@', $HTTP_USER_AGENT, $log_version2)) {
			$USR_BROWSER_VER = $log_version[1] . '.' . $log_version2[1];
			$USR_BROWSER_AGENT = 'SAFARI';
		} elseif (preg_match('@Mozilla/([0-9].[0-9]{1,2})@', $HTTP_USER_AGENT, $log_version)) {
			$USR_BROWSER_VER = $log_version[1];
			$USR_BROWSER_AGENT = 'MOZILLA';
		} else {
			$USR_BROWSER_VER = 0;
			$USR_BROWSER_AGENT = 'OTHER';
		}
	}
}
?>