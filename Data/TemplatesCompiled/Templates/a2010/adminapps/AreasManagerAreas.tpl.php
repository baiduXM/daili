<?php
/*
 ExpressPHP Template Compiler 3.0.0 beta
 compiled from AreasManagerAreas.htm at 2010-01-07 01:47:00 Asia/Shanghai
*/
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><?php $this->Display("header"); ?><style type="text/css">
<!--
@import url("/Templates/a2010/adminapps/images/style.css");
-->
</style>
<script language="javascript" type="text/javascript">
function GetNewAreaID(ParentAreaID){
	var data = "Action=GetNewAreaID&ParentAreaID="+ParentAreaID+'&r='+Math.random();
	$.ajax({
		type: "GET",
		url: "/GetParameter.php",
		data: data,
		dataType: "json",
		success: GetNewAreaIDResponse
	});	
}
function FormCheckAll(obj,objClassName){
	if(obj.checked){
		$('.'+objClassName).each(function(){
			this.checked=true;
		});
	}
	else {
		$('.'+objClassName).each(function(){
			this.checked=false;
		});
	}
}
function GetNewAreaIDResponse(Result){
	var data = Result;
	if(data.Code=='succ'){
		$('#AreaID').val(data.Data.NewAreaID);	
	}
	else {
		alert(data.Message);
	}
}
</script>
</head>

<body>

<form id="form1" name="form1" method="post"
	action="<?php echo UrlRewriteSimple('AreasManager','Areas',true); ?>">
<div class="panel">
  <div class="panel-header">
    <div class="panel-header-left"></div>
    <div class="panel-header-content">模块管理</div>
    <div class="panel-header-right"></div>
  </div>
  <div class="panel-body">
    <div class="panel-body-left">
      <div class="panel-body-right">
        <div class="panel-body-content">
        <div><span
	class="font-not-style font-12px">(当前目录: <a
	href="<?php echo UrlRewriteSimple('AreasManager','Areas'); ?>&ParentAreaID=-1">所有</a>
&gt; <a href="<?php echo UrlRewriteSimple('AreasManager','Areas'); ?>">Top</a>
<?php $__view__data__0__=GetAreaParents($ParentAreaID);if(is_array($__view__data__0__)) { foreach($__view__data__0__ as $l) { ?>
&gt; <a
	href="<?php echo UrlRewriteSimple('AreasManager','Areas'); ?>&ParentAreaID=<?php echo $l[AreaID];?>"><?php echo $l[AreaName];?></a>
<?php } } ?>
)</span></div>
          <table width="100%" border="0" cellspacing="0" cellpadding="5"
	class="DataGird">
	<tr>
		<th width="50" class="vertical-line"><input type="checkbox"
			name="AllSelect" class="AllSelect"
			onclick="FormCheckAll(this, 'AreaSelect')" /></th>
		<th width="70" class="vertical-line">ID</th>
		<th width="100" align="left" class="vertical-line">全称</th>
		<th width="100" align="left" class="vertical-line">简称</th>
		<th align="left" class="vertical-line">缩写</th>
		<th align="left" class="vertical-line">拼音</th>
		<th width="80" class="vertical-line">性质</th>
		<th width="80" class="vertical-line">热门</th>
		<th width="120" class="vertical-line">分组</th>
		<th width="100">操作</th>
	</tr>
