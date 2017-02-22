<?php

define( 'ExpressPHP_USER_AGENT_IE8', ' Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; Trident/4.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; CIBA)' );
define( 'ExpressPHP_Cache_Control_NOCACHE', 'no-cache' );
define( 'ExpressPHP_Cache_Control_PUBLIC', 'Public' );
define( 'ExpressPHP_Accept_ALL', 'image/jpeg, application/x-ms-application, image/gif, application/xaml+xml, image/pjpeg, application/x-ms-xbap, application/x-shockwave-flash, application/vnd.ms-excel, application/vnd.ms-powerpoint, application/msword, */*' );
define( 'ExpressPHP_Connection_Keep_Alive', 'Keep-Alive' );
define( 'ExpressPHP_ExpressPHP_Connection_Close', 'Close' );
define( 'Accept_Encoding_GZIP', 'gzip' );

class ExpressRobot{
	public $Referer = null;
	public $UserAgent = null;
	public $AcceptEncoding = null;
	public $Connection = null;
	public $Host = null;
	public $Accpet = null;
	public $AcceptLanguage = null;
	public $ContentType = null;
	public $ContentLength = null;
	public $Cookie = null;
	public $CacheControl = null;
	
	public $MaxRedirects = 10;
	public $Authentication = 0;
	public $AuthUser = null;
	public $AuthPassword = null;
	
	public $TimeOut = 5;
	public $RequestHeader = false;
	public $ResponseHeader = false;
	public $Data = array ();
	public $function = 'curl'; // file or curl
	/*
	public $Proxy = null;
	public $ProxyAuth = false;
	public $ProxyUser = null;
	public $ProxyPass = null;
	*/
	public $TargetURL;
	private $URL_scheme = 'http';
	private $URL_host = null;
	private $URL_port = 80;
	private $URL_user = false;
	private $URL_pass = false;
	private $URL_path = null;
	private $URL_query = null;
	private $URL_fragment = null;
	
	private $Method = 'GET';
	private $curl_ch = null;
	
