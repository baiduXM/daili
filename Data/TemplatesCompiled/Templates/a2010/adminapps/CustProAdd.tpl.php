<?php
/*
 ExpressPHP Template Compiler 3.0.0 beta
 compiled from CustProAdd.htm at 2014-04-01 11:18:26 Asia/Shanghai
*/
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
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
<div class="panel">
  <div class="panel-header">
    <div class="panel-header-left"></div>
    <div class="panel-header-content">客户信息</div>
    <div class="panel-header-right"></div>
  </div>
  <div class="panel-body">
    <div class="panel-body-left">
      <div class="panel-body-right">
        <div class="panel-body-content">
   <table width="100%" border="0" cellspacing="0" cellpadding="5">
	<tr>
		<td width="150" align="right">企业名称：</td>
		<td width="242"><?php echo $CustomersInfo[CompanyName];?><font color="#FF0000">&nbsp;</font></td>
	    <td align="right">域名：</td>
	    <td><?php echo $CustomersInfo[DomainName];?></td>
	</tr>
	<tr>
		<td align="right">企业联系人：</td>
		<td><?php echo $CustomersInfo[CustomersName];?></td>
	    <td align="right">联系电话：</td>
	    <td><?php echo $CustomersInfo[Tel];?><font color="#FF0000">&nbsp;</font></td>
	</tr>
	<tr>
      <td align="right">联系传真：</td>
	  <td><?php echo $CustomersInfo[Fax];?></td>
	  <td align="right">联系人电子邮件：</td>
	  <td><?php echo $CustomersInfo[Email];?></td>
	</tr>
	<tr>
      <td align="right">企业地址：</td>
	  <td><?php echo $CustomersInfo[Address];?></td>
	  <td align="right">客户所属地区：</td>
	  <td><?php echo $CustomersInfo[Area];?></td>
	</tr>
	<tr>
      <td align="right">负责客服：</td>
	  <td><?php echo $CustomersInfo[ServiceName];?></td>
	  <td align="right">所属管理组：</td>
	  <td>
          
<?php $__view__data__0__=$UserGroups;if(is_array($__view__data__0__)) { foreach($__view__data__0__ as $List) { ?>
          <?php if($List[UserGroupID]==$CustomersInfo[UserGroupID]) { echo $List[GroupName];?><?php } ?>          
<?php } } ?>
  </td>
	</tr>
	<tr>
      <td align="right">备注：</td>
	  <td colspan="3"><?php echo $CustomersInfo[Remark];?></td>
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

<form action="<?php echo UrlRewriteSimple('CustPro','Add',true); ?>"
	method="post" enctype="multipart/form-data" name="form1" id="form1">
    
<div class="panel">
  <div class="panel-header">
    <div class="panel-header-left"></div>
    <div class="panel-header-content">开通产品</div>
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
        
<?php $__view__data__0__=$ProjectLists;if(is_array($__view__data__0__)) { foreach($__view__data__0__ as $List) { ?>
        <option value="<?php echo $List[ProjectID];?>" >&nbsp;&nbsp;<?php echo $List[ProjectName];?>&nbsp;&nbsp;</option>
        
<?php } } ?>
      </select></td>
	  </tr>
	<tr>
      <td align="right">产品属性：</td>
	  <td><span id='PropertyPropertyID'>
      选择产品后显示
      </span></td>
	  </tr>
	<tr>
      <td align="right">产品开通时间：</td>
	  <td><input name="StartTime" type="text" class="input-style" id="StartTime" onclick="return Calendar('StartTime');"/></td>
	  </tr>
	<tr>
      <td align="right">产品到期时间：</td>
	  <td><input name="EndTime" type="text" class="input-style" id="EndTime" onclick="return Calendar('EndTime');"/></td>
	  </tr>
	<tr>
      <td align="right">备注：</td>
	  <td><textarea name="Remark" cols="100" rows="5" class="input-style" id="Remark"></textarea>
	    <input type="hidden" name="CustomersID" id="CustomersID" value="<?php echo $CustomersInfo[CustomersID];?>" /></td>
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
	name="button" type="submit" class="btn" id="button" value=" 添 加 " />
 <input
	name="button2" type="reset" class="btn" id="button2" value=" 重 置 " /></div>

</form>
</body>
</html>
