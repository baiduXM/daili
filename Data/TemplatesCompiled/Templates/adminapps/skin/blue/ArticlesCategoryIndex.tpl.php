<?php
/*
 ExpressPHP Template Compiler 3.0.0 beta
 compiled from ArticlesCategoryIndex.htm at 2010-01-07 01:47:01 Asia/Shanghai
*/
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><?php $this->Display("header"); ?><link href="/templates/adminapps/skin/blue/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function CategoryDelete(CategoryID){
	var data = "CategoryID="+CategoryID+'&r='+Math.random();
	$.ajax({
		type: "GET",
		url: "?module=ArticlesCategory&action=Delete",
		data: data,
		dataType: "json",
		success: CategoryDeleteResponse
	});	
}

function CategoryDeleteResponse(Result){
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


<div >
<div class="data-line-border-f0f0f0">
<div class="UserBodyTitle">分类列表</div>
<div class="font-12px">
<div style="line-height:25px;">当前分类: <a href="<?php echo UrlRewriteSimple('ArticlesCategory','Index'); ?>" >Top</a> 
<?php $__view__data__0__=$Location;if(is_array($__view__data__0__)) { foreach($__view__data__0__ as $l) { ?>
&nbsp;/&nbsp; <a href="<?php echo UrlRewriteSimple('ArticlesCategory','Index'); ?>&ParentCategoryID=<?php echo $l[CategoryID];?>" ><?php echo $l[CategoryName];?></a> 
<?php } } ?>
</div>
    <table width="100%" border="0" cellspacing="0" cellpadding="5" class="DataGird">
  <tr>
    <th width="50" class="vertical-line">#ID</th>
    <th  align="left" class="vertical-line">分类名称</th>
    <th width="220"class="vertical-line">别名</th>
    <th width="220">操作</th>
  </tr>
  
<?php $__view__data__0__=$data;if(is_array($__view__data__0__)) { foreach($__view__data__0__ as $list) { ?>
  <tr>
    <td align="center"><?php echo $list[CategoryID];?></td>
    <td>&nbsp;<?php echo $list[CategoryName];?></td>
    <td align="center">&nbsp;<?php echo $list[Alias];?></td>
    <td align="center"><a href="<?php echo UrlRewriteSimple('ArticlesCategory','Index'); ?>&ParentCategoryID=<?php echo $list[CategoryID];?>" >下级目录</a>|&nbsp;<a href="<?php echo UrlRewriteSimple('Category','Create'); ?>&CategoryID=<?php echo $list[CategoryID];?>" >编辑</a>&nbsp;|&nbsp; <a href="javascript:;" onclick="CategoryDelete('<?php echo $list[CategoryID];?>')">删除</a> </td>
  </tr>
  
<?php } } ?>
</table>


</div>

<div class="clear"></div>
</div>

<div style="padding-left: 100px; line-height: 50px; height: 50px;"></div>
</div>
</body>
</html>
