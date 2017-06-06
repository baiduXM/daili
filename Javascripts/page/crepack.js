$(function() {
    //语言切换
    $(".lang").on("click", function(e) {
        var _this = $(this);
        if (_this.hasClass("cur")) {
            _this.find("tt").text("CN");
            _this.removeClass("cur");
        } else {
            _this.find("tt").text("EN");
            _this.addClass("cur");
        }
    });
    
    //数据提交
    $('.Btn1').click(function() {
        var input = $('.Input'),
                data = {},
                err = 0;
        for (var i = 0, j = input.length; i < j; i++) {
            data[input[i].name] = input[i].value;
        }
        data['tuijian'] = $("select[name='tuijian']").val();
        data['lang'] = $(".lang").hasClass("cur") ? 'EN' : 'CN';
        $.post("Apps?module=Model&action=PkCreate", {modelInfo: data}, function(result) {
            if (result.err == 0) {
                Msg(3, result.msg);
            } else {
                Msg(2, result.msg);
            }
        });
    });
})