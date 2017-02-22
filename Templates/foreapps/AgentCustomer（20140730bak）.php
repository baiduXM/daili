<?php include 'AgentHead.php';?>
<body>
<div class="wrap">
  <?php include 'AgentTop.php';?>
  <div class="main">
    <?php include 'AgentLeft.php';?>
    <div class="content-right fr"> 
      <!-- 添加客户开始!-->
      <div class="opacity"></div>
      <div class="Bombbox" id="add-Client">
        <h1 class="Bombbox-top"><span class="close"><img src="images/close.png" /></span>添加客户</h1>
        <div class="Bombbox-m">
          <form name="form1" method="post" action="<?php echo UrlRewriteSimple($MyModule,'AddCustomer',true);?>"  id="form1" enctype="multipart/form-data">
            <table width="100%" border="0">
              <tr height="30">
                <td width="140" align="right">企业名称：</td>
                <td><input name="CompanyName" type="text" class="input" /></td>
              </tr>
              <tr height="34">
                <td align="right">联系电话：</td>
                <td><input name="Tel" type="text" class="input" /></td>
              </tr>
              <tr height="34">
                <td align="right">联系人：</td>
                <td><input name="CustomersName" type="text" class="input"/></td>
              </tr>
              <tr height="34">
                <td align="right">传真：</td>
                <td><input name="Fax" type="text" class="input" /></td>
              </tr>
              <tr height="34">
                <td align="right">电子邮件：</td>
                <td><input name="Email" type="text" class="input" id="Email" /></td>
              </tr>
              <tr height="34">
                <td align="right">所属地区：</td>
                <td><select name="Area" class="input">
                    <option value="">选择</option>
                    <option value="厦门">厦门</option>
                    <option value="泉州">泉州</option>
                    <option value="龙岩">龙岩</option>
                    <option value="漳州">漳州</option>
                  </select></td>
              </tr>
              <tr height="64">
                <td align="right">备注：</td>
                <td><textarea name="Remark" cols="" rows="" class="input" style="height:60px;"></textarea></td>
              </tr>
              <tr height="34">
                <td colspan="2" align="center">
