<?php
/*
 ExpressPHP Template Compiler 3.0.0 beta
 compiled from AgentApiset.htm at 2014-11-08 11:22:33 Asia/Shanghai
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
<form action="<?php echo UrlRewriteSimple($MyModule,'Apiset',true); ?>" method="post" enctype="multipart/form-data" name="form1" id="form1">
  <div class="panel">
    <div class="panel-header">
      <div class="panel-header-left"></div>
      <div class="panel-header-content">设置接口</div>
      <div class="panel-header-right"></div>
    </div>
    <div class="panel-body">
      <div class="panel-body-left">
        <div class="panel-body-right">
          <div class="panel-body-content">
            <table width="100%" border="0" cellspacing="0" cellpadding="5">
              <tr>
                <td width="150" align="right">用户名：</td>
                <td><input name="UserName" type="text" disabled="disabled" class="input-style" id="UserName" value="<?php echo $AgentInfo[UserName];?>"/>
                  &nbsp;&nbsp;<font color="#FF0000">不能修改</font></td>
              </tr>
              <tr>
                <td align="right">私钥：</td>
                <td><input name="apiprivate" type="text" class="input-style" readonly="readonly" id="ContactAddress" value="<?php echo $AgentApiInfo['private'];?>" /><button id="createprivate" type="button">随机生成</button></td>
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
    <input type="hidden" name="Page" id="Page" value="<?php echo $Page;?>" />
    <input name="button" type="submit" class="btn" id="button" value="修 改" />
    <a href="javascript:history.go(-1);">&nbsp;&nbsp;返回</a>
  </div>
</form>
<script type="text/javascript">
function _getRandomString(len) {
    len = len || 20;
    var $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var maxPos = $chars.length;
    var pwd = '';
    for (i = 0; i < len; i++) {
        pwd += $chars.charAt(Math.floor(Math.random() * maxPos));
    }
    return pwd;
}
$(function(){
    $('#createprivate').click(function(){
            var value = _getRandomString(12);
            $("input[name='apiprivate']").val(value);
    });
});
</script>
</body>
</html>
