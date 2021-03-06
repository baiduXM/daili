$(function(){
    $(".crelist").css("height", "80%");
    /*日期插件*/
    $('#beginDD').calendar({
        trigger: '#txtBeginDate',
        zIndex: 999,
        format: 'yyyy-mm-dd'
    });
    $('#endDD').calendar({
        trigger: '#txtEndDate',
        zIndex: 999,
        format: 'yyyy-mm-dd'
    });
    //异步获取数据
    var report = function(){
        //开始时间
        this.startTime = '';
        //结束时间
        this.endTime = '';
        //数据类型
        this.proType = '';
        /*加载前的时间*/
        this.timeLoad = 0;
        /*加载最短持续时间*/
        this.timeWait = 1000;
        /*计时器*/
        this.timeSave;       
        //生成等待动画
        this.waitAni = $(".flower-loader");
        // 基于准备好的dom，初始化echarts图表
        this.chart = echarts.init(document.getElementById('main'));
        //echaets配置初始化
        this.option = {
                title: {
                    text: '行业选择热度统计'
                },
                legend: {
                    data: ['G宝盆']
                },
                tooltip: {
                    trigger: 'axis'
                },
                toolbox:{/*工具 区域缩放，数据视图，折线柱状图，刷新，保存为图片*/
                    show: true,
                    feature: {
                        dataZoom: {
                            yAxisIndex: 'none'
                        },
                        dataView: {readOnly: true},
                        magicType: {type: ['line', 'bar']},
                        restore: {},
                        saveAsImage: {}
                    },
                    right: '10%'
                },
                xAxis: [
                    {
                        axisLabel: {
                            rotate: 20,     /*旋转20度*/
                            interval : 0    /*显示全部，1为隔一个显示，以此类推，不设置按默认处理*/
                        },
                        type: 'category',   /*坐标轴类型*/
                        boundaryGap: false, /*坐标轴两边留白*/
                        data: []    /*x轴的数据*/
                    }
                ],
                yAxis: [
                    {
                        type: 'value'   /*坐标轴类型*/
                    }
                ],
                series: [
                    {   /*类目标题，类型，数据*/
                        "name": "G宝盆",    
                        "type": "bar",
                        "data": []
                    }
                ]
            };
        /*加载图标的显示*/
        this.load = function(open) {
            open = open || false;
            var _this = this;
            clearTimeout(_this.timeSave);
            if(open){
                var time = Date.parse(new Date()) - _this.timeLoad,
                    timeWait = function(){
                        $(".flower-loader").animate({opacity: 0});
                    };
                if(time > _this.timeWait){
                    $(".flower-loader").animate({opacity: 0});
                }else{
                    _this.timeSave = setTimeout(timeWait, _this.timeWait);
                }
                _this.timeLoad = 0;
            }else{
                _this.timeLoad = Date.parse(new Date());
                $(".flower-loader").animate({opacity: 1});
            }
        };
        this.getData = function(){
            var _this = this;
            $.get('Apps?module=Report&action=ProCount&start=' + _this.startTime + '&end=' + _this.endTime, function(json){
                _this.load(true);
                if(json.err == 0){
                    var data = json.data;
                    _this.chart.setOption({     /*数据表格重载*/
                        xAxis: {
                            data: data.categories
                        },
                        series: [{
                            // 根据名字对应到相应的系列
                            name: 'G宝盆',
                            data: data.data
                        }]
                    });
                }else
                    Msg(2, json.msg);
            });
        };
        this.product = function(){
            var _this = this;
            $("#product").click(function(){
                var startTime = $("#txtBeginDate").val(),
                    endTime = $("#txtEndDate").val();
                if(_this.startTime != startTime || _this.endTime != endTime){
                    var interval,data;
                    _this.startTime = startTime;
                    _this.endTime = endTime;
                    startTime = startTime.toDate();
                    endTime = endTime.toDate();
                    _this.load();
                    interval = endTime - startTime;
                    /*初步数据审核*/
                    if(interval)
                        _this.getData();
                }else{
                    _this.load(true);
                    Msg(0, '不要重复生成同种表单');
                }
            });
        };
        /*页面改变时，表格紧随改变*/
        this.resize = function(){
            this.chart.resize();
        };
        /*开始执行*/
        this.init = function(){
            $(window).resize(function() {
                this.resize();
            })
            this.chart.setOption(this.option);
            this.product();
        };
        this.init();
    }();
    
    
})