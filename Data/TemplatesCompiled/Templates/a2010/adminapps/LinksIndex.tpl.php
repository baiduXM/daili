<?php
/*
 ExpressPHP Template Compiler 3.0.0 beta
 compiled from LinksIndex.htm at 2010-01-07 16:42:36 Asia/Shanghai
*/
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><?php $this->Display("header"); ?><style type="text/css">
<!--
@import url("/Templates/a2010/adminapps/images/style.css");
-->
</style>
</head>

<body>

<form id="form1" name="form1" method="post"
	action="<?php echo UrlRewriteSimple('Links','Delete',true); ?>">
    
<div class="panel">
  <div class="panel-header">
    <div class="panel-header-left"></div>
    <div class="panel-header-content">友情链接管理</div>
    <div class="panel-header-right"></div>
  </div>
  <div class="panel-body">
    <div class="panel-body-left">
      <div class="panel-body-right">
        <div class="panel-body-content">
          <table width="100%" border="0" cellspacing="0" cellpadding="5"
	class="DataGird">
	<tr>
		<th width="30" class="vertical-line">选择</th>
		<th width="100" align="left" class="vertical-line">标题</th>
		<th align="left" class="vertical-line">说明</th>
		<th width="40" class="vertical-line">性质</th>
		<th width="40" class="vertical-line">状态</th>
		<th width="120" align="left" class="vertical-line">目录</th>
		<th width="40" class="vertical-line">排序</th>
		<th width="50">操作</th>
	</tr>
<?php $__view__data__0__=$LinksList[Data];if(is_array($__view__data__0__)) { foreach($__view__data__0__ as $list) { ?>
	<tr>
		<td align="center"><input type="checkbox" name="ID[]"
			id="checkbox" value="<?php echo $list[ID];?>" /></td>
		<td>&nbsp;<a href="<?php echo $list[Url];?>" target="_blank"><?php echo $list[Title];?></a></td>
		<td>&nbsp;<?php echo $list[Describe];?></td>
		<td align="center"><?php if(!$list[Property]) { ?>首页<?php } else { ?>内页<?php } ?></td>
		<td align="center"><?php if(!$list[Status]) { ?>禁用<?php } else { ?>启用<?php } ?></td>
		<td>&nbsp;<?php echo $Category->GetName($list[CategoryID]); ?></td>
		<td align="center"><?php echo $list[DisplayOrder];?></td>
		<td align="center"><a
			href="<?php echo UrlRewriteSimple('Links','Index'); ?>&ID=<?php echo $list[ID];?>">编辑</a></td>
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
    
<div
	style="padding-left: 10px; line-height: 35px; height: 35px; font-size: 12px;"
	class="font-12px"><input name="button" type="submit" class="btn"
	id="button" value=" 删除 " /> 分页导航: <?php if($LinksList[FirstPage]) { ?><a
	href="<?php echo UrlRewriteSimple('Links','Index',false); ?>&Page=<?php echo $LinksList[FirstPage];?>">首页</a><?php } ?>&nbsp;&nbsp;<?php if($LinksList[BackPage]) { ?><a
	href="<?php echo UrlRewriteSimple('Links','Index',false); ?>&Page=<?php echo $LinksList[BackPage];?>">上一页</a><?php } ?>&nbsp;&nbsp;
<?php $__view__data__0__=$LinksList[PageNums];if(is_array($__view__data__0__)) { foreach($__view__data__0__ as $pid) { ?>
 [<a
	href="<?php echo UrlRewriteSimple('Links','Index',false); ?>&Page=<?php echo $pid;?>"><?php echo $pid;?></a>]
&nbsp;&nbsp; 
<?php } } ?>
 <?php if($LinksList[NextPage]) { ?><a
	href="<?php echo UrlRewriteSimple('Links','Index',false); ?>&Page=<?php echo $LinksList[NextPage];?>">下一页</a><?php } ?>&nbsp;&nbsp;<?php if($LinksList[LastPage]) { ?><a
	href="<?php echo UrlRewriteSimple('Links','Index',false); ?>&Page=<?php echo $LinksList[LastPage];?>">尾页</a><?php } ?></div>

</form>

<form id="form1" name="form1" method="post"
	action="<?php echo UrlRewriteSimple('Links','Save',true); ?>">
<div class="panel">
  <div class="panel-header">
    <div class="panel-header-left"></div>
    <div class="panel-header-content">编辑友情链接</div>
    <div class="panel-header-right"></div>
  </div>
  <div class="panel-body">
    <div class="panel-body-left">
      <div class="panel-body-right">
        <div class="panel-body-content">
        <table width="100%" border="0" cellspacing="0" cellpadding="5">
	<tr>
		<td width="150" align="right">标题:</td>
		<td><input name="Title" type="text" class="input-notsize-style"
			id="Title" value="<?php echo self::__htmlspecialchars($LinksDetail[Title]); ?>" /></td>
	</tr>
	<tr>
		<td align="right">URL:</td>
		<td><input name="Url" type="text" class="input-notsize-style"
			id="Url" size="32" maxlength="255"
			value="<?php echo self::__htmlspecialchars($LinksDetail[Url]); ?>" /></td>
	</tr>
	<tr>
		<td align="right">说明:</td>
		<td><input name="Describe" type="text"
			class="input-notsize-style" id="Describe" size="32" maxlength="64"
			value="<?php echo self::__htmlspecialchars($LinksDetail[Describe]); ?>" /></td>
	</tr>
	<tr>
		<td align="right">性质:</td>
		<td><input type="radio" name="Property" id="radio" value="0"<?php if(!$LinksDetail[Property]) { ?> checked="checked" <?php } ?> /> 首页 <input
			name="Property" type="radio" id="radio2" value="1"<?php if($LinksDetail[Property]) { ?> checked="checked" <?php } ?>/> 内页</td>
	</tr>
	<tr>
		<td align="right">状态:</td>
		<td><input type="radio" name="Status" id="radio2" value="0"<?php if(!$LinksDetail[Status]) { ?> checked="checked" <?php } ?> /> 禁用 <input
			name="Status" type="radio" id="radio22" value="1"<?php if($LinksDetail[Status]) { ?> checked="checked" <?php } ?>/> 启用</td>
	</tr>
	<tr>
		<td align="right">选择目录:</td>
		<td>
		<select name="CategoryID">
        <option value="0"> 选择目录 </option>
        
<?php $__view__data__0__=$Categories;if(is_array($__view__data__0__)) { foreach($__view__data__0__ as $c) { ?>
        <option value="<?php echo $c[CategoryID];?>"> <?php echo $c[CategoryName];?> </option>
        
<?php } } ?>
        </select>
		</td>
	</tr>
	<tr>
		<td align="right">排序:</td>
		<td><input name="DisplayOrder" type="text"
			class="input-notsize-style" id="DisplayOrder" size="4" maxlength="4"
			value="<?php echo self::__htmlspecialchars($LinksDetail[DisplayOrder]); ?>" /></td>
	</tr>
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

<div style="padding-left: 100px;"><input
	name="button" type="submit" class="btn" id="button" value=" 保 存 " /> <input
	name="button2" type="reset" class="btn" id="button2" value=" 重 置 " />
<input type="hidden" name="ID" id="ID"
	value="<?php echo self::__htmlspecialchars($LinksDetail[ID]); ?>" /></div>

</form>

</body>
</html>
