<?php include 'AgentHead.php'; ?>
<link rel="stylesheet" type="text/css" href="Css/logcost.css">
<body>
    <div class="wrap">
        <?php include 'AgentTop.php'; ?>
        <?php include 'Agentleft.php'; ?>
        <div class="cont-right">
            <div class="mainBox">
                <div class="logcost-panel">
                    <input type="month" class="Input starttime timelimit month" style="margin-left:1%;" value="<?php echo $Data["month"]; ?>">
                    <button  class="searchbottom">查找</button>
                    <div style="float:right;display: inline;margin-right:1%;">
                        <label>类型：</label><select class="logcost-type">
                            <option value="0">所有</option>
                            <option value="1">创建客户</option>
                            <option value="2">网站续费</option>
                            <option value="3">充值</option>
                            <option value="4">扩容</option>
                        </select>
                    </div>
                    <div class="table-panel">
                        <span class="text-center table-title"><?php echo $Data["month"]; ?>消费日志</span>
                        <table>
                            <tr><th class="text-left">订单编号</th><th>消费客户</th><th>消费金额</th><th>剩余金额</th><th>操作</th><th>操作客服</th><th class="last">操作时间</th></tr>
                            <?php foreach ($Data["log"] as $v) { ?>
                                <tr class="data-item" data-type="<?php echo $v["type"]; ?>"><td class="text-left"><?php echo $v["OrderID"]; ?></td><td><?php echo $v["CompanyName"]; ?></td><td><?php echo ($v["cost"]>0?("+".$v["cost"]):$v["cost"]); ?></td><td><?php echo $v["Balance"]; ?></td><td><?php echo $v["description"]; ?></td><td><?php echo $v["ContactName"]; ?></td><td class="last"><?php echo $v["adddate"]; ?></td></tr>
                                    <?php } ?>
                        </table>
                        <?php if(count($Data["log"])==0){?>
                        <span class="text-center table-foot">没有日志记录</span>
                        <?php }?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<?php include 'AgentFoot.php'; ?>