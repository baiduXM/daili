<?php include 'AgentHead.php';?>
<script type="text/javascript" src="./Javascripts/amcharts.js"></script>
<script type="text/javascript" src="./Javascripts/pie.js"></script>
<script type="text/javascript">
            var chart;
            var legend;
            var chartData = [{
                country: "功能版",
                litres: <?php echo $Data['Info']['FengXin']['Fgongneng'];?>
            }, {
                country: "标准版",
                litres: <?php echo $Data['Info']['FengXin']['Fstandard'];?>
            }];
            AmCharts.ready(function () {
                // PIE CHART
                chart = new AmCharts.AmPieChart();
                chart.dataProvider = chartData;
                chart.titleField = "country";
                chart.valueField = "litres";
                chart.outlineColor = "#FFFFFF";
                chart.outlineAlpha = 0.9;
				chart.labelRadius = -30;
                chart.outlineThickness = 2;
				chart.labelText ="[[country]]";
                // WRITE
                chart.write("chartdiv");
            });
        </script>
<body>
<div class="wrap" >
  <?php include 'AgentTop.php';?>
  <div class="main">
    <?php include 'AgentLeft.php';?>
    <div class="content-right fr">
      <div class="opacity"></div>
      <!-- 充值start!-->
      <div class="Bombbox" id="Recharge">
        <div class="slideTxtBox">
          <div class="hd">
            <ul>
              <li style="width:50%">G宝盆充值</li>
              <li style="width:50%">风信充值</li>
            </ul>
          </div>
          <div class="bd" style="border:0px;">
            <div class="Recharge-table">
              <table width="100%" border="0">
                <tr height="30">
                  <td width="70">充值金额：</td>
                  <td><input name="" type="text" style="width:250px;" /></td>
                </tr>
                <tr height="25">
                  <td colspan="2">若需人工充值，请联系客服</td>
                </tr>
              </table>
            </div>
            <div class="Recharge-table">
              <table width="100%" border="0">
                <tr height="30">
                  <td width="70">充值金额：</td>
                  <td><input name="" type="text" style="width:250px;" /></td>
                </tr>
                <tr height="25">
                  <td colspan="2">若需人工充值，请联系客服</td>
                </tr>
              </table>
            </div>
          </div>
        </div>
        <script type="text/javascript">jQuery(".slideTxtBox").slide({trigger:"click"});</script>
        <table width="100%" border="0" align="center">
          <tr height="50">
            <td width="90"></td>
            <td><input name="" type="button" value="确定充值" class="btn-Determine" />
              <input name="" type="button" value="取消充值" class="btn-Cancel" /></td>
          </tr>
        </table>
      </div>
      <!-- 充值end!-->
      <div class="content-box">
        <div class="money-box">
          <table width="100%" border="0">
            <tr height="70">
              <td style="background:url(images/index.jpg) right center no-repeat;" width="40%"><span class="font20">总余额 :</span><span class="red font33">￥<?php echo $Data['Balance']['SUM'];?></span></td>
              <td width="40%"><p>风信余额 :<span class="red font22">￥<?php echo $Data['Balance']['FengXin'];?></span></p>
                <p>G寳盆余额 :<span class="red font22">￥<?php echo $Data['Balance']['GBaoPen'];?></span></p></td>
              <td width="20%"><!-- <input name="" type="button" value="充值" class="Recharge" id="Recharge-btn"/>!--></td>
            </tr>
          </table>
        </div>
        <div class="box-item">
          <div class="item">
            <h1 class="item-top"><span class="title">风信</span></h1>
            <table width="100%" border="0" cellspacing="1" cellpadding="0" id="grid1" class="item-table">
              <tr height="30">
                <td width="25%">客户数量：</td>
                <td class="center number1" ><div class="number"></div>
                  <?php echo $Data['Info']['FengXin']['Fcount'];?></td>
                <td width="25%">未生效客户：</td>
                <td class="center number1" ><div class="number"></div>
                  <?php echo $Data['Info']['FengXin']['Finvalid'];?></td>
              </tr>
              <tr height="30">
                <td width="25%">已过期客户：</td>
                <td class="center number1" ><div class="number"></div>
                  <?php echo $Data['Info']['FengXin']['Foverdue'];?></td>
                <td width="25%">即将到期客户：</td>
                <td class="center number1" ><div class="number"> </div>
                  <?php echo $Data['Info']['FengXin']['Fbeoverdue'];?></td>
              </tr>
              <tr height="30">
                <td width="25%">额度超限客户：</td>
                <td class="center number1" ><div class="number"></div>
                  - </td>
                <td width="25%">额度将尽客户：</td>
                <td class="center number1" ><div class="number"></div>
                  -</td>
              </tr>
            </table>
            <script type="text/javascript">
//grid("名称","奇数行背景","偶数行背景","鼠标经过背景","点击后背景");
grid("grid1","#ffffff","#fafafa");
</script> 
          </div>
          <div class="item">
            <h1 class="item-top"><span class="title">G寳盆</span></h1>
            <table width="100%" border="0" cellspacing="1" cellpadding="0" id="grid2" class="item-table">
              <tr height="30">
                <td width="25%">客户数量：</td>
                <td class="center number1" ><div class="number"></div>
                  <?php echo $Data['Info']['GBaoPen']['Gcount'];?></td>
                <td width="25%">未生效客户：</td>
                <td class="center number1" ><div class="number"></div>
                  <?php echo $Data['Info']['GBaoPen']['Ginvalid'];?></td>
              </tr>
              <tr height="30">
                <td width="25%">已过期客户：</td>
                <td class="center number1" ><div class="number"></div>
                  <?php echo $Data['Info']['GBaoPen']['Goverdue'];?></td>
                <td width="25%">即将到期客户：</td>
                <td class="center number1" ><div class="number"> </div>
                  <?php echo $Data['Info']['GBaoPen']['Gbeoverdue'];?></td>
              </tr>
              <tr height="30">
                <td width="25%">额度超限客户：</td>
                <td class="center number1" ><div class="number"></div>
                  - </td>
                <td width="25%">额度将尽客户：</td>
                <td class="center number1" ><div class="number"></div>
                  - </td>
              </tr>
            </table>
            <script type="text/javascript">
//grid("名称","奇数行背景","偶数行背景","鼠标经过背景","点击后背景");
grid("grid2","#ffffff","#fafafa");
</script> 
          </div>
        </div>
        <!--<div class="chartdiv">
          <div id="chartdiv"></div>
          <?php if($Data['Info']['FengXin']['Fgongneng']!=0 || $Data['Info']['FengXin']['Fstandard']!=0){?>
          <h1 class="title">风信客户行业划分比例</h1>
          <?php } ?>
        </div>
        <div style="width:100%; height:60px; display:block; clear:both;"></div>-->
      </div>
    </div>
  </div>
  <?php include 'AgentFoot.php';?>