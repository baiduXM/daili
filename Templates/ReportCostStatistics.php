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
                                    <font style="position: absolute;top: 40px;left: 21px;color: burlywood;">按天计算下，期间间隔不超过20天</font>
                                    <input class="Input" id="txtBeginDate" placeholder="输入开始时间"/>
                                    <div id="beginDD"></div>
                                    <i>-</i>
                                    <input class="Input" id="txtEndDate" placeholder="输入截止时间"/>
                                    <div id="endDD"></div>
                                    <select name="mathType" id="mathType" class="formstyle">
                                        <option value="day">按天计算</option>
                                        <option value="week">按周计算</option>
                                        <option value="month">按月计算</option>
                                        <option value="year">按年计算</option>
                                    </select>
                                    <button type="submit" id="product" class="searchbottom">生成</button>
                                    <span class="flower-loader" style="opacity: 0;"></span>
                            </div>
                        </div>
                        <!-- 图表展示 -->
                        <div id="main" style="height:500px"></div>
                    </div>
                </div>
                <script src="Javascripts/calendar.js"></script>
                <script src="Javascripts/echarts.js"></script>
            </div>
        </div>
    </div>
</body>
<?php include 'AgentFoot.php'; ?>