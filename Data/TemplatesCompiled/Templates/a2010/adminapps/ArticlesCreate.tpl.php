<?php
/*
 ExpressPHP Template Compiler 3.0.0 beta
 compiled from ArticlesCreate.htm at 2010-01-07 15:21:39 Asia/Shanghai
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
  <form action="<?php echo UrlRewriteSimple('Articles','Save',true); ?>"
	method="post" enctype="multipart/form-data" name="form1" id="form1">

<div class="panel">
  <div class="panel-header">
    <div class="panel-header-left"></div>
    <div class="panel-header-content">文章发布/编辑</div>
    <div class="panel-header-right"></div>
  </div>
  <div class="panel-body">
    <div class="panel-body-left">
      <div class="panel-body-right">
        <div class="panel-body-content">
  <table width="100%" border="0" cellspacing="0" cellpadding="5">
          <tr>
            <td width="15%" align="right">标题:</td>
            <td><input name="Title" type="text"
			class="input-style" id="Title" value="<?php echo self::__htmlspecialchars($Detail[Title]); ?>" size="64" /></td>
          </tr>
          <tr>
            <td align="right">别名:</td>
            <td><input name="Alias" type="text"
			class="input-style" id="Alias" value="<?php echo self::__htmlspecialchars($Detail[Alias]); ?>" size="64" /> 
              如果填写该项, 只允许半角英文字母,减号,数字组成的字符串,且不能重复.否则请放空.</td>
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
			class="input-style" id="Keywords" value="<?php echo self::__htmlspecialchars($Detail[Keywords]); ?>" /> 多关键字时以半角逗号隔开</td>
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


    <div style="padding-left: 100px; ">
      <input
	name="button" type="submit" class="btn" id="button" value=" 保 存 " />
      <input
	name="button2" type="reset" class="btn" id="button2" value=" 重 置 " />
      <?php if($Detail) { ?>      <input name="ArticleID" type="hidden" value="<?php echo $Detail[ArticleID];?>" />
      <?php } ?> </div>
  </form>
</body>
</html>