	public $_rStatus, $_rContent, $_rInfo;
	public $_rError = null;
	public $_rErrno = 0;
	public $_rIsRedirect = false;
	public function __construct($options){
		if (is_array( $options )){
			foreach ( $options as $key => $value ){
				$key = strtolower( $key );
				switch ($key){
					case 'timeout' :
						$value = intval( $value );
						$this->TimeOut = ($value > 0 ? $value : 1);
						break;
					/*
					case 'proxy' :
						$this->Proxy = $value;
						break;
					*/
					case 'method' :
						$this->Method = strtoupper( $value ) == 'GET' ? 'GET' : 'POST';
						break;
					case 'referer' :
						$this->Referer = $value;
						break;
					case 'user-agent' :
						$this->UserAgent = $value;
						break;
					case 'engine' :
						$this->function = $value;
				}
			}
		}
		if ($this->function == 'curl' && ! function_exists( 'curl_init' )){
			$this->function = 'file';
		}
	
	}
	public function Run($url, $method = 'GET', $toCharset = 'utf-8', $fromCharset = 'utf-8', $header = false){
		$this->RequestHeader = $header;
		if (strtoupper( $method ) == 'GET'){
			$result = $this->get( $url );
		}else{
			$result = $this->post( $url );
		}
		if (! $this->_rErrno && $result && $toCharset != $fromCharset){
			$result = mb_convert_encoding( $result, $toCharset, $fromCharset );
		}
		return $result;
	}
	public function get($url, $data = array()){
		$this->Method = 'GET';
		$url_components = parse_url( $url );
		if (! count( $url_components ))
			return false;
		if (count( $data )){
			foreach ( $data as $key => $value ){
				$this->Data[$key] = $value;
			}
		}
		if ($url_components['host'])
			$this->URL_host = $url_components['host'];
		if ($url_components['scheme'])
			$this->URL_scheme = $url_components['scheme'];
		if ($url_components['user'])
			$this->URL_user = $url_components['user'];
		if ($url_components['pass'])
			$this->URL_pass = $url_components['pass'];
		if ($url_components['port'])
			$this->URL_port = $url_components['port'];
		if ($url_components['query'])
			$this->URL_query = $url_components['query'];
		if ($url_components['path'])
			$this->URL_path = $url_components['path'];
		if ($this->URL_user && $this->URL_pass){
			$this->Authentication = true;
			$this->AuthUser = $this->URL_user;
			$this->AuthPassword = $this->URL_pass;
		}
		if ($this->function == 'curl'){
			$this->curl_ch = curl_init();
			curl_setopt( $this->curl_ch, CURLOPT_RETURNTRANSFER, 1 );
			$this->curl_header();
			$result = $this->curl_HttpRequest();
			curl_close( $this->curl_ch );
			return $result;
		}else{
			$cx = $this->file_header();
			return $this->file_HttpRequest( $cx );
		}
	}
	public function getfile($url, $SavePath, $Referer = null){
		if (function_exists( 'curl_init' )){
			$fp = fopen( $SavePath, 'wb' );
			if ($fp == false){
				return false;
			}
			$ch = curl_init();
			if ($Referer)
				curl_setopt( $ch, CURLOPT_REFERER, $Referer );
			curl_setopt( $ch, CURLOPT_FILE, $fp );
			curl_setopt( $ch, CURLOPT_HEADER, 0 );
			curl_setopt( $ch, CURLOPT_URL, $url );
			curl_exec( $ch );
			if (curl_errno( $ch )){
				$result = false;
			}else
				$result = true;
			curl_close( $ch );
			fclose( $fp );
			return $result;
		}else{
			return copy( $url, $SavePath );
		}
	}
	public function post($url, $data = array()){
		$this->Method = 'POST';
		$url_components = parse_url( $url );
		if (! count( $url_components ))
			return false;
		if (count( $data )){
			foreach ( $data as $key => $value ){
				$this->Data[$key] = $value;
			}
		}
		if ($url_components['host'])
			$this->URL_host = $url_components['host'];
		if ($url_components['scheme'])
			$this->URL_scheme = $url_components['scheme'];
		if ($url_components['user'])
			$this->URL_user = $url_components['user'];
		if ($url_components['pass'])
			$this->URL_pass = $url_components['pass'];
		if ($url_components['port'])
			$this->URL_port = $url_components['port'];
		if ($url_components['query'])
			$this->URL_query = $url_components['query'];
		if ($url_components['path'])
			$this->URL_path = $url_components['path'];
		if ($this->URL_user && $this->URL_pass){
			$this->Authentication = true;
			$this->AuthUser = $this->URL_user;
			$this->AuthPassword = $this->URL_pass;
		}
		if ($this->function == 'curl'){
			$this->curl_ch = curl_init();
			curl_setopt( $this->curl_ch, CURLOPT_RETURNTRANSFER, 1 );
			$this->curl_header();
			$result = $this->curl_HttpRequest();
			curl_close( $this->curl_ch );
			return $result;
		}else{
			if (count( $this->Data )){
				$this->RequestHeader = true;
			}
			$cx = $this->file_header();
			return $this->file_HttpRequest( $cx );
		}
	}
	public function file_header(){
		
		if (count( $this->Data )){
			$querystring = http_build_query( $this->Data, '', '&' );
		}
		
		if ($this->Method == 'GET'){
			if ($this->URL_query){
				if ($querystring)
					$querystring = $this->URL_query . '&' . $querystring;
				else
					$querystring = $this->URL_query;
			}
		}
		/*
		 if($querystring){
			$this->ContentLength = strlen($querystring);
		}
		*/
		$HeaderData['method'] = $this->Method;
		$header = "";
		if ($this->AcceptLanguage){
			$header .= 'Accept-Language' . ':' . $this->AcceptLanguage . "\r\n";
		}
		if ($this->Accpet){
			$header .= 'Accpet' . ':' . $this->Accpet . "\r\n";
		}
		if ($this->Connection){
			$header .= 'Connection' . ':' . $this->Connection . "\r\n";
		}
		if ($this->ContentType){
			$header .= 'Content-type' . ':' . $this->ContentType . "\r\n";
		}
		if ($this->ContentLength){
			$header .= 'Content-length' . ':' . $this->ContentLength . "\r\n";
		}
		if ($this->Referer && $this->Referer != 'auto'){
			$header .= 'Referer' . ':' . $this->Referer . "\r\n";
		}
		if ($this->Authentication){
			$header .= "Authorization: Basic " . base64_encode( $this->AuthUser . ":" . $this->AuthPassword ) . "\r\n";
		}
		if ($this->UserAgent){
			if ($this->UserAgent = 'auto')
				$this->UserAgent = $_SERVER['HTTP_USER_AGENT'];
			$header .= 'User-Agent' . ':' . $this->UserAgent . "\r\n";
		}
		if ($this->CacheControl){
			$header .= 'Cache-Control' . ':' . $this->CacheControl . "\r\n";
		}
		$HeaderData['header'] = $header;
		if ($querystring)
			$HeaderData['content'] = $querystring;
		if ($this->timeout)
			$HeaderData['timeout'] = $this->TimeOut;
			/*
		if ($this->Proxy)
			$HeaderData['proxy'] = $this->Proxy;
		*/
		if ($this->Method == 'GET')
			$this->TargetURL = $this->URL_scheme . '://' . $this->URL_host . ($this->URL_port ? ':' . $this->URL_port : '') . ($this->URL_path ? $this->URL_path : '/') . ($querystring ? '?' . $querystring : '');
		else
			$this->TargetURL = $this->URL_scheme . '://' . $this->URL_host . ($this->URL_port ? ':' . $this->URL_port : '') . ($this->URL_path ? $this->URL_path : '/') . ($this->URL_query ? '?' . $this->URL_query : '');
		
		return stream_context_create( array (
			$this->URL_scheme => $HeaderData 
		) );
	}
	public function file_HttpRequest($cx = null){
		
		if ($this->RequestHeader){
			if ($cx)
				$this->_rContent = file_get_contents( $this->TargetURL, false, $cx );
			else
				$this->_rContent = file_get_contents( $this->TargetURL, false );
		}else
			$this->_rContent = file_get_contents( $this->TargetURL, false );
		$IsRedirect = false;
		if ($http_response_header){
			$this->_rInfo = $http_response_header;
			$tmpArr = explode( ' ', $http_response_header[0] );
			if ($tmpArr)
				$this->_rStatus = $tmpArr[1];
			
			foreach ( $http_response_header as $h ){
				if (strstr( strtolower( $h ), 'location' )){
					$IsRedirect = true;
					$newurl = trim( substr( $h, strpos( $h, ':' ) + 1 ) );
					$newurl = str_replace( array (
						"\r", 
						"\n" 
					), array (
						'', 
						'' 
					), $newurl );
				}
			}
		}
		if ($IsRedirect){
			$this->_rIsRedirect = true;
			$http_response_header = null;
			$this->Data = array ();
			return $this->get( $newurl );
		}else
			return $this->_rContent;
	}
	public function curl_header(){
		if ($this->Method == 'GET'){
			if (count( $this->Data )){
				$querystring = http_build_query( $this->Data, '', '&' );
			}
			if ($this->URL_query){
				if ($querystring)
					$querystring = $this->URL_query . '&' . $querystring;
				else
					$querystring = $this->URL_query;
			}
		
		}
		if ($this->RequestHeader){
			
			$headers[] = 'Host: ' . $this->URL_host;
			if ($this->AcceptLanguage)
				$headers[] = "Accept-Language: " . $this->AcceptLanguage;
			if ($this->Connection)
				$headers[] = 'Connection: ' . $this->Connection;
			if ($this->Accpet)
				$headers[] = "Accept: " . $this->Accpet;
			
			if ($this->Cookie)
				$headers[] = 'Cookie: ' . $this->Cookie;
			if ($headers){
				curl_setopt( $this->curl_ch, CURLOPT_HTTPHEADER, $headers );
			}
			if ($this->Referer == 'auto'){
				curl_setopt( $this->curl_ch, CURLOPT_AUTOREFERER, true );
			}elseif ($this->Referer){
				curl_setopt( $this->curl_ch, CURLOPT_REFERER, $this->Referer );
			}
			if ($this->UserAgent){
				if ($this->UserAgent == 'auto')
					$this->UserAgent = $_SERVER['HTTP_USER_AGENT'];
				curl_setopt( $this->curl_ch, CURLOPT_USERAGENT, $this->UserAgent );
			}
		}
		
		$this->TargetURL = $this->URL_scheme . '://' . $this->URL_host . ($this->URL_port ? ':' . $this->URL_port : '') . ($this->URL_path ? $this->URL_path : '/') . ($querystring ? '?' . $querystring : '');
	}
	
