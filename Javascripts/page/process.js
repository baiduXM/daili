$(function() {
    $("#tab .tabList ul li").click(function() {
        $("#tab .tabCon > div").removeClass().eq($(this).index()).addClass("cur");
        $(this).addClass("cur").siblings().removeClass("cur");
    });
//     $('#listtbody').on('click',".recharge",function () {
//     var cus = $(this).parent().parent().find('input:hidden').attr('value'),
//     name = $(this).parent().siblings().eq(0).text(),
//     html = '<div class="userdata-content"><p style="font-size:20px;">正在对<span style="color:red;">'+name+'</span>进行充值操作</p>\
//     <p>\
//     <span class="content-l">充值金额：</span>\
//     <span><input type="text" name="recharge" class="Input" value="3000"></span>\
//     </p>\
//     <input type="hidden" class="Input" value="'+cus+'"></div>';
//     $(".dialog-content a.dia-ok").addClass('gorecharge');
//     popup(html);
//     });

    /*删除客服，并检测客服状态*/
    $('#listtbody').on('click', ".delete", function() {
        var cus = $(this).parent().parent().find('input:hidden').attr('value'),
                name = $(this).parent().siblings().eq(0).text(),
                html;
        $.get("Apps?module=Agent&action=SevMsg&num=" + cus, function(result) {
            if (result.err == 0) {
                var option = '';
                if (result.data) {
                    option = '<select class="formstyle" style="width:200px">';
                    $.each(result.data, function(i, v) {
                        option += '<option value="' + i + '">' + v + '</option>';
                    })
                    option += '</select>';
                    option = '<p><span class="content-l">转交对象</span><span>' + option + '</span></p>';
                }
                html = '<div class="userdata-content"><p style="font-size:20px;">确定删除<span style="color:red;">' + name + '</span>？</p>\n\
                            ' + option + '\n\
                            <input type="hidden" class="Input" value="' + cus + '"></div>';
                $(".dialog-content a.dia-ok").addClass('godelete');
                popup(html);
            } else {
                Msg(2, result.msg);
            }
        });
    });
    
    /*修改密码*/
    $('#listtbody').on('click', ".modify", function() {
        var cus = $(this).parent().parent().find('input:hidden').attr('value'),
            name = $(this).parent().siblings().eq(0).text(),
            html;
            html = '<div class="userdata-content"><p style="font-size:20px;"><span style="color:red;">' + name + '</span>密码修改</p>\n\
                        <p><span class="content-l">修改密码：</span><span><input type="password" placeholder="6-16位字符组合" class="Input" name="pwd1" value=""></span></p>\n\
                        <p><span class="content-l">再次确认：</span><span><input type="password" placeholder="6-16位字符组合" class="Input" name="pwd2" value=""></span></p>\n\
                        <input type="hidden" class="Input" value="' + cus + '"></div>';
            $(".dialog-content a.dia-ok").addClass('gomodify');
            popup(html);
    });
    /*充值*/
    $('#listtbody').on('click', ".recharge", function() {
        var cus = $(this).parent().parent().find('input:hidden').attr('value'),
            name = $(this).parent().siblings().eq(0).text(),
            html;
            html = '<div class="userdata-content"><p style="font-size:20px;">正在对<span style="color:red;">'+name+'</span>进行充值操作</p>\n\
                        <p><span class="content-l">充值金额：</span><span><input type="number" name="recharge" min="0" class="Input"value="3000"></span></p>\n\
                        <input type="hidden" class="Input" value="' + cus + '"></div>';
            $(".dialog-content a.dia-ok").addClass('gorecharge');
            popup(html);
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
    /*标签单击*/
    $(".tag span").click(function(){
        $(this).hasClass("cur")?$(this).removeClass("cur"):$(this).addClass("cur");
    })
    /*页码点击*/
    $(".pagebox a.num").click(function() {
        var _this = $(this);
        if (!_this.hasClass("pon")) {
            $.get("Apps?module=Agent&action=GetSevList&page=" + _this.text(), function(result) {
                if(result.err == 0){
                    var html;
                    $.each(result.data.list, function(i,v){
                        html += '<tr><td class="text-left">' + v.name + '</td>\
                                    <td class="enfont">' + (v.tel ? v.tel : '--') + '</td>\
                                    <td class="enfont">' + (v.email ? v.email : '--') + '</td>\
                                    <td><font style="color:#090">' + (v.num ? v.num : 0) + '</font></td>\
                                    <td class="text-right">\
                                        <a href="javascript:;" class="modify">密码修改</a>\n\
                                        ' + (result.data.del ? '<a href="javascript:;" class="delete">删除</a>' : '') + '\
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
    /*开通模块*/
    $("#searchbox").click(function() {
        var search = $("#search1").val()
        if(search){
            $.get("Apps?module=Agent&action=SearchSevList&search=" + search, function(result) {
                if(result.err == 0){
                    var html;
                    $.each(result.data.list, function(i,v){
                        html += '<tr><td class="text-left">' + v.name + '</td>\
                                    <td class="enfont">' + (v.tel ? v.tel : '--') + '</td>\
                                    <td class="enfont">' + (v.email ? v.email : '--') + '</td>\
                                    <td><font style="color:#090">' + (v.num ? v.num : 0) + '</font></td>\
                                    <td class="text-right pop">\
                                        <a href="javascript:;" class="modify">密码修改</a>\
                                        <a href="javascript:;" class="delete">删除</a>\
                                    </td>\
                                    <input type="hidden" value="' + v.id + '">\
                                </tr>';
                    });
                    var pageList = $(".pagebox a.num"),
                        pageNum = pageList.length,
                        s = pageList.length - result.data.pagenum;
                    if(pageList.length > result.data.pagenum){
                        for(var i = 0; i < (pageList.length - result.data.pagenum); i++){
                            pageList.eq(pageList.length - i -1).hide();
                        }
                    }
                    $("#listtbody").html(html);
                }else{
                    Msg(2,result.msg);
                }
            });
        }else{
            Msg(0, '请填写搜索内容');
        }
    });
    //搜索回车事件
    $("Input[id^='search']").on("keypress", function(e){
        if(event.keyCode == "13")    
        {
            $("#searchbox").click();
        }
    });
    
    
    /*权限单击事件*/
    $(".input-wrapper").click(function(){
        var li = $(this);
        if(li.next().length > 0){
            if(li.hasClass("powcur"))
                li.removeClass("powcur");
            else
                li.addClass("powcur");
        }else{
            if(li.hasClass("powcur"))
                $(".input-wrapper").removeClass("powcur");
            else
                $(".input-wrapper").addClass("powcur");
        }
    });

    //客服信息提交
    $('.Btn1').click(function(){
        var input = $('.cur .Input'),
            powList = $(".powList .powcur"),
            powStr='',
            data = {};
        if(powList.length > 0){
            for(var i=0,j=powList.length;i<j;i++){
                if(powList.eq(i).attr("data"))
                    powStr += powList.eq(i).attr("data") + ',';
            }
        }
        data["list"] = powStr;
        for(var i=0,j=input.length;i<j;i++){
            data[input[i].name]=input[i].value;
        }
        if(data.account && data.pwd && data.pwd.length > 5 && data.pwd.length < 17){
            $.post("Apps?module=Agent&action=CreateUser",{userinfo:data},function(result){
                if(result.err == 0){
                    Msg(3, result.msg);
                }else{
                    Msg(2, result.msg);
                }
            });
        }else{
            Msg(1, '账号密码不能为空，且密码为6-16位字母或数字');
        }
    });


    $(".dialog-content a.dia-ok").click(function() {
        var number = $(".userdata-content input[type='hidden']").val();
        if($(this).hasClass("gorecharge")){
            var price = $(".userdata-content input[name='recharge']").val();
            if(!isNaN(price)){
                $.post("Apps?module=Agent&action=Recharge",{num: number, price: price},function(result){
                    if(result.err == 0){
                            Msg(3,result.data.name+"已成功充值");
                        }else{
                            Msg(2,result.msg);
                    }
                });
                $(".dialog-content a.dia-ok").removeClass('gorecharge');
            }else{
                Msg(2,"请正确填写金额");
            }
        }else if ($(this).hasClass("godelete")) {
            var select = $(".userdata-content select").children("option:selected").val();
            $.post("Apps?module=Agent&action=Delete", {num: number, id: select}, function(result) {
                if (result.err == 0) {
                    Msg(3, result.data.name + "已成功删除");
                    window.location.href = window.location.href;
                    $("#listtbody tr>input[value='" + number + "']").parent().remove();
                } else {
                    Msg(2, result.msg);
                }
            });
            $(".dialog-content a.dia-ok").removeClass('godelete');
        }else if ($(this).hasClass("gomodify")) {
            var psd1 = $(".userdata-content input[name='pwd1']").val(),
                psd2 = $(".userdata-content input[name='pwd2']").val();
            if(psd1.length > 5 && psd1.length <17 && psd1 == psd2){
                $.post("Apps?module=Agent&action=Modify", {num: number, data: psd1}, function(result) {
                    if (result.err == 0) {
                        Msg(3, result.msg);
                    } else {
                        Msg(2, result.msg);
                    }
                });
                $(".dialog-content a.dia-ok").removeClass('gomodify');
            }else{
                if(psd1 == psd2)
                    Msg(1, psd1.length < 5 ? '密码不得小于5个字符' : '密码不得大于12个字符');
                else
                    Msg(1, '两次输入的密码不一致');
                return false;
            }
        }
        $('#dialog-overlay, #dialog-box').hide();
        $('#dialog-message').html('');
        return false;
    });
//    $('#testDiv').mousemove(function(e) { 
//        var xx = e.originalEvent.x || e.originalEvent.layerX || 0; 
//        var yy = e.originalEvent.y || e.originalEvent.layerY || 0; 
//        $(this).text(xx + '---' + yy); 
//    }); 
});