<?php
/*
 ExpressPHP Template Compiler 3.0.0 beta
 compiled from __Message.htm at 2010-01-07 01:47:01 Asia/Shanghai
*/
?><html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><?php $this->Display("header"); if($RedirectURL) { ?><meta http-equiv="refresh" content="5;URL=<?php echo $URL;?>" /><?php } ?><link href="/templates/adminapps/skin/blue/style.css" rel="stylesheet"
	type="text/css" />
<style type="text/css">
<!--
.message-header {
	font-family: Arial, Helvetica, sans-serif;
	line-height: 30px;
	font-weight: bold;
	color: #FFF;
	text-decoration: none;
	text-align: left;
	background-image:
		url(/templates/adminapps/skin/blue/images/message-header-bg.gif);
	background-repeat: no-repeat;
	height: 31px;
	width: 480px;
	margin: 0px;
	padding: 0px;
}

.message-content {
	background-image:
		url(/templates/adminapps/skin/blue/images/message-content-bg.gif);
	margin: 0px;
	padding: 0px;
	height: 110px;
	width: 480px;
}

.message-footer {
	background-image:
		url(/templates/adminapps/skin/blue/images/message-footer-bg.gif);
	height: 34px;
	width: 480px;
}

.message-box {
	width: 480px;
	height: 175px;
	margin: 30px auto;
}

body {
	margin: 0 auto;
}

.message-btn {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #000;
	text-decoration: none;
	background-image:
		url(/templates/adminapps/skin/blue/images/message-btn-bg.gif);
	background-repeat: no-repeat;
	height: 22px;
	width: 80px;
	padding-top: 2px;
	padding-bottom: 2px;
	border: none 0px;
	cursor: pointer;
}
-->
</style><?php if($ExtFrame) { ?> <?php $this->Display("extframe-js"); ?> <?php } ?></head>
<body <?php if($ExtFrame) { ?>class="ExtFrame"<?php } ?>>
<table width="100%" height="100%" border="0" cellspacing="0"
	cellpadding="0">
	<tr>
		<td align="center" valign="middle">
		<div class="message-box">
		<div class="message-header"><span
			style="padding-left: 10px; text-align: left;">信息提示</span></div>
		<div class="message-content">
		<div style="padding: 15px; font-size: 12px; text-align: left;"><?php echo $Message;?></div>
		</div>
		<div class="message-footer">
		<div style="text-align: right; padding: 6px 15px 0 0;"><input
			name="button" type="submit" class="message-btn" id="button"
			value="<?php if($URL!=='HISTORY') { echo $Title;?><?php } else { ?>返回<?php } ?>"
			onclick="<?php if($ExtFrame&&$URL!=='HISTORY') { ?>ExtFrameClose(); <?php } elseif($URL=='HISTORY') { ?>history.back();<?php } else { ?>location.href='<?php echo $URL;?>'<?php } if($MainFrameReload) { ?> MainFrameReload(); <?php } ?>" />
		</div>
		</div>
		</div>
		</td>
	</tr>
</table>
</body>
</html>
