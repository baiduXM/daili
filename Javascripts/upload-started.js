// 文件上传
jQuery(function() {
    //当前配置收集和赋值
    var dataInit = function(json) {
        if (json) {
            json = $.parseJSON(json);
            var key, arr, i, select;
            for (key in json) {
                if ($("#config-list input[name='" + key + "']").length) {
                    json[key] != 0 ? $("#config-list input[name='" + key + "']").val(json[key]) : $("#config-list input[name='" + key + "']").val("");
                } else if ($("#config-list select[name='" + key + "']").length) {
                    select = $("#config-list select[name='" + key + "']");
                    select.find("option:selected").attr("selected", false);
                    select.find("option[value='" + json[key] + "']").attr("selected", true);
                    select.get(0).selectedIndex = select.find("option[value='" + json[key] + "']").index();
                } else if (key == 'typetag') {
                    if (json[key] != 0) {
                        arr = json[key].split(",");
                        $("#typetag .tag span.cur").removeClass("cur");
                        for (i in arr) {
                            $("#typetag .tag span[data='" + arr[i] + "']").addClass("cur");
                        }
                    } else {
                        $("#typetag .tag span.cur").removeClass("cur");
                    }
                } else if (key == 'colortag') {
                    if (json[key] != 0) {
                        arr = json[key].split(",");
                        $("#colortag .tag span.cur").removeClass("cur");
                        for (i in arr) {
                            $("#colortag .tag span[data='" + arr[i] + "']").addClass("cur");
                        }
                    } else {
                        $("#colortag .tag span.cur").removeClass("cur");
                    }
                }
            }
            return true;
        } else {
            var input, i, count, val, data = '{';
            var typetag = $("#typetag .tag span.cur"),
                    typecolor = $("#colortag .tag span.cur");
            select = $("#config-list select");
            input = $("#config-list input");
            for (i = 0, count = select.length; i < count; i++) {
                data += '"' + $(select[i]).attr("name") + '":"' + $(select[i]).val() + '",';
            }
            for (i = 0, count = input.length; i < count; i++) {
                val = $(input[i]).val() ? $(input[i]).val() : 0;
                data += '"' + $(input[i]).attr("name") + '":"' + val + '",';
            }
            data += typetag.length == 0 ? '"typetag":0,' : '"typetag":"';
            for (i = 0, count = typetag.length; i < count; i++) {
                data += $(typetag[i]).attr("data") + ',';
                data += (count - 1 == i) ? '",' : '';
            }
            data += typecolor.length == 0 ? '"colortag":0' : '"colortag":"';
            for (i = 0, count = typecolor.length; i < count; i++) {
                data += $(typecolor[i]).attr("data") + ',';
                data += (count - 1 == i) ? '"' : '';
            }
            data += '}';
            return data;
        }
    };
    
    var $list = $('#thelist'),
            $btn = $('#ctlBtn'),
            state = 'pending',
            rarData = new Object(),
            colortag = '<span style="vertical-align: top;">颜色标签(必填)</span><span class="tag">',
            finish = new Object(),
            uploader,
            configData = dataInit(),
            colorInit = ['white', 'grey', 'black', 'blue', 'green', 'yellow', 'orange', 'pink', 'red', 'purple', 'brown', 'colorful'],
            colorData = {white: ['white', '白色'], grey: ['grey', '灰色'], black: ['black', '黑色'], blue: ['blue', '蓝色'], green: ['green', '绿色'], yellow: ['yellow', '黄色'], orange: ['orange', '橙色'], pink: ['pink', '粉色'], red: ['red', '红色'], purple: ['purple', '紫色'], brown: ['#804000', '棕色'], colorful: ['', '彩色']};
    $.each(colorInit, function(i1, v1) {
        colortag += '<span data="' + v1 + '"' + (v1 == 'colorful' ? '' : ' style="background-color:' + colorData[v1][0] + ';"') + '>' + colorData[v1][1] + '</span>';
    });
    colortag += '</span>';
    $(colortag).appendTo($("#colortag"));
    if (window.applicationCache) {
        $("#dropbox").show();
    }
    uploader = WebUploader.create({
        swf: 'Javascripts/Uploader.swf',
        // 不压缩image
        resize: false,
        // 文件接收服务端。
        server: 'Apps?module=Model&action=FileUpload&r=597126158',
        //文件拖拽
        dnd: '#dropbox',
        // 选择文件的按钮。可选。
        // 内部根据当前运行是创建，可能是input元素，也可能是flash.
        pick: '#picker',
        //上传数量
        threads: 1,
        //单个文件大小限制
        fileSingleSizeLimit: 8388608,
        //文件个数限制
        fileNumLimit: 4,
        //只允许选择文件，可选。
        accept: {
            title: 'model',
            extensions: 'zip,csv',
            mimeTypes: 'model/*'
        }
    });

    // 当有文件添加进来的时候
    uploader.on('fileQueued', function(file) {
        if (file.ext == 'zip') {
            if (file.name.split("_").length == 2 && file.name.split("_")[1].split(".").length == 2 && $.inArray(file.name.split("_")[1].split(".")[0], colorInit) != -1)
                ;
            else
                rarData[file.id] = configData;
        }
        var cur = '';
        if (!$("#thelist .cur").length) {
            cur = ' cur';
            if (rarData[file.id]) {
                $("#config-list .zip").show("slow").siblings("div").hide("slow");
                dataInit(rarData[file.id]);
            } else if (file.ext == 'csv') {
                $("#config-list .csv").show("slow").siblings("div").hide("slow");
            }
        }
        var addline = rarData[file.id] ? '<p>模板名 <input type="text" name="model" placeholder="不填，自动新建模板号" class="Input" style="height: 32px;line-height: 32px;width: 60%;background:rgba(0, 0, 0, 0);"><span class="loadmodel transition1">载入</span></p>\n\
                                    <p>语言选择：<span class="lang"><tt class="transition1">CN</tt><span class="transition1"></span></span></p>'
                :
                '';
        $list.append('<div id="' + file.id + '" class="item' + cur + '">' +
                '<h4 class="info"><span><img style="width: 30px;padding-top: 10px;padding-right: 7px;" src="./Images/' + file.ext + '.png"></span>' + file.name + '</h4>' +
                addline +
                '<p class="state">等待上传...</p><span class="spin close">X</span><span class="moveicon"></span>' +
                '</div>');
    });
    //文件单击选中事件
    $("#thelist").on("click", "div[id^='WU_FILE_']", function() {
        if (!$(this).hasClass("cur")) {
            var cur = $("#thelist .item.cur"),
                    id = $(this).attr("id"),
                    file = uploader.getFile(id);
            if (rarData[cur.attr("id")]) {
                rarData[cur.attr("id")] = dataInit();
            }
            if (rarData[id]) {
                $("#config-list .zip").show("slow").siblings("div").hide("slow");
                dataInit(rarData[id]);
            } else if (finish[id]) {
                $("#config-list .err").find(".point").text(finish[id]);
                $("#config-list .err").show("slow").siblings("div").hide("slow");
            } else if (file.ext == 'csv') {
                $("#config-list .csv").show("slow").siblings("div").hide("slow");
            } else {
                $("#config-list .other").show("slow").siblings("div").hide("slow");
            }
            cur.removeClass("cur");
            $(this).addClass("cur");
        }
    });
    //删除文件
    $("#thelist").on("click", ".close", function(e) {
        e.preventDefault();
        e.stopPropagation();
        if (uploader.isInProgress()) {
            Msg(1, '正在上传，不执行删除操作');
        } else {
            var parent = $(this).parent();
            if (parent.hasClass("cur")) {
                var bro = parent.siblings();
                if (bro.length) {
                    bro.get(0).click();
                } else {
                    $("#config-list .other").show("slow").siblings("div").hide("slow");
                }
            }
            uploader.removeFile(parent.attr("id"), true);
        }
    });
    //语言切换
    $("#thelist").on("click", ".lang", function(e) {
        e.preventDefault();
        e.stopPropagation();
        if (uploader.isInProgress()) {
            Msg(1, '正在上传，切换不了了');
        } else {
            var _this = $(this);
            if (_this.hasClass("cur")) {
                _this.find("tt").text("CN");
                _this.removeClass("cur");
            } else {
                _this.find("tt").text("EN");
                _this.addClass("cur");
            }
        }
    });
    //模板信息载入输入框回车事件
    $("#thelist").on("keypress", "Input[name='model']", function(e){
        if(event.keyCode == "13")    
        {
            $(this).next().click();
        }
    });
    //模板信息载入请求
    $("#thelist").on("click", ".loadmodel", function(e) {
        e.preventDefault();
        e.stopPropagation();
        if (uploader.isInProgress()) {
            Msg(1, '正在上传，载入不了');
        } else {
            var _this = $(this);
            if (!_this.hasClass("already")) {
                var con = _this.prev().val();
                if (con) {
                    $.get('model?module=Model&action=GetModel&name=' + con, function(result) {
                        if (!result.err) {
                            _this.addClass("already");
                            var json = result.data,
                                    data, lang, file;
                            data = '{"tuijian":"' + json.tuijian + '","mPrice":"' + json.price + '","yPrice":"' + json.youhui + '","url":"' + json.url + '","star":"' + json.star + '","typetag":"' + json.target + '","colortag":"' + json.color + '"}';
                            lang = _this.parent().next().find(".lang");
                            file = _this.parent().parent();
                            rarData[file.attr("id")] = data;
                            if (lang.find("tt").text() != json.lang) {
                                lang.click();
                            }
                            if (file.hasClass("cur")) {
                                dataInit(rarData[file.attr("id")]);
                            }
                        } else {
                            Msg(2, result.msg);
                        }
                    })
                } else {
                    Msg(1, '请输入模板编号');
                }
            }
        }
    });
    // 文件移除时触发
    uploader.on('fileDequeued', function(file) {
        delete rarData[file.id];
        var $li = $('#' + file.id);
        $li.remove();
    });
    // 文件上传时附加选好的属性
    uploader.on('uploadStart', function(file) {
        var $li = $('#' + file.id);
        if (file.ext == 'zip') {
            file.msg = $li.find("input").val();
            file.lang = $li.find(".lang").hasClass("cur") ? 'EN' : 'CN';
            file.data = $li.hasClass("cur") ? dataInit() : rarData[file.id];
        }
    });
    // 文件加入列队之前触发
    uploader.on('beforeFileQueued', function(file) {
        var err;
        if (file.ext != 'zip' && file.ext != 'csv') {
            err = file.name + '：上传文件只能是zip或csv文件；'
        }
        if (file.size > 8388608) {
            err = file.name + '：上传文件大小不能够大于8M；'
        }
        if (err) {
            Msg(1, err);
        }
    });
    // 文件上传过程中创建进度条实时显示。
    uploader.on('uploadProgress', function(file, percentage) {
        var $li = $('#' + file.id),
                $percent = $li.find('.progress .progress-bar');

        // 避免重复创建
        if (!$percent.length) {
            $percent = $('<div class="progress progress-striped active">' +
                    '<div class="progress-bar" role="progressbar" style="width: 0%">' +
                    '</div>' +
                    '</div>').appendTo($li).find('.progress-bar');
        }

        $li.find('p.state').text('上传中');

        $percent.css('width', percentage * 90 + '%');
    });
    // 文件上传完成后进度条隐藏
    uploader.on('uploadComplete', function(file) {
        $('#' + file.id).find('.progress').fadeOut();
    });
    // 文件上传成功后信息处理。
    uploader.on('uploadSuccess', function(file, ret, hds) {
        delete rarData[file.id];
        if ((typeof ret.data) != 'string') {
            console.log(ret.data);
            ret.data = '打开控制台查看详细信息';
        }
        finish[file.id] = ret.err ? '错误代码：' + ret.err + '错误内容：' + ret.data : '成功上传';
        if ($('#' + file.id).hasClass("cur")) {
            $("#config-list .err").find(".point").text(finish[file.id]);
            $("#config-list .err").show("slow").siblings("div").hide("slow");
        }
        $('#' + file.id).find('p.state').text(ret.msg);
    });
    // 文件上传失败后信息处理。
    uploader.on('uploadError', function(file) {
        delete rarData[file.id];
        finish[file.id] = '上传出错';
        if ($('#' + file.id).hasClass("cur")) {
            $("#config-list .err").find(".point").text(finish[file.id]);
            $("#config-list .err").show("slow").siblings("div").hide("slow");
        }
        $('#' + file.id).find('p.state').text('上传出错');
    });

    // 任何操作都会触发此事件。
    uploader.on('all', function(type) {
        if (type === 'startUpload') {
            state = 'uploading';
        } else if (type === 'stopUpload') {
            state = 'paused';
        } else if (type === 'uploadFinished') {
            state = 'done';
        }

        if (state === 'uploading') {
            $btn.text('暂停上传');
        } else {
            $btn.text('开始上传');
        }
    });

    $btn.on('click', function() {
        if (state === 'uploading') {
            uploader.stop();
        } else {
            uploader.upload();
        }
    });
    windowchange();
    // 行业标签点击事件
    $(".tag span").click(function() {
        $(this).hasClass("cur") ? $(this).removeClass("cur") : $(this).addClass("cur");
    });
});
function windowchange() {
    $(".crelist").height($(window).height() - 84);
    $(".crelist").css("background", "none");
}