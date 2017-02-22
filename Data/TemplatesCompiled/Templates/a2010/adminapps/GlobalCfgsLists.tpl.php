<?php
/*
 ExpressPHP Template Compiler 3.0.0 beta
 compiled from GlobalCfgsLists.htm at 2010-01-07 01:47:00 Asia/Shanghai
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
<script type="text/javascript">
function VariableDelete(VariableName){
	var data = "VariableName="+encodeURI(VariableName)+'&r='+Math.random();
	$.ajax({
		type: "POST",
		url: "?module=GlobalCfgs&action=Delete",
		data: data,
		dataType: "json",
		success: VariableDeleteResponse
	});	
}

function VariableDeleteResponse(Result){
	if(Result.Code=='Succ'){
		alert(Result.Message);
		location.reload();
	}
	else {
		alert(Result.Message);
	}
}
</script>
<body>

<div class="panel">
  <div class="panel-header">
    <div class="panel-header-left"></div>
    <div class="panel-header-content">全局参数</div>
    <div class="panel-header-right"></div>
  </div>
  <div class="panel-body">
    <div class="panel-body-left">
      <div class="panel-body-right">
        <div class="panel-body-content">
   <table width="100%" border="0" cellspacing="0" cellpadding="5"
	class="DataGird">
	<tr>
		<th width="150" class="vertical-line">#参数名</th>
		<th width="300" align="left" class="vertical-line">参数说明</th>
		<th align="left" class="vertical-line">参数值</th>
		<th align="left">操作</th>
	</tr>
<?php $__view__data__0__=$data;if(is_array($__view__data__0__)) { foreach($__view__data__0__ as $list) { ?>
	<tr>
		<td align="left">&nbsp;<?php echo $list[VariableName];?></td>
		<td>&nbsp;<?php echo $list[VariableDescribe];?></td>
		<td align="left"><?php if($list[VariableType]==0) { echo _substr($list[VariableValue],80); } else { ?>(数组数据不提供预览)<?php } ?></td>
		<td align="left">&nbsp; <a
			href="<?php echo UrlRewriteSimple('GlobalCfgs','Lists',true); ?>&VariableName=<?php echo $list[VariableName];?>">修改</a>
		&nbsp; | &nbsp;<a href="javascript:;"
			onclick="if(confirm('您确认将删除该参数\'<?php echo $list[VariableName];?>\'?')){VariableDelete('<?php echo $list[VariableName];?>');}else {return false;}">删除</a>
		&nbsp;</td>
	</tr>
	
<?php } } ?>
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


<form action="<?php echo UrlRewriteSimple('GlobalCfgs','Update',true); ?>"
	method="post" name="form1" id="form1">
<div class="panel">
  <div class="panel-header">
    <div class="panel-header-left"></div>
    <div class="panel-header-content">新建/编辑全局参数</div>
    <div class="panel-header-right"></div>
  </div>
  <div class="panel-body">
    <div class="panel-body-left">
      <div class="panel-body-right">
        <div class="panel-body-content">
   <table width="100%" border="0" cellspacing="0" cellpadding="5">
	<tr>
		<td width="15%" align="right" valign="top">参数名:</td>
		<td valign="top"><input name="VariableName" type="text"
			class="input-notsize-style" id="VariableName" size="40"
			maxlength="64" value="<?php echo self::__htmlspecialchars($Detail[VariableName]); ?>" /></td>
	</tr>
	<tr>
		<td align="right" valign="top">参数说明:</td>
		<td valign="top"><input name="VariableDescribe" type="text"
			class="input-notsize-style" id="VariableDescribe" size="40"
			maxlength="60" value="<?php echo self::__htmlspecialchars($Detail[VariableDescribe]); ?>" /></td>
	</tr>
	<tr>
		<td align="right" valign="top">参数类型:</td>
		<td valign="top">
<?php $__view__data__0__0__=$VariableTypes;  if(is_array($__view__data__0__0__)) { foreach($__view__data__0__0__ as $id => $title) { ?>
<input
			type="radio" name="VariableType" id="radio" value="<?php echo $id;?>"<?php if($Detail[VariableType]==$id) { ?>checked= "checked"<?php } ?> /><?php echo $title;?>
<?php } }  ?>
</td>
	</tr>
	<tr>
		<td align="right" valign="top">参数值:</td>
		<td valign="top"><textarea name="VariableValue" cols="70"
			rows="5" id="VariableValue"><?php echo self::__htmlspecialchars($Detail[VariableValue]); ?></textarea></td>
	</tr>
	<tr>
		<td align="right" valign="top">&nbsp;</td>
		<td valign="top">&nbsp;</td>
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


<div style="padding-left: 100px; line-height: 35px;"><input
	name="button" type="submit" class="btn" id="button" value=" 保 存 " /> <input
	name="button2" type="reset" class="btn" id="button2" value=" 重 置 " /></div>

</form>

<div class="panel">
  <div class="panel-header">
    <div class="panel-header-left"></div>
    <div class="panel-header-content">调用说明</div>
    <div class="panel-header-right"></div>
  </div>
  <div class="panel-body">
    <div class="panel-body-left">
      <div class="panel-body-right">
        <div class="panel-body-content">
         <div class="font-12px" style="line-height: 20px;">
<p>&nbsp;&nbsp;&nbsp;&nbsp;1. 该模块为ExpressPHP核心模块, 在整站任何地方均可以调用!</p>
<p>&nbsp;&nbsp;&nbsp;&nbsp;2. 调用函数方法: __GlobalParameters('参数名')</p>
<p>&nbsp;&nbsp;&nbsp;&nbsp;3. 模板中应用方法: {echo
__GlobalParameters('SiteName')}</p>
</div>
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
