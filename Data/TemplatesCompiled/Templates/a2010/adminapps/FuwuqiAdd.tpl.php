<?php
/*
 ExpressPHP Template Compiler 3.0.0 beta
 compiled from FuwuqiAdd.htm at 2015-11-19 16:01:40 Asia/Shanghai
*/
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><?php $this->Display("header"); ?><style type="text/css">
<!--
@import url("/Templates/a2010/adminapps/images/style.css");
-->
</style>
<script type="text/javascript" src="Javascripts/calendar.js"></script>
</head>
<body>
<form action="<?php echo UrlRewriteSimple('Fuwuqi','Add',true); ?>"
	method="post" enctype="multipart/form-data" name="form1" id="form1">
    
<div class="panel">
  <div class="panel-header">
    <div class="panel-header-left"></div>
    <div class="panel-header-content"><?php if($Data) { ?>修改服务器<?php } else { ?>添加服务器<?php } ?></div>
    <div class="panel-header-right"></div>
  </div>
  <div class="panel-body">
    <div class="panel-body-left">
      <div class="panel-body-right">
        <div class="panel-body-content">
   <table width="100%" border="0" cellspacing="0" cellpadding="5">
	<tr>
		<td width="150" align="right">服务器名称:</td>
		<td><input name="FuwuqiName" type="text" class="input-style"
			id="ProjectName" value="<?php echo $Data['FuwuqiName'];?>"/>
			<input type="hidden" name="SeverID" id="SeverID" value="<?php echo $Data['ID'];?>" /></td>
	</tr>
	<tr>
		<td align="right">IP:</td>
		<td><input name="IP" type="text" class="input-style" id="IP" value="<?php echo $Data['IP'];?>" /></td>
	</tr>
	<tr>
		<td align="right">CNAME地址:</td>
		<td><input name="CName" class="input-style" id="CName" value="<?php echo $Data['CName'];?>" /></td>
	</tr>
	<tr>
		<td align="right">访问地址:</td>
		<td><input name="FwAdress" class="input-style" id="FwAdress" value="<?php echo $Data['FwAdress'];?>" /></td>
	</tr>
	<tr>
		<td align="right">FTP:</td>
		<td><input name="FTP" class="input-style" id="FTP" value="<?php echo $Data['FTP'];?>" /></td>
	</tr>
	<tr>
		<td align="right">FTP用户名:</td>
		<td><input name="FTPName" class="input-style" id="FTPName" value="<?php echo $Data['FTPName'];?>" /></td>
	</tr>
	<tr>
		<td align="right">FTP密码:</td>
		<td><input name="FTPPassword" class="input-style" id="FTPPassword" value="<?php echo $Data['FTPPassword'];?>" /></td>
	</tr>
	<tr>
		<td align="right">FTP端口:</td>
		<td><input name="FTPDuankou" class="input-style" id="FTPDuankou" value="<?php echo $Data['FTPDuankou'];?>" /></td>
	</tr>
	<tr>
		<td align="right">FTP目录:</td>
		<td><input name="FTPMulu" class="input-style" id="FTPMulu" value="<?php echo $Data['FTPMulu'];?>" /></td>
	</tr>
	<tr>
		<td align="right">状态:</td>
		<td><input type="checkbox" name="State" id="State" class="input-style" value="1" <?php if($Data['State']!=0) { ?>checked<?php } ?>/></td>
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

<div style="padding-left: 100px;"><input name="button" type="submit" class="btn" id="button" value=" <?php if($Data) { ?>修改<?php } else { ?>添 加<?php } ?> " />
 <input name="button2" type="reset" class="btn" id="button2" value=" 重 置 " /></div>

</form>
</div>
</body>
</html>