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
                url = "Apps?module=Expired&action=GetCus",
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
                        combo  = "",
                        dataNum   = data.cus.length;
                    $.each(data.cus, function (i, v) {
                        switch (v.combo){
                            case '0':
                                combo = '免费';
                                break;
                            case '1':
                                combo = '基础';
                                break;
                            case '2':
                                combo = '普通';
                                break;
                            case '3':
                                combo = '升级';
                                break;
                            case '4':
                                combo = '定制';
                                break;
                        }
                        cuslist += '<tr><!--<td><input type="checkbox" name="ID"></td>-->\
                            <td class="text-left" style="width: 20%;">' + v.CompanyName + '</td>\
                            <td>' + v.Email + '</td>\
                            <td>' + v.UpdateTime + '</td>\
                            <td>' + v.StartTime + '</td>\
                            <td>' + v.EndTime + '</td>\
                            <td>' + combo + '</td>\
                            <input type="hidden" value="' + v.GshowID + '">\
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
            _this.response = $.get("Apps?module=Expired&action=CusInit", function (result) {
                /*操作权限初始化*/
                var operation      = ['--',''];
                result.data.operat = result.data.operat.split(',');
                $.each(result.data.operat, function (i2, v2) {
                    if (v2 == 'delete') {
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
                    $('#export').attr('href','Apps?module=Expired&action=exportData&type='+num);//改变导出数据类型值
                    $(this).addClass("cur").siblings().removeClass();
                    _this.listID = num;
                    if (_this.search != "") {
                        _this.search = "";
                        $("#search1").val("");
                    }
                    _this.onLoad();
                    _this.repStop();
                    _this.response = $.get("Apps?module=Expired&action=GetCusNum&type=" + num, function (result) {
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
                if (_this.search) {
                    _this.onLoad();
                    _this.repStop();
                    _this.response = $.get("Apps?module=Expired&action=GetCusNum&type=-1" + _this.search, function (result) {
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


    /*删除*/
    $('.leftbox ul,#listtbody').on('click', ".delete", function () {
        var cus  = $(this).parent().parent().find('input:hidden').attr('value'),
            html = '<div class="userdata-content"><p style="font-size:20px;">确定删除此客户？</p>\
                    <input type="hidden" class="Input" value="' + cus + '"></div>';
        $(".dialog-content a.dia-ok").addClass('godelete');
        popup(html);
    });


});