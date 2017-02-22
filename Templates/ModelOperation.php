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
      <div class="mainBox" style="max-height: 90%;overflow: auto;">
                <div id="tab" class="nytab">
                    <div class="tabList">
                        <ul>
                            <li>PC模板</li>
                            <li>手机模板</li>
                            <li>双站模板</li>
                        </ul>
                    </div>
                    <div class="tabCon">
                        <div class="cur">
                            <div class="shbox">
                                <div class="labelBox">
                                    搜索内容：
                                    <a href="javasrcipt:;" data="name"></a>
                                    <a href="javasrcipt:;" data="url"></a>
                                    <a href="javasrcipt:;" data="priceL"></a>
                                    <a href="javasrcipt:;" data="priceT"></a>
                                </div>
                                <div class="search">
                                    <div class="leftS">
                                        <font>模板名:</font>
                                        <span>
                                            <input type="text" class="Input" id="search1"> <i class="iconfont"></i>
                                        </span>
                                        <font>网址:</font>
                                        <span>
                                            <input type="text" class="Input" id="search2"> <i class="iconfont"></i>
                                        <font>价格区间</font>
                                        </span>
                                        <span>
                                            <input type="text" class="Input" placeholder="最低价格" id="search3"> -
                                        </span>
                                        <span>
                                            <input type="text" class="Input" placeholder="最高价格" id="search4">
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
                                                <th class="text-left">模板名称</th>
                                                <th>模板网址</th>
                                                <th>优惠价</th>
                                                <th class="devname">开发人员</th>
                                                <th>推荐</th>
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