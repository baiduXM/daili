<?php include 'AgentHead.php'; ?>
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
                <div id="tab" class="nytab">
                    <div class="tabList">
                        <ul>
                            <li class="cur"><?php echo $Type ? '代理商' : '客服' ?>列表</li>
                            <li class="">添加<?php echo $Type ? '代理商' : '客服' ?></li>
                        </ul>
                    </div>
                    <div class="tabCon">
                        <div class="cur">
                            <div class="shbox">
                                <?php if(!$Type){ ?>
                                <div class="search">
                                    <div class="leftS"> <font>按<?php echo $Type ? '代理商' : '客服' ?>信息查找:</font>
                                        <span>
                                            <input type="text" class="Input" placeholder="<?php echo $Type ? '代理商' : '客服' ?>账号" id="search1"> <i class="iconfont"></i>
                                        </span>
                                        <span>
                                            <button type="submit" id="searchbox" class="searchbottom">查找</button>
                                        </span>
                                    </div>
                                </div>
                                <?php } ?>
                                <form action="" id="listform">
                                    <table border="0" cellspacing="0" cellpadding="0" width="100%" class="showbox">
                                        <tbody>
                                            <tr>
                                            <!--<th width="5%"><input type="checkbox"></th>-->
                                                <th class="text-left">账号</th>
                                                <th>电话</th>
                                                <th>邮箱</th>
                                                <th>客户数量</th>
                                                <th class="text-right" width="25%">操作/管理</th>
                                            </tr>
                                        </tbody>
                                        <tbody id="listtbody">
                                            <?php foreach ($Data['agentlist'] as $val) { ?>
                                                <tr>
    <!--                                            <td><input type="checkbox" name="ID"></td>-->
                                                    <td class="text-left"><?php echo $val['UserName'] ?></td>
                                                    <td class="enfont"><?php echo $val['ContactName'] ? $val['ContactTel'] : '--' ?></td>
                                                    <td class="enfont"><?php echo $val['ContactTel'] ? $val['ContactEmail'] : '--' ?></td>
                                                    <td><font style="color:#090"><?php echo $val['CusNum'] ? $val['CusNum'] : 0; ?></font></td>
                                                    <td class="text-right pop">
                                                        <!--                                                    <a href="javascript:;" class="recharge">充值</a>
                                                                                                            <font class="line">|</font>-->
                                                        <a href="javascript:;" class="modify">密码修改</a>
                                                        <?php if($_SESSION["Level"]==1){?>
                                                            <a href="javascript:;" class="recharge">充值</a>
                                                        <?php }?>
                                                    <?php if(!$Type){ ?>
                                                        <a href="javascript:;" class="delete">删除</a>
                                                    <?php } ?>
                                                    </td>
                                            <input type="hidden" value="<?php echo $val['AgentID']; ?>">
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </form>
                                <div class="pagebox">
                                    <div class="paging">
                                        <a class="pageprev" href="javascript:;"></a>
                                        <?php for ($i = 1; $i <= ceil($Data['count'] / 8); $i++) {
                                            if ($i == 1) echo '<a class="num pon" href="javascript:;">' . $i . '</a>';
                                            elseif ($i > 5) echo '<a class="num" href="javascript:;" style="display:none">' . $i . '</a>';
                                            else echo '<a class="num" href="javascript:;">' . $i . '</a>';
                                        } ?>
                                        <a class="pagenext" href="javascript:;"></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="userdata-content">
                                <p>
                                    <span class="content-l"><?php echo $Type ? '代理商' : '客服' ?>账号</span>
                                    <span>
                                        <input type="text" name="account" class="Input" size="25">
                                    </span>
                                    <span class="as">*</span>
                                </p>
                                <p>
                                    <span class="content-l">账号密码</span>
                                    <span>
                                        <input type="password" name="pwd" placeholder="6-16位字符组合" class="Input" size="12">
                                    </span>
                                    <span class="as">*</span>
                                </p>
                                <p>
                                    <span class="content-l"><?php echo $Type ? '代理商' : '客服' ?>昵称</span>
                                    <span>
                                        <input type="text" name="name" class="Input" size="25">
                                    </span>
                                </p>
                                <p>
                                    <span class="content-l">联系电话</span>
                                    <span>
                                        <input type="text" name="tel" class="Input" size="25">
                                    </span>
                                </p>
                                <p>
                                    <span class="content-l">邮箱地址</span>
                                    <span>
                                        <input type="text" name="email" class="Input" size="25">
                                    </span>
                                </p>
                                <?php if(!$Type){ ?>
                                <p id="typetag">
                                    <span class="content-l" style="vertical-align: top;">操作权限</span>
                                    <span class="powList">
                                        <span class="input-wrapper" data="modify">
                                            <span class="checkbox">
                                              <span>客户信息修改</span>
                                            </span>
                                        </span>
                                        <span class="input-wrapper" data="case">
                                            <span class="checkbox">
                                              <span>客户案例推荐</span>
                                            </span>
                                        </span>
                                        <span class="input-wrapper" data="renew">
                                            <span class="checkbox">
                                              <span>续费操作</span>
                                            </span>
                                        </span>
                                        <span class="input-wrapper" data="process">
                                            <span class="checkbox">
                                              <span>网站处理</span>
                                            </span>
                                        </span>
                                        <span class="input-wrapper" data="transfer">
                                            <span class="checkbox">
                                              <span>客户转移</span>
                                            </span>
                                        </span>
                                        <span class="input-wrapper" data="manage">
                                            <span class="checkbox">
                                              <span>客户管理</span>
                                            </span>
                                        </span>
                                        <span class="input-wrapper" data="create">
                                            <span class="checkbox">
                                              <span>客户创建</span>
                                            </span>
                                        </span>
                                        <span class="input-wrapper" data="">
                                            <span class="checkbox">
                                              <span>全选</span>
                                            </span>
                                        </span>
                                    </span>
                                </p>
                                <?php } ?>
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
</body>
<?php include 'AgentFoot.php'; ?>