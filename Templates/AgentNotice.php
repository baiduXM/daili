<?php include 'AgentHead.php'; ?>
<body>
    <div id="dialog-overlay"></div>
    <div id="dialog-box">
        <div class="dialog-content">
            <div id="dialog-message"></div>
            <a href="#" class="button dia-ok">确定</a>
            <a href="#" class="button dia-no">关闭</a>
        </div>
    </div>
    <div class="wrap">
        <?php include 'AgentTop.php'; ?>
        <?php include 'Agentleft.php'; ?>
        <div class="cont-right">
            <div class="mainBox">
                <div id="tab" class="nytab">
                    <div class="tabList">
                        <ul>
                            <li class="">发布公告</li>
                        </ul>
                    </div>
                    <div class="tabCon">
                        <div class="cur">
                            <div class="shbox" style='margin-left: 100px;padding-bottom: 10px;'>
                                <div>
                                    <span>
                                        <input type="hidden" name='id' value=''>
                                        <input type="hidden" name='uid' value=''>
                                    </span>
                                </div>
                                <div style='padding-top: 15px;padding-bottom: 15px;'>
                                    <span style='font-size: 12pt;'>标题</span>
                                    <span>
                                        <input type="input" name="title" style='height: 20px;width: 400px;' value="">
                                    </span>
                                </div>
                                <div style='padding-top: 15px;padding-bottom: 15px;'>
                                    <span style='font-size: 12pt;'>是否展示</span>
                                    <span class="Input">
                                        <input type="radio" name="is_on" value="1" checked>是
                                        <input type="radio" name="is_on" value="0">否
                                    </span>
                                </div>                                
                                <!-- 编辑器 -->
                                <script id="editor" type="text/plain" style="width:1024px;height:500px;"></script>
                                <div style='position: absolute;right:550px;bottom: 156px;font-size: 12pt;color: red;'>*暂不支持上传图片到统一平台</div>
                            </div>
                        </div>
                    </div>
                    <div class="btnDD">
                        <input type="submit" class="Btn1" value="提交">
                    </div>
                </div>
            </div>
        </div>
    </div>
<script type="text/javascript">
    //实例化编辑器
    var ue = UE.getEditor('editor');
</script>
</body>
<?php include 'AgentFoot.php'; ?>