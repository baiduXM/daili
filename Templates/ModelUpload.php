<?php include 'AgentHead.php'; 
?>
<body>
    <style>
        .record{
            width:400px;
            height:200px;
            margin:auto;
            border: 2px solid #1B9DD9;
            overflow: hidden;
            -webkit-box-shadow: 10px 10px 25px #9CC;
            -moz-box-shadow: 10px 10px 25px #9CC;
            box-shadow: 10px 10px 25px #9CC;
            -moz-border-radius:0 0 7px 7px;
            -webkit-border-radius:7px 7px 7px 7px;
            border-radius:7px 7px 7px 7px;
        }
        .con{
            margin-left: 20px;
            margin-top: 10px;
            color:red;
            font-size: 17px;
            line-height: 20px;
        }
    </style>
    <script src="Javascripts/webuploader.js"></script>
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
                <div id="uploader" class="upload-view">
                    <div id="dropbox">将压缩包拖拽到此区域</div>
                    <!--用来存放文件信息-->
                    <div id="thelist" class="uploader-list"></div>
                    <div class="btns" style="text-align:center">
                        <div id="picker">选择文件</div>
                        <button id="ctlBtn" class="btn btn-default">开始上传</button>
                    </div>
                </div>
                <div id="config-list">
                    <span></span><span></span><span></span><span></span>
                    <div class="zip none">
                        <div class="title">
                            <span>压缩包文件配置</span>
                        </div>
                        <div class="userdata-content">
                            <p>
                                <span>市场价</span>
                                <span><input type="text" name="mPrice" class="Input" value=""></span>
                            </p>
                            <p>
                                <span>优惠价</span>
                                <span><input type="text" name="yPrice" class="Input" value=""></span>
                            </p>
                            <p>
                                <span>URL：</span>
                                <span><input type="text" name="url" class="Input" value="" placeholder="填写 > config > 模板编号.n01.5067.org"></span>
                            </p>
                            <p>
                                <span>推荐</span>
                                <span>
                                    <select name="tuijian" style="width:120px">
                                            <option value="0" selected>不启用</option>
                                            <option value="1">启用</option>
                                            <option value="2">推荐到首页</option>
                                    </select>
                                </span>
                                <span>百度星评</span>
                                <span><input type="number" name="star" class="Input" min="0" max="5" step="0.5" value="3" style="width:80px"></span>
                            </p>
                            <p id="typetag">
                                <span style="vertical-align: top;">网站标签(必填)</span>
                                <span class="tag">
                                    <span data="1">IT科技、软件、通讯业</span>
                                    <span data="9">婚庆、广告、服务、展览</span>
                                    <span data="25">消防、货架、钢器材</span>
                                    <span data="2">办公、文教、乐器</span>
                                    <span data="3">餐饮、旅游、酒店</span>
                                    <span data="4">电子、电工、电器</span>
                                    <span data="5">房地产、房屋租赁</span>
                                    <span data="6">服装、鞋帽、皮具</span>
                                    <span data="7">化工、化学、涂料</span>
                                    <span data="10">机械、工业制品</span>
                                    <span data="11">家居、日用、家具</span>
                                    <span data="12">建筑、建材、装饰</span>
                                    <span data="13">贸易、物流、出口</span>
                                    <span data="14">美容、美发、护肤</span>
                                    <span data="15">汽车、运输、汽配</span>
                                    <span data="16">摄影、冲印、玩具</span>
                                    <span data="17">食品、饮料加工</span>
                                    <span data="18">五金、仪器、仪表</span>
                                    <span data="19">学校、教育培训</span>
                                    <span data="20">照明、水电、能源</span>
                                    <span data="21">珠宝、首饰、饰品</span>
                                    <span data="22">咨询、顾问、翻译</span>
                                    <span data="27">家电、音响、电器</span>
                                    <span data="28">印刷、包装、丝印</span>
                                    <span style="width:90px;" data="8">环保、生态</span>
                                    <span style="width:72px;" data="23">家政服务</span>
                                    <span style="width:36px;" data="24">其他</span>
                                    <span style="width:90px;" data="26">药品、保健</span>
                                </span>
                            </p>
                            <p id="colortag">
                            </p>
                        </div>
                    </div>
                    <div class="csv none">
                        <div class="userdata-content">
                            <div class="point">此文件为报价文件，没有配置项</div>
                        </div>
                    </div>
                    <div class="err none">
                        <div class="userdata-content">
                            <div class="point"></div>
                        </div>
                    </div>
                    <div class="other">
                        <div class="userdata-content">
                            <p>无配置项</p>
                        </div>
                    </div>
                </div>
                <script src="Javascripts/upload-started.js"></script>
<!--                    <div class="record">
                    <p class="con">正在压缩HTML文件....<p>
                    <p class="con">正在压缩HTML文件....<p>
                    <p class="con">正在压缩图片文件....<p>
                </div>
                <div style="height:20px;"></div>-->
            </div>
        </div>
    </div>
</body>
<?php include 'AgentFoot.php'; ?>