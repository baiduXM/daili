<?php
include './ExpressPHP.Init.php';
if ($_GET ['Action'] == 'GetLocation') {
	include './modules/class.AreasModule.php';
	$ParentID = _intval ( $_GET ['ParentID'] );
	$TargetID = $_GET ['TargetID'];
	$SelectID = $_GET['SelectID'];
	$DB = new DB ( );
	$Result = $DB->Select ( 'SELECT AreaID,AreaName FROM tbl_location WHERE ParentAreaID=' . $ParentID . ' ORDER BY AreaID ASC' );
	if ($Result) {
		echo JsonMessage ( 'succ', '成功取得区域', $Result, array ('TargetID' => $TargetID,'SelectID'=>$SelectID ) );
	} else {
		echo JsonMessage ( 'succ', '成功取得区域', null );
	}
}
if ($_GET ['Action'] == 'CheckUserName') {
	$UserName = trim ( $_GET ['UserName'] );
	if (! class_exists ( 'UsersModule' ))
		include './modules/class.UsersModule.php';
	$Users = new UsersModule ( );
	if (! preg_match ( "/^([^ ]{3,20})$/", $UserName )) {
		echo JsonMessage ( 'error', '非法登陆名,请重新填写您的登陆名!', null );
		exit;
	}
	if($Users->CheckUserName($UserName)){
		echo JsonMessage ( 'error', htmlencode($UserName).'已经被其它人使用!', null );
		exit;
	}
	else{
		unset($Users);
		echo JsonMessage ( 'succ', '恭喜您, '.htmlencode($UserName).'可以注册!', null );
		exit;
	}
}
if ($_GET ['Action'] == 'CheckEmail') {
	$Email = trim ( $_GET ['Email'] );
	if (! class_exists ( 'UsersModule' ))
		include './modules/class.UsersModule.php';
	$Users = new UsersModule ( );
	if (! $Email || ! _IsEmail ( $Email )) {
		echo JsonMessage ( 'error', '非法邮箱, 请重新填写您的邮箱地址!', null );
		exit;
	}
	if($Users->CheckEmail($Email)){
		echo JsonMessage ( 'error', htmlencode($Email).' 已经被其它人使用!', null );
		exit;
	}
	else{
		unset($Users);
		echo JsonMessage ( 'succ', htmlencode($Email).' 可以注册!', null );
		exit;
	}
}


?>