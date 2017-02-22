<?php
/*
 ExpressPHP Template Compiler 3.0.0 beta
 compiled from TemplateModify.htm at 2010-01-07 16:48:09 Asia/Shanghai
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

<form action="<?php echo UrlRewriteSimple('Template','Modify',true); ?>"
	method="post" name="form1" id="form1">
<div class="panel">
  <div class="panel-header">
    <div class="panel-header-left"></div>
    <div class="panel-header-content">编辑模块</div>
    <div class="panel-header-right"></div>
  </div>
  <div class="panel-body">
    <div class="panel-body-left">
      <div class="panel-body-right">
        <div class="panel-body-content">
  <table width="100%" border="0" cellspacing="0" cellpadding="5">
	<tr>
		<td width="15%" align="right">模块名称:</td>
		<td><?php echo $Path;?> <input name="Path" type="hidden" id="Path"
			value="<?php echo $Path;?>" /></td>
	</tr>
	<tr>
		<td align="right" valign="top">源文件:</td>
		<td><textarea name="Sources" id="Sources" cols="45" rows="30"
			style="width: 98%; padding: 10px;"><?php echo $Sources;?></textarea></td>
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


<div style="padding-left: 100px; "><input
	name="button" type="submit" class="btn" id="button" value=" 保 存 " /> <input
	name="button2" type="reset" class="btn" id="button2" value=" 重 置 " /></div>

</form>

</body>
</html>
