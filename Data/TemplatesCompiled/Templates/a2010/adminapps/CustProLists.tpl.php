<?php
/*
 ExpressPHP Template Compiler 3.0.0 beta
 compiled from CustProLists.htm at 2014-11-08 11:15:54 Asia/Shanghai
*/
?><html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><?php $this->Display("header"); ?><style type="text/css">
<!--
@import url("/Templates/a2010/adminapps/images/style.css");
-->
</style>
<script type="text/javascript" src="Javascripts/calendar.js"></script>
<script type="text/javascript">

function myObjRequest(){
	var myhttp=null;
	try {
		myhttp = new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch(ie) {
			    try{
					myhttp = new ActiveXObject("Microsoft.XMLHTTP");
				}
				catch(huohu){
					myhttp = new XMLHttpRequest();
					}
			}
	return myhttp;
}

function getweather(){
  var r=Math.random();
  var url="/index.php?module=Tianqi&action=GetWeather&r="+r;
  var myObj=myObjRequest();
  myObj.open("GET",url,true);
  myObj.onreadystatechange=function(){
    if (myObj.readyState==4){
	  if (myObj.status==200){ 
	    // document.getElementById(divname).innerHTML=myObj.responseText;
	  }
	}
  }
  myObj.send(null)
  }
//-->




$(document).ready(function(){
	$('#ProjectID').change(function(){
		var ProjectID = parseInt($("#ProjectID").val());
		GetProjectProperty(ProjectID);
	});
});
function GetProjectProperty(ProjectID){
	if(!ProjectID){
		return false;
	}
	
	var r=Math.random();
  	var url="/admin.php?module=CustPro&action=GetProjectProperty&ProjectID="+ProjectID+"&r="+r;
  	var myObj=myObjRequest();
  	myObj.open("GET",url,true);
  	myObj.onreadystatechange=function(){
    if (myObj.readyState==4){
	  if (myObj.status==200){
	    document.getElementById('PropertyPropertyID').innerHTML=myObj.responseText;
	  }
	}
  }
  myObj.send(null)
}
</script>
</head>

<body>
<form id="form1" name="form1" method="get" action="<?php echo UrlRewriteSimple('Articles','Delete',true); ?>">
<div class="panel">
  <div class="panel-header">
    <div class="panel-header-left"></div>
    <div class="panel-header-content">客户管理 > 客户产品管理</div>
    <div class="panel-header-right"></div>
  </div>
  <div class="panel-body">
    <div class="panel-body-left">
      <div class="panel-body-right">
        <div class="panel-body-content">
   <table width="100%" border="0" cellspacing="1" cellpadding="5" class="DataGird">
  <tr>
    <th width="130"  align="left" class="vertical-line">产品名称</th>
    <th width="130"  align="left" class="vertical-line">企业名称</th>
    <th width="130"  align="left" class="vertical-line">行业版本</th>
    <th width="130"  align="left" class="vertical-line">增购服务</th>
    <th width="130" class="vertical-line">到期时间</th>
	 <th width="130" class="vertical-line">最后操作日期</th>
    <th width="250">操作</th>
  </tr>
  <tbody>
  
<?php $__view__data__0__=$Data[Data];if(is_array($__view__data__0__)) { foreach($__view__data__0__ as $list) { ?>
  <tr>
    <td>&nbsp;<?php echo $list[ProjectName];?></td>
    <td>&nbsp;<font color="#FF0000"><?php echo $list[CompanyName];?></font></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="center" style="font-size:9px;">&nbsp;<?php echo date('Y-m-d', strtotime($list[EndTime])); ?></td>
	<td align="center" style="font-size:9px;"><?php echo date('Y-m-d', strtotime($list[UpdateTime])); ?></td>
    <td align="center" ><a href="<?php echo UrlRewriteSimple($MyModule,'Lists',true); ?>&CustomersProjectID=<?php echo $list[CustomersProjectID];?>&CustomersID=<?php echo $list[CustomersID];?>">编辑</a>&nbsp;&nbsp;
    <a href="<?php echo UrlRewriteSimple($MyModule,'Delete',true); ?>&CustomersProjectID=<?php echo $list[CustomersProjectID];?>&CustomersID=<?php echo $list[CustomersID];?>">删除</a>&nbsp;&nbsp;
    <?php if($list[ProjectID]==1) { ?><a href="/interface.php?module=Interfaces&action=UpdateGBPen&CustomersProjectID=<?php echo $list[CustomersProjectID];?>">更新聚宝盆信息</a>&nbsp;&nbsp;
    <?php } elseif($list[ProjectID]==6) { ?><a href="/interface.php?module=Interfaces&action=OpenShop&CustomersProjectID=<?php echo $list[CustomersProjectID];?>">开通爱上城</a>&nbsp;&nbsp;
    <a href="/interface.php?module=Interfaces&action=UpdateShop&CustomersProjectID=<?php echo $list[CustomersProjectID];?>">更新爱商城信息</a>&nbsp;&nbsp;
    <?php } ?></td>
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
<a href="<?php echo UrlRewriteSimple($MyModule,'Lists',true); ?>&CustomersID=<?php echo $CustomersInfo[CustomersID];?>">首页</a>&nbsp;&nbsp;
<?php $__view__data__0__=$Data[PageNums];if(is_array($__view__data__0__)) { foreach($__view__data__0__ as $PageVal) { ?>
<a href="<?php echo UrlRewriteSimple($MyModule,'Lists',true); ?>&CustomersID=<?php echo $CustomersInfo[CustomersID];?>&Page=<?php echo $PageVal;?>"><?php echo $PageVal;?></a>&nbsp;&nbsp;
<?php } } ?>
<a href="<?php echo UrlRewriteSimple($MyModule,'Lists',true); ?>&CustomersID=<?php echo $CustomersInfo[CustomersID];?>&Page=<?php echo $Data['PageCount'];?>">尾页</a>&nbsp;&nbsp;<?php } ?> </div>   
       
</form>
<form action="<?php echo UrlRewriteSimple('CustPro','Add',true); ?>"
	method="post" enctype="multipart/form-data" name="form1" id="form1">
    
<div class="panel">
  <div class="panel-header">
    <div class="panel-header-left"></div>
    <div class="panel-header-content"><?php if($CustomersProjectID>0) { ?>编辑客户产品<?php } else { ?>开通客户产品<?php } ?></div>
    
    <div class="panel-header-right"></div>
  </div>
  <div class="panel-body">
    <div class="panel-body-left">
      <div class="panel-body-right">
        <div class="panel-body-content">
   <table width="100%" border="0" cellspacing="0" cellpadding="5">
	<tr>
      <td width="150" align="right">产品名称：</td>
	  <td><select name="ProjectID" id="ProjectID">
      	<option value="">&nbsp;&nbsp;选择产品&nbsp;&nbsp;</option>
        
<?php $__view__data__0__=$ProjectLists;if(is_array($__view__data__0__)) { foreach($__view__data__0__ as $List) { ?>
        <option value="<?php echo $List[ProjectID];?>" <?php if($CustProInfo['ProjectID']==$List[ProjectID]) { ?> selected <?php } ?>>&nbsp;&nbsp;<?php echo $List[ProjectName];?>&nbsp;&nbsp;</option>
        
<?php } } ?>
      </select></td>
	  </tr>
	<tr>
      <td align="right">产品属性：</td>
	  <td><span id='PropertyPropertyID'>
      <?php if($CustomersProjectID>0) { ?>      <?php echo $CustProInfo['property'];?>      <?php } else { ?>      选择产品后显示
      <?php } ?>      </span></td>
	  </tr>
	<tr>
      <td align="right">产品开通时间：</td>
	  <td><input name="StartTime" type="text" class="input-style" id="StartTime" onClick="return Calendar('StartTime');" value="<?php if($CustomersProjectID>0) { echo date('Y-m-d', strtotime($CustProInfo[StartTime])); } ?>"/></td>
	  </tr>
	<tr>
      <td align="right">产品到期时间：</td>
	  <td><input name="EndTime" type="text" class="input-style" id="EndTime" onClick="return Calendar('EndTime');" value="<?php if($CustomersProjectID>0) { echo date('Y-m-d', strtotime($CustProInfo[EndTime])); } ?>"/></td>
	  </tr>
	<!--<tr>
      <td align="right">产品时间延期至：</td>
	  <td><input name="MoreTime" type="text" class="input-style" id="MoreTime" onClick="return Calendar('MoreTime');" value="<?php if($CustomersProjectID>0) { echo date('Y-m-d', strtotime($CustProInfo[MoreTime])); } ?>"/></td>
	  </tr>-->
	<tr>
	  <td align="right">备注：</td>
	  <td><textarea name="Remark" cols="100" rows="5" class="input-style" id="Remark"><?php echo $CustProInfo['Remark'];?></textarea>
	    <input type="hidden" name="CustomersID" id="CustomersID" value="<?php echo $CustomersInfo[CustomersID];?>" />
	    <input type="hidden" name="CustomersProjectID" id="CustomersProjectID" value="<?php echo $CustomersProjectID;?>" /></td>
	  </tr>
      
    <tr>
      <td align="right">公众号名称：</td>
	  <td><input name="WeiXinName" type="text" class="input-style" id="WeiXinName" value="<?php echo $CustProInfo[WeiXinName];?>"/> <font color="#FF0000">风信产品才需要填写</font></td>
	  </tr>
    <tr>
      <td align="right">公众号原始id：</td>
	  <td><input name="WeiXinID" type="text" class="input-style" id="WeiXinID" value="<?php echo $CustProInfo[WeiXinID];?>"/> <font color="#FF0000">风信产品才需要填写</font></td>
	  </tr>
    <tr>
      <td align="right">微信号：</td>
	  <td><input name="WeiXinNO" type="text" class="input-style" id="WeiXinNO" value="<?php echo $CustProInfo[WeiXinNO];?>"/> <font color="#FF0000">风信产品才需要填写</font></td>
	  </tr>
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

<div style="padding-left: 100px;"><input
	name="button" type="submit" class="btn" id="button" value=" <?php if($CustomersProjectID>0) { ?>修 改<?php } else { ?>添 加<?php } ?> " />
 <input
	name="button2" type="reset" class="btn" id="button2" value=" 重 置 " /></div>

</form>
</body>
</html>