<?php
/*
 ExpressPHP Template Compiler 3.0.0 beta
 compiled from UsersGroupsRoles.htm at 2010-01-07 01:47:01 Asia/Shanghai
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


<div><?php $data=self::__template_functions(array(
"class"=>"ModulesModule",
"function"=>"Lists",
"AppsID"=>"0",
)
);?><form id="form1" name="form1" method="post"
	action="<?php echo UrlRewriteSimple('Users','GroupsRoles',true); ?>">
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
          <table width="100%" border="0" cellpadding="5" cellspacing="0"
	class="DataGird">
	<tr>
		<td width="150" align="left">用户组:</td>
		<td><?php echo $UserGroupDetail[GroupName];?></td>
	</tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="5"
	class="DataGird">
	<tr>
		<th align="left" class="vertical-line">权限列表: <input
			name="selectall" type="checkbox" value=""
			onclick="FormCheckAll(this,'rolelist');" />全选</th>
	</tr>

</table>
<?php $__view__data__0__=$data;if(is_array($__view__data__0__)) { foreach($__view__data__0__ as $list) { ?>
	<div style="<?php if($list[Level]>=2&&$list[Property]) { ?>float:left;<?php } else { ?>clear:both;<?php } ?>  margin: 0px 10px 0px 0px;line-height:25px;">
&nbsp;<?php echo str_repeat('&nbsp;',$list[Level]*6); ?><input name="Roles[]" type="checkbox" id="Roles[]"
			value="<?php if($list[Property]) { echo $list[ModuleClass].$list[ModuleAction]; } else { echo $list[ModuleID];?><?php } ?>"<?php if(in_array(($list[Property]?$list[ModuleClass].$list[ModuleAction]:$list[ModuleID]),$UserGroupDetail[Roles])) { ?>checked="checked"
			<?php } ?> class="rolelist" /> &nbsp;&nbsp;<?php echo $list[ModuleName];?></div>
	
<?php } } ?>
    <div class="clear"></div>
        </div>
      </div>
    </div>
  </div>
  <div class="panel-footer">
    <div class="panel-footer-left"></div>
    <div class="panel-footer-right"></div>
  </div>
</div>

<div style="padding-left: 100px; line-height: 50px; height: 50px;">
<input name="selectall" type="checkbox" value=""
	onclick="FormCheckAll(this,'rolelist');" />全选 &nbsp;&nbsp;<input
	name="button" type="submit" class="btn" id="button" value=" 更 新 " /> <input
	name="button2" type="reset" class="btn" id="button2" value=" 重 置 " />
<input name="UserGroupID" type="hidden" id="UserGroupID"
	value="<?php echo $UserGroupID;?>" /></div>
</form>
</body>
</html>
