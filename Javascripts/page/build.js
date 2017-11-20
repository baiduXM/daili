jQuery(document).ready(function() {


    //页面大小初始化
    windowchange();

    //提交数据初始审核
    $('.Btn3').click(function() {
        var html = '<div class="userdata-content"><p style="font-size:20px;color:red;">请确认下面的信息，一旦创建，不可修改！！！！</p>\n';
        if ($(this).attr('value') == '创建并开通') {
            if (/.*[\u4e00-\u9fa5]+.*$/.test($(".userdata-content input[name='account']").val()) || ($(".userdata-content input[name='account']").val() == '')) {
                Msg(1, '账号不能为空或含有中文');
                return false;
            }
            if(/^[a-zA-Z0-9][a-zA-Z0-9-]*[a-zA-Z0-9]$/.test($(".userdata-content input[name='account']").val()) == false){
                Msg(1, '账号只能由数字，字母，分隔号构成。首字符和尾字符只能是数字或字母');
                return false;
            }

            html += '<p><span>公司账号：</span><span class="major">' + $(".userdata-content input[name='account']").val() + '</span></p></div>';
            html += '<p><span>总消费费用：</span><span class="major">￥600元</span></p></div>';
        } else {
            Msg(2, '非法请求');
            return false;
        }
        popup(html);
    });
    
    //ajax请求
    $(".dialog-content a.dia-ok").click(function() {
        var data = '{', input;
        var r_let = /^[A-Za-z]+$/, r_num = /^[0-9\-]+$/;
        if($('.Btn3').val() == '创建并开通'){
            // input = $("input[type!='submit']");
            // $.each(input, function(i, v) {
            //     data += '"' + v.name + '":"' + v.value + '",';
            // });
            data += '"account":"' + $("input[name=account]").val() + '",';
            data += '"companyname":"' + $("input[name=companyname]").val() + '",';
            data += '"username":"' + $("input[name=username]").val() + '",';
            data += '"tel":"' + $("input[name=tel]").val() + '",';
            data += '"email":"' + $("input[name=email]").val() + '",';
            data += '"address":"' + $("input[name=address]").val() + '",';
            data += '"starttime":"' + $("input[name=starttime]").val() + '"';
        } else {
            $('#dialog-box').toggle("slow",function(){
                $("#dialog-overlay").slideUp("fast");
            });
            $('#dialog-message').html('');
            Msg(2, '非法请求');
            return false;
        }
        data += '}';
        data = $.parseJSON(data);
        if (!r_num.test(data['tel'])) {
            Msg(1, '您输入的电话号码不正确');
        } else {
            if (data["username"] && data["companyname"] && data["email"] && data["tel"] && data["account"]) {
                Msg(1, '<span>正在处理，请稍等...</span><span class="flower-loader" style="opacity: 1;"></span>');
                $.post("Apps?module=Gcard&action=NewCus", data, function(result) {
                    if (result.err == 0) {
                        Msg(3, result.msg);
                    } else {
                        Msg(2, result.msg);
                    }
                });
            } else {
                Msg(1, '公司账号,公司名称,联系人姓名,联系电话,Email---是必填选项，请检查');
            }
        }
        $('#dialog-box').toggle("slow",function(){
            $("#dialog-overlay").slideUp("fast");
        });
        $('#dialog-message').html('');
    });
});


function windowchange() {
    $(".crelist").height($(window).height() - 84);
    $(".crelist").css("overflow-y", "auto");
}