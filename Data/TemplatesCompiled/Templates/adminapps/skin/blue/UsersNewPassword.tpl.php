<?php
/*
 ExpressPHP Template Compiler 3.0.0 beta
 compiled from UsersNewPassword.htm at 2010-01-07 01:47:01 Asia/Shanghai
*/
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><?php $this->Display("header"); ?><link href="/templates/adminapps/skin/blue/style.css" rel="stylesheet"
	type="text/css" />
</head>

<body>
<div>
<form id="form1" name="form1" method="post"
	action="<?php echo UrlRewriteSimple('Users','NewPassword',true); ?>">
<div class="line-border-f0f0f0">
<div class="UserBodyTitle">修改密码</div>
<div class="block"></div>
<div class="font-12px">
<table width="100%" border="0" cellspacing="0" cellpadding="5">
	<tr>
		<td width="150" align="right">当前密码:</td>
		<td><input name="Password" type="password"
			class="input-notsize-style" id="Password" /></td>
	</tr>
	<tr>
		<td align="right">新密码:</td>
		<td><input name="NewPassword" type="password"
			class="input-notsize-style" id="NewPassword" /></td>
	</tr>
	<tr>
		<td align="right">确认新密码:</td>
		<td><input name="CfmNewPassword" type="password"
			class="input-notsize-style" id="CfmNewPassword" /></td>
	</tr>
</table>

</div>

</div>
<div style="padding-left: 100px; line-height: 50px; height: 50px;"><input
	name="button" type="submit" class="btn" id="button" value=" 修 改 " /> <input
	name="button2" type="reset" class="btn" id="button2" value=" 重 置 " /></div>

</form>
</div>
<div class="clear"></div>
</body>
</html>
