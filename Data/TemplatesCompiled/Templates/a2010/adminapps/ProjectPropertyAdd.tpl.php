<?php
/*
 ExpressPHP Template Compiler 3.0.0 beta
 compiled from ProjectPropertyAdd.htm at 2014-03-31 17:03:40 Asia/Shanghai
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
<form action="<?php echo UrlRewriteSimple('ProjectProperty','Add',true); ?>"
	method="post" enctype="multipart/form-data" name="form1" id="form1">
    
<div class="panel">
  <div class="panel-header">
    <div class="panel-header-left"></div>
    <div class="panel-header-content">添加产品属性</div>
    <div class="panel-header-right"></div>
  </div>
  <div class="panel-body">
    <div class="panel-body-left">
      <div class="panel-body-right">
        <div class="panel-body-content">
   <table width="100%" border="0" cellspacing="0" cellpadding="5">
	<tr>
		<td width="150" align="right">产品名称：</td>
		<td><input name="ProjectName" type="text" class="input-style"
			id="ProjectName" maxlength="64" readonly="readonly" value="<?php echo $ProjectInfo[ProjectName];?>" />
            <input type="hidden" name="ProjectID" id="ProjectID" value="<?php echo $ProjectInfo[ProjectID];?>" />
            <input type="hidden" name="Page" id="Page" value="<?php echo $Page;?>" /></td>
	</tr>
	<tr>
      <td align="right">&nbsp; 一级属性名称：</td>
	  <td><select name="PropertyPropertyParentID" id="PropertyPropertyParentID">
          <option value="0" <?php if($PropertyPropertyInfo[PropertyPropertyParentID]==0) { ?>selected<?php } ?>>顶级属性</option>
          
<?php $__view__data__0__=$ParentData;if(is_array($__view__data__0__)) { foreach($__view__data__0__ as $ParenList) { ?>
          <option value="<?php echo $ParenList[PropertyPropertyID];?>" <?php if($PropertyPropertyInfo[PropertyPropertyParentID]==$ParenList[PropertyPropertyID]) { ?>selected<?php } ?>><?php echo $ParenList[PropertyPropertyName];?></option>
          
<?php } } ?>
      </select></td>
	  </tr>
	<tr>
		<td align="right">属性名称：</td>
		<td><input name="PropertyPropertyName" type="text" class="input-style" id="PropertyPropertyName" /></td>
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
</body>
</html>
