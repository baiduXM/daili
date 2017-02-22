<?php include 'AgentHead.php';?>
<body>
<div class="wrap">
  <?php include 'AgentTop.php';?>
  <div class="main">
    <?php include 'AgentLeft.php';?>
    <div class="content-right fr">
    	<div class="content-box">
					<div class="content-main">
						<table width="100%" cellpadding="0" cellspacing="1" border="0"
							class="box-page">
							<thead>
								<tr height="33">
									<th width="10%">编号</th>
									<th width="23%">登陆时间</th>
									<th width="19%">登陆IP地址</th>
								</tr>
							</thead>
							<tbody id="grid">
                        <?php foreach ($Data ['Data'] As $k => $Value){?>
                            <tr height="35">
								<td><?php echo $Value['id'];?></td>
								<td><?php echo $Value['time'];?></td>
								<td><?php echo $Value['ip'];?></td>
							</tr>
                        <?php }?>
                        </tbody>
							<tfoot>
								<tr height="35">
									<td colspan="7"> 共 <?php echo $Data ['RecordCount'];?> 条记录，每页 <?php echo $Data ['PageSize'];?> 条 <a
										href="<?php echo UrlRewriteSimple($MyModule,$MyAction,true);?>">首页</a>
										<a
										href="<?php if($Data['Page']>1){echo UrlRewriteSimple($MyModule,$MyAction,true).'&Page='.($Data['Page']-1);}else{echo '#';}?>">上一页</a>
										<a
										href="<?php if($Data['Page']<$Data['RecordCount']){echo UrlRewriteSimple($MyModule,$MyAction,true).'&Page='.($Data['Page']+1);}else{echo '#';}?>">下一页</a>
										<a
										href="<?php if($Data['Page']<$Data['RecordCount']){echo UrlRewriteSimple($MyModule,$MyAction,true).'&Page='.$Data['PageCount'];}else{echo '#';}?>">尾页</a>
										跳转到 <input name="ToPage" id="ToPage"
										onKeyUp="ToPage(<?php echo $Data['PageCount'];?>)"
										; type="text" style="width: 30px; margin: 0px 4px;" /> 页 <span
										id="ToPage_Test" style="color: #F00"></span> <script
											type="text/javascript">
                                    function ToPage(PageCount){
                                        var pages = document.getElementById("ToPage").value;
                                        if(pages>PageCount || pages<1)
                                        {
                                            document.getElementById("ToPage_Test").innerHTML='请填写正确分页';
                                            return false;
                                        }
                                        location.href = "<?php echo UrlRewriteSimple($MyModule,$MyAction,true).'&Page=';?>"+pages;
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