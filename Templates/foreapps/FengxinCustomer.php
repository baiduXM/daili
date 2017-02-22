<?php include 'AgentHead.php';?>
<body>
<div class="wrap">
  <?php include 'AgentTop.php';?>
  <div class="main">
    <?php include 'AgentLeft.php';?>
    <div class="content-right fr">
      <div class="opacity"></div>
      <!-- 添加风信客户start!-->
      <div class="Bombbox FengxinBombbox" id="add-fx">
        <h1 class="Bombbox-top"> <span class="close"><img src="/images/close.png" /></span>风信客户添加 </h1>
        <div class="Bombbox-m">
          <table width="100%" border="0">
            <tr height="45">
              <td colspan="2"><div class="slideTxtBox">
                  <div class="hd">
                    <ul>
                      <li class="i1">选择客户</li>
                      <li id="new" class="i2">创建新客户</li>
                    </ul>
                  </div>
                  <div class="bd">
                    <div id="edite1" class="edite">
                      <form id="form2" enctype="multipart/form-data" action="<?php echo UrlRewriteSimple($MyModule,'EditCustomerFengxinInfo',true);?>" method="post" name="form2">
                        <p>
                          <label>选择客户：</label>
                          <input id="companyname" class="input2" type="text" name="CompanyName" value="" autocomplete="off" />
                        <div id="companylist"></div>
                        </p>
                        <p class="custominfo"></p>
                      </form>
                    </div>
                    <div id="edite2" class="edite">
                      <form enctype="multipart/form-data" id="form2" action="<?php echo UrlRewriteSimple($MyModule,'EditCustomerFengxinInfo',true);?>" method="post" name="form2">
                        <table width="100%" border="0">
                          <tbody>
                            <tr height="30">
                              <td width="100" align="right">风信用户名：</td>
                              <td><input type="text" value="" class="input" name="FengXinUserName">
                                <input type="hidden" value="new" name="new" /></td>
                            </tr>
                            <tr height="30">
                              <td align="right">风信密码：</td>
                              <td><input type="text" disabled="disabled" value="初始始密码为：fengxin123456" class="input" /></td>
                            </tr>
                            <tr height="30">
                              <td align="right">企业名称：</td>
                              <td><input type="text" value="" class="input" name="CompanyName" /></td>
                            </tr>
                            <tr height="30">
                              <td align="right">联系人：</td>
                              <td><input type="text" value="" class="input" name="CustomersName" /></td>
                            </tr>
                            <tr height="30">
                              <td align="right">联系电话：</td>
                              <td><input type="text" value="" class="input" name="Tel" /></td>
                            </tr>
                            <tr height="30">
                              <td align="right">传真：</td>
                              <td><input type="text" value="" class="input" name="Fax" /></td>
                            </tr>
                            <tr height="30">
                              <td align="right">电子邮件：</td>
                              <td><input type="text" value="" class="input" name="Email" /></td>
                            </tr>
                            <tr height="30">
                              <td align="right">通讯地址：</td>
                              <td><input type="text" value="" class="input" name="Address" /></td>
                            </tr>
                            <tr height="34">
                              <td align="right">公众号名称：</td>
                              <td nowrap="nowrap"><input type="text" value="" class="input" name="WeiXinName" /></td>
                            </tr>
                            <tr height="34">
                              <td align="right">公众号原始id：</td>
                              <td nowrap="nowrap"><input type="text" value="" class="input" name="WeiXinID" /></td>
                            </tr>
                            <tr height="34">
                              <td align="right">微信号：</td>
                              <td><input type="text" value="" class="input" name="WeiXinNO" /></td>
                            </tr>
                            <tr height="34">
                              <td align="right">行业版本：</td>
                              <td>
                                  <select class="select" name="GongNeng">
                                      <option value="标准版">标准版</option>
                                      <option value="餐饮版">餐饮版</option>
                                      <option value="婚庆版">婚庆版</option>
                                      <option value="电商微店版">电商微店版</option>
                                      <option value="医疗版">医疗版</option>
                                      <option value="汽车版">汽车版</option>
                                      <option value="酒店版">酒店版</option>
                                      <option value="地产版">地产版</option>
                                      <option value="美容版">美容版</option>
                                      <option value="旅游版">旅游版</option>
                                      <option value="健身版">健身版</option>
                                      <option value="政务版">政务版</option>
                                      <option value="物业版">物业版</option>
                                      <option value="KTV版">KTV版</option>
                                      <option value="酒吧版">酒吧版</option>
                                      <option value="装修版">装修版</option>
                                      <option value="教育版">教育版</option>
                                      <option value="花店版">花店版</option>
                                  </select>
                              </td>
                            </tr>
                            <tr height="34">
                              <td align="right">备注：</td>
                              <td><textarea style="height: 60px;" class="input"
																		rows="" cols="" name="Remark"></textarea></td>
                            </tr>
                            <tr height="34">
                              <td align="right"></td>
                              <td><input type="submit" class="btn-Determine check" value="确定" name="create">
                                <input type="reset" onClick="ClosetEditInfoResult()" class="btn-Cancel" value="取消" name="取消">
                                <!--<input type="hidden" value="18" id="CustomersProjectID" name="CustomersProjectID">
                                <input type="hidden" value="22" id="CustomersID" name="CustomersID">
                                <input type="hidden" value="7" id="ProjectID" name="ProjectID">--></td>
                            </tr>
                          </tbody>
                        </table>
                      </form>
                    </div>
                  </div>
                </div>
                <script type="text/javascript">jQuery(".slideTxtBox").slide({trigger:"click"});</script></td>
            </tr>
          </table>
        </div>
      </div>
      <!-- 添加风信客户end!--> 
      <!-- 风信客户管理start!-->
      <div class="Bombbox FengxinBombbox" id="Manage-box"></div>
      <!-- 风信客户管理end!--> 
      <!-- 版本升级start!-->
      <div class="Bombbox" id="Upgrade-box"></div>
      <!-- 版本升级end!--> 
      <!-- 续费start!-->
      <div class="Bombbox" id="Renewals-box"> </div>
      <!-- 续费end!-->
      <div class="content-box">
        <div class="content-top">
          <div class="search fr">
            <form action="<?php echo UrlRewriteSimple($MyModule,$MyAction,true);?>" method="post" name="form2">
              <input name="searchtxt" type="text" placeholder="公众号" value="" class="searchtext" />
              <input name="submit" type="submit" value="" class="search-btn" />
            </form>
          </div>
          <a href="<?php echo UrlRewriteSimple('Agent','Customer',true);?>"
							class="back-btn">返回上一级</a><a href="#" class="btn" id="btn-add">添加风信</a> </div>
        <div class="content-main">
          <table width="100%" cellpadding="0" cellspacing="1" border="0"
							class="box-page">
            <thead>
              <tr height="33">
                <th width="5%">编号</th>
                <th width="15%">企业名称</th>
                <th width="15%">公众账号名称</th>
                <th width="9%">行业版本</th>
                <th width="16%">已增购服务</th>
                <th width="9%">到期时间</th>
                <th width="6%">状态</th>
                <th width="25%">操作</th>
              </tr>
            </thead>
            <tbody id="grid">
              <?php 
              if(empty($Data ['Data'])){
              	echo '<tr height="35"><td colspan="8" style="align:center">没有数据结果</td></tr>';
              }
              else{
              foreach ($Data ['Data'] As $k => $Value){?>
              <tr height="35">
                <td><?php echo $Value['CustomersProjectID'];?></td>
                <td><div class="number"></div>
                  <?php echo $Value['CompanyName'];?>
                  <button type="button" class="step-icon button" value="<?php echo $Value['CustomersID'];?>" pagevalue="<?php echo $Data ['Page'];?>"> <img src="images/step-icon.png" /> </button></td>
                <td><?php echo $Value['WeiXinName'];?></td>
                <td><?php echo $Value['GongNeng'];?>
                    <!--<?php if($Value['GongNeng']=='标准版'){?>
                    <button type="button" class="Upgrade-icon button" value="<?php echo $Value['CustomersProjectID'];?>"> <img src="images/up-icon.png" /> </button>
                    <?php } ?>-->
                </td>
                <td><?php echo $Value['Fuwu'];?></td>
                <td><?php echo date("Y-m-d", strtotime($Value['EndTime'])) ;?></td>
                <td><button type="button" class="Status-icon button" value="<?php echo $Value['CustomersID'];?>" status="<?php echo $Value['status'];?>"> <img src="images/status<?php echo $Value['status'];?>.png" /> </button></td>
                <td nowrap="nowrap"><button type="button" class="box-a renewals" value="<?php echo $Value['CustomersProjectID'];?>" pagevalue="<?php echo $Data ['Page'];?>">续费</button>
                  <button type="button" class="box-a manage" value="<?php echo $Value['CustomersID'];?>" pagevalue="<?php echo $Data ['Page'];?>">修改</button>
                  <a target="_blank" href="<?php echo UrlRewriteSimple($MyModule,'Manage',true).'&ID='.$Value['CustomersProjectID'];?>" class="box-a">管理</a><a href="<?php echo UrlRewriteSimple($MyModule,'DeleteFengXin',true).'&ID='.$Value['CustomersProjectID'];?>" class="box-a" onClick="return confirm('确定删除该用户产品吗?')">删除</a></td>
              </tr>
              <?php } }?>
            </tbody>
            <tfoot>
              <tr height="35">
                <td colspan="8"> 共 <?php echo $Data ['RecordCount'];?> 条记录，每页 <?php echo $Data ['PageSize'];?> 条 <a
										href="<?php echo UrlRewriteSimple($MyModule,'Customer',true);?>">首页</a> <a
										href="<?php if($Data['Page']>1){echo UrlRewriteSimple($MyModule,'Customer',true).'&Page='.($Data['Page']-1);}else{echo '#';}?>">上一页</a> <a
										href="<?php if($Data['Page']<$Data['PageCount']){echo UrlRewriteSimple($MyModule,'Customer',true).'&Page='.($Data['Page']+1);}else{echo '#';}?>">下一页</a> <a
										href="<?php if($Data['Page']<$Data['PageCount']){echo UrlRewriteSimple($MyModule,'Customer',true).'&Page='.$Data['PageCount'];}else{echo '#';}?>">尾页</a> 跳转到
                  <input name="ToPage" id="ToPage" onKeyUp="ToPage(<?php echo $Data['PageCount'];?>)" ; type="text" style="width: 30px; margin: 0px 4px;" />
                  页 <span
										id="ToPage_Test" style="color: #F00"></span> <script
											type="text/javascript">
                                    function ToPage(PageCount){
                                        var pages = document.getElementById("ToPage").value;
                                        if(pages>PageCount || pages<1)
                                        {
                                            document.getElementById("ToPage_Test").innerHTML='请填写正确分页';
                                            return false;
                                        }
                                        location.href = "<?php echo UrlRewriteSimple($MyModule,'Customer',true).'&Page=';?>"+pages;
                                    }
                                </script></td>
              </tr>
            </tfoot>
          </table>
          <script type="text/javascript">
                        //grid("名称","奇数行背景","偶数行背景","鼠标经过背景","点击后背景");
                        grid("grid","#f9fcfd","#ffffff");
                    </script> 
        </div>
      </div>
    </div>
  </div>
  <script src="./Javascripts/fengxin.js" type="text/javascript"></script>
  <?php include 'AgentFoot.php';?>