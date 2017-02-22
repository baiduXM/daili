<?php
/*
 ExpressPHP Template Compiler 3.0.0 beta
 compiled from UsersGroupsRoles.htm at 2010-01-07 01:47:01 Asia/Shanghai
*/
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><?php $this->Display("header"); ?><link href="/templates/adminapps/skin/blue/style.css" rel="stylesheet"
	type="text/css" />
</head>

<body>


<div><?php $data=self::__template_functions(array(
"class"=>"ModulesModule",
"function"=>"Lists",
"AppsID"=>"0",
)
);?><form id="form1" name="form1" method="post"
	action="<?php echo UrlRewriteSimple('Users','GroupsRoles',true); ?>">

<div class="block"></div>


<div class="data-line-border-f0f0f0">
<div class="UserBodyTitle">权限管理</div>
<div class="font-12px">
<table width="100%" border="0" cellpadding="5" cellspacing="0"
	class="DataGird">
	<tr>
		<td width="150" align="center">用户组:</td>
		<td><?php echo $UserGroupDetail[GroupName];?></td>
	</tr>
</table>
</div>
</div>
<div class="data-line-border-f0f0f0">
<div class="font-12px">
<table width="100%" border="0" cellspacing="0" cellpadding="5"
	class="DataGird">
	<tr>
		<th align="left" class="vertical-line">模块名称 <input
			name="selectall" type="checkbox" value=""
			onclick="FormCheckAll(this,'rolelist');" />全选</th>
	</tr>
<?php $__view__data__0__=$data;if(is_array($__view__data__0__)) { foreach($__view__data__0__ as $list) { ?>
	<tr>
		<td>&nbsp;<?php echo str_repeat('&nbsp;',$list[Level]*5); echo $list[Level];?>.<?php echo $list[DisplayOrder];?>&nbsp;
		<input name="Roles[]" type="checkbox" id="Roles[]"
			value="<?php if($list[Property]) { echo $list[ModuleClass].$list[ModuleAction]; } else { echo $list[ModuleID];?><?php } ?>"<?php if(in_array(($list[Property]?$list[ModuleClass].$list[ModuleAction]:$list[ModuleID]),$UserGroupDetail[Roles])) { ?>checked="checked"
			<?php } ?> class="rolelist" /> &nbsp;&nbsp;<?php echo $list[ModuleName];?></td>
	</tr>
	
<?php } } ?>
</table>


</div>

<div class="clear"></div>
</div>

<div style="padding-left: 100px; line-height: 50px; height: 50px;">
<input name="selectall" type="checkbox" value=""
	onclick="FormCheckAll(this,'rolelist');" />全选 &nbsp;&nbsp;<input
	name="button" type="submit" class="btn" id="button" value=" 更 新 " /> <input
	name="button2" type="reset" class="btn" id="button2" value=" 重 置 " />
<input name="UserGroupID" type="hidden" id="UserGroupID"
	value="<?php echo $UserGroupID;?>" /></div>
</form>
</div>
</body>
</html>
