<?php
/*
 ExpressPHP Template Compiler 3.0.0 beta
 compiled from ArticlesCategoryIndex.htm at 2010-01-21 17:23:59 Asia/Shanghai
*/
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><?php $this->Display("header"); ?><style type="text/css">
<!--
@import url("/Templates/a2010/adminapps/images/style.css");
-->
</style>
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
<div class="panel">
  <div class="panel-header">
    <div class="panel-header-left"></div>
    <div class="panel-header-content">文章分类管理</div>
    <div class="panel-header-right"></div>
  </div>
  <div class="panel-body">
    <div class="panel-body-left">
      <div class="panel-body-right">
        <div class="panel-body-content">
  <div style="line-height:25px;">当前分类: <a href="<?php echo UrlRewriteSimple('ArticlesCategory','Index'); ?>" >Top</a> 
<?php $__view__data__0__=$Location;if(is_array($__view__data__0__)) { foreach($__view__data__0__ as $l) { ?>
&nbsp;/&nbsp; <a href="<?php echo UrlRewriteSimple('ArticlesCategory','Index'); ?>&ParentCategoryID=<?php echo $l[CategoryID];?>" ><?php echo $l[CategoryName];?></a> 
<?php } } ?>
</div>
    <table width="100%" border="0" cellspacing="1" cellpadding="5" class="DataGird">
  <tr>
    <th  align="left" class="vertical-line">分类名称</th>
    <th width="220"class="vertical-line">别名</th>
    <th width="220">操作</th>
  </tr>
  
<?php $__view__data__0__=$data;if(is_array($__view__data__0__)) { foreach($__view__data__0__ as $list) { ?>
  <tr>
    <td><?php echo str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;',$list[Level]-1); if($list[Level]==1) { ?><img src="/Templates/a2010/adminapps/images/cate-ico-top.png" align="absmiddle" /><?php } else { ?><img src="/Templates/a2010/adminapps/images/cate-ico-sub.png" align="absmiddle" /><?php } ?> <?php echo $list[CategoryName];?></td>
    <td align="center">&nbsp;<?php echo $list[Alias];?></td>
    <td align="center"><a href="<?php echo UrlRewriteSimple('ArticlesCategory','Index'); ?>&ParentCategoryID=<?php echo $list[CategoryID];?>" >下级目录</a>&nbsp;&nbsp;&nbsp;<a href="<?php echo UrlRewriteSimple('ArticlesCategory','Create'); ?>&CategoryID=<?php echo $list[CategoryID];?>" >编辑</a>&nbsp;&nbsp;&nbsp; <a href="javascript:;" onclick="CategoryDelete('<?php echo $list[CategoryID];?>')">删除</a> </td>
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

</body>
</html>
