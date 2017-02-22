<?php
/*
 ExpressPHP Template Compiler 3.0.0 beta
 compiled from UsersLogin.htm at 2010-01-07 01:47:01 Asia/Shanghai
*/
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管理员登陆 - 运营管理中心</title>
<link href="/Templates/a2010/adminapps/images/style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="login-bg"><form name='registerform' id='registerform'
	action="<?php echo UrlRewriteSimple('Users','Login',true); ?>" method='post'>
<table width="100%" border="0" align="center" cellpadding="10" cellspacing="0">
  <tr>
    <td rowspan="2" align="left" valign="top"><img src="/Templates/a2010/adminapps/images/logo-picture.png" width="267" height="165" /></td>
    <td width="50%" height="50">&nbsp;</td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td width="100%" colspan="2">管理员登陆</td>
        </tr>
      <tr>
        <td align='right' style="font-size: 12px;">账&nbsp;&nbsp;&nbsp;&nbsp;户:&nbsp;&nbsp;</td>
        <td><input tabindex="1" name="UserName" type="text" id='UserName'
			style="width: 120px; font-size: 12px;" size="25" />
          &nbsp;</td>
        </tr>
      <tr>
        <td align='right' style="font-size: 12px;">密&nbsp;&nbsp;&nbsp;&nbsp;码:&nbsp;&nbsp;</td>
        <td><input name="Password" type="password" tabindex="2"
			id='Password' style="width: 120px; font-size: 12px;" size="25" />
          &nbsp;</td>
        </tr>
      <tr>
        <td colspan="2" align="center">&nbsp;</td>
        </tr>
      <tr>
        <td colspan="2" align="center"><input name="btnsubmit" tabindex="3"
			id='btnsubmit' border="0" value='登 陆' type="submit" class="btn" />
          <input
			name="btnsubmit2" tabindex="3" id='btnsubmit2' border="0" value='重 置'
			type="reset" class="btn" />
          <input name="RedirectURL" type="hidden"
			value="<?php echo self::__htmlspecialchars($RedirectURL); ?>" /></td>
        </tr>
    </table></td>
  </tr>
</table>
</form>
</div>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" valign="top" style="font-size:9px"> Developed By PHPUSR.COM, (C) 2009 - 2010.</td>
    <td width="180" align="right"><img src="/Templates/a2010/adminapps/images/test-welcome.png" width="178" height="58" /></td>
  </tr>
</table>
</body>
</html>
