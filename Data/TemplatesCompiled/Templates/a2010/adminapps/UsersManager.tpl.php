<?php
/*
 ExpressPHP Template Compiler 3.0.0 beta
 compiled from UsersManager.htm at 2014-04-01 00:18:32 Asia/Shanghai
*/
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><?php $this->Display("header"); ?><script language="javascript" type="text/javascript">
function Lock(UserID){
	UserSetting('Lock', UserID);
}
function Open(UserID){
	UserSetting('Open', UserID);
}
function InitPassword(UserID){
	UserSetting('InitPassword', UserID);
}
function UserSetting(Action,UserID){
	
	var data = "Action="+Action+"&UserID="+UserID+'&r='+Math.random();
	if (!UserID) return false;
	$.ajax({
		type: "POST",
		url: "<?php echo UrlRewriteSimple('Users','UserSetting'); ?>",
		data: data,
		dataType: "json",
		success: UserSettingResponse
	});	
}
function UserSettingResponse(result){
	var data = result;
	if(data['Code']=='error'){
		alert(data['Message']);
	}
	else{
		alert(data['Message']);
		location.reload();
	}
}
</script>
<style type="text/css">
<!--
@import url("/Templates/a2010/adminapps/images/style.css");
-->
</style>
</head>

<body>


<div>
<form id="form1" name="form1" method="post"
	action="<?php echo UrlRewriteSimple('Users','Manager',true); ?>">

<div class="panel">
  <div class="panel-header">
    <div class="panel-header-left"></div>
    <div class="panel-header-content">用户管理</div>
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
		<th align="left" class="vertical-line">用户名</th>
		<th align="left" width="80" class="vertical-line">用户组</th>
		<th width="40" class="vertical-line">状态</th>
		<th width="120" class="vertical-line">注册时间</th>
		<th width="150">操作</th>
	</tr>
<?php $__view__data__0__=$UserList[Data];if(is_array($__view__data__0__)) { foreach($__view__data__0__ as $list) { ?>
	<tr>
		<td align="center"><?php echo $list[UserID];?></td>
		<td>&nbsp;<?php echo $list[UserName];?></td>
		<td>&nbsp;<?php echo $UserGroups[$list[UserGroupID]];?></td>
		<td align="center"><?php echo $ArrRegStatus[$list[UserStatus]];?></td>
		<td align="center" nowrap="nowrap"
			style="font-size: 9px; font-family: Verdana, Geneva, sans-serif;"><?php echo $list[RegDateTime];?></td>
		<td align="left"><a
			href="<?php echo UrlRewriteSimple('Users','ManagerProfile',true); ?>&UserID=<?php echo $list[UserID];?>">编辑</a><?php if(!$list[UserStatus]) { ?> &nbsp;|&nbsp; <a href="javascript:;"
			onclick="Lock('<?php echo $list[UserID];?>')">禁用</a><?php } if($list[UserStatus]) { ?>		&nbsp;|&nbsp; <a href="javascript:;" onclick="Open('<?php echo $list[UserID];?>')">启用</a><?php } ?>&nbsp;|&nbsp;
		<a href="javascript:;" onclick="InitPassword('<?php echo $list[UserID];?>')"
			title="将用户登陆密码设置为 'abc123'">初始化密码</a></td>
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
    
<div style="line-height: 20px; padding-left:30px; padding-bottom:30px" class="font-12px">
<div class="float-left">查询结果: 共 <?php echo $UserList[RecordCount];?>个用户&nbsp;&nbsp;&nbsp;第 <?php echo $UserList[Page];?>/<?php echo $UserList[PageCount];?> 页.</div>
<div class="float-right"><?php if($UserList[FirstPage]) { ?><a
	href="<?php echo $MultiPageUrl;?>&Page=<?php echo $UserList[FirstPage];?>">首页</a><?php } ?>&nbsp;&nbsp; <?php if($UserList[BackPage]) { ?><a
	href="<?php echo $MultiPageUrl;?>&Page=<?php echo $UserList[BackPage];?>">上一页</a><?php } ?>&nbsp;&nbsp; 
<?php $__view__data__0__=$UserList[PageNums];if(is_array($__view__data__0__)) { foreach($__view__data__0__ as $pid) { ?>
 [<a
	href="<?php echo $MultiPageUrl;?>&Page=<?php echo $pid;?>"><?php echo $pid;?></a>] &nbsp;&nbsp; 
<?php } } ?>
 <?php if($UserList[NextPage]) { ?><a href="<?php echo $MultiPageUrl;?>&Page=<?php echo $UserList[NextPage];?>">下一页</a><?php } ?>&nbsp;&nbsp;<?php if($UserList[LastPage]) { ?><a
	href="<?php echo $MultiPageUrl;?>&Page=<?php echo $UserList[LastPage];?>">尾页</a><?php } ?></div>
</div>
</form>
</div>
<div class="clear"></div>
<div>
<form id="form1" name="form1" method="get" action="<?php echo UrlRewriteSimple('Users','Manager',true); ?>">
    
<div class="panel">
  <div class="panel-header">
    <div class="panel-header-left"></div>
    <div class="panel-header-content">搜索</div>
    <div class="panel-header-right"></div>
  </div>
  <div class="panel-body">
    <div class="panel-body-left">
      <div class="panel-body-right">
        <div class="panel-body-content">
          <table width="100%" border="0" cellspacing="0" cellpadding="5">
	<tr>
		<td width="15%" align="right">用户名:</td>
		<td colspan="3"><input name="UserName" type="text"
			class="input-notsize-style" id="UserName" value="" />&nbsp;&nbsp;<span
			style="color: #990">提醒: 输入"a"将搜索符合"a"开头的用户!但并不会搜索"*a*"的记录.</span></td>
	</tr>
	<tr>
		<td align="right">用户组:</td>
		<td width="35%"><select name="UserGroupID" id="UserGroupID">
			<option value="">请选择</option>
<?php $__view__data__0__0__=$UserGroups;  if(is_array($__view__data__0__0__)) { foreach($__view__data__0__0__ as $key => $title) { ?>
<option value="<?php echo $key;?>"><?php echo $title;?></option>
<?php } }  ?>
</select></td>
		<td width="15%" align="right">状态</td>
		<td width="35%"><select name="UserStatus" id="UserStatus">
			<option value="">请选择</option>
<?php $__view__data__0__0__=$ArrRegStatus;  if(is_array($__view__data__0__0__)) { foreach($__view__data__0__0__ as $key => $title) { ?>
<option value="<?php echo $key;?>"><?php echo $title;?></option>
<?php } }  ?>
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
<div style="padding-left: 30px;"><input
	name="button" type="submit" class="btn" id="button" value=" 搜 索 " /> <input
	name="module" type="hidden" value="Users" /> <input name="action"
	type="hidden" value="Manager" /></div>

</form>

</div>
<div class="clear"></div>

</body>
</html>
