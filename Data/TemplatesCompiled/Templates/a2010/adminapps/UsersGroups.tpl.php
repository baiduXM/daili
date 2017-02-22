<?php
/*
 ExpressPHP Template Compiler 3.0.0 beta
 compiled from UsersGroups.htm at 2014-03-20 10:39:14 Asia/Shanghai
*/
?><html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><?php $this->Display("header"); ?><style type="text/css">
<!--
@import url("/Templates/a2010/adminapps/images/style.css");
-->
</style>
</head>

<body>
<div>

<div class="panel">
  <div class="panel-header">
    <div class="panel-header-left"></div>
    <div class="panel-header-content">用户组管理</div>
    <div class="panel-header-right"></div>
  </div>
  <div class="panel-body">
    <div class="panel-body-left">
      <div class="panel-body-right">
        <div class="panel-body-content">
          <table width="100%" border="0" cellspacing="0" cellpadding="5"
	class="DataGird">
	<tr>
		<th width="50" class="vertical-line">#ID</th>
		<th width="100" align="left" class="vertical-line">用户组名称</th>
		<th align="left" width="100" class="vertical-line">性质</th>
		<th width="40" class="vertical-line">默认</th>
		<th width="40" class="vertical-line">注册?</th>
		<th width="80" nowrap="nowrap" class="vertical-line">注册状态</th>
		<th width="40" class="vertical-line">登陆</th>
		<th align="left">操作</th>
	</tr>
<?php $__view__data__0__=$data;if(is_array($__view__data__0__)) { foreach($__view__data__0__ as $list) { ?>
	<tr>
		<td align="center"><?php echo $list[UserGroupID];?></td>
		<td>&nbsp;<?php echo $list[GroupName];?></td>
		<td>&nbsp;<?php echo $ArrIsRoot[$list[IsRoot]];?></td>
		<td align="center"><?php echo $ArrIsDefault[$list[IsDefault]];?></td>
		<td align="center"><?php echo $ArrRegEnable[$list[RegEnable]];?></td>
		<td align="center"><?php echo $ArrRegStatus[$list[RegStatus]];?></td>
		<td align="center"><?php echo $ArrLoginStatus[$list[LoginStatus]];?></td>
		<td align="left"><a
			href="<?php echo UrlRewriteSimple('Users','Groups'); ?>&UserGroupID=<?php echo $list[UserGroupID];?>">编辑</a><?php if($list[UserGroupID]>1002) { ?> &nbsp;|&nbsp; <a
			href="<?php echo UrlRewriteSimple('Users','GroupsDelete'); ?>&UserGroupID=<?php echo $list[UserGroupID];?>">删除</a><?php } if(!$list[IsDefault]) { ?> <!--&nbsp;|&nbsp; <a
			href="<?php echo UrlRewriteSimple('Users','GroupsSetDefault'); ?>&UserGroupID=<?php echo $list[UserGroupID];?>">默认注册组</a>--><?php } ?>&nbsp;|&nbsp;
		<a
			href="<?php echo UrlRewriteSimple('Users','GroupsRoles'); ?>&UserGroupID=<?php echo $list[UserGroupID];?>">权限设置</a>&nbsp;|&nbsp;
		<a
			href="<?php echo UrlRewriteSimple('Users','Manager'); ?>&UserGroupID=<?php echo $list[UserGroupID];?>">用户列表</a>
		</td>
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


</div>
<div>
<form id="form1" name="form1" method="post"
	action="<?php echo UrlRewriteSimple('Users','GroupsSave',true); ?>">
    
<div class="panel">
  <div class="panel-header">
    <div class="panel-header-left"></div>
    <div class="panel-header-content">新增/编辑用户组</div>
    <div class="panel-header-right"></div>
  </div>
  <div class="panel-body">
    <div class="panel-body-left">
      <div class="panel-body-right">
        <div class="panel-body-content">
          <table width="100%" border="0" cellspacing="0" cellpadding="5">
	<tr>
		<td width="150" align="right">用户组名称:</td>
		<td><input name="GroupName" type="text"
			class="input-notsize-style" id="GroupName"
			value="<?php echo self::__htmlspecialchars($UserGroupDetail[GroupName]); ?>" /></td>
	</tr>
	<tr>
		<td align="right">性质:</td>
		<td><select name="IsRoot" id="IsRoot">
<?php $__view__data__0__0__=$ArrIsRoot;  if(is_array($__view__data__0__0__)) { foreach($__view__data__0__0__ as $key => $title) { ?>
<option value="<?php echo $key;?>" <?php if($UserGroupDetail[IsRoot]==$key) { ?>				selected="selected"<?php } ?> ><?php echo $title;?></option>
<?php } }  ?>
</select></td>
	</tr>
	<tr>
		<td align="right">是否允许注册:</td>
		<td><select name="RegEnable" id="RegEnable">
<?php $__view__data__0__0__=$ArrRegEnable;  if(is_array($__view__data__0__0__)) { foreach($__view__data__0__0__ as $key => $title) { ?>
<option value="<?php echo $key;?>" <?php if($UserGroupDetail[RegEnable]==$key) { ?>				selected="selected"<?php } ?> ><?php echo $title;?></option>
<?php } }  ?>
</select></td>
	</tr>
	<tr>
		<td align="right">注册状态:</td>
		<td><select name="RegStatus" id="RegStatus">
<?php $__view__data__0__0__=$ArrRegStatus;  if(is_array($__view__data__0__0__)) { foreach($__view__data__0__0__ as $key => $title) { ?>
<option value="<?php echo $key;?>" <?php if($UserGroupDetail[RegStatus]==$key) { ?>				selected="selected"<?php } ?> ><?php echo $title;?></option>
<?php } }  ?>
</select></td>
	</tr>
	<tr>
		<td align="right">是否允许登陆:</td>
		<td><select name="LoginStatus" id="LoginStatus">
<?php $__view__data__0__0__=$ArrLoginStatus;  if(is_array($__view__data__0__0__)) { foreach($__view__data__0__0__ as $key => $title) { ?>
<option value="<?php echo $key;?>" <?php if($UserGroupDetail[LoginStatus]==$key) { ?>				selected="selected"<?php } ?> ><?php echo $title;?></option>
<?php } }  ?>
</select></td>
	</tr>
	<tr>
		<td align="right">排序:</td>
		<td><input name="DisplayOrder" type="text"
			class="input-notsize-style" id="DisplayOrder" size="4" maxlength="4"
			value="<?php echo self::__htmlspecialchars($UserGroupDetail[DisplayOrder]); ?>" /></td>
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
<input type="hidden" name="UserGroupID" id="UserGroupID"
	value="<?php echo self::__htmlspecialchars($UserGroupDetail[UserGroupID]); ?>" /></div>

</form>

</div>
</body>
</html>
