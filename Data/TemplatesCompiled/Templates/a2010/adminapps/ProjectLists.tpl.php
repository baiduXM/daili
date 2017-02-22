<?php
/*
 ExpressPHP Template Compiler 3.0.0 beta
 compiled from ProjectLists.htm at 2014-11-01 11:36:24 Asia/Shanghai
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
<form id="form1" name="form1" method="get" action="<?php echo UrlRewriteSimple('Articles','Delete',true); ?>">
<div class="panel">
  <div class="panel-header">
    <div class="panel-header-left"></div>
    <div class="panel-header-content">产品管理</div>
    <div class="panel-header-right"></div>
  </div>
  <div class="panel-body">
    <div class="panel-body-left">
      <div class="panel-body-right">
        <div class="panel-body-content">
   <table width="100%" border="0" cellspacing="1" cellpadding="5" class="DataGird">
  <tr>
    <th width="50" class="vertical-line">#ID</th>
    <th width="200"  align="left" class="vertical-line">产品名称</th>
    <th width="200"  align="left" class="vertical-line">上线时间</th>
    <th width="200" class="vertical-line">项目属性</th>
	 <th width="200" class="vertical-line">最后操作日期</th>
    <th width="200">操作</th>
  </tr>
  <tbody>
  
<?php $__view__data__0__=$Data[Data];if(is_array($__view__data__0__)) { foreach($__view__data__0__ as $list) { ?>
  <tr>
    <td align="center"><?php echo $list[ProjectID];?></td>
    <td>&nbsp;<?php echo $list[ProjectName];?></td>
    <td>&nbsp;<?php echo date('Y-m-d', strtotime($list[OnlineTime])); ?></td>
    <td align="center" style="font-size:9px;">&nbsp;</td>
	<td align="center" style="font-size:9px;"><?php echo date('Y-m-d', strtotime($list[UpdateTime])); ?></td>
    <td align="left" ><a href="<?php echo UrlRewriteSimple($MyModule,'Edit',true); ?>&KeyID=<?php echo $list[ProjectID];?>">编辑</a>&nbsp;&nbsp;
    <!--<a href="<?php echo UrlRewriteSimple($MyModule,'Delete',true); ?>&KeyID=<?php echo $list[ProjectID];?>&Page=<?php echo $Data['Page'];?>">删除</a>&nbsp;&nbsp;-->
    <a href="<?php echo UrlRewriteSimple('Property','Lists',true); ?>&ProjectID=<?php echo $list[ProjectID];?>&Page=<?php echo $Data['Page'];?>">管理版本</a>&nbsp;&nbsp;
    <?php if($list[ProjectID]==7) { ?><a href="<?php echo UrlRewriteSimple('FuWu','Lists',true); ?>&ProjectID=<?php echo $list[ProjectID];?>&Page=<?php echo $Data['Page'];?>">服务大全</a>&nbsp;&nbsp;<?php } ?></td>
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
<a href="<?php echo UrlRewriteSimple($MyModule,'Lists',true); ?>?Page=<?php echo $PageVal;?>"><?php echo $PageVal;?></a>&nbsp;&nbsp;
<?php } } ?>
<a href="<?php echo UrlRewriteSimple($MyModule,'Lists',true); ?>?Page=<?php echo $Data['PageCount'];?>">尾页</a>&nbsp;&nbsp;<?php } ?> </div>   
       
</form>

</body>
</html>