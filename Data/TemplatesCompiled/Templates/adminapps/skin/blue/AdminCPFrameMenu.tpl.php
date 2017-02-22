<?php
/*
 ExpressPHP Template Compiler 3.0.0 beta
 compiled from AdminCPFrameMenu.htm at 2010-01-07 01:47:01 Asia/Shanghai
*/
?><html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Menu</title>
<script src="/Javascripts/jquery.min.js" type="text/javascript"></script>
<style type="text/css">
body {
	margin: 0;
	padding: 0;
	height: 100%;
	overflow-x: hidden;
	overflow-y: auto;
	width: 100%;
	background-image:
		url(/templates/adminapps/skin/blue/images/frame-left-bg.gif);
	background-repeat: repeat-y;
}

.line-x {
	background-image:
		url(/templates/adminapps/skin/blue/images/frame-left-line-x.gif);
	background-repeat: no-repeat;
	background-position: center center;
	height: 5px;
	width: 160px;
	font-size: 1px;
	line-height: 10px;
}

.menu-item {
	line-height: 25px;
	padding-left: 35px;
}

.menu-categories-item {
	line-height: 25px;
	padding-left: 15px;
}

a {
	font-size: 12px;
	color: #000;
	text-decoration: none;
}

a:hover {
	font-size: 12px;
	color: #06F;
	text-decoration: underline;
}

* {
	font-size: 12px;
}
</style>
<script type="text/javascript">
function AutoleftFrame(){
	var obj = $(window.top.document).find('frameset[id=LeftRightFrame]');
	if(obj){
		if(obj.attr('cols')=='18,*'){
			$('.op').css('width','auto');
			obj.attr('cols','166,*');
		}
		else {
			$('.op').css('width','18px');
			obj.attr('cols','18,*');
		}
	}
}
</script>

</head>
<body>
<div
	style="line-height: 18px; padding-top: 3px; height: 18px; padding-right: 15px; text-align: right;"
	class="op"><img
	src="/Templates/adminapps/skin/blue/images/op.gif" width="16"
	height="16" alt="显示/隐藏左侧菜单" onClick="AutoleftFrame();"
	style="cursor: pointer;"></div>
<div>&nbsp;</div><?php $Groups=self::__template_functions(array(
"class"=>"ModulesModule",
"function"=>"GetMenuByParentID",
"ParentID"=>$ParentModuleID,
)
);?> 
<?php $__view__data__0__=$Groups;if(is_array($__view__data__0__)) { foreach($__view__data__0__ as $list) { if($Users->CheckRole(($list[Property]?$list[ModuleClass].$list[ModuleAction]:$list[ModuleID]),
$UserID)) { ?> <?php if(!$list[Property]) { ?><div class="menu-categories">
<div class="line-x">&nbsp;</div>
<div class="menu-categories-item"><img
	src="/Templates/adminapps/skin/blue/images/down.gif" width="14"
	height="14" align="absmiddle">&nbsp;&nbsp;<?php echo $list[ModuleName];?></div>
<div class="line-x">&nbsp;</div>
</div>
<div style="padding-left: 15px;"><?php $Menus=self::__template_functions(array(
"class"=>"ModulesModule",
"function"=>"GetMenuByParentID",
"ParentID"=>$list[ModuleID],
)
);?> 
<?php $__view__data__1__=$Menus;if(is_array($__view__data__1__)) { foreach($__view__data__1__ as $menu) { ?>
 <?php if($Users->CheckRole(($menu[Property]?$menu[ModuleClass].$menu[ModuleAction]:$menu[ModuleID]),
$UserID)) { ?><div class="menu-item"><a
	href="<?php echo UrlRewriteSimple($menu[ModuleClass],$menu[ModuleAction],true); ?>"
	target="mainFrame"><?php echo $menu[ModuleName];?></a></div><?php } ?> 
<?php } } ?>
</div><?php } else { ?><div class="line-x">&nbsp;</div>
<div class="menu-item"><a
	href="<?php echo UrlRewriteSimple($list[ModuleClass],$list[ModuleAction],true); ?>"
	target="mainFrame"><?php echo $list[ModuleName];?></a></div><?php } ?> <?php } ?> 
<?php } } ?>
</body>
</html>
