<!doctype html>
<head>
<meta charset="UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<link href='../Css/font.css' rel='stylesheet' type='text/css'>
<title>易尔通--代理平台后台登入界面</title>
<script src="../Javascripts/jquery1.9.1.min.js"></script> 
<link rel="stylesheet" type="text/css" href="../Css/demo.css" />
<link rel="stylesheet" type="text/css" href="../Css/style.css" />
</head>
<body>
<div class="cb-slideshow">
  <ul>
    <?PHP foreach($ImageData as $k=>$v){ ?>
      <li><span style="background-image: url(<?PHP echo $v['Url'];?>)"><?PHP echo $k;?></span>
      <div>
       <p><?PHP echo $v['Content'];?></p>
       <h3>————<?PHP echo $v['Name'];?></h3>
      </div>
    </li>
    <?PHP } ?>
  </ul>
</div>
<div id="login">
  <form action="<?php echo UrlRewriteSimple('Home', 'Login');?>" method="post">
    <h1>易尔通代理平台登入</h1>
    <ul>
      <li class="use_pas">
        <span class="u_log"></span>
        <input type="text" name="UserName" placeholder="Username">
      </li>
      <li class="use_pas">
        <span class="p_log"></span>
        <input type="password" name="PassWord" placeholder="Password">
      </li>
      <li class="submit">
        <input type="submit" value="Sign In">
      </li>
    </ul>
  </form>
</div>
</body>
</html>