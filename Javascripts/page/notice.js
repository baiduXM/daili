$(function() {
    /*选项卡切换*/
    $("#tab .tabList ul li").click(function() {
        $("#tab .tabCon > div").removeClass().eq($(this).index()).addClass("cur");
        $(this).addClass("cur").siblings().removeClass("cur");

        $("input[name=id]").val('');
        $("input[name=uid]").val('');
        $("input[name=title]").val('');
        $("input[name=is_on]:eq(0)").prop('checked',false);
        $("input[name=is_on]:eq(1)").prop('checked','checked');
        UE.getEditor('editor').setContent('');
    });

    /*页码后滚*/
    $(".pagebox .pagenext").click(function() {
        var cur = $(".paging .pon"),
            next = cur.next();
        if (next.hasClass("num")) {
            next.click();
        }
    });

    /*页码前滚*/
    $(".pagebox .pageprev").click(function() {
        var cur = $(".paging .pon"),
            prev = cur.prev();
        if (prev.hasClass("num")) {
            prev.click();
        }
    });

    /*页码点击*/
    $(".pagebox a.num").click(function() {
        var _this = $(this);
        if (!_this.hasClass("pon")) {
            $.get("Apps?module=Agent&action=noticeList&type=0&page=" + _this.text(), function(result) {
                if(result.err == 1000){
                    var html;
                    $.each(result.msg, function(i,v){
                        html += '<tr><td class="text-left">' + v.title + '</td>\
                                    <td class="enfont">' + (v.is_on == 1 ? '是' : '否') + '</td>\
                                    <td class="enfont">' + v.updatetime + '</td>\
                                    <td class="text-right pop">\
                                        <a href="javascript:;" class="modify">修改</a>\n\
                                        <a href="javascript:;" class="delete">删除</a>\
                                    </td>\
                                    <input type="hidden" value="' + v.id + '">\
                                </tr>';
                    })
                    $("#listtbody").html(html);
                    $(".paging .pon").removeClass("pon");
                    _this.addClass("pon");
                }else{
                    Msg(2,result.msg);
                }
            });
        }
    });

    /*获取公告*/
    // $.get("Apps?module=Gbaopen&action=GetNotice",function(data){
    //     var ue = UE.getEditor('editor');
    //     var data = data.msg;
    //     if(!data.err){
    //         $('.shbox input[name=id]').val(data.id);
    //         $('.shbox input[name=uid]').val(data.uid);
    //         $('.shbox input[name=title]').val(data.title);
    //         if(data.is_on == 1){
    //             $('.shbox input[name=is_on]:eq(0)').attr('checked',true);
    //         } else {
    //             $('.shbox input[name=is_on]:eq(1)').attr('checked',true);
    //         }
    //         ue.addListener("ready", function () {
    //             UE.getEditor('editor').setContent(data.content);
    //         });
    //     }        
    // });

    /*发布公告*/
    $('.Btn1').click(function(){
        var editor = UE.getEditor('editor');
        var data = {};

        data['id'] = $("input[name=id]").val();
        data['uid'] = $("input[name=uid]").val();
        data['content'] = editor.getContent();
        data['title'] = $("input[name=title]").val();
        data['is_on'] = $("input[name=is_on]:checked").val();
        data['type'] = 0;
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

    /*点击修改*/
    $('#listtbody').on('click','.modify',function(){
        $('#edit').addClass("cur");
        $('#edit').siblings().removeClass("cur");
        $('#notice-edit').addClass("cur");
        $('#notice-edit').siblings().removeClass("cur");

        var id = $(this).parent().parent().find('input:hidden').attr('value');

        /*获取公告详细信息*/
        $.get("Apps?module=Gbaopen&action=GetNotice&id="+id,function(data){
            var data = data.msg;
            if(!data.err){
                $('.shbox input[name=id]').val(data.id);
                $('.shbox input[name=uid]').val(data.uid);
                $('.shbox input[name=title]').val(data.title);
                if(data.is_on == 1){
                    $('.shbox input[name=is_on]:eq(0)').attr('checked',true);
                    $('.shbox input[name=is_on]:eq(1)').attr('checked',false);
                } else {
                    $('.shbox input[name=is_on]:eq(0)').attr('checked',false);
                    $('.shbox input[name=is_on]:eq(1)').attr('checked',true);
                }
                // ue.addListener("ready", function () {
                //     UE.getEditor('editor').setContent(data.content);
                // });
                UE.getEditor('editor').setContent(data.content);
            }        
        });
    });

    /*点击删除*/
    $('#listtbody').on('click','.delete',function(){
        if(!confirm('确定删除?')){
            return false;
        }
        var id = $(this).parent().parent().find('input:hidden').attr('value');
        $.post("Apps?module=Gbaopen&action=DelNotice",{id:id},function(result){
            if(result.err == 0){
                alert('删除成功');
                location.reload();
            }else{
                Msg(2, result.msg);
            }
        });
    });

});