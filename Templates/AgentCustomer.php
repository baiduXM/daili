<?php include 'AgentHead.php';?>
<body>
<div id="dialog-overlay"></div>
<div id="dialog-box">
 <div class="dialog-content">
  <div id="dialog-message"></div>
  <a href="#" class="button dia-ok">确定</a>
  <a href="#" class="button dia-no">关闭</a>
 </div>
</div>
<div class="wrap">
   <?php include 'AgentTop.php';?>
   <?php include 'Agentleft.php';?>
   <div class="cont-right">
      <div class="mianBox">
         <div class="infobox">
            <div class="userInfo">
               <div class="info-inner">
                  <div class="userInfo-left">
                     <h2>
                        <?php echo $Data['user']['friendly'];?>
                        <a href="<?php echo UrlRewriteSimple('Agent','UserInfo',true);?>"><?php echo $Data['user']['username'];?></a>
                     </h2>
                     <h3>
                        <span class="ulever">
                           归属区域：<?php echo $Data['user']['address'];?>
                           <a href=""></a>
                        </span>
                        <span class="info-line">|</span>
                        <span class="ulever">用户级别：<?php echo $Data['user']['group'];?></span>
                     </h3>
                     <p>座机电话：<?php echo $Data['user']['contacttel'];?></p>
                  </div>
                  <div class="infoRight"> <img src="<?php echo $Data['user']['img'];?>">
                  </div>
               </div>
            </div>
            <div class="moneyInfo">
               <div class="info-inner">
                  <div class="money-left">
                     <p>
                        <?php
                        if ($Data['power'] & CUS_AGENT)
                            echo '客户总量：'.$Data['count'].'个客户';
                        elseif($Data['power'] & CUS_PROCESS)
                            echo '余额： <b>￥'.$Data['user']['balance'].'</b><a href="">充值</a>';
                        ?>
                     </p>
                     <p>
                        <?php if ($Data['power'] & CUS_AGENT)
                           echo '已开通G宝盆的客户：'.$Data['user']['pcnum'].'个客户';
                        elseif($Data['power'] & CUS_PROCESS)
                            echo ' 本月消费： <i>￥'.$Data['user']['consumption'].'</i>';
                        ?>
                     </p>
                     <p>
                     <?php if ($Data['power'] & CUS_AGENT)echo '未开通G宝盆的客户：'.$Data['user']['phonenum'].'个客户';
                     elseif($Data['power'] & CUS_PROCESS)echo ' 本月开通：<i>'.$Data['user']['pcnum'].'</i><span>个PC站和</span><i>'.$Data['user']['phonenum'].'</i><span>个手机站</span>';?>
                     </p>
                  </div>
                  <div class="infoRight">
                     <i class="iconfont">&#xe62b;</i>
                  </div>
               </div>
            </div>
            <div class="otherInfo">
               <div class="info-inner">
                  <div class="money-left">
                     <p></p>
                     <p>登录IP：<?php echo $Data['user']['ip'];?></p>
                     <p>上次登陆：<?php echo $Data['user']['lasttime'];?></p>
                  </div>
                  <div class="infoRight">
                     <i class="iconfont">&#xe62b;</i>
                  </div>
               </div>
            </div>
         </div>
         <div class="listbox">
            <div class="leftbox">
               <div class="leftbox-top">
                  <span>客户列表</span><span class="flower-loader"></span>
                  <a href="<?php echo UrlRewriteSimple('Gbaopen','Customer',true);?>">更多></a>
               </div>
               <div class="tabhead">
                  <span class="tab-first">企业名称</span>
                  <span class="tab-second">开户时间</span>
                  <span class="tab-third">到期时间</span>
                  <span class="tab-four">操作管理</span>
               </div>
               <ul>
               	  
               </ul>
               <div class="pagebox">
                  <div class="paging">
                     <a class="pageprev" href="javascript:;"></a>
                     <a class="num pon" href="javascript:;">1</a>
                     <a class="pagenext" href="javascript:;"></a>
                    <div class="pagemsg"></div>
                  </div>
                  <div class="tonum">
                     <a class="current" href="javascript:;">5</a>
                     <a href="javascript:;">10</a>
                     <a href="javascript:;">20</a>
                  </div>
               </div>
            </div>
            <div class="rightbox fr">
            <?php if($Data['message']){?>
               <div class="callCenter mess">
                  <div class="mess-top">
                     <h2>大区经理：<?php echo $Data['message']['name'];?></h2>
                     <div class="call-img">
                        <img src="<?php echo $Data['message']['image'];?>" alt=""></div>
                     <h3><?php echo $Data['message']['tel'];?></h3>
                  </div>
                  <ul class="over">
                     <li class="first" id="a">
                        <a href="">
                           <i class="iconfont">&#xe669;</i>
                           <p>我的问题</p>
                        </a>
                     </li>
                     <li>
                        <a href="javascript:;">
                           <i class="iconfont">&#xe669;</i>
                           <p>提交问题</p>
                        </a>
                     </li>
                     <!-- <div class="mpbm">我的问题</div>
                  <div class="spbm">提交的问题</div>
                  -->
               </ul>
            </div>
            <?php }?>
            <div class="update">
               <h2> <b>最近消息</b>
                  <a href="">更多></a>
               </h2>
               <ul>
                  <li>
                     <a href=""><?php echo $Data['message']['newmsg'];?></a>
                  </li>
               </ul>
            </div>
         </div>
      </div>
   </div>
</div>
</div>
</body>
<?php include 'AgentFoot.php';?>