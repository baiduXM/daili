<?php
/*
 ExpressPHP Template Compiler 3.0.0 beta
 compiled from AdminCPFrameTop.htm at 2010-01-07 01:47:00 Asia/Shanghai
*/
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Top</title>
<script type="text/javascript" src="/Javascripts/jquery.min.js"></script>
<script type="text/javascript">
function OpenleftFrame(mid){
	var obj = $(window.top.document).find('frameset[id=LeftRightFrame]');
	if(obj)
		obj.attr('cols','210,*');
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
<style type="text/css">
<!--
@import url("/Templates/a2010/adminapps/images/style.css");
-->
</style>
<style type="text/css">
<!--
.frame-top-header-bg {
	background-image: url(/Templates/a2010/adminapps/images/top-bg.png);
	background-repeat: repeat-x;
	height: 50px;
}

.frame-top-header-right {
	background-image: url(/Templates/a2010/adminapps/images/top-tomorrow.png);
	background-repeat: no-repeat;
	background-position: right top;
	height: 50px;
	width: 360px;
}


.users-status {
	margin-top: 32px;
	font-size: 12px;
	color: #FFF;
	text-align: right;
}
.frame-top-menu-bg {
	background-image: url(/Templates/a2010/adminapps/images/top-menu-bg.png);
	background-repeat: repeat-x;
	clear: both;
	height: 29px;
}
.menu-left-blank {
	float: left;
	height: 29px;
	width: 200px;
	line-height: 29px;
	color: #333;
}
.menu-focus {
	float: left;
	margin-right: 10px;
}
.menu-focus .menu-item-left {
	font-size: 1px;
	background-image: url(/Templates/a2010/adminapps/images/top-menu-item-left.png);
	background-repeat: no-repeat;
	float: left;
	height: 29px;
	width: 3px;
}
.menu-focus .menu-item-bg {
	background-image: url(/Templates/a2010/adminapps/images/top-menu-item-bg.png);
	background-repeat: repeat-x;
	float: left;
	height: 29px;
	line-height: 35px;
	text-align: center;
	padding-right: 5px;
	padding-left: 5px;
}
.menu-focus .menu-item-right {
	font-size: 1px;
	background-image: url(/Templates/a2010/adminapps/images/top-menu-item-right.png);
	background-repeat: no-repeat;
	float: left;
	height: 29px;
	width: 3px;
}

.menu-blur {
	float: left;
	margin-right: 10px;
}
.menu-blur .menu-item-left {
	font-size: 1px;
	float: left;
	height: 29px;
	width: 3px;
}
.menu-blur .menu-item-bg {
	float: left;
	height: 29px;
	line-height: 35px;
	text-align: center;
	padding-right: 5px;
	padding-left: 5px;
}
.menu-blur .menu-item-right {
	font-size: 1px;
	float: left;
	height: 29px;
	width: 3px;
}
.menu-focus a {
	font-weight: bold;
	color: #333;
	text-decoration: none;
}
.menu-blur a {
	font-weight: none;
	color: #444;
	text-decoration: none;
}

.menu-right-blank {
	line-height: 29px;
	float: right;

	margin-right: 10px;
}
-->
</style>
</head>
<body scroll="no">
<div class="frame-top-header-bg">
<div class="float-left"><img src="/Templates/a2010/adminapps/images/manager-logo.png" width="250" height="50" /></div>
<div class="float-right frame-top-header-right">&nbsp;</div>
</div>
<div class="frame-top-menu-bg">
<div class="menu-left-blank">&nbsp;&nbsp;&nbsp;&nbsp;欢迎您,<?php echo self::__htmlspecialchars($UserDetail[NickName]); ?>!</div>
<div class="menu-focus" id="AdminCPMain">
<div class="menu-item-left">&nbsp;</div>
<div class="menu-item-bg"><a href="?module=AdminCP&action=FrameMain" target="mainFrame" onclick="CloseleftFrame('AdminCPMain');">管理首页</a></div>
<div class="menu-item-right">&nbsp;</div>
</div><?php $Groups=self::__template_functions(array(
"class"=>"ModulesModule",
"function"=>"GetMenuByParentID",
"ParentID"=>"0",
)
);?> 
<?php $__view__data__0__0__=$Groups;  if(is_array($__view__data__0__0__)) { foreach($__view__data__0__0__ as $id => $list) { ?>
 <?php if($Users->CheckRole(($list[Property]?$list[ModuleClass].$list[ModuleAction]:$list[ModuleID]),
$UserID)) { ?><div class="menu-blur" id="ModuleID<?php echo $list[ModuleID];?>"><div class="menu-item-left">&nbsp;</div><div class="menu-item-bg"><a
	href="?module=AdminCP&action=FrameMenu&ParentModuleID=<?php echo $list[ModuleID];?>"
	target="iFrameMenu"
	onclick="OpenleftFrame('ModuleID<?php echo $list[ModuleID];?>');"><?php echo $list[ModuleName];?></a></div>
<div class="menu-item-right">&nbsp;</div>
</div><?php } ?> 
<?php } }  ?>
<div class="menu-right-blank">
<a href="/" target="_blank">网站首页</a> &nbsp;|&nbsp; <a href="?module=Users&action=Profile" target="mainFrame">账户资料</a> &nbsp;|&nbsp; <a href="?module=Users&action=NewPassword" target="mainFrame" >设置密码</a> &nbsp;|&nbsp; <a href="?module=Users&action=Logout" target="_top">安全退出</a>
</div>
    
</div>
</body>
</html>
