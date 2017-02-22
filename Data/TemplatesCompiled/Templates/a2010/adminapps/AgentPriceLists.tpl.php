<?php
/*
 ExpressPHP Template Compiler 3.0.0 beta
 compiled from AgentPriceLists.htm at 2014-09-11 17:23:11 Asia/Shanghai
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
    <div class="panel-header-content">代理商价格管理</div>
    <div class="panel-header-right"></div>
  </div>
  <div class="panel-body">
    <div class="panel-body-left">
      <div class="panel-body-right">
        <div class="panel-body-content">
          <table width="100%" border="0" cellspacing="1" cellpadding="5" class="DataGird">
            <tr>
              <th width="130"  align="left" class="vertical-line">代理产品</th>
              <th width="130"  align="left" class="vertical-line">代理级别</th>
              <th width="130"  align="left" class="vertical-line">代理折扣</th>
              <th width="124">操作</th>
            </tr>
            <tbody>
              
<?php $__view__data__0__=$Data[Data];if(is_array($__view__data__0__)) { foreach($__view__data__0__ as $list) { ?>
              <tr>
                <td>&nbsp;<?php echo $list[ProjectName];?></td>
                <td>&nbsp;<?php echo $list[LevelName];?></td>
                <td>&nbsp;<?php echo $list[AgenDiscount];?></td>
                <td align="center" ><a href="<?php echo UrlRewriteSimple($MyModule,'Edit',true); ?>&AgentPriceID=<?php echo $list[AgentPriceID];?>&Page=<?php echo $Data['Page'];?>">编辑</a><!--&nbsp;&nbsp; <a href="<?php echo UrlRewriteSimple($MyModule,'Delete',true); ?>&AgentPriceID=<?php echo $list[AgentPriceID];?>&Page=<?php echo $Data['Page'];?>">删除</a>--></td>
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
<div style="line-height:50px;" class="font-12px"> <?php if($Data[PageSize] < $Data[RecordCount]) { ?>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;第<?php echo $Data['Page'];?>页/共<?php echo $Data['PageCount'];?>页&nbsp;&nbsp; <a href="<?php echo UrlRewriteSimple($MyModule,'Lists',true); ?>">首页</a>&nbsp;&nbsp; 
  
<?php $__view__data__0__=$Data[PageNums];if(is_array($__view__data__0__)) { foreach($__view__data__0__ as $PageVal) { ?>
 
  <a href="<?php echo UrlRewriteSimple($MyModule,'Lists',true); ?>?Page=<?php echo $PageVal;?>"><?php echo $PageVal;?></a>&nbsp;&nbsp; 
  
<?php } } ?>
 
  <a href="<?php echo UrlRewriteSimple($MyModule,'Lists',true); ?>?Page=<?php echo $Data['PageCount'];?>">尾页</a>&nbsp;&nbsp;
  <?php } ?> </div>
</body>
</html>