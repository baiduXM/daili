<?php
/*
 ExpressPHP Template Compiler 3.0.0 beta
 compiled from UsersNewUser.htm at 2010-01-07 01:47:01 Asia/Shanghai
*/
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><?php $this->Display("header"); ?><link href="/templates/adminapps/skin/blue/style.css" rel="stylesheet"
	type="text/css" />
<script type="text/javascript">
$(document).ready(function() {
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
	var data = "Action=CheckEmail&Email="+Email+'&r='+Math.random();
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
<div>
<form action="<?php echo UrlRewriteSimple('Users','NewUser',true); ?>"
	method="post" enctype="multipart/form-data" name="form1" id="form1">
<div class="UserBodyTitle">添加用户</div>

<div class="line-border-f0f0f0">
<div class="block"></div>
<div class="font-12px">
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
		<td align="right">用户组:</td>
		<td><select name="UserGroupID" id="UserGroupID">
<?php $__view__data__0__0__=$UserGroups;  if(is_array($__view__data__0__0__)) { foreach($__view__data__0__0__ as $key => $title) { ?>
<option value="<?php echo $key;?>" <?php if($Profile[UserGroupID]==$key) { ?>				selected="selected"<?php } ?> ><?php echo $title;?></option>
<?php } }  ?>
</select></td>
		<td>&nbsp;</td>
	</tr>
</table>
</div>

</div>
<div style="padding: 10px; text-align: center;"><input
	name="button" type="submit" class="btn" id="button" value="注册" /> <input
	name="button2" type="reset" class="btn" id="button2" value="重置" /></div>
</form>
</div>
<div class="clear"></div>
</body>
</html>
