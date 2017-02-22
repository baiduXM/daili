<?php
/*
 ExpressPHP Template Compiler 3.0.0 beta
 compiled from FinancialSeach.htm at 2015-02-03 01:16:45 Asia/Shanghai
*/
?><html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><?php $this->Display("header"); ?><style type="text/css">
<!--
@import url("/Templates/a2010/adminapps/images/style.css");
-->
</style>
<script type="text/javascript" src="Javascripts/calendar.js"></script>
</head>

<body>
<div class="panel">
  <div class="panel-header">
    <div class="panel-header-left"></div>
    <div class="panel-header-content">财务统计</div>
    <div class="panel-header-right"></div>
  </div>
  <div class="panel-body">
    <div class="panel-body-left">
      <div class="panel-body-right">
        <div class="panel-body-content">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <form name="form1" method="get" action="<?php echo UrlRewriteSimple('Financial','Seach',true); ?>">
              <tr>
                <td width="125" height="30" align="right"><strong>订单号</strong></td>
                <td width="125"><input type="text" name="OrderNO" id="OrderNO" value="<?php echo $OrderNO;?>"></td>
                <td width="125" height="30" align="right"><label for="OrderNO"><span class="vertical-line"><strong>入账/消费</strong></span></label></td>
                <td width="125"><select name="Type" id="Type">
                    <option value="">选择入账/消费</option>
                    <option value="入账" <?php if($Type=='入账') { ?>selected<?php } ?>>入账</option>
                    <option value="消费" <?php if($Type=='消费') { ?>selected<?php } ?>>消费</option>
                  </select></td>
                <td width="125" align="right"><span class="vertical-line"><strong>产品</strong></span></td>
                <td width="125"><select name="ProjectIDValue" id="ProjectIDValue">
                    <option value="">选择产品</option>
                    <option value="7" <?php if($ProjectIDValue==7) { ?>selected<?php } ?>>风信</option>
                    <option value="1" <?php if($ProjectIDValue==6) { ?>selected<?php } ?>>G宝盆</option>
                  </select></td>
                <td width="125" align="right"><strong>代理商</strong></td>
                <td width="125"><input type="text" name="AgentIDValue" id="AgentIDValue" value="<?php echo $AgentIDValue;?>"></td>
                <td width="125" align="right"><strong>客户企业名称</strong></td>
                <td width="125"><input type="text" name="CustomersIDValue" id="CustomersIDValue" value="<?php echo $CustomersIDValue;?>"></td>
              </tr>
              <tr>
                <td height="30" align="right"><strong>下订单开始时间</strong></td>
                <td><input name="StartTime" type="text" 
			id="StartTime" value="<?php echo $StartTime;?>" onclick="return Calendar('StartTime');"/></td>
                <td align="right"><strong>下订单结束时间</strong></td>
                <td><input name="EndTime" type="text" 
			id="EndTime" value="<?php echo $EndTime;?>" onclick="return Calendar('EndTime');"/>
            </td>
                <td align="right"><strong>最低交易金额</strong></td>
                <td><input type="text" name="MinAmount" id="MinAmount" value="<?php echo $MinAmount;?>"></td>
                <td align="right"><strong>最高交易金额</strong></td>
                <td><input type="text" name="MaxAmount" id="MaxAmount" value="<?php echo $MaxAmount;?>"></td>
                <td align="right"><span class="vertical-line"><strong>客户端IP</strong></span></td>
                <td><input type="text" name="FromIP" id="FromIP" value="<?php echo $FromIP;?>"></td>
              </tr>
              <tr>
                <td height="30" align="right">&nbsp;</td>
                <td colspan="9">
                <input
	name="button3" type="submit" class="btn" id="button3" value=" 统 计 " />
                <input
	name="button4" type="reset" class="btn" id="button4" value=" 重新搜索 " onClick="location.href='<?php echo UrlRewriteSimple('Financial','Seach',true); ?>'"/>
                  <input type="hidden" name="module" id="module" value="Financial">
                  <input type="hidden" name="action" id="action" value="Seach">
                  <input type="hidden" name="seachValue" id="seachValue" value="1">
                  <font color="#FF0000">注：暂时统计记录最高5000条，超过5000条数据则不能正确统计，可以缩短时间统计。</font></td>
              </tr>
              <?php if($seachValue) { ?>              <tr>
                <td height="30" align="right" bgcolor="#CCCCCC"><strong>统计结果：</strong></td>
                <td colspan="9" bgcolor="#CCCCCC"><?php if($Data[RecordCount]==5000) { ?>数据太多，统计失败。<?php } else { ?><font color="#0033FF"><strong>总共<?php echo $Data[RecordCount];?>条记录；消费记录<?php echo $XiaoFeiNum;?>条，总消费金额共<?php echo $XiaoFei;?>元；入账记录<?php echo $RuZhangNum;?>条，总入账金额共<?php echo $RuZhang;?>元。</strong></font><?php } ?></td>
              </tr><?php } ?>            </form>
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
<div class="panel">
  <div class="panel-header">
    <div class="panel-header-left"></div>
    <div class="panel-header-content">财务统计</div>
    <div class="panel-header-right"></div>
  </div>
  <div class="panel-body">
    <div class="panel-body-left">
      <div class="panel-body-right">
        <div class="panel-body-content">
          <table width="100%" border="0" cellspacing="1" cellpadding="5" class="DataGird">
            <tr>
              <th width="109"  align="left" class="vertical-line">订单号</th>
              <th width="111"  align="left" class="vertical-line">入账/消费</th>
              <th width="101"  align="left" class="vertical-line">代理商</th>
              <th width="111"  align="left" class="vertical-line">操作时间</th>
              <th width="112"  align="left" class="vertical-line">操作产品</th>
              <th width="88" class="vertical-line">客户端IP</th>
              <th width="114" class="vertical-line">金额</th>
              <th width="191">描述</th>
              <th width="48">操作</th>
            </tr>
            <tbody>
              
