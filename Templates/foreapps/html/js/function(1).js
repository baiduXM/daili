$(document).ready(function(){
	$('.top-vip').hover(function(){
		$(this).find(".hide-vip").show()
		},function(){
		$(this).find(".hide-vip").hide()
		})
		
		//弹出框
		$('#btn-Client-add').click(function(){
		$("#add-Client").show()
		$(".opacity").show()
		})
		$('.add-img-btn').click(function(){
		$("#add-picture").show()
		$(".opacity").show()
		})
		$('.Upgrade-icon').click(function(){
		$("#Upgrade-box").show()
		$(".opacity").show()
		})
		$('.Renewals').click(function(){
		$("#Renewals-box").show()
		$(".opacity").show()
		})
		$('#btn-add').click(function(){
		$("#add-fx").show()
		$(".opacity").show()
		})
		$('.close,.btn-Cancel').click(function(){
		$("#add-Client,#add-picture,#Upgrade-box,#Renewals-box,#add-fx").hide()
		$(".opacity").hide()
		})
		//提示空间
		$('.step-icon').click(function(){
		$('.hide-num-box1').remove();
		$(this).siblings('.number').html('<div class="hide-num-box1" style="width:247px">\
    	<span class="hide-num-box-icon1"></span>\
        <div class="hide-num-box-main1">\
        	<table width="100%" border="0">\
  <tr>\
    <td width="100" align="right">公司：</td>\
    <td width="130"><input name="" type="text" value="厦门某某公司" style=" width:113px;" /></td>\
  </tr>\
  <tr>\
    <td align="right">电话：</td>\
    <td><input name="" type="text" value="0592388477" style=" width:113px;" /></td>\
  </tr>\
  <tr>\
    <td align="right">联络人：</td>\
    <td><input name="" type="text" value="陈先生" style=" width:113px;" /></td>\
  </tr>\
  <tr>\
    <td align="right">联络人手机：</td>\
    <td><input name="" type="text" value="1598075458" style=" width:113px;" /></td>\
  </tr>\
  <tr>\
    <td align="right">营业执照：</td>\
    <td>\
	<span class="file-box">\
	<input type="button" class="btnfile" value="上传" /><input type="file" name="fileField" class="file" id="fileField" size="28" onchange="document.getElementById("textfield").value=this.value" /></span>\
	<span class="gray font12">未上传</span></td>\
  </tr>\
  <tr>\
    <td align="right">税务登记证：</td>\
    <td><span class="file-box"><input type="button" class="btnfile" value="更改" />\
    <input type="file" name="fileField" class="file" id="fileField" size="28" onchange="document.getElementById("textfield").value=this.value" /></span><a href="#" class="Checkout">查看</a></td>\
  </tr>\
  <tr>\
    <td align="right">备注：</td>\
    <td><input name="" type="text" value="厦门某某公司" style=" width:113px;" /></td>\
  </tr>\
  <tr height="45">\
    <td colspan="2" align="right"><input name="" type="button" value="完成" class="btn-Determine" /><input name="" type="button" value="取消" class="btn-Cancel" /></td>\
  </tr>\
</table>\
        </div></div>')
		$('.hide-num-box').css({"marginTop":-($('.hide-num-box').height()/2)})
		})
		$('.btn-Cancel').live('click',function(){
			$('.hide-num-box1').remove();
		})
		//企业资料修改
		$('.number1').hover(function(){
		$(this).find('.number').html('<div class="hide-num-box">\
    	<span class="hide-num-box-icon"></span>\
        <div class="hide-num-box-main">\
        	<dl>空间大小：<span class=" red">3</span></dl>\
            <dl>空间大小：<span class=" red">3</span></dl>\
            <dl>空间大小：<span class=" red">3</span></dl>\
            <dl>空间大小：<span class=" red">3</span></dl>\
            <dl class=" more"><a href="#">更多...</a></dl>\
        </div></div>')
		$('.hide-num-box').css({"marginTop":-($('.hide-num-box').height()/2)})
		},function(){
		$(this).find('.number').html("")
		})
	//幻灯片元素与类"menu_body"段与类"menu_head"时点击
	$(".menu_head").click(function(){
		$(this).toggleClass("cur").next(".menu_body").slideToggle(300).siblings(".menu_body").slideUp("slow");
		$(this).siblings().removeClass("cur");
	});
	if($('.main').height()< $(window).height())
	{$(".foot").addClass("foot-fixed")}
	else{$(".foot").removeClass("foot-fixed")}
	$('.top-right').width( $(window).width()- $('.top-left').outerWidth());
	$('.content-right').width( $(window).width()- $('.class').width()-10);
	$('.box-item').width( $('.content-box').width()- $('.chartdiv').outerWidth());
	$('.Bombbox').css({"marginTop":-($('.Bombbox').height()/2+20)})
	
	$(window).resize(function(){
		$('.Bombbox').css({"marginTop":-($('.Bombbox').height()/2+20)})
		$('.box-item').width( $('.content-box').width()- $('.chartdiv').width());
		$('.content-right').width( $(window).width()- $('.class').outerWidth());
		$('.top-right').width( $(window).width()- $('.top-left').outerWidth());
		if($('.main').height()< $(window).height())
		{$(".foot").addClass("foot-fixed")}
		else{$(".foot").removeClass("foot-fixed")}
	})
	})
	
	