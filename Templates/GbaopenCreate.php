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
                                <span class="content-l">选择客户</span>
                                <span>
                                    <select name="c_customer" id="c_customer" class="formstyle" style="width:200px">
                                        <option value="new">新建客户</option>
                                        <?php foreach ($Data['cus'] as $val) { ?>
                                            <option value="<?php echo $val['CustomersID'] ?>" <?php if ($val['CustomersID'] == $Data['cussel']['CustomersID']) echo 'selected'; ?>><?php echo $val['CompanyName'] ?></option>
                                        <?php } ?>
                                    </select>
                                </span>
                            </p>
                        </div>
                        <div class="userdata-content">
                            <p>
                                <span class="content-l">Email</span>
                                <span>
                                    <input type="text" name="email" class="Input" <?php if ($Data['cussel']) echo 'value="' . $Data['cussel']['Email'] . '" disabled="disabled"'; ?>></span>
                                <span class="content-l">公司名称</span>
                                <span>
                                    <input type="text" name="companyname" class="Input" <?php if ($Data['cussel']) echo 'value="' . $Data['cussel']['CompanyName'] . '"'; ?>></span>
                            </p>
                            <p>
                                <span class="content-l">联系人姓名</span>
                                <span>
                                    <input type="text" name="name" class="Input" size="10" <?php if ($Data['cussel']) echo 'value="' . $Data['cussel']['CustomersName'] . '"'; ?>>
                                </span>
                                <span class="content-l">联系电话</span>
                                <span>
                                    <input type="text" name="tel" class="Input" size="13" <?php if ($Data['cussel']) echo 'value="' . $Data['cussel']['Tel'] . '"'; ?>></span>
                            </p>
                            <p>
                                <span class="content-l">传真</span>
                                <span>
                                    <input type="text" name="fax" class="Input" size="25" <?php if ($Data['cussel']) echo 'value="' . $Data['cussel']['Fax'] . '"'; ?>></span>
                                <span class="content-l">地址</span>
                                <span>
                                    <input type="text" name="address" class="Input" <?php if ($Data['cussel']) echo 'value="' . $Data['cussel']['Address'] . '"'; ?>></span>
                            </p>
                            <p>
                                <span class="content-l" style="vertical-align:top">备注</span>
                                <span>
                                    <textarea name="remark" class="Input" style=" height:100%;" <?php if ($Data['cussel']) echo 'value="' . $Data['cussel']['Remark'] . '"'; ?>></textarea>
                                </span>
                                <?php if ($Data['ExperienceCount'] > 0) { ?>
                                    <span class="content-l" style="vertical-align:top">体验用户:</span>
                                    <input type="text" class="Experience text-right" value="否" disabled="disabled"/>
                                    <span class="Experience-btn"></span>
                                    <span style="vertical-align:top">体验用户剩余<font style="color:red;"><?php echo $Data['ExperienceCount']; ?></font>个名额;说明:体验用户可享受一个月免费体验使用！</span>
                                <?php } ?>
                            </p>
                        </div>
                        <div class="userdata-content" style="display:none">
                            <p>
                                <span class="content-l">账号</span>
                                <span>
                                    <input type="text" name="account" class="Input" size="25">
                                    <span class="content-l">密码</span>
                                    <span>
                                        <input type="text" name="password" class="Input" value="" placeholder="初始密码与账号一致" />
                                    </span>
                            </p>
                            <p>
                                <span class="content-l">优惠券</span>
                                <span>
                                    <input type="text" name="coupons" id="Coupons" class="Input" size="25"></span>
                                <span class="content-l">优惠价格</span>
                                <span>
                                    <input type="text" name="couponspri" id="CouponsPri" class="Input" disabled="true"></span>
                            </p>
                            <p>
                                <span class="content-l">起始时间</span>
                                <span>
                                    <input type="text" name="starttime" class="Input" placeholder="格式:2016-5-1 16:00:00，不填默认当前时间">
                                </span>
<!--                                <span class="content-l">开通年限</span>
                                <span>
                                    默认1年-->
                                    <!--<input type="number" name="stilltime" class="Input" min="1" max="100" placeholder="可选，不填默认1年">-->
                                <!--</span>-->
                            </p>
                            <p>
                                <span class="content-l">FTP</span>
                                <span class="Input">
                                    <input type="radio" name="ftp_c" value="1" checked>公司FTP
                                    <input type="radio" name="ftp_c" value="0">客户FTP
                                </span>
<!--                                <span class="content-l">容量</span>
                                <span class="Input">
                                    默认300M-->
