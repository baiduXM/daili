<?php
/*
 ExpressPHP Template Compiler 3.0.0 beta
 compiled from AgentAddAccount.htm at 2014-11-08 11:39:48 Asia/Shanghai
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
<form action="<?php echo UrlRewriteSimple($MyModule,'AddAccount',true); ?>" method="post" enctype="multipart/form-data" name="form1" id="form1">
  <div class="panel">
    <div class="panel-header">
      <div class="panel-header-left"></div>
      <div class="panel-header-content">代理商入账</div>
      <div class="panel-header-right"></div>
    </div>
    <div class="panel-body">
      <div class="panel-body-left">
        <div class="panel-body-right">
          <div class="panel-body-content">
            <table width="100%" border="0" cellspacing="0" cellpadding="5">
              <tr>
                <td align="right">代理商：</td>
                <td>&nbsp;<?php echo $AgentInfo[UserName];?></td>
              </tr>
              <tr>
                <td width="150" align="right">风信代理级别：</td>
                <td>&nbsp;<?php echo GetNameByID($AgentInfo[FengXinAgentPriceID]); ?></td>
              </tr>
              <tr>
                <td width="150" align="right">宝盆代理级别：</td>
                <td>&nbsp;<?php echo GetNameByID($AgentInfo[GBaoPenAgentPriceID]); ?></td>
              </tr> 
              <tr>
                <td align="right">代理产品：</td>
                <td><select name="ProjectID" id="ProjectID">
                    <option value="">选择代理产品</option>
                    
<?php $__view__data__0__=$ProjectLists;if(is_array($__view__data__0__)) { foreach($__view__data__0__ as $list) { ?>
                    <option value="<?php echo $list[ProjectID];?>"><?php echo $list[ProjectName];?></option>
                    
<?php } } ?>
                  </select></td>
              </tr>
              <tr>
                <td align="right">入账金额：</td>
                <td><input name="JinE" type="text" class="input-style" id="JinE" />
                  <font color="#FF0000">注意：充值不能小于1元</font></td>
              </tr>
              <tr>
                <td align="right">备注：</td>
                <td><textarea name="Remarks" cols="100" rows="5" class="input-style" id="Remarks"></textarea></td>
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
    <input type="hidden" name="AgentID" id="AgentID" value="<?php echo $AgentInfo[AgentID];?>" />
    <input
	name="button" type="submit" class="btn" id="button" value=" 提 交 " />
    <input
	name="button2" type="reset" class="btn" id="button2" value=" 重 置 " />
  </div>
</form>
</body>
</html>
