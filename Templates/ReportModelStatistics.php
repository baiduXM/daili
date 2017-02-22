<?php include 'AgentHead.php';
?>
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
        <?php include 'AgentTop.php'; ?>
        <?php include 'Agentleft.php'; ?>

        <div class="cont-right">
            <div class="crelist">
                <div class="mainBox">
                    <div class="shbox">
                        <!-- 时间搜索 -->
                        <div class="search">
                            <div class="leftS"> 
                                <font>请输入生成报表的时间段：</font>
                                <input class="Input" id="txtBeginDate" placeholder="输入开始时间"/>
                                <div id="beginDD"></div>
                                <i>-</i>
                                <input class="Input" id="txtEndDate" placeholder="输入截止时间"/>
                                <div id="endDD"></div>
                                <button type="submit" id="product" class="searchbottom">生成</button>
                                <span class="flower-loader" style="opacity: 0;"></span>
                            </div>
                        </div>
                        <!-- 图表展示 -->
                        <div id="main" style="height:500px"></div>
                    </div>

<!--                    <ul class="tempDate">
                        <li>模板总量:<span>250</span></li>
                        <li>手机模板:<span>8250</span></li>
                        <li>PC模板:<span>2150</span></li>
                        <li>双站模板:<span>1250</span></li>
                    </ul>-->
                </div>
                <script src="Javascripts/calendar.js"></script>
                <script src="Javascripts/echarts.js"></script>
            </div>
        </div>
    </div>
</body>
<?php include 'AgentFoot.php'; ?>