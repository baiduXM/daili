<?php
/*
 ExpressPHP Template Compiler 3.0.0 beta
 compiled from FuWuLists.htm at 2014-11-01 12:35:55 Asia/Shanghai
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
    <div class="panel-header-content">风信服务管理</div>
    <div class="panel-header-right"></div>
  </div>
  <div class="panel-body">
    <div class="panel-body-left">
      <div class="panel-body-right">
        <div class="panel-body-content">
   <table width="100%" border="0" cellspacing="1" cellpadding="5" class="DataGird">
  <tr>
    <th width="367"  align="left" class="vertical-line">产品名称</th>
    <th width="189"  align="left" class="vertical-line">服务名称</th>
    <th width="176" class="vertical-line">价格</th>
    <th width="120">操作</th>
  </tr>
  <tbody>
  
<?php $__view__data__0__=$Data[Data];if(is_array($__view__data__0__)) { foreach($__view__data__0__ as $list) { ?>
  <tr>
    <td>风信</td>
    <td>&nbsp;<?php echo $list[FuWuName];?></td>
    <td align="center">&nbsp;<?php echo $list[FuWuPrice];?></td>
    <td align="center" ><a href="<?php echo UrlRewriteSimple($MyModule,'Lists',true); ?>&FuWuID=<?php echo $list[FuWuID];?>">编辑</a>&nbsp;&nbsp;
    <!--<a href="<?php echo UrlRewriteSimple($MyModule,'Delete',true); ?>&FuWuID=<?php echo $list[FuWuID];?>&Page=<?php echo $Data['Page'];?>">删除</a>--></td>
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
   <div style="line-height:50px;" class="font-12px"><?php if($Data[PageSize] < $Data[RecordCount]) { ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;第<?php echo $Data['Page'];?>页/共<?php echo $Data['PageCount'];?>页&nbsp;&nbsp;
<a href="<?php echo UrlRewriteSimple($MyModule,'Lists',true); ?>">首页</a>&nbsp;&nbsp;
<?php $__view__data__0__=$Data[PageNums];if(is_array($__view__data__0__)) { foreach($__view__data__0__ as $PageVal) { ?>
<a href="<?php echo UrlRewriteSimple($MyModule,'Lists',true); ?>&Page=<?php echo $PageVal;?>"><?php echo $PageVal;?></a>&nbsp;&nbsp;
<?php } } ?>
<a href="<?php echo UrlRewriteSimple($MyModule,'Lists',true); ?>&Page=<?php echo $Data['PageCount'];?>">尾页</a>&nbsp;&nbsp;<?php } ?> </div>   
</div>
 <div style="line-height:50px;" class="font-12px">

 </div>   
       


<form action="<?php echo UrlRewriteSimple('FuWu','AddAndEdit',true); ?>" method="post" enctype="multipart/form-data" name="form1" id="form1">
<div class="panel">
  <div class="panel-header">
    <div class="panel-header-left"></div>
    <div class="panel-header-content">添加/修改服务</div>
    <div class="panel-header-right"></div>
  </div>
  <div class="panel-body">
    <div class="panel-body-left">
      <div class="panel-body-right">
        <div class="panel-body-content">
   <table width="100%" border="0" cellspacing="1" cellpadding="5" class="DataGird">
  <tbody>
  <tr>
    <td>&nbsp;&nbsp; &nbsp;&nbsp;服务名称：
      <input name="FuWuName" type="text" class="input-style" id="FuWuName" maxlength="64" value="<?php echo $FuWuInfo[FuWuName];?>" />
      <input type="hidden" name="FuWuID" id="ProjectID" value="<?php echo $FuWuInfo[FuWuID];?>" />
      <input type="hidden" name="Page" id="ProjectID" value="<?php echo $Data[Page];?>" />
    </tr>
  <tr>
    <td>&nbsp;&nbsp; &nbsp;&nbsp;服务价格：
      <input name="FuWuPrice" type="text" class="input-style" id="FuWuPrice" value="<?php echo $FuWuInfo[FuWuPrice];?>"/>&nbsp;&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp; <input
	name="button" type="submit" class="btn" id="button" value=" <?php if($FuWuInfo[FuWuID]>0) { ?>修 改<?php } else { ?>添 加<?php } ?> " />&nbsp;&nbsp; 
 <input
	name="button2" type="reset" class="btn" id="button2" value=" 重 置 " /></td>
  </tr>
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
 <div style="line-height:50px;" class="font-12px">

 </div>   
       
</form>
</body>
</html>