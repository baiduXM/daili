$(function() {
    /*获取公告*/
    $.post("Apps?module=Gbaopen&action=GetNotice",function(data){
        var data = data.msg;
        if(!data.err){
            $('.shbox input[name=id]').val(data.id);
            $('.shbox input[name=uid]').val(data.uid);
            $('.shbox input[name=title]').val(data.title);
            if(data.is_on == 1){
                $('.shbox input[name=is_on]:eq(0)').attr('checked',true);
            } else {
                $('.shbox input[name=is_on]:eq(1)').attr('checked',true);
            }
            ue.addListener("ready", function () {
                UE.getEditor('editor').setContent(data.content);
            });
        }        
    });

    /*发布公告*/
    $('.Btn1').click(function(){
        var editor = UE.getEditor('editor');
        var data = {};

        data['id'] = $("input[name=id]").val();
        data['uid'] = $("input[name=uid]").val();
        data['content'] = editor.getContent();
        data['title'] = $("input[name=title]").val();
        data['is_on'] = $("input[name=is_on]:checked").val();
        // console.log(data);
        if(data){
            $.post("Apps?module=Gbaopen&action=ModifyNotice",{data:data},function(result){
                if(result.err == 0){
                    // Msg(3, result.msg);
                    alert('发布成功');
                    location.reload();
                }else{
                    Msg(2, result.msg);
                }
            });
        }else{
            Msg(1, '请输入内容');
        }
    });
});