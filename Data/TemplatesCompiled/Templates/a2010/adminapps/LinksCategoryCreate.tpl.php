<?php
/*
 ExpressPHP Template Compiler 3.0.0 beta
 compiled from LinksCategoryCreate.htm at 2010-01-07 01:47:00 Asia/Shanghai
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
<form
	action="<?php echo UrlRewriteSimple('LinksCategory','CreateSave',true); ?>"
	method="post" name="form1" id="form1">
<div class="panel">
  <div class="panel-header">
    <div class="panel-header-left"></div>
    <div class="panel-header-content">新增/编辑外链目录</div>
    <div class="panel-header-right"></div>
  </div>
  <div class="panel-body">
    <div class="panel-body-left">
      <div class="panel-body-right">
        <div class="panel-body-content">
       <table width="100%" border="0" cellspacing="0" cellpadding="5">
	<tr>
		<td width="15%" align="right">目录名称:</td>
		<td><input name="CategoryName" type="text"
			class="input-notsize-style" id="CategoryName"
			value="<?php echo self::__htmlspecialchars($Detail[CategoryName]); ?>" /></td>
	</tr><?php if(!$Detail) { ?>	<tr>
		<td align="right">父级目录:</td>
		<td><select name="ParentCategoryID" id="ParentCategoryID">
			<option value="0">&nbsp;&nbsp;Top&nbsp;&nbsp;</option>
<?php $__view__data__0__=$data;if(is_array($__view__data__0__)) { foreach($__view__data__0__ as $list) { ?>
			<option value="<?php echo $list[CategoryID];?>">&nbsp;&nbsp;<?php echo str_repeat('&nbsp;',$list[Level]*3); ?>|- <?php echo $list[CategoryName];?></option>
			
<?php } } ?>
</select></td>
	</tr>
	<?php } ?><tr>
		<td align="right">目录别名:</td>
		<td><input name="Alias" type="text" class="input-notsize-style"
			id="Alias" value="<?php echo $Detail[Alias];?>" /></td>
	</tr>
	<tr>
		<td align="right">同级排序:</td>
		<td><input name="DisplayOrder" type="text"
			class="input-notsize-style" id="DisplayOrder"
			value="<?php echo self::__htmlspecialchars($Detail[DisplayOrder]); ?>" /></td>
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


<div style="padding-left: 100px; line-height: 50px; height: 50px;"><input
	name="button" type="submit" class="btn" id="button" value=" 保 存 " /> <input
	name="button2" type="reset" class="btn" id="button2" value=" 重 置 " /><?php if($Detail) { ?> <input name="CategoryID" type="hidden"
	value="<?php echo $Detail[CategoryID];?>" /> <?php } ?></div>

</form>
</body>
</html>
