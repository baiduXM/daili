<?php
/*
 ExpressPHP Template Compiler 3.0.0 beta
 compiled from FuwuqiManage.htm at 2015-11-19 16:01:36 Asia/Shanghai
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
    <div class="panel-header-content">服务器管理</div>
    <div class="panel-header-right"></div>
  </div>
  <div class="panel-body">
    <div class="panel-body-left">
      <div class="panel-body-right">
        <div class="panel-body-content">
   <table width="100%" border="0" cellspacing="1" cellpadding="5" class="DataGird">
  <tr>
    <th width="50" class="vertical-line">ID</th>
    <th width="100"  align="left" class="vertical-line">名称</th>
    <th width="100"  align="left" class="vertical-line">IP</th>
	 <th width="100" class="vertical-line">CNAME地址</th>
	 <th width="100" class="vertical-line">访问地址</th>
    <th width="300">FTP</th>
    <th width="100">FTP端口</th>
    <th width="100">FTP目录</th>
    <th width="100">网站数量</th>
    <th width="100">状态</th>
    <th width="100">操作</th>
  </tr>
  <tbody>
  
<?php $__view__data__0__=$Data;if(is_array($__view__data__0__)) { foreach($__view__data__0__ as $list) { ?>
  <tr>
    <td align="center"><?php echo $list['ID'];?></td>
    <td>&nbsp;<?php echo $list['FuwuqiName'];?></td>
    <td>&nbsp;<?php echo $list['IP'];?></td>
    <td align="center">&nbsp;<?php echo $list['CName'];?></td>
    <td align="center">&nbsp;<?php echo $list['FwAdress'];?></td>
	<td align="center"><?php echo $list['FTP'];?>-<?php echo $list['FTPName'];?>-<?php echo $list['FTPPassword'];?></td>
	<td align="center"><?php echo $list['FTPDuankou'];?></td>
	<td align="center"><?php echo $list['FTPMulu'];?></td>
	<td align="center"><?php echo $list['WebNum'];?></td>
	<td align="center"><?php if($list['State']==1) { ?>启用<?php } else { ?>禁用<?php } ?></td>
    <td align="center" ><a href="<?php echo UrlRewriteSimple($MyModule,'Add',true); ?>&SeverID=<?php echo $list[ID];?>">修改</a>&nbsp;&nbsp;
    <!--<a href="<?php echo UrlRewriteSimple($MyModule,'Delete',true); ?>&KeyID=<?php echo $list[ID];?>}">删除</a>&nbsp;&nbsp;-->
   
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
</form>

</body>
</html>