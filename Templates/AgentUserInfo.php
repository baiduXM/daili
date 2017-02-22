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
                                <li class="cur">基本资料</li>
                            </ul>
                        </div>
                        <div class="tabCon">
                            <div class="cur">
                                <div class="userdata-content">
                                    <p>
                                        <span class="content-l">姓名</span>
                                        <span>
                                            <input type="text" name="name" class="Input" value="<?php echo $Data['ContactName']; ?>" size="25">
                                        </span>
                                            <span class="as">
                                            </span>
                                    </p>
                                    <p>
                                        <span class="content-l">所属地区</span>
                                        <span>
                                            <input type="text" name="place" class="Input" value="<?php echo $Data['ContactAddress']; ?>" size="10">
                                        </span>
                                    </p>
                                    <p>
                                        <span class="content-l">联系电话</span>
                                        <span>
                                            <input type="text" name="tel" class="Input" value="<?php echo $Data['ContactTel']; ?>" size="25"></span>
                                        <span class="as">
                                        </span>
                                    </p>
                                    <p>
                                        <span class="content-l">邮箱地址</span>
                                        <span>
                                            <input type="text" name="email" class="Input" value="<?php echo $Data['ContactEmail']; ?>" size="25"></span>
                                        <span class="as">
                                        </span>
                                    </p>
                                    <p>
                                        <span class="content-l">组别</span>
                                        <span>
                                            <input type="text" name="group" class="Input" value="<?php echo $Data['Remarks']; ?>" disabled="true"></span>
                                        <span class="as">
                                        </span>
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
    <script type="text/javascript">
        var user = $('.Input'),
                usermsg = {};
        for (var i = 0, j = user.length; i < j; i++)
            usermsg[user[i].name] = user[i].value;
    </script>
</body>
<?php include 'AgentFoot.php'; ?>