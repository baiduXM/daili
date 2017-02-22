jQuery(document).ready(function() {
    //当前js版本
    var Version = '3.7';
    function getmoney() {
        $.get("Apps?module=Agent&action=getbalance",function(data){
            data=$.parseJSON(data);
            $(".balance .money").text(data["Balance"]);
        });
    }
    if ($(".balance .money").length > 0) {
        getmoney();
//        setInterval(getmoney, 10000);
    }
    $.get("config.json?" + Math.random(), function(result) {
//        result=$.parseJSON(result);
        if (result.Version != Version) {
            alert("当前版本较低，为了避免错误，请清空浏览器缓存，刷新页面");
        }
    });
    
    //提示框初始化
    $('.messagebox .message').click(function(){
        $(this).animate({top: -$(this).outerHeight()}, 500);
    });
    //end

    $('.mag').click(function() {
        $('.mag-down').toggle();
    });
    
    //退出
    $('.login').click(function() {
        $('.topTip').toggle();
    });
    $('.topTip').click(function(){
        window.location.href = "http://" + document.location.hostname + "/?module=Home&action=Quit";
    });
    
    function initwidth(){
        var topright_w = $('.mainTop').width() - $('.mainTop .logo').width();
        $('.topright').css('width', topright_w);
        $('.cont-right').css('width', $(window).width() - $('.left-menu').width());
    }
    initwidth();

    $(window).resize(function () {
        initwidth();
        if (!$('#dialog-box').is(':hidden')){
            var maskHeight = $(document).height();  
            var maskWidth = $(window).width();
            var dialogTop =  (maskHeight - $('#dialog-box').height())/2;
            var dialogLeft = (maskWidth - $('#dialog-box').width())/2;
            $('#dialog-overlay').css({height:maskHeight, width:maskWidth});
            $('#dialog-box').css({top:dialogTop, left:dialogLeft});
        }
    });
    
    /*左侧模块*/
    var movemenu = function (){
        this.SecondIsShow = false;
        this.ministatus = false;
        this.topright_w = $('.topright').width();
        this.contright_l = $('.cont-right').css('left');
        this.secondmenu_l = $('.second-menu').css('left');
        this.leftMenuClick = function(){
            var _this = this;
            $('.second-menu p,.nav').click(function(event) {
                var action = $(this).attr("action");
                $('.second-menu>div').hide();
                $('.second-menu>div.' + action).show();
                if(!_this.SecondIsShow){
                    if(!_this.ministatus){
                        _this.newwidth = parseInt($('.second-menu').width()) + parseInt($('.cont-right').css('left')) - 2;
                        _this.contright_l = _this.newwidth;
                        var changwidth = parseInt($('.cont-right').width()) - parseInt(_this.secondmenu_l);
                        $('.cont-right').css({'left': _this.newwidth, 'width': changwidth});
                    }else{
                        _this.contright_l = $('.second-menu').width();
                        var newleft = parseInt(_this.contright_l) + parseInt($('.left-menu li i').width());
                        $('.cont-right').css({'left': newleft});
                    }
                    _this.SecondIsShow = true;
                }else{
                    if(!_this.ministatus){
                        _this.newwidth = parseInt($('.second-menu').width());
                        _this.contright_l = _this.newwidth;
                        var changwidth = parseInt($('.cont-right').width()) + parseInt(_this.secondmenu_l);
                        $('.cont-right').css({'left': _this.newwidth, 'width': changwidth});
                    }else{
                        var newleft = parseInt($('.left-menu li i').width());
                        $('.cont-right').css({'left': newleft});
                    }
                    _this.SecondIsShow = false;
                }
            });
        };

        this.miniMenuClick = function(){
            var _this = this;
            $('.mini-menu').click(function(event) {
                _this.ministatus = !_this.ministatus;
                if(_this.ministatus){
                    var minus = $('.left-menu.main').width() - $('.left-menu li i').width()
                        , newleftcont = parseInt($('.cont-right').css('left')) - minus
                        , changwidth = parseInt($('.cont-right').width()) + minus;
                    $('.topright').animate({width: "100%"});
                    $('.cont-right').css({'left': newleftcont, 'width': changwidth});

                    var newleftsecond = parseInt($('.second-menu').css('left')) - minus;
                    this.secondmenu_l = newleftsecond;
                    $('.second-menu').css({'left': this.secondmenu_l});
                    $(this).find("i").removeClass("fa-back");
                    $(this).find("i").addClass("fa-more");
                } else {
                    var changwidth = parseInt($('.cont-right').width()) - ($('.left-menu.main').width() - $('.left-menu li i').width());
                    if (_this.SecondIsShow) {
                        _this.contright_l = $('.cont-left').width();
                    } else {
                        _this.contright_l = $('.left-menu.main').width();
                    }
                    $('.topright').animate({width: _this.topright_w});
                    $('.cont-right').css({'left': _this.contright_l, 'width': changwidth});
                    $('.second-menu').css({'left': _this.secondmenu_l});
                    $(this).find("i").removeClass("fa-more");
                    $(this).find("i").addClass("fa-back");
                }
            });
        };
        this.init = function(){
            this.leftMenuClick();
            this.miniMenuClick();
        };
        this.init();
    }()

    //弹窗关闭
    $('#dialog-box a.dia-no, #dialog-overlay').click(function () {
        $('#dialog-box').slideUp("slow",function(){
            $("#dialog-overlay").slideUp("fast");
        });
        $('#dialog-message').html('');
        $(".dialog-content a:first").removeClass();
        $(".dialog-content a:first").addClass('button dia-ok');
        return false;
    });
});

//提示框
var myMessages = ['info','warning','error','success'];
function hideAllMessages()
{
    $('.messagebox .message').click();
}
function Msg(num,msg){
    hideAllMessages();
    $('.messagebox .'+myMessages[num]+' p').html(msg);
    $('.'+myMessages[num]).animate({top:"0"}, 500);
}

//弹窗
function popup(message) {
    $('#dialog-message').html(message);
    var maskHeight = $(document).height();
    var maskWidth = $(window).width();
    var dialogTop =  (maskHeight - $('#dialog-box').height())/2;
    var dialogLeft = (maskWidth - $('#dialog-box').width())/2;
    $('#dialog-overlay').css({height:maskHeight, width:maskWidth}).toggle("fast",function(){
        $('#dialog-box').css({top:dialogTop, left:dialogLeft}).slideDown("slow");
    });
}

//时间格式化
Date.prototype.Format = function (fmt) { 
    var o = {
        "M+": this.getMonth() + 1, //月份 
        "d+": this.getDate(), //日 
        "h+": this.getHours(), //小时 
        "m+": this.getMinutes(), //分 
        "s+": this.getSeconds(), //秒 
        "q+": Math.floor((this.getMonth() + 3) / 3), //季度 
        "S": this.getMilliseconds() //毫秒 
    };
    if (/(y+)/.test(fmt)) fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
    for (var k in o)
    if (new RegExp("(" + k + ")").test(fmt)) fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
    return fmt;
}
