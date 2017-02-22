<?php
class ExpressString {
	public $String;
	public function __construct($String = null) {
		if ($String)
			$this->String = $String;
		return $this;
	}
	public function setString($String = null) {
		if ($String)
			$this->String = $String;
		return $this;
	}
	public function ClearBlank(){
		$newString = preg_replace ( '/([\s]{2,})/', ' ', $this->String );
		return new ExpressString ( $newString );
	}
	public function ClearLeftBlank($String=-999999,$isArrayString=false){
		if($String==-999999) $String = $this->String;
		if(is_array($String)){
			foreach ($String as $key => $value){
				$String[$key] = $this->ClearLeftBlank($value, true);
			}
			return $String;
		}
		else {
			if(!$String) return false;
			$String = strtr($String, array('&nbsp;'=>' '));
			$String = ltrim($String);
			$String = preg_replace ( '/([\s]{2,})/', ' ', $String );
			if(!$isArrayString&&$String)
				return new ExpressString ( $String );
			else 
				return $String;
		}
	}
	public function ClearRightBlank($String=-999999,$isArrayString=false){
		if($String==-999999) $String = $this->String;
		if(is_array($String)){
			foreach ($String as $key => $value){
				$String[$key] = $this->ClearRightBlank($value,true);
			}
			return $String;
		}
		else {
			if(!$String) return false;
			$String = strtr($String, array('&nbsp;'=>' '));
			$String = preg_replace ( '/([\s]{1,})/', ' ', $String );
			$String = rtrim($String);
			if(!$isArrayString)
				return new ExpressString ( $String );
			else 
				return $String;
		}
	}	
	/**
	 * 获取从指定正则表达式的字符串起左边的所有字符
	 *
	 * @param string $pattern
	 * @return ExpressString
	 */
	public function LeftByPattern($pattern) {
		if (preg_match ( $pattern, $this->String, $matches, PREG_OFFSET_CAPTURE )) {
			$newString = substr ( $this->String, 0, $matches [0] [1] );
			return new ExpressString ( $newString );
		} else
			return false;
	}
	/**
	 * 获取从指定正则表达式的字符串起右边的所有字符
	 * 
	 * 若指定self值为false时,即返回不包括符合正则表达式的字符串.
	 *
	 * @param string $pattern
	 * @param boolean $self
	 * @return ExpressString
	 */
	public function RightByPattern($pattern, $self = true) {
		if (preg_match ( $pattern, $this->String, $matches, PREG_OFFSET_CAPTURE )) {
			$newString = substr ( $this->String, (! $self ? (strlen ( $matches [0] [0] ) + $matches [0] [1]) : $matches [0] [1]) );
			return new ExpressString ( $newString );
		} else
			return false;
	}
	public function __destruct() {
		unset ( $this );
	}
	/**
	 * 转换字符编码,需要mb_string库支持
	 *
	 * @param string $toCharset
	 * @param string $fromCharset
	 * @return ExpressString
	 */
	public function convert_encoding($toCharset = 'utf-8', $fromCharset = 'gbk') {
		$newString = mb_convert_encoding ( $this->String, $toCharset, $fromCharset );
		return new ExpressString ( $newString );
	}
	public function Replace($pattern, $replacement){
		$newString = preg_replace($pattern, $replacement, $this->String);
		return new ExpressString ( $newString );
	}
	public function Find($strRegularExpression){
		if(preg_match($strRegularExpression, $this->String, $Matchs, PREG_OFFSET_CAPTURE)){
			return $Matchs;
		}
		else
			return false;
	}
	/**
	 * 指定正则表达式获取所有配匹的字符
	 *
	 * @param string $strRegularExpression
	 * @return array
	 */
	public function FindAllByRegular($strRegularExpression) {
		if (preg_match_all ( $strRegularExpression, $this->String, $Matchs, PREG_PATTERN_ORDER ))
			return $Matchs;
		else
			return false;
	}
	
