<?php
/*
 ExpressPHP Template Compiler 3.0.0 beta
 compiled from TemplateCompiledChecker.htm at 2010-01-07 01:47:01 Asia/Shanghai
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
<div class="panel">
  <div class="panel-header">
    <div class="panel-header-left"></div>
    <div class="panel-header-content">模板缓存</div>
    <div class="panel-header-right"></div>
  </div>
  <div class="panel-body">
    <div class="panel-body-left">
      <div class="panel-body-right">
        <div class="panel-body-content">
          <table width="100%" border="0" cellspacing="0" cellpadding="5"
	class="DataGird">
	<tr>
		<th align="left" class="vertical-line">模板缓存文件</th>
		<th width="250">检查结果</th>
	</tr>
<?php $__view__data__0__0__=$lists;  if(is_array($__view__data__0__0__)) { foreach($__view__data__0__0__ as $file => $message) { ?>
<tr>
		<td align="left"><?php echo $TemplatesCompiledPath;?><?php echo $file;?></td>
		<td align="left"><?php echo $message;?></td>
	</tr>
<?php } }  ?>
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

</body>
</html>
