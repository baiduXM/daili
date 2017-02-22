<?php
/*
 ExpressPHP Template Compiler 3.0.0 beta
 compiled from AgentInfo.htm at 2014-11-08 11:22:29 Asia/Shanghai
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
      <div class="panel-header-content">代理商详情</div>
      <div class="panel-header-right"></div>
    </div>
    <div class="panel-body">
      <div class="panel-body-left">
        <div class="panel-body-right">
          <div class="panel-body-content">
            <table width="100%" border="0" cellspacing="0" cellpadding="5">
              <tr>
                <td width="150" height="30" align="right"><strong>用户名：</strong></td>
                <td><?php echo $AgentInfo[UserName];?></td>
              </tr>
              <tr>
                <td width="150" height="30" align="right"><strong>企业名称：</strong></td>
                <td><?php echo $AgentInfo[EnterpriseName];?></td>
              </tr>
              <tr>
                <td width="150" align="right"><strong>风信代理级别：</strong></td>
                <td>&nbsp;<?php echo GetNameByID($AgentInfo[FengXinAgentPriceID]); ?></td>
              </tr>
              <tr>
                <td width="150" align="right"><strong>宝盆代理级别：</strong></td>
                <td>&nbsp;<?php echo GetNameByID($AgentInfo[GBaoPenAgentPriceID]); ?></td>
              </tr>
              <tr>
                <td height="30" align="right"><strong>联系人：</strong></td>
                <td><?php echo $AgentInfo[ContactName];?></td>
              </tr>
              <tr>
                <td height="30" align="right"><strong>联系电话：</strong></td>
                <td><?php echo $AgentInfo[ContactTel];?></td>
              </tr>
              <tr>
                <td height="30" align="right"><strong>电子邮件：</strong></td>
                <td><?php echo $AgentInfo[ContactEmail];?></td>
              </tr>
              <tr>
                <td height="30" align="right"><strong>地址：</strong></td>
                <td><?php echo $AgentInfo[ContactAddress];?></td>
              </tr>
              <tr>
                <td height="30" align="right"><strong>备注：</strong></td>
                <td><?php echo $AgentInfo[Remarks];?></td>
              </tr>
              <tr>
                <td height="30" align="right"><strong>财务明细：</strong></td>
                <td><table width="500" border="0">
                  <tr>
                    <td width="143" height="25">充值产品</td>
                    <td width="129">充值总额</td>
                    <td width="214">账户余额</td>
                  </tr>
                  
<?php $__view__data__0__=$AgentAccountInfo;if(is_array($__view__data__0__)) { foreach($__view__data__0__ as $list) { ?>
                  <tr>
                    <td height="25"><?php echo $list[ProjectName];?></td>
                    <td><?php echo $list[Total];?></td>
                    <td><?php echo $list[Balance];?></td>
                  </tr>
                  
<?php } } ?>
                  <tr>
                    <td height="25">合计</td>
                    <td><?php echo $AllTotal;?></td>
                    <td><?php echo $AllBalance;?></td>
                  </tr>
                </table></td>
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
