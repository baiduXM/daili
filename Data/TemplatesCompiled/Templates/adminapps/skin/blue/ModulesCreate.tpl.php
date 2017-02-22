<?php
/*
 ExpressPHP Template Compiler 3.0.0 beta
 compiled from ModulesCreate.htm at 2010-01-07 01:47:01 Asia/Shanghai
*/
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><?php $this->Display("header"); ?><link href="/templates/adminapps/skin/blue/style.css" rel="stylesheet"
	type="text/css" />

<script type="text/javascript">
function ClearSelectOption(obj){
	obj.options.length=0;
}
function $$(n, d) { 
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}
var ViewsData = [];
function GetModules(AppsID){
	$$('ViewsFunctions').options.length=0;
	var data = "AppsID="+AppsID+'&r='+Math.random();
	$.ajax({
		type: "GET",
		url: "?module=Modules&action=ViewExport",
		data: data,
		dataType: "json",
		success: GetModulesResponse
	});	
}

function GetModulesResponse(Result){
	var data = Result;
	var counter =  data['Data'] ? data['Data'].length : 0;
	var obj = $$('ViewsFunctions');
	if(data['Code']=='Succ'){
		for(var i=0;i<counter;i++){
			var tmpName = '';
			if(data['Data'][i].sViewName){
				tmpName = data['Data'][i].sViewName;
			}
			else {
				tmpName = '';
			}
			var id = '';
			id = data['Data'][i].sClassName+','+data['Data'][i].sView;
			ViewsData [id] = {
				'sViewName':tmpName,
				'sClassName':data['Data'][i].sClassName,
				'sView':data['Data'][i].sView,
				'ViewerEngine':data['Data'][i].ViewerEngine
			};
			var title = tmpName+' : '+data['Data'][i].sClassName+'::'+data['Data'][i].sView+' : '+(data['Data'][i].sRuleProperty?'需验证':'不需要验证');
			obj.options[i] = new Option(title, id);
		}
	}
	else{
		alert(data['Message']);
	}

}

function GetModules2(AppsID){
	$$('Views').options.length=0;
	var data = "AppsID="+AppsID+'&r='+Math.random();
	$.ajax({
		type: "GET",
		url: "?module=Modules&action=ViewExport",
		data: data,
		dataType: "json",
		success: GetModules2Response
	});	
}

function GetModules2Response(Result){
	var data = Result;
	var obj = $$('Views');
	var counter =  data['Data'] ? data['Data'].length : 0;
	if(data['Code']=='Succ'){
		for(var i=0;i<counter;i++){
			var tmpName = '';
			if(data['Data'][i].sViewName){
				tmpName = data['Data'][i].sViewName;
			}
			else {
				tmpName = '';
			}
			var id = data['Data'][i].sRuleID;
			var title = tmpName+' : '+data['Data'][i].sClassName+'::'+data['Data'][i].sView+' : '+(data['Data'][i].sRuleProperty?'需验证':'不需要验证');
			obj.options[i] = new Option(title, data['Data'][i].sClassName+','+data['Data'][i].sView+','+ tmpName+','+data['Data'][i].ViewerEngine);
		}
	}
	else{
		alert(data['Message']);
	}
}

function setField(id){
	$('#ModuleName').val(ViewsData[id].sViewName);
	$('#ModuleClass').val(ViewsData[id].sClassName);
	$('#ModuleAction').val(ViewsData[id].sView);
	$('#ViewerEngine').val(ViewsData[id].ViewerEngine);
}
</script>

</head>

<body>
<div class="block">&nbsp;</div>
<div>
<form action="<?php echo UrlRewriteSimple('Modules','Create',true); ?>"
	method="post" name="form1" id="form1">

<div class="UserBodyTitle">编辑模块</div>
<div class="data-line-border-f0f0f0">
<div class="block"></div>
<div class="font-12px">
<table width="100%" border="0" cellspacing="0" cellpadding="5">
	<tr>
		<td width="15%" align="right">模块名称:</td>
		<td><input name="ModuleName" type="text"
			class="input-notsize-style" id="ModuleName" value="" /></td>
		<td width="40%"><b>自动获取接口目录下所有视图和方法</b></td>
	</tr>
	<tr>
		<td align="right">性质:</td>
		<td><select name="Property" id="Property">
<?php $__view__data__0__0__=$Propertys;  if(is_array($__view__data__0__0__)) { foreach($__view__data__0__0__ as $id => $title) { ?>
<option value="<?php echo $id;?>"><?php echo $title;?></option>
<?php } }  ?>
</select></td>
		<td rowspan="7" valign="top">
		<table width="350" border="0">
			<tr>
				<td><select name="TargetAppsID" id="TargetAppsID">
