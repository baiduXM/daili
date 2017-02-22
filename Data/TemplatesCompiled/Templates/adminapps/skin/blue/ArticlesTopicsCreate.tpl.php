<?php
/*
 ExpressPHP Template Compiler 3.0.0 beta
 compiled from ArticlesTopicsCreate.htm at 2010-01-07 01:47:01 Asia/Shanghai
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
  <form action="<?php echo UrlRewriteSimple('Articles','TopicsSave',true); ?>"
	method="post" enctype="multipart/form-data" name="form1" id="form1">
    <div class="UserBodyTitle">旅游专题编辑/创建</div>
    <div class="data-line-border-f0f0f0">
      <div class="block"></div>
      <div class="font-12px">
        <table width="100%" border="0" cellspacing="0" cellpadding="5">
          <tr>
            <td width="15%" align="right">专题标题:</td>
            <td><input name="Title" type="text"
			class="input-style" id="Title" value="<?php echo self::__htmlspecialchars($Detail[Title]); ?>" /></td>
          </tr>
          <tr>
            <td width="15%" align="right">描述:</td>
            <td><textarea name="Describe" rows="10" style="width:90%; height:150px;" id="Describe"><?php echo self::__htmlspecialchars($Detail[Describe]); ?></textarea></td>
          </tr>
          <tr>
            <td align="right">关键字:</td>
            <td><input name="Keywords" type="text"
			class="input-style" id="Keywords" value="<?php echo self::__htmlspecialchars($Detail[Keywords]); ?>" /></td>
          </tr>
          <tr>
            <td align="right">专题图片:</td>
            <td>
            <input type="file" name="picture" id="picture" />
            <?php if($Detail[Picture]) { ?>            <p>已保存图片: <a href="<?php echo $Detail[Picture];?>" target="_blank"><?php echo $Detail[Picture];?></a></p>
            <?php if($Detail[PictureThumb]) { ?><p>已保存缩图: <a href="<?php echo $Detail[PictureThumb];?>" target="_blank"><?php echo $Detail[PictureThumb];?></a></p>
            <?php } } ?>            </td>
          </tr>
        </table>
      </div>
    </div>
    <div style="padding-left: 100px; line-height: 50px; height: 50px;">
      <input
	name="button" type="submit" class="btn" id="button" value=" 保 存 " />
      <input
	name="button2" type="reset" class="btn" id="button2" value=" 重 置 " />
      <?php if($Detail) { ?>      <input name="TopicID" type="hidden" value="<?php echo $Detail[TopicID];?>" />
      <?php } ?> </div>
  </form>
</div>
<div class="clear"></div>
<div class="clear"></div>
</body>
</html>
