<?php
/*
 ExpressPHP Template Compiler 3.0.0 beta
 compiled from AgentPriceEdit.htm at 2014-09-03 10:25:18 Asia/Shanghai
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
<form action="<?php echo UrlRewriteSimple($MyModule,'Edit',true); ?>" method="post" enctype="multipart/form-data" name="form1" id="form1">
  <div class="panel">
    <div class="panel-header">
      <div class="panel-header-left"></div>
      <div class="panel-header-content">添加代理商价格</div>
      <div class="panel-header-right"></div>
    </div>
    <div class="panel-body">
      <div class="panel-body-left">
        <div class="panel-body-right">
          <div class="panel-body-content">
            <table width="100%" border="0" cellspacing="0" cellpadding="5">
              <tr>
                <td align="right">代理产品：</td>
                <td>
                <select name="ProjectID" id="ProjectID">
                	<option value="">选择代理产品</option>
                
<?php $__view__data__0__=$ProjectLists;if(is_array($__view__data__0__)) { foreach($__view__data__0__ as $list) { ?>
                  	<option value="<?php echo $list[ProjectID];?>" <?php if($AgentPriceInfo[ProjectID]==$list[ProjectID]) { ?> selected="selected"<?php } ?>><?php echo $list[ProjectName];?></option>
                
<?php } } ?>
                </select>
                  &nbsp;</td>
              </tr>
              <tr>
                <td width="150" align="right">代理级别：</td>
                <td>
                <select name="LevelID" id="LevelID">
                	<option value="">选择代理级别</option>
                
<?php $__view__data__0__=$LevelArray;if(is_array($__view__data__0__)) { foreach($__view__data__0__ as $list) { ?>
                  	<option value="<?php echo $list[id];?>" <?php if($AgentPriceInfo[LevelID]==$list[id]) { ?> selected="selected"<?php } ?>><?php echo $list[name];?></option>
                
<?php } } ?>
                </select>
                </td>
              </tr>
              <tr>
                <td align="right">代理折扣：</td>
                <td><input name="AgenDiscount" type="text" class="input-style" id="AgenDiscount" value="<?php echo $AgentPriceInfo[AgenDiscount];?>" /></td>
              </tr>
              <tr>
                <td align="right">备注：</td>
                <td><textarea name="Remarks" cols="100" rows="5" class="input-style" id="Remarks"><?php echo $AgentPriceInfo[Remarks];?></textarea></td>
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
  <div style="padding-left: 100px;">
    <input type="hidden" name="AgentPriceID" id="AgentPriceID" value="<?php echo $AgentPriceInfo[AgentPriceID];?>" />
    <input type="hidden" name="Page" id="Page" value="<?php echo $Page;?>" />
    <input
	name="button" type="submit" class="btn" id="button" value=" 修 改 " />
    <input
	name="button2" type="reset" class="btn" id="button2" value=" 重 置 " />
  </div>
</form>
</body>
</html>