<!--                                    <input type="radio" name="capacity" class="capacity" value="100" checked>100M
                                    <input type="radio" name="capacity" class="capacity" value="300" checked>300M
                                    <input type="radio" name="capacity" class="capacity" value="500">500M
                                    <input type="radio" name="capacity" class="capacity" value="1000">1000M-->
                                <!--</span>-->
                            </p>
                            <p id="companyFTP">
                                <span class="content-l">服务器选择</span>
                                <span>
                                    <select  class="form-control" name="ftp" style="width:200px">
                                        <?php
                                        foreach ($Data['server'] as &$val) {
                                            $val['CName'] = substr($val['CName'], 1);
                                            echo '<option value="' . $val['ID'] . '" content="' . $val['CName'] . '">' . $val['FuwuqiName'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </span>
                                <span class="as">需要客户手动以Cname解析到c<?php echo $Data['server'][0][CName]; ?>
                                </span>
                            </p>
                            <p class="ownftp" style="display:none;">
                                <span class="content-l">FTP地址</span>
                                <span>
                                    <input type="text" value="" class="Input" name="ftp_address">
                                </span>
                            </p>
                            <p class="ownftp" style="display:none;">
                                <span class="content-l">FTP用户名</span>
                                <span>
                                    <input type="text" value="" class="Input" name="ftp_user">
                                </span>
                            </p>
                            <p class="ownftp" style="display:none;">
                                <span class="content-l">FTP密码</span>
                                <span>
                                    <input type="text" value="" class="Input" name="ftp_pwd">
                                </span>
                            </p>
                            <p class="ownftp" style="display:none;">
                                <span class="content-l">访问地址</span>
                                <span>
                                    <input type="text" value="" class="Input" name="ftp_fwaddress">
                                </span>
                            </p>
                            <p class="ownftp" style="display:none;">
                                <span class="content-l">FTP端口</span>
                                <span>
                                    <input type="text" value="21" class="Input" name="ftp_duankou">
                                </span>
                            </p>
                            <p class="ownftp" style="display:none;">
                                <span class="content-l">FTP目录</span>
                                <span>
                                    <input type="text" value="./www/" class="Input" name="ftp_mulu">
                                </span>
                            </p>
                            <p>
                                <span class="content-l">高级定制</span>
                                <span class="Input">
                                    <input type="radio" name="super" value="0" checked>关闭
                                    <input type="radio" name="super" value="1">PC
                                    <input type="radio" name="super" value="2">手机
                                    <input type="radio" name="super" value="3">双站
                                </span>
                                <span class="content-l">类型选择</span>
                                <span class="Input">
                                    <input type="radio" name="pc_mobile" value="1" checked>PC
                                    <input type="radio" name="pc_mobile" value="2">手机
                                    <input type="radio" name="pc_mobile" value="3">套餐
                                    <input type="radio" name="pc_mobile" value="4">双站
                                </span>
                            </p>
                            <p class="modelchoose" id="pk" style="display:none;">
                                <span class="content-l">双站模板</span>
                                <span><input type="text" name="pkmodel" class="Input"></span>
                            </p>
                            <p class="modelchoose" id="pc">
                                <span class="content-l">pc模板</span>
                                <span><input type="text" name="pcmodel" class="Input"></span>
                                <span class="content-l">PC域名</span>
                                <span><input type="text" name="pcdomain" class="Input"></span>
                            </p>
                            <p class="modelchoose" id="mobile" style="display:none;">
                                <span class="content-l">手机模板</span>
                                <span><input type="text" name="mobilemodel" class="Input"></span>
                                <span class="content-l">手机域名</span>
                                <span><input type="text" name="mobiledomain" class="Input"></span>
                            </p>
                            <p class="modelchoose" id="domain_outpc" style="display:none;">
                                <input name="outpc_add" type="checkbox">
                                <span class="content-l">外域PC域名</span>
                                <span><input type="text" name="outpcdomain" class="Input" value="http://"></span>
                                <textarea readonly="readonly" class="info" style="display:none;"></textarea>
                                <textarea readonly="readonly" class="infoblnd" style="display:none;">&lt;script type=&quot;text/javascript&quot;&gt;var system ={win : false,mac : false,xll : false,ipad:false};var p = navigator.platform;system.win = p.indexOf(&quot;Win&quot;) == 0;system.mac = p.indexOf(&quot;Mac&quot;) == 0;system.x11 = (p == &quot;X11&quot;) || (p.indexOf(&quot;Linux&quot;) == 0);system.ipad = (navigator.userAgent.match(/iPad/i) != null)?true:false;if(system.win||system.mac||system.xll||system.ipad){}else{window.location.href=&quot;$$&quot;;}&lt;/script&gt;</textarea>
                                <span class="as">
                                </span>
                            </p>
                            <p class="modelchoose" id="domain_outmobile">
                                <input name="outmobile_add" type="checkbox">
                                <span class="content-l">外域手机域名</span>
                                <span><input type="text" name="outmobiledomain" class="Input" value="http://"></span>
                                <textarea readonly="readonly" class="info" style="display:none;"></textarea>
                                <textarea readonly="readonly" class="infoblnd" style="display:none;">&lt;script type="text/javascript"&gt; var system ={ win : false, mac : false, xll : false };  var p = navigator.platform; system.win = p.indexOf("Win") == 0; system.mac = p.indexOf("Mac") == 0; system.x11 = (p == "X11") || (p.indexOf("Linux") == 0); if(system.win||system.mac||system.xll){      window.location.href="$$"; }else{ } &lt;/script&gt;</textarea>
                                <span class="as">
                                </span>
                            </p>
                            <span style="padding-left: 25px;color: red;">注:默认年限为1年并赠送1个月,除体验用户，体验用户默认为一个月试用期;默认空间为300M</span>
                        </div>
                        <div class="btnDD" style="text-align:center;">
                            <input type="submit" class="Btn2" value="下一页">
                            <input type="submit" class="Btn3" value="<?php
                                   if ($Data['cussel'])
                                       echo '创建并开通';
                                   else
                                       echo'创建客户';
                                   ?>">
                        </div>
                    </div>
<?php } else echo '您没有权限执行此操作！！'; ?>
            </div>
        </div>
    </div>
</body>
<?php include 'AgentFoot.php'; ?>