<?php
/*
 ExpressPHP Template Compiler 3.0.0 beta
 compiled from ModulesLists.htm at 2010-01-07 01:47:00 Asia/Shanghai
*/
?><html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><?php $this->Display("header"); ?><style type="text/css">
<!--
@import url("/Templates/a2010/adminapps/images/style.css");
-->
</style>
<script type="text/javascript">
function ModuleDelete(ModuleID){
	var data = "ModuleID="+ModuleID+'&r='+Math.random();
	$.ajax({
		type: "GET",
		url: "?module=Modules&action=Delete",
		data: data,
		dataType: "json",
		success: ModuleDeleteResponse
	});	
}

function ModuleDeleteResponse(Result){
	if(Result.Code=='Succ'){
		alert(Result.Message);
		location.reload();
	}
	else {
		alert(Result.Message);
	}
}
</script>
</head>

<body>


<div>
<form id="form1" name="form1" method="post"
	action="<?php echo UrlRewriteSimple('Modules','Update',true); ?>">
    
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
          <table width="100%" border="0" cellspacing="0" cellpadding="5"
	class="DataGird">
	<tr>
		<th width="50" class="vertical-line">#ID</th>
		<th align="left" class="vertical-line">模块名称</th>
		<th width="50" class="vertical-line">Level</th>
		<th width="150" class="vertical-line">视图类::方法名</th>
		<th width="50" class="vertical-line">Engine</th>
		<th align="left" width="80" class="vertical-line">属性</th>
		<th align="left" width="80" class="vertical-line">同级排序</th>
		<th width="150">操作</th>
	</tr>
<?php $__view__data__0__=$data;if(is_array($__view__data__0__)) { foreach($__view__data__0__ as $list) { ?>
	<tr>
		<td align="center"><?php echo $list[ModuleID];?></td>
		<td height="30"><?php echo str_repeat('&nbsp;',$list[Level]*4); ?>|- <input
			name="ModuleNames[<?php echo $list[ModuleID];?>]" type="text"
			value="<?php echo $list[ModuleName];?>" class="input-underline" /></td>
		<td align="center"><?php echo $list[Level];?></td>
		<td align="left"><?php if($list[Property]) { echo $list[ModuleClass].'::'.$list[ModuleAction]; } ?></td>
		<td>&nbsp;<?php echo $list[ViewerEngine];?></td>
		<td><select name="Propertys[<?php echo $list[ModuleID];?>]">
<?php $__view__data__0__0__=$Propertys;  if(is_array($__view__data__0__0__)) { foreach($__view__data__0__0__ as $Property => $PropertyTitle) { ?>
<option <?php if($list[Property]==$Property) { ?> selected="selected"
				<?php } ?> value="<?php echo $Property;?>"><?php echo $PropertyTitle;?></option>
			
<?php } } ?>
</select></td>
		<td><input name="DisplayOrders[<?php echo $list[ModuleID];?>]" type="text"
			value="<?php echo $list[DisplayOrder];?>" class="input-underline" /></td>
		</td>

		<td align="center">&nbsp; <a href="javascript:;"
			onclick="ModuleDelete('<?php echo $list[ModuleID];?>')">删除</a></td>
	</tr>
<?php } }  ?>
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
 
<div style="padding-left: 100px; height: 50px;"><input
	name="button" type="submit" class="btn" id="button" value=" 更 新 " /> <input
	name="button2" type="reset" class="btn" id="button2" value=" 重 置 " /></div>
</form>
</div>
</body>
</html>