<?php $__view__data__0__=$Data[Data];if(is_array($__view__data__0__)) { foreach($__view__data__0__ as $list) { ?>
              <tr>
                <td>&nbsp;<a href="<?php echo UrlRewriteSimple($MyModule,'Info',true); ?>&OrderID=<?php echo $list[OrderID];?>&Page=<?php echo $Data['Page'];?>"><?php echo $list[OrderNO];?></a></td>
                <td>&nbsp;<?php echo $list[TypeName];?></td>
                <td>&nbsp;<?php echo $list[UserName];?></td>
                <td>&nbsp;<?php echo $list[AddTime];?></td>
                <td>&nbsp;<?php echo $list[ProjectName];?></td>
                <td align="center">&nbsp;<?php echo $list[FromIP];?></td>
                <td align="center">&nbsp;<?php echo $list[Amount];?></td>
                <td align="center" title="<?php echo $list[Description];?>">&nbsp;<?php echo _cutstr($list[Description],20); ?></td>
                <td align="center" ><a href="<?php echo UrlRewriteSimple($MyModule,'Info',true); ?>&OrderID=<?php echo $list[OrderID];?>&Page=<?php echo $Data['Page'];?>">详情</a></td>
              </tr>
              
<?php } } ?>
            </tbody>
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
<!--<div style="line-height:50px;" class="font-12px"> <?php if($Data[PageSize] < $Data[RecordCount]) { ?>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;第<?php echo $Data['Page'];?>页/共<?php echo $Data['PageCount'];?>页&nbsp;&nbsp; <a href="<?php echo UrlRewriteSimple($MyModule,'Seach',true); ?>$<?php echo $WhereGet;?>">首页</a>&nbsp;&nbsp; 
  
<?php $__view__data__0__=$Data[PageNums];if(is_array($__view__data__0__)) { foreach($__view__data__0__ as $PageVal) { ?>
 
<a href="<?php echo UrlRewriteSimple($MyModule,'Seach',true); ?>&Page=<?php echo $PageVal;?>$<?php echo $WhereGet;?>"><?php echo $PageVal;?></a>&nbsp;&nbsp; 
<?php } } ?>
 
<a href="<?php echo UrlRewriteSimple($MyModule,'Seach',true); ?>&Page=<?php echo $Data['PageCount'];?>$<?php echo $WhereGet;?>">尾页</a>&nbsp;&nbsp;
  <?php } ?></div>
-->
</body>
</html>