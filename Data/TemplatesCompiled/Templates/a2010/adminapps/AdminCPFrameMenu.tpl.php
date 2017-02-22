<?php
/*
 ExpressPHP Template Compiler 3.0.0 beta
 compiled from AdminCPFrameMenu.htm at 2014-06-19 16:05:25 Asia/Shanghai
*/
?><html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Menu</title>
<script src="/Javascripts/jquery.min.js" type="text/javascript"></script>
<script  type="text/javascript">
function categoryFocus(pid){
	if($('.menu-categories-subs[id=subs'+pid+']').css('display')=='none'){
		$('.menu-categories-subs[id=subs'+pid+']').show();
		$('.menu-categories-subs[id!=subs'+pid+']').hide();
		$('#category-ico-'+pid).attr('src','/Templates/a2010/adminapps/images/menu-up.gif');
	}
	else{
		$('.menu-categories-subs[id=subs'+pid+']').hide();
		$('#category-ico-'+pid).attr('src','/Templates/a2010/adminapps/images/menu-ico.gif');
		}
}
</script>
<style type="text/css">
<!--
@import url("/Templates/a2010/adminapps/images/style.css");
.frame-menus {
	margin: 0px;
	padding-top: 0px;
	padding-right: 3px;
	padding-bottom: 0px;
	padding-left: 5px;
}
.frame-menus .frame-menus-header {
	background-image: url(/Templates/a2010/adminapps/images/left-menu-header.png);
	height: 27px;
	width: 185px;
}
.frame-menus .frame-menus-bg {
	background-image: url(/Templates/a2010/adminapps/images/left-menu-bg.png);
	background-repeat: repeat-y;
}
.frame-menus .frame-menus-footer {
	background-image: url(/Templates/a2010/adminapps/images/left-menu-end.png);
	background-repeat: no-repeat;
	height: 8px;
	width: 185px;
}
.line-x {
	background-image: url(/Templates/a2010/adminapps/images/left-menu-xline.png);
	background-repeat: no-repeat;
	height: 2px;
	width: 160px;
	margin: 2px 8px 2px 8px;
	font-size:1px;
}
.menu-categories-item {
	margin: 0px;
	padding: 5px 0px 5px 35px;
}
.menu-item {
	margin: 0px;
	padding: 5px 0px 5px 35px;
}
.menu-sub-item {
	padding: 5px 0px 5px 55px;
}
.menu-categories-subs{
	display:none;
}
-->
</style>
</head>
<body>
<div class="frame-menus">
  <div class="frame-menus-header">&nbsp;</div>
  <div class="frame-menus-bg"> <?php $Groups=self::__template_functions(array(
"class"=>"ModulesModule",
"function"=>"GetMenuByParentID",
"ParentID"=>$ParentModuleID,
)
);?>    
<?php $__view__data__0__0__=$Groups;  if(is_array($__view__data__0__0__)) { foreach($__view__data__0__0__ as $i => $list) { ?>
    <?php if($Users->CheckRole(($list[Property]?$list[ModuleClass].$list[ModuleAction]:$list[ModuleID]),$UserID)) { ?> <?php if(!$list[Property]) { ?>    <div class="menu-categories"> <?php if($i) { ?>      <div class="line-x">&nbsp;</div>
      <?php } ?>      <div class="menu-categories-item"><img
	src="/Templates/a2010/adminapps/images/menu-ico.gif" width="14"
	height="14" align="absmiddle" id="category-ico-<?php echo $list[ModuleID];?>">&nbsp;&nbsp;<a href="javascript:;" onclick="categoryFocus('<?php echo $list[ModuleID];?>')"><?php echo $list[ModuleName];?></a></div>
      
    </div>
	 <?php $Menus=self::__template_functions(array(
"class"=>"ModulesModule",
"function"=>"GetMenuByParentID",
"ParentID"=>$list[ModuleID],
)
);?> <?php if($Menus) { ?>    <div class="menu-categories-subs" id="subs<?php echo $list[ModuleID];?>">
	<div class="line-x">&nbsp;</div>
      
<?php $__view__data__1__1__=$Menus;  if(is_array($__view__data__1__1__)) { foreach($__view__data__1__1__ as $k => $menu) { ?>
      <?php if($Users->CheckRole(($menu[Property]?$menu[ModuleClass].$menu[ModuleAction]:$menu[ModuleID]),$UserID)) { ?>      <?php if($k) { ?>      <div class="line-x">&nbsp;</div>
      <?php } ?>      <div class="menu-sub-item"><a
	href="<?php echo UrlRewriteSimple($menu[ModuleClass],$menu[ModuleAction],true); ?>"
	target="mainFrame"><?php echo $menu[ModuleName];?></a></div>
      <?php } ?>      
<?php } }  ?>
    </div>
	<?php } ?>    <?php } else { ?>    <?php if($i) { ?>    <div class="line-x">&nbsp;</div>
    <?php } ?>    <div class="menu-item"><a
	href="<?php echo UrlRewriteSimple($list[ModuleClass],$list[ModuleAction],true); ?>"
	target="mainFrame"><?php echo $list[ModuleName];?></a></div>
    <?php } ?> <?php } ?> 
<?php } }  ?>
 </div>
  <div class="frame-menus-footer">&nbsp;</div>
</div>
</body>
</html>
