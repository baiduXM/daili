jQuery(document).ready(function () {
	/*翻页*/
    var pagelist = function () {
    	/*总共的客户数量*/
        this.allListNum = 1;
        /*页码集合*/
        this.page = $(".pagebox a.num");
        /*页码可达到的最大值*/
        this.pageMax = 1;
        /*当前选择的页码*/
        this.checkPage = 1;
        /*当前已显示出来的最后一个页码*/
        this.showPageLast = 1;
        /*每页数量显示的集合*/
        this.listNum = [];
        /*最多显示的页码数量*/
        this.showPageNum = 5;
        /*判断不同页面的使用*/
        this.type;
        /*控制页面加载的内容*/
        this.listID = 0;
        /*搜索内容存储*/
        this.search = "";
        /*当前页面和总页面显示*/
        this.pageMsg = $(".pagebox .pagemsg");
        /*加载前的时间*/
        this.timeLoad = 0;
        /*加载最短持续时间*/
        this.timeWait = 1000;
        /*计时器*/
        this.timeSave;
        /*请求*/
        this.response;

        /*列表数量按钮点击*/
        this.tonumCheck = function () {
            var _this = this;
            $(".tonum a").click(function (even) {
                if (!$(this).hasClass('current')) {
                    $(this).siblings().removeClass('current');
                    $(this).addClass('current');
                    _this.pageReset();
                    _this.listReset();
                }
            });
        };

        /*加载图标显示*/
        this.onLoad = function (open) {
            open      = open || false;
            var _this = this;
            clearTimeout(_this.timeSave);
            if (open) {
                var time     = Date.parse(new Date()) - _this.timeLoad,
                    timeWait = function () {
                        $(".flower-loader").animate({opacity: 0});
                    };
                if (time > _this.timeWait) {
                    $(".flower-loader").animate({opacity: 0});
                } else {
                    _this.timeSave = setTimeout(timeWait, _this.timeWait);
                }
                _this.timeLoad = 0;
            } else {
                _this.timeLoad = Date.parse(new Date());
                $(".flower-loader").animate({opacity: 1});
            }
        };

        /*ajax请求状态,若上一个请求正在进行，将中止上次请求*/
        this.repStop = function () {
            var _this = this;
            if (_this.response.readyState == 1) {
                _this.response.abort();
                _this.onLoad(true);
            }
        };

        /*页码点击*/
        this.numCheck = function () {
            var _this = this;
            /*页码后滚*/
            $(".pagebox .pagenext").click(function () {
                if (_this.showPageLast < _this.pageMax) {
                    _this.showPageLast++;
                    _this.page.eq(_this.showPageLast - 1).show("slow");
                    _this.page.eq(_this.showPageLast - _this.showPageNum - 1).hide("slow");
                }
            });
            /*页码前滚*/
            $(".pagebox .pageprev").click(function () {
                if ($(".pagebox a.num").index($(".pagebox a.num:visible:first")) > 0) {
                    _this.showPageLast--;
                    _this.page.eq(_this.showPageLast).hide("slow");
                    _this.page.eq(_this.showPageLast - _this.showPageNum).show("slow");
                }
            });
            /*页码数量控制*/
            $(".pagebox a.num").click(function (even) {
                if (!$(this).hasClass('pon')) {
                    if (_this.page.index(this) + 1 <= _this.pageMax) {
                        _this.page.eq(_this.checkPage - 1).removeClass('pon');
                        $(this).addClass('pon');
                        _this.checkPage = _this.page.index(this) + 1;
                        _this.checkPage == _this.showPageLast ? $(".pagebox .pagenext").click() : null;
                        (_this.checkPage == _this.showPageLast - _this.showPageNum + 1) ? $(".pagebox .pageprev").click() : null;
                        _this.pageMsg.text(_this.checkPage + "/" + _this.pageMax);
                        _this.listReset();
                    }
                }
            });
        };

    	/*列表信息*/
        this.listReset = function() {
        	var _this = this,
                url = "Apps?module=Gcard&action=GetCus",
                olistNum = _this.listNum[$(".tonum a").index($(".tonum a.current"))];
            if (_this.timeLoad == 0) {
                _this.onLoad();
            }
            url += "&type=" + _this.listID + "&page=" + _this.checkPage + "&num=" + olistNum + _this.search;
            _this.repStop();
            _this.response = $.get(url , function(result){
                if(result.err == 0) {
                    var data      = result.data;
                    var cuslist   = "",
                        timeList  = "",
                        nameList  = "",
                        oper_each = '',
                        dataNum   = data.cus.length;
                    $.each(data.cus, function (i, v) {
                        oper_each = v.account ? dataInit.operation[1] : dataInit.operation[0];
                        if (v.starttime) {
                            timeList = '<td class="poptip">' + v.starttime + '</td>\
                                        <td class="poptip">' + v.endtime + '</td>';
                        } else {
                            timeList = '<td>--</td><td>--</td>';
                        }

                        nameList = '<td>' + v.account + '</td>';

                        cuslist += '<tr><!--<td><input type="checkbox" name="ID"></td>-->\
                            <td class="text-left"><a href="javascript:;" class="dName modify">' + v.company + '</a></td>\
                            ' + nameList + timeList + '\
                            <td><font style="color:#090">' + v.UserName + '</font></td>\
                            <td class="text-right">' + oper_each + '</td>\
                            <input type="hidden" value="' + v.id + '">\
                        </tr>';
                    });
                    $("#listtbody").hide("slow", function () {
                        $("#listtbody").html(cuslist);
                        $("#listtbody").show("slow");
                    });
                    _this.onLoad(true);
                } else {
                    Msg(2, result.msg);
                }
            });
        }

        /*兼容客户管理列表,对列表数量控制的标签进行初始化*/
        this.msgSet = function () {
            var _this  = this;
            _this.type = $(".pagebox").prev()[0].tagName.toLowerCase() == 'form' ? "tr" : "li";
            _this.onLoad();
            _this.response = $.get("Apps?module=Gcard&action=CusInit", function (result) {
                var place = '<ul class="one"><span>▬▶</span>\n\
                            <li data="0">关闭</li>\n';
                /*操作权限初始化*/
                var operation      = ['--',''];
                result.data.operat = result.data.operat.split(',');
                $.each(result.data.operat, function (i2, v2) {
                    if (v2 == 'renew') {
                        operation[1] += '<a href="javascript:;" class="renew"> 续费 </a>';
                    } else if (v2 == 'process') {
                        operation[1] += '<a href="javascript:;" class="modify"> 信息修改 </a>';
                    } else if (v2 == 'transfer') {
                        operation[1] += '<a href="javascript:;" class="custransfer"> 客户转接 </a>';
                    } else if (v2 == 'manage') {
                        operation[1] += '<a href="javascript:;" class="g-manage"> G名片管理 </a>';
                    } else if (v2 == 'delete') {
                        operation[1] += '<a href="javascript:;" class="delete"> 删除 </a>';
                    }
                });
                result.data.operation = operation;
                dataInit              = result.data;
                _this.allListNum      = dataInit.num == 0 ? 1 : dataInit.num;
                _this.tableLiCheck();
                _this.searchBox();
                _this.listNumLoad();
                _this.pageReset();
                if (dataInit.num > 0) {
                    _this.listReset();
                } else {
                    _this.onLoad(true);
                }
            });
        };

        /*列表为table标签时才进行此操作*/
        this.tableLiCheck = function () {
            var _this = this;
            $(".tabList ul li").click(function () {
                if (!$(this).hasClass('cur')) {
                    var num = parseInt($('.tabList ul li').index(this));
                    $(this).addClass("cur").siblings().removeClass();
                    _this.listID = num;
                    if (_this.search != "") {
                        _this.search = "";
                        $("#search1,#search2,#search3").val("");
                    }
                    _this.onLoad();
                    _this.repStop();
                    _this.response = $.get("Apps?module=Gcard&action=GetCusNum&type=" + num, function (result) {
                        result.data = parseInt(result.data);
                        if (result.data >= 0) {
                            _this.allListNum = result.data == 0 ? 1 : result.data;
                            _this.listNumLoad();
                            if (_this.listNum[$(".tonum a").index($(".tonum a.current"))] == undefined) {
                                $(".tonum a.current").removeClass("current");
                                $(".tonum a").eq(_this.listNum.length - 1).addClass("current");
                            }
                            _this.pageReset();
                            if (result.data > 0) {
                                _this.listReset();
                            } else {
                                $("#listtbody").html("");
                                _this.onLoad(true);
                            }
                        }
                    });
                }
            });
        };

        /*重置编写分页*/
        this.pageReset = function () {
            var _this = this;
            /*最大页码值*/
            _this.pageMax = Math.ceil(_this.allListNum / _this.listNum[$(".tonum a").index($(".tonum a.current"))]);
            /*页码队列如果小于最大的页码，创建新的页码标签，扩充队列，直至最大页码*/
            if (_this.page.length < _this.pageMax) {
                var aOne, has = false;
                aOne          = _this.page.eq(_this.page.length - 1);
                if (aOne.hasClass("pon")) {
                    has = true;
                    aOne.removeClass("pon");
                }
                for (var i = 0; i < _this.pageMax - _this.page.length; i++) {
                    aOne.after(aOne.clone(true).hide().text(_this.pageMax - i));
                }
                has ? aOne.addClass("pon") : '';
                _this.page = $(".pagebox a.num");
            }
            /*当前选中页码如果超过最大页码，重定向到最大页码*/
            if (_this.checkPage > _this.pageMax) {
                _this.page.eq(_this.checkPage - 1).removeClass('pon');
                for (var i = 0; i < _this.pageMax - _this.checkPage; i++) {
                    _this.page.eq(_this.checkPage - 1 - i).hide("slow");
                }
                _this.checkPage = _this.pageMax;
                _this.page.eq(_this.checkPage - 1).addClass('pon');
            }
            /*所有页码先隐藏，获取在页码中展示出来的最后一个页码，根据此页码向前遍历，展示页码*/
            _this.showPageLast = _this.showPageLast > _this.pageMax ? _this.pageMax : _this.showPageLast;
            _this.page.hide("slow");
            for (var i = 0; i < _this.showPageNum; i++) {
                if (_this.showPageLast - i > 0)
                    _this.page.eq(_this.showPageLast - i - 1).show("slow");
                else
                    break;
            }
            /*若向前展示页码小于展示的固定数量，则向后遍历所有页码*/
            if (_this.showPageLast < _this.pageMax) {
                var shownum = $(".pagebox a.num:visible").length;
                if (shownum < _this.showPageNum) {
                    for (var i = 0; i < _this.showPageNum - shownum; i++) {
                        _this.showPageLast++;
                        _this.page.eq(_this.showPageLast - 1).show("slow");
                        if (_this.showPageLast == _this.pageMax || ((shownum + i + 1) == _this.showPageNum))
                            break;
                    }
                }
            }
            _this.pageMsg.text(_this.checkPage + "/" + _this.pageMax);
        };

        /*根据总数量控制页面标签值数量载入*/
        this.listNumLoad = function () {
            var _this   = this,
                tonum   = $(".tonum a"),
                listnum = [];
            for (var i = 0; i < tonum.length; i++) {
                if (Math.ceil(_this.allListNum / $(".tonum a").eq(i).text()) == 1) {
                    tonum.eq(i).show("slow");
                    listnum.push(tonum.eq(i).text());
                    $(".tonum a").eq(i).nextAll().hide("slow");
                    break;
                }
                tonum.eq(i).show("slow");
                listnum.push(tonum.eq(i).text());
            }
            _this.listNum = listnum;
        };

        /*客户管理列表搜索模块*/
        this.searchBox = function () {
            var _this = this;
            $("#searchbox").click(function () {
                _this.search = $("#search1").val() ? "&contact=" + $("#search1").val() : '';
                _this.search += $("#search2").val() ? "&name=" + $("#search2").val() : '';
                _this.search += $("#search3").val() ? "&domain=" + $("#search3").val() : '';
                if (_this.search) {
                    _this.onLoad();
                    _this.repStop();
                    _this.response = $.get("Apps?module=Gcard&action=GetCusNum&type=-1" + _this.search, function (result) {
                        result.data  = parseInt(result.data);
                        _this.listID = -1;
                        $(".tabList ul li").removeClass();
                        _this.allListNum = result.data > 0 ? result.data : 1;
                        _this.listNumLoad();
                        if (_this.listNum[$(".tonum a").index($(".tonum a.current"))] == undefined) {
                            $(".tonum a.current").removeClass("current");
                            $(".tonum a").eq(_this.listNum.length - 1).addClass("current");
                        }
                        _this.pageReset();
                        if (result.data > 0) {
                            _this.listReset();
                        } else {
                            _this.type == 'tr' ? $("#listtbody").html("") : "";
                            _this.onLoad(true);
                        }
                    });
                } else {
                    Msg(0, "搜索内容不能为空，至少填写一项");
                }
            });
            //搜索回车事件
            $("Input[id^='search']").on("keypress", function (e) {
                if (event.keyCode == "13") {
                    $("#searchbox").click();
                }
            });
        };

        /*重要模块加载*/
        this.init = function () {
            this.msgSet();
            this.tonumCheck();
            this.numCheck();
        };
        this.init();
    }();

    /*续费模块*/
    $('.leftbox ul,#listtbody').on('click', ".renew", function () {
        var cus = $(this).parent().parent().find('input:hidden').attr('value');
        $.get("Apps?module=Gcard&action=Operation&type=renew&cus=" + cus, function (result) {
            if (!result.err) {
                $(".dialog-content a.dia-ok").addClass('gorenew');
                var html = '', price,
                    data = result.data;
                html     = '<div class="userdata-content"><p style="font-size:20px;">确定对<strong style="color:red">' + data.name + '</strong>进行续费操作？</p>';
                html += '<p>\
                        <span class="content-l">续费时间</span>\
                        <span>\
                            <select class="formstyle" style="width:200px">\
                                <option value="1">1 - 年</option>\
                                <option value="2">2 - 年</option>\
                                <option value="3">3 - 年</option>\
                                <option value="5">5 - 年</option>\
                                <option value="10">10 - 年</option>\
                            </select>\
                        </span>\
                    </p>\
                    <p>\
                        <span class="content-l">续费到</span>\
                        <span><input type="text" name="endtime" class="Input" disabled="true"></span>\
                        <span class="as"></span>\
                    </p>\
                    <p>\
                        <span class="content-l">将消费金额</span>\
                        <span>\
                            <input type="text" name="money" class="Input" disabled="true">\
                            <input type="hidden" value="' + cus + '">\
                        </span>\
                        <span class="as"></span>\
                    </p>\
                    </div>\
                    <script type="text/javascript">\n\
                    var jsUserdata = function (){\n\
                        theTime=(new Date()).Format("yyyy-MM-dd hh:mm:ss");\n\
                        this.radioCho;\n\
                        this.year\n\
                        ;this.date = "' + data.endtime + '">theTime?"' + data.endtime + '":theTime;\n\
                        ;this.change = function(){\n\
                            var _this = this;\n\
                            $(".userdata-content select").change(function(){\n\
                                _this.year = $(this).children("option:selected").val();\n\
                                _this.reset();\n\
                            });\n\
                        };\n\
                        this.reset = function(){\n\
                            var _this = this;\n\
                            var newprice,newyear;\n\
                            var single_money=600;\n\
                            newyear = new Date(_this.date);\n\
                            newyear.setFullYear(parseInt(newyear.getFullYear())+parseInt(_this.year));\n\
                            newyear = newyear.Format("yyyy-MM-dd hh:mm:ss");\n\
                            $(".userdata-content input[name=\'endtime\']").val(newyear);\n\
                            newprice = single_money * _this.year;\n\
                            $(".userdata-content input[name=\'money\']").val(newprice);\n\
                        }\n\
                        this.init = function(){\n\
                            this.change();\n\
                            $(".userdata-content select").change();\n\
                        },\n\
                        this.init();\n\
                    }();\n\
                    </script>';
                popup(html);
            } else {
                Msg(2, result.msg);
            }
        });
    });

    /*信息修改*/
    $('.leftbox ul,#listtbody').on('click', ".modify", function () {
        var cus = $(this).parent().parent().find('input:hidden').attr('value');
        $.get("Apps?module=Gcard&action=Operation&type=modify&cus=" + cus, function (result) {
            if (!result.err) {
                $(".dialog-content a.dia-ok").addClass('gomodify');
                var data = result.data, html, p = '';
                html     = '<div class="userdata-content"><p style="font-size:20px;">确定对' + data.account + '进行修改信息操作？</p>';
                $.each(data, function (i, v) {
                    if(i!='account'){
                        html += '<p>\
                            <span class="content-l">' + v[0] + '</span>\
                            <span><input type="text" name="' + i + '" class="Input" value="' + v[1] + '"></span>\
                            <span class="as"></span>\
                        </p>';
                    }                    
                });
                html += '<input type="hidden" class="Input" value="' + cus + '"></div>\
                    <script type="text/javascript">\
                    </script>';
                popup(html);
            } else {
                Msg(2, result.msg);
            }
        });
    });

    /*客户转移*/
    $('.leftbox ul,#listtbody').on('click', ".custransfer", function () {
        var cus = $(this).parent().parent().find('input:hidden').attr('value');
        $.get("Apps?module=Gcard&action=Operation&type=transfer&cus=" + cus, function (result) {
            if (!result.err) {
                $(".dialog-content a.dia-ok").addClass('gocustransfer');
                var data = result.data, html, option = '';
                if (data.obj) {
                    option = '<select class="formstyle" style="width:200px">';
                    $.each(data.obj, function (i, v) {
                        option += '<option value="' + i + '">' + v + '</option>';
                    })
                    option += '</select>';
                } else
                    option = '无可转交的对象';
                html = '<div class="userdata-content"><p style="font-size:20px;">确定对' + data.name + '进行修改信息操作？</p>\
                    <p>\
                    <span class="content-l">转交对象</span>\
                    <span>' + option + '</span>\
                    </p>'
                html += '<input type="hidden" class="Input" value="' + cus + '"></div>\
                    <script type="text/javascript">\
                    </script>';
                popup(html);
            } else {
                Msg(2, result.msg);
            }
        });
    });

    /*弹窗数据处理ajax请求*/
    $(".dialog-content a.dia-ok").click(function () {
        var number = $(".userdata-content input[type='hidden']").val();
        if ($(this).hasClass("gorenew")) {
            var year     = $(".userdata-content select").children("option:selected").val(),
                money    = $(".userdata-content input[name='money']").val();
            $.post("Apps?module=Gcard&action=Renew", {
                num: number,
                price: money,
                yearnum: year
            }, function (result) {
                if (!result.err) {
                    Msg(3, result.data.name + "已成功续费修改");
                } else {
                    Msg(2, result.msg);
                }
            });
            $(".dialog-content a.dia-ok").removeClass('gorenew');
        } else if($(this).hasClass("gomodify")) {
            var input = $(".userdata-content input[type!='hidden']"), data = {};
            data.num  = number;
            $.each(input, function (i, v) {
                data[v.name] = v.value;
            })
            $.post("Apps?module=Gcard&action=Modify", data, function (result) {
                if (!result.err) {
                    Msg(3, '账号' + result.data.name + "的信息已成功修改");
                } else {
                    Msg(2, result.msg);
                }
            });
            $(".dialog-content a.dia-ok").removeClass('gomodify');
        } else if ($(this).hasClass("gocustransfer")) {
            var select = $(".userdata-content select").children("option:selected").val();
            if (select != undefined) {
                $.post("Apps?module=Gcard&action=Custransfer", {num: number, id: select}, function (result) {
                    if (!result.err) {
                        Msg(3, result.data.name + "的信息已成功转移");
                        $(".leftbox ul>input[value='" + number + "'],#listtbody tr>input[value='" + number + "']").parent().remove();
                    } else {
                        Msg(2, result.msg);
                    }
                });
            } else {
                Msg(0, "不存在转移对象");
            }
            $(".dialog-content a.dia-ok").removeClass('gocustransfer');
        } else if ($(this).hasClass("godelete")) {
            $.post("Apps?module=Gcard&action=DeleteGcard", {num: number}, function (result) {
                if (!result.err) {
                    Msg(3, result.data.name + "已成功删除");
                } else {
                    Msg(2, result.msg);
                }
            });
            $(".dialog-content a.dia-ok").removeClass('godelete');
        }
        $('#dialog-box').toggle("slow", function () {
            $("#dialog-overlay").slideUp("fast");
        });
        $('#dialog-message').html('');
        return false;
    });

    /*登录G名片*/
    $('.leftbox ul,#listtbody').on('click', ".g-manage", function () {
        var cus = $(this).parent().parent().find('input:hidden').attr('value');
        var url = '?module=Gcard&action=GcardManage';
        window.open(url + '&ID=' + cus, '正在跳转');
    });

    /*删除*/
    $('.leftbox ul,#listtbody').on('click', ".delete", function () {
        var cus  = $(this).parent().parent().find('input:hidden').attr('value'),
            html = '<div class="userdata-content"><p style="font-size:20px;">确定删除此客户？</p>\
                    <input type="hidden" class="Input" value="' + cus + '"></div>';
        $(".dialog-content a.dia-ok").addClass('godelete');
        popup(html);
    });
});