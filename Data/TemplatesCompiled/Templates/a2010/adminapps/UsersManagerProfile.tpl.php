<?php
/*
 ExpressPHP Template Compiler 3.0.0 beta
 compiled from UsersManagerProfile.htm at 2010-01-07 01:47:01 Asia/Shanghai
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
<div>

<div class="panel">
  <div class="panel-header">
    <div class="panel-header-left"></div>
    <div class="panel-header-content">账户信息</div>
    <div class="panel-header-right"></div>
  </div>
  <div class="panel-body">
    <div class="panel-body-left">
      <div class="panel-body-right">
        <div class="panel-body-content">
          <table width="100%" border="0" cellspacing="0" cellpadding="5">
	<tr>
		<td align="right">用户名:</td>
		<td><?php echo self::__htmlspecialchars($Profile[UserName]); ?></td>
	</tr>
	<tr>
		<td align="right">邮件地址:</td>
		<td><?php echo self::__htmlspecialchars($Profile[Email]); ?></td>
	</tr>
	<tr>
		<td width="150" align="right">昵称:</td>
		<td><?php echo self::__htmlspecialchars($Profile[NickName]); ?></td>
	</tr>
	<tr>
		<td align="right">个性签名:</td>
		<td><?php echo self::__htmlspecialchars($Profile[Sign]); ?></td>
	</tr>
	<tr>
		<td align="right">性别:</td>
		<td><?php if($Profile[Gender]==1) { ?>男<?php } elseif($Profile[Gender]==2) { ?>女<?php } else { ?>未知<?php } ?></td>
	</tr>
	<tr>
		<td align="right">联系地址:</td>
		<td><?php echo GetAreaTitle($Profile[StateID]); ?> <?php echo GetAreaTitle($Profile[CityID]); ?> <?php echo GetAreaTitle($Profile[TownID]); echo self::__htmlspecialchars($Profile[Address]); ?></td>
	</tr>
	<tr>
		<td align="right">邮政编码:</td>
		<td><?php echo self::__htmlspecialchars($Profile[Postcode]); ?></td>
	</tr>
	<tr>
		<td align="right">联系人:</td>
		<td><?php echo self::__htmlspecialchars($Profile[RealName]); ?></td>
	</tr>
	<tr>
		<td align="right">手机号码:</td>
		<td><?php echo self::__htmlspecialchars($Profile[MobileTelephone]); ?></td>
	</tr>
	<tr>
		<td align="right">联系电话:</td>
		<td><?php echo self::__htmlspecialchars($Profile[Telephone]); ?></td>
	</tr>
	<tr>
		<td align="right">传真:</td>
		<td><?php echo self::__htmlspecialchars($Profile[Fax]); ?></td>
	</tr>
	<tr>
		<td align="right">QQ:</td>
		<td><?php echo self::__htmlspecialchars($Profile[IM][QQ]); ?></td>
	</tr>
	<tr>
		<td align="right">用户组:</td>
		<td><?php echo $UserGroups[$Profile[UserGroupID]];?></td>
	</tr>
	<tr>
		<td align="right">注册时间:</td>
		<td><?php echo self::__htmlspecialchars($Profile[RegDateTime]); ?></td>
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

<form id="form1" name="form1" method="post"
	action="<?php echo UrlRewriteSimple('Users','UserSetting',true); ?>">
<div class="panel">
  <div class="panel-header">
    <div class="panel-header-left"></div>
    <div class="panel-header-content">修改所属用户组</div>
    <div class="panel-header-right"></div>
  </div>
  <div class="panel-body">
    <div class="panel-body-left">
      <div class="panel-body-right">
        <div class="panel-body-content">
          <table width="100%" border="0" cellspacing="0" cellpadding="5">
	<tr>
		<td align="right">用户组:</td>
		<td><select name="UserGroupID" id="UserGroupID">
<?php $__view__data__0__0__=$UserGroups;  if(is_array($__view__data__0__0__)) { foreach($__view__data__0__0__ as $key => $title) { ?>
<option value="<?php echo $key;?>" <?php if($Profile[UserGroupID]==$key) { ?>				selected="selected"<?php } ?> ><?php echo $title;?></option>
<?php } }  ?>
</select></td>
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
<div style="padding-left: 100px; height: 50px;">
<input name="button" type="submit" class="btn" id="button" value=" 修 改 " />
<input name="button2" type="reset" class="btn" id="button2"
	value=" 重 置 " /> <input type="hidden" name="UserID" id="UserID"
	value="<?php echo $Profile[UserID];?>" /> <input type="hidden" name="Action"
	id="Action" value="ModifyGroup" /></div>

</form>

</body>
</html>
