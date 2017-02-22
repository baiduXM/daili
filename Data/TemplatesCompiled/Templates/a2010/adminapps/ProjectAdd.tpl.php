<?php
/*
 ExpressPHP Template Compiler 3.0.0 beta
 compiled from ProjectAdd.htm at 2014-04-01 02:00:05 Asia/Shanghai
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
<form action="<?php echo UrlRewriteSimple('Project','Add',true); ?>"
	method="post" enctype="multipart/form-data" name="form1" id="form1">
    
<div class="panel">
  <div class="panel-header">
    <div class="panel-header-left"></div>
    <div class="panel-header-content">添加产品</div>
    <div class="panel-header-right"></div>
  </div>
  <div class="panel-body">
    <div class="panel-body-left">
      <div class="panel-body-right">
        <div class="panel-body-content">
   <table width="100%" border="0" cellspacing="0" cellpadding="5">
	<tr>
		<td width="150" align="right">产品名称:</td>
		<td><input name="ProjectName" type="text" class="input-style"
			id="ProjectName" maxlength="64" /></td>
	</tr>
	<tr>
		<td align="right">产品上线时间:</td>
		<td><input name="OnlineTime" type="text" class="input-style"
			id="OnlineTime" onclick="return Calendar('OnlineTime');"/></td>
	</tr>
	<tr>
		<td align="right">产品备注:</td>
		<td><textarea name="Remark" cols="100" rows="5" class="input-style" id="Remark"></textarea></td>
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
	name="button" type="submit" class="btn" id="button" value=" 添 加 " />
 <input
	name="button2" type="reset" class="btn" id="button2" value=" 重 置 " /></div>

</form>
</div>
</body>
</html>
