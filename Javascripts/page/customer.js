jQuery(document).ready(function () {
    var dataInit,
        /*颜色初始化*/
        colorInit = ['white', 'black', 'blue', 'green', 'yellow', 'orange', 'red', 'purple', 'colorful'],
        colorData = {
            white: ['white', '白色'],
            black: ['black', '黑色'],
            blue: ['blue', '蓝色'],
            green: ['green', '绿色'],
            yellow: ['yellow', '黄色'],
            orange: ['orange', '橙色'],
            red: ['red', '红色'],
            purple: ['purple', '紫色'],
            colorful: ['', '彩色']
        };
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
        /*列表信息修改*/
        this.listReset = function () {
            var _this    = this,
                url      = "Apps?module=Gbaopen&action=GetCus",
                olistNum = _this.listNum[$(".tonum a").index($(".tonum a.current"))];
            if (_this.timeLoad == 0) {
                _this.onLoad();
            }
            url += "&type=" + _this.listID + "&page=" + _this.checkPage + "&num=" + olistNum + _this.search;
            _this.repStop();
            _this.response = $.get(url, function (result) {
                if (!result.err) {
                    var data      = result.data;
                    var cuslist   = "",
                        timeList  = "",
                        nameList  = "",
                        oper_each = '',
                        dataNum   = data.cus.length;
                    $.each(data.cus, function (i, v) {
                        if (v.Status == 0) {
                            oper_each = dataInit.operation[2];
                        } else {
                            oper_each = v.name ? dataInit.operation[0] : dataInit.operation[1];
                        }
                        v.name = v.name ? v.name : '--';
                        switch (v.type) {
                            case "1":
                                v.type = 'PC';
                                break;
                            case "2":
                                v.type = '手机';
                                break;
                            case "3":
                                v.type = '套餐';
                                break;
                            case "4":
                                v.type = '双站';
                                break;
                            default:
                                v.type = '--';
                                break;
                        }
                        if (_this.type == 'tr') {
                            if (v.MobileTimeStart && v.PCTimeStart) {
                                timeList = '<td class="poptip">PC：' + v.PCTimeStart + '<div class="popfrm">\
                                                                <b class="phpicn">◆</b>\
                                                                <p>手机：' + v.MobileTimeStart + '</p>\
                                                            </div></td>\
                                            <td class="poptip">PC：' + v.PCTimeEnd + '<div class="popfrm">\
                                                                <b class="phpicn">◆</b>\
                                                                <p>手机：' + v.MobileTimeEnd + '</p>\
                                                            </div></td>';
                            } else {
                                timeList = v.PCTimeStart ? '<td>PC：' + v.PCTimeStart + '</td><td>PC：' + v.PCTimeEnd + '</td>' : v.MobileTimeStart ? '<td>手机:' + v.MobileTimeStart + '</td><td>手机：' + v.MobileTimeEnd + '</td>' : '<td>--</td><td>--</td>';
                            }
                            if (v.agent) {
                                nameList = '<td class="poptip">' + v.name  + '<div class="popfrm">\
                                                                <b class="phpicn">◆</b>\
                                                                <p>所属人员：' + v.agent + '</p>\
                                                            </div></td>';
                                nameList += '<td>' + v.domain + '</td>';
                                nameList += '<td>' + v.fuwu + '</td>';
                            } else {
                                nameList = '<td>' + v.name + '</td>';
                                nameList += '<td>' + v.domain + '</td>';
                                nameList += '<td>' + v.fuwu + '</td>';
                            }
                            cuslist += '<tr><!--<td><input type="checkbox" name="ID"></td>-->\
                                <td class="text-left"><a href="javascript:;" class="dName modify">' + v.company + '</a></td>\
                                ' + nameList + timeList + '\
                                <td><font style="color:#090">' + v.type + '</font></td>\
                                <td>' + ((v.name != '--' && v.type != '--' && v.Status == 1) ? '<div class="cases' + (v.Place == 0 ? '"' : ' place" data="' + v.Place + '"') + '><span>' + v.PlaceName + '</span>' + dataInit.area + '</div>' : '--') + '</td>\
                                <td><font style="color:#090">' + v.agent_username + '</font></td>\
                                <td class="text-right">' + oper_each + '</td>\
                                <input type="hidden" value="' + v.id + '">\
                            </tr>';
                        } else {
                            if (v.MobileTimeStart && v.PCTimeStart) {
                                timeList = '<span class="tab-second poptip">PC：' + v.PCTimeStart + '<div class="popfrm">\
                                                                <b class="phpicn">◆</b>\
                                                                <p>手机：' + v.MobileTimeStart + '</p>\
                                                            </div></span>\
                                            <span class="tab-third poptip">PC：' + v.PCTimeEnd + '<div class="popfrm">\
                                                                <b class="phpicn">◆</b>\
                                                                <p>手机：' + v.MobileTimeEnd + '</p>\
                                                            </div></span>';
                            } else {
                                timeList = v.PCTimeStart ? '<span class="tab-second">PC：' + v.PCTimeStart + '</span><span class="tab-third">PC：' + v.PCTimeEnd + '</span>' : v.MobileTimeStart ? '<span class="tab-second">手机:' + v.MobileTimeStart + '</span><span class="tab-third">手机：' + v.MobileTimeEnd + '</span>' : '<span class="tab-second">--</span><span class="tab-third">--</span>';
                            }
                            cuslist += '<li>\
                                <span class="tab-first"><a href="javascript:;" class="modify">' + v.company + '</a></span>\
                                ' + timeList + '\
                                <span class="tab-four">' + oper_each + '</span>\
                                <input type="hidden" value="' + v.id + '">\
                             </li>';
                        }
                    });
                    if (_this.type == 'tr') {
                        $("#listtbody").hide("slow", function () {
                            $("#listtbody").html(cuslist);
                            $("#listtbody").show("slow");
                        });
                    } else if (_this.type == 'li') {
                        var mhLi = parseInt($(".leftbox ul").css("max-height")),
                            hLi  = parseInt($(".leftbox ul li").css("height"));
                        (mhLi < (hLi * dataNum)) ? $(".leftbox ul").css("overflow-y", "auto") : "";
                        $(".leftbox ul").html(cuslist);
                    }
                    _this.onLoad(true);
                } else {
                    Msg(2, result.msg);
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
                    if(num == 3 || num == 4 || num ==5) {
                        $('#exportExcel').show();
                        $('#exportExcel').attr('href','Apps?module=Gbaopen&action=excel_data&type=' + num);
                    } else {
                        $('#exportExcel').hide();
                        $('#exportExcel').attr('href','#');
                    }
                    if (_this.search != "") {
                        _this.search = "";
                        $("#search1,#search2,#search3").val("");
                    }
                    _this.onLoad();
                    _this.repStop();
                    _this.response = $.get("Apps?module=Gbaopen&action=GetCusNum&type=" + num, function (result) {
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
                                _this.type == 'tr' ? $("#listtbody").html("") : "";
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
                    _this.response = $.get("Apps?module=Gbaopen&action=GetCusNum&type=-1" + _this.search, function (result) {
                        result.data  = parseInt(result.data);
                        _this.listID = -1;
                        $(".tabList ul li").removeClass();
                        $("#exportExcel").hide();
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
        /*兼容客户管理列表,对列表数量控制的标签进行初始化*/
        this.msgSet = function () {
            var _this  = this;
            _this.type = $(".pagebox").prev()[0].tagName.toLowerCase() == 'form' ? "tr" : "li";
            _this.onLoad();
            _this.response = $.get("Apps?module=Gbaopen&action=CusInit&type=" + _this.type, function (result) {
                var place = '<ul class="one"><span>▬▶</span>\n\
                            <li data="0">关闭</li>\n';
                $.each(result.data.area, function (i1, v1) {
                    place += '<li data=' + v1.id + '>' + v1.name;
                    if (v1.child) {
                        place += '<ul class="two">\n<span>▬▶</span>\n';
                        $.each(v1.child, function (i2, v2) {
                            place += '<li data=' + v2.id + '>' + v2.name;
                            if (v2.child) {
                                place += '<ul class="three">\n<span>▬▶</span>\n';
                                $.each(v2.child, function (i3, v3) {
                                    place += '<li data=' + v3.id + '>' + v3.name + '</li>';
                                });
                                place += '</ul>';
                            }
                            place += '</li>';
                        });
                        place += '</ul>';
                    }
                    place += '</li>';
                });
                place += '</ul>';
                /*操作权限初始化*/
                var operation      = ['', '--'];
                result.data.operat = result.data.operat.split(',');
                $.each(result.data.operat, function (i2, v2) {
                    if (v2 == 'renew') {
                        operation[0] += '<a href="javascript:;" class="renew"> 续费 </a>';
                        operation[0] += '<a href="javascript:;" class="morecapacity"> 扩容 </a>';
                    } else if (v2 == 'process') {
                        operation[0] += '<a href="javascript:;" class="processing"> 网站处理 </a>';
                        operation[0] += '<a href="javascript:;" class="sitemove"> 网站迁移 </a>';
                    } else if (v2 == 'transfer')
                        operation[0] += '<a href="javascript:;" class="custransfer"> 客户转接 </a>';
                    else if (v2 == 'manage') {
                        operation[0] += '<a href="javascript:;" class="g-show"> E推 </a>';
                        operation[0] += '<a href="javascript:;" class="g-show-manage"> E推管理 </a>';
                        operation[0] += '<a href="javascript:;" class="g-manage"> 平台管理 </a>';
                        operation[0] += '<a href="javascript:;" class="g-applets"> 小程序打包 </a>';
                    } else if (v2 == 'create')
                        operation[1] = '<a href="javascript:;" class="g-create"> 开通 </a>';
                    else if (v2 == 'delete') {
                        operation[0] += '<a href="javascript:;" class="delete"> 删除 </a>';
                        operation[2] = '<a href="javascript:;" class="reduction"> 还原 </a>';
                    }
                });
                result.data.operation = operation;
                result.data.area      = place;
                dataInit              = result.data;
                _this.allListNum      = dataInit.num == 0 ? 1 : dataInit.num;
                if (_this.type == "tr") {
                    _this.tableLiCheck();
                    _this.searchBox();
                } else {
                    var ulT      = $(".leftbox ul").offset().top,
                        winH     = $(document).height(),
                        pageboxH = $(".pagebox").outerHeight();
                    var ulH      = Math.ceil(winH - ulT - pageboxH - 100);
                    $(".leftbox ul").css("max-height", ulH + 'px');
                    if (dataInit.overdue >= 0) {
                        $(".otherInfo p:first").html("有" + dataInit.overdue + "个域名需要续费，请尽快续费");
                    }
                }
                _this.listNumLoad();
                _this.pageReset();
                if (dataInit.num > 0) {
                    _this.listReset();
                } else {
                    _this.onLoad(true);
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

    /**
     * 小程序打包
     * */
    $(".leftbox ul,#listtbody").on('click', ".g-applets", function (){
        var html = $(this).parent().siblings('.poptip').html();
        var g_name = html.substring(0, html.indexOf('<div')); //截取某个字符前的字符串
        //console.log(g_name);
        var url = 'Apps?module=Gbaopen&action=SmallProgramPackage';
        $.ajax({
            url: url,
            type: 'GET',
            async: false,
            data: {g_name:g_name},
            success: function (data) {
                console.log(data);
                if (data == 1004 ){
                    Msg(1, '此账号未开通小程序');
                    return false;
                }else {
                    // $(this).attr('href', data);
                    var con=  confirm('确定打包下载？');
                   if (con == true){
                       window.location.href = data;
                   }
                }
            }
        });
    });

    //文本框点击复制事件
    $('#dialog-message').on('click', ".info", function () {
        $('#dialog-message .info').select();
        document.execCommand("Copy");
        alert('已复制！');
    });

    /*推荐案例模块*/
    $('.leftbox ul,#listtbody').on('click', ".cases", function () {
        var cases = $(this),
            data  = cases.attr("data") ? cases.attr("data") : 0;
        if (cases.children("ul").is(":hidden")) {
            cases.children("ul").show("slow");
            data == 0 ? cases.children("ul").children("li").show().eq(0).hide() : cases.children("ul").children("li").show();
        } else {
            cases.children("ul").hide("slow");
        }
    });
    $('.leftbox ul,#listtbody').on('click', ".cases li", function (e) {
        e.preventDefault();
        e.stopPropagation();
        var _this    = $(this),
            load     = function (elm) {
                var curelm = $(elm);
                var parelm = curelm.parent().parent(),
                    arr    = [curelm.attr("data")];
                if (parelm[0].tagName.toLowerCase() == 'li') {
                    $.merge(arr, load(parelm));
                } else {
                    arr.push(parelm);
                }
                return arr;
            };
        var data     = load(_this);
        var cases    = $(data.pop());
        var caselist = data;
        data         = caselist[0];
        caselist     = caselist.reverse().join("-");
        if (data.length > 0) {
            var cus  = cases.parent().siblings('input:hidden:last').attr('value');
            var html = '<div class="userdata-content"><input type="hidden" value="' + cus + '" data="' + data + '"><p style="font-size:20px;">';
            $.get("Apps?module=Gbaopen&action=GetCases&num=" + cus, function (result) {
                if (!result.err) {
                    var json = result.data;
                    if (data != 0) {
                        if (json.type > 2) {
                            var colortag = '';
                            var simgurl  = json.pc.img.length == 2 ? '<span class="popfrm" style="top: initial;left: 45px;"><b class="phpicn">◆</b><span><a target="_blank" href="' + json.pc.img[0] + '">如未选择，则默认上次上传的图片：<img src="' + json.pc.img[0] + '" style="width: 100%;"></a></span></span>' : '',
                                imgurl   = json.pc.img.length == 2 ? '<span class="popfrm" style="top: initial;left: 45px;"><b class="phpicn">◆</b><span><a target="_blank" href="' + json.pc.img[1] + '">如未选择，则默认上次上传的图片：<img src="' + json.pc.img[1] + '" style="width: 100%;"></a></span></span>' : '';
                            $.each(colorInit, function (i1, v1) {
                                if (json.pc.color == false) {
                                    colortag += '<span data="' + v1 + '"' + (v1 == 'colorful' ? '' : ' style="background-color:' + colorData[v1][0] + ';"') + '>' + colorData[v1][1] + '</span>';
                                } else {
                                    if ($.inArray(v1, json.pc.color) == -1) {
                                        colortag += '<span data="' + v1 + '"' + (v1 == 'colorful' ? '' : ' style="background-color:' + colorData[v1][0] + ';"') + '>' + colorData[v1][1] + '</span>';
                                    } else {
                                        colortag += '<span data="' + v1 + '" class="cur"' + (v1 == 'colorful' ? '' : ' style="background-color:' + colorData[v1][0] + ';"') + '>' + colorData[v1][1] + '</span>';
                                    }
                                }
                            });
                            var long = '', small = '', mid = '';
                            $.each(dataInit.tag, function (i2, v2) {
                                var cur = json.pc.tag != false ? $.inArray(i2, json.pc.tag) != -1 ? 'class="cur"' : '' : '';
                                if (v2.length > 8) {
                                    long += '<span ' + cur + ' data="' + i2 + '">' + v2 + '</span>';
                                } else if (v2.length < 6) {
                                    small += '<span ' + cur + ' style="width:' + v2.length * 18 + 'px;" data="' + i2 + '">' + v2 + '</span>';
                                } else {
                                    mid += '<span ' + cur + ' data="' + i2 + '">' + v2 + '</span>';
                                }
                            });
                            dataInit.case = json;
                            html += '确定对推荐此客户网站到 ' + _this.text().split('▬')[0] + ' 案例列表？</p>\n\
                                <div id="caseCho1"><span>PC</span><span>手机</span></div>\n\
                                <div id="caseCho2">\n\
                                <p><span class="content-l">上传网站缩略图</span>\n\
                                <span class="poptip"><input type="file" id="simgupload" name="simgfile" />' + simgurl + '</span></p>\n\
                                <p><span class="content-l">上传网站截图</span>\n\
                                <span class="poptip"><input type="file" id="imgupload" name="imgfile" />' + imgurl + '</span>\n\
                                </p><p id="typetag"><span style="vertical-align: top;">网站标签(必填)</span>\n\
                                <span class="tag">' + long + mid + small + '</span></p>\n\
                                <p id="colortag"><span style="vertical-align: top;">颜色标签(必填)</span>\n\
                                <span class="tag">' + colortag + '\n\
                                </span></p>\n\
                                \n</div>\n</div>';
                        } else {
                            if (json.type == 1) {
                                var colortag = '';
                                var simgurl  = json.pc.img.length == 2 ? '<span class="popfrm" style="top: initial;left: 45px;"><b class="phpicn">◆</b><span><a target="_blank" href="' + json.pc.img[0] + '">如未选择，则默认上次上传的图片：<img src="' + json.pc.img[0] + '" style="width: 100%;"></a></span></span>' : '',
                                    imgurl   = json.pc.img.length == 2 ? '<span class="popfrm" style="top: initial;left: 45px;"><b class="phpicn">◆</b><span><a target="_blank" href="' + json.pc.img[1] + '">如未选择，则默认上次上传的图片：<img src="' + json.pc.img[1] + '" style="width: 100%;"></a></span></span>' : '';
                                $.each(colorInit, function (i1, v1) {
                                    if (json.pc.color == false) {
                                        colortag += '<span data="' + v1 + '"' + (v1 == 'colorful' ? '' : ' style="background-color:' + colorData[v1][0] + ';"') + '>' + colorData[v1][1] + '</span>';
                                    } else {
                                        if ($.inArray(v1, json.pc.color) == -1) {
                                            colortag += '<span data="' + v1 + '"' + (v1 == 'colorful' ? '' : ' style="background-color:' + colorData[v1][0] + ';"') + '>' + colorData[v1][1] + '</span>';
                                        } else {
                                            colortag += '<span data="' + v1 + '" class="cur"' + (v1 == 'colorful' ? '' : ' style="background-color:' + colorData[v1][0] + ';"') + '>' + colorData[v1][1] + '</span>';
                                        }
                                    }
                                });
                                var long = '', small = '', mid = '';
                                $.each(dataInit.tag, function (i2, v2) {
                                    var cur = json.pc.tag != false ? $.inArray(i2, json.pc.tag) != -1 ? 'class="cur"' : '' : '';
                                    if (v2.length > 8) {
                                        long += '<span ' + cur + ' data="' + i2 + '">' + v2 + '</span>';
                                    } else if (v2.length < 6) {
                                        small += '<span ' + cur + ' style="width:' + v2.length * 18 + 'px;" data="' + i2 + '">' + v2 + '</span>';
                                    } else {
                                        mid += '<span ' + cur + ' data="' + i2 + '">' + v2 + '</span>';
                                    }
                                });
                            } else {
                                var colortag = '';
                                var simgurl  = json.mobile.img.length == 2 ? '<span class="popfrm" style="top: initial;left: 45px;"><b class="phpicn">◆</b><span><a target="_blank" href="' + json.mobile.img[0] + '">如未选择，则默认上次上传的图片：<img src="' + json.mobile.img[0] + '" style="width: 100%;"></a></span></span>' : '',
                                    imgurl   = json.mobile.img.length == 2 ? '<span class="popfrm" style="top: initial;left: 45px;"><b class="phpicn">◆</b><span><a target="_blank" href="' + json.mobile.img[1] + '">如未选择，则默认上次上传的图片：<img src="' + json.mobile.img[1] + '" style="width: 100%;"></a></span></span>' : '';
                                $.each(colorInit, function (i1, v1) {
                                    if (json.mobile.color == false) {
                                        colortag += '<span data="' + v1 + '"' + (v1 == 'colorful' ? '' : ' style="background-color:' + colorData[v1][0] + ';"') + '>' + colorData[v1][1] + '</span>';
                                    } else {
                                        if ($.inArray(v1, json.mobile.color) == -1) {
                                            colortag += '<span data="' + v1 + '"' + (v1 == 'colorful' ? '' : ' style="background-color:' + colorData[v1][0] + ';"') + '>' + colorData[v1][1] + '</span>';
                                        } else {
                                            colortag += '<span data="' + v1 + '" class="cur"' + (v1 == 'colorful' ? '' : ' style="background-color:' + colorData[v1][0] + ';"') + '>' + colorData[v1][1] + '</span>';
                                        }
                                    }
                                });
                                var long = '', small = '', mid = '';
                                $.each(dataInit.tag, function (i2, v2) {
                                    var cur = json.mobile.tag != false ? $.inArray(i2, json.mobile.tag) != -1 ? 'class="cur"' : '' : '';
                                    if (v2.length > 8) {
                                        long += '<span ' + cur + ' data="' + i2 + '">' + v2 + '</span>';
                                    } else if (v2.length < 6) {
                                        small += '<span ' + cur + ' style="width:' + v2.length * 18 + 'px;" data="' + i2 + '">' + v2 + '</span>';
                                    } else {
                                        mid += '<span ' + cur + ' data="' + i2 + '">' + v2 + '</span>';
                                    }
                                });
                            }
                            html += '确定对推荐此客户网站到 ' + _this.text().split('▬')[0] + ' 案例列表？</p>\n\
                                <p><span class="content-l">上传网站缩略图</span>\n\
                                <span class="poptip"><input type="file" id="simgupload" name="simgfile" />' + simgurl + '</span></p>\n\
                                <p><span class="content-l">上传网站截图</span>\n\
                                <span class="poptip"><input type="file" id="imgupload" name="imgfile" />' + imgurl + '</span>\n\
                                </p><p id="typetag"><span style="vertical-align: top;">网站标签(必填)</span>\n\
                                <span class="tag">' + long + mid + small + '</span></p>\n\
                                <p id="colortag"><span style="vertical-align: top;">颜色标签(必填)</span>\n\
                                <span class="tag">' + colortag + '\n\
                                </span></p>\n\
                                \n</div>\n\
                                <script type="text/javascript">\n\
                                $(".tag span").click(function(){\n\
                                    $(this).hasClass("cur")?$(this).removeClass("cur"):$(this).addClass("cur");\n\
                                })\
                                </script>';
                        }
                    } else {
                        var cho = json.type > 2 ? json.pc.color && json.pc.tag ?
                            '<p>当前已推荐了PC和手机案例,请选择您要关闭的案例</p><p><span class="content-l">关闭的案例：</span><span class="Input"><input type="checkbox" name="caseCho" value="1">PC<input type="checkbox" name="caseCho" value="2">手机</span></p>'
                            : '' : '';
                        html += '确定将此客户网站从案例列表中移除</p><input type="hidden" value="' + cus + '" data="' + data + '">\n\
                                ' + cho + '</div>';
                    }
                    cases.addClass("current");
                    $(".dialog-content a.dia-ok").addClass('goimgupload');
                    popup(html);
                } else {
                    Msg(2, result.msg);
                }
            });
        }
    });

    /*续费模块*/
    $('.leftbox ul,#listtbody').on('click', ".renew", function () {
        var cus = $(this).parent().parent().find('input:hidden').attr('value');
        $.get("Apps?module=Gbaopen&action=Operation&type=renew&cus=" + cus, function (result) {
            if (!result.err) {
                $(".dialog-content a.dia-ok").addClass('gorenew');
                var html = '', price,
                    data = result.data;
                html     = '<div class="userdata-content"><p style="font-size:20px;">确定对<strong style="color:red">' + data.name + '</strong>进行续费操作？</p>';
//                var secTitle = '', radioCho = '';
//                switch (parseInt(data.type)) {
//                    case 4:
//                        if (data.state == 2) {
//                            radioCho += '<input type="radio" name="pc_mobile" value="4" data="' + data.package.youhui + '" checked="checked">双站\
//                                        <input type="radio" name="pc_mobile" data="' + data.pc.youhui + '" time"' + data.pc.time + '" value="1">PC\
//                                        <input type="radio" name="pc_mobile" data="' + data.mobile.youhui + '" time"' + data.mobile.time + '" value="2">手机';
//                            secTitle += '<p>您当前模板是双站模板:<strong style="color:red">' + data.package.name + '</strong>=<strong style="color:red">' + data.pc.name + '</strong>+<strong style="color:red">' + data.mobile.name + '</strong></p>';
//                        } else if (data.state == 1 || data.state == 0) {
//                            secTitle += '双站模板:<strong style="color:red">' + data.package.name + '</strong>';
//                            radioCho += (data.mobile.exist && data.pc.exist) ? '<input type="radio" name="pc_mobile" data="' + (data.pc.youhui + data.mobile.youhui) + '" value="3" checked="checked">双站' : '';
//                            data.pc.exist ? radioCho += '<input type="radio" name="pc_mobile" data="' + data.pc.youhui + '" time"' + data.pc.time + '" value="1">PC' : secTitle += ',PC模板:' + data.pc.name;
//                            data.mobile.exist ? radioCho += '<input type="radio" name="pc_mobile" data="' + data.mobile.youhui + '" time"' + data.mobile.time + '" value="2">手机' : secTitle += ',手机模板:' + data.mobile.name;
//                            secTitle = '<p>您当前选择的' + secTitle + '已变动' + (radioCho ? ',只能进行以下续费操作' : ',无可续费操作') + '</p>';
//                        }
//                        html += secTitle;
//                        break;
//                    case 3:
//                        data.pc.exist ? radioCho += '<input type="radio" name="pc_mobile" data="' + data.pc.youhui + '" value="1">PC' : secTitle += 'PC模板';
//                        data.mobile.exist ? radioCho += '<input type="radio" name="pc_mobile" data="' + data.mobile.youhui + '" value="2">手机' : secTitle += (secTitle ? ',' : '') + '手机模板';
//                        radioCho += (data.mobile.exist && data.pc.exist) ? '<input type="radio" name="pc_mobile" data="' + (data.pc.youhui + data.mobile.youhui) + '" value="3" checked="checked">套餐' : '';
//                        if (secTitle == '') {
//                            html += '<p>您当前模板是套餐模板，PC：<strong style="color:red">' + data.pc.name + '</strong> 手机：<strong style="color:red">' + data.mobile.name + '</strong>，选择您要续费的模板操作</p>';
//                        } else {
//                            secTitle = '<p>您当前选择的' + secTitle + '已变动' + (radioCho ? ',只能进行以下续费操作' : ',无可续费操作') + '</p>';
//                        }
//                        html += secTitle;
//                        break;
//                    case 2:
//                        data.mobile.exist ? radioCho += '<input type="radio" name="pc_mobile" data="' + data.mobile.youhui + '" value="2">手机' : secTitle += '手机模板';
//                        if (secTitle == '') {
//                            html += '<p>您当前模板是手机模板：<strong style="color:red">' + data.mobile.name + '</strong>，选择您要续费的模板操作</p>';
//                        } else {
//                            secTitle = '<p>您当前选择的' + secTitle + '已变动,无可续费操作</p>';
//                        }
//                        html += secTitle;
//                        break;
//                    case 1:
//                        data.pc.exist ? radioCho += '<input type="radio" name="pc_mobile" data="' + data.pc.youhui + '" value="1">PC' : secTitle += 'PC模板';
//                        if (secTitle == '') {
//                            html += '<p>您当前模板是PC模板：<strong style="color:red">' + data.pc.name + '</strong>，选择您要续费的模板操作</p>';
//                        } else {
//                            secTitle = '<p>您当前选择的' + secTitle + '已变动,无可续费操作</p>';
//                        }
//                        html += secTitle;
//                        break;
//                    default:
//                        break;
//                }
                var capa_price = 0;
                if (result.data.capacity == (300 * 1024 * 1024)) {
                    capa_price = 500;
                } else if (result.data.capacity == (500 * 1024 * 1024)) {
                    capa_price = 800;
                } else if (result.data.capacity == (1000 * 1024 * 1024)) {
                    capa_price = 1500;
                } else if (result.data.capacity == (100 * 1024 * 1024)) {
                    capa_price = 300;
                }
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
                        <span class="content-l">续费起始时间</span>\
                        <span class="Input">\
                            <input type="radio" name="time_type" value="0" checked>过期时间\
                            <input type="radio" name="time_type" value="1">当前时间\
                        </span>\
                    </p>\
                    \n\
                    ' + (data.pc.exist && data.mobile.exist ? '<p><span class="content-l">续费类型</span>\
                        <span class="Input">\
                            <input type="radio" name="pm_type" value="3" checked>双站续费\
                            <input type="radio" name="pm_type" value="1">单PC续费\
                            <input type="radio" name="pm_type" value="2">单手机续费\
                        </span>\
                    </p>' : '') + (data.pc.exist ? '<p>\
                        <span class="content-l">PC续费到</span>\
                        <span><input type="text" name="pc_time" class="Input" disabled="true"></span>\
                        <span class="as"></span>\
                    </p>' : '') + (data.mobile.exist ? '<p>\
                        <span class="content-l">手机续费到</span>\
                        <span><input type="text" name="mobile_time" class="Input" disabled="true"></span>\
                        <span class="as"></span>\
                    </p>' : '') + '<p>\n\
                        <span class="content-l">续费空间</span>\
                        <span class="Input">\
                            <input type="radio" name="capacity" class="capacity" data-money="300" value="100">100M\
                            <input type="radio" name="capacity" class="capacity" data-money="500" value="300">300M\
                            <input type="radio" name="capacity" class="capacity" data-money="800" value="500">500M\
                            <input type="radio" name="capacity" class="capacity" data-money="1500" value="1000">1000M\
                        </span>\
                    </p>' + '<p>\
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
                        ;this.pcDate = "' + data.pc.time + '";\n\
                        ;this.mobileDate = "' + data.mobile.time + '";\n\
                        if(this.pcDate == "null" || this.pcDate == "") {\n\
                            this.pcDate = theTime;\n\
                        }\n\
                        if(this.mobileDate == "null" || this.mobileDate == "") {\n\
                            this.mobileDate = theTime;\n\
                        }\n\
                        ;this.change = function(){\n\
                            var _this = this;\n\
                            $(".userdata-content select").change(function(){\n\
                                _this.year = $(this).children("option:selected").val();\n\
                                _this.reset();\n\
                            });\n\
                            $(".userdata-content input:radio[name=\'time_type\']").change(function(){\n\
                                _this.reset();\n\
                            });\n\
                            $(".userdata-content input:radio[name=\'capacity\']").change(function(){\n\
                                _this.reset();\n\
                            });\n\
                            $(".userdata-content input:radio[name=\'pm_type\']").change(function(){\n\
                                _this.reset();\n\
                            });\n\
                        };\n\
                        this.reset = function(){\n\
                            var _this = this;\n\
                            var newprice,newyear;\n\
                            var single_money=$("input:radio[name=\'capacity\']:checked").data("money");\n\
                            var pm_type = $("input:radio[name=\'pm_type\']:checked").val();\n\
                            var time_type = $("input:radio[name=\'time_type\']:checked").val();\n\
                            if(time_type == 0) {\n\
                                this.pcDate = "'+data.pc.time+'";\n\
                                this.mobileDate = "'+data.mobile.time+'";\n\
                                if(this.pcDate == "null" || this.pcDate == "" || this.pcDate == "0000-00-00 00:00:00") {\n\
                                    this.pcDate = theTime;\n\
                                }\n\
                                if(this.mobileDate == "null" || this.mobileDate == "" || this.mobileDate == "0000-00-00 00:00:00") {\n\
                                    this.mobileDate = theTime;\n\
                                }\n\
                            } else if(time_type == 1) {\n\
                                this.pcDate = theTime;\n\
                                this.mobileDate = theTime;\n\
                                if(pm_type == 1) {\n\
                                    this.mobileDate = "'+data.mobile.time+'";\n\
                                } else if(pm_type == 2) {\n\
                                    this.pcDate = "'+data.pc.time+'";\n\
                                }\n\
                            }\n\
                            if( pm_type == 1) {\n\
                                var pc_add_year = _this.year;\n\
                                var mobile_add_year = 0;\n\
                            } else if( pm_type == 2) {\n\
                                var pc_add_year = 0;\n\
                                var mobile_add_year = _this.year;\n\
                            } else {\n\
                                var pc_add_year = _this.year;\n\
                                var mobile_add_year = _this.year;\n\
                            }\n\
                            newyear = new Date(_this.pcDate);\n\
                            newyear.setFullYear(parseInt(newyear.getFullYear())+parseInt(pc_add_year));\n\
                            newyear = newyear.Format("yyyy-MM-dd hh:mm:ss");\n\
                            $(".userdata-content input[name=\'pc_time\']").val(newyear);\n\
                            newyear = new Date(_this.mobileDate);\n\
                            newyear.setFullYear(parseInt(newyear.getFullYear())+parseInt(mobile_add_year));\n\
                            newyear = newyear.Format("yyyy-MM-dd hh:mm:ss");\n\
                            $(".userdata-content input[name=\'mobile_time\']").val(newyear);\n\
                            newprice = single_money * _this.year;\n\
                            $(".userdata-content input[name=\'money\']").val(newprice);\n\
                        }\n\
                        this.init = function(){\n\
                            $(".capacity[value=\'' + result.data.capacity / 1024 / 1024 + '\']").prop("checked", true);\n\
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
        $.get("Apps?module=Gbaopen&action=Operation&type=modify&cus=" + cus, function (result) {
            if (!result.err) {
                $(".dialog-content a.dia-ok").addClass('gomodify');
                var data = result.data, html, p = '';
                html     = '<div class="userdata-content"><p style="font-size:20px;">确定对' + data.name[1] + '进行修改信息操作？</p>';
                $.each(data, function (i, v) {
                    if (i != 'experience') {
                        if (i == 'remark')
                            html += '<p>\
                                    <span class="content-l" style="vertical-align:top">' + v[0] + '</span>\
                                    <textarea name="remark" class="Input" style=" height:100%;"></textarea>\
                                    <span class="as"></span>\
                                </p>';
                        else if (i == 'email') {
                            html += '<p>\
                                    <span class="content-l">' + v[0] + '</span>\
                                    <span><input type="text" name="' + i + '" class="Input" value="' + v[1] + '"' + (v[1] ? ' disabled="true"' : '') +'></span>\
                                    <span class="as">' + (v[1] ? '' : '邮箱填写后不可更改') +'</span>\
                                </p>';
                        } else {
                            html += '<p>\
                                    <span class="content-l">' + v[0] + '</span>\
                                    <span><input type="text" name="' + i + '" class="Input" value="' + v[1] + '"></span>\
                                    <span class="as"></span>\
                                </p>';
                        }
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

    /*客户转移模块*/
    $('.leftbox ul,#listtbody').on('click', ".custransfer", function () {
        var cus = $(this).parent().parent().find('input:hidden').attr('value');
        $.get("Apps?module=Gbaopen&action=Operation&type=transfer&cus=" + cus, function (result) {
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

    /*网站处理模块*/
    $('.leftbox ul,#listtbody').on('click', ".processing", function () {
        var cus = $(this).parent().parent().find('input:hidden').attr('value');
        $.get("Apps?module=Gbaopen&action=Operation&type=process&cus=" + cus, function (result) {
            if (!result.err) {
                $(".dialog-content a.dia-ok").addClass('goprocessing');
                var data        = result.data, html, option = '';
                console.log(data);
                var domainfocus = '';
                if (data.domain_def) {
                    var domain_def = encodeURIComponent(data.domain_def);
                    domain_def     = domain_def.split('.');
                    domain_def[0]  = '';
                    domain_def     = domain_def.join('.');
                    domainfocus    = '<span class="notice">域名解析到：c' + domain_def + '</span>'
                }
                //换色模板片段
                    //PC
                var pc_html = '';
                if(data.pc_is == 1 && data.pcoption) {
                    pc_html += '<p id="pc_color"><span class="content-l">pc颜色</span>\n\
                                <span class="Input">';
                    $.each(data.pcoption,function(i1,v1){
                        if(v1 == data.pccolor) {
                            pc_html += '<input type="radio" name="pc_color" style="vertical-align:0;" value="'+v1+'" checked><span style="margin:5px 5px 0 2px;width:15px;height:15px;background-color:#'+v1+'"></span>';
                        } else {
                            pc_html += '<input type="radio" name="pc_color" style="vertical-align:0;" value="'+v1+'"><span style="margin:5px 5px 0 2px;width:15px;height:15px;background-color:#'+v1+'"></span>';
                        }                        
                    });
                    pc_html += '</span></p>';
                }
                    //手机
                var mobile_html = '';
                if(data.mobile_is == 1 && data.mobileoption) {
                    mobile_html += '<p id="mobile_color"><span class="content-l">手机颜色</span>\n\
                                <span class="Input">';
                    $.each(data.mobileoption,function(i2,v2){
                        if(v2 == data.mobilecolor) {
                            mobile_html += '<input type="radio" name="mobile_color" style="vertical-align:0;" value="'+v2+'" checked><span style="margin:5px 5px 0 2px;width:15px;height:15px;background-color:#'+v2+'"></span>';
                        } else {
                            mobile_html += '<input type="radio" name="mobile_color" style="vertical-align:0;" value="'+v2+'"><span style="margin:5px 5px 0 2px;width:15px;height:15px;background-color:#'+v2+'"></span>';
                        }                        
                    });
                    mobile_html += '</span></p>';
                }
                    //双站
                var pk_html = '';
                if(data.pc_mobile == 4) {
                    pk_html = pc_html + mobile_html;
                }
                var 
                html          = '<div class="userdata-content"><p style="font-size:20px;">确定对' + data.name + '进行修改信息操作？</p>';
                var starttime = data.pc_starttime ? '<p>\
                        <span class="content-l">PC上线时间</span>\
                        <span><input type="text" name="pc_starttime" class="Input" value="' + data.pc_starttime + '"></span>\
                    </p>' : '';
                starttime += data.mobile_starttime ? '<p>\
                        <span class="content-l">手机上线时间</span>\
                        <span><input type="text" name="mobile_starttime" class="Input" value="' + data.mobile_starttime + '"></span>\
                    </p>' : '';
                html += starttime + '<p><span class="content-l">高级定制</span>\
                        <span class="Input">\
                        <input type="radio" name="senior" value="0">关闭\
                        <input type="radio" name="senior" value="1">PC\
                        <input type="radio" name="senior" value="2">手机\
                        <input type="radio" name="senior" value="3">套餐</span>\
                    </p>\
                    <p><span class="content-l">类型选择</span>\
                       <span class="Input">\
                           <input type="radio" name="pc_mobile" value="1">PC\
                           <input type="radio" name="pc_mobile" value="2">手机\
                           <input type="radio" name="pc_mobile" value="3">套餐\
                           <input type="radio" name="pc_mobile" value="4">双站</span>\
                    </p>\
                    <p><span class="content-l">站点类型</span>\
                       <span class="Input">\
                           <input type="radio" name="is_demo" value="0">客户站\
                           <input type="radio" name="is_demo" value="1">模板站\
                    </p>\
                    <p><span class="content-l">栏目自定义</span>\
                       <span class="Input">\
                           <input type="radio" name="column_on" value="1">开启\
                           <input type="radio" name="column_on" value="0">关闭\
                    </p>\
                    <p>\
                        <span class="content-l">中英关联账号</span>\
                        <span><input type="text" name="othercus" class="Input" placeholder="无关联不需填写" value="' + data.othercus + '"></span>\
                    </p>\
                    <p class="modelchoose" id="pc" style="display:none;">\
                       <span class="content-l">pc模板</span>\
                       <span><input type="text" name="pcmodel" class="Input" value="' + data.pcmodel + '"></span>\
                    </p>'+(data.pc_mobile != 4 ? pc_html : '')+'\
                    <p class="modelchoose" id="mobile" style="display:none;">\
                       <span class="content-l">手机模板</span>\
                       <span><input type="text" name="mobilemodel" class="Input" value="' + data.mobilemodel + '"></span>\
                    </p>'+(data.pc_mobile != 4 ? mobile_html : '')+'\
                    <p class="modelchoose" id="pk" style="display:none;">\
                       <span class="content-l">双站模板</span>\
                       <span><input type="text" name="pkmodel" class="Input" value="' + data.pkmodel + '"></span>\
                    </p>'+pk_html+'\
                    <p class="modelchoose" id="domain_pc" style="display:none;">\
                       <span class="content-l">PC域名</span>\
                       <span><input type="text" name="pcdomain" class="Input" value="' + data.pcdomain + '"></span>\n\
                       ' + (domain_def ? data.pcdomain.indexOf(domain_def) == -1 ? '' : domainfocus : '') + '\
                    </p>\
                    <p class="modelchoose" id="domain_mobile" style="display:none;">\
                       <span class="content-l">手机域名</span>\
                       <span><input type="text" name="mobiledomain" class="Input" value="' + data.mobiledomain + '"></span>\
                       ' + (domain_def ? data.pcdomain.indexOf(domain_def) == -1 ? '' : domainfocus : '') + '\
                    </p>\
                    <p class="modelchoose domain" id="domain_outpc">\
                       <input name="outpc_add" type="checkbox"' + (data.pcdomain != 'http://' ? ' checked' : '') + '>\
                       <span class="content-l">外域PC域名</span>\
                       <span><input type="text" name="outpcdomain" class="Input" value="' + (data.pc_out_domain ? data.pc_out_domain : data.pcdomain ?  data.pcdomain : 'http://') + '"></span>\
                        <textarea readonly="readonly" class="info" style="display:none;"></textarea>\
                        <textarea readonly="readonly" class="infoblnd" style="display:none;"><script type="text/javascript">var system ={win : false,mac : false,xll : false,ipad:false};var p = navigator.platform;system.win = p.indexOf("Win") == 0;system.mac = p.indexOf("Mac") == 0;system.x11 = (p == "X11") || (p.indexOf("Linux") == 0);system.ipad = (navigator.userAgent.match(/iPad/i) != null)?true:false;if(system.win||system.mac||system.xll||system.ipad){}else{top.location.href="$$";}<\/script></textarea>\
                        <span class="as"></span>\
                    </p>\
                    <p class="modelchoose domain" id="domain_outmobile">\
                       <input name="outmobile_add" type="checkbox"' + (data.mobiledomain != 'http://' ? ' checked' : '') + '>\
                       <span class="content-l">外域手机域名</span>\
                       <span><input type="text" name="outmobiledomain" class="Input" value="' + (data.mobile_out_domain ? data.mobile_out_domain : data.mobiledomain ? data.mobiledomain : 'http://') + '"></span>\
                       <textarea readonly="readonly" class="info" style="display:none;"></textarea>\
                       <textarea readonly="readonly" class="infoblnd" style="display:none;"><script type="text/javascript"> var system ={ win : false, mac : false, xll : false };  var p = navigator.platform; system.win = p.indexOf("Win") == 0; system.mac = p.indexOf("Mac") == 0; system.x11 = (p == "X11") || (p.indexOf("Linux") == 0); if(system.win||system.mac||system.xll){      top.location.href="$$"; }else{ } <\/script></textarea>\
                       <span class="as">\
                       </span>\
                    </p>\
                    <style>\
                        #app_info .app_css{width: 140px;}\
                        #app_info .app_css em{color: #ff0000;}\
                        #app_info span.pz{color: #ff0000;}\
                        #app_info span.pz span{color: #B4BAC9;}\
                        #app_info span.zc a{color: #4A8BDD;}\
                    </style>\
                     <p class="modelchoose1" id="applets" style="display: '+(data.pc_mobile !=1 ? '' : 'none')+'">\
                        <input type="checkbox" id="is_applets" '+ (data.is_applets != 1 ? '' : 'checked')+' >\
                        <span class="content-l"><label for="is_applets">是否开通小程序</label></span>\
                        <input type="text" id="is_app" name="is_applets" value="'+(data.is_applets != 1 ? '0' : '1')+'" style="display:none;">\
                        <input type="text" id="is_app_old" name="is_app_old" value="'+(data.is_applets != 1 ? '0' : '1')+'" style="display:none;">\
                    </p>\
                    <p class="modelchoose1" id="app_info" style="display:'+(data.is_applets != 1 ? 'none' : 'block')+';">\
                        <span class="content-l app_css"><em>*</em> AppId(小程序ID)</span>\
                        <span><input type="text" name="AppId" class="Input" value="'+(data.AppId ? data.AppId : '' )+'"></span>\
                        <br>\
                        <span class="content-l app_css"><em>*</em> AppSecret(小程序秘钥)</span>\
                        <span><input type="text" name="AppSecret" class="Input" value="'+(data.AppSecret ? data.AppSecret : '' )+'"></span>\
                        <br>\
                        <span class="content-l app_css"><em>*</em> 服务器配置</span>\
                        <span class="pz"><span>小程序域名配置</span>( 请配置为 https://xcx.5067.org )</span>\
                        <br>\
                        <span class="zc"><b>我还没有注册微信小程序</b>&nbsp;<a href="https://mp.weixin.qq.com/" target="_blank">去注册>>></a></span>\
                    </p>';
                /*<span><input type="text" name="AppletDomainName" class="Input" value="'+(data.AppletDomainName ? data.AppletDomainName : '' )+'"></span>\
                 <span class="pz">小程序域名配置</span>\*/
                html += '<input type="hidden" class="Input" value="' + cus + '"></div>\
                    <script type="text/javascript">\
                        var dialogscr = function(){\
                        $("#dialog-message input[type=\'radio\'][name=\'senior\'][value=\'' + data.senior + '\']").attr("checked","true");\
                        $("#dialog-message input[type=\'radio\'][name=\'pc_mobile\'][value=\'' + data.pc_mobile + '\']").attr("checked","true");\
                        $("#dialog-message input[type=\'radio\'][name=\'column_on\'][value=\'' + data.column_on + '\']").attr("checked","true");\
                        $("#dialog-message input[type=\'radio\'][name=\'is_demo\'][value=\'' + data.is_demo + '\']").attr("checked","true");\
                        changetext(' + data.pc_mobile + ', 1);\
                        $("#dialog-message input[type=\'radio\'][name=\'pc_mobile\']").change(function(){changetext($(this).val(), 2)});\
                        $("#dialog-message .domain input[type=\'checkbox\']").click(function(){\
                            if($(this).is(":checked")) {\
                                if($(this).attr("name")=="outpc_add")\
                                        $(this).siblings("textarea.info").val($(this).siblings("textarea.infoblnd").val().replace("$$",$("input[name=\'mobiledomain\']").val()));\
                                else\
                                        $(this).siblings("textarea.info").val($(this).siblings("textarea.infoblnd").val().replace("$$",$("input[name=\'pcdomain\']").val()));\
                                $(this).siblings("textarea.info").show();$(this).siblings(".as").text("外域域名需要插入左方文本框内的脚本");\
                            } else {$(this).siblings("textarea.info").hide();$(this).siblings(".as").text("")}\
                        })}();\
                        \
                        $("#dialog-message #applets input[type=\'checkbox\']").on(\'click\', function () {\
                            var _this = $(this);\
                            if(_this.is(":checked")){\
                                $("#app_info").show();\
                                $("#app_info span").show();\
                                $("#is_app").val("1");\
                            }else {\
                                $("#app_info").hide();\
                                $("#app_info input").val("");\
                                $("#is_app").val("0");\
                            }\
                        });\
                        $("#dialog-message input[type=\'radio\'][name=\'pc_mobile\']").on(\'click\', function() { \
                            var val = $(this).val();\
                            if(val == "1"){\
                                $("#applets").hide();\
                                $("#app_info").hide();\
                                $("#app_info input").val("");\
                                $("#is_app").val("0");\
                            }else {\
                                $("#applets").show();\
                            }\
                         })\
                    </script>';
                popup(html);
            } else {
                Msg(2, result.msg);
            }
        });
    });


    /*开通模块*/
    $('.leftbox ul,#listtbody').on('click', ".g-create", function () {
        var cus              = $(this).parent().parent().find('input:hidden').attr('value');
        window.location.href = '?module=Gbaopen&action=Create&cus=' + cus;
    });

    $('.leftbox ul,#listtbody').on('click', ".delete", function () {
        var cus  = $(this).parent().parent().find('input:hidden').attr('value'),
            html = '<div class="userdata-content"><p style="font-size:20px;">确定删除此客户？</p>\
                    <input type="hidden" class="Input" value="' + cus + '"></div>';
        $(".dialog-content a.dia-ok").addClass('godelete');
        popup(html);
    });
    $('.leftbox ul,#listtbody').on('click', ".reduction", function () {
        var cus  = $(this).parent().parent().find('input:hidden').attr('value'),
            html = '<div class="userdata-content"><p style="font-size:20px;">确定还原此客户？</p>\
                    <input type="hidden" class="Input" value="' + cus + '"></div>';
        $(".dialog-content a.dia-ok").addClass('reduction');
        popup(html);
    });
    $('.leftbox ul,#listtbody').on('click', ".sitemove", function () {
        var option_html = "";
        var cus         = $(this).parent().parent().find('input:hidden').attr('value');
        var fuwuqiid    = 0;
        $.ajax({
            url: "Apps?module=Gbaopen&action=Operation&type=sitemove&cus=" + cus,
            async: false,
            type: "GET",
            dataType: "json",
            success: function (result) {
                if (!result.err) {
                    fuwuqiid = result.data.FuwuqiID;
                } else {
                    Msg(2, result.msg);
                }
            }
        });
        $.ajax({
            url: "Apps?module=Gbaopen&action=getFuwuqi",
            async: false,
            type: "GET",
            dataType: "json",
            success: function (data) {
                var lists = $.parseJSON(data);
                $.each(lists, function (k, v) {
                    if (fuwuqiid != v["ID"]) {
                        option_html += '<option value="' + v["ID"] + '">' + v["FuwuqiName"] + '</option>';
                    }
                });
            }
        });
        var cus  = $(this).parent().parent().find('input:hidden').attr('value'),
            html = '<div class="userdata-content"><p style="font-size:20px;">确定进行客户迁移？</p>\n\
                            <p>\
                                <input type="hidden" class="Input" value="' + cus + '">\
                                <span class="content-l">FTP:</span>\n\
                                <span class="Input">\n\
                                    <input type="radio" name="FTP" value="1" onchange="if($(\'input[name=FTP]:checked\').val()==1){$(\'.FTP_1\').show();$(\'.FTP_0\').hide();$(\'.FTP_2\').hide();}"/>公司FTP\n\
                                    <input type="radio" onchange="if($(\'input[name=FTP]:checked\').val()==0){$(\'.FTP_0\').show();$(\'.FTP_1\').hide();$(\'.FTP_2\').hide();}" name="FTP" value="0" checked/>客户FTP\n\
                                    <input type="radio" onchange="if($(\'input[name=FTP]:checked\').val()==2){$(\'.FTP_2\').show();$(\'.FTP_1\').hide();$(\'.FTP_0\').hide();}" name="FTP" value="2" />35FTP\n\
                                </span>\n\
                            </p>\
                            <div class="FTP_0" style="padding-top: 25px;">\n\
                                <p>\n\
                                    <span class="content-l">FTP地址:</span>\n\
                                    <span>\n\
                                        <input type="text" id="address" name="address" class="Input"/>\n\
                                    </span>\n\
                                </p>\n\
                                <p>\n\
                                    <span class="content-l">FTP用户名:</span>\n\
                                    <span>\n\
                                        <input type="text" id="user" name="user" class="Input"/>\n\
                                    </span>\n\
                                </p>\n\
                                <p>\n\
                                    <span class="content-l">FTP密码:</span>\n\
                                    <span>\n\
                                        <input type="text" id="pwd" name="pwd" class="Input"/>\n\
                                    </span>\n\
                                </p>\n\
                                <p>\n\
                                    <span class="content-l">访问地址:</span>\n\
                                    <span>\n\
                                        <input type="text" id="ftp_url" name="ftp_url" class="Input"/>\n\
                                    </span>\n\
                                </p>\n\
                                <p>\n\
                                    <span class="content-l">FTP端口:</span>\n\
                                    <span>\n\
                                        <input type="text" id="port" name="port" class="Input" value="21"/>\n\
                                    </span>\n\
                                </p>\n\
                                <p>\n\
                                    <span class="content-l">FTP目录:</span>\n\
                                    <span>\n\
                                        <input type="text" id="dir" name="dir" class="Input" value="./www/"/>\n\
                                    </span>\n\
                                </p>\n\
                            </div>\n\
                            <div class="FTP_1" style="display:none;padding-top: 25px;">\n\
                                <span class="content-l">服务器选择:</span>\n\
                                <select class="Input" id="FuwuqiID">' + option_html + '</select>\n\
                            </div>\n\
                            <div class="FTP_2" style="display:none;padding-top: 25px;">\n\
                                <p>\n\
                                    <span class="content-l">FTP用户名:</span>\n\
                                    <span>\n\
                                        <input type="text" id="35user" name="35user" class="Input"/>\n\
                                    </span>\n\
                                </p>\n\
                                <p>\n\
                                    <span class="content-l">FTP密码:</span>\n\
                                    <span>\n\
                                        <input type="text" id="35pwd" name="35pwd" class="Input"/>\n\
                                    </span>\n\
                                </p>\n\
                                <p>\n\
                                    <span class="content-l">手机域名:</span>\n\
                                    <span>\n\
                                        <textarea id="m_url" name="m_url" class="Input" style="height:50px;"/></textarea>\n\
                                    </span>\n\
                                </p>\n\
                            </div>\n\
                            <span style="color:red;">注:迁移成功之后,请重新解析域名</span>\
                        </div>';
        $(".dialog-content a.dia-ok").addClass('sitemove');
        popup(html);
    });

    /*管理模块*/
    $('.leftbox ul,#listtbody').on('click', ".g-manage", function () {
        var cus = $(this).parent().parent().find('input:hidden').attr('value');
        var url = '?module=Gbaopen&action=GbaoPenManage';
        window.open(url + '&ID=' + cus, '正在跳转');
    });
    /**
     * E推管理
     */
    $('.leftbox ul,#listtbody').on('click', ".g-show-manage", function () {
        var cus = $(this).parent().parent().find('input:hidden').attr('value');
        var url = '?module=Gbaopen&action=EtuiManage';
        window.open(url + '&ID=' + cus, '正在跳转');
    });
    /**
     * E推
     */
    $('.leftbox ul,#listtbody').on('click', ".g-show", function () {
        var cus    = $(this).parent().parent().find('input:hidden').attr('value');
        var html   = "";
        var htmljs = "";
        $.ajax({
            url: '/Apps?module=Gbaopen&action=getGshow',
            type: 'POST',
            data: {num: cus},
            async: false,
            success: function (data) {
                // console.log(data);
                if (data.data == false) {
                    html   = '<div class="userdata-content"><p style="font-size:20px;">是否开通该客户E推？</p>\n\
                        <input type="hidden" class="Input" value="' + cus + '">\n\
                            <p>\n\
                                <span class="content-l">套餐:</span>\n\
                                <input class="" name="e-combo" type="radio" data-money="0" value="0" checked/>免费版\n\
                                <input class="" name="e-combo" type="radio" data-money="388" value="1"/>基础版\n\
                                <input class="" name="e-combo" type="radio" data-money="688" value="2"/>普通版\n\
                                <input class="" name="e-combo" type="radio" data-money="1388" value="3"/>升级版\n\
                                <input class="" name="e-combo" type="radio" data-money="0" value="4"/>定制版\n\
                                <input class="Input" style="display: none;" name="e-combo-custom" type="number" min="1" value="" placeholder="输入价格"/>\n\
                            </p>\n\
                            <p>\n\
                                <span class="content-l">年限:</span>\n\
                                <input class="" name="e-year" type="radio" data-years="1" value="1" checked/>1年\n\
                                <input class="" name="e-year" type="radio" data-years="2" value="2"/>2年\n\
                                <input class="" name="e-year" type="radio" data-years="3" value="3"/>3年\n\
                                <input class="" name="e-year" type="radio" data-years="5" value="5"/>5年\n\
                            </p>\n\
                            <p>\n\
                                <span class="content-l">价格:</span>\n\
                                ￥<span class="combo-year-money">0.00</span>\n\
                            </p>\n\
                        </div>';
                    htmljs = '<script type="text/javascript">\n\
                        var year = 1, combo = 0, combo_year_money = 0;\n\
                        $(".userdata-content [name=\'e-combo\']").change(function(){\n\
                            if($(this).val() == 4) {\n\
                                $(".userdata-content [name=\'e-combo-custom\']").show();\n\
                                combo = 0;\n\
                                combo_year_change();\n\
                            }else{\n\
                                $(".userdata-content [name=\'e-combo-custom\']").hide();\n\
                                combo = $(this).data("money");\n\
                                combo_year_change();\n\
                            }\n\
                        });\n\
                        $(".userdata-content [name=\'e-combo-custom\']").focusout(function(){\n\
                            combo = $(this).val();\n\
                            combo_year_change();\n\
                        });\n\
                        $(".userdata-content [name=\'e-year\']").change(function(){\n\
                            year = $(this).data("years");\n\
                            combo_year_change();\n\
                        });\n\
                        $(".userdata-content [name=\'e-year-custom\']").focusout(function(){\n\
                            year = parseInt($(this).val());\n\
                            combo_year_change();\n\
                        });\n\
                        function combo_year_change(){\n\
                            combo_year_money = year * combo;\n\
                            $(".userdata-content .combo-year-money").text(combo_year_money);\n\
                        };\n\
                </script>';
                } else {
                    $(".g-show-manage").prop('display', 'block');
                    html   = '<div class="userdata-content"><p style="font-size:20px;">是否续费该客户E推？</p>\
                        <input type="hidden" class="Input" value="' + cus + '">\n\
                            <p>\n\
                                <span class="content-l">套餐:</span>\n\
                                <input class="" name="e-combo" type="radio" data-money="0" value="0" checked/>免费版\n\
                                <input class="" name="e-combo" type="radio" data-money="388" value="1"/>基础版\n\
                                <input class="" name="e-combo" type="radio" data-money="688" value="2"/>普通版\n\
                                <input class="" name="e-combo" type="radio" data-money="1388" value="3"/>升级版\n\
                                <input class="" name="e-combo" type="radio" data-money="0" value="4"/>定制版\n\
                                <input class="Input" style="display: none;" name="e-combo-custom" type="number" min="1" value="" placeholder="输入价格"/>\n\
                            </p>\n\
                            <p>\n\
                                <span class="content-l">年限:</span>\n\
                                <input class="" name="e-year" type="radio" data-years="1" value="1" checked/>1年\n\
                                <input class="" name="e-year" type="radio" data-years="2" value="2"/>2年\n\
                                <input class="" name="e-year" type="radio" data-years="3" value="3"/>3年\n\
                                <input class="" name="e-year" type="radio" data-years="5" value="5"/>5年\n\
                            </p>\n\
                            <p>\n\
                                <span class="content-l">续费至:</span>\n\
                                <input class="Input date" name="date" type="text" value="" disabled="true"/>\n\
                                ￥<span class="combo-year-money">0.00</span>\n\
                            </p>\n\
                        </div>';
                    htmljs = '<script type="text/javascript">\n\
                        var jsUserdata = function (){\n\
                            var theTime, EndTime, newyear;\n\
                            var year = 1, combo = 0, combo_year_money = 0;\n\
                            theTime = (new Date()).Format("yyyy-MM-dd hh:mm:ss");\n\
                            EndTime = "' + data.data.EndTime + '" > theTime ? "' + data.data.EndTime + '" : theTime;\n\
                            var icombo = ' + data.data.combo + ';\n\
                            $(".userdata-content [name=\'e-combo\']").change(function(){\n\
                                if($(this).val() == 4) {\n\
                                    $(".userdata-content [name=\'e-combo-custom\']").show();\n\
                                    combo = 0;\n\
                                    combo_year_change();\n\
                                }else{\n\
                                    $(".userdata-content [name=\'e-combo-custom\']").hide();\n\
                                    combo = $(this).data("money");\n\
                                    combo_year_change();\n\
                                }\n\
                            });\n\
                            $(".userdata-content [name=\'e-combo-custom\']").focusout(function(){\n\
                                combo = $(this).val();\n\
                                combo_year_change();\n\
                            });\n\
                            $(".userdata-content [name=\'e-year\']").change(function(){\n\
                                year = $(this).data("years");\n\
                                combo_year_change();\n\
                                reset();\n\
                            });\n\
                            function reset(){\n\
                                newyear = new Date(EndTime);\n\
                                newyear.setFullYear(parseInt(newyear.getFullYear())+parseInt(year));\n\
                                newyear = newyear.Format("yyyy-MM-dd hh:mm:ss");\n\
                                $(".userdata-content input[name=\'date\']").val(newyear);\n\
                            };\n\
                            function combo_year_change(){\n\
                                combo_year_money = year * combo;\n\
                                $(".userdata-content .combo-year-money").text(combo_year_money);\n\
                            };\n\
                            function init(){\n\
                                if(icombo == null){\n\
                                    combo = 0;\n\
                                }else{\n\
                                    $(".userdata-content [name=\'e-combo\'][value=\'"+icombo+"\']").prop("checked", "checked");\n\
                                    combo = $(".userdata-content [name=\'e-combo\'][value=\'"+icombo+"\']").data("money");\n\
                                }\n\
                            }\n\
                            init();\n\
                            reset();\n\
                            combo_year_change();\n\
                        }();\n\
                        </script>';
                }
            }
        });
        $(".dialog-content a.dia-ok").addClass('g-show');
        popup(html + htmljs);
    });

    /**
     * 更多容量
     *
     * @param months 剩余有效期
     * @param oldcapacity 当前容量
     */
    function morecapacity(months, oldcapacity) {
        console.log("month:" + months);
        console.log("oldcapacity:" + oldcapacity);
        var old_single_money = ($(".userdata-content input[name='morecapacity'][value='" + oldcapacity + "']").data("money") ?
            $(".userdata-content input[name='morecapacity'][value='" + oldcapacity + "']").data("money") : 0);
        // $(".userdata-content input[name='morecapacity'][value='" + oldcapacity + "']").prop("checked", true);
        $(".userdata-content input[name='morecapacity'][value='" + oldcapacity + "']").parent("span").prevAll().hide();
        // $(".userdata-content input[name='morecapacity']").unbind();
        $(".userdata-content input[name='morecapacity']").unbind().change(function () {
            var new_single_money = $(".userdata-content input[name='morecapacity']:checked").data("money");
            // $(".userdata-content .price").val(((new_single_money - old_single_money) * months / 12).toFixed(0) + "元");
            $(".userdata-content .price").val((new_single_money).toFixed(0) + "元");
            console.log("new_single_money:" + new_single_money);
            console.log("old_single_money:" + old_single_money);
        });
    }

    /*扩容模块*/
    $('.leftbox ul,#listtbody').on('click', ".morecapacity", function () {
        var cus  = $(this).parent().parent().find('input:hidden').attr('value'),
            html = '<div class="userdata-content"><p style="font-size:20px;">确定扩展此客户容量？</p>\
                        <input type="hidden" class="Input" value="' + cus + '">\n\
                            <p>\n\
                                <span class="content-l">空间容量扩展至:</span>\n\
                                <span class="Input">\n\
                                    <span><input type="radio" name="morecapacity" value="100" data-money="300"/>100M</span>\n\
                                    <span><input type="radio" name="morecapacity" value="300" data-money="500"/>300M</span>\n\
                                    <span><input type="radio" name="morecapacity" value="500" data-money="800"/>500M</span>\n\
                                    <span><input type="radio" name="morecapacity" value="1000" data-money="1500"/>1000M</span>\n\
                                </span>\n\
                            </p>\n\
                            <p><span class="content-l">所需费用:</span><input type="text" class="Input price" value="0元" disabled="true"/></p>\
                    </div>';
        $(".dialog-content a.dia-ok").addClass('morecapacity');
        popup(html);
        $.ajax({
            url: "Apps?module=Gbaopen&action=getCusCapacityInfo",
            async: false,
            type: "POST",
            data: {num: cus},
            success: function (result) {
                if (!result.err) {
                    morecapacity(result.months, result.capacity / 1024 / 1024);
                } else {
                    Msg(2, result.msg);
                }
            }
        });
    });
    //案例双站选择效果
    $(".dialog-content").on('click', "#caseCho1 span", function () {
        var _this = this;
        var num   = $(_this).index();
        if ($(_this).css("z-index") != 10) {
            $(_this).css("z-index", "10");
            $("#caseCho1 span").animate({width: 66, borderRadius: 33, left: -35}, function () {
                $(_this).addClass("cur").siblings().css("visibility", "hidden");
                function load() {
                    //加载图标动画
                    $(_this).removeClass("cur");
                    //案例页生成
                    var data                = num == 0 ? dataInit.case.pc : dataInit.case.mobile;
                    var caseType            = num == 0 ? 'PC' : '手机';
                    var colortag = '', html = '';
                    var simgurl             = data.img.length == 2 ? '<span class="popfrm" style="top: initial;left: 45px;"><b class="phpicn">◆</b><span><a target="_blank" href="' + data.img[0] + '">如未选择，则默认上次上传的图片：<img src="' + data.img[0] + '" style="width: 100%;"></a></span></span>' : '',
                        imgurl              = data.img.length == 2 ? '<span class="popfrm" style="top: initial;left: 45px;"><b class="phpicn">◆</b><span><a target="_blank" href="' + data.img[1] + '">如未选择，则默认上次上传的图片：<img src="' + data.img[1] + '" style="width: 100%;"></a></span></span>' : '';
                    $.each(colorInit, function (i1, v1) {
                        if (data.color == false) {
                            colortag += '<span data="' + v1 + '"' + (v1 == 'colorful' ? '' : ' style="background-color:' + colorData[v1][0] + ';"') + '>' + colorData[v1][1] + '</span>';
                        } else {
                            if ($.inArray(v1, data.color) == -1) {
                                colortag += '<span data="' + v1 + '"' + (v1 == 'colorful' ? '' : ' style="background-color:' + colorData[v1][0] + ';"') + '>' + colorData[v1][1] + '</span>';
                            } else {
                                colortag += '<span data="' + v1 + '" class="cur"' + (v1 == 'colorful' ? '' : ' style="background-color:' + colorData[v1][0] + ';"') + '>' + colorData[v1][1] + '</span>';
                            }
                        }
                    });
                    var long = '', small = '', mid = '';
                    $.each(dataInit.tag, function (i2, v2) {
                        var cur = data.tag != false ? $.inArray(i2, data.tag) != -1 ? 'class="cur"' : '' : '';
                        if (v2.length > 8) {
                            long += '<span ' + cur + ' data="' + i2 + '">' + v2 + '</span>';
                        } else if (v2.length < 6) {
                            small += '<span ' + cur + ' style="width:' + v2.length * 18 + 'px;" data="' + i2 + '">' + v2 + '</span>';
                        } else {
                            mid += '<span ' + cur + ' data="' + i2 + '">' + v2 + '</span>';
                        }
                    });
                    html += '<p class="case_type">当前选择的是：<span>' + caseType + '</span></p><p><span class="content-l">上传网站缩略图</span>\n\
                            <span class="poptip"><input type="file" id="simgupload" name="simgfile" />' + simgurl + '</span></p>\n\
                            <p><span class="content-l">上传网站截图</span>\n\
                            <span class="poptip"><input type="file" id="imgupload" name="imgfile" />' + imgurl + '</span>\n\
                            </p><p id="typetag"><span style="vertical-align: top;">网站标签(必填)</span>\n\
                            <span class="tag">' + long + mid + small + '</span></p>\n\
                            <p id="colortag"><span style="vertical-align: top;">颜色标签(必填)</span>\n\
                            <span class="tag">' + colortag + '\n\
                            </span></p><script type="text/javascript">\n\
                                $(".tag span").click(function(){\n\
                                    $(this).hasClass("cur")?$(this).removeClass("cur"):$(this).addClass("cur");\n\
                                })\
                                </script>';
                    $("#caseCho2").html(html);
                    //圆圈扩散动画
                    $(_this).animate(
                        {width: 1000, top: -500, left: -520, height: 1000, borderRadius: 533},
                        function () {
                            //圆圈缩小动画
                            $(_this).animate(
                                {width: 66, top: -66, left: -35, height: 66, borderRadius: 33, opacity: 0},
                                function () {
                                    $("#caseCho1").remove();
                                }
                            );
                            $("#caseCho2").css("visibility", "visible");
                        }
                    );
                }
                ;
                setTimeout(load, 500);
            });
        }
    });

    /*弹窗数据处理ajax请求*/
    $(".dialog-content a.dia-ok").click(function () {
        var number = $(".userdata-content input[type='hidden']").val();
        if ($(this).hasClass("gorenew")) {
            var year     = $(".userdata-content select").children("option:selected").val(),
                capacity = $(".userdata-content input[name='capacity']:checked").val(),
                pm_type = $(".userdata-content input[name='pm_type']:checked").val(),
                time_type = $(".userdata-content input[name='time_type']:checked").val(),
                money    = $(".userdata-content input[name='money']").val();
            $.post("Apps?module=Gbaopen&action=Renew", {
                num: number,
                capacity: capacity,
                pm_type: pm_type,
                time_type: time_type,
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
        } else if ($(this).hasClass("gomodify")) {
            var input = $(".userdata-content input[type!='hidden']"), data = {};
            data.num  = number;
            $.each(input, function (i, v) {
                data[v.name] = v.value;
            })
            $.post("Apps?module=Gbaopen&action=Modify", data, function (result) {
                if (!result.err) {
                    Msg(3, result.data.name + "的信息已成功修改");
                } else {
                    Msg(2, result.msg);
                }
            });
            $(".dialog-content a.dia-ok").removeClass('gomodify');
        } else if ($(this).hasClass("gocustransfer")) {
            var select = $(".userdata-content select").children("option:selected").val();
            if (select != undefined) {
                $.post("Apps?module=Gbaopen&action=Custransfer", {num: number, id: select}, function (result) {
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
        } else if ($(this).hasClass("goprocessing")) {
            var input = $(".userdata-content input[type!='hidden'][type='text']"),
                data  = '{';
            $.each(input, function (i, v) {
                data += '"' + v.name + '":"' + v.value + '",';
            })
            data += '"pc_mobile":"' + $("input[type=\'radio\'][name=\'pc_mobile\']:checked").val() + '",';
            data += '"senior":"' + $("input[type=\'radio\'][name=\'senior\']:checked").val() + '",';
            data += '"column_on":"' + $("input[type=\'radio\'][name=\'column_on\']:checked").val() + '",';
            data += '"is_demo":"' + $("input[type=\'radio\'][name=\'is_demo\']:checked").val() + '",';

            //换色模板选色
            if($('#pc_color').length > 0) {
                data += '"pc_color":"' + $("input[type=\'radio\'][name=\'pc_color\']:checked").val() + '",';
            } else {
                data += '"pc_color":"",';
            }
            if($('#mobile_color').length > 0) {
                data += '"mobile_color":"' + $("input[type=\'radio\'][name=\'mobile_color\']:checked").val() + '",';
            } else {
                data += '"mobile_color":"",';
            }
            
            data += '"outmobile_add":"' + $("input[type=\'checkbox\'][name=\'outmobile_add\']").is(':checked') + '",';
            data += '"outpc_add":"' + $("input[type=\'checkbox\'][name=\'outpc_add\']").is(':checked') + '",';
            data += '"num":' + number + '}';
            data = $.parseJSON(data);
            if($("input[name=\'is_applets\']").val() == 1 && $("input[name=\'is_app_old\']").val() == 0) {
                Msg(1, '<span>开启小程序需要等待一定的时间，请稍等...</span><span class="flower-loader" style="opacity: 1;"></span>');
            }
            $.post("Apps?module=Gbaopen&action=Processing", data, function (result) {
                if (!result.err) {
                    Msg(3, result.data.name + "的网站信息已成功修改");
                } else {
                    Msg(2, result.msg);
                }
            });
            $(".dialog-content a.dia-ok").removeClass('goprocessing');
        } else if ($(this).hasClass("godelete")) {
            $.post("Apps?module=Agent&action=DeleteCustomer", {num: number}, function (result) {
                if (!result.err) {
                    Msg(3, result.data.name + "已成功删除");
                } else {
                    Msg(2, result.msg);
                }
            });
            $(".dialog-content a.dia-ok").removeClass('godelete');
        } else if ($(this).hasClass("reduction")) {
            $.post("Apps?module=Agent&action=reductionCustomer", {num: number}, function (result) {
                if (!result.err) {
                    Msg(3, result.data.name + "已成功还原");
                } else {
                    Msg(2, result.msg);
                }
            });
            $(".dialog-content a.dia-ok").removeClass('reduction');
        } else if ($(this).hasClass("sitemove")) {
            var data    = {};
//            var FTP=$('input[name=FTP]:checked').val();
            data["FTP"] = $('.userdata-content input[name=FTP]:checked').val();
            data["num"] = number;
            if (data["FTP"] == 1) {
                data["FuwuqiID"] = $('.userdata-content #FuwuqiID').val();
            } else if(data["FTP"] == 0) {
                data["address"] = $('.userdata-content #address').val();
                data["user"]    = $('.userdata-content #user').val();
                data["pwd"]     = $('.userdata-content #pwd').val();
                data["ftp_url"] = $('.userdata-content #ftp_url').val();
                data["port"]    = $('.userdata-content #port').val();
                data["dir"]     = $('.userdata-content #dir').val();
            } else if(data["FTP"] == 2){
                data["35user"]    = $('.userdata-content #35user').val();
                data["35pwd"]     = $('.userdata-content #35pwd').val();
                data["m_url"]     = $('.userdata-content #m_url').val();
            }
            Msg(1, '<span>正在处理，请稍等...</span><span class="flower-loader" style="opacity: 1;"></span>');
            $.post("Apps?module=Gbaopen&action=SiteMove", data, function (result) {
                if (!result.err) {
                    Msg(3, result.data.name + "已成功迁移");
                } else {
                    Msg(2, result.msg);
                }
            });
            $(".dialog-content a.dia-ok").removeClass('sitemove');
        } else if ($(this).hasClass("morecapacity")) {
            var data             = {};
            data["morecapacity"] = $('.userdata-content input[name=morecapacity]:checked').val();
            data["num"]          = number;
            Msg(1, '<span>正在处理，请稍等...</span><span class="flower-loader" style="opacity: 1;"></span>');
            $.post("Apps?module=Gbaopen&action=morecapacity", data, function (result) {
                if (!result.err) {
                    Msg(3, result.data.name + "已成功扩容");
                } else {
                    Msg(2, result.msg);
                }
            });
            $(".dialog-content a.dia-ok").removeClass('morecapacity');
        } else if ($(this).hasClass("g-show")) { //===E推提交
            var data      = {};
            data["year"]  = $('.userdata-content [name="e-year"]:checked').val();//开通年限
            data["combo"] = $('.userdata-content [name="e-combo"]:checked').val();//开通版本
            data["money"] = $('.userdata-content .combo-year-money').text();//开通价格
            data["num"]   = number;//？
            Msg(1, '<span>正在处理，请稍等...</span><span class="flower-loader" style="opacity: 1;"></span>');
            $.post("Apps?module=Gbaopen&action=Gshow", data, function (result) {
                if (!result.err) {
                    Msg(3, result.msg);
                } else {
                    Msg(2, result.msg);
                }
            });
            $(".dialog-content a.dia-ok").removeClass('g-show');
        } else if ($(this).hasClass("goimgupload")) {
            var cases    = $("#listtbody .cases.current");
            var area     = $(".userdata-content input[type='hidden']").attr("data");
            var caseType = 0;
            var tag      = '';
            var color    = '';
            if (area == 0) {
                if ($(".userdata-content input[name='caseCho']").length > 0) {
                    if ($(".userdata-content input[name='caseCho']:checked").length != 0) {
                        caseType = $(".userdata-content input[name='caseCho']:checked").length > 1 ? 0 : $(".userdata-content input[name='caseCho']:checked").val();
                    } else {
                        Msg(2, '请选择您要关闭的案例类型');
                        return false;
                    }
                } else
                    caseType = 0;
            } else {
                caseType    = $("#caseCho2 .case_type span");
                caseType    = caseType.length > 0 ? caseType.text() == 'PC' ? 1 : 2 : 0;
                var typetag = $("#typetag .tag span.cur"), typecolor = $("#colortag .tag span.cur");
                if (typetag.length == 0 || typecolor.length == 0) {
                    Msg(1, "<span style=\"color:red;\">网站标签和颜色标签必填</span>");
                    return false;
                }
                for (var i = 0, count = typetag.length; i < count; i++) {
                    tag += $(typetag[i]).attr("data") + ',';
                }
                for (var i = 0, count = typecolor.length; i < count; i++) {
                    color += $(typecolor[i]).attr("data") + ',';
                }
            }
            $.ajaxFileUpload({
                url: 'Apps?module=Gbaopen&action=ComExc', //用于文件上传的服务器端请求地址
                secureuri: false, //是否需要安全协议，一般设置为false
                fileElementId: ['imgupload', 'simgupload'], //文件上传域的ID
                dataType: 'json',
                data: {num: number, areaID: area, color: color, tag: tag, type: caseType},
                success: function (result, status)  //服务器成功响应处理函数
                {
                    if (!result.err) {
                        if (area == 0) {
                            Msg(3, "已成功从案例列表中移除");
                            if (result.data.state) {
                                cases.removeClass("place");
                                cases.children("span").text('关闭');
                                cases.attr("data", area);
                            }
                        } else {
                            Msg(3, "已成功添加进<strong style='color:yellow;margin:0px 5px;'>" + result.data.place + "</strong>案例列表");
                            cases.addClass("place");
                            cases.children("span").text(result.data.place);
                            cases.attr("data", area);
                        }
                    } else {
                        Msg(2, result.msg);
                    }
                },
                error: function (data, status, e)//服务器响应失败处理函数
                {
                    console.log(e);
                }
            });
            cases.removeClass("current");
            cases.children("ul").hide("slow");
            $(".dialog-content a.dia-ok").removeClass('goimgupload');
        }
        $('#dialog-box').toggle("slow", function () {
            $("#dialog-overlay").slideUp("fast");
        });
        $('#dialog-message').html('');
        return false;
    });

    //选择模板时检测是否是换色模板
    $(document).on('input propertychange','.modelchoose',function(){
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

function changetext(num, type) {
    var m = $(".modelchoose");
    m.hide();
    if (num == 1) {
        $("#pc").show();
        $("#domain_pc").show();
        $("#domain_outmobile").show();
        $('#mobile_color').remove();
    }
    else if (num == 2) {
        $("#mobile").show();
        $("#domain_mobile").show();
        $("#domain_outpc").show();
        $('#pc_color').remove();
    }
    else if (num == 3) {
        $("#pc").show();
        $("#mobile").show();
        $("#domain_pc").show();
        $("#domain_mobile").show();
    }
    else {
        $("#pk").show();
        $("#domain_pc").show();
        $("#domain_mobile").show();
        if(type == 2) {
            $('#pc_color').remove();
            $('#mobile_color').remove();
        }
        
    }
    ;
}
;