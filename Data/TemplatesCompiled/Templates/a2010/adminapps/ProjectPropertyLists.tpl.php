<?php
/*
 ExpressPHP Template Compiler 3.0.0 beta
 compiled from ProjectPropertyLists.htm at 2014-03-31 17:07:14 Asia/Shanghai
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
    <div class="panel-header-content">属性管理</div>
    <div class="panel-header-right"></div>
  </div>
  <div class="panel-body">
    <div class="panel-body-left">
      <div class="panel-body-right">
        <div class="panel-body-content">
   <table width="100%" border="0" cellspacing="1" cellpadding="5" class="DataGird">
  <tr>
    <th  align="left" class="vertical-line">属性名称</th>
    <th  align="left" class="vertical-line">产品名称</th>
    <th width="120" class="vertical-line">最后操作日期</th>
    <th width="120">操作</th>
  </tr>
  <tbody>
  
<?php $__view__data__0__=$Data;if(is_array($__view__data__0__)) { foreach($__view__data__0__ as $list) { ?>
  <tr>
    <td>&nbsp;<?php echo $list[PropertyPropertyName];?></span></td>
    <td>&nbsp;<?php echo $ProjectInfo[ProjectName];?></td>
    <td align="center" style="font-size:9px;"><?php echo date('Y-m-d', strtotime($list[UpdateTime])); ?></td>
    <td align="center" ><a href="<?php echo UrlRewriteSimple('ProjectProperty','Lists',true); ?>&ProjectID=<?php echo $list[ProjectID];?>&PropertyPropertyID=<?php echo $list[PropertyPropertyID];?>">编辑</a>&nbsp;&nbsp;
    <a href="<?php echo UrlRewriteSimple('ProjectProperty','Delete',true); ?>&PropertyPropertyID=<?php echo $list[PropertyPropertyID];?>&ProjectID=<?php echo $ProjectInfo['ProjectID'];?>">删除</a>&nbsp;&nbsp;    </td>
  </tr>
          
<?php $__view__data__1__=$list[Two];if(is_array($__view__data__1__)) { foreach($__view__data__1__ as $ListTwo) { ?>
          <tr style="color:#777777;">
            <td>&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;<?php echo $ListTwo[PropertyPropertyName];?></td>
            <td>&nbsp;<?php echo $ProjectInfo[ProjectName];?></td>
            <td align="center" style="font-size:9px;">&nbsp;<?php echo date('Y-m-d', strtotime($ListTwo[UpdateTime])); ?></td>
            <td align="center" >&nbsp;<a href="<?php echo UrlRewriteSimple('ProjectProperty','Lists',true); ?>&ProjectID=<?php echo $ListTwo[ProjectID];?>&PropertyPropertyID=<?php echo $ListTwo[PropertyPropertyID];?>">编辑</a>&nbsp;&nbsp;
    <a href="<?php echo UrlRewriteSimple('ProjectProperty','Delete',true); ?>&PropertyPropertyID=<?php echo $ListTwo[PropertyPropertyID];?>&ProjectID=<?php echo $ProjectInfo['ProjectID'];?>">删除</a>&nbsp;&nbsp;</td>
          </tr>
          
<?php } } ?>
  
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
 <div style="line-height:50px;" class="font-12px">

 </div>   
       
</form>


<form action="<?php echo UrlRewriteSimple('ProjectProperty','Add',true); ?>"
	method="post" enctype="multipart/form-data" name="form1" id="form1">
<div class="panel">
  <div class="panel-header">
    <div class="panel-header-left"></div>
    <div class="panel-header-content">添加属性</div>
    <div class="panel-header-right"></div>
  </div>
  <div class="panel-body">
    <div class="panel-body-left">
      <div class="panel-body-right">
        <div class="panel-body-content">
   <table width="100%" border="0" cellspacing="1" cellpadding="5" class="DataGird">
  <tbody>
  <tr>
    <td>&nbsp;&nbsp; &nbsp;&nbsp; 产品名称：<input name="ProjectName" type="text" class="input-style"
			id="ProjectName" maxlength="64" readonly="readonly" value="<?php echo $ProjectInfo[ProjectName];?>" />
            <input type="hidden" name="ProjectID" id="ProjectID" value="<?php echo $ProjectInfo[ProjectID];?>" />
            <input type="hidden" name="PropertyPropertyID" id="PropertyPropertyID" value="<?php echo $PropertyPropertyInfo[PropertyPropertyID];?>" /></td>
    </tr>
  <tr>
    <td>&nbsp;&nbsp; &nbsp;&nbsp; 一级属性名称：      
      <select name="PropertyPropertyParentID" id="PropertyPropertyParentID">
        <option value="0" <?php if($PropertyPropertyInfo[PropertyPropertyParentID]==0) { ?>selected<?php } ?>>顶级属性</option>
        
<?php $__view__data__0__=$ParentData;if(is_array($__view__data__0__)) { foreach($__view__data__0__ as $ParenList) { ?>
        <option value="<?php echo $ParenList[PropertyPropertyID];?>" <?php if($PropertyPropertyInfo[PropertyPropertyParentID]==$ParenList[PropertyPropertyID]) { ?>selected<?php } ?>><?php echo $ParenList[PropertyPropertyName];?></option>
        
<?php } } ?>
      </select>
      </td>
  </tr>
  <tr>
    <td>&nbsp;&nbsp; &nbsp;&nbsp; 二级属性名称：
      <input name="PropertyPropertyName" type="text" class="input-style" id="PropertyPropertyName" value="<?php echo $PropertyPropertyInfo[PropertyPropertyName];?>"/>
    &nbsp;&nbsp; &nbsp;&nbsp; <input
	name="button" type="submit" class="btn" id="button" value=" <?php if($PropertyPropertyInfo[PropertyPropertyID]>0) { ?>修 改<?php } else { ?>添 加<?php } ?> " />&nbsp;&nbsp; 
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