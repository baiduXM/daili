<?php
/*
 ExpressPHP Template Compiler 3.0.0 beta
 compiled from ArticlesCreate.htm at 2010-01-07 01:47:01 Asia/Shanghai
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
  <form action="<?php echo UrlRewriteSimple('Articles','Save',true); ?>"
	method="post" enctype="multipart/form-data" name="form1" id="form1">
    <div class="UserBodyTitle">游记发布/编辑</div>
    <div class="data-line-border-f0f0f0">
      <div class="block"></div>
      <div class="font-12px">
        <table width="100%" border="0" cellspacing="0" cellpadding="5">
          <tr>
            <td width="15%" align="right">标题:</td>
            <td><input name="Title" type="text"
			class="input-style" id="Title" value="<?php echo self::__htmlspecialchars($Detail[Title]); ?>" /></td>
          </tr>
          <tr>
            <td align="right">标题图片:</td>
            <td><input type="file" name="picture" id="picture" />
              <?php if($Detail[Picture]) { ?>              <p>已保存图片: <a href="<?php echo $Detail[Picture];?>" target="_blank"><?php echo $Detail[Picture];?></a>
                <input name="PictureDelete" type="checkbox" id="PictureDelete" value="1" />
                删除</p>
              <?php if($Detail[PictureThumb]) { ?>              <p>已保存缩图: <a href="<?php echo $Detail[PictureThumb];?>" target="_blank"><?php echo $Detail[PictureThumb];?></a></p>
              <?php } } ?> </td>
          </tr>
          <tr>
            <td width="15%" align="right" valign="top">内容:</td>
            <td><?php echo $editor;?></td>
          </tr>
          <tr>
            <td align="right">选择分类:</td>
            <td><select name="CategoryID" id="CategoryID">
                <option value="0">&nbsp;&nbsp;未选择&nbsp;&nbsp;</option>
                
<?php $__view__data__0__=$Categories;if(is_array($__view__data__0__)) { foreach($__view__data__0__ as $list) { ?>
                <option value="<?php echo $list[CategoryID];?>" <?php if($Detail[CategoryID]==$list[CategoryID]) { ?>selected="selected"<?php } ?>>&nbsp;&nbsp;<?php echo str_repeat('&nbsp;',$list[Level]*3); ?>|- <?php echo $list[CategoryName];?></option>
                
<?php } } ?>
              </select></td>
          </tr>
          <tr>
            <td align="right">关键字:</td>
            <td><input name="Keywords" type="text"
			class="input-style" id="Keywords" value="<?php echo self::__htmlspecialchars($Detail[Keywords]); ?>" /></td>
          </tr>
        </table>
      </div>
    </div>
    <div style="padding-left: 100px; line-height: 50px; height: 50px;">
      <input
	name="button" type="submit" class="btn" id="button" value=" 保 存 " />
      <input
	name="button2" type="reset" class="btn" id="button2" value=" 重 置 " />
      <?php if($Detail) { ?>      <input name="ArticleID" type="hidden" value="<?php echo $Detail[ArticleID];?>" />
      <?php } ?> </div>
  </form>
</div>
<div class="clear"></div>
<div class="clear"></div>
</body>
</html>
