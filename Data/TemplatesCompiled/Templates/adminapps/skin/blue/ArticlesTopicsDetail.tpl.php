<?php
/*
 ExpressPHP Template Compiler 3.0.0 beta
 compiled from ArticlesTopicsDetail.htm at 2010-01-07 01:47:01 Asia/Shanghai
*/
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><?php $this->Display("header"); ?><link href="/templates/adminapps/skin/blue/style.css" rel="stylesheet"
	type="text/css" />
</head>
<body>
<div class="block">&nbsp;</div>
<div>
    <div class="UserBodyTitle">旅游专题详细</div>
    <div class="data-line-border-f0f0f0">
      <div class="block"></div>
      <div class="font-12px">
        <table width="100%" border="0" cellspacing="0" cellpadding="5">
          <tr>
            <td width="15%" align="center"><div style="background-image:url(/templates/adminapps/skin/blue/images/picture-100x100px-bg.gif); background-repeat:no-repeat; padding:8px 0 0 3px;; width:100px; height:100px;"><?php if($Detail[Picture]) { ?><a href="<?php echo $Detail[Picture];?>" target="_blank"><img src="<?php if($Detail[PictureThumb]) { echo $Detail[PictureThumb];?><?php } else { echo $Detail[Picture];?><?php } ?>" width="90" height="90" border=0 /></a><?php } else { ?>&nbsp;<?php } ?></div></td>
            <td><table width="100%%" border="0" cellspacing="5" cellpadding="5">
              <tr>
                <td><b><?php echo self::__htmlspecialchars($Detail[Title]); ?></b></td>
                </tr>
              <tr>
                <td><?php echo self::__htmlspecialchars($Detail[Describe]); ?></td>
              </tr>
              <tr>
                <td>关键字: <?php echo self::__htmlspecialchars($Detail[Keywords]); ?>&nbsp;&nbsp;专题属性:<?php if($Detail[AreaID]) { echo GetAreaTitle($Detail[AreaID]); } else { ?>Public 公用专题<?php } ?></td>
              </tr>
            </table></td>
          </tr>
        </table>
      </div>
    </div>
</div>
<div class="clear"></div>
<div class="block"></div>
<div class="font-12px">
<form id="form1" name="form1" method="get" action="<?php echo UrlRewriteSimple('Articles','TopicsDetail',true); ?>">
  关键字:
    <input type="text" name="query" id="query" value="<?php echo $query;?>" />
    <input type="hidden" name="TopicID" id="TopicID" value="<?php echo $Detail[TopicID];?>" />
    <input name="module" type="hidden" value="Articles" />
<input name="action" type="hidden" value="TopicsDetail" />
    <input name="button" type="submit" class="btn" id="button" value="查询" />
</form>
</div><?php if($SearchResult) { ?><form id="form1" name="form1" method="post" action="<?php echo UrlRewriteSimple('Articles','TopicsSetting',true); ?>">
<div class="line-border-f0f0f0">
<div class="UserBodyTitle">查询结果</div>
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
  
<?php $__view__data__0__=$SearchResult;if(is_array($__view__data__0__)) { foreach($__view__data__0__ as $list) { ?>
  <tr>
    <td align="center"><input name="ArticleID[]" type="checkbox" id="id[]" value="<?php echo $list[ArticleID];?>" class="sid" /></td>
    <td align="center"><?php echo $list[ArticleID];?></td>
    <td>&nbsp;<?php echo $list[Title];?></td>
    <td align="center" style="font-size:8px;" nowrap="nowrap"><?php echo $list[Updated];?></td>
    <td align="center" ><a href="<?php echo UrlRewriteSimple('Articles','Create',true); ?>&ArticleID=<?php echo $list[ArticleID];?>">编辑</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="/articles/article-<?php echo $list[ArticleID];?>.htm" target="_blank">预览</a></td>
  </tr>
  
<?php } } ?>
  </tbody>
</table>
</div>
</div>
 <div style="line-height:50px;" class="font-12px">
 &nbsp;&nbsp;<input name="checkall" type="checkbox" value="" onclick="FormCheckAll(this, 'sid')"/>&nbsp;&nbsp;
 <input name="button2" type="submit" class="btn" id="button2" value="添加" />
  <input name="module" type="hidden" value="Articles" />
<input name="action" type="hidden" value="TopicsSetting" />
<input type="hidden" name="TopicID" id="TopicID" value="<?php echo $Detail[TopicID];?>" />
<input type="hidden" name="TargetTopicID" id="TargetTopicID" value="<?php echo $Detail[TopicID];?>" />
<input type="hidden" name="Page" id="Page" value="<?php echo $Page;?>" />
<input type="hidden" name="query" id="query" value="<?php echo $query;?>" />
&nbsp;&nbsp;&nbsp;<?php if($BackPage) { ?><a href="?module=Articles&action=TopicsDetail&TopicID=<?php echo $Detail[TopicID];?>&query=<?php echo urlencode($query); ?>&Page=<?php echo $BackPage;?>">上一页</a><?php } ?>&nbsp;&nbsp;&nbsp;<a href="?module=Articles&action=TopicsDetail&TopicID=<?php echo $Detail[TopicID];?>&query=<?php echo urlencode($query); ?>&Page=<?php echo $NextPage;?>">下一页</a>
 </div>         
  </form><?php } ?><div class="clear"></div>
<div class="block"></div>
<form id="form1" name="form1" method="post" action="<?php echo UrlRewriteSimple('Articles','TopicsSetting',true); ?>">
<div class="line-border-f0f0f0">
<div class="UserBodyTitle">已添加到专题的游记列表</div>
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
  
<?php $__view__data__0__=$TopicArticles;if(is_array($__view__data__0__)) { foreach($__view__data__0__ as $list) { ?>
  <tr>
    <td align="center"><input name="ArticleID[]" type="checkbox" id="id[]" value="<?php echo $list[ArticleID];?>" class="aid" /></td>
    <td align="center"><?php echo $list[ArticleID];?></td>
    <td>&nbsp;<?php echo $list[Title];?></td>
    <td align="center" style="font-size:8px;"  nowrap="nowrap"><?php echo $list[Updated];?></td>
    <td align="center" ><a href="<?php echo UrlRewriteSimple('Articles','Create',true); ?>&ArticleID=<?php echo $list[ArticleID];?>">编辑</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="/articles/article-<?php echo $list[ArticleID];?>.htm" target="_blank">预览</a></td>
  </tr>
  
<?php } } ?>
  </tbody>
</table>
</div>
</div>
 <div style="line-height:50px;" class="font-12px">
 &nbsp;&nbsp;<input name="checkall" type="checkbox" value="" onclick="FormCheckAll(this, 'aid')"/>&nbsp;&nbsp;
 <input name="button2" type="submit" class="btn" id="button2" value="删除" />(提示: 从专题列表中删除)
  <input name="module" type="hidden" value="Articles" />
<input name="action" type="hidden" value="TopicsSetting" />
<input type="hidden" name="TopicID" id="TopicID" value="<?php echo $Detail[TopicID];?>" />
<input type="hidden" name="TargetTopicID" id="TargetTopicID" value="0" />
<input type="hidden" name="Page" id="Page" value="<?php echo $Page;?>" />
<input type="hidden" name="query" id="query" value="<?php echo $query;?>" />
 </div>         
  </form>
<div class="clear"></div>
</body>
</html>
