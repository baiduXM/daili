jQuery(document).ready(function() {
	
    //用户提交
    $('.Btn1').click(function(){
        var input = $('.Input'),
            data = {},
            err = 0;
        for(var i=0,j=input.length;i<j;i++){
            data[input[i].name]=input[i].value;
            if(usermsg[input[i].name]!=data[input[i].name])
            	err +=1;
        }
        if(err){
        	$.post("Apps?module=Agent&action=UserInfo",{userinfo:data},function(result){
	    		if(!result.err){
	    			Msg(3,'您的信息已成功修改');
	    		}else{
	    			Msg(2,result.msg);
	    		}
	    	});
        }else{
        	Msg(1,'未更改任何消息，请修改后再提交');
        }
    });
});