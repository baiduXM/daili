<?php
/*
 ExpressPHP Template Compiler 3.0.0 beta
 compiled from UsersLogin.htm at 2010-01-07 01:47:01 Asia/Shanghai
*/
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>网站线上管理系统登录</title>
<style type="text/css">
body {
	margin: 0;
	padding: 0;
}

* {
	font-size: 12px;
}

.btn {
	background-image:
		url(/templates/adminapps/skin/blue/images/btn-18-bg.gif);
	background-repeat: no-repeat;
	height: 20px;
	width: 78px;
	font-size: 12px;
	padding-top: 2px;
	border-top-width: 0px;
	border-right-width: 0px;
	border-bottom-width: 0px;
	border-left-width: 0px;
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: none;
	border-left-style: none;
	font-family: Arial;
	color: #39F;
	cursor: pointer;
	padding-bottom: 0px;
}
</style>
</head>
<body>
<form name='registerform' id='registerform'
	action="<?php echo UrlRewriteSimple('Users','Login',true); ?>" method='post'>
<div style="width: 600px; height: 300px; margin: 100px auto;">
<div style="float: left; width: 290px; height: 300px;">
<table border="0" cellpadding="0" cellspacing="0" align="center"
	width="290">
	<tr>
		<td width="30" height="80">&nbsp;</td>
	</tr>
	<tr>
		<td>
		<div style="padding-left: 30px;"><img
			src="/templates/adminapps/skin/blue/images/data-logo.gif" width="200"
			height="35" /></div>
		</td>
	</tr>
	<tr>
		<td>
		<div style="padding-left: 35px; line-height: 20px;">网络运营中心,
		让运营更高效、 反应更快速！</div>
		</td>
	</tr>
</table>
</div>
<div
	style="float: left; width: 10px; height: 300px; padding: 4px; text-align: center;"><img
	src="/templates/adminapps/skin/blue/images/login-panel-line.gif"
	width="1" height="230" /></div>
<div style="float: left; width: 290px; height: 300px;">
<table border="0" cellpadding="0" cellspacing="4" align="center"
	width="300">
	<tr>
		<td height="60" colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="2" style="font-size: 14px;">管理账户登陆</td>
	</tr>
	<tr>
		<td colspan="2" height="10"></td>
	</tr>
	<tr>
		<td width="30%" align='right' style="font-size: 12px;">账&nbsp;&nbsp;&nbsp;&nbsp;户:&nbsp;&nbsp;</td>
		<td><input tabindex="1" name="UserName" type="text" id='UserName'
			style="width: 120px; font-size: 12px;" size="25" />&nbsp;</td>
	</tr>
	<tr>
		<td align='right' style="font-size: 12px;">密&nbsp;&nbsp;&nbsp;&nbsp;码:&nbsp;&nbsp;</td>
		<td><input name="Password" type="password" tabindex="2"
			id='Password' style="width: 120px; font-size: 12px;" size="25" />&nbsp;</td>
	</tr>

	<tr>
		<td colspan=2 align="center">&nbsp;</td>
	</tr>
	<tr>
		<td colspan=2 align="center"><input name="btnsubmit" tabindex="3"
			id='btnsubmit' border="0" value='登 陆' type="submit" class="btn" /> <input
			name="btnsubmit2" tabindex="3" id='btnsubmit2' border="0" value='重 置'
			type="reset" class="btn" /> <input name="RedirectURL" type="hidden"
			value="<?php echo self::__htmlspecialchars($RedirectURL); ?>" /></td>
	</tr>

</table>
</div>
<div
	style="clear: both; line-height: 30px; margin: 0px auto; text-align: center; font-family: Georgia, 'Times New Roman', Times, serif; color: #999; font-size: 9px;">
Created by ExpressPHP 2009 .</div>
</div>

</form>

</body>
</html>