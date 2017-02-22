<?php
/*
 ExpressPHP Template Compiler 3.0.0 beta
 compiled from AdminLogsAddLogs.htm at 2014-09-22 17:05:52 Asia/Shanghai
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
    <div class="panel-header-content">导入条件</div>
    <div class="panel-header-right"></div>
  </div>
  <div class="panel-body">
    <div class="panel-body-left">
      <div class="panel-body-right">
        <div class="panel-body-content">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <form name="form1" method="get" action="">
              <tr>
                <td height="30" align="right"><strong>开始时间</strong></td>
                <td><input name="StartTime" type="text" 
			id="StartTime" value="<?php echo $StartTime;?>" onClick="return Calendar('StartTime');"/></td>
                <td align="right"><strong>结束时间</strong></td>
                <td><input name="EndTime" type="text" 
			id="EndTime" value="<?php echo $EndTime;?>" onClick="return Calendar('EndTime');"/>
                <td height="30" align="right">&nbsp;</td>
                <td colspan="9">
                <button type="button" class="btn" id="button">导入</button>
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
    <div class="panel-header-content">日志导入结果</div>
    <div class="panel-header-right"></div>
  </div>
  <div class="panel-body">
    <div class="panel-body-left">
      <div class="panel-body-right">
        <div class="panel-body-content">
          <table width="100%" border="0" cellspacing="1" cellpadding="5" class="DataGird">
            <tr>
              <th width="50"  align="left" class="vertical-line">导入时间</th>
              <th width="50"  align="left" class="vertical-line">结果</th>
            </tr>
            <tbody id="showlist">
            <tr></tr>
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
<script type="text/javascript">
$(document).ready(function(){
	$("#button").click(function(){
		$("#showlist").html('<tr></tr>');
		var start = $("input[name='StartTime']").val();
		var end = $("input[name='EndTime']").val();
		function js_strto_time(str_time){
		    var arr = str_time.split("-");
		    var datum = new Date(Date.UTC(arr[0],arr[1]-1,arr[2]));
		    return strtotime = datum.getTime()/1000;
		}
		var b = js_strto_time(start);
		var e = js_strto_time(end);
		for (var i=b;i<=e;i=i+60*60*24){
			$.get("admin.php", { module:"AdminLogs",action:"ImportLogs", showdate: i},
					function(data){
						$("#showlist tr:last").before(data);
			})
		}
		$("#showlist tr:last").after('<tr><td>导入结束！</td></tr>');		

	})
})
</script>
</body>
</html>