<?php $__view__data__0__=$Apps;if(is_array($__view__data__0__)) { foreach($__view__data__0__ as $list) { ?>
					<option value="<?php echo $list[AppsID];?>"><?php echo $list[AppsName];?></option>
					
<?php } } ?>
</select> <input name="button3" type="button" class="btn-foreapps"
					id="button3" value=" 导入 "
					onclick="GetModules(this.form.TargetAppsID.value)" /></td>
			</tr>
			<tr>
				<td><select name="ViewsFunctions" size="10" id="ViewsFunctions"
					style="width: 98%;" onclick="setField(this.value)">
				</select></td>
			</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td align="right">父级目录:</td>
		<td><select name="ParentModuleID" id="ParentModuleID">
			<option value="0">&nbsp;&nbsp;Top&nbsp;&nbsp;</option>
<?php $__view__data__0__=$Categories;if(is_array($__view__data__0__)) { foreach($__view__data__0__ as $list) { ?>
			<option value="<?php echo $list[ModuleID];?>">&nbsp;&nbsp;<?php echo str_repeat('&nbsp;',$list[Level]*3); ?>|- <?php echo $list[ModuleName];?></option>
			
<?php } } ?>
</select></td>
	</tr>
	<tr>
		<td align="right">模块接口ID:</td>
		<td><select name="AppsID" id="AppsID">
<?php $__view__data__0__=$Apps;if(is_array($__view__data__0__)) { foreach($__view__data__0__ as $list) { ?>
			<option value="<?php echo $list[AppsID];?>"><?php echo $list[AppsName];?></option>
			
<?php } } ?>
</select></td>
	</tr>
	<tr>
		<td align="right">模块视图类:</td>
		<td><input name="ModuleClass" type="text"
			class="input-notsize-style" id="ModuleClass" value="" maxlength="10" /></td>
	</tr>
	<tr>
		<td align="right">模块视图方法:</td>
		<td><input name="ModuleAction" type="text"
			class="input-notsize-style" id="ModuleAction" maxlength="64" /></td>
	</tr>
	<tr>
		<td align="right">模块视图输出方式：</td>
		<td><input name="ViewerEngine" type="text"
			class="input-notsize-style" id="ViewerEngine" value="" maxlength="64" /></td>
	</tr>
	<tr>
		<td align="right">同级排序:</td>
		<td><input name="DisplayOrder" type="text"
			class="input-notsize-style" id="DisplayOrder" /></td>
	</tr>
</table>
</div>

</div>
<div style="padding-left: 100px; line-height: 50px; height: 50px;"><input
	name="button" type="submit" class="btn" id="button" value=" 保 存 " /> <input
	name="button2" type="reset" class="btn" id="button2" value=" 重 置 " /></div>

</form>
</div>
<div class="clear"></div>

<div class="block">&nbsp;</div>
<div>
<form action="<?php echo UrlRewriteSimple('Modules','ViewImport',true); ?>"
	method="post" name="form1" id="form1">

<div class="UserBodyTitle">导入视图模块</div>
<div class="data-line-border-f0f0f0">
<div class="block"></div>
<div class="font-12px">
<table width="100%" border="0" cellspacing="0" cellpadding="5">
	<tr>
		<td align="right" valign="top">父级目录:</td>
		<td valign="top"><select name="ParentModuleID"
			id="ParentModuleID">
			<option value="0">&nbsp;&nbsp;Top&nbsp;&nbsp;</option>
<?php $__view__data__0__=$Categories;if(is_array($__view__data__0__)) { foreach($__view__data__0__ as $list) { ?>
			<option value="<?php echo $list[ModuleID];?>">&nbsp;&nbsp;<?php echo str_repeat('&nbsp;',$list[Level]*3); ?>|- <?php echo $list[ModuleName];?></option>
			
<?php } } ?>
</select></td>
	</tr>
	<tr>
		<td align="right" valign="top">选择视图:</td>
		<td valign="top">
		<table width="450" border="0">
			<tr>
				<td><select name="AppsID" id="AppsID">
<?php $__view__data__0__=$Apps;if(is_array($__view__data__0__)) { foreach($__view__data__0__ as $list) { ?>
					<option value="<?php echo $list[AppsID];?>"><?php echo $list[AppsName];?></option>
					
<?php } } ?>
</select> <input name="button" type="button" class="btn-foreapps"
					value=" 导入 " onclick="GetModules2(this.form.AppsID.value)" /></td>
			</tr>
			<tr>
				<td><select name="Views[]" size="10" multiple="multiple"
					id="Views" style="width: 98%;">
				</select></td>
			</tr>
		</table>
		</td>
	</tr>
</table>
</div>

</div>
<div style="padding-left: 100px; line-height: 50px; height: 50px;"><input
	name="button" type="submit" class="btn" id="button" value=" 保 存 " /> <input
	name="button2" type="reset" class="btn" id="button2" value=" 重 置 " /></div>

</form>
</div>
<div class="clear"></div>
</body>
</html>
