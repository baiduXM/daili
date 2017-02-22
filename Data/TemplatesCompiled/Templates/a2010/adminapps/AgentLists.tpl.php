<?php
/*
 ExpressPHP Template Compiler 3.0.0 beta
 compiled from AgentLists.htm at 2014-12-18 09:04:07 Asia/Shanghai
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
    <div class="panel-header-content">代理商管理</div>
    <div class="panel-header-right"></div>
  </div>
  <div class="panel-body">
    <div class="panel-body-left">
      <div class="panel-body-right">
        <div class="panel-body-content">
          <table width="100%" border="0" cellspacing="1" cellpadding="5" class="DataGird">
            <tr>
              <th width="80"  align="left" class="vertical-line">用户名</th>
              <th width="80"  align="left" class="vertical-line">企业名称</th>
              <th width="80"  align="left" class="vertical-line">联系人</th>
              <th width="80"  align="left" class="vertical-line">联系电话</th>
              <th width="127" class="vertical-line">代理级别</th>
              <th width="60" class="vertical-line">充值总额</th>
              <th width="80">账户总余额</th>
              <th width="60">提供接口</th>
              <th width="150">操作</th>
            </tr>
            <tbody>
              
<?php $__view__data__0__=$Data[Data];if(is_array($__view__data__0__)) { foreach($__view__data__0__ as $list) { ?>
              <tr>
                <td>&nbsp;<?php echo $list[UserName];?></td>
                <td>&nbsp;<?php echo $list[EnterpriseName];?></td>
                <td>&nbsp;<?php echo $list[ContactName];?></td>
                <td>&nbsp;<?php echo $list[ContactTel];?></td>
                <td align="center">&nbsp;[风信:<?php echo GetNameByID($list[FengXinAgentPriceID]); ?>][G宝盆:<?php echo GetNameByID($list[GBaoPenAgentPriceID]); ?>]</td>
                <td align="center">&nbsp;<?php echo $list[Total];?></td>
                <td align="center">&nbsp;<?php echo $list[Balance];?></td>
                <td align="center">&nbsp;<?php echo ($list[Api][url]) ? '是' : '否'?></td>
                <td align="center" ><a href="<?php echo UrlRewriteSimple($MyModule,'Apiset',true); ?>&AgentID=<?php echo $list[AgentID];?>&Page=<?php echo $Data['Page'];?>">外接</a>&nbsp;&nbsp; <a href="<?php echo UrlRewriteSimple($MyModule,'Info',true); ?>&AgentID=<?php echo $list[AgentID];?>&Page=<?php echo $Data['Page'];?>">详情</a>&nbsp;&nbsp; <a href="<?php echo UrlRewriteSimple($MyModule,'Edit',true); ?>&AgentID=<?php echo $list[AgentID];?>&Page=<?php echo $Data['Page'];?>">编辑</a>&nbsp;&nbsp; <!--<a href="<?php echo UrlRewriteSimple($MyModule,'Delete',true); ?>&AgentID=<?php echo $list[AgentID];?>&Page=<?php echo $Data['Page'];?>">删除</a>-->
<a href="<?php echo UrlRewriteSimple($MyModule,'AddAccount',true); ?>&AgentID=<?php echo $list[AgentID];?>&Page=<?php echo $Data['Page'];?>">入账</a></td>
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
 
  <a href="<?php echo UrlRewriteSimple($MyModule,'Lists',true); ?>&Page=<?php echo $PageVal;?>"><?php echo $PageVal;?></a>&nbsp;&nbsp; 
  
<?php } } ?>
 
  <a href="<?php echo UrlRewriteSimple($MyModule,'Lists',true); ?>&Page=<?php echo $Data['PageCount'];?>">尾页</a>&nbsp;&nbsp;
  <?php } ?> </div>
</body>
</html>