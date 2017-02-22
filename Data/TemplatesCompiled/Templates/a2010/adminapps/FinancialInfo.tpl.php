<?php
/*
 ExpressPHP Template Compiler 3.0.0 beta
 compiled from FinancialInfo.htm at 2014-09-10 18:06:27 Asia/Shanghai
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
  <div class="panel">
    <div class="panel-header">
      <div class="panel-header-left"></div>
      <div class="panel-header-content">订单详情</div>
      <div class="panel-header-right"></div>
    </div>
    <div class="panel-body">
      <div class="panel-body-left">
        <div class="panel-body-right">
          <div class="panel-body-content">
            <table width="100%" border="0" cellspacing="0" cellpadding="5">
              <tr>
                <td width="150" height="30" align="right"><strong>订单号：</strong></td>
                <td><?php echo $OrderInfo[OrderNO];?></td>
              </tr>
              <tr>
                <td width="150" height="30" align="right"><strong>入账/消费：</strong></td>
                <td><?php echo $OrderInfo[TypeName];?></td>
              </tr>
              <tr>
                <td height="30" align="right"><strong>代理商：</strong></td>
                <td><?php echo $OrderInfo[AgentUserName];?></td>
              </tr>
              <tr>
                <td height="30" align="right"><strong>操作时间：</strong></td>
                <td><?php echo $OrderInfo[AddTime];?></td>
              </tr>
              <tr>
                <td height="30" align="right"><strong>操作产品：</strong></td>
                <td><?php echo $OrderInfo[ProjectName];?></td>
              </tr>
              <tr>
                <td height="30" align="right"><strong>客户端IP：</strong></td>
                <td><?php echo $OrderInfo[FromIP];?></td>
              </tr>
              <tr>
                <td height="30" align="right"><strong>金额：</strong></td>
                <td><?php echo $OrderInfo[Amount];?></td>
              </tr>
              <tr>
                <td height="30" align="right"><strong>描述：</strong></td>
                <td><?php echo $OrderInfo[Description];?></td>
              </tr>
              <tr>
                <td height="30" align="right"><strong>备注：</strong></td>
                <td><?php echo $OrderInfo[Remarks];?></td>
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
	name="button" type="submit" class="btn" id="button" value=" 返 回 " onclick="history.go(-1)"/>

    
  </div>
</body>
</html>