<script type="text/javascript">
function GetProjectInfo(Action){
	if(Action==1){
		document.getElementById("AddFengXin").style.display = 'block';
		document.getElementById("AddGBanPen").style.display = 'none';		
	}
	if(Action==2){
		document.getElementById("AddFengXin").style.display = 'none';
		document.getElementById("AddGBanPen").style.display = 'block';	
	}
}
</script>
                  <label>
                    <input type="radio" name="RadioGroup1" value="风信客户" id="RadioGroup1_0" style="width:15px; height:15px; vertical-align:middle"  onclick="GetProjectInfo(1);"/>
                    风信客户</label>
                  &nbsp;&nbsp;&nbsp;
                  <label>
                    <input type="radio" name="RadioGroup1" value="G宝盆客户" id="RadioGroup1_1" style="width:15px; height:15px;vertical-align:middle" onclick="GetProjectInfo(2);"/>
                    G宝盆客户</label>
                  </td>
              </tr>
              <tr height="34">
                <td colspan="2" align="center">
      <!-- 添加风信客户start!-->
          <table width="100%" border="0" style="display:none;" id="AddFengXin">
            <tr height="45">
              <td colspan="2">
              <div class="slideTxtBox">
                  <div class="hd">
                    <ul>
                      <li class="i1">邀请开通</li>
                      <li class="i2">已知客户公众号密码</li>
                    </ul>
                  </div>
                  <div class="bd">
                    <div class="edite">
                      <p>将生成一个邀请链接，发给客户由客户自行绑定微信公众号开通</p>
                    </div>
                    <div class="edite">
                      <table width="100%" border="0">
                        <tr height="34">
                          <td>公众号名称：</td>
                          <td><input name="" type="text" style="width:160px;" /></td>
                        </tr>
                        <tr height="34">
                          <td>公众号邮箱：</td>
                          <td><input name="" type="text" style="width:160px;" /></td>
                        </tr>
                        <tr height="34">
                          <td>初始化密码：</td>
                          <td><input name="" type="text" style="width:160px;" /></td>
                        </tr>
                        <tr height="34">
                          <td>公众号微信号：</td>
                          <td><input name="" type="text" style="width:160px;" /></td>
                        </tr>
                        <tr height="34">
                          <td>公众号原始接ID</td>
                          <td><input name="" type="text" style="width:160px;" /></td>
                        </tr>
                      </table></div>
                <script type="text/javascript">jQuery(".slideTxtBox").slide({trigger:"click"});</script>
                </div>
              </div>
                </td>
            </tr>
          </table>
      <!-- 添加风信客户end!--> 
      <!-- 添加G宝盆客户start!-->
          <table width="100%" border="0" style="display:none;" id="AddGBanPen">
            <tr height="45">
              <td colspan="2">
              <div class="slideTxtBox">
                  <div class="hd">
                    <ul>
                      <li class="i1">开通G宝盆</li>
                    </ul>
                  </div>
                  <div class="bd">
                    <div class="edite">
                      <table width="100%" border="0">
                        <tr height="34">
                          <td>公众号名称：</td>
                          <td><input name="" type="text" style="width:160px;" /></td>
                        </tr>
                        <tr height="34">
                          <td>公众号邮箱：</td>
                          <td><input name="" type="text" style="width:160px;" /></td>
                        </tr>
                        <tr height="34">
                          <td>初始化密码：</td>
                          <td><input name="" type="text" style="width:160px;" /></td>
                        </tr>
                        <tr height="34">
                          <td>公众号微信号：</td>
                          <td><input name="" type="text" style="width:160px;" /></td>
                        </tr>
                        <tr height="34">
                          <td>公众号原始接ID</td>
                          <td><input name="" type="text" style="width:160px;" /></td>
                        </tr>
                      </table></div>
                <script type="text/javascript">jQuery(".slideTxtBox").slide({trigger:"click"});</script>
                </div>
              </div>
                </td>
            </tr>
          </table>
      <!-- 添加G宝盆客户end!--> 
                </td>
              </tr>
              <tr height="34">
                <td align="right"></td>
                <td><input name="" type="submit" value="确定" class="btn-Determine" />
                  <input name="" type="reset" value="取消" class="btn-Cancel" /></td>
              </tr>
            </table>
          </form>
        </div>
      </div>
      <!-- 添加客户end-->
      
      <div class="content-box">
        <div class="content-top">
          <div class="search fr">
            <input name="" type="text" onFocus="if(this.value=='企业名称 / 公众号'){this.value='';}" onBlur="if(this.value==''){this.value='企业名称 / 公众号'}" value="企业名称 / 公众号" class="input"  />
            <input name="" type="button" class="search-btn" />
          </div>
          <a href="#" class="btn" id="btn-Client-add">添加客户</a> </div>
        <div class="content-main">
          <table width="100%" cellpadding="0" cellspacing="1" border="0" class="box-page">
            <thead>
              <tr height="33">
                <th width="3%">编号</th>
                <th width="22%">企业名称</th>
                <th width="15%">联系方式</th>
                <th width="10%">类别</th>
                <th width="10%">销售员</th>
                <th width="12%">备注</th>
                <th width="5%">G风险</th>
                <th width="5%">G寳盆</th>
                <th width="5%">状态</th>
                <th width="14%">操作</th>
              </tr>
            </thead>
            <tbody id="grid">
              <?php foreach ($Data ['Data'] As $Value){?>
              <tr height="35">
                <td width="3%"><?php echo $Value['CustomersID'];?></td>
                <td width="22%"><?php echo $Value['CompanyName'];?></td>
                <td width="15%"><?php echo $Value['Tel'];?></td>
                <td width="10%">潜在客户</td>
                <td width="10%">客户</td>
                <td width="12%">风信合同阶段</td>
                <td width="5%"><img src="images/fengxin.png" /></td>
                <td width="5%"><img src="images/Gbp.png" /></td>
                <td width="5%"><img src="images/play-icon.png" /></td>
                <td width="14%"><a href="#" class="box-a">修改</a><a href="#" class="box-a">删除</a></td>
              </tr>
              <?php }?>
            </tbody>
            <tfoot>
              <tr height="35">
                <td colspan="10"> 共 <?php echo $Data ['RecordCount'];?> 条记录，每页 <?php echo $Data ['PageSize'];?> 条 <a href="<?php if($Data['Page']>1){echo UrlRewriteSimple($MyModule,'Customer',true);}else{echo '#';}?>">首页</a> <a href="<?php if($Data['Page']>1){echo UrlRewriteSimple($MyModule,'Customer',true).'&Page='.($Data['Page']-1);}else{echo '#';}?>">上一页</a> <a href="<?php if($Data['Page']<$Data['RecordCount']){echo UrlRewriteSimple($MyModule,'Customer',true).'&Page='.($Data['Page']+1);}else{echo '#';}?>">下一页</a> <a href="<?php if($Data['Page']<$Data['RecordCount']){echo UrlRewriteSimple($MyModule,'Customer',true).'&Page='.$Data['PageCount'];}else{echo '#';}?>">尾页</a> 跳转到
                  <input name="ToPage" id="ToPage" onKeyUp="ToPage(<?php echo $Data['PageCount'];?>)"; type="text" style="width:30px; margin:0px 4px;" />
                  页 <span id="ToPage_Test" style="color:#F00"></span> 
                  <script type="text/javascript">
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
  <?php include 'AgentFoot.php';?>