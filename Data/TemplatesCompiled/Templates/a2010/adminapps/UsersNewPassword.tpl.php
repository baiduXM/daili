<?php
/*
 ExpressPHP Template Compiler 3.0.0 beta
 compiled from UsersNewPassword.htm at 2010-01-07 01:47:01 Asia/Shanghai
*/
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><?php $this->Display("header"); ?><style type="text/css">
<!--
@import url("/Templates/a2010/adminapps/images/style.css");
-->
</style>
</head>

<body>
<form id="form1" name="form1" method="post"
	action="<?php echo UrlRewriteSimple('Users','NewPassword',true); ?>">
    
<div class="panel">
  <div class="panel-header">
    <div class="panel-header-left"></div>
    <div class="panel-header-content">设置账户密码</div>
    <div class="panel-header-right"></div>
  </div>
  <div class="panel-body">
    <div class="panel-body-left">
      <div class="panel-body-right">
        <div class="panel-body-content">
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
    </div>
  </div>
  <div class="panel-footer">
    <div class="panel-footer-left"></div>
    <div class="panel-footer-right"></div>
  </div>
</div>

<div style="padding-left: 100px;"><input
	name="button" type="submit" class="btn" id="button" value=" 修 改 " /> <input
	name="button2" type="reset" class="btn" id="button2" value=" 重 置 " /></div>

</form>

</body>
</html>
