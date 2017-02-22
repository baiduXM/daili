<?php
/*
 ExpressPHP Template Compiler 3.0.0 beta
 compiled from AdminLogsLogsLists.htm at 2015-02-03 01:24:08 Asia/Shanghai
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
    <div class="panel-header-content">搜索日志</div>
    <div class="panel-header-right"></div>
  </div>
  <div class="panel-body">
    <div class="panel-body-left">
      <div class="panel-body-right">
        <div class="panel-body-content">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <form name="form1" method="get" action="<?php echo UrlRewriteSimple('Financial','Seach',true); ?>">
              <tr>
              	<td width="125" align="right"><strong>代理商</strong></td>
              	<td width="125"><input type="text" name="AgentIDValue" id="AgentIDValue" value="<?php echo $AgentIDValue;?>"></td>
              	<td width="125" align="right"><strong>客户企业名称</strong></td>
              	<td width="125"><input type="text" name="CustomersIDValue" id="CustomersIDValue" value="<?php echo $CustomersIDValue;?>"></td>
                <td width="125" height="30" align="right"><strong>订单号</strong></td>
                <td width="125"><input type="text" name="OrderNO" id="OrderNO" value="<?php echo $OrderNO;?>"></td>
                <td height="30" align="right"><strong>操作时间</strong></td>
                <td><input name="Time" type="text" 
			id="Time" value="<?php echo $Time;?>" onClick="return Calendar('Time');"/></td>
            </td>
                <td align="right"><span class="vertical-line"><strong>客户端IP</strong></span></td>
                <td><input type="text" name="FromIP" id="FromIP" value="<?php echo $FromIP;?>"></td>
                <td height="30" align="right">&nbsp;</td>
                <td colspan="9">
                  <input name="button" type="submit" class="btn" id="button" value="搜索 " />
                  <input type="hidden" name="module" id="module" value="AdminLogs">
                  <input type="hidden" name="action" id="action" value="LogsLists">
                  <input type="hidden" name="seachValue" id="seachValue" value="1">
				</td>
              </tr>
            </form>
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
    <div class="panel-header-content">日志列表</div>
    <div class="panel-header-right"></div>
  </div>
  <div class="panel-body">
    <div class="panel-body-left">
      <div class="panel-body-right">
        <div class="panel-body-content">
          <table width="100%" border="0" cellspacing="1" cellpadding="5" class="DataGird">
            <tr>
              <th width="50"  align="left" class="vertical-line">编号</th>
              <th width="100"  align="left" class="vertical-line">操作</th>
              <th width="100"  align="left" class="vertical-line">结果</th>
              <th width="111"  align="left" class="vertical-line">客户端IP</th>
              <th width="112"  align="left" class="vertical-line">操作时间</th>
              <th width="80" class="vertical-line">操作代理</th>
              <th width="80" class="vertical-line">操作对象</th>
              <th width="191">描述</th>
              <th width="48">订单号</th>
            </tr>
            <tbody>
              
<?php $__view__data__0__=$Data[Data];if(is_array($__view__data__0__)) { foreach($__view__data__0__ as $list) { ?>
              <tr>
                <td>&nbsp;<?php echo $list[id];?></td>
                <td>&nbsp;<?php echo $list[code];?></td>
                <td>&nbsp;<?php echo $list[status];?></td>
                <td>&nbsp;<?php echo $list[ip];?></td>
                <td>&nbsp;<?php echo $list[time];?></td>
                <td style="text-align:center;">&nbsp;<?php echo $list[AgentUserName];?></td>
                <td style="text-align:center;">&nbsp;<?php echo $list[CustomersName];?></td>
                <td align="center">&nbsp;<span title='<?php echo $list[Remark];?>'><?php echo _cutstr($list[Remark],20); ?></span></td>
                <td align="center">&nbsp;<?php echo $list[OrderNO];?></td>
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
<div style="line-height:50px;" class="font-12px"> <?php if($Data[PageSize] < $Data[RecordCount]) { ?>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;第<?php echo $Data['Page'];?>页/共<?php echo $Data['PageCount'];?>页&nbsp;&nbsp; <a href="<?php echo UrlRewriteSimple($MyModule,'LogsLists',true); echo $so;?>&<?php echo $WhereGet;?>">首页</a>&nbsp;&nbsp; 
  
<?php $__view__data__0__=$Data[PageNums];if(is_array($__view__data__0__)) { foreach($__view__data__0__ as $PageVal) { ?>
 
<a href="<?php echo UrlRewriteSimple($MyModule,'LogsLists',true); ?>&Page=<?php echo $PageVal;?><?php echo $so;?>"><?php echo $PageVal;?></a>&nbsp;&nbsp; 
<?php } } ?>
 
<a href="<?php echo UrlRewriteSimple($MyModule,'LogsLists',true); ?>&Page=<?php echo $Data['PageCount'];?><?php echo $so;?>&<?php echo $WhereGet;?>">尾页</a>&nbsp;&nbsp;
  <?php } ?></div>
</body>
</html>