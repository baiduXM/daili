jQuery(document).ready(function() {
    $(".Experience-btn,.Experience").click(function() {
        if ($(".Experience").val() == "是") {
            $(".Experience-btn").animate({"left": "-70px"});
            $(".Experience").removeClass("text-left");
            $(".Experience").addClass("text-right");
            $(".Experience").val("否");
            $("Input[name=stilltime]").parent("span").prev(".content-l").show();
            $("Input[name=stilltime]").parent("span").show();
            $("Input[name=capacity]").parent("span").prev(".content-l").show();
            $("Input[name=capacity]").parent("span").show();
        } else {
            $(".Experience-btn").animate({"left": "-46px"});
            $(".Experience").removeClass("text-right");
            $(".Experience").addClass("text-left");
            $(".Experience").val("是");
            $("Input[name=stilltime]").parent("span").prev(".content-l").hide();
            $("Input[name=stilltime]").parent("span").hide();
            $("Input[name=capacity]").parent("span").prev(".content-l").hide();
            $("Input[name=capacity]").parent("span").hide();
        }
    });
    //优惠券
    $("#Coupons").change(function() {
        var Coupons = $(this).val();
        if (Coupons != '') {
            $.get("index.php", {module: "ApiModel", action: "GetCoupons", code: Coupons},
            function(data) {
                if (data > 0) {
                    $('#CouponsPri').val(data);
                } else if (data == -1) {
                    $('#CouponsPri').val('优惠券已过期');
                } else if (data == -2) {
                    $('#CouponsPri').val('优惠券已使用');
                } else {
                    $('#CouponsPri').val('无此优惠券');
                }
            })
        }
    });

    //客户提交
    $('select#c_customer').change(function() {
        if ($(this).val() == 'new') {
            $("input[type=text]").val("");
            $('input[name=email]').removeAttr("disabled");
            $('.userdata-content').eq(2).hide('slow', function() {
                $('.userdata-content').eq(1).show('slow');
                $('.Btn2').attr('value', '下一页');
                $('.Btn3').attr('value', '创建客户');
            });
            $(".Experience-btn").animate({"left": "-70px"});
            $(".Experience").removeClass("text-left");
            $(".Experience").addClass("text-right");
            $(".Experience").val("否");
            $("Input[name=stilltime]").parent("span").prev(".content-l").show();
            $("Input[name=stilltime]").parent("span").show();
            $("Input[name=capacity]").parent("span").prev(".content-l").show();
            $("Input[name=capacity]").parent("span").show();
        } else {
            $.get("Apps?module=Gbaopen&action=Operation&type=modify&cus=" + $(this).val(), function(result) {
                if (result.err == 0) {
                    var crelist = $('.userdata-content');
                    result = result.data;
                    $.each(result, function(i, v) {
                        if (i == 'remark') {
                            $("textarea[name='remark']").val(v[1]);
                        } else if (i == 'experience') {
                            if (v[1] == "0") {
                                $(".Experience-btn").animate({"left": "-70px"});
                                $(".Experience").removeClass("text-left");
                                $(".Experience").addClass("text-right");
                                $(".Experience").val("否");
                                $("Input[name=stilltime]").parent("span").prev(".content-l").show();
                                $("Input[name=stilltime]").parent("span").show();
                                $("Input[name=capacity]").parent("span").prev(".content-l").show();
                                $("Input[name=capacity]").parent("span").show();
                            } else {
                                $(".Experience-btn").animate({"left": "-46px"});
                                $(".Experience").removeClass("text-right");
                                $(".Experience").addClass("text-left");
                                $(".Experience").val("是");
                                $("Input[name=stilltime]").parent("span").prev(".content-l").hide();
                                $("Input[name=stilltime]").parent("span").hide();
                                $("Input[name=capacity]").parent("span").prev(".content-l").hide();
                                $("Input[name=capacity]").parent("span").hide();
                            }
                        } else {
                            $('input[name=' + i + ']').val(v[1]);
                            if(i == 'email') {
                                if(v[1]) {
                                    $('input[name=email]').attr("disabled", "true");
                                }
                            }
                        }
                    })
                    // $('input[name=email]').attr("disabled", "true");
                    crelist.eq(1).hide('slow', function() {
                        crelist.eq(2).show('slow');
                        $('.Btn2').attr('value', '上一页');
                        $('.Btn3').attr('value', '创建并开通');
                    });
                } else {
                    Msg(2, result.msg);
                }
            });
        }
    });

    //文本框点击复制事件
    $('.crelist textarea .info').click(function() {
        $('.crelist textarea .info').select();
        document.execCommand("Copy");
        alert('已复制！');
    });
    //页面大小初始化
    windowchange();
    
    //模板选择
    $("input[name='pcdomain']").focus(function() {
        var ftp_c = $("input[name='ftp_c']:checked").val();
        if(ftp_c == 1){
            $(this).val("http://" + $("input[name='account']").val() + $("#companyFTP option:selected").attr("content"));
        }        
    });
    $("input[name='mobiledomain']").focus(function() {
        var ftp_c = $("input[name='ftp_c']:checked").val();
        if(ftp_c == 1){
            $(this).val("http://m." + $("input[name='account']").val() + $("#companyFTP option:selected").attr("content"));
        }        
    });
    $("input[type='radio'][name='pc_mobile']").change(function() {
        changetype($(this).val());
    });

    $("input[name='ftp_c']").change(function(){
        $("input[name='pcdomain']").val('');
        $("input[name='mobiledomain']").val('');
    });

    $("#companyFTP").change(function() {
        var pcdomain = $("input[name='pcdomain']").val();
        var mobiledomain = $("input[name='mobiledomain']").val();
        if (/\.5067\.org/.test(pcdomain) && $("input[name='pcdomain']").val() != '') {
            $("input[name='pcdomain']").val("http://" + $("input[name='account']").val() + $("#companyFTP option:selected").attr("content"));
        }
        if (/\.5067\.org/.test(mobiledomain) && $("input[name='mobiledomain']").val() != '') {
            $("input[name='mobiledomain']").val("http://m." + $("input[name='account']").val() + $("#companyFTP option:selected").attr("content"));
        }
    });
    //ftp选择
    $("input[type='radio'][name='ftp_c']").change(function() {
        if ($(this).val() == 1) {
            $("#companyFTP").show();
            $(".ownftp").hide();
            $(".35ftp").hide();
        } else if($(this).val() == 0) {
            $(".ownftp").show();
            $("#companyFTP").hide();
            $(".35ftp").hide();
        } else if($(this).val() == 2){
            $(".35ftp").show();
            $("#companyFTP").hide();
            $(".ownftp").hide();
        }
    });
    $("#companyFTP select").change(function() {
        content = $(this).children('option:selected').attr("content");
        $("#companyFTP span.as").text("需要客户手动以Cname解析到c" + content);
    });
    
    //外域勾选
    $(".crelist .domain input[type='checkbox']").click(function() {
        var _this = $(this);
        if (_this.is(":checked")) {
            if (_this.attr("name") == "outpc_add")
                _this.siblings("textarea.info").val(_this.siblings("textarea.infoblnd").val().replace("$$", $("input[name='mobiledomain']").val())).show();
            else
                _this.siblings("textarea.info").val(_this.siblings("textarea.infoblnd").val().replace("$$", $("input[name='pcdomain']").val())).show();
            _this.siblings("span.as").text("外域域名需要插入左边文本框内的脚本");
        } else {
            _this.siblings("textarea.info").hide();
            _this.siblings("span.as").text("");
        }
    });

    //小程序勾选
    $(".crelist #applets input[type='checkbox']").on('click', function () {
        var _this = $(this);
        if(_this.is(":checked")){
            $("#app_info").show();
            $("#app_info span").show();
        }else {
            $("#app_info").hide();
            $("#app_info input").val('');
        }
    });

    //上下页页面切换
    $('.Btn2').click(function() {
        if ($(this).attr('value') == '下一页') {
            $(this).attr('value', '上一页');
            $('.Btn3').attr('value', '创建并开通');
            $('.userdata-content').eq(1).hide('slow', function() {
                $('.userdata-content').eq(2).show('slow');
            });
        } else {
            $(this).attr('value', '下一页');
            if ($('select#c_customer').val() == 'new')
                $('.Btn3').attr('value', '创建客户');
            $('.userdata-content').eq(2).hide('slow', function() {
                $('.userdata-content').eq(1).show('slow');
            });
        }
    });

    //提交数据初始审核
    $('.Btn3').click(function() {
        var html = '<div class="userdata-content"><p style="font-size:20px;color:red;">请确认下面的信息，一旦创建，不可修改！！！！</p>\n';
        if ($(this).attr('value') == '创建并开通') {

            var applets = $(".crelist #applets input[type='checkbox']");
            var is_checked = applets.is(":checked");
            if(is_checked){
                var AppId = $(".crelist #app_info input[name='AppId']").val();
                var AppSecret = $(".crelist #app_info input[name='AppSecret']").val();
                //var AppletDomainName = $(".crelist #app_info input[name='AppletDomainName']").val();
                if ( AppId == '' ){
                    Msg(1, 'AppId(小程序ID)不能为空');
                    return false;
                }else if (AppSecret == ''){
                    Msg(1, 'AppSecret(小程序秘钥)不能为空');
                    return false;
                }
                /*else if(AppletDomainName == ''){
                    Msg(1, '服务器配置不能为空');
                    return false;
                }*/
            }

            var password=$("input[name='password']").val();
            if(password!=""){
                if(!(/^\w+$/.test(password))){
                    Msg(1, '密码不可使用特殊字符');
                    return false;
                }
            }
            if (/.*[\u4e00-\u9fa5]+.*$/.test($(".userdata-content input[name='account']").val()) || ($(".userdata-content input[name='account']").val() == '')) {
                Msg(1, '账号不能为空或含有中文');
                return false;
            }
            if(/^[a-zA-Z0-9][a-zA-Z0-9-]*[a-zA-Z0-9]$/.test($(".userdata-content input[name='account']").val()) == false){
                Msg(1, '账号只能由数字，字母，分隔号构成。首字符和尾字符只能是数字或字母');
                return false;
            }
            //35开户判断域名总数有没有超过九个
            var ftp = $("input[name=ftp]:checked").val();
            if(ftp == 2){
                var mobile35 = $("input[name=mobiledomain]").val();
                var pc35 = $("input[name=pcdomain]").val();
                var m_length = mobile35.split(",").length;
                var p_length = pc35.split(",").length;
                if(m_length + p_length > 9){
                    Msg(1,'PC站和手机站的域名共计超过九个');
                    return false;
                }
            }
            // html += '<p><span>邮箱地址：</span><span class="major">' + $(".userdata-content input[name='email']").val() + '</span></p>\n';
            var email = $(".userdata-content input[name='email']").val();
            if(email) {
                html += '<p><span>邮箱地址：</span><span class="major">' + email + '</span></p>\n';
            }
            html += '<p><span>客户账号：</span><span class="major">' + $(".userdata-content input[name='account']").val() + '</span></p></div>';
            
            var data = {};
            data["Experience"] = ($(".Experience").val() == "是") ? 1 : 0;
            data["Capacity"] = $(".capacity:checked").val()>0?$(".capacity:checked").val():300;
            data["CPhone"] = $("input[name=pc_mobile]:checked").val();
            data["PC_model"] = $("input[name=pcmodel]").val();
            data["Mobile_model"] = $("input[name=mobilemodel]").val();
            data["PK_model"] = $("input[name=pkmodel]").val();
            data["stilltime"] = $("input[name=stilltime]").val() > 0 ? $("input[name=stilltime]").val() : 1;
            data["coupons"] = $("input[name=coupons]").val()? $("input[name=coupons]").val():"";
            $.ajax({
                    url:"Apps?module=Gbaopen&action=getcost",
                    data:data,
                    async:false,
                    type:"POST",
                    success:function(result) {
                    html += '<p><span>总消费费用：</span><span class="major">￥' + result["price"] + '元</span></p></div>';
                    }
                });
        } else if ($(this).attr('value') == '创建客户') {
            // html += '<p><span>邮箱地址：</span><span class="major">' + $(".userdata-content input[name='email']").val() + '</span></p>\n';
            var email = $(".userdata-content input[name='email']").val();
            if(email) {
                html += '<p><span>邮箱地址：</span><span class="major">' + email + '</span></p>\n';
            }
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
        var text = $("textarea[name='remark']");
        if($('.Btn3').val() == '创建并开通'){
            var cus = $(".crelist .userdata-content").eq(0).find("select").val();
            var ftp = $(".crelist .userdata-content").eq(2).find("select").val();
            input = $("input[type!='submit']");
            $.each(input, function(i, v) {
                if (!(v.checked) && (v.type == 'radio'))
                    return true;
                if (v.type == 'checkbox')
                    data += '"' + v.name + '":"' + v.checked + '",';
                else
                    data += '"' + v.name + '":"' + v.value + '",';
            });

            var applets = $(".crelist #applets input[type='checkbox']");
            var is_checked = applets.is(":checked");
            if (is_checked == true){
                console.log(is_checked+' 是');
                data['is_applets'] = '1';
                data['AppId'] = $(".crelist #app_info input[name='AppId']").val();
                data['AppSecret'] = $(".crelist #app_info input[name='AppSecret']").val();
                //data['AppletDomainName'] = $(".crelist #app_info input[name='AppletDomainName']").val();
            }else {
                console.log(is_checked+' 否');
                data['is_applets'] = '0';
            }

            data += '"type":"cuspro","cus":"' + cus + '","ftp":' + ftp + ',';
        } else if($('.Btn3').val() == '创建客户'){
            input = $(".crelist .userdata-content").eq(1).find("input");
            $.each(input, function(i, v) {
                data += '"' + v.name + '":"' + v.value + '",';
            })
            data += '"type":"cus",';
        } else {
            $('#dialog-box').toggle("slow",function(){
                $("#dialog-overlay").slideUp("fast");
            });
            $('#dialog-message').html('');
            Msg(2, '非法请求');
            return false;
        }
        data += '"' + text.attr('name') + '":"' + text.val() + '"}';
        data = $.parseJSON(data);
        data["experience"] = ($(".Experience").val() == "是") ? 1 : 0;
        data["capacity"] = $(".capacity:checked").val();
        if (!r_num.test(data['tel'])) {
            Msg(1, '您输入的电话号码不正确');
        } else {
            if (data["name"] && data["companyname"] && data["tel"]) {
                Msg(1, '<span>正在处理，请稍等...</span><span class="flower-loader" style="opacity: 1;"></span>');
                $.post("Apps?module=Gbaopen&action=NewCus", data, function(result) {
                    if (result.err == 0) {
                        Msg(3, result.msg);
                    } else {
                        Msg(2, result.msg);
                    }
                });
            } else {
                Msg(1, '公司名称,联系人姓名,联系电话---是必填选项，请检查');
            }
        }
        $('#dialog-box').toggle("slow",function(){
            $("#dialog-overlay").slideUp("fast");
        });
        $('#dialog-message').html('');
    });

    //选择模板时检测是否是换色模板
    $('.modelchoose').on('input propertychange',function(){
        var type = $(this).attr('id');
        if(type == 'pk' || type == 'pc' || type == 'mobile') {
            var id = '#' + type;     
            var id_color = id + '_color';       
            var input = 'input[name=' + type + 'model]';
            var model = $(input).val();
            if(type != 'pk') {
                $(id_color).remove();
            } else {
                $('#pc_color').remove();
                $('#mobile_color').remove(); 
            }
            if(model.length >= 10) {
                $.get('Apps?module=Model&action=checkModel&type=' + type + '&model=' + model, function(result){
                    if(result.err == 1000) {
                        var res = result.data;
                        var html = '';
                        if(res.pc_is) {
                            html += '<p id="pc_color"><span class="content-l">pc颜色</span>\n\
                                    <span class="Input">';
                            $.each(res.pc_color,function(i1,v1){
                                if(i1 == 0) {
                                    html += '<input type="radio" name="pc_color" style="vertical-align:0;" value="'+v1+'" checked><span style="margin:5px 5px 0 2px;width:15px;height:15px;background-color:#'+v1+'"></span>';
                                } else {
                                    html += '<input type="radio" name="pc_color" style="vertical-align:0;" value="'+v1+'"><span style="margin:5px 5px 0 2px;width:15px;height:15px;background-color:#'+v1+'"></span>';
                                }                        
                            });
                            html += '</span></p>';
                        }
                        if(res.mobile_is) {
                            html += '<p id="mobile_color"><span class="content-l">手机颜色</span>\n\
                                    <span class="Input">';
                            $.each(res.mobile_color,function(i2,v2){
                                if(i2 == 0) {
                                    html += '<input type="radio" name="mobile_color" style="vertical-align:0;" value="'+v2+'" checked><span style="margin:5px 5px 0 2px;width:15px;height:15px;background-color:#'+v2+'"></span>';
                                } else {
                                    html += '<input type="radio" name="mobile_color" style="vertical-align:0;" value="'+v2+'"><span style="margin:5px 5px 0 2px;width:15px;height:15px;background-color:#'+v2+'"></span>';
                                }                        
                            });
                            html += '</span></p>';
                        }
                        $(id).after(html);
                    } else {
                        if(type != 'pk') {
                            $(id_color).remove();
                        } else {
                            $('#pc_color').remove();
                            $('#mobile_color').remove(); 
                        }
                    }
                });
            }
        }
    });
});

//类型选择 相应文本框展示
function changetype(num) {
    var m = $(".modelchoose");
    m.hide();
    if (num == 1) {
        $("#pc").show();
        $("#domain_outmobile").show();
        $("#pc").find("span").eq(0).show();
        $("#pc").find("span").eq(1).show();
        $('#mobile_color').remove();
    } else if (num == 2) {
        $("#mobile").show();
        $("#domain_outpc").show();
        $("#mobile").find("span").eq(0).show();
        $("#mobile").find("span").eq(1).show();
        $("#applets").show();
        $("#applets").find("span").eq(0).show();
        $("#applets").find("span").eq(1).show();
        $('#pc_color').remove();
    } else if (num == 3) {
        $("#pc").show();
        $("#mobile").show();
        $("#pc").find("span").eq(0).show();
        $("#pc").find("span").eq(1).show();
        $("#mobile").find("span").eq(0).show();
        $("#mobile").find("span").eq(1).show();
        $("#applets").show();
        $("#applets").find("span").eq(0).show();
        $("#applets").find("span").eq(1).show();
    } else {
        $("#pk").show();
        $("#pc").show().find("span").eq(0).hide();
        $("#pc").find("span").eq(1).hide();
        $("#mobile").show().find("span").eq(0).hide();
        $("#mobile").find("span").eq(1).hide();
        $("#applets").show();
        $("#applets").find("span").eq(0).show();
        $("#applets").find("span").eq(1).show();
        $('#pc_color').remove();
        $('#mobile_color').remove();
    }
}
;

function windowchange() {
    $(".crelist").height($(window).height() - 84);
    $(".crelist").css("overflow-y", "auto");
}