	/**
	 * 将字符串转换成小写
	 *
	 * @return ExpressString
	 */
	public function toLower() {
		$newString = strtolower ( $this->String );
		return new ExpressString ( $newString );
	}
	/**
	 * 将字符串转换成大写
	 *
	 * @return ExpressString
	 */	
	public function toUpper() {
		$newString = strtoupper ( $this->String );
		return new ExpressString ( $newString );
	}
	public function __toString() {
		return $this->String;
	}
	/**
	 * 清除HTML元素之间的断行,跳表符(\r\n\t)
	 *
	 * @return ExpressString
	 */
	public function ClearHtmlLn(){
		$newString = preg_replace ( "/(>)([\n\t\r]+)(<)/", '$1$3', $this->String );
		return new ExpressString ( $newString );
	}
	/**
	 * 清除空白的字符串,包括连续的空格,空的段落
	 *
	 * @return ExpressString
	 */
	public function ClearBlankTag() {
		$newString = preg_replace ( '/([\s]{2,})/', '', $this->String );
		$newString = preg_replace ( '/<([a-z0-9]+)(|[^>]+)><\/([a-z0-9]+>/i', '', $newString );
		$newString = preg_replace ( '/<p>([\s\r\n\t]+)<\/p>/', '', $newString );
		$newString = strtr ( $newString, array ('<p></p>' => '' ) );
		return new ExpressString ( $newString );
	}
	public function ClearImgTag(){
		$newString = preg_replace ( '/<img\s([^>]+)>/i', '', $this->String );
		return new ExpressString ( $newString );
	}
	/**
	 * 清除样式表信息或链接文件
	 *
	 * @return ExpressString
	 */
	public function ClearCss() {
		$newString = preg_replace ( "/[\n\r\t]*<style(.+?)<\/style>/isU", "", $this->String );
		return new ExpressString ( $newString );
	}
	/**
	 * 清除Javascripts文件
	 *
	 * @return ExpressString
	 */	
	public function ClearJavascript() {
		$newString = preg_replace ( "/[\n\r\t]*<script(.+?)<\/script>/is", "", $this->String );
		return new ExpressString ( $newString );
	}
	/**
	 * 将常用的全角字符转换成半角字符
	 *
	 * @return ExpressString
	 */
	public function ConvertCommonChar() {
		$arrChar = array ('０' => '0', '１' => '1', '２' => '2', '３' => '3', '４' => '4', '５' => '5', '６' => '6', '７' => '7', '８' => '8', '９' => '9', '，' => ',', '。' => '.', '；' => ';' );
		$newString = strtr ( $this->String, $arrChar );
		return new ExpressString ( $newString );
	}
	/**
	 * 替代系统strtr 函数,并支持数组字符串操作
	 *
	 * @param string $String
	 * @param array $replace_pairs
	 * @param boolean $ClearHTML
	 * @return string
	 */
	public function strtr($String, $replace_pairs, $ClearHTML = false) {
		if (is_array ( $String )) {
			foreach ( $String as $key => $value ) {
				$String [$key] = self::strtr ( $value, $replace_pairs );
			}
			unset ( $key, $value );
			return $String;
		}
		$String = strtr ( $String, $replace_pairs );
		if ($ClearHTML)
			$String = strip_tags ( $String );
		return $String;
	}
	/**
	 * substr替代函数,并支持数组操作.
	 *
	 * @param string $String
	 * @param intval $Start
	 * @param intval $Length
	 * @return string
	 */
	public function substr($String, $Start, $Length = 0) {
		if (is_array ( $String )) {
			foreach ( $String as $key => $value ) {
				$String [$key] = self::substr ( $value, $Start, $Length );
			}
			return $String;
		}
		if ($Length) {
			return substr ( $String, $Start, $Length );
		}
		return substr ( $String, $Start );
	}
	/**
	 * 判断字符串在指定字符串是否存在
	 *
	 * @param 字符串 $findString
	 * @return 布尔型
	 */
	public function inString($findString) {
		$Start = strpos ( $this->String, $findString );
		if ($Start === false)
			return flase;
		else
			return true;
	}
	/**
	 * 将当前字符串从 BeginString 向右截取
	 *
	 * @param string $BeginString
	 * @param boolean $self
	 * @return ExpressString
	 */
	public function Right($BeginString, $self = false) {
		$Start = strpos ( $this->String, $BeginString );
		if ($Start === false)
			return null;
		if (! $self)
			$Start += strlen ( $BeginString );
		$newString = substr ( $this->String, $Start );
		return new ExpressString ( $newString );
	}
	public function Length(){
		return strlen($this->String);
	}
	/**
	 * 将当前字符串从 BeginString 向左截取
	 *
	 * @param string $BeginString
	 * @param boolean $self
	 * @return ExpressString
	 */	
	public function Left($BeginString, $self = false) {
		$Start = strpos ( $this->String, $BeginString );
		if ($Start === false)
			return null;
		if ($self)
			$Start += strlen ( $BeginString );
		$newString = substr ( $this->String, 0, $Start );
		return new ExpressString ( $newString );
	}
	/**
	 * 从当前字符串中截取 $BeginString到 $EndString之间的字符串
	 *
	 * @param 字符串 $BeginString
	 * @param 字符串 $EndString
	 * @return 字符串
	 */
	public function SubString($BeginString, $EndString = null) {
		$Start = strpos ( $this->String, $BeginString );
		if ($Start === false)
			return null;
		$Start += strlen ( $BeginString );
		$newString = substr ( $this->String, $Start );
		if (! $EndString)
			return new ExpressString ( $newString );
		$End = strpos ( $newString, $EndString );
		if ($End == false)
			return null;
		$newString = substr ( $newString, 0, $End );
		return new ExpressString ( $newString );
	}
}
?>