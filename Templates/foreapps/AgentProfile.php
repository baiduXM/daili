<?php include 'AgentHead.php';?>
<body>
<div class="wrap">
  <?php include 'AgentTop.php';?>
  <div class="main">
    <?php include 'AgentLeft.php';?>
    <div class="content-right fr"> 
    <div class="content-box">
    <div class="content-main profile">
<form action="<?php echo UrlRewriteSimple($MyModule,$MyAction,true)?>" method="post">
            <table width="100%" border="0" cellspacing="0" cellpadding="5">
              <tr height="50">
                <td width="150" align="right">用户名：</td>
                <td><input type="text" disabled="disabled" class="input" id="UserName" value="<?php echo $Data['UserName']?>"/><font color="green"> √</font></td>
              </tr>
             <tr height="50">
                <td align="right">密码：</td>
                <td><input name="PassWord" type="text" class="input" id="PassWord" placeholder="不少于6个字符，不修改放空" /><font color="green"> √</font></td>
              </tr>
             <tr height="50">
                <td width="150" align="right">企业名称：</td>
                <td><input name="EnterpriseName" type="text" class="input" id="EnterpriseName" value="<?php echo $Data['EnterpriseName']?>"/><font color="green"> √</font></td>
              </tr>
              <tr height="50">
                <td align="right">联系人：</td>
                <td><input name="ContactName" type="text" class="input" id="ContactName" value="<?php echo $Data['ContactName']?>" /><font color="green"> √</font></td>
              </tr>
              <tr height="50">
                <td align="right">联系电话：</td>
                <td><input name="ContactTel" type="text" class="input" id="ContactTel" value="<?php echo $Data['ContactTel']?>" /><font color="green"> √</font></td>
              </tr>
              <tr height="50">
                <td align="right">电子邮件：</td>
                <td><input name="ContactEmail" type="text" class="input" id="ContactEmail" value="<?php echo $Data['ContactEmail']?>" /><font color="green"> √</font></td>
              </tr>
              <tr height="50">
                <td align="right">地址：</td>
                <td><input name="ContactAddress" type="text" class="input" id="ContactAddress" value="<?php echo $Data['ContactAddress']?>" /><font color="green"> √</font></td>
              </tr>
            </table>
  <div style="padding:50px 0 0 150px;">
    <input name="button" type="submit" class="btn check" id="button" value=" 修 改 " />
  </div>
</form>
</div>
      </div>
    </div>
  </div>
  <script src="./Javascripts/profile.js" type="text/javascript"></script>
   <?php include 'AgentFoot.php';?>