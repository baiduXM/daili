<?php
/*
 ExpressPHP Template Compiler 3.0.0 beta
 compiled from UsersRegister.htm at 2010-01-07 01:47:01 Asia/Shanghai
*/
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><?php $this->Display("header"); ?><link href="/templates/adminapps/skin/blue/style.css" rel="stylesheet"
	type="text/css" />
<script type="text/javascript" src="/javascripts/areas.func.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	GetLocation(0,'StateID');
	$('#UserName').focus(); 
	$('#UserName').blur(function(){
		CheckUserName(this.value);
	});
	$('#Email').blur(function(){
		CheckEmail(this.value);
	});
});
function QuestionSelect(v,obj){
	if(v=='1'){
		obj.form.Question.value='';
		$('.QuestionInput').show();
	}
	else if(v=='0'){
		$('.QuestionInput').hide();
		obj.form.Question.value='';
	}
	else{
		$('.QuestionInput').hide();
		obj.form.Question.value=v;
	}
}
function CheckUserName(UserName){
	
	var data = "Action=CheckUserName&UserName="+encodeURI(UserName)+'&r='+Math.random();
	if (!UserName) return false;
	$.ajax({
		type: "GET",
		url: "/GetParameter.php",
		data: data,
		dataType: "json",
		success: CheckUserNameResponse
	});	
}
function CheckUserNameResponse(result){
	var data = result;
	if(data['Code']=='error'){
		$('.UserNameMessage').css('color','#f00');
		$('.UserNameMessage').html(data['Message']);
	}
	else{
		$('.UserNameMessage').css('color','#006600');
		$('.UserNameMessage').html(data['Message']);
	}
}
function CheckEmail(Email){
	var data = "Action=CheckEmail&Email="+encodeURI(Email)+'&r='+Math.random();
	$.ajax({
		type: "GET",
		url: "/GetParameter.php",
		data: data,
		dataType: "json",
		success: CheckEmailResponse
	});	
}
function CheckEmailResponse(result){
	var data = result;
	if(data['Code']=='error'){
		$('.EmailMessage').css('color','#f00');
		$('.EmailMessage').html(data['Message']);
	}
	else{
		$('.EmailMessage').css('color','#006600');
		$('.EmailMessage').html(data['Message']);
	}
}
</script>
</head>

<body>
<div class="clear"></div>
<div class="ScreenBodyWidth">
<div class="left" style="width: 725px; margin-right: 5px;">
<h2>账户注册</h2>
<div style="padding: 10px;">
<form id="form1" name="form1" method="post" action="" class="font-12px">
<table width="100%" border="0" cellspacing="0" cellpadding="5">
	<tr>
		<td width="20%" align="right">登陆名:</td>
		<td width="50%"><input name="UserName" type="text"
			class="input-style" id="UserName" maxlength="20" /></td>
		<td>
		<div class="UserNameMessage">&nbsp;</div>
		</td>
	</tr>
	<tr>
		<td align="right">&nbsp;</td>
		<td>4~20个字符组成.</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td align="right">密码:</td>
		<td><input name="Password" type="password" class="input-style"
			id="Password" /></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td align="right">&nbsp;</td>
		<td>6-20个字符组成, 不接受纯数字的密码</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td align="right">确认密码:</td>
		<td><input name="CfmPassword" type="password" class="input-style"
			id="CfmPassword" /></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td align="right">邮件地址:</td>
		<td><input name="Email" type="text" class="input-style"
			id="Email" /></td>
		<td>
		<div class="EmailMessage">&nbsp;</div>
		</td>
	</tr>
	<tr>
		<td align="right" valign="top">安全问题:</td>
		<td><select name="QuestionList" id="QuestionList"
			onchange="QuestionSelect(this.value, this)">
			<option value="0">请选择问题</option>
<?php $__view__data__0__=$Parameters[QuestionList];if(is_array($__view__data__0__)) { foreach($__view__data__0__ as $q) { ?>
			<option value="<?php echo $q;?>"><?php echo $q;?></option>
			
<?php } } ?>
<option value="1">自定义问题...</option>
		</select>
		<div class="QuestionInput" style="display: none;"><input
			name="Question" type="text" class="input-style" value="" /></div>
		</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td align="right">答案:</td>
		<td><input name="Answer" type="text" class="input-style"
			id="Answer" /></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td align="right"><b>以下是个人信息</b></td>
		<td>(可选项)</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td align="right">昵称:</td>
		<td><input name="NickName" type="text" class="input-style"
			id="NickName" /></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td align="right">个性签名:</td>
		<td><input name="Sign" type="text" class="input-style" id="Sign" /></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td align="right">性别:</td>
		<td><input name="Gender" type="radio" id="radio" value="1" /> 男
		<input type="radio" name="Gender" id="radio2" value="2" /> 女</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td align="right">所在地:</td>
		<td>
		<div style="float: left;"><select name="StateID" id="StateID"
			onchange="GetLocation(this.value,'CityID');">
		</select></div>
		<div style="float: left;"><select name="CityID" id="CityID"
			onchange="GetLocation(this.value,'TownID');"
			style="display: none; float: left;">
		</select></div>
		<div style="float: left;"><select name="TownID" id="TownID"
			style="display: none; float: left;">
		</select></div>
		</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td align="right">联系地址:</td>
		<td><input name="Address" type="text" class="input-style"
			id="Address" maxlength="64" /></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td align="right">邮政编码:</td>
		<td><input name="Postcode" type="text" class="input-style"
			id="Postcode" maxlength="10" /></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td align="right">联系人:</td>
		<td><input name="RealName" type="text" class="input-style"
			id="RealName" maxlength="64" /></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td align="right">手机号码:</td>
		<td><input name="MobileTelephone" type="text" class="input-style"
			id="MobileTelephone" /></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td align="right">联系电话:</td>
		<td><input name="Telephone" type="text" class="input-style"
			id="Telephone" /></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td align="right">传真:</td>
		<td><input name="Fax" type="text" class="input-style" id="Fax" /></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td align="right">QQ:</td>
		<td><input name="IM[QQ]" type="text" class="input-style"
			id="IM[QQ]" /></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input name="button" type="submit"
			class="btn" id="button" value="注册" /> <input name="button2"
			type="reset" class="btn" id="button2" value="重置" /></td>
		<td>&nbsp;</td>
	</tr>
</table>
</form>
</div>
</div>
</div>
<div class="clear"></div><?php $this->Display("footer"); ?></body>
</html>
