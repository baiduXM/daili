<?php
/*
 ExpressPHP Template Compiler 3.0.0 beta
 compiled from CustomersEdit.htm at 2014-11-10 16:25:55 Asia/Shanghai
*/
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><?php $this->Display("header"); ?><style type="text/css">
<!--
@import url("/Templates/a2010/adminapps/images/style.css");
-->
</style>

</head>
<body>
<form action="<?php echo UrlRewriteSimple('Customers','Edit',true); ?>"
	method="post" enctype="multipart/form-data" name="form1" id="form1">
    
<div class="panel">
  <div class="panel-header">
    <div class="panel-header-left"></div>
    <div class="panel-header-content">编辑客户</div>
    <div class="panel-header-right"></div>
  </div>
  <div class="panel-body">
    <div class="panel-body-left">
      <div class="panel-body-right">
        <div class="panel-body-content">
   <table width="100%" border="0" cellspacing="0" cellpadding="5">
	<tr>
		<td width="150" align="right">企业名称：</td>
		<td><input name="CompanyName" type="text" class="input-style"
			id="CompanyName" maxlength="64" value="<?php echo $CustomersInfo[CompanyName];?>"/>&nbsp;&nbsp;<font color="#FF0000">*</font></td>
	</tr>
	<tr>
	  <td align="right">域名：</td>
	  <td><input name="DomainName" type="text" class="input-style"
			id="DomainName" maxlength="64" value="<?php echo $CustomersInfo[DomainName];?>"/></td>
	  </tr>
	<tr>
		<td align="right">企业联系人：</td>
		<td><input name="CustomersName" type="text" class="input-style" id="CustomersName" value="<?php echo $CustomersInfo[CustomersName];?>"/>&nbsp;&nbsp;<font color="#FF0000">*</font></td>
	</tr>
	<tr>
      <td align="right">联系电话：</td>
	  <td><input name="Tel" type="text" class="input-style" id="Tel" value="<?php echo $CustomersInfo[Tel];?>"/>&nbsp;&nbsp;<font color="#FF0000">*</font></td>
	  </tr>
	<tr>
      <td align="right">联系传真：</td>
	  <td><input name="Fax" type="text" class="input-style" id="CustomersName3" value="<?php echo $CustomersInfo[Fax];?>"/></td>
	  </tr>
	<tr>
      <td align="right">联系人电子邮件：</td>
	  <td><input name="Email" type="text" class="input-style" id="CustomersName4" value="<?php echo $CustomersInfo[Email];?>"/></td>
	  </tr>
	<tr>
      <td align="right">企业地址：</td>
	  <td><input name="Address" type="text" class="input-style" id="CustomersName8" value="<?php echo $CustomersInfo[Address];?>"/></td>
	  </tr>
	<tr>
	  <td align="right">代理商：</td>
	  <td><input name="ServiceName" type="text" class="input-style" id="ServiceName" value="admin"/></td>
	  </tr>
	<!--<tr>
	  <td align="right">所属管理组：</td>
	  <td><select name="UserGroupID" id="UserGroupID">
      
<?php $__view__data__0__=$UserGroups;if(is_array($__view__data__0__)) { foreach($__view__data__0__ as $List) { ?>
        <option value="<?php echo $List[UserGroupID];?>" <?php if($List[UserGroupID]==$CustomersInfo[UserGroupID]) { ?>selected="selected"<?php } ?>>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $List[GroupName];?>&nbsp;&nbsp;&nbsp;&nbsp;</option>
      
<?php } } ?>
      </select>
&nbsp;&nbsp;<font color="#FF0000">*</font></td>
	  </tr>-->
	<tr>
      <td align="right">备注：</td>
	  <td><textarea name="Remark" cols="100" rows="5" class="input-style" id="Remark"><?php echo $CustomersInfo[Remark];?></textarea></td>
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
	name="button" type="submit" class="btn" id="button" value=" 修 改 " />
 <input
	name="button2" type="reset" class="btn" id="button2" value=" 重 置 " />
    <input type="hidden" name="CustomersID" id="CustomersID" value="<?php echo $CustomersInfo[CustomersID];?>" />
    </div>

</form>
</body>
</html>
