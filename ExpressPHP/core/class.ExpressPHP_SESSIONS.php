<?php
abstract class ExpressPHP_SESSIONS {
	public $version = '3.0.0';
	protected $variables = array ();
	protected $domains = '';
	protected $path = '/';
	protected $expiretime = 1200;
	protected $prefix = 'nl_';
	protected $hashcode = '1l2y3s';
	protected $timestamp = 0;
	
	public function __construct(){
		$options = $this->__Config();
		foreach ( $options as $key => $value ) {
			if ($key == 'domains' && $value == 'auto') {
				$this->$key = $this->get_cookie_domain();
			} else {
				$this->$key = $value;
			}
		}
		$this->timestamp = time();
	}
	public function __destruct(){
		unset($this);
	}
	abstract protected function __Config();
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
	public function get_cookie_domain(){
		$host_domain = $_SERVER["HTTP_HOST"];
		if (strpos($host_domain, ':') !== false) {
			$host_domain = substr($host_domain, 0, strpos($host_domain, ':'));
		}
		$host_domains = explode(".", $host_domain);
		$host_domains_count = count($host_domains);
		$domain = '';
		for($i = ($host_domains_count - 1); $i > 0; $i --) {
			if ($host_domains[$i]) $domain = ($host_domains_count > 1 ? '.' : '') . $host_domains[$i] . $domain;
		}
		return $domain;
	}
	public function Update($ob_clearn = false){
		if ($ob_clearn) {
			ob_clean();
		}
		$private_hashcode = substr(md5(uniqid(rand(), true)), - 6);
		foreach ( $this->variables as $key => $value ) {
			$value = base64_encode($value . $this->md5($key, $value, $private_hashcode) . $private_hashcode);
			setcookie($this->prefix . $key, $value, $this->timestamp + $this->expiretime, $this->path, $this->domains, $_SERVER['SERVER_PORT'] == 443 ? 1 : 0);
		}
	}
	public function Get($variable){
		global $_COOKIE;
		if (isset($_COOKIE[$this->prefix . $variable])) {
			$strTempCookie = '';
			$strTempCookie = base64_decode($_COOKIE[$this->prefix . $variable]);
			$validate_string = substr($strTempCookie, - 38);
			$validate = substr($validate_string, 0, 32);
			$private_hashcode = substr($validate_string, - 6);
			$value = substr($strTempCookie, 0, - 38);
			unset($strTempCookie);
			if ($validate == $this->md5($variable, $value, $private_hashcode)) {
				$this->variables[$variable] = $value;
				$this->Update();
				return $value;
			}
		}
		return false;
	}
	public function md5($variable, $value, $private_hashcode){
		return md5($this->getenv('HTTP_USER_AGENT') . $this->getIP() . $this->hashcode . $variable . $value . $private_hashcode . $this->domains . $this->path . $this->expiretime);
	}
	public function __get($varibale_name){
		if (isset($this->variables[$varibale_name])) {
			return $this->variables[$varibale_name];
		} else {
			return $this->get($varibale_name);
		}
	}
	public function clear(){
		$this->variables = array ();
	}
	public function __set($varibale_name, $varibale_value){
		$this->variables[$varibale_name] = $varibale_value;
	}
	public function __isset($varibale_name){
		return isset($this->variables[$varibale_name]);
	}
	public function __unset($varibale_name){
		unset($this->variables[$varibale_name]);
	}
}
?>