<?php
function captcha_encode($fieldname, $string){
	global $system_config;
	return md5($system_config['captcha_hashcode'] . $fieldname . ':' . $string . $system_config['captcha_hashcode']) . $fieldname;
}

function captcha_checker(){
	$tmpString = $_POST['captcha_validate_string'] ? $_POST['captcha_validate_string'] : $_GET['captcha_validate_string'];
	if (strlen($tmpString) <= 32) return false;
	$captcha_encode_string = substr($tmpString, 0, 32);
	
	$captcha_fieldname = substr($tmpString, 32);
	
	$captcha_string = $_POST[$captcha_fieldname] ? $_POST[$captcha_fieldname] : $_GET[$captcha_fieldname];
	if (! $captcha_string) return false;
	if ($captcha_encode_string . $captcha_fieldname == captcha_encode($captcha_fieldname, $captcha_string)) return true;
	else
		return false;
}
function captcha_timestamp(){
	global $system_config;
	$timestamp = time();
	return '<input name="captcha_validate_timestamp" type="hidden" id="captcha_validate_timestamp" value="' . md5($system_config['captcha_hashcode'] . $timestamp . $system_config['captcha_hashcode']) . $timestamp . '" />';
}
function captcha_timestamp_check(){
	global $system_config;
	$encode_string = $_POST['captcha_validate_timestamp'] ? $_POST['captcha_validate_timestamp'] : $_GET['captcha_validate_timestamp'];
	if (strlen($encode_string) <= 32) return false;
	if (substr($encode_string, 0, 32) == md5($system_config['captcha_hashcode'] . substr($encode_string, 32) . $system_config['captcha_hashcode'])) {
		$history_timestamp = substr($encode_string, 32);
		if ((time() - $system_config['captcha_interval']) > $history_timestamp) return true;
	}
	return false;
}
?>