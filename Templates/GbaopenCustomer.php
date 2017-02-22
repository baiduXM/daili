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
      <div class="mainBox">
                <div id="tab" class="nytab">
                    <div class="tabList">
                        <ul>
                            <li class="cur">全部客户</li>
                            <li class="">已开通代理</li>
                            <li class="">未开通代理</li>
                            <li class="">已过期</li>
                            <li class="">30天内过期</li>
                            <?php if($_SESSION["Level"]==1){?>
                            <li class="">回收站</li>
                            <?php }?>
                        </ul>
                    </div>
                    <div class="tabCon">
                        <div class="cur">
                            <div class="shbox">
                                <div class="search">
                                    <div class="leftS"> <font>客户信息查找:</font>
                                        <span>
                                            <input type="text" class="Input" placeholder="公司名称或联系人" id="search1"> <i class="iconfont"></i>
                                        </span> <font>用户名</font>
                                        <span>
                                            <input type="text" class="Input" placeholder="用户名" id="search2"> <i class="iconfont"></i>
                                        </span>
                                        <span>
                                            <input type="text" class="Input" placeholder="域名" id="search3">
                                        </span>
                                        <span>       
                                            <button type="submit" id="searchbox" class="searchbottom">查找</button>
                                        </span>
                                        <span class="flower-loader"></span>
                                    </div>
                                </div>
                                <form action="" id="listform">
                                    <table border="0" cellspacing="0" cellpadding="0" width="100%" class="showbox">
                                        <tbody>
                                            <tr>
                                            <!--<th width="5%"><input type="checkbox"></th>-->
                                                <th class="text-left">公司名称</th>
                                                <th>用户名</th>
                                                <th>开启时间</th>
                                                <th>到期时间</th>
                                                <th>网站服务</th>
                                                <th>网站状态</th>
                                                <th>推荐案例</th>
                                                <th>客服人员</th>
                                                <th class="text-right" width="25%">操作/管理</th>
                                            </tr>
                                        </tbody>
                                        <tbody id="listtbody">
                                            
                                        </tbody>
                                    </table>
                                </form>
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
                                        <a href="javascript:;">15</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
</div>
</div>
<script src="Javascripts/ajaxfileupload.js"></script>
</body>
<?php include 'AgentFoot.php';?>