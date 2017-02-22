<?php
/*
 ExpressPHP Template Compiler 3.0.0 beta
 compiled from AdminCPFrameTop.htm at 2010-01-07 01:47:01 Asia/Shanghai
*/
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Top</title>
<link href="/Templates/adminapps/skin/blue/blue-top.css"
	rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/Javascripts/jquery.min.js"></script>
<script type="text/javascript">
function OpenleftFrame(mid){
	var obj = $(window.top.document).find('frameset[id=LeftRightFrame]');
	if(obj)
		obj.attr('cols','166,*');
	setFocus(mid);
}
function CloseleftFrame(mid){
	var obj = $(window.top.document).find('frameset[id=LeftRightFrame]');
	if(obj)
		obj.attr('cols','0,*');
	setFocus(mid);
}
function setFocus(mid){
	
	$('.menu-focus[id!='+mid+']').attr('class','menu-blur');
	$('.menu-blur[id='+mid+']').attr('class','menu-focus');
}
</script>

</head>
<body scroll="no">
<div class="box">
<div class="box-left">
<div class="logo"><img
	src="/Templates/adminapps/skin/blue/images/data-logo.gif"
	align="absmiddle" /></div>
</div>
<div class="box-right">
<div class="users-status"><?php echo self::__htmlspecialchars($UserDetail[NickName]); ?> [
修改资料, <a href="?module=Users&action=Logout" target="_top">安全退出</a> ]</div>
<div style="float: left; height: 23px;">
<div class="menu-focus" id="AdminCPMain"><a
	href="?module=AdminCP&action=FrameMain" target="mainFrame"
	onclick="CloseleftFrame('AdminCPMain');">管理首页</a></div><?php $Groups=self::__template_functions(array(
"class"=>"ModulesModule",
"function"=>"GetMenuByParentID",
"ParentID"=>"0",
)
);?> 
<?php $__view__data__0__0__=$Groups;  if(is_array($__view__data__0__0__)) { foreach($__view__data__0__0__ as $id => $list) { ?>
 <?php if($Users->CheckRole(($list[Property]?$list[ModuleClass].$list[ModuleAction]:$list[ModuleID]),
$UserID)) { ?><div class="menu-blur" id="ModuleID<?php echo $list[ModuleID];?>"><a
	href="?module=AdminCP&action=FrameMenu&ParentModuleID=<?php echo $list[ModuleID];?>"
	target="iFrameMenu"
	onclick="OpenleftFrame('ModuleID<?php echo $list[ModuleID];?>');"><?php echo $list[ModuleName];?></a></div><?php } ?> 
<?php } }  ?>
</div>
<div class="menu-right"><a href="/" target="_blank">网站首页</a> | <a
	href="?module=Users&action=Logout" target="_top">安全退出</a></div>
</div>
</div>
</body>
</html>