	public function curl_HttpRequest(){
		curl_setopt( $this->curl_ch, CURLOPT_URL, $this->TargetURL );
		//设置返回目标页面数据
		curl_setopt( $this->curl_ch, CURLOPT_CONNECTTIMEOUT, 5 );
		curl_setopt( $this->curl_ch, CURLOPT_TIMEOUT, $this->TimeOut );
		curl_setopt( $this->curl_ch, CURLOPT_VERBOSE, true );
		if ($this->Method == 'POST'){
			curl_setopt( $this->curl_ch, CURLOPT_POST, true );
			curl_setopt( $this->curl_ch, CURLOPT_POSTFIELDS, $this->Data );
		}
		if ($this->AcceptEncoding){
			curl_setopt( $this->curl_ch, CURLOPT_ENCODING, $this->AcceptEncoding );
		}
		if ($this->ResponseHeader){
			curl_setopt( $this->curl_ch, CURLOPT_HEADER, true );
		}
		if ($this->MaxRedirects){
			//接受目标网页进行Location 跳转,并获取最终页面的结果
			curl_setopt( $this->curl_ch, CURLOPT_FOLLOWLOCATION, true );
			//允许目标网页行跳转操作次数
			curl_setopt( $this->curl_ch, CURLOPT_MAXREDIRS, $this->MaxRedirects );
		}
		if ($this->Authentication){
			curl_setopt( $this->curl_ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC );
			curl_setopt( $this->curl_ch, CURLOPT_USERPWD, $this->AuthUser . ':' . $this->AuthPassword );
		}
		/*
		if ($this->Proxy){
			curl_setopt( $this->curl_ch, CURLOPT_PROXY, $this->Proxy );
			if ($this->ProxyAuth){
				curl_setopt( $this->curl_ch, CURLOPT_PROXYAUTH, true );
				curl_setopt( $this->curl_ch, CURLOPT_PROXYUSERPWD, $this->ProxyUser . ':' . $this->ProxyPass );
			}
		}
		*/
		$this->_rContent = curl_exec( $this->curl_ch );
		$this->_rErrno = curl_errno( $this->curl_ch );
		if ($this->_rErrno){
			$this->_rError = curl_error( $this->curl_ch );
			$this->_rContent = null;
			return false;
		}
		$this->_rInfo = curl_getinfo( $this->curl_ch );
		if ($this->_rInfo['redirect_count'])
			$this->_rIsRedirect = true;
		$this->_rStatus = intval( $this->_rInfo['http_code'] );
		
		return $this->_rContent;
	
	}
	public function set($VariableName, $VariableValue = null){
		if (is_array( $VariableName )){
			foreach ( $VariableName as $key => $value ){
				$this->Data[$key] = $value;
			}
		}else{
			$this->Data[$VariableName] = $VariableValue;
		}
	}
}
/*
$PHPURL = new ExpressRobot( array (
	'timeout' => 5, 
	'engine' => 'curl' 
) );

//echo $PHPURL->getfile( 'http://121.14.157.211:82/pictures/2/3958/ARCANA_0004_7loz1d64.jpg', 'test.jpg', 'http://www.imanhua.com/comic/2/list_3958.html?p=5' ) ? 'ok' : 'failed';
//exit;
$PHPURL->RequestHeader = true;
$PHPURL->Referer = 'http://www.imanhua.com/comic/2/list_3958.html?p=8';


$result = $PHPURL->get( 'http://finance.cn.yahoo.com/fin/finance_search_result.html', array (
	's' => '600001' 
) );

//$PHPURL->Cookie = 'myname=wushuang';
//$PHPURL->Referer = 'http://search.test.258.com';
$PHPURL->UserAgent = Expressphp_USER_AGENT_IE8;
//$PHPURL->getfile( 'http://www.258.com/logo/zh/logo.gif', 'test.gif' );


$result = $PHPURL->Run( 'http://www.imanhua.com/comic/2/list_3958.html?p=8' );

//$result = $PHPURL->get( 'http://www.258.com' );
echo '<p>Redirect:</p>';
echo $PHPURL->_rIsRedirect ? 'true' : 'false';

echo '<p>error:</p>';
echo $PHPURL->_rError;
echo '<p>Status:</p>';
echo $PHPURL->_rStatus;
echo '<p>result:</p>';
echo $result;
*/
?>