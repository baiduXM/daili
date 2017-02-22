<?PHP
	if($Data){
?>
 <table width="100%" cellpadding="0" cellspacing="1" border="0"
							class="box-page">
            <thead>
              <tr height="33">
                <th width="7%">编号</th>
                <th width="20%">负责客服</th>
				<th>账号</th>
                <th width="9%">联系人</th>
                <th>联系电话</th>
                <th width="9%">开户时间</th>
                <th width="9%">到期时间</th>
				<th>开通站点</th>
              </tr>
            </thead>
            <tbody id="grid">
              <?php 
              if(empty($Data)){
              	echo '<tr height="35"><td colspan="7" style="align:center">没有数据结果</td></tr>';
              }
              else{
              foreach ($Data As $k => $Value){?>
              <tr height="35">
                <td align="center"><?php echo $Value['CustomersProjectID'];?></td>
				<td align="center"><?php echo $Value['UserName'];?></td>
				<td align="center"><?php echo $Value['G_name'];?></td>
                <td align="center"><?php echo $Value['CustomersName'];?></td>
                <td align="center"><?php echo $Value['Tel'];?></td>
                <td align="center"><?php echo date("Y-m-d", strtotime($Value['StartTime'])) ;?></td>
                <td align="center"><?php echo date("Y-m-d", strtotime($Value['EndTime'])) ;?></td>
				<td align="center">开通：<?php if($Value['isPackage']) echo '套餐' ;elseif($Value['CPhone']==3) echo '双站';elseif($Value['CPhone']==1) echo 'PC站';elseif($Value['CPhone']==2) echo '手机站' ;?></td>
              </tr>
              <?php } }?>
            </tbody>
<?php 
	}else{
?>
<div class="search fr">
	<form action="<?php echo UrlRewriteSimple(Gbaopen,ToOne,true);?>" method="post" name="form2">
	  <input name="searchtxt" type="text" placeholder="域名" value="" class="searchtext" />
	  <input name="submit" type="submit" value="查询"/>
	</form>
</div>

<?PHP
	}
?>