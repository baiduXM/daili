jQuery(document).ready(function() {
    var     dataInit,
            colorInit = ['white', 'grey', 'black', 'blue', 'green', 'yellow', 'orange', 'pink', 'red', 'purple', 'brown', 'colorful'],
            tjInit = ['关闭', '开启', '首页'],
            colorData = {white: ['white', '白色'], grey: ['grey', '灰色'], black: ['black', '黑色'], blue: ['blue', '蓝色'], green: ['green', '绿色'], yellow: ['yellow', '黄色'], orange: ['orange', '橙色'], pink: ['pink', '粉色'], red: ['red', '红色'], purple: ['purple', '紫色'], brown: ['#804000', '棕色'], colorful: ['', '彩色']};
    /*翻页*/
    var pagelist = function() {
        this.allListNum = 1;    						/*总共的客户数量*/
        this.page = $(".pagebox a.num");					/*页码集合*/
        this.pageMax = 1;                                                       /*页码可达到的最大值*/
        this.checkPage = 1;							/*当前选择的页码*/
        this.showPageLast = 1;  						/*当前已显示出来的最后一个页码*/
        this.listNum = [];							/*每页数量显示的集合*/
        this.showPageNum = 5;							/*最多显示的页码数量*/
        this.modelID;								/*当前选择的模板*/
        this.listID = 1;							/*控制页面加载的内容*/
        this.search = {name:'', url:'', priceL:'', priceT:''};                 /*搜索内容存储*/
        this.pageMsg = $(".pagebox .pagemsg");                                  /*当前页面和总页面显示*/
        this.timeLoad = 0;                                                      /*加载前的时间*/
        this.timeWait = 1000;                                                   /*加载最短持续时间*/
        this.timeSave;                                                          /*计时器*/
        this.response = {readyState: 4};                                      /*ajax请求参数初始化*/
        /*控制列表数量点击*/
        this.tonumCheck = function() {
            var _this = this;
            $(".tonum a").click(function(even) {
                if (!$(this).hasClass('current')) {
                    $(this).siblings().removeClass('current');
                    $(this).addClass('current');
                    _this.pageReset();
                    _this.listReset();
                }
            });
        };
        /*加载动画*/
        this.onLoad = function(show) {
            show = show || false;
            var _this = this;
            clearTimeout(_this.timeSave);
            if (show) {
                var time = Date.parse(new Date()) - _this.timeLoad,
                        timeWait = function() {
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
        /*中止请求*/
        this.repStop = function() {
            var _this = this;
            if (_this.response.readyState == 1) {
                _this.response.abort();
                _this.onLoad(true);
            }
        };
        /*页码点击*/
        this.numCheck = function() {
            var _this = this;
            /*页码后滚*/
            $(".pagebox .pagenext").click(function() {
                if (_this.showPageLast < _this.pageMax) {
                    _this.showPageLast++;
                    _this.page.eq(_this.showPageLast - 1).show("slow");
                    _this.page.eq(_this.showPageLast - _this.showPageNum - 1).hide("slow");
                }
            });
            /*页码前滚*/
            $(".pagebox .pageprev").click(function() {
                if ($(".pagebox a.num").index($(".pagebox a.num:visible:first")) > 0) {
                    _this.showPageLast--;
                    _this.page.eq(_this.showPageLast).hide("slow");
                    _this.page.eq(_this.showPageLast - _this.showPageNum).show("slow");
                }
            });
            /*页码数量控制*/
            $(".pagebox a.num").click(function(even) {
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
        this.listReset = function() {
            var _this = this,
                    url = "Apps?module=Model&action=GetModelList",
                    olistNum = _this.listNum[$(".tonum a").index($(".tonum a.current"))],
                    search = '';
            if (_this.timeLoad == 0) {
                _this.onLoad();
            }
            search += _this.search.name ? "&name=" + _this.search.name : '';
            search += _this.search.url ? "&url=" + _this.search.url : '';
            search += _this.search.priceL ? "&priceL=" + _this.search.priceL : '';
            search += _this.search.priceT ? "&priceT=" + _this.search.priceT : '';
            url += "&type=" + _this.listID + "&page=" + _this.checkPage + "&num=" + olistNum + search;
            _this.repStop();
            _this.response = $.get(url, function(result) {
                if (result.err == 0) {
                    var data = result.data;
                    var modelList = "";
                    $.each(data.list, function(i, v) {
                        v.youhui = v.youhui ? v.youhui : 0;
                        v.price = v.price ? v.price : 0;
                        modelList += '<tr><!--<td><input type="checkbox" name="ID"></td>-->\
                                <td class="text-left"><a href="javascript:;" class="dName modify">' + v.name + '</a></td>\
                                <td class="poptip"><font class="orange"><a href="' + v.url[0] + '" target="_blank">' + v.url[0] + '</a></font>' + (v.url[1] ? '<div class="popfrm"><b class="phpicn">◆</b><p>' + v.url[1] + '</p></div>' : '') + '</td>\
                                <td class="poptip">' + v.youhui + '<div class="popfrm"><b class="phpicn">◆</b><p class="strickout">' + v.price + '</p></div></td>'
                                +(_this.listID!=3?('<td class="devname">' + v.devname + '</td>'):'')+
                                '<td><div class="cases ' + (v.tuijian == 0 ? '' : 'place" data="' + v.tuijian) + '"><span>' + tjInit[v.tuijian] + '</span><ul class="one"><span>▬▶</span>\
                                    <li data="0">' + tjInit[0] + '</li><li data="1">' + tjInit[1] + '</li><li data="2">' + tjInit[2] + '</li></ul></div></td>\
                                <td class="text-right"><a href="javascript:;" class="process"> 模板处理 </a>'+((_this.listID==1||_this.listID==2)?'<a href="/?module=Model&action=LoadTpl&name='+v.name+'" class="loadtemplate"> 模板下载 </a>':'')+'</td>\
                                <input type="hidden" value="' + v.id + '">\
                            </tr>';
                    });
                    $("#listtbody").hide("slow", function() {
                        $("#listtbody").html(modelList);
                        $("#listtbody").show("slow");
                    });
                    if(_this.listID==3){
                        $(".devname").hide();
                    }else{
                        $(".devname").show();
                    }
                    _this.onLoad(true);
                } else {
                    Msg(2, result.msg);
                }
            });
        };
        /*列表为table标签时才进行此操作*/
        this.tableLiCheck = function() {
            var _this = this;
            $(".tabList ul li").click(function() {
                if (!$(this).hasClass('cur')) {
                    var num = parseInt($('.tabList ul li').index(this)) + 1,
                        search = '';
                    $(this).addClass("cur").siblings().removeClass();
                    _this.listID = num;
                    _this.onLoad();
                    _this.repStop();
                    search += _this.search.name ? "&name=" + _this.search.name : '';
                    search += _this.search.url ? "&url=" + _this.search.url : '';
                    search += _this.search.priceL ? "&priceL=" + _this.search.priceL : '';
                    search += _this.search.priceT ? "&priceT=" + _this.search.priceT : '';
                    _this.response = $.get("Apps?module=Model&action=GetModelNum&type=" + _this.listID + search, function(result) {
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
        this.pageReset = function() {
            var _this = this;
            _this.pageMax = Math.ceil(_this.allListNum / _this.listNum[$(".tonum a").index($(".tonum a.current"))]);
            if (_this.page.length < _this.pageMax) {
                var aOne, has = false;
                aOne = _this.page.eq(_this.page.length - 1);
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
            if (_this.checkPage > _this.pageMax) {
                _this.page.eq(_this.checkPage - 1).removeClass('pon');
                for (var i = 0; i < _this.pageMax - _this.checkPage; i++) {
                    _this.page.eq(_this.checkPage - 1 - i).hide("slow");
                }
                _this.checkPage = _this.pageMax;
                _this.page.eq(_this.checkPage - 1).addClass('pon');
            }
            _this.showPageLast = _this.showPageLast > _this.pageMax ? _this.pageMax : _this.showPageLast;
            _this.page.hide("slow");
            for (var i = 0; i < _this.showPageNum; i++) {
                if (_this.showPageLast - i > 0)
                    _this.page.eq(_this.showPageLast - i - 1).show("slow");
                else
                    break;
            }
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
        /*控制页面标签值数量载入*/
        this.listNumLoad = function() {
            var _this = this,
                    tonum = $(".tonum a"),
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
        /*模块响应*/
        this.modelBox = function(){
            var _this = this;
            $('#listtbody').on('click', ".process", function() {
                _this.modelID = $(this).parent().parent().find('input:hidden').attr('value');
                _this.onLoad();
                _this.repStop();
                _this.response = $.get("Apps?module=Model&action=Operation&cmd=process&num=" + _this.modelID + "&type=" + _this.listID, function(result) {
                    if (result.err == 0) {
                        var data = result.data,
                            target,
                            url,
                            html = '<div class="userdata-content"><p style="font-size:20px;">确定对' + data.name + '进行修改信息操作？</p>';
                            var long = '', small = '', mid = '', tag = data.tag ? data.tag.split(',') : false, color = data.color ? data.color.split(',') : false, colortag = '';
                            $.each(dataInit.tag, function(i2, v2) {
                                var cur = tag != false ? $.inArray(i2, tag) != -1 ? 'class="cur"' : '' : '';
                                if (v2.length > 8) {
                                    long += '<span ' + cur + ' data="' + i2 + '">' + v2 + '</span>';
                                } else if (v2.length < 6) {
                                    small += '<span ' + cur + ' style="width:' + v2.length * 18 + 'px;" data="' + i2 + '">' + v2 + '</span>';
                                } else {
                                    mid += '<span ' + cur + ' data="' + i2 + '">' + v2 + '</span>';
                                }
                            });
                            $.each(colorInit, function(i1, v1) {
                                if (data.color == false) {
                                    colortag += '<span data="' + v1 + '"' + (v1 == 'colorful' ? '' : ' style="background-color:' + colorData[v1][0] + ';"') + '>' + colorData[v1][1] + '</span>';
                                } else {
                                    if ($.inArray(v1, color) == -1) {
                                        colortag += '<span data="' + v1 + '"' + (v1 == 'colorful' ? '' : ' style="background-color:' + colorData[v1][0] + ';"') + '>' + colorData[v1][1] + '</span>';
                                    } else {
                                        colortag += '<span data="' + v1 + '" class="cur"' + (v1 == 'colorful' ? '' : ' style="background-color:' + colorData[v1][0] + ';"') + '>' + colorData[v1][1] + '</span>';
                                    }
                                }
                            });
                            if(_this.listID == 3){
                                url = '<p><span>PC URL：</span><span><input type="text" name="pc_url" class="Input" value="' + data.pc_url + '"></span></p>';
                                url += '<p><span>手机 URL：</span><span><input type="text" name="mobile_url" class="Input" value="' + data.mobile_url + '"></span></p>';
                            }else{
                                url = '<p><span>URL：</span><span><input type="text" name="url" class="Input" value="' + data.url + '"></span></p>';
                            }
                            html += '<p><span>市场价</span>\n\
                                <span><input type="text" name="mPrice" class="Input" value="' + data.price + '"></span></p>\n\
                                <p><span>优惠价</span>\n\
                                <span><input type="text" name="yPrice" class="Input" value="' + data.youhui + '"></span></p>\n\
                                ' + url + '\n\
                                <p id="typetag"><span style="vertical-align: top;">网站标签(必填)</span>\n\
                                    <span class="tag">' + long + mid + small + '</span></p>\n\
                                <p id="colortag"><span style="vertical-align: top;">颜色标签(必填)</span>\n\
                                    <span class="tag">' + colortag + '\n\
                                    </span></p>\n\
                                </div>\n\
                                <script type="text/javascript">\n\
                                $(".tag span").click(function(){\n\
                                    $(this).hasClass("cur")?$(this).removeClass("cur"):$(this).addClass("cur");\n\
                                })\
                                </script>\n';
                        $(".dialog-content a.dia-ok").addClass('goprocess');
                        popup(html);
                    } else {
                        Msg(2, result.msg);
                    }
                    _this.onLoad(true);
                });
            });
            $('#listtbody').on('click', ".cases li", function(e) {
                e.preventDefault();
                e.stopPropagation();
                var $this = $(this),
                    type = $this.attr("data"),
                    self = $this.parent().parent();
                var cus = self.parent().siblings('input:hidden:last').attr('value');
                _this.onLoad();
                _this.repStop();
                _this.response = $.post("Apps?module=Model&action=StatusChange", {num : cus, type : _this.listID, tuijian: type}, function(result) {
                    if (result.err == 0) {
                        if(type == 0){
                            self.removeClass("place");
                        }else{
                            self.addClass("place");
                        }
                        self.children("span").text(tjInit[type]);
                        self.click();
                        self.attr("data", type);
                        $this.hide();
                        $this.siblings().show();
                    } else {
                        Msg(2, result.msg);
                    }
                    _this.onLoad(true);
                });
            });

            //弹窗确定
            $(".dialog-content a.dia-ok").click(function() {
                if ($(this).hasClass("goprocess") && _this.modelID) {
                    var input = $(".userdata-content input[type!='hidden'][type='text']"),
                            data = '{';
                    $.each(input, function(i, v) {
                        data += '"' + v.name + '":"' + v.value + '",';
                    });
                    var tag = '', color = '', typetag = $("#typetag .tag span.cur"), typecolor = $("#colortag .tag span.cur");
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
                    data += '"num":' + _this.modelID + ',';
                    data += '"type":' + _this.listID + ',';
                    data += '"typetage":"' + tag + '",';
                    data += '"colortag":"' + color + '"}';
                    data = $.parseJSON(data);
                    $.post("Apps?module=Model&action=Process", data, function(result) {
                        if (result.err == 0) {
                            _this.page.eq(_this.checkPage -1).removeClass('pon').click();
                            Msg(3, "信息已成功修改");
                        } else {
                            Msg(2, result.msg);
                        }
                    });
                    _this.modelID = false;
                    $(".dialog-content a.dia-ok").removeClass('goprocess');
                }
                $('#dialog-box').toggle("slow", function() {
                    $("#dialog-overlay").slideUp("fast");
                });
                $('#dialog-message').html('');
                return false;
            });
        };
        /*客户管理列表搜索模块*/
        this.searchBox = function() {
            var _this = this;
            $("#searchbox").click(function() {
                var search = '',
                    search_before = '';
                search_before += _this.search.name ? "&name=" + _this.search.name : '';
                search_before += _this.search.url ? "&url=" + _this.search.url : '';
                search_before += _this.search.priceL ? "&priceL=" + _this.search.priceL : '';
                search_before += _this.search.priceT ? "&priceT=" + _this.search.priceT : '';
                _this.search.name = $("#search1").val();
                _this.search.url = $("#search2").val();
                _this.search.priceL = $("#search3").val();
                _this.search.priceT = $("#search4").val();
                _this.search.name ? $(".labelBox a[data='name']").html(_this.search.name + '<span>x</span>').show() : $(".labelBox a[data='name']").hide();
                _this.search.url ? $(".labelBox a[data='url']").html(_this.search.url + '<span>x</span>').show() : $(".labelBox a[data='url']").hide();
                _this.search.priceL ? $(".labelBox a[data='priceL']").html('大于' + _this.search.priceL + '<span>x</span>').show() : $(".labelBox a[data='priceL']").hide();
                _this.search.priceT ? $(".labelBox a[data='priceT']").html('小于' + _this.search.priceT + '<span>x</span>').show() : $(".labelBox a[data='priceT']").hide();
                _this.search.name || _this.search.url || _this.search.priceL || _this.search.priceT ? $(".labelBox").slideDown() : $(".labelBox").slideUp();
                search += _this.search.name ? "&name=" + _this.search.name : '';
                search += _this.search.url ? "&url=" + _this.search.url : '';
                search += _this.search.priceL ? "&priceL=" + _this.search.priceL : '';
                search += _this.search.priceT ? "&priceT=" + _this.search.priceT : '';
                if (search != search_before) {
                    _this.onLoad();
                    _this.repStop();
                    _this.response = $.get("Apps?module=Model&action=GetModelNum&type=" + _this.listID + search, function(result) {
                        result.data = parseInt(result.data);
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
                            $("#listtbody").html("");
                            _this.onLoad(true);
                        }
                    });
                } else {
                    Msg(0, "搜索内容重复或为空");
                }
            });
            //标签删除事件
            $(".labelBox").on('click', 'span', function() {
                var search = '',
                    search_type = $(this).parent().hide().attr("data");
                _this.search[search_type] = '';
                search += _this.search.name ? "&name=" + _this.search.name : '';
                search += _this.search.url ? "&url=" + _this.search.url : '';
                search += _this.search.priceL ? "&priceL=" + _this.search.priceL : '';
                search += _this.search.priceT ? "&priceT=" + _this.search.priceT : '';
                _this.search.name || _this.search.url || _this.search.priceL || _this.search.priceT ? '' : $(".labelBox").slideUp();
                _this.onLoad();
                _this.repStop();
                _this.response = $.get("Apps?module=Model&action=GetModelNum&type=" + _this.listID + search, function(result) {
                    result.data = parseInt(result.data);
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
                        $("#listtbody").html("");
                        _this.onLoad(true);
                    }
                });
            });
            //搜索回车事件
            $("Input[id^='search']").on("keypress", function(e) {
                if (event.keyCode == "13")
                {
                    $("#searchbox").click();
                }
            });
        };
        /*兼容客户管理列表,对列表数量控制的标签进行初始化*/
        this.msgSet = function() {
            var _this = this;
            $.get("Apps?module=Model&action=ModelInit", function(result) {
                dataInit = result.data;
            });
            _this.modelBox();
            _this.tableLiCheck();
            _this.searchBox();
            $(".tabList ul li").eq(0).click();
        };
        this.init = function() {
            this.msgSet();
            this.tonumCheck();
            this.numCheck();
        };
        this.init();
    }();

    //弹窗
    $('#listtbody').on('click', ".cases", function() {
        var cases = $(this),
                data = cases.attr("data") ? cases.attr("data") : 0;
        if (cases.children("ul").is(":hidden")) {
            cases.children("ul").show("slow");
            data == 0 ? cases.children("ul").children("li").show().eq(0).hide() : cases.children("ul").children("li").show().eq(data).hide();
        } else {
            cases.children("ul").hide("slow");
        }
    });
});