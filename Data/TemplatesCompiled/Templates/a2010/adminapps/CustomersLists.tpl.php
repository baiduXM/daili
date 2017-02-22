<?php
/*
 ExpressPHP Template Compiler 3.0.0 beta
 compiled from CustomersLists.htm at 2014-12-18 11:15:28 Asia/Shanghai
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
<div class="panel">
  <div class="panel-header">
    <div class="panel-header-left"></div>
    <div class="panel-header-content">客户管理</div>
    <div class="panel-header-right"></div>
  </div>
  <div class="panel-body">
    <div class="panel-body-left">
      <div class="panel-body-right">
        <div class="panel-body-content">
   <table width="100%" border="0" cellspacing="1" cellpadding="5" class="DataGird">
  <tr>
    <th width="130"  align="left" class="vertical-line">企业名称</th>
    <th width="130"  align="left" class="vertical-line">企业联系人</th>
    <th width="130"  align="left" class="vertical-line">客户所属地区</th>
    <th width="130"  align="left" class="vertical-line">负责客服</th>
    <th width="130" class="vertical-line">联系电话</th>
	 <th width="130" class="vertical-line">最后操作日期</th>
    <th width="250">操作</th>
  </tr>
  <tbody>
  
<?php $__view__data__0__=$Data[Data];if(is_array($__view__data__0__)) { foreach($__view__data__0__ as $list) { ?>
  <tr>
    <td>&nbsp;<?php echo $list[CompanyName];?></td>
    <td>&nbsp;<?php echo $list[CustomersName];?></td>
    <td>&nbsp;<?php echo $list[Area];?></td>
    <td>&nbsp;<?php echo $list[ServiceName];?></td>
    <td align="center" style="font-size:9px;">&nbsp;<?php echo $list[Tel];?></td>
	<td align="center" style="font-size:9px;"><?php echo date('Y-m-d', strtotime($list[UpdateTime])); ?></td>
    <td align="center" ><a href="<?php echo UrlRewriteSimple($MyModule,'Edit',true); ?>&CustomersID=<?php echo $list[CustomersID];?>&Page=<?php echo $Data['Page'];?>">编辑</a>&nbsp;&nbsp;
    <a href="<?php echo UrlRewriteSimple($MyModule,'Delete',true); ?>&CustomersID=<?php echo $list[CustomersID];?>&Page=<?php echo $Data['Page'];?>">删除</a>&nbsp;&nbsp;
    <!--<a href="<?php echo UrlRewriteSimple('CustPro','Add',true); ?>&CustomersID=<?php echo $list[CustomersID];?>&Page=<?php echo $Data['Page'];?>">开通产品</a>&nbsp;&nbsp;-->
    <a href="<?php echo UrlRewriteSimple('CustPro','Lists',true); ?>&CustomersID=<?php echo $list[CustomersID];?>">管理本用户产品</a></td>
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

 <div style="line-height:50px;" class="font-12px"><?php if($Data[PageSize] < $Data[RecordCount]) { ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;第<?php echo $Data['Page'];?>页/共<?php echo $Data['PageCount'];?>页&nbsp;&nbsp;
<a href="<?php echo UrlRewriteSimple($MyModule,'Lists',true); ?>">首页</a>&nbsp;&nbsp;
<?php $__view__data__0__=$Data[PageNums];if(is_array($__view__data__0__)) { foreach($__view__data__0__ as $PageVal) { ?>
<a href="<?php echo UrlRewriteSimple($MyModule,'Lists',true); ?>&Page=<?php echo $PageVal;?>"><?php echo $PageVal;?></a>&nbsp;&nbsp;
<?php } } ?>
<a href="<?php echo UrlRewriteSimple($MyModule,'Lists',true); ?>&Page=<?php echo $Data['PageCount'];?>">尾页</a>&nbsp;&nbsp;<?php } ?> </div>   
       

</body>
</html>