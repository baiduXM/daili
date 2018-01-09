<?php include 'AgentHead.php'; ?>
<link rel="stylesheet" type="text/css" href="Css/create.css">
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
            <div class="mainBox">
                <?php if ($Data['power']) { ?>
                    <div class="crelist">
                        <div class="userdata-content">
                            <p>
                                <span class="content-l">公司账号</span>
                                <span>
                                    <input type="text" name="account" class="Input" >
                                </span>
                                <span class="as">*</span>
                                <span class="content-l">公司名称</span>
                                <span>
                                    <input type="text" name="companyname" class="Input" >
                                </span>
                                <span class="as">*</span>
                            </p>
                            <p>
                                <span class="content-l">联系人姓名</span>
                                <span>
                                    <input type="text" name="username" class="Input" size="10" >
                                </span>
                                <span class="as">*</span>
                                <span class="content-l">联系电话</span>
                                <span>
                                    <input type="text" name="tel" class="Input" size="13" >
                                </span>
                                <span class="as">*</span>
                            </p>
                            <p>
                                <span class="content-l">邮箱</span>
                                <span>
                                    <input type="text" name="email" class="Input" >
                                </span>
                                <span class="content-l">地址</span>
                                <span>
                                    <input type="text" name="address" class="Input" >
                                </span>                              
                            </p>
                            <p>                                
                                <span class="content-l">起始时间</span>
                                <span>
                                    <input type="text" name="starttime" class="Input" placeholder="格式:2016-5-1 16:00:00，不填默认当前时间">
                                </span>
                                <span class="content-l">员工人数限制</span>
                                <span>
                                    <input type="text" name="num" class="Input" value="10">
                                </span> 
                            </p>
                        </div>
                        <div class="btnDD" style="text-align:center;">
                            <input type="submit" class="Btn3" value="创建并开通">
                        </div>
                    </div>
<?php } else echo '您没有权限执行此操作！！'; ?>
            </div>
        </div>
    </div>
</body>
<?php include 'AgentFoot.php'; ?>