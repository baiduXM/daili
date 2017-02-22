<?php
/*
 ExpressPHP Template Compiler 3.0.0 beta
 compiled from UsersProfile.htm at 2010-01-07 01:47:01 Asia/Shanghai
*/
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><?php $this->Display("header"); ?><style type="text/css">
<!--
@import url("/Templates/a2010/adminapps/images/style.css");
-->
</style>
<script type="text/javascript" src="/javascripts/areas.func.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	GetLocation(0,'StateID','<?php echo $Profile[StateID];?>');<?php if($Profile[CityID]) { ?>	GetLocation('<?php echo $Profile[StateID];?>','CityID','<?php echo $Profile[CityID];?>');
	GetLocation('<?php echo $Profile[CityID];?>','TownID','<?php echo $Profile[TownID];?>');
	<?php } ?>});
</script>
</head>

<body>
<form action="<?php echo UrlRewriteSimple('Users','Profile',true); ?>"
	method="post" enctype="multipart/form-data" name="form1" id="form1">
    
<div class="panel">
  <div class="panel-header">
    <div class="panel-header-left"></div>
    <div class="panel-header-content">修改账户资料</div>
    <div class="panel-header-right"></div>
  </div>
  <div class="panel-body">
    <div class="panel-body-left">
      <div class="panel-body-right">
        <div class="panel-body-content">
   <table width="100%" border="0" cellspacing="0" cellpadding="5">
	<tr>
		<td align="right">当前密码:</td>
		<td><input name="Password" type="password"
			class="input-notsize-style" id="Password" /></td>
	</tr>
	<tr>
		<td width="150" align="right">昵称:</td>
		<td><input name="NickName" type="text" class="input-style"
			id="NickName" value="<?php echo self::__htmlspecialchars($Profile[NickName]); ?>" /></td>
	</tr>
	<tr>
		<td align="right">个性签名:</td>
		<td><input name="Sign" type="text" class="input-style" id="Sign"
			value="<?php echo self::__htmlspecialchars($Profile[Sign]); ?>" /></td>
	</tr>
	<tr>
		<td align="right">性别:</td>
		<td><input name="Gender" type="radio" id="radio" value="1"<?php if($Profile[Gender]==1) { ?> checked="checked" <?php } ?> /> 男 <input
			type="radio" name="Gender" id="radio2" value="2"<?php if($Profile[Gender]==2) { ?> checked="checked" <?php } ?> /> 女</td>
	</tr>
	<tr>
		<td align="right">所在地:</td>
		<td>
		<div style="float: left; zoom: 1; width: 150px;"><select
			name="StateID" id="StateID"
			onchange="GetLocation(this.value,'CityID');">
		</select></div>
		<div style="float: left; zoom: 1; width: 150px;"><select
			name="CityID" id="CityID"
			onchange="GetLocation(this.value,'TownID');"
			style="display: none; float: left;">
		</select></div>
		<div style="float: left; zoom: 1; width: 150px;"><select
			name="TownID" id="TownID" style="display: none; float: left;">
		</select></div>
		</td>
	</tr>
	<tr>
		<td align="right">联系地址:</td>
		<td><input name="Address" type="text" class="input-style"
			id="Address" maxlength="64" value="<?php echo self::__htmlspecialchars($Profile[Address]); ?>" /></td>
	</tr>
	<tr>
		<td align="right">邮政编码:</td>
		<td><input name="Postcode" type="text" class="input-style"
			id="Postcode" maxlength="10" value="<?php echo self::__htmlspecialchars($Profile[Postcode]); ?>" /></td>
	</tr>
	<tr>
		<td align="right">联系人:</td>
		<td><input name="RealName" type="text" class="input-style"
			id="RealName" maxlength="64" value="<?php echo self::__htmlspecialchars($Profile[RealName]); ?>" /></td>
	</tr>
	<tr>
		<td align="right">手机号码:</td>
		<td><input name="MobileTelephone" type="text" class="input-style"
			id="MobileTelephone" value="<?php echo self::__htmlspecialchars($Profile[MobileTelephone]); ?>" /></td>
	</tr>
	<tr>
		<td align="right">联系电话:</td>
		<td><input name="Telephone" type="text" class="input-style"
			id="Telephone" value="<?php echo self::__htmlspecialchars($Profile[Telephone]); ?>" /></td>
	</tr>
	<tr>
		<td align="right">传真:</td>
		<td><input name="Fax" type="text" class="input-style" id="Fax"
			value="<?php echo self::__htmlspecialchars($Profile[Fax]); ?>" /></td>
	</tr>
	<tr>
		<td align="right">QQ:</td>
		<td><input name="IM[QQ]" type="text" class="input-style"
			id="IM[QQ]" value="<?php echo self::__htmlspecialchars($Profile[IM][QQ]); ?>" /></td>
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
	name="button" type="submit" class="btn" id="button" value=" 修 改 " /> <input
	name="button2" type="reset" class="btn" id="button2" value=" 重 置 " /></div>

</form>
</div>
</body>
</html>
