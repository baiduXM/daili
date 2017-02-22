<?php
/**
 * ExpressPHP_Exception
 * 错误处理及异常处理类
 * Developer : Leslie X 3.0
 */

class ExpressPHP_Exception {
	const VERSION = '2.0.0';
	public $message = null;
	public $code = null;
	public $file = null;
	public $line = null;
	static public function error_handler($message, $code, $file = null, $line = null) {
		if ($code > 7)
			self::message ( $message, $code, $file, $line );
	}
	static public function exception_handler(Exception $e) {
		self::message ( $e->getCode (), $e->getMessage (), $e->getFile (), $e->getLine () );
	}
	static public function message($message, $code, $file = null, $line = null) {
		echo '<pre>';
		echo "Error Code: {$code}\n";
		echo "Error Message: {$message}\n";
		if ($file)
			echo "Error File: {$file}\n";
		if ($line)
			echo "Error Line: {$line}\n";
		echo '<pre>';
		die ();
	}
}
//自定义错误处理
set_error_handler ( array (
	'ExpressPHP_Exception', 
	'error_handler' 
) );
//自定义异常处理
set_exception_handler ( array (
	'ExpressPHP_Exception', 
	'exception_handler' 
) );
?>