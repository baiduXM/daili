<?php include 'AgentHead.php';?>
<body>
<div class="wrap">
  <?php include 'AgentTop.php';?>
  <div class="main">
    <?php include 'AgentLeft.php';?>
    <div class="content-right fr"> 
      <div class="content-box">
        <div class="content-top">
          <div class="search fr">
          	<form action="<?php echo UrlRewriteSimple($MyModule,$MyAction,true);?>" method="post" name="form2">
            <input name="searchtxt" type="text" onFocus="if(this.value=='姓名'){this.value='';}" onBlur="if(this.value==''){this.value='姓名'}" value="姓名" class="searchtext"  />
            <input name="submit" type="submit" value="" class="search-btn" />
            </form>
          </div>
		 </div>
        <div class="content-main">
          <table width="100%" cellpadding="0" cellspacing="1" border="0" class="box-page">
            <thead>
              <tr height="33">
                <th>编号</th>
                <th width="64%">内容</th>
              </tr>
            </thead>
            <tbody id="grid">
              <?php if ($Data['Data']){ foreach ($Data['Data'] As $Value){?>
              <tr height="35">
                <td><?php echo $Value['ID'];?></td>
                <td style="text-align: left;"><?php echo $Value['Content'];?></td>
              </tr>
              <?php }}?>
            </tbody>
            <tfoot>
              <tr height="35">
                <td colspan="8"> 共 <?php echo $Data ['RecordCount'];?> 条记录，每页 <?php echo $Data ['PageSize'];?> 条 <a href="<?php echo UrlRewriteSimple($MyModule,'Lists',true);?>">首页</a>
                 <a href="<?php if($Data['Page']>1){ echo UrlRewriteSimple($MyModule,'Lists',true).'&Page='.($Data['Page']-1);}else{echo '#';}?>">上一页</a> 
                 <a href="<?php if($Data['Page']<($Data['RecordCount']/$Data['PageSize'])){ echo UrlRewriteSimple($MyModule,'Lists',true).'&Page='.($Data['Page']+1);}else{echo '#';}?>">下一页</a>
                  <a href="<?php if($Data['Page']<$Data['RecordCount']){ echo UrlRewriteSimple($MyModule,'Lists',true).'&Page='.$Data['PageCount'];}else{echo '#';}?>">尾页</a> 跳转到
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
   location.href = "<?php echo UrlRewriteSimple($MyModule,'Lists',true).'&Page=';?>"+pages;
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
<script type="text/javascript">
$(".close,.btn-Cancel").live('click',function(){
	 $("#add-Client,#add-picture,#Upgrade-box,#Renewals-box,#add-fx,#Recharge,#Manage-box,.add-Client-fengxin").hide()
	 $(".opacity").hide()
	 $("#Manage-box").val('');
	 $(".custominfo").html('');	
})

 $("button.fengxin").click(function(){  
		var Company = $(this).val();
		var head = '';
		$.get("index.php", { module:"Fengxin",action:"GetCustomerInfoByName", name: Company},
	        function(data){
				$(".custominfo").html(data);
				$(".add-Client-fengxin").show();
        })
     })
$("button.manage").click(function(){
	 var vid=$(this).attr("value");
	 var vpage=$(this).attr("pagevalue");
	 $.get("index.php", { module:"Fengxin",action:"ManageFunction", ID: vid, Page: vpage },
		function(data){
		 $("#Manage-box").html(data)
		 $("#Manage-box").show();
	})
 })
</script>
  <?php include 'AgentFoot.php';?>