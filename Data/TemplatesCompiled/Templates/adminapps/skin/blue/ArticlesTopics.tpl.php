<?php
/*
 ExpressPHP Template Compiler 3.0.0 beta
 compiled from ArticlesTopics.htm at 2010-01-07 01:47:01 Asia/Shanghai
*/
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><?php $this->Display("header"); ?><link href="/templates/adminapps/skin/blue/style.css" rel="stylesheet" type="text/css" />

</head>

<body>


<div >
<form id="form1" name="form1" method="get" action="<?php echo UrlRewriteSimple('Articles','TopicsDelete',true); ?>">
<div class="line-border-f0f0f0">
<div class="UserBodyTitle">游记专题管理</div>
<div class="font-12px">
    <table width="100%" border="0" cellspacing="0" cellpadding="5" class="DataGird">
  <tr>
    <th width="50" class="vertical-line">选择</th>
    <th width="50" class="vertical-line">#ID</th>
    <th  align="left" class="vertical-line">标题</th>
    <th width="120" class="vertical-line">日期</th>
    <th width="120">操作</th>
  </tr>
  <tbody>
  
<?php $__view__data__0__=$TopicsList;if(is_array($__view__data__0__)) { foreach($__view__data__0__ as $list) { ?>
  <tr>
    <td align="center"><input name="TopicID[]" type="checkbox" id="id[]" value="<?php echo $list[TopicID];?>" class="id" /></td>
    <td align="center"><?php echo $list[TopicID];?></td>
    <td>&nbsp;<?php echo $list[Title];?></td>
    <td align="center" style="font-size:9px;" nowrap><?php echo $list[Updated];?></td>
    <td align="center" ><a href="<?php echo UrlRewriteSimple('Articles','TopicsDetail',true); ?>&TopicID=<?php echo $list[TopicID];?>">管理</a>&nbsp;&nbsp;<a href="<?php echo UrlRewriteSimple('Articles','TopicsCreate',true); ?>&TopicID=<?php echo $list[TopicID];?>">修改</a></td>
  </tr>
  
<?php } } ?>
  </tbody>
</table>


</div>

</div>
 <div style="line-height:50px;" class="font-12px">
 &nbsp;&nbsp;<input name="checkall" type="checkbox" value="" onClick="FormCheckAll(this, 'id')"/>&nbsp;&nbsp;
 <input name="button2" type="submit" class="btn" id="button2" value="删除" />
  <input name="module" type="hidden" value="Articles" />
<input name="action" type="hidden" value="TopicsDelete" />
 <input name="Page" type="hidden" id="page" value="<?php echo $Page;?>" />
 第<?php echo $Page;?>页&nbsp;&nbsp;<?php if($BackPage) { ?><a href="<?php echo UrlRewriteSimple('Articles','Topics',true); ?>&Page=<?php echo $BackPage;?>">上一页</a><?php } ?>&nbsp;&nbsp;<?php if($NextPage) { ?><a href="<?php echo UrlRewriteSimple('Articles','Topics',true); ?>&Page=<?php echo $NextPage;?>">下一页</a><?php } ?>&nbsp;&nbsp;

 </div>         
  </form>
<div class="block"></div>
</div>
<div class="clear"></div>
<div class="clear"></div>

</body>
</html>
