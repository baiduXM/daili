<?php include 'AgentHead.php'; ?>
<body>
    <div class="wrap">
        <?php include 'AgentTop.php'; ?>
        <?php include 'Agentleft.php'; ?>
        <div class="cont-right">
            <div class="mianBox">
                <div class="nycont-main">
                    <div id="tab" class="nytab">
                        <div class="tabList">
                            <ul>
                                <li class="cur">添加双站模板</li>
                            </ul>
                        </div>
                        <div class="tabCon">
                            <div class="cur">
                                <div class="userdata-content">
                                    <p>
                                        <span class="content-l">双站模板编号</span>
                                        <span>
                                            <input type="text" name="id" class="Input" value="" size="25">
                                            <span class="content-l">双站名称</span>
                                            <span>
                                                <input type="text" name="name" class="Input" value="" size="10">
                                            </span>
                                    </p>
                                    <p>
                                        <span class="content-l">语言选择：</span>
                                        <span class="lang ">
                                            <tt class="transition1">CN</tt>
                                            <span class="transition1"></span>
                                        </span>
                                        <span class="content-l">推荐</span>
                                        <span>
                                            <select name="tuijian" style="width:120px">
                                                <option value="0" selected="selected">不启用</option>
                                                <option value="1">启用</option>
                                                <option value="2">推荐到首页</option>
                                            </select>
                                        </span>
                                    </p>
                                    <p>
                                        <span class="content-l">市场价</span>
                                        <span>
                                            <input type="text" name="price" class="Input" value="" size="25"></span>
                                        <span class="content-l">优惠价</span>
                                        <span>
                                            <input type="text" name="youhui" class="Input" value="" size="25"></span>
                                    </p>
                                    <p>
                                        <span class="content-l">PC模板编号</span>
                                        <span>
                                            <input type="text" name="pc" class="Input" value="" size="25"></span>
                                        <span class="content-l">PC模板URL</span>
                                        <span>
                                            <input type="text" name="pc_url" class="Input" value="" size="25"></span>
                                    </p>
                                    <p>
                                        <span class="content-l">手机模板编号</span>
                                        <span>
                                            <input type="text" name="mobile" class="Input" value="" size="25"></span>
                                        <span class="content-l">手机模板URL</span>
                                        <span>
                                            <input type="text" name="mobile_url" class="Input" value="" size="25"></span>
                                    </p>
                                </div>
                                <div class="btnDD">
                                    <input type="submit" class="Btn1" value="提交">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<?php include 'AgentFoot.php'; ?>