<?php $__view__data__0__=GetAreas($ParentAreaID);if(is_array($__view__data__0__)) { foreach($__view__data__0__ as $list) { ?>
	<tr>
		<td align="center"><input type="checkbox" name="AreaID[]"
			id="checkbox" value="<?php echo $list[AreaID];?>" class="AreaSelect" /></td>
		<td align="center" nowrap="nowrap"><?php echo $list[AreaID];?></td>
		<td nowrap="nowrap">&nbsp;<?php echo $list[AreaName];?></td>
		<td nowrap="nowrap">&nbsp;<?php echo $list[ShortName];?></td>
		<td nowrap="nowrap">&nbsp;<?php echo $list[Ab];?></td>
		<td nowrap="nowrap">&nbsp;<?php echo $list[Alias];?></td>
		<td align="center" nowrap="nowrap"><?php echo $AreaProperty[$list[Property]];?></td>
		<td align="center" nowrap="nowrap"><?php if($list[IsTop]) { ?>是<?php } else { ?>&nbsp;<?php } ?></td>
		<td nowrap="nowrap">&nbsp;<?php echo GetAreaGroupName($list[GroupID]); ?></td>
		<td align="center"><a
			href="<?php echo UrlRewriteSimple('AreasManager','Areas'); ?>&ParentAreaID=<?php echo $list[AreaID];?>">下级区域</a>
		| <a
			href="<?php echo UrlRewriteSimple('AreasManager','Areas'); ?>&AreaID=<?php echo $list[AreaID];?>#Modify">编辑</a></td>
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
<div
	style="padding-left: 10px; line-height: 35px; height: 35px; font-size: 12px;"
	class="font-12px">设置分组: <select name="GroupID" id="GroupID">
	<option value="0">选择分组...</option>
<?php $__view__data__0__=GetAreaGroups();if(is_array($__view__data__0__)) { foreach($__view__data__0__ as $list) { ?>
	<option value="<?php echo $list[GroupID];?>"><?php echo $list[GroupName];?></option>
	
<?php } } ?>
</select> <input name="button" type="submit" class="btn" id="button" value="设置分组"
	onclick="this.form.OP.value='SetGroup';" /> 设置为 <input name="button2"
	type="submit" class="btn" id="button2" value="城市"
	onclick="this.form.OP.value='SetIsCity';" /> <input name="button2"
	type="submit" class="btn" id="button2" value="省"
	onclick="this.form.OP.value='SetIsState';" /> <input name="button2"
	type="submit" class="btn" id="button2" value="县/镇/区"
	onclick="this.form.OP.value='SetIsTown';" /> <input name="button2"
	type="submit" class="btn" id="button2" value="热门"
	onclick="this.form.OP.value='SetIsTop';" /> <input name="button2"
	type="submit" class="btn" id="button2" value="取消热门"
	onclick="this.form.OP.value='SetUnIsTop';" /> </span> <input name="OP"
	type="hidden" id="OP" value="SetGroup" /> <input name="ParentAreaID"
	type="hidden" value="<?php echo $ParentAreaID;?>" /></div>
</form>

<a name="Modify"></a>
<form id="form2" name="form2" method="post"
	action="<?php echo UrlRewriteSimple('AreasManager','AreasSave',true); ?>">
    
<div class="panel">
  <div class="panel-header">
    <div class="panel-header-left"></div>
    <div class="panel-header-content">新增/编辑区域</div>
    <div class="panel-header-right"></div>
  </div>
  <div class="panel-body">
    <div class="panel-body-left">
      <div class="panel-body-right">
        <div class="panel-body-content">
          <table width="100%" border="0" cellspacing="0" cellpadding="5">
	<tr>
		<td align="right">父级区域:</td>
		<td><select name="ParentAreaID" id="ParentAreaID"
			onchange="GetNewAreaID(this.value)">
			<option value="0">-- Top --</option>
<?php $__view__data__0__=GetCategoryToOptions();if(is_array($__view__data__0__)) { foreach($__view__data__0__ as $list) { ?>
			<option value="<?php echo $list[AreaID];?>"<?php if($AreaDetail[ParentAreaID]==$list[AreaID]) { ?> selected="selected"<?php } ?>><?php if($list[Level]==1) { ?>&nbsp;&nbsp; - <?php } elseif($list[level]==2) { ?>&nbsp;&nbsp;&nbsp;-<?php } else { ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -
			<?php } echo $list[AreaName];?></option>
			
<?php } } ?>
</select></td>
	</tr>
	<tr>
		<td width="150" align="right">区域ID:</td>
		<td><input name="AreaID" type="text" class="input-notsize-style"
			id="AreaID" value="<?php echo self::__htmlspecialchars($AreaDetail[AreaID]); ?>" /> , <span
			style="color: #990">提醒: ID有一定的规则,请严格遵守.</span></td>
	</tr>
	<tr>
		<td align="right">区域全称:</td>
		<td><input name="AreaName" type="text"
			class="input-notsize-style" id="AreaName"
			value="<?php echo self::__htmlspecialchars($AreaDetail[AreaName]); ?>" /></td>
	</tr>
	<tr>
		<td align="right">区域简称:</td>
		<td><input name="ShortName" type="text"
			class="input-notsize-style" id="ShortName"
			value="<?php echo self::__htmlspecialchars($AreaDetail[ShortName]); ?>" /></td>
	</tr>
	<tr>
		<td align="right">缩写:</td>
		<td><input name="Ab" type="text" class="input-notsize-style"
			id="Ab" value="<?php echo self::__htmlspecialchars($AreaDetail[Ab]); ?>" /></td>
	</tr>
	<tr>
		<td align="right">拼音:</td>
		<td><input name="Alias" type="text" class="input-notsize-style"
			id="Alias" value="<?php echo self::__htmlspecialchars($AreaDetail[Alias]); ?>" /></td>
	</tr>

	<tr>
		<td align="right">性质:</td>
		<td><input type="radio" name="Property" id="IsCity" value="1"<?php if($AreaDetail[Property]==1) { ?>checked= "checked"<?php } ?> /> 城市 <input
			type="radio" name="Property" id="IsCity2" value="0"<?php if($AreaDetail[Property]==0) { ?>checked= "checked"<?php } ?> /> 省/洲 <input
			type="radio" name="Property" id="IsCity2" value="2"<?php if(!$AreaDetail[Property]==2) { ?>checked= "checked"<?php } ?> /> 县/区/镇</td>
	</tr>
	<tr>
		<td align="right">分组:</td>
		<td><select name="GroupID" id="GroupID">
			<option value="0">选择分组...</option>
<?php $__view__data__0__=GetAreaGroups();if(is_array($__view__data__0__)) { foreach($__view__data__0__ as $list) { ?>
			<option value="<?php echo $list[GroupID];?>"<?php if($AreaDetail[GroupID]==$list[GroupID]) { ?> selected="selected"<?php } ?>><?php echo $list[GroupName];?></option>
			
<?php } } ?>
</select></td>
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
    
<div style="padding-left: 100px;  height: 50px;"><input
	name="button" type="submit" class="btn" id="button" value=" 保 存 " /> <input
	name="button2" type="reset" class="btn" id="button2" value=" 重 置 " />
</div>

</form>

</body>
</html>
