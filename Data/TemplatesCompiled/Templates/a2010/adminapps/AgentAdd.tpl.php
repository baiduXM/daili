<?php
/*
 ExpressPHP Template Compiler 3.0.0 beta
 compiled from AgentAdd.htm at 2014-12-02 14:56:10 Asia/Shanghai
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
<form action="<?php echo UrlRewriteSimple($MyModule,'Add',true); ?>"
	method="post" enctype="multipart/form-data" name="form1" id="form1">
  <div class="panel">
    <div class="panel-header">
      <div class="panel-header-left"></div>
      <div class="panel-header-content">添加代理商</div>
      <div class="panel-header-right"></div>
    </div>
    <div class="panel-body">
      <div class="panel-body-left">
        <div class="panel-body-right">
          <div class="panel-body-content">
            <table width="100%" border="0" cellspacing="0" cellpadding="5">
              <tr>
                <td width="150" align="right">用户名：</td>
                <td><input name="UserName" type="text" class="input-style" id="UserName" maxlength="64"/>
                  &nbsp;&nbsp;<font color="#FF0000">* 不少于3个字符</font></td>
              </tr>
              <tr>
                <td align="right">密码：</td>
                <td><input name="PassWord" type="text" class="input-style" id="PassWord" />
                  &nbsp;&nbsp;<font color="#FF0000">* 不少于6个字符</font></td>
              </tr>
              <tr>
                <td width="150" align="right">企业名称：</td>
                <td><input name="EnterpriseName" type="text" class="input-style"
			id="EnterpriseName" maxlength="64"/>&nbsp;&nbsp;<font color="#FF0000">* </font></td>
              </tr>
              <tr>
                <td align="right">风信代理级别：</td>
                <td><select name="FengXinAgentPriceID" id="FengXinAgentPriceID">
                 
                  
<?php $__view__data__0__=$LevelArray;if(is_array($__view__data__0__)) { foreach($__view__data__0__ as $list) { ?>
                  <option value="<?php echo $list[AgentPriceID];?>"><?php echo GetNameByID($list[LevelID]); ?></option>
                  
<?php } } ?>
                </select></td>
              </tr>
              <tr>
                <td align="right">G宝盆代理级别：</td>
                <td><select name="GBaoPenAgentPriceID" id="GBaoPenAgentPriceID">
                  
                  
<?php $__view__data__0__=$GBaoPenLevelArray;if(is_array($__view__data__0__)) { foreach($__view__data__0__ as $list) { ?>
                  <option value="<?php echo $list[AgentPriceID];?>"><?php echo GetNameByID($list[LevelID]); ?></option>
                  
<?php } } ?>
                </select></td>
              </tr>
              <tr>
                <td align="right">联系人：</td>
                <td><input name="ContactName" type="text" class="input-style" id="ContactName" />&nbsp;&nbsp;<font color="#FF0000">* </font></td>
              </tr>
              <tr>
                <td align="right">联系电话：</td>
                <td><input name="ContactTel" type="text" class="input-style" id="ContactTel" />&nbsp;&nbsp;<font color="#FF0000">* </font></td>
              </tr>
              <tr>
                <td align="right">电子邮件：</td>
                <td><input name="ContactEmail" type="text" class="input-style" id="ContactEmail" /></td>
              </tr>
              <tr>
                <td align="right">地址：</td>
                <td><input name="ContactAddress" type="text" class="input-style" id="ContactAddress" /></td>
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
    <input
	name="button" type="submit" class="btn" id="button" value=" 添 加 " />
    <input
	name="button2" type="reset" class="btn" id="button2" value=" 重 置 " />
  </div>
</form>
</body>
</html>
