<?php
/*
 ExpressPHP Template Compiler 3.0.0 beta
 compiled from ArticlesLists.htm at 2010-01-21 17:03:51 Asia/Shanghai
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
<form id="form1" name="form1" method="get" action="<?php echo UrlRewriteSimple('Articles','Delete',true); ?>">
<div class="panel">
  <div class="panel-header">
    <div class="panel-header-left"></div>
    <div class="panel-header-content">文章管理</div>
    <div class="panel-header-right"></div>
  </div>
  <div class="panel-body">
    <div class="panel-body-left">
      <div class="panel-body-right">
        <div class="panel-body-content">
   <table width="100%" border="0" cellspacing="1" cellpadding="5" class="DataGird">
  <tr>
    <th width="50" class="vertical-line">选择</th>
    <th width="50" class="vertical-line">#ID</th>
    <th  align="left" class="vertical-line">标题</th>
    <th width="120" class="vertical-line">分类</th>
	 <th width="120" class="vertical-line">日期</th>
    <th width="120">操作</th>
  </tr>
  <tbody>
  
<?php $__view__data__0__=$Data;if(is_array($__view__data__0__)) { foreach($__view__data__0__ as $list) { ?>
  <tr>
    <td align="center"><input name="ArticleID[]" type="checkbox" id="id[]" value="<?php echo $list[ArticleID];?>" class="id" /></td>
    <td align="center"><?php echo $list[ArticleID];?></td>
    <td>&nbsp;<?php echo $list[Title];?></td>
    <td align="center" style="font-size:9px;"><?php if($list[CategoryID]) { echo $category->GetName($list[CategoryID]); } else { ?>&nbsp;&nbsp;<?php } ?></td>
	  <td align="center" style="font-size:9px;"><?php echo $list[Updated];?></td>
    <td align="center" ><a href="<?php echo UrlRewriteSimple('Articles','Create',true); ?>&ArticleID=<?php echo $list[ArticleID];?>">编辑</a></td>
  </tr>
  
<?php } } ?>
  </tbody>
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

 <div style="line-height:50px;" class="font-12px">
 &nbsp;&nbsp;<input name="checkall" type="checkbox" value="" onClick="FormCheckAll(this, 'id')"/>&nbsp;&nbsp;
 <input name="button2" type="submit" class="btn" id="button2" value="删除" />
  <input name="module" type="hidden" value="Articles" />
<input name="action" type="hidden" value="Delete" />
 <input name="Page" type="hidden" id="page" value="<?php echo $Page;?>" />
 			  
 第<?php echo $Page;?>页&nbsp;&nbsp;<?php if($BackPage) { ?><a href="<?php echo UrlRewriteSimple('Articles','Lists',true); ?>&Page=<?php echo $BackPage;?>">上一页</a><?php } ?>&nbsp;&nbsp;<?php if($NextPage) { ?><a href="<?php echo UrlRewriteSimple('Articles','Lists',true); ?>&Page=<?php echo $NextPage;?>">下一页</a><?php } ?>&nbsp;&nbsp;

 </div>   
 <div>重新设置分类:<select name="CategoryID" id="CategoryID">
                <option value="0">&nbsp;&nbsp;未选择&nbsp;&nbsp;</option>
                
<?php $__view__data__0__=$Categories;if(is_array($__view__data__0__)) { foreach($__view__data__0__ as $list) { ?>
                <option value="<?php echo $list[CategoryID];?>" <?php if($Detail[CategoryID]==$list[CategoryID]) { ?>selected="selected"<?php } ?>>&nbsp;&nbsp;<?php echo str_repeat('&nbsp;',$list[Level]*3); ?>|- <?php echo $list[CategoryName];?></option>
                
<?php } } ?>
              </select>
 <input name="button2" type="submit" class="btn" id="button2" value="设置" onClick="this.form.action.value='Setting'" /></div>      
  </form>

</body>
</